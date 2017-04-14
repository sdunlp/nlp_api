<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
return [
		'__pattern__' => [
				'name' => '\w+'
		],
        'upload' => ['index/upload',['method'=>'post']],
        'unload' => ['index/unload',['method'=>'get']],
        'keywords' => ['index/keywords',['method'=>'get']]
];
