<?php
session_start();
require "../common/connect.php";
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "add":
		$data['comment_name'] = $_POST['name'];
		$data['comment_email'] = $_POST['email'];
		$data['comment_content'] = $_POST['content'];
		$data['comment_ip'] = get_ip();
		$data['comment_date'] = date('Y-m-d H:i:s');
		$resurt = $db->insert("wl_comment", $data);
		if($resurt)
		{
			header("location:admin.php?page=add_message&para=action=success");
		}
		else
		{
			header("location:admin.php?page=add_message&para=action=error");
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
		添加留言
	</div>
	<div class="panel-body">
		<div class="group" style="border:1px solid #ccc; padding: 5px;">
			<div class="btn-group">
				<button id = "send" type="button" class="btn btn-success">
					<span class="glyphicon glyphicon-send"></span> 发布
				</button>
				<button id = "clear" type="button" class="btn btn-danger">
				 <span class="glyphicon glyphicon-retweet"></span> 清空
				</button>
			</div>
		</div>
		<form id = "add_message_form" class="form-horizontal" style="margin-top: 20px;" role="form"
		action = "add_message.php?action=add" method = "post">
		  <div class="form-group">
		    <label class="col-sm-2 control-label">昵称：</label>
		    <div class="col-sm-10">
		      <input class="form-control" type="text" name = "name" value=""
		      placeholder="请输入昵称">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">电子邮箱：</label>
		    <div class="col-sm-10">
		      <input class="form-control" type="text" name = "email" value=""
		      placeholder="请输入电子邮箱">
		    </div>
		  </div> 
		  <div class="form-group">
		    <label class="col-sm-2 control-label" for="name">留言内容：</label>
		    <div class="col-sm-10">
		      <textarea class="form-control" name="content"></textarea>
		    </div>
		  </div>
		</form>
	</div>
</div>
<script>
$("#send").click(function(){
	$("#add_message_form").submit();
})
$("#clear").click(function(){
	$("#add_message_form :input").not(":button, :submit, :reset, :hidden, :checkbox, :radio").val("");  
	$("#add_message_form :input").removeAttr("checked").remove("selected");  
	$("#add_message_form :textarea").val(""); 
})
</script>