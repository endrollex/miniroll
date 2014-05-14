<?php
/**
 * Service for index.php
 * Top part style 1 for index.php
 * This file has some CSS class or JS, please modify them for wanted style.
*/
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<script type="text/javascript">
<?php
//$_SESSION['view']: save view option
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
	if (($_SESSION['view'] & 2) == 2) echo 'var force_is_mobile = 4;';
	else echo 'var force_is_mobile = 5;';
}
else echo 'var force_is_mobile = 3;';
?>
</script>
<script type="text/javascript" src="htmindex.js"></script>
<?php
//meta and title
$hatt_meta_k = 'need_index';
if (isset($meta_keywords)) $hatt_meta_k = $meta_keywords;
$hatt_meta_d = '';
if (isset($meta_description)) {
	if ($meta_description !== '') $hatt_meta_d = $meta_description;
}
$echo_tit_top = 'index_top.php';
if (isset($echo_title)) $echo_tit_top = $echo_title;
//O=('-'Q) echo
echo '<meta name="keywords" content="'.$hatt_meta_k.'" />';
echo '<meta name="description" content="'.$hatt_meta_d.'" />';
echo '<link rel="SHORTCUT ICON" href="images/icon_4.ico"/>';
echo '<title>'.$echo_tit_top.'</title>';
//
?>
<link href="htmindex.css" rel="stylesheet" type="text/css" />
<link href="f_assistant/prettify/prettify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="f_assistant/prettify/prettify.js"></script>
<script type="text/javascript" src="f_assistant/jwplayer/jwplayer.js"></script>
</head>
<body onload="prettyPrint();" class="body_index">
<div class="div_home_set"><!--trace.div_home_set-->
<div class="div_cpp01">
<div class="div_cpp01_home">
<ul class="ul_top01">
<li class="li_top01"><a class="lab" href="index.php">Home</a></li>
<li class="li_top01"><a class="lab" href="index.php?p=000099999998_mf_">Search</a></li>
<li class="li_top01"><a class="lab" href="index.php?p=000100000000_mf_sk_">Album</a></li>
<li class="li_top01"><a class="lab" href="index.php?l=do">Download</a></li>
<li class="li_top01"><a class="lab" href="index.php?p=000099999999_mi_">About</a></li>
<li class="li_top01">
</li>
</ul>
</div>
</div>