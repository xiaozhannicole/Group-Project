<?php
namespace app\index\controller;

use think\controller;
use think\Db;
use app\index\model\File_tb;
use app\index\model\Authority_tb;
use app\index\model\Err_tb;
use think\request;
use think\validate;
//use think\Debug;

class Edit extends Controller
{
	public function index(){
		$fileid = $_GET['fileid'];
		$res = Db::table('file_tb')
		->where('file_id',$fileid)->find();
		$old_version = Db::table('file_tb')
		->where('file_ini_id',$res['file_ini_id'])
		->select();

		$coodinator_array = Db::table('authority_tb')
		->where('file_ini_id',$res['file_ini_id'])
		->field('co_user')
		->select();	
		foreach ($coodinator_array as $val) {
   			$val = join(",",$val);
    		$temp_array[] = $val;
    	}
    	$co = implode(",", $temp_array);
		return $this->fetch('edit',[
			'file_ini_id'=>$res['file_ini_id'],
			'filename' => $res['file_name'],
			'content'=>$res['content'],
    		'lastupdate' => $res['update_time'],
            'creator' => $res['create_usr'],
            'file_id' => $res['file_id'],
            'pre_id' =>$res['pre_id'],
            'old_version' => $old_version,
            'coodinator' => $co
    	]);
	}

	public function update(Request $request){
		$post=$request->param();
		dump($post);
		if ($post){
			$pre_id_2 = Db::table('file_tb')
			->where('file_ini_id',$post['file_ini_id'])
        	->max('pre_id');


			$ini_id = Db::table('file_tb')
				->where('file_id',$post['file_id'])
				->field('file_ini_id')
				->find();

			$version=Db::table('file_tb')
        		->where('file_ini_id',implode($ini_id))
       			->max('pre_id');

       		 File_tb::create([
                        'file_name'=>$post['filename_update'],
                        'file_ini_id' =>$post['file_ini_id'],
                        'content'=>$post['content_update'],
                     	'create_usr'=>$post['creator'],
                     	'update_usr'=>session('username'),
                     	'pre_id'=> $version+1 
                    ]);

			if ($post['pre_id_1'] == strval($pre_id_2))
			{
				
				return $this->redirect('./index');
		}else{
			//版本错误，返回检测网站
			Err_tb::create([
                        'file_name'=>$post['filename_update'],
                        'file_ini_id' =>$post['file_ini_id'],
                        'content'=>$post['content_update'],
                     	'create_usr'=>$post['creator'],
                     	'update_usr'=>session('username'),
                     	'pre_id'=> $version+1 
                    ]);
			//$id=$post['file_ini_id'];
			return $this->redirect("./Compare",['fileid'=>$post['file_ini_id']]);
		}
	}
	else{
		
		return $this->error('failed');
	}

	}
	

	public function add_co(Request $name){
		$post=$name->param();
		$user = Db::table('usr_tb')
			->where('usrname',$post['coodinator'])
			->find();
		if ($user){
			$co_exists=Db::table('authority_tb')
			->where('file_ini_id',$post['file_ini_id'])
			->where('co_user',$post['coodinator'])
			->find();  
			if (!$co_exists){
				if ($post['coodinator'] != session('username')){
			Authority_tb::create([
				'file_ini_id'=> $post['file_ini_id'],
				'co_user'=> $post['coodinator']
			]);
			return $this->success('yeh');
		}
		else {
			return $this->error('creator');
		}
	}
		else{ 
			return $this->error('exists');
	}
		}else{
			return $this->error('wrong');
		}

	}

	 public function delete_co(Request $name){
     $post=$name->param();
     $user = Db::table('usr_tb')
         ->where('usrname',$post['coodinator'])
         ->find();
     if ($user){
         $co_exists=Db::table('authority_tb')
         ->where('file_ini_id',$post['file_ini_id'])
         ->where('co_user',$post['coodinator'])
         ->delete(); 
         return $this->success('yeh');
     } else{ 
         return $this->error('not exists');
    }

    }

    public function delete(Request $name){
     $post=$name->param();
     Db::table('file_tb')
         ->where('file_id',$post['file_id'])
         ->delete();
         return $this->redirect('./index','yeh'); 

    }

    
}