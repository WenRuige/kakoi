<?php
namespace kakoi;
use kakoi;
class buildDir{
	
	static  $content = "<?php
	class IndexController{
		public function index(){
		 echo 'welcome to use kakoi';
		}
	}
	?>";
	
	static $config=
	"<?php
	return array(
	'DB_HOST'=>'localhost', 
	'DB_USER'=>'root',         //用户名
	'DB_PWD'=>'',              //密码
	'DB_NAME'=>'test',         //数据库名称
	'DB_PORT'=>'3306',         //端口号
	'DB_TYPE'=>'mysql',		   //数据库类型
	'DB_CHARSET'=>'utf-8',     //字符集
	);?>";
	private static $instance = null;
	static function getInstance(){
		if(self::$instance){
				return self::$instance;
		}else{
			self::$instance = new buildDir();
			return self::$instance;
		}
		
	}
	public function __construct(){
		
				
	}
	//创建文件夹
	public function buildFile($path = 'Home'){
		//echo  $path;
		$this->path = $path;
		if(!is_dir(EVENT)) mkdir(EVENT,0775,true);
		if(is_writable(EVENT)){		
				$dirs = array(
				EVENT."/".$path,
				EVENT."/Public",
				EVENT."/Config",
				EVENT."/".$path."/Controller",
				EVENT."/".$path."/Model",
				EVENT."/".$path."/View",
				EVENT."/".$path."/Cache",
				);	
		foreach($dirs as $dir){
			if(!is_dir($dir))
			mkdir($dir,0775,true);
					
				}
		}
		
	}
	public function buildController()
	{
		$controller =EVENT."/".$this->path."/"."Controller";
		if(is_dir(EVENT."/".$this->path))
			if(!is_file($controller."/IndexController.class.php")){
				 $temp=$controller."/IndexController.class.php";
					$myfile = fopen($temp,"w")or die("Unable to open file!");
					fwrite($myfile,buildDir::$content);
					
			}
				
		
		
	}
	public function buildConfig(){
			$data = EVENT."/Config";
			if(!is_file($data."/Config.php")){
					$temp=$data."/Config.php";
					$myfile = fopen($temp,"w")or die("Unable to open file!");
					fwrite($myfile,buildDir::$config);
			}
	}
		
}
