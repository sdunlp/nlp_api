<?php

namespace app\controller;

use think\Controller;

class Index extends Controller {

	public function item() {
		$request = request();
		if($request->get('id') == null){
			abort(501, "method param miss: id");
		}
		$arr = array();
		exec('python D:\a.py '.escapeshellarg($request->get('id')),$arr);
		return json_decode(implode('', $arr));
	}
}
