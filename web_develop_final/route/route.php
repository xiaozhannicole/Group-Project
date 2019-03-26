<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

//定义资源路由
//第一个参数定义路由规则
//第二个路由定义对应的控制器名称
route::resource('upload','Upload');
route::resource('edit','Edit');
Route::get('hello/:name', 'index/hello');

return [

];

//Route::rule('/','index/login','get');