<?php
//if direct visit, exit
if (!isset($manage_php)) exit();
?>
<?php
function hash_lock(&$lock_str) {
	$salt1 = '7G2mF~ZOcRf!%u]8IY-(K(2eua0Jd4';
	return sha1(sha1($salt1.$lock_str));
}
?>