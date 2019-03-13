<?php
namespace app\index\controller;

use think\controller;
use think\Db;
use app\index\model\File_tb;
use think\request;
use think\validate;
//use think\Debug;

class Edit extends Controller
{
	public function index(){
		$filename= $_GET['filename'];
		$res = Db::table('file_tb')->where('file_name',$filename)->find();

		return $this->fetch('edit',[
			'filename' => $filename,
			'content'=>$res['content'],
    		'lastupdate' => $res['update_time'],
            'creator' => $res['create_usr'],
            'file_id' => $res['file_id']
    	]);
	}

	public function update(Request $request){
		$post=$request->param();
		if ($post){
			Db::table('file_tb')->where('file_id',$post['file_id'])->update([
				'content'=>$post['content_update'],
				'update_usr'=>session('username')
			]);
			return $this->success('success');
		}else{
			return $this->error('failed');
		}
	}
    
}