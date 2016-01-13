<?php

namespace kakoi;
use kakoi\view;
header("Content-type: text/html; charset=utf-8");
class Template{
	
		private $arrayConfig = array(
		"suffix"      => ".html", 			//设置模板文件
		"templateDir" =>  "", 	//设置模板所在的文件夹
		"compileDir"  => "",
		"debug"      => false,		//设置编译后存放的目录
		"cache_htm"	  =>  true,		//是否需要编译成静态的html文件
		"suffix_cache"=> ".htm",		//编译后的文件后缀	
		"cache_time"  =>2000,			// 多长时间自动更新
		"php_turn"    =>false,			//是否支持原生的php代码
		"cache_control" => "control.dat",
		
		);
		
	private $compileTool;		//编译器
	public $filename;		//模板文件名称
	private $value =array();		//值栈
	static private $instance  = null;	
	public $debug = array();	//调试信息
	public function __construct($arrayConfig =array()){
		
	
		$this->debug['begin'] = microtime(true);
		$this->arrayConfig =$arrayConfig+$this->arrayConfig;
		//var_dump($this->arrayConfig);
		$this->getPath();
		if(!is_dir($this->arrayConfig['templateDir'])){
			exit("template isnt not found");
		}
		if(!is_dir($this->arrayConfig['compileDir'])){
			
			mkdir($this->arrayConfig['compileDir'],0770,true);
		}
	include("Compile.class.php");
		//$this->compileTool = new Compile;
	}
	/**
	
			路径处理为绝对路径
	
	*/
	public function getPath(){
		$this->arrayConfig['templateDir'] = strtr(realpath($this->arrayConfig['templateDir']),'\\','/').'/';
		$this->arrayConfig['compileDir'] = strtr(realpath($this->arrayConfig['compileDir']),'\\','/').'/';
	}
	
	/***
	
			获取模板的实例
	**/
	public static function getInstance($arrayConfig=array()){
		if(is_null(self::$instance)){
			self::$instance = new Template($arrayConfig);
		}
		return self::$instance;
	}
	
	public function setConfig($key,$value = null){
		if(is_array($key)){
			$this->arrayConfig = $key+$this->arrayConfig;
		}else{
			$this->arrayConfig[$key] = $value;
		}
	}
	public function getConfig($key = null){
		if($key){
			return $this->arrayConfig[$key];
		}else{
			return $this->arrayConfig;
		}
		
	}
	
	
	public function assign($key,$value){
		$this->value[$key] = $value;
	}
	
	public function assignArray($array){
		if(is_array($array)){
				foreach($array as $k => $v){
					$this->value[$k] = $v;
				}
				
		}
	}
	
	public function path(){
		return $this->arrayConfig['templateDir'].$this->filename.$this->arrayConfig['suffix'];
	}
	/***
			是否需要缓存
	**/
	public function needCache(){
		return $this->arrayConfig['cache_htm'];
	}
	/***
				是否需要重新生成缓存文件
	**/
	
	public function reCache($file){
		$flag = false;
		$cacheFile = $this->arrayConfig['compileDir'].md5(@$filename).'.'.'php';
		//var_dump($cacheFile);
		if($this->arrayConfig['cache_htm']===true){
			$timeFlag = (time()-@filemtime($cacheFile))<$this->arrayConfig['cache_time']?
			true:false;
			if(!is_file($cacheFile)&&@filesize($cacheFile)>1&&$timeFlag){
				$flag = true;
			}else{
				$flag = false;
			}
		}
		return $flag;
	}
	public function show($file){
		$this->filename =$file;
		if(!is_file($this->path())){
			echo $this->path();
			exit('找不到相对应的模板');
		}
		$compileFile = $this->arrayConfig['compileDir'].'/'.md5(@$filename).'.php';
		$cacheFile = $this->arrayConfig['compileDir'].md5(@$filename).'.htm';
	//	echo $compileFile;
		//echo $cacheFile;
		if($this->reCache($file)===false){
			$this->debug['cached'] = 'false';
		//	var_dump($compileFile);
			$this->compileTool = new \Compile($this->path(),$compileFile,$this->arrayConfig);
			if($this->needCache()){
				ob_start();
			}
			extract($this->value,EXTR_OVERWRITE);
			if(@is_file($compileFile)||@filemtime($compileFile)<@filemtime($this->path())){
				$this->compileTool->vars = $this->value;
				$this->compileTool->compile();
				include $compileFile;
			}else{
				include $compileFile;
			}
			if($this->needCache()){
				$message = ob_get_contents();
				file_put_contents($cacheFile,$message);
			}
			
		}else{
			readfile($cacheFile);
			//$this->debug['cached'] = true;
		}
		$this->debug['spend'] = microtime(true) - $this->debug['begin'];
		$this->debug['count'] = count($this->value);
		$this->debug_info();
		/*
		var_dump($compileFile);this
		var_dump($this->path());
		if(!is_file($compileFile)){
			mkdir($this->arrayConfig['compileDir']);  //	此处若存在需要判断
			$this->compileTool->compile($this->path(),$compileFile);
			readfile($compileFile);
		}else{
			readfile($compileFile);
		}
		*/
	}
	public function debug_info(){
		//$this->arrayConfig['debug']=false;
		if($this->arrayConfig['debug']===true){
			var_dump($this);
			echo "程序运行日期",date("Y-m-d h:i:s")."</br>";
			echo "模板解析耗时",$this->debug['spend'],'秒'."</br>";
			echo "模板包含标签数目",$this->debug['count']."</br>";
			echo "是否使用静态缓存",$this->debug['cached']."</br>";
			//echo "模板引擎实例参数",var_dump($this->getConfig());
		}
	}
	/******
		清楚缓存的文件
	
	
	*****/
	public function clean($path = null){
		if($path = null){
			$path = $this->arrayConfig['CompileDir'];
			$path = glob($path.'*'.$this->arrayConfig['suffix_cache']);
			
		}else{
			$path = $this->arrayConfig['compileDir'].md5($path).'.htm';
			foreach((array)$path as $v){
				unlink($v);
			}
		}
	}
	
	
	
}