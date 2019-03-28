<?php
class IndexTest extends PHPUnit_Framework_TestCase{
    //Constructor
    function __construct(){
    	//Define the version of the TP
    	define('TPUNIT_VERSION','3.2.3');
        //Define the directory path, preferably the absolute path
    	define('TP_BASEPATH', 'E:/www/novel/');
		//Import base library
		include_once 'E:\www\novel\Application\test\base.php';
		//Import the controller to be tested
		include_once 'E:\www\novel\Application\Home\Controller\IndexController.php';
    }
	//Test index action
    public function testIndex(){
    	//New controller
        $index=new \Home\Controller\IndexController();
		//Method of calling the controller
		$index->test();
		//assertion
		$this->expectOutputString('123');
    }

}
