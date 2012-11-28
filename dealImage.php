<?php
/**
**@author:xiaolong
**@date:2012-11-27
**
**
**/
class dealImage{
	
	private $_allowFileType = array(1,2,3);//允许上传的图片类型 1 = GIF，2 = JPG，3 = PNG
	private $_allowFileSize = 500*1024;//允许上传的图片大小
	public  $newFileName = time();//新图片名称
	public  $savePath = date('Y').'/'.date('m').'/'.date('d');//设置保存的文件路径
	private $_source ;//图片资源
	private $_imgWidth;//图片宽度
	private $_imgHieght;//图片高度
	private $_imgType;//图片类型
	private $_imgSize;//图片大小

	function __construct($source,$size){
		$this->_source = $source;
		$this->_imgSize = $size;
		list($this->_imgWidth,$this->_imgHieght,$this->_imgType) = $this->_getImgInfo();
		$this->_checkImgType();
		$this->_checkImgSize();


	}

	//检查图片类型
	private function _checkImgType(){
		if(!in_array($this->_imgType,$this->_allowFileType)){
			$imgStr = implode(',',$this->_allowFileType);
			return $this->_msg('上传的图片类型只允许'.$imgStr.' 这几种格式',0);
		}
	}
	
	//检查图片大小
	private function _checkImgSize(){
		if( ($this->_imgSize) > ($$this->_allowFileSize) ){
			$allowSize = $this->_allowFileSize/1024;
			return $this->_msg('上传的图片不能大于'.$allowSize.'kb',0);
		}
	}

	//获取图片宽 高  类型 
	private function _getImgInfo(){
		return getimagesize($this->source);
	}
	
	//图片 缩放 算法
	// $maxWidth 要 缩放
	private function _resizeImg($maxWidth,$maxHeight){
		
	}


	//提示信息 返回JSON数据
	//$param $msg 提示信息,$flag标识 0错误,1成功,$imgUrl 上传成功返回的图片路径
	private function _msg($msg,$flag=1,$imgUrl=null){
		return  array('msg'=>$msg,'flag'=>$flag,'imgUrl'=>$imgUrl);
	}

	
}
