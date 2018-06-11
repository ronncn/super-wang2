<?php
session_start();//开启SESSION
require "../common/connect.php";

if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "logout":
			unset($_SESSION['admin_id'], $_SESSION['admin_name']);
			header("Location:login.php");
		break;
		default:
		if(!(isset($_POST['username']) && isset($_POST['password'])))
		{
			header("Location: login.php");
		}
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$sqlwhere = "where admin_user = '{$username}' and admin_pwd = '{$password}'";
		$data = $db->select_one("wl_admin", $sqlwhere);
		var_dump($data);
		if($data)
		{
			$_SESSION['admin_id'] = $data['Id'];
			$_SESSION['admin_name'] = $data['admin_name'];
			//登录成功，跳转到首页
			header("Location: admin.php");
			//echo $_SESSION['admin_id'];
		}
		else
		{
			//登录失败，跳转登录页面
			header("Location: login.php");
		}
		break;
	}
}
?>
<html>  
    <head>  
        <meta charset="utf-8">  
        <meta http-equiv="X-UA-Compatible" content="IE=edge">  
        <meta name="viewport" content="width=device-width, initial-scale=1">  
        <title>用户登录</title>  
        <!-- Bootstrap 核心 CSS 文件 -->  
        <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <style>  
            /*web background*/  
            .container{  
                display:table;  
                height:100%;  
            }  
  
            .row{  
                display: table-cell;  
                vertical-align: middle;  
            }  
            /* centered columns styles */  
            .row-centered {  
                text-align:center;  
            }  
            .col-centered {  
                display:inline-block;  
                float:none;  
                text-align:left;  
                margin-right:-4px;  
            }  
        </style>  
    </head>  
  
    <body>  
        <div class="container">  
            <div class="row row-centered">
                <h2>后台管理</h2> 
                <div class="well col-md-6 col-centered"> 
                    <form action="login.php?action=do" method="post" role="form">  
                        <div class="form-group input-group input-group-md">  
                            <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>  
                            <input type="text" class="form-control" id="username" name="username" placeholder="请输入用户ID"/>  
                        </div>  
                        <div class="form-group input-group input-group-md">  
                            <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-lock"></i></span>  
                            <input type="password" class="form-control" id="password" name="password" placeholder="请输入密码"/>  
                        </div>  
                        <br/>  
                        <button type="submit" class="btn btn-success btn-block">登录</button>  
                    </form>  
                </div>  
            </div>  
        </div>  
  
  
      
        <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
    </body>  
</html>  