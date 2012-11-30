<?php
/**
**@author:xiaolong
**@date:2012-11-27
**
**
**/
class dealImage{
	
	private $_allowFileType = array(1,2,3);//允许上传的图片类型 1 = GIF，2 = JPG，3 = PNG
	private $_allowFileSize = 51200;//允许上传的图片大小 默认500kb
	private $_newFileName ;//新图片名称
	private $_savePath = 'uploadimage';//设置保存的文件路径
	private $_source ;//图片资源
	private $_imgWidth;//图片宽度
	private $_imgHieght;//图片高度
	private $_imgType;//图片类型
	private $_imgSize;//图片大小
	private $_imgName;

	function __construct($source,$name,$size,$newFileName,$savePath){
		$this->_source = $source;
		$this->_imgName = $name;
		$this->_imgSize = $size;
		$this->_newFileName = $newFileName;
		$this->_savePath = $savePath;
		list($this->_imgWidth,$this->_imgHieght,$this->_imgType) = $this->_getImgInfo();
		
		$this->_checkImgType();
		$this->_checkImgSize();
	}

	//检查图片类型
	private function _checkImgType(){
		if(!in_array($this->_imgType,$this->_allowFileType)){
			$imgStr = implode(',',$this->_allowFileType);
			return false;
			$str = $this->_msg('上传的图片类型只允许'.$imgStr.' 这几种格式',0);
			exit($str);
		}
	}
	
	//检查图片大小
	private function _checkImgSize(){
		if( ($this->_imgSize) > ($this->_allowFileSize) ){
			$allowSize = $this->_allowFileSize/1024;
			exit($this->_msg('上传的图片不能大于'.$allowSize.'kb',0));
		}
	}

	//获取图片宽 高  类型 
	private function _getImgInfo(){
		return getimagesize($this->_source);
	}
	
	//图片 缩放 算法
	// $maxWidth 要 缩放 如果传入的最大宽度  和高度 多比原图的要大 则 返回原图的大小,不做处理
	private function _resizeImg($maxWidth,$maxHeight){
		if( ($maxWidth && $this->_imgWidth>$maxWidth) || ($maxHeight && $this->_imgHieght>$maxHeight) ){
			if($maxWidth && $this->_imgWidth>$maxWidth ){ //原图宽度大于最大宽度   
				$widthratio = $maxWidth/$this->_imgWidth;
				$resizewidth_tag = true;
			}

			if($maxHeight && $this->_imgHieght>$maxHeight){ //原图高度大于最大高度
				$heightratio = $maxHeight/$this->_imgHieght;
				$resizeheight_tag = true;
			}

			if( $resizewidth_tag && $resizeheight_tag ){ //新图的宽度和高度多比原图小
				if($widthratio<$heightratio){ //那个比较小就说明它的长度要长，就取哪条，以长边为准缩放保证图片不被压缩    
					$ratio = $widthratio;
				}else{
					$ratio = $heightratio;
				}
			}

			if($resizewidth_tag && !$resizeheight_tag){
				$ratio = $widthratio;
			}
			
			if($resizeheight_tag && !$resizewidth_tag){
				$ratio = $heightratio;
			}
			$arr = array();
			$arr['width'] = ($this->_imgWidth) * $ratio;
			$arr['height'] = ($this->_imgHieght) * $ratio;
			return $arr;
		}else{
			return array('width'=>$this->_imgWidth,'height'=>$this->_imgHieght);
		}
	}

	//创建文件夹
	private function _createFolders($dir){ 
		return is_dir($dir) or ($this->_createFolders(dirname($dir)) and mkdir($dir, 0777)); 
	}

	//获取文件后缀名
	private function _getSufix(){
		$pathArr = pathinfo($this->_imgName); 
		return strtolower($pathArr['extension']);
	}

	//返回图片要保存的路径
	private function _getDestination(){
		return $this->_savePath.'/'.$this->_newFileName.'.'.$this->_getSufix();
	}

	//获取图像载入函数
	private function _getImgFrom(){
		$imgType = $this->_imgType;
		$str = 'imagecreatefrom';
		switch($imgType){
			case 1:
				$imgFunction = $str.'gif';
				break;
			case 2:
				$imgFunction = $str.'jpeg';
				break;
			case 3:
				$imgFunction = $str.'png';
				break;
		}
		return $imgFunction;
	}


	//保存原图不处理
	public function saveImg(){
		$this->_createFolders($this->_savePath);//创建文件夹
		$destination = $this->_getDestination();
		$flag = move_uploaded_file($this->_source,$destination);
		if($flag){
			return $this->_msg('上传成功',1,$destination);
		}else{
			return  $this->_msg('上传失败',0);
		}
	}

	//缩略图片
	//$maxWidth 缩略的最大宽度 $maxHeight 缩略的最大高度,$rate 生成的质量 imagejpeg专有
	public function thumbImg($maxWidth,$maxHeight,$rate=100){
		
		$imageCreateFrom = $this->_getImgFrom();
		$img = $imageCreateFrom($this->source);

		list($width,$height) =  $this->_resizeImg($maxWidth,$maxHeight);
		$newImg = imagecreatetruecolor($width,$height);
		
		imagecopyresampled($newImg,$img,0,0,0,0,$width,$height,$width,$height);
		
		$this->_createFolders($this->_savePath);//创建文件夹
		$destination = $this->_getDestination();

		imagejpeg($newImg,$destination,$rate); # 生成缩略图;
		imagedestroy($newImg);
		imagedestroy($img); 
		return $this->_msg('上传成功',1,$destination);
		
	}


	//提示信息 返回JSON数据
	//$param $msg 提示信息,$flag标识 0错误,1成功,$imgUrl 上传成功返回的图片路径
	private function _msg($msg,$flag=1,$imgUrl=null){
		$str = json_encode(array('msg'=>$msg,'flag'=>$flag,'imgUrl'=>$imgUrl));
		return  $str;
	}

	
}
