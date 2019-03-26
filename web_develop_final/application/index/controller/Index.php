<?php
namespace app\index\controller;

use think\controller;
use think\Db;
use app\index\model\Usr_tb;
use app\index\model\File_tb;
use app\index\model\Authority_tb;
use think\file;
use think\request;

class Index extends controller
{
    public function index()
    {

        $file_co=Db::table('authority_tb')
        ->where('co_user',session('username'))
        ->field('file_ini_id')
        ->group('file_ini_id')
        ->select();
        //循环
        for ($i=0;$i<count($file_co);$i++){ 
        $version[$i]=Db::table('file_tb')
        ->where('file_ini_id',implode($file_co[$i]))
        ->max('pre_id');

        $file_own[$i]=Db::table('file_tb')
        ->where('file_ini_id',implode($file_co[$i]))
        ->where('pre_id',$version[$i])
        ->select();
    };

        $user = Db::table('usr_tb')
        ->where('usrname',session('username'))
        ->select();

        $err = Db::table('err_tb')
            ->select();

        return $this->fetch('index',[
            'file_own' => $file_own,
            'user'=>$user[0]['usrname'],
            'create_time'=> $user[0]['create_time'],
            'info'=>$user[0]['info'],
             'error'=>$err
        ]);


        //主页文件传输
    //     for ($i=0;$i<=3;$i++){ 
    //return $file_own;   
    }
   
    public function create(){
        $ini_id = rand();
        File_tb::create([
            'file_ini_id' =>$ini_id,
            'file_name' => 'unamed',
            'create_usr'=>session('username'), 
                    ]);
        Authority_tb::create([
            'file_ini_id' =>$ini_id,
            'co_user'=>session('username'), 
                    ]);
        $file = Db::table('file_tb')
            ->where('file_ini_id',$ini_id)
            ->select();
        return $this->redirect("./edit",['fileid'=>$file[0]['file_id']]);
    }
    
    public function upload()
    {
        //判断文件上传是否出错
        $file=$this->request->file("file");
        if($_FILES["file"]["error"])
        {
            echo $_FILES["file"]["error"];
        }
        else
        {
            //控制上传的文件类型，大小
            if($_FILES["file"]["type"]=="text/plain"||$_FILES["file"]["type"]=="application/octet-stream"&&$_FILES["file"]["size"]<1024000)
            {            
                $file_exists=Db::table('file_tb')->where('file_name',$_FILES["file"]["name"])->find();      
                if ($file_exists)
                {
                    echo "File exists!";
                    //选择是否替换
                }
                else
                {
                    $new_file = $file->move('./static/upload');
                    $content=file_get_contents($new_file->getpathName());
                    $ini_id=rand();
                    File_tb::create([
                        'file_name'=>$_FILES["file"]["name"],
                        'file_ini_id' =>$ini_id,
                        'content'=>$content,
                     'create_usr'=>session('username'),
                    ]);
                    
                    Authority_tb::create([
                        'file_ini_id' =>$ini_id,
                        'co_user'=>session('username'),
                    ]);     
                    return $this->success("upload success!");
                }
            }
            else
            {
                echo "file type error!";
            }
        }
    }
 
}
?>
    