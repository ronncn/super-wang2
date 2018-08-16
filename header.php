<?php
require_once "common/connect.php";
$where = "where Id = 1";
$setting = $db->select_one("wl_setting",$where);
$class_sql = "select distinct project_class from wl_project";
$class_list = $db->select_all("wl_project",'',"distinct project_class");
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!--字符编码-->
    <meta charset="UTF-8" />
	<!--视图 宽度等于设备宽度丨初始化缩放等于1丨不允许用户缩放-->
	<meta name="viewport" content="width=device-width, initial-scale = 1, user-scalable=no" />
	<!--关键字 关键字内容-->
	<meta name="keywords" content="<?php echo $setting['web_key'];?>" />
	<!--描述 描述内容-->
	<meta name="description" content="<?php echo $setting['web_desc'];?>" />
	<!--网站的ico图标-->
	<link href="favicon.ico" rel="icon" />
	<link href="public/css/index.css" rel="stylesheet" />
	<!--网站的标题-->
	<title><?php echo $setting['web_title'];?></title>
	<script src="public/js/jquery-3.3.1.js"></script>
</head>
<body>
	<header>
		<div id = "h_logo">
			<img src="public/images/wl.png" width=130 alt="wl" />
		</div>
		<nav>
			<ul>
				<!--<li><a href="#">封面</a></li>-->
				<li><a href="index.php">项目</a></li>
				<li><a href="article_list.php">随笔</a></li>
				<li><a href="message.php">留言</a></li>
				<li><a href="article.php?id=5">关于</a></li>
			</ul>
		</nav>
	</header>