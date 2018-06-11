<?php
session_start();
require "../common/connect.php";

//获取子页面内容
function get_childpage($page,$para=null)
{
	if(is_null($para))
	{
		$p = file_get_contents("http://localhost/wanglong.work/webadmin/".$page.".php");
	}
	else
	{
		$p = file_get_contents("http://localhost/wanglong.work/webadmin/".$page.".php?".$para);
		//echo $p;
	}
	return $p;
}

if(!isset($_SESSION['admin_id']))
{
	//如果没有设置SESSION，跳转到登录页面
	header("Location:login.php");
}
else
{
	if(isset($_GET['page']))
	{
		if(isset($_GET['para']))
		{
			$para = $_GET['para'];
		}
		else
		{
			$para = null;
		}
		switch($_GET['page'])
		{
			case "project_list":
				$page = get_childpage($_GET['page'],$para);
			break;
			case "add_article":
				$page = get_childpage($_GET['page'],$para);
			break;
			case "article_list":
				$page = get_childpage($_GET['page'],$para);
			break;
			case "add_message":
				$page = get_childpage($_GET['page'],$para);
			break;
			case "message_list":
				$page = get_childpage($_GET['page'],$para);
			break;
			case "message_reply":
				$page = get_childpage($_GET['page'],$para);
			break;
			case "setting":
				$page = get_childpage($_GET['page'],$para);
			break;
			default:
				$page = get_childpage("add_project",$para);
				//$page = file_get_contents("add_project.php?action");
			break;
		}
	}
	else
	{
		$page = get_childpage("add_project",null);
	}
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!--字符编码-->
    <meta charset="UTF-8" />
	<!--视图 宽度等于设备宽度丨初始化缩放等于1丨不允许用户缩放-->
	<meta name="viewport" content="width=device-width, initial-scale = 1, user-scalable=no" />
	<!--网站的ico图标-->
	<link href="bitbug_favicon.ico" rel="icon" />
	<link href="../public/css/admin.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--网站的标题-->
	<title>wanglong.work丨后台管理</title>
	<style type="text/css">
		.panel-title,.list-group-item{cursor: pointer;}
	</style>
</head>
<body>
	<section>
		<div class="container">
			<div class="page-header">
		    	<h1>后台管理
		        	<small>主页</small>
		        	<span style="float: right; font-size: 16px; margin-top: 20px;">
						<a href="login.php?action=logout"><?php echo $_SESSION['admin_id'];?></a>
					</span>
		    	</h1>
			</div>
			<div class="row">
				<aside class="col-xs-6 col-sm-3">
					<div class="panel-group" id="accordion">
					    <div class="panel panel-default">
					        <div class="panel-heading">
					            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" 
					                href="#collapse1">
					                <span class="glyphicon glyphicon-th-large"></span> 项目管理
					            </h4>
					        </div>
					        <div id="collapse1" class="panel-collapse collapse in">
				            	<ul class="list-group">
								    <li class="list-group-item menu-item" data-page="add_project">
								    	发布项目
								    </li>
								    <li class="list-group-item menu-item" data-page="project_list">
								    	项目列表
								    </li>
								</ul>
					        </div>
					    </div>
					    <div class="panel panel-default">
					        <div class="panel-heading">
					            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" 
					                href="#collapse2">
					                <span class="glyphicon glyphicon-list-alt"></span> 文章管理
					            </h4>
					        </div>
					        <div id="collapse2" class="panel-collapse collapse">
				            	<ul class="list-group">
								    <li class="list-group-item menu-item" data-page="add_article.html">发布文章</li>
								    <li class="list-group-item menu-item" data-page="article_list.html">文章列表</li>
								</ul>
					        </div>
					    </div>
					    <div class="panel panel-default">
					        <div class="panel-heading">
					            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" 
					                href="#collapse3">
					                <span class="glyphicon glyphicon-user"></span> 
					                留言管理
					            </h4>
					        </div>
					        <div id="collapse3" class="panel-collapse collapse">
				            	<ul class="list-group">
								    <li class="list-group-item menu-item" data-page="add_message.html">添加留言</li>
								    <li class="list-group-item menu-item" data-page="message_list.html">留言列表</li>
								</ul>
					        </div>
					    </div>
					    <div class="panel panel-default">
					        <div class="panel-heading">
					            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" 
					                href="#collapse4">
					                <span class="glyphicon glyphicon-cog"></span> 
					                网站设置
					            </h4>
					        </div>
					        <div id="collapse4" class="panel-collapse collapse">
				            	<ul class="list-group">
								    <li class="list-group-item menu-item" data-page="setting.html">网站设置</li>
								</ul>
					        </div>
					    </div>
					</div>	
				</aside>
				<article class="col-xs-9">
					<?php echo $page;?>
				</article>
			</div>
		</div>
	</section>
	<script>
		$(".menu-item").click(function(){
			var addr = $(this).data("page");
		  	//$("#page-child").load(addr);
			window.location.href = "admin.php?page=" + addr;
		})
	</script>
</body>
</html>
<?php
}
?>