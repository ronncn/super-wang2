<?php
    //包含一个文件上传类中的上传类  
    include "../common/UploadHelper.php";
    $up = new UploadHelper;  
	
    $up->set("path", "../uploadProject/");  
    $up->set("maxsize", 2000000);  
    $up->set("allowtype", array("zip"));
	
	if($up->upload("file"))
	{
		require_once('../common/pclzip.lib.php');
        $archive = new PclZip($up->getFilePath());
		$path = $up->getUploadPath().substr($up->getFileName(),0, -4)."/";
		if(!is_dir($path))
		{
			if(!@mkdir($path, 0755))
			{
				$up->set('errorNum', -4);
			}
		}
		if($archive->extract(PCLZIP_OPT_PATH, $path) == 0)
		{
			echo "解压缩失败！";
		}
		else
		{
			$return['file_path'] = "http://".$_SERVER['HTTP_HOST'].substr($up->getFilePath(),2);
			$return['file_addr'] = "http://".$_SERVER['HTTP_HOST'].substr($path,2);
			echo json_encode($return);
		}
    }
	else 
	{
        //获取上传失败以后的错误提示  
        var_dump($up->getErrorMsg());
    } 