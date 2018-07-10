<?php 
session_start();
require "../common/connect.php";
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "edit":
			$data['admin_user'] = $_POST['user'];
			$data['admin_name'] = $_POST['name'];
			$data['admin_pwd'] = md5($_POST['pass']);
			
			$where = "where Id = 1";
			$res = $db->select_one("wl_admin",$where);
			if($res)
			{
				$resurt = $db->update("wl_admin", $data, $where);
			}
			else
			{
				$data['Id'] = 1;
				$resurt = $db->insert("wl_admin", $data);
			}
			if($resurt)
			{
				header("location:admin.php?page=setting_admin&para=action=success");
			}
			else
			{
				header("location:admin.php?page=setting_admin&para=action=error");
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
$where = "where Id = 1";
$resurt = $db->select_one("wl_admin",$where);
if($resurt != false)
{
	$data['user'] = $resurt['admin_user'];
	$data['name'] = $resurt['admin_name'];
}
?>
<div class="panel panel-default">
	<div class="panel-heading">
		网站设置
	</div>
	<div class="panel-body">
		<div class="group" style="border:1px solid #ccc; padding: 5px;">
			<div class="btn-group">
				<button id="send" type="button" class="btn btn-success">
					<span class="glyphicon glyphicon-send"></span> 保存
				</button>
				<button id="clear" type="button" class="btn btn-danger">
				 <span class="glyphicon glyphicon-retweet"></span> 清空
				</button>
			</div>
		</div>
		<form id="setting_form" class="form-horizontal" style="margin-top: 20px;" role="form" action="setting_admin.php?action=edit" method="post">
		  <div class="form-group">
		    <label class="col-sm-2 control-label">管理员账号：</label>
		    <div class="col-sm-10">
		      <input class="form-control" name="user" type="text" value="<?php if(isset($data['user'])){echo $data['user'];}?>">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">管理员昵称：</label>
		    <div class="col-sm-10">
		      <input class="form-control" name="name" type="text" value="<?php if(isset($data['name'])){echo $data['name'];}?>">
		    </div>
		  </div> 
		  <div class="form-group">
		    <label class="col-sm-2 control-label">管理员密码：</label>
		    <div class="col-sm-10">
		      <input class="form-control" name="pass" type="password" value="">
		    </div>
		  </div>
		</form>
	</div>
</div>
<script>
$("#send").click(function(){
	if($("input[name='pass']").val()=="")
	{
		alert("请输入修改密码");
	}
	else
	{
		$("#setting_form").submit();
	}
})
$("#clear").click(function(){
	$("#setting_form :input").not(":button, :submit, :reset, :hidden, :checkbox, :radio").val("");  
	$("#setting_form :input").removeAttr("checked").remove("selected");  
	$("#setting_form :textarea").val(""); 
})
</script>