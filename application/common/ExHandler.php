<?php
namespace app\common;
use think\exception\Handle; 
use	think\exception\HttpException;

class ExHandler extends Handle {
	
	public function render(\Exception $e){
		if($e instanceof HttpException){
			$statusCode = $e->getStatusCode();
		}
		if(!isset($statusCode)){
			$statusCode = 404;
		}
		return json($e->getMessage(), $statusCode);
	}
}
