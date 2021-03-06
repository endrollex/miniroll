<?php
/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
// g.php generate avatar
function get_gravatar($email, $s = 64, $d = '', $r = 'g')
{
	$url = 'f_assistant/gravatar/g.php?';
	$url .= "m=".md5(strtolower(trim($email)));
    return $url;
}
// not use
/*
function get_gravatar2($email, $s = 64, $d = '', $r = 'g')
{
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5(strtolower(trim($email)));
	$url .= "?s=$s&amp;d=$d&amp;r=$r";
    return $url;
}
*/
?>