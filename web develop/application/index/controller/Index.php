<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
//use think\template;
//use Config;

class Index extends Controller
{
    public function index()
    {
    
    	$res=Db::connect("mysql://root1:pxy19960829@127.0.0.13306/my webiste##utf8");
    	dump($res);


    }
}
