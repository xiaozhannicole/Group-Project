<?php
namespace app\index\controller;

use think\controller;
use think\Db;
use think\request;
use think\validate;

//use think\Debug;

class Register extends Controller
{
	public function index(){
		return view('register');
	}
	public function post(Request $request){
		$post=$request->param();
		$validate = validate::make([
			'username'=>'require',
			'password'=>'require|min:6|max:20|confirm',
		]);

		$status = $validate->check($post);

		if ($status){
			Db::table('usr_tb')
			->insert([
				'usrname'=>$post['username'],
				'passwd'=>md5($post['password'])
			]);
			return $this->success('success,please log in','./login');
		}else{
			return $this->error('failed');
		}
	}

    
}