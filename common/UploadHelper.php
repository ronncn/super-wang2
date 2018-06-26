<?php
class UploadHelper
{
	private $path = "./uploads";//上传路径
	private $allowtype = array('jpg', 'gif', 'png');//限制上传文件的类型
	private $maxsize = 1000000;//限制文件上传的大小
	private $israndname = false;//是否随机重命名
	
	private $originName;
	private $tmpFileName;
	private $filePath;
	private $fileType;
	private $fileSize;
	private $newFileName;
	private $errorNum;
	private $errorMsg = "";
	
	
	function set($key, $val)
	{
		//把字符串大写转化为小写
		$key = strtolower($key);
		if(array_key_exists($key, get_class_vars(get_class($this))))
		{
			$this->setOption($key, $val);
		}
		return $this;
	}
	
	function upload($file)
	{
		$return = true;
		//检查文件地址合法性
		if(!$this->checkFilePath())
		{
			$this->errorMsg = $this->getError();
			return false;
		}
		$name = $_FILES[$file]['name'];
		$tmp_name = $_FILES[$file]['tmp_name'];
		$size = $_FILES[$file]['size'];
		$error = $_FILES[$file]['error'];
		
		if(is_array($name))
		{
			$errors = array();
			for ($i = 0; $i < count($name); $i++) {  
                /*设置文件信息 */  
                if ($this->setFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i])) {  
                    if (!$this->checkFileSize() || !$this->checkFileType()) {  
                        $errors[] = $this->getError();  
                        $return = false;  
                    }  
                } else {  
                    $errors[] = $this->getError();  
                    $return = false;  
                }  
                /* 如果有问题，则重新初使化属性 */  
                if (!$return)  
                    $this->setFiles();  
            }
		
			if($return)
			{
				$fileNames = array();
				for($i = 0; $i < count($name); $i++)
				{
					if($this->setFiles($name[$i], $tmp_name[$i], $size[$i],$error[$i]))
					{
						$this->setNewFileName();
						if(!$this->copyFile())
						{
							$errors[] = $this->getError();
							return false;
						}
						$fileName[] = $this->newFileName;
					}
				}
				$this->newFileName = $fileNames;
			}
			$this->errorMsg = $errors;
			return $return;
		}
		else
		{
			/* 设置文件信息 */
			if($this->setFiles($name,$tmp_name,$size,$error)) 
			{
			  /* 上传之前先检查一下大小和类型 */
			  if($this->checkFileSize() && $this->checkFileType())
			  { 
				/* 为上传文件设置新文件名 */
				$this->setNewFileName(); 
				/* 上传文件  返回0为成功， 小于0都为错误 */
				if($this->copyFile())
				{ 
				  return true;
				}
				else
				{
				  $return = false;
				}
			  }else
			  {
				$return = false;
			  }
			} else 
			{
			  $return = false; 
			}
			//如果$return为false, 则出错，将错误信息保存在属性errorMess中
			if(!$return)
			  $this->errorMess=$this->getError(); 
			return $return;
      }
	}
	
	public function getFileName()
	{
		return $this->newFileName;
	}
	
	public function getFilePath()
	{
		return $this->filePath;
	}
	
	public function getErrorMsg()
	{
		return $this->errorMsg;
	}
	
	/* 为单个成员属性设置值 */
	private function setOption($key, $val)
	{
		$this->$key = $val;
	}
	
	private function getError()
	{
		$str = "上传文件<font color='red'>{$this->originName}</font>时出错;";
		switch($this->errorNum)
		{
			case 4:
				$str .= " 没有文件被上传。";
				break;
			case 3:
				$str .= " 文件只有部分被上传。";
				break;
			case 2:
			case 1:
				$str .= " 超过上传文件的大小。";
				break;
			case -1:
				$str .= " 不允许上传的类型。";
				break;
			case -3:
				$str .= " 上传失败。";
				break;
			case -4:
				$str .= " 建立存放上传文件路径失败。";
				break;
			case -5:
				$str .= " 上传文件的路径错误。";
				break;
			default:
				$str .= " 未知错误。";
		}
		return $str ."<br />";
	}
	
	private function setFiles($name = "", $tmp_name = "", $size = 0, $error = 0)
	{
		$this->setOption('errorNum',$error);
		if($error)
			return false;
		$this->setOption('originName', $name);
		$this->setOption('tmpFileName', $tmp_name);
		$arrStr = explode('.', $name);
		$this->setOption('fileType', strtolower($arrStr[count($arrStr) - 1]));
		$this->setOption('fileSize', $size);
		return true;
	}
	
	private function setNewFileName()
	{
		if($this->israndname)
		{
			$this->setOption('newFileName', $this->proRandName());
		}
		else
		{
			$this->setOption('newFileName', $this->originName);
		}
	}
	
	private function checkFilePath()
	{
		//判断上传路径是否为空
		if(empty($this->path))
		{
			$this->setOption('errorNum', -5);
			return false;
		}
		//判断上传路径是否存在
		if(!file_exists($this->path) || !is_writable($this->path))
		{
			if(!@mkdir($this->path, 0755))
			{
				$this->setOption('errorNum', -4);
				return false;
			}
		}
		return true;
	}
	
	private function checkFileType()
	{
		if(in_array(strtolower($this->fileType), $this->allowtype))
		{
			return true;
		}
		else
		{
			$this->setOption('errorNum', -1);
			return false;
		}
	}
	
	private function checkFileSize()
	{
		if($this->fileSize > $this->maxsize)
		{
			$this->setOption('errorNum', -2);
			return false;
		}
		else
		{
			return true;
		}	
	}
	
	private function proRandName()
	{
		$fileName = date('YmdHis')."_".rand(100,999);
		return $fileName.'.'.$this->fileType;
	}
	
	private function copyFile()
	{
		if(!$this->errorNum)
		{
			$path = rtrim($this->path, '/').'/';
			$path .= $this->newFileName;
			if(@move_uploaded_file($this->tmpFileName, $path))
			{
				$this->filePath = $path;
				return true;
			}
		}
		else
		{
			return false;
		}
	}
	
	
}
?>