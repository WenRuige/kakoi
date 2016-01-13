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
	'DB_USER'=>'root',         //�û���
	'DB_PWD'=>'',              //����
	'DB_NAME'=>'test',         //���ݿ�����
	'DB_PORT'=>'3306',         //�˿ں�
	'DB_TYPE'=>'mysql',		   //���ݿ�����
	'DB_CHARSET'=>'utf-8',     //�ַ���
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
	//�����ļ���
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
