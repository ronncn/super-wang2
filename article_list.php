<?php
require_once "header.php";
$date = $db->select_all("wl_article","order by article_date desc","DISTINCT DATE_FORMAT(article_date, '%Y-%m')");
//var_dump($article_list);
?>
	<div id="main">
		<div class="main_center">
			<?php foreach($date as $d){?>
			<div class="article_item">
				<h1 class="time"><?php echo $article_date = $d["DATE_FORMAT(article_date, '%Y-%m')"];?></h1>
				<ul>
				<?php 
				$article_list = $db->select_all("wl_article","where DATE_FORMAT(article_date, '%Y-%m') = '{$article_date}' order by article_date desc");
				//var_dump($article_list);
				foreach($article_list as $art){
				?>
					<li>
						<h1 class="title"><a href="article.php?id=<?php echo $art['Id'];?>"><?php echo $art['article_title'];?></a></h1>
						<p><?php echo substr($art['article_des'],0,350);?><span style="font-weight: bold;"><a href="article.php?id=<?php echo $art['Id'];?>"> 阅读更多>> </a></span></p>
					</li>
				<?php }?>
				</ul>
			</div>
			<?php }?>
		</div>
	</div>
</body>
</html>