<?php
namespace kakoi;
use kakoi;
class handle{
	
	private static $instance = null;
	static function getInstance(){
		if(self::$instance){
				return self::$instance;
		}else{
			self::$instance = new handle();
			return self::$instance;
		}
		
	}
	public function C($moudle,$name,$method,$id){
		require_once(EVENT."/".$moudle.'/Controller/'.$name."Controller.class.php");
			$obj_temp = $name."Controller";
				$obj = new $obj_temp();
				$obj->$method($id);
	}
	// public function M($name){
		// ECHO $name;
		//require_once(EVENT."/".$moudle.'/Moudel/'.$name."Model.class.php");
	
	// }
	
	
}
?>