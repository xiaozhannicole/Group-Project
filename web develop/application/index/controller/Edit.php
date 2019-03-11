<?php
namespace app\index\controller;

use think\controller;
use think\Db;
use app\index\model\Usr_tb;
//use think\Debug;

class edit extends controller
{

    public function index()
    {
    	return $this->fetch('edit',[
    		'creator' => 'lala',
    		'filename' => 'file1',
    		'lastupdate' => '1day'
    	]);

    	dump(Db::connect());
    }
}