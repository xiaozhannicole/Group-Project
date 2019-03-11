<?php
namespace app\index\controller;

use think\controller;
use think\Db;
use app\index\model\Usr_tb;
//use think\Debug;
//use Config;



class Index extends controller
{
 
    public function index()
    {
    	return $this->fetch('index',[
    		'username' => 'lala',
    		'filename' => 'file1',
    		'lastupdate' => '1day'
    	]);
    }

    	
    public function upload()
    {
        //判断文件上传是否出错
        dump($_FILES);
        if($_FILES["file"]["error"])
        {
            echo $_FILES["file"]["error"];
        }
        else
        {
            //控制上传的文件类型，大小
            if($_FILES["file"]["type"]=="text/plain"&&$_FILES["file"]["size"]<1024000)
            {
                //找到文件存放位置，注意tp5框架的相对路径前面不用/
                //这里的filename进行了拼接，前面是路径，后面从date开始是文件名
                //我在static文件下新建了一个file文件用来存放文件，要注意自己建一个文件才能存放传过来的文件
                $file_exists=Db::table('file_tb')->where('file_name',$_FILES["file"]["name"])->find();
            
                //判断文件是否存在
                if ($file_exists)
                {
                    echo "该文件已存在！";
                    //选择是否替换
                }
                else
                {
            
                    Db::table('file_tb')->insert([
                        'file_name'=>$_FILES["file"]["name"],
                        // 'content'=>$_FILES["file"]["content"],
                     'create_usr'=>$session.username
                    ]);
                }
            }
            else
            {
                echo "file type error!";
            }
        }
    }

    
}
