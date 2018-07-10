<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once "header.php";
if(!isset($_GET['id']))
{
	header("location:article_list.php");
}
$id = $_GET['id'];
$art = $db->select_one("wl_article","where Id={$id}");
?>
	<div id="main">
		<div class="main_center">
			<article class="article_wrap">
				<h1 class="title"><?php echo $art['article_title'];?></h1>
				<div class="article_content">
					<?php echo $art['article_content'];?>
				</div>
				<div >
				<?php 
				$art_left = $db->select_one("wl_article","where Id = (select Id from wl_article where Id < {$id} order by Id desc limit 1)","Id,article_title");
				//var_dump($art_left);
				$art_right = $db->select_one("wl_article","where Id = (select Id from wl_article where Id > {$id} order by Id asc limit 1)","Id,article_title");
				if(count($art_left)!=0)
				{
					echo "<span><a href='article.php?id={$art_left['Id']}'>←上一篇：{$art_left['article_title']}</a></span><br/>";
				}
				else
				{
					echo "<span><a href='#'>←上一篇：没有了</a></span><br/>";
				}
				if(count($art_right)!=0)
				{
					echo "<span><a href='article.php?id={$art_right['Id']}'>→下一篇：{$art_right['article_title']}</a></span><br/>";
				}
				else
				{
					echo "<span><a href='#'>→下一篇：没有了</a></span><br/>";
				}
				?>
				</div>
				<br/>
				
				<!--
				<div class="content">
					<form method="post" action="#">
						<textarea name="message" rows="5" placeholder="请留言..." maxlength="500"></textarea>
						<input type="text" name="nick" placeholder="请输入昵称" value="" />
						<input class="fr" type="text" name="contact" placeholder="请输入电子邮箱" value="" />
						<input class="btn" type="submit" name="btn_message" value="我要评论" />
					</form>
				</div>
				<br />
				<div class="display">
					<div class="title">
						<span class="shuxian fl"></span>
						<h1>最新评论</h1>
					</div>
					<ul class="message_list">
						<li>
							<div class="ml_top">
								<span>昵称</span>
								<span class="fr">IP：221.7.207***  &nbsp;&nbsp;&nbsp; &nbsp; 2013-02-21 08:39:32 </span>
							</div>
							<div class="ml_middle">
								<p>回复内容</p>
							</div>
							<div class="ml_bottom">
								<b>管理员回复：</b>
								<span>管理员回复内容！</span>
							</div>
						</li>
						<li>
							<div class="ml_top">
								<span>昵称</span>
								<span class="fr">IP：221.7.207***  &nbsp;&nbsp;&nbsp; &nbsp; 2013-02-21 08:39:32 </span>
							</div>
							<div class="ml_middle">
								<p>回复内容</p>
							</div>
							<div class="ml_bottom">
								<b>管理员回复：</b>
								<span>管理员回复内容！</span>
							</div>
						</li>
					</ul>
				</div>-->
			</article>

		</div>
	</div>
</body>
</html>