<?php

namespace app\controller;

use think\Controller;
use think\Request;
use think\Session;

class Index extends Controller {

	public function upload(Request $request){
        if(Session::has('identity')){
            $identity = $request->session('identity');
            deleteDir(ROOT_PATH . 'public' . DS . 'uploads' . DS . $identity);
            Session::clear();
        }
        $files = $request->file('files');
        if($files == null || !is_array($files) || count($files) <= 0)
            abort(400,'method param miss or empty: files');
        $identity = time();
        Session::set('identity',$identity);
        foreach ($files as $file){
            $info = $file->validate(['ext'=>'txt'])->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . $identity,'');
            if(!$info){
                abort(500,'upload failed: '.$file->getError());
            }
        }
        $result = array();
        //TODO exec('python D:\a.py '.escapeshellarg(ROOT_PATH . 'public' . DS . 'uploads' . DS . $identity . DS),$result);
        Session::set('data',json_decode(implode('', $result)));
    }

    public function unload(Request $request){
	    if(Session::has('identity')){
	        $identity = $request->session('identity');
            deleteDir(ROOT_PATH . 'public' . DS . 'uploads' . DS . $identity);
            Session::clear();
        }
    }

}
