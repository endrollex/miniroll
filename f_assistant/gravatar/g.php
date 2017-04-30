<?php
/**
 * g.php
 * if gravatar can not be accessed, please change the setting manually.
*/
//
$gravatar_ok = true;
//
function get_gravatar_url($md5, $s = 64, $d = '', $r = 'g')
{
	$url = 'http://www.gravatar.com/avatar/';
	$url .= $md5;
	$url .= "?s=$s&d=$d&r=$r";
    return $url;
}
//
function get_gravatar_url_v2ex($md5, $s = 64, $d = '', $r = 'g')
{
	$url = 'http://cdn.v2ex.com/gravatar/';
	$url .= $md5;
	$url .= "?s=$s&d=$d&r=$r";
    return $url;
}
//
if (!$gravatar_ok) {
	$link_str = "/images/bad_gravatar.gif";
	header("Location: ".$link_str);
}
else {
	$md5 = 'd41d8cd98f00b204e9800998ecf8427e';
	if (isset($_GET['m'])) $md5 = $_GET['m'];
	$link_str = get_gravatar_url($md5);
	header("Location: ".$link_str);
}
?>