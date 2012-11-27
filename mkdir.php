<?php
/**
 * YiiBase class file.
 *
 * @author xiaolong 
 * @link 
 * @copyright Copyright &copy; 012  Software LLC
 * @license 
 * @version 
 * @package 
 * @since 1.0
 * @date:2012-11-27
 * @desc: PHP创建文件夹
 */
 function createDir($dir){
	return mkdir($dir,0777,true);//PHP5.0以上 递归的创建文件夹
 };

//echo createDir('test/'.date('Y').'/'.date('m'));


function mkdirs($dir, $mode = 0777)

{

if (is_dir($dir) || mkdir($dir, $mode)) return TRUE;

if (!mkdirs(dirname($dir), $mode)) return FALSE;

return mkdir($dir, $mode);

}
//mkdirs('dddd/aaa/sss');

function create_folders($dir){ 

    return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777)); 
	
}

create_folders('cs/111/ddd');

mkdir('33333/222',0777);