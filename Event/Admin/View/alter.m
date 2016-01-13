<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" /> 
<link href="Event/Public/css/bootstrap.min.css" rel="stylesheet">
<script src="Event/Public/js/jquery-2.1.1.js"></script>
<script src="Event/Public/js/bootstrap.min.js"></script>
<script charset="utf-8" src="kakoi/ORG/kind/kindeditor.js"></script>
<script charset="utf-8" src="kakoi/ORG/kind/lang/zh_CN.js"></script>
<script charset="utf-8" src="kakoi/ORG/kind/lang/zh_CN.js"></script>



<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id');
        });
	
	
		function show(){
		
		html = editor.html();
		editor.sync();
		html = document.getElementById('editor_id').value; // 原生API 获取输入的值
		kind =jQuery("#select").val();
	
		title=$("input[name='title']").val();
		id = $("input[name='id']").val();
	
				$.ajax({
								type: "POST",
								url: "index.php?moudle=admin&controller=index&method=update",
								data: "title="+title+"&html="+html+"&kind="+kind+"&id="+id,
								success:function(data){
											alert("success");
										
										}
							});
							}
	
	

</script>


</head>


<body id="bg" style =" background-color: #efefef;">

<div class="container">

   <h1>RuiWenge's &nbsp;Blog</h1>

   <div class="row">
  
     
        <div class="col-md-1" >
         
      </div>
      <div class="col-md-8" >
	 <center> 
	 <img src="Event/Public/123.gif" 
   class="img-circle"></center>
   </br>
	<h1>Alter</h1>

  <div class="m-post" STYLE="padding: 40px 40px 35px;
  margin: 40px 0 0;
  background: #fff;">
	 <div class="form-group">
	  <label for="exampleInputEmail1">Kind</label>
	     <select class="form-control" id ="select">
         <option value ="1">技术相关</option>
         <option value ="2">心情随笔</option>
         <option value ="3">动漫siki</option>
      </select>
    <label for="exampleInputEmail1">Tittle</label>
    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="title" name="title" value="{$title}">
  </div>
	<label for="exampleInputEmail1">Content</label>
		  <div class="controls">
                   <textarea id="editor_id" name="content" style="width:700px;height:300px;">
{$content}
</textarea>
                </div>
	<button type="button" class="btn btn-primary" onclick ="show()">提交</button>
	<input type="hidden"  name ="id" value="{$id}">
</div>

 

  

      </div>
	  
	  
	

	  <div class="col-md-3">
	
  

      </div>
   </div>


</div>
<footer><a href ="home_index_index_0.html">返回主页面</a></footer>
</body>
</html>