<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 删除目录
 * @param $dir string 要删除的目录路径
 * @return bool 删除是否成功
 */
function deleteDir($dir) {
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullPath = $dir . DS . $file;
            if (!is_dir($fullPath)) {
                unlink($fullPath);
            } else {
                deleteDir($fullPath);
            }
        }
    }
    closedir($dh);
    if (rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}