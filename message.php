<?php
require_once "header.php";
function getIp()
{
if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
$ip = getenv("HTTP_CLIENT_IP");
else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
$ip = getenv("HTTP_X_FORWARDED_FOR");
else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
$ip = getenv("REMOTE_ADDR");
else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
$ip = $_SERVER['REMOTE_ADDR'];
else
$ip = "unknown";
return($ip);
}
if(isset($_GET['action'])&&$_GET['action'] == "submit")
{
	$data['comment_name'] = $_POST['nick'];
	$data['comment_email'] = $_POST['contact'];
	$data['comment_content'] = $_POST['message'];
	$data['comment_ip'] = getIp();
	$data['comment_date'] = date("Y-m-d H:i:s",time());
	$rs = $db->insert("wl_comment",$data);
	if($rs)
	{
		header("location: message.php");
	}
	else
	{
		echo "<scrtip>alert('留言失败');window.location.href = 'message.php';</script>";
	}
	exit();
}
$message = $db->select_all("wl_comment","order by comment_date desc");
//var_dump($message);
?>
	<div id="main">
		<div class="main_center">
			<div class="message">
				<div class="title">
					<span class="shuxian fl"></span>
					<h1>访客留言</h1>
					<p>关于留言板的使用说明</p>
				</div>
				<div class="content">
					<form id="messageForm" method="post" action="message.php?action=submit">
						<textarea name="message" rows="10" placeholder="请留言..." maxlength="500"></textarea>
						<input type="text" name="nick" placeholder="请输入昵称" />
						<input class="fr" type="text" name="contact" placeholder="请输入电子邮箱" />
						<button class="btn" type="button" name="btn_message">留言</button>
					</form>
					<script>
						$(".btn").click(function(){
							if($("textarea[name='message']").val() == "")
							{
								alert("请输入留言信息");
							}
							else if($("input[name='nick']").val() == "")
							{
								alert("请输入昵称");
							}
							else if($("input[name='contact']").val() == "")
							{
								alert("请输入电子邮箱");
							}
							else
							{
								$("#messageForm").submit();
							}
						})
					</script>
				</div>
				<div class="display">
					<div class="title">
						<span class="shuxian fl"></span>
						<h1>最新留言</h1>
					</div>
					<ul class="message_list">
					<?php foreach($message as $m){?>
						<li>
							<div class="ml_top">
								<span><?php echo $m['comment_name'];?></span>
								<span class="fr">IP：<?php echo $m['comment_ip'];?>  &nbsp;&nbsp;&nbsp; &nbsp; <?php echo $m['comment_date'];?> </span>
							</div>
							<div class="ml_middle">
								<p><?php echo $m['comment_content'];?></p>
							</div>
							<?php 
							if($m['comment_reply'] != "")
							{
							?>
							<div class="ml_bottom">
								<b>管理员回复：</b>
								<span><?php echo $m['comment_reply'];?></span>
							</div>
							<?php }?>
						</li>
					<?php }?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
</html>