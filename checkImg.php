<?php    
header("Content-Type:text/html;charset=utf-8");    
$im = imagecreatefromjpeg('oldsrc.jpg');    
$maxwidth = 75;    
$maxheight = 75;    
$name = 'newpic';    
$filetype = '.jpg';    
$pic_width = imagesx($im);    
$pic_height = imagesy($im);    

if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))    
{    
	if($maxwidth && $pic_width>$maxwidth)   //原图宽度大于最大宽度    
	{    
		$widthratio = $maxwidth/$pic_width;    
		$resizewidth_tag = true;    
	}    

	if($maxheight && $pic_height>$maxheight) //原图高度度大于最大高度    
	{    
		$heightratio = $maxheight/$pic_height;    
		$resizeheight_tag = true;    
	}    

	if($resizewidth_tag && $resizeheight_tag)   //如果新图片的宽度和高度都比原图小    
	{    
		if($widthratio<$heightratio)        //那个比较小就说明它的长度要长，就取哪条，以长边为准缩放保证图片不被压缩    
			$ratio = $widthratio;    
		else    
			$ratio = $heightratio;    
	}    

	if($resizewidth_tag && !$resizeheight_tag)    
		$ratio = $widthratio;    
	if($resizeheight_tag && !$resizewidth_tag)    
		$ratio = $heightratio;    

	$newwidth = $pic_width * $ratio;            //原图的宽度*要缩放的比例    
	$newheight = $pic_height * $ratio;          //原图高度*要缩放的比例    
		
	if(function_exists("imagecopyresampled"))    
	{    
		$newim = imagecreatetruecolor($newwidth,$newheight);    //生成一张要生成的黑色背景图 ，比例为计算出来的新图片比例    
		imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);  //复制按比例缩放的原图到 ，新的黑色背景中。    
	}    
	else    
	{    
		$newim = imagecreate($newwidth,$newheight);    
		imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);    
	}    

	$name = $name.$filetype;    
	imagejpeg($newim,$name);    
	imagedestroy($newim);    
}    
else    
{    
	$name = $name.$filetype;    
	imagejpeg($im,$name);    
    }            
?>    