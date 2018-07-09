<?php
session_start();
require "../common/connect.php";
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "add":
			$data['article_title'] = $_POST['title'];
			$data['article_key'] = $_POST['key'];
			$data['article_des'] = $_POST['desc'];
			$data['article_class'] = $_POST['class'];
			$data['article_content'] = $_POST['content'];
			$data['article_date'] = date('Y-m-d H:i:s', time());
			
			if($_POST['id'] != "")
			{
				$id = $_POST['id'];
				$where = "where Id = {$id}";
				
				$resurt = $db->update("wl_article",$data,$where);
				
			}
			else
			{
				$resurt = $db->insert("wl_article",$data);
				//return;
			}	
			if($resurt)
			{
				header("location:admin.php?page=add_article&para=action=success");
			}
			else
			{
				header("location:admin.php?page=add_article&para=action=error");
			}
		break;
		case "edit":
			if(isset($_GET['Id']))
			{
				$data['Id'] = $_GET['Id'];
				$where = "where Id = {$_GET['Id']}";
				$resurt = $db->select_one("wl_article",$where);
				$data['article_title'] = $resurt['article_title'];
				$data['article_key'] = $resurt['article_key'];
				$data['article_class'] = $resurt['article_class'];
				$data['article_content'] = $resurt['article_content'];
				//$data['article_date'] = date('Y-m-d H:i:s');
			}
		break;
		case "success":
			echo "发布成功！"; 
		break;
		case "error":
			echo "发布失败！"; 
		break;
		default:
		break;
	}
}
?>

<div class="panel panel-default">
	<div class="panel-heading">
		发布文章
	</div>
	<div class="panel-body">
		<div class="group" style="border:1px solid #ccc; padding: 5px;">
			<div class="btn-group">
				<button type="button" class="btn btn-success" id="send">
					<span class="glyphicon glyphicon-send"></span> 发布
				</button>
				<button type="button" class="btn btn-info">
				 <span class="glyphicon glyphicon-film"></span> 暂存
				</button>
				<button type="button" class="btn btn-danger">
				 <span class="glyphicon glyphicon-retweet" id="clear"></span> 清空
				</button>
			</div>
		</div>
		<form id="add_article_form" class="form-horizontal" style="margin-top: 20px;" role="form"
		action="add_article.php?action=add" method="post">
			<input type="hidden" name="id" value="<?php if(isset($data['Id'])){ echo $data['Id'];}?>">
		  <div class="form-group">
		    <label class="col-sm-2 control-label">文章标题：</label>
		    <div class="col-sm-10">
		      <input class="form-control" type="text" name="title" value="<?php if(isset($data['article_title'])){ echo $data['article_title'];} ?>"
		      placeholder="请输入文章标题">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">文章分类：</label>
		    <div class="col-sm-10">
		      <input class="form-control" type="text" name="class" value="<?php
			   if(isset($data['article_class'])){ echo $data['article_class'];}?>"
		      placeholder="请输入文章分类">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">文章标签：</label>
		    <div class="col-sm-10">
		      <input class="form-control" type="text" name="key" value="<?php
			   if(isset($data['article_key'])){ echo $data['article_key'];}
			  ?>"
		      placeholder="输入标签请用逗号“,”分隔">
		    </div>
		  </div> 
		  <input type="hidden" name="desc" id="desc" value="" />
		  <!--
		  <div class="form-group">
		    <label class="col-sm-2 control-label" for="name">文章首图：</label>
			  <div class="col-sm-3">
			    <label class="sr-only" for="inputfile">上传图片</label>
			    <input type="file" id="inputfile">
			  </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label" for="name"></label>
			  <div class="col-sm-10">
			  	<img src="../public/images/timg.jpg" width="600" height="300" />
			  </div>
		  </div>
		  -->
		  <div class="form-group">
		    <label class="col-sm-2 control-label">编辑：</label>
		    <div class="col-sm-10">
			    <!-- 加载编辑器的容器 -->
			    <script id="container" name="content" type="text/plain">
			        <?php if(isset($data['article_content'])){echo $data['article_content'];}?>
			    </script>
			    <!-- 配置文件 -->
			    <script type="text/javascript" src="../public/ueditor/ueditor.config.js"></script>
			    <!-- 编辑器源码文件 -->
			    <script type="text/javascript" src="../public/ueditor/ueditor.all.js"></script>
			    <!-- 实例化编辑器 -->
			    <script type="text/javascript">
			        var ue = UE.getEditor('container');
			    </script>
		    </div>
		  </div> 
		</form>
	</div>
	
<script>
$("#send").click(function(){
	var _title = $("input[name='title']").val();
	var _class = $("input[name='class']").val();
	if(_title == '')
	{
		alert("请输入文章名称");
	}
	else if(_class == '')
	{
		alert("请输入文章分类");
	}
	else
	{	
		var txt = ue.getContentTxt();
		$("desc").val(txt.substring(0,100));
		$("#add_article_form").submit();
	}
})
$("#clear").click(function(){
	$("#add_article_form :input").not(":button, :submit, :reset, :hidden, :checkbox, :radio").val("");  
	$("#add_article_form :input").removeAttr("checked").remove("selected");
})
</script>
</div>
			