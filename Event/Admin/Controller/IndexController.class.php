<?php
	class IndexController extends Controller{
		
			public function __construct(){
				
			}
		public function index(){
		global $tpl;
		 global $DB;
		 $DB->M('Message');
		 $data = $DB->select();
		 //var_dump($data);
		 $tpl->assign('data',$data);
		 $tpl->show("index");
		
		}
		
		
		public function post(){
			global $DB;
			$title_temp = $_POST['title'];
			$html = $_POST['html'];
			$kind = $_POST['kind'];
			if(!empty($title_temp))
			$title =htmlspecialchars($title_temp);
				//转义防止SQL注入
			
			 $DB->M("Message");
			//var_dump($DB);		 // 使用的表名称
	
		$data['title'] = $title;
		$data['content'] = $html;
		$data['kind'] = $kind;
		$data['updatetime'] = date("Y-m-d h:i:sa") ;
		$data['click'] =0;
		$DB->add($data);
		
		
		}
		//删除文章
		public function delete($id){
			global $DB;
			$DB->M('Message');
			$data = $DB->delete("id=$id");
			
			if($data){
				echo "<script>self.location='admin_index_index_0.html';</script>";
			}else{
				echo "删除失败";
			}
			
		}
		//修改文章
		public function alter($id){
		 global $tpl;
		 global $DB;
		 $DB->M('Message');
		 $sql = "select * from  blog_message where id=".$id;
		 $data = $DB->find($sql);
		 //var_dump($data['0']['title']);,
		 $tpl->assign('id',$data['0']['id']);
		 $tpl->assign('title',$data['0']['title']);
		 $tpl->assign('content',$data['0']['content']);
		 $tpl->show('alter');
		}
		public function update(){
			global $tpl;
			global $DB;
			$title_temp = $_POST['title'];
			$id = $_POST['id'];
			$html = $_POST['html'];
			$kind = $_POST['kind'];
			if(!empty($title_temp))
			$title =htmlspecialchars($title_temp);
		
		$DB->M('Message');
		
		$data['title'] = $title;
		$data['content'] = $html;
		$data['kind'] = $kind;
		$data['updatetime'] = date("Y-m-d h:i:sa") ;
		$DB->update($data)->where("id=$id");
		echo "<script>self.location='admin_index_index_0.html';</script>";
		
			
		}
	}
	
	
	
	
	
	
	
	?>
	
	
	