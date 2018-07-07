<?php
session_start();
require "../common/connect.php";

if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "edit":
			$data['web_title'] = $_POST['title'];
			$data['web_key'] = $_POST['key'];
			$data['web_desc'] = $_POST['desc'];
			$data['web_copyright'] = $_POST['copyright'];
			$data['web_icp'] = $_POST['icp'];
			$data['date'] = date('y-m-d h:i:s',time());
			
			$where = "where Id = 1";
			$res = $db->select_one("wl_setting",$where);
			if($res)
			{
				$resurt = $db->update("wl_setting", $data, $where);
			}
			else
			{
				$resurt = $db->insert("wl_setting", $data);
			}
			if($resurt)
			{
				header("location:admin.php?page=setting&para=action=success");
			}
			else
			{
				header("location:admin.php?page=setting&para=action=error");
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
$resurt = $db->select_one("wl_setting",$where);
if($resurt != false)
{
	$data['web_title'] = $resurt['web_title'];
	$data['web_key'] = $resurt['web_key'];
	$data['web_desc'] = $resurt['web_desc'];
	$data['web_copyright'] = $resurt['web_copyright'];
	$data['web_icp'] = $resurt['web_icp'];
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
		<form id="setting_form" class="form-horizontal" style="margin-top: 20px;" role="form"
		action="setting.php?action=edit" method = "post">
		  <div class="form-group">
		    <label class="col-sm-2 control-label">网站标题：</label>
		    <div class="col-sm-10">
		      <input class="form-control" type="text" name="title" value="<?php if(isset($data['web_title'])){ echo $data['web_title'];}?>"
		      placeholder="请输入网站标题">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">网站关键字：</label>
		    <div class="col-sm-10">
		      <input class="form-control" type="text" name="key" value="<?php if(isset($data['web_key'])){ echo $data['web_key'];}?>"
		      placeholder="请输入网站关键字">
		    </div>
		  </div> 
		  <div class="form-group">
		    <label class="col-sm-2 control-label" for="name">网站描述：</label>
		    <div class="col-sm-10">
		      <textarea class="form-control" name="desc"><?php if(isset($data['web_desc'])){ echo $data['web_desc'];}?></textarea>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label">网站版权：</label>
		    <div class="col-sm-10">
		      <input class="form-control" type="text" name="copyright" value="<?php if(isset($data['web_copyright'])){ echo $data['web_copyright'];}?>"
		      placeholder="请输入网站版权信息">
		    </div>
		  </div> 
		  <div class="form-group">
		    <label class="col-sm-2 control-label">备案号：</label>
		    <div class="col-sm-10">
		      <input class="form-control" type="text" name="icp" value="<?php if(isset($data['web_icp'])){ echo $data['web_icp'];}?>"
		      placeholder="请输入网站备案号">
		    </div>
		  </div> 
		</form>
	</div>
</div>

<script>
$("#send").click(function(){
	$("#setting_form").submit();
})
$("#clear").click(function(){
	$("#setting_form :input").not(":button, :submit, :reset, :hidden, :checkbox, :radio").val("");  
	$("#setting_form :input").removeAttr("checked").remove("selected");  
	$("#setting_form :textarea").val(""); 
})
</script>