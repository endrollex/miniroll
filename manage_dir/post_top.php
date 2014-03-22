<?php
/**
 * Top part of all management files, Service for login.php, post.php, post_view.php, upload.php, 
 * All management functions can not be direct visited, the entrance is ../manage.php
 * Notice: the working directory is the root of website
*/
//if direct visit, exit
if (!isset($manage_php)) exit();
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<script type="text/javascript" src="htmindex.js"></script>
<link rel="SHORTCUT ICON" href="images/icon_4.ico"/>
<title>miniroll management system</title>
<link href="htmindex.css" rel="stylesheet" type="text/css" />
<link href="f_assistant/prettify/prettify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="f_assistant/prettify/prettify.js"></script>
<script type="text/javascript" src="f_assistant/jwplayer/jwplayer.js"></script>
<style type="text/css">
textarea {font-size: 12px;}
input {font-size: 12px;}
</style>
</head>
<!--#..............................................................body-->
<body onload="prettyPrint();" class="body_manage">
<div class="div_normal" id="dom_index01"><!--trace.div_normal-->
<div class="post_div"><!--trace.post_div-->
<br/>miniroll management system | <a href="index.php">INDEX</a><br/>
<a href="manage.php?m=0">Post new</a> | 
<a href="manage.php?m=1">Post view or eidt</a> | 
<a href="manage.php?m=2">Upload file</a> | 
<a href="manage.php?m=3">Login</a><br/>
--------<br/>
<script type="text/javascript">
scr_post();
</script>