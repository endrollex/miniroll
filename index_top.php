<?php
/**
 * Top bar style 1 for index.php
 * This file have some CSS class or JS, please modify them for wanted style.
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="zh-cn" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<script type="text/javascript" src="htmindex.js"></script>
<?php
//meta and title
session_start();
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
echo '<title>'.$echo_tit_top.'</title>';
//copy above to index.top2.php
?>
<link href="htmindex.css" rel="stylesheet" type="text/css" />
<link href="f_assistant/prettify/prettify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="f_assistant/prettify/prettify.js"></script>
<script type="text/javascript" src="f_assistant/jwplayer/jwplayer.js"></script>
</head>
<body onload="prettyPrint();" class="body_index">
<div class="div_home_set""><!--trace.div_home_set-->
<div class="div_cpp01">
<div class="div_cpp01_home">
<ul class="ul_top01">
<li class="li_top01"><a class="lab" href="index.php">Home</a></li>
<li class="li_top01"><a class="lab" href="index.php?p=000099999998_mi_mf_">Search</a></li>
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
echo '<a class="lab" href="index.php'.$hatt_link_back.'">&lt;-Back</a>';
?>
</li>
</ul>
</div>
</div>