<?php
session_start();
require "../common/connect.php";

if(!isset($_GET['Id']))
{
	return;
}
$Id = $_GET['Id'];
$where = "where Id = {$Id}";
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "reply":
			$data['comment_reply'] = $_POST['reply'];
			$data['comment_reply_date'] = date('Y-m-d H:i:s');
			$result = $db->update("wl_comment", $data, $where);
			if($result)
			{
				header("location: admin.php?page=message_list");
			}
			else
			{
				echo "回复失败";
			}
		break;
	}
}
$rs = $db->select_one("wl_comment",$where);
if(!$rs)
{
	echo "查询失败！";
	return;
}
?>
<!--回复留言页面-->
<div class="panel panel-default">
	<div class="panel-heading">
		回复留言
	</div>
	<div class="panel-body">
		<form class="form-horizontal" style="margin-top: 20px;" role="form"
		action="message_reply.php?action=reply&Id=<?php echo $Id;?>" method="post">
		  <div class="form-group">
		    <label class="col-sm-2 control-label">留言昵称：</label>
		    <div class="col-sm-10">
		    	<p class="text-muted checkbox"><?php echo $rs['comment_name'];?></p>
		    </div>
		  </div>  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">留言邮箱：</label>
		    <div class="col-sm-10">
		    	<p class="text-muted checkbox"><?php echo $rs['comment_email'];?></p>
		    </div>
		  </div>  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">留言内容：</label>
		    <div class="col-sm-10">
		    	<p class="text-muted checkbox"><?php echo $rs['comment_content'];?></p>
		    </div>
		  </div> 
		  <div class="form-group">
		    <label class="col-sm-2 control-label" for="name">留言IP：</label>
			  <div class="col-sm-10">
			  	<p class="text-muted checkbox"><?php echo $rs['comment_ip']?>（<span>山东青岛</span>）</p>
			  </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label" for="name">回复内容：</label>
			  <div class="col-sm-10">
			  	<textarea class="form-control" name="reply"><?php echo $rs['comment_reply'];?></textarea>
			  </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-2 pull-right">
		    	<button class="btn btn-info pull-right" type="submit">回复</button>
		    </div>
		  </div> 
		</form>
	</div>
</div>
