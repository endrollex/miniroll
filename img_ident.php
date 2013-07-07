<?php
/**
 * Service for comment.php
 * PHP environment require: GD library
 * Create a image, determine whether or not the user is human
*/
header('Content-type: image/png');
session_start();
//input require $_SESSION['rand_img']
//font
date_default_timezone_set('Etc/GMT-8');
//change font function
function c_font(&$font_use, &$font_ix) {
	switch ($font_ix) {
		case 0: $font_use = 'font/arial.ttf'; break;
		case 1: $font_use = 'font/cour.ttf'; break;
		case 2: $font_use = 'font/tahoma.ttf'; break;
		case 3: $font_use = 'font/verdana.ttf'; break;
		case 4: $font_use = 'font/times.ttf'; break;
	}
}
$font_ix = mt_rand(0, 4);
$font_use = '';
c_font($font_use, $font_ix);
$font_si1 = 14;
$font_si2 = 14;
//word
$s_ident = '';
$s_pattern = '';
if (isset($_SESSION['rand_img'])) {
	$s_ident = $_SESSION['rand_img'][0];
	$s_pattern = $_SESSION['rand_img'][1];
}
//color
$img = imagecreatetruecolor(120, 30);
$c_r1= mt_rand(0, 192);
$c_r2= mt_rand(0, 192);
$c_r3= mt_rand(0, 192);
$clor1 = imagecolorallocate($img, $c_r1, $c_r2, $c_r3);
$white = imagecolorallocate($img, 255, 255, 255);
imagefill($img, 0, 0, $clor1);
//border
imagesetpixel($img, 0, 0, $white);
imagesetpixel($img, 1, 0, $white);
imagesetpixel($img, 0, 1, $white);
imagesetpixel($img, 118, 0, $white);
imagesetpixel($img, 119, 0, $white);
imagesetpixel($img, 119, 1, $white);
imagesetpixel($img, 0, 28, $white);
imagesetpixel($img, 0, 29, $white);
imagesetpixel($img, 1, 29, $white);
imagesetpixel($img, 118, 29, $white);
imagesetpixel($img, 119, 29, $white);
imagesetpixel($img, 119, 28, $white);
//position
$i_angle = mt_rand(-2, 2);
$start_x = mt_rand(0, 3);
$start_y = mt_rand(16, 20);
$sid_len = strlen($s_ident);
$start_x = 1*(16-$sid_len)+$start_x;
imagettftext($img, $font_si1, $i_angle, $start_x+2, $start_y+2, $white, $font_use, $s_ident);
imagettftext($img, $font_si1, $i_angle, $start_x, $start_y, $clor1, $font_use, $s_ident);
imagettftext($img, $font_si2, $i_angle, $start_x-1, $start_y-1, $clor1, 'font/cour.ttf', $s_pattern);
imagepng($img);
imagedestroy($img);
?>