<?php
    //包含一个文件上传类中的上传类  
    include "../common/UploadHelper.php";
    $up = new UploadHelper;  
	
    $up->set("path", "../uploadProject/");  
    $up->set("maxsize", 2000000);  
    $up->set("allowtype", array("zip", "rar", "7Z"));
	
	if($up->upload("file"))
	{
        echo $up->getFilePath();
    }
	else 
	{
        //获取上传失败以后的错误提示  
        var_dump($up->getErrorMsg());
    } 