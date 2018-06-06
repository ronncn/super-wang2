<?php
    // 解决中文乱码问题
    header("Content-Type: text/html;charset=utf-8"); 
	
	$dbms = "mysql";//数据库类型
	$host = "localhost";//主机
	$db_username = "root";//数据库的用户名
	$db_password = "root";//数据库密码
	$db_table = "";//链接的数据表
	$dsn = "$dbms:host=$host;dbname=$db_table";//数据源
	
	try{
		$dbh = new PDO($dsn, $db_username, $db_password);//初始化一个PDO对象
		//echo "连接成功";
	}catch(PDOException $e){
		die("Error!:". $e->getMessage()."<br/>");
	}
	//长连接，最后加一个参数：array(PDO::ATTR_PERSISTENT => true)
	//$db = new PDO($dbn, $db_username, $db_password, array(PDO::ATTR_PERSISTENT => true));