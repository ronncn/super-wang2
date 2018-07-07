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

function get_ip(){
    //判断服务器是否允许$_SERVER
    if(isset($_SERVER)){    
        if(isset($_SERVER[HTTP_X_FORWARDED_FOR])){
            $realip = $_SERVER[HTTP_X_FORWARDED_FOR];
        }elseif(isset($_SERVER[HTTP_CLIENT_IP])) {
            $realip = $_SERVER[HTTP_CLIENT_IP];
        }else{
            $realip = $_SERVER[REMOTE_ADDR];
        }
    }else{
        //不允许就使用getenv获取  
        if(getenv("HTTP_X_FORWARDED_FOR")){
              $realip = getenv( "HTTP_X_FORWARDED_FOR");
        }elseif(getenv("HTTP_CLIENT_IP")) {
              $realip = getenv("HTTP_CLIENT_IP");
        }else{
              $realip = getenv("REMOTE_ADDR");
        }
    }

    return $realip;
}      