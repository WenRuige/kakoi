<?php
	
	class IndexController extends Controller{
		public function index(){
		 
		global $tpl;
		global $DB;
		
		 $DB->M("Message");
		 $p = isset($_GET['p'])?$_GET['p']:'1';
		 $num = 4;			//分页每页的条数
		 $sql = "select * from blog_message limit ".($p-1).",$num";	//查询每页的条数
		 $total = "select count(*) from blog_message";	//	查询总条数
		 $data = $DB->find($total);
		 $value = $DB->find($sql);
		 $total_pages=ceil($data['0']['count(*)']/$num);  //总页数 除以
		$tpl->assign('total_pages',$total_pages);
		$tpl->assign('value',$value);
		$tpl->assign('data',$value);
		$tpl->show("index");
		}
		public function show($id){
			global $DB;
			global $tpl;
			if(isset($id)){
				$DB->M("Message");
				$data = $DB->selectOne("id=$id");
				$num = $data['click'];
				$num = $num+1;
				$data['click'] = $num;
				$DB->update($data)->where("id=$id");
				$tpl->assign('data',$data);
				$tpl->show('show');
				
			}
		}
		public function tech(){
			global $DB;
			global $tpl;
		  $DB->M("Message");
		$sql = "select * from blog_message where kind ='1'";
		$data = $DB->find($sql);
		$tpl->assign('data',$data);
			$tpl->show('tech');
		}
		public function status(){
			
				global $DB;
			global $tpl;
		  $DB->M("Message");
		$sql = "select * from blog_message where kind ='2'";
		$data = $DB->find($sql);
		$tpl->assign('data',$data);
			$tpl->show('status');
			
		}
	}
	?>