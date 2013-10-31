<?php
/**
 * Service for index.php
 * Top part style 1 for index.php
 * This file have some CSS class or JS, please modify them for wanted style.
*/
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
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
<?php
$hatt_link_back = '#';
if (isset($_SESSION['l'])) {
	if ($_SESSION['l'] !== 'nul') {
		$hatt_link_back = '?l='.$_SESSION['l'];
		if (isset($_SESSION['next_sav'])) $hatt_link_back = $hatt_link_back.'&amp;next='.$_SESSION['next_sav'];
	}
	else {if (isset($_SESSION['next_sav'])) $hatt_link_back = '?next='.$_SESSION['next_sav'];}
}
if (isset($_SESSION['back_here'])) {
	$hatt_link_back = $_SESSION['back_here'];
	unset($_SESSION['back_here']);
}
//O=('-'Q) echo
echo '<a class="lab" href="index.php'.$hatt_link_back.'">Back</a>';
?>
</li>
</ul>
</div>
</div>