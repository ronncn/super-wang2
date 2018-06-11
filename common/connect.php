<?php
// 解决中文乱码问题
header("Content-Type: text/html;charset=utf-8"); 
require "DBHelper.class.php";
$host = "localhost";			//主机
$port = 3306;					//端口
$user = "root";					//用户名
$pass = "root";					//密码
$dbname = "wanglong";			//数据库
$db=new DBHelper($host,$user,$pass,$dbname);