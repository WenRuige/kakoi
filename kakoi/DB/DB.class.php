<?php
namespace kakoi;
use kakoi\DB;
//数据库连接层

class DB{
	//数据库应该重写一遍
	static $link;
	public function __construct($Config=array()){
		//数据库连接层
		if(count($Config)==0){
			echo "数组为空";
		}else{
			$dsn=$Config['DB_TYPE'].':host='.$Config['DB_HOST'].';dbname='.$Config['DB_NAME'];
			self::$link=new \PDO($dsn,$Config['DB_USER'], $Config['DB_PWD']);
			$this->table = $Config['DB_NAME']."_";
			
		}
		
	}
	/**
	
	
	**/
	public function M($table){
		$table = strtolower($table);
		$this->table.= $table;	
	}
	/**
	
	
	**/
	public function add($data){
			$table =$this->table;
			global $key;
			global $value;
			foreach($data as $key_tmp =>$value_tmp){
				$key.=$key_tmp.',';
				$value.="'".$value_tmp."'".',';	
			}
			$key=rtrim($key, ",");
			$value=rtrim($value, ",");
			$sql = "insert into ".$table."(".$key.")values(".$value.")";//sql的插入语句  格式：insert into 表(多个字段)values(多个值)
			//echo $sql;
			//return $sql;
			self::$link->query("SET NAMES utf8");  
			$result=self::$link->query($sql);//调用类自身的	
		
	}
	/**
			更新
	
	**/
	public  function update($data){
			//$table =$this->table;	 //	指定数据的表
			global $field;
			foreach($data as $value=>$key){
				$field.=$value."="."'".$key."'".",";		
			}
			$field=rtrim($field,",");
			//echo $field."</br>";
			$this->update = $field;
			return $this;			
		}
		/**
				
			
	**/
		public function where($where){
			$sql="update ".$this->table." set ".$this->update." where ".$where."";
			self::$link->query("SET NAMES utf8"); 
			$result = self::$link->query($sql);		
			return $result;
		}
		/**
			选择  所有数据
	
	**/
	
	public function find($condition){
		//有条件的查找
			self::$link->query("SET NAMES utf8");  
				
				$rs = self::$link->query($condition);
				$rs->setFetchMode(\PDO::FETCH_ASSOC);//返回关联数组
				$result = $rs -> fetchAll();
				return $result;
		
	}
	
		public function select($condition=''){
								
				self::$link->query("SET NAMES utf8");  
				$sql = "select * from ".$this->table;
				$this->sql = $sql;
				$rs = self::$link->query($sql);
				$rs->setFetchMode(\PDO::FETCH_ASSOC);//返回关联数组
				$result = $rs -> fetchAll();
				return $result;
				
			
		}
		public function selectOne($condition){
			self::$link->query("SET NAMES utf8");  
				$sql = "select * from ".$this->table." where ".$condition;
				$this->sql = $sql;
				
			
				$rs = self::$link->query($sql);
					$rs->setFetchMode(\PDO::FETCH_ASSOC);
				$result = $rs -> fetch();
				return $result;
			
		}
		/**
	
				删除
	**/
		public function delete($where){
			$sql = "delete from ".$this->table." where ".$where."";//sql的插入语句  格式：insert into 表(多个字段)values(多个值)
			$result = self::$link->query($sql);//调用类自身的
					return $result;
		}
		// public function limit($limit){
			// return "123";
		// }
		
		// public function execute($result = array()){
			// var_dump($result);
		// }
		public function __call($fun,$args){
			if(in_array($fun,array("limit"))){
				echo $fun."</br>";	
			}
			
			
		}
}
