<?php
namespace app\index\controller;

use think\controller;
use think\Db;
use think\request;
use think\validate;
use app\index\model\Usr_tb;
use app\index\model\File_tb;
use app\index\model\Authority_tb;

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

		$user_exist=Db::table('usr_tb')
		->where('usrname',$post['username'])
		->find();
		if(!$user_exist){
		$status = $validate->check($post);
		if ($status){
			Usr_tb::create([
				'usrname'=>$post['username'],
				'passwd'=>md5($post['password']),
				'info'=>$post['info']
			]);
			$ini_id=rand();
			File_tb::create([
				'file_ini_id'=>$ini_id,
				'file_name'=>'example file',
				'create_usr'=>$post['username'],
				'content'=>'Edit your content here.',
			]);
			Authority_tb::create([
				'file_ini_id'=>$ini_id,
				'co_user'=>$post['username'],
			]);
			return $this->success('success,please log in','./login');
		}else{
			return $this->error('failed');
		}
	}else{
			return $this->error('username exists');
		}

	}    
}