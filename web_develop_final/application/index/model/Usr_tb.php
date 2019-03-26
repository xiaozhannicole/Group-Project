<?php

namespace app\index\model;

use think\Model;

class Usr_tb extends Model
{
	public function setPasswordAttr($val){
		return md5($val);
	}
}


?>