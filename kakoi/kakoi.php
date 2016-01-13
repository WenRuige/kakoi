<?php
namespace kakoi;
use kakoi;

spl_autoload_extensions('.class.php'); //设定以什么扩展名结尾
set_include_path(get_include_path().PATH_SEPARATOR."kakoi/"); //设定文件的目录
spl_autoload_register();
if(isset($OTHER)){
	
}else{
	$OTHER = "Home";
}

$build = buildDir::getInstance();
//引入文件创建
$build->buildFile($OTHER);
//创建控制器
$build->buildController();
//创建配置文件
$build->buildConfig();

$moudle = isset($_GET['moudle'])?$_GET['moudle']:'Home';			//	模块名称
$controller = isset($_GET['controller'])?$_GET['controller']:'Index';	//加载的控制器
$method = isset($_GET['method'])?$_GET['method']:'Index';
$id = isset($_GET['id'])?$_GET['id']:'0';




// echo $moudle."</br>";
// echo $controller."</br>";
// echo $method."</br>";
//模板存放路径
$path = EVENT."/".$moudle."/View/";
$cache = EVENT."/".$moudle."/Cache";

$Controller = new \Controller();
//引入数据库配置文件
$data = require_once(EVENT."/Config/Config.php");
require_once("/DB/DB.class.php");
$DB = new DB($data);
$Controller = new \Controller();
require_once("/View/Template.class.php");
//引入模板
	$arrayConfig = array(
		"suffix"      => ".m", 			//设置模板文件
		"templateDir" =>  $path, 	//设置模板所在的文件夹
		"compileDir"  => $cache,
		"debug"      => false,		//设置编译后存放的目录
		"cache_htm"	  =>  true,		//是否需要编译成静态的html文件
		"suffix_cache"=> ".htm",		//编译后的文件后缀	
		"cache_time"  =>2000,			// 多长时间自动更新
		"php_turn"    =>false,			//是否支持原生的php代码
		"cache_control" => "control.dat",
		
		);
		
static $tpl;
$tpl    = Template::getInstance($arrayConfig);
//var_dump($tpl); 
$handle = handle::getInstance();
$handle->C($moudle,$controller,$method,$id);

//传入数据库配置参数













