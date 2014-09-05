<?php
/*
Plugin Name: Save Yupoo Imgs To Local
Plugin URI: http://www.brunoxu.com/save-yupoo-imgs-to-local.html
Description: 保存又拍(yupoo)图片到本地目录，全文查找图片并替换
Author: Bruno Xu
Author URI: http://www.brunoxu.com/
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

$upload_dir = wp_upload_dir();
$save_yupoo_imgs_path = $upload_dir['basedir'] . '/yupoo_imgs/';
$save_yupoo_imgs_purl = $upload_dir['baseurl'] . '/yupoo_imgs/';

$action = 'get_header';
add_action($action, 'save_yupoo_imgs_obstart', 20);
function save_yupoo_imgs_obstart() {
	ob_start('save_yupoo_imgs_obend');
}

function save_yupoo_imgs_obend($content) {
	return save_yupoo_imgs_filter($content);
}

function save_yupoo_imgs_filter($content)
{
	$regexp = "/<a[^<>]+href=['\"](http:\/\/pic.yupoo.com\/[^'\"]+)['\"][^<>]*>/i";
	$content = preg_replace_callback(
		$regexp,
		"save_yupoo_imgs_str_handler",
		$content
	);

	$regexp = "/<img[^<>]+src=['\"](http:\/\/pic.yupoo.com\/[^'\"]+)['\"][^<>]*>/i";
	$content = preg_replace_callback(
		$regexp,
		"save_yupoo_imgs_str_handler",
		$content
	);

	return $content;
}

function save_yupoo_imgs_str_handler($matches)
{	
	$str = $matches[0];
	$img_src = $matches[1];
	$newimg_src = save_yupoo_imgs_str_handler_2($img_src);
	
	if ($img_src == $newimg_src) {
		return $str;
	} else {
		return str_replace($img_src, $newimg_src, $str);
	}
}

/*
a  http://pic.yupoo.com/xiaoxu125634/Cw6swQp5/ZQTxk.jpg
img  http://pic.yupoo.com/xiaoxu125634/Cw6swQp5/medium.jpg
*/
function save_yupoo_imgs_str_handler_2($img_src)
{
	global $save_yupoo_imgs_path, $save_yupoo_imgs_purl;

	$newimg_subname = str_ireplace('http://pic.yupoo.com/','',$img_src); 
	$newimg_path = $save_yupoo_imgs_path.$newimg_subname;
	$newimg_src = $save_yupoo_imgs_purl.$newimg_subname;
	$newimg_folder = substr($newimg_path, 0, strrpos($newimg_path,'/')+1);

	if (file_exists($newimg_path)) {
		return $newimg_src;
	}

	if (! file_exists($newimg_folder)) {
		mkdir($newimg_folder, 0755, true);
	}
	$get_file = file_get_contents($img_src);
	if (! $get_file) {
		return $img_src;
	}
	$fp = fopen($newimg_path, 'w');
	fwrite($fp, $get_file);
	fclose($fp);

	return $newimg_src;
}
