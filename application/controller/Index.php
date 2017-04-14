<?php

namespace app\controller;

use think\Controller;
use think\Request;

class Index extends Controller {

	public function upload(Request $request){
	    //预处理
        $this->unload();

	    //取得参数
        $files = $request->file('files');
        $lang = $request->post('lang');

        //参数验证
        if($files == null || !is_array($files) || count($files) <= 0)
            abort(400,'method param miss or empty: files');
        if($lang == null || ($lang != 'zh-CN' && $lang != 'en'))
            abort(400,'method param miss or format error: lang (zh-CN\en case sensitive)');

        //开始执行
        $identity = time();
        session('identity',$identity);
        foreach ($files as $file){
            $info = $file->validate(['ext'=>'txt'])->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . $identity,'');
            if(!$info){
                abort(415,'upload failed: '.$file->getError());
            }
        }
        $result = array();
        $return_var = 0;
        if($lang == 'en')
            exec('python '.ROOT_PATH.'application\common\nlp_system\en\demo.py '.escapeshellarg(ROOT_PATH . 'public' . DS . 'uploads' . DS . $identity . DS),$result,$return_var);
        else if($lang == 'zh-CN')
            exec('python '.ROOT_PATH.'application\common\nlp_system\zh-CN\nlpChinese.py '.escapeshellarg(ROOT_PATH . 'public' . DS . 'uploads' . DS . $identity . DS),$result,$return_var);
        if($return_var == 0){
            $json = json_decode(implode('', $result),true);
            $ret = array();
            foreach ($json as $key=>$value){
                if($value['code'] != 0){
                    $ret[] = array('name'=>$key, 'message'=>$value['message']);
                    unset($json[$key]);
                }else{
                    unset($json[$key]['message']);
                    unset($json[$key]['code']);
                }
            }
            session('data', $json);
            return $ret;
        }else{
            abort(500,'execution failed: python internal exception.');
        }
        return [];
    }

    public function unload(){
	    if(session('?identity')){
	        $identity = session('identity');
            deleteDir(ROOT_PATH . 'public' . DS . 'uploads' . DS . $identity);
            session(null);
        }
    }

    public function keywords(){
        if(session('?data')){
            $data = session('data');
            $result = array();
            foreach ($data as $file=>$value){
                foreach ($value['keywords'] as $keyword){
                    if(isset($result[$keyword['word']])){
                        $result[$keyword['word']]['frequency'] += $keyword['frequency'];
                        $result[$keyword['word']]['count'] ++;
                    }else{
                        $result[$keyword['word']] = ['frequency'=>$keyword['frequency'],'count'=>1];
                    }
                }
            }
            $ret = array();
            foreach ($result as $keyword=>$value){
                $ret[] = ['word'=>$keyword,'frequency'=>$value['frequency'] / $value['count']];
            }
            return $ret;
        }else{
            abort(404,"No file uploaded.");
        }
        return [];
    }
}
