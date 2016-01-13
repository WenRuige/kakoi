<?php
namespace kakoi;
use kakoi;

spl_autoload_extensions('.class.php'); //�趨��ʲô��չ����β
set_include_path(get_include_path().PATH_SEPARATOR."kakoi/"); //�趨�ļ���Ŀ¼
spl_autoload_register();
if(isset($OTHER)){
	
}else{
	$OTHER = "Home";
}

$build = buildDir::getInstance();
//�����ļ�����
$build->buildFile($OTHER);
//����������
$build->buildController();
//���������ļ�
$build->buildConfig();

$moudle = isset($_GET['moudle'])?$_GET['moudle']:'Home';			//	ģ������
$controller = isset($_GET['controller'])?$_GET['controller']:'Index';	//���صĿ�����
$method = isset($_GET['method'])?$_GET['method']:'Index';
$id = isset($_GET['id'])?$_GET['id']:'0';




// echo $moudle."</br>";
// echo $controller."</br>";
// echo $method."</br>";
//ģ����·��
$path = EVENT."/".$moudle."/View/";
$cache = EVENT."/".$moudle."/Cache";

$Controller = new \Controller();
//�������ݿ������ļ�
$data = require_once(EVENT."/Config/Config.php");
require_once("/DB/DB.class.php");
$DB = new DB($data);
$Controller = new \Controller();
require_once("/View/Template.class.php");
//����ģ��
	$arrayConfig = array(
		"suffix"      => ".m", 			//����ģ���ļ�
		"templateDir" =>  $path, 	//����ģ�����ڵ��ļ���
		"compileDir"  => $cache,
		"debug"      => false,		//���ñ�����ŵ�Ŀ¼
		"cache_htm"	  =>  true,		//�Ƿ���Ҫ����ɾ�̬��html�ļ�
		"suffix_cache"=> ".htm",		//�������ļ���׺	
		"cache_time"  =>2000,			// �೤ʱ���Զ�����
		"php_turn"    =>false,			//�Ƿ�֧��ԭ����php����
		"cache_control" => "control.dat",
		
		);
		
static $tpl;
$tpl    = Template::getInstance($arrayConfig);
//var_dump($tpl); 
$handle = handle::getInstance();
$handle->C($moudle,$controller,$method,$id);

//�������ݿ����ò���













