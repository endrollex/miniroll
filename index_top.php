<?php
/**
 * Service for index.php
 * Top part style 1 for index.php
*/
?>
<?php
//
$http_str = <<<EOT
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<script type="text/javascript">
EOT;
//
//here is the view control setting, the setting is both in index_top.php, post_top.php
//$_SESSION['view']: save view option
//$_GET['once_glance']: once open with glance view, value is arbitrary
if (!isset($_SESSION['view'])) $_SESSION['view'] = 15;
if (isset($_GET['view'])) {
	if ($_GET['view'] == 'title') $_SESSION['view'] |= 1;
	if ($_GET['view'] == 'glance') $_SESSION['view'] &= 14;
	if ($_GET['view'] == 'auto') $_SESSION['view'] |= 4;
	if ($_GET['view'] == 'pc') {$_SESSION['view'] &= 11; $_SESSION['view'] |= 2;}
	if ($_GET['view'] == 'mobile') {$_SESSION['view'] &= 11; $_SESSION['view'] &= 13;}
}
//force_is_mobile: 3 = auto, 4 = pc, 5 = mobile
if (($_SESSION['view'] & 4) == 0) {
	if (($_SESSION['view'] & 2) == 2) $http_str .= 'var force_is_mobile = 4;';
	else $http_str .= 'var force_is_mobile = 5;';
}
else $http_str .= 'var force_is_mobile = 3;';
//
$http_str .= <<<EOT
</script>
<script type="text/javascript" src="htmindex.js"></script>
EOT;
//
//meta and title
$hatt_meta_k = 'need_index';
if (isset($meta_keywords)) $hatt_meta_k = $meta_keywords;
$hatt_meta_d = '';
if (isset($meta_description)) {
	if ($meta_description !== '') $hatt_meta_d = $meta_description;
}
$echo_tit_top = 'index_top.php';
if (isset($echo_title)) $echo_tit_top = $echo_title;
$http_str .= '<meta name="keywords" content="'.$hatt_meta_k.'" />';
$http_str .= '<meta name="description" content="'.$hatt_meta_d.'" />';
$http_str .= '<link rel="SHORTCUT ICON" href="images/icon_4.ico"/>';
$http_str .= '<title>'.$echo_tit_top.'</title>';
//
$http_str .= <<<EOT
<link href="htmindex.css" rel="stylesheet" type="text/css" />
<link href="f_assistant/prettify/prettify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
scr_viewp();
</script>
<script type="text/javascript" src="f_assistant/prettify/prettify.js"></script>
<script type="text/javascript" src="f_assistant/jwplayer/jwplayer.js"></script>
<script>jwplayer.key="PKUFi8TSuWCndKmcSYGHaEAHYc+Hh9VgjhrkbQ==";</script>
</head>
<body onload="prettyPrint();" class="body_index" style="background-image: url('images/back_color.gif');	background-repeat: repeat-x; background-position: top center;">
<div class="div_home_set" id="dom_div_home_set"><!--trace.div_home_set-->
<div class="div_cpp01" id="dom_div_cpp01">
<div class="div_cpp01_home">
<ul class="ul_top01" id="dom_ul_top01">
<li class="li_top01"><a class="lab2" href="index.php">Home</a></li>
<li class="li_top01"><a class="lab2" href="index.php?p=000099999998_mf_">Search</a></li>
<li class="li_top01"><a class="lab2" href="index.php?l=al&amp;once_glance=1">Album</a></li>
<li class="li_top01"><a class="lab2" href="index.php?l=do">Download</a></li>
<li class="li_top01"><a class="lab2" href="index.php?p=000099999999_mi_">About</a></li>
</ul>
</div>
<a href="index.php"><img alt="blog_name" height="31" class="img_top01" src="images/blog_name.gif" width="344" /></a>
</div>
EOT;
//
?>