<?php
/**
 * The guest comment main module
 *
 * Require files:
 *     comment_w.php: Comment form
 *     img_ident.php: Generate a image
 *     font/cet4_s.txt: The words list for generate image
 *     font/x.ttf: Font files
 *     az_comment/lock: Prevent concurrent
 *     az_comment/log/: The comment log dir
 *
 * Third party codes:
 *     f_assistant/gravatar: Gravatar, get avatar image
 *
 * Copyright 2013 Huang Yiting (http://endrollex.com)
 * miniroll is distributed under the terms of the GNU General Public License
*/
?>
<div class="div_com1">
<?php
//gravatar
$is_gravatar = false;
if (file_exists('f_assistant/gravatar/gravatar.php')) {require('f_assistant/gravatar/gravatar.php'); $is_gravatar = true;}
//comment log function
$comm_log_p = 'az_comment/log/comm_log';
$comm_log_maxsize = 1000000;
function comm_log(&$comm_log_p, &$comm_log_maxsize, &$post_co_email, $post_co_tit) {
	$comm_log = $comm_log_p.'.php';
	if (file_exists($comm_log))
		if (filesize($comm_log) > $comm_log_maxsize) {
			$temp_str = date('YmdHis', time());
			$comm_log_hist = $comm_log_p.'_'.$temp_str.'.php';
			$temp_read = file_get_contents($comm_log);
			file_put_contents($comm_log_hist, $temp_read);
			file_put_contents($comm_log, '');
	}
	$fp = fopen($comm_log, 'ab');
	if ($fp) {
		$temp_str = "<?php\r\n//";
		$temp_str .= date('Y-m-d H:i:s', time());
		$temp_str .= ','.$post_co_email;
		$temp_str .= ','.$post_co_tit;
		$temp_str .= "\r\n?>\r\n";
		fwrite($fp, $temp_str);
		fclose($fp);
	}
}
//var
$com_dir = 'az_comment/';
if (isset($dir_comment)) $com_dir = $dir_comment;
$comm_file = '';
$comm_count_file = '';
$comm_size = 0;
//read comment count
if (isset($_SESSION['view_file_c'])) {
	$comm_file = $com_dir.$_SESSION['view_file_c'].'c';
	$comm_count_file = $comm_file.'_count';
	if (file_exists($comm_count_file)) $comm_size = file_get_contents($comm_count_file);
}
//temp input
if (isset($_POST['co_tit'])) $_SESSION['co_tit'] = $_POST['co_tit'];
if (isset($_POST['co_cont'])) $_SESSION['co_cont'] = $_POST['co_cont'];
if (isset($_POST['co_link'])) $_SESSION['co_link'] = $_POST['co_link'];
//check img
$check_all_ok = false;
$check_tit = false;
$check_link = false;
$check_cont = false;
$check_ident = false;
$check_email = false;
//$_SESSION['com_msg'] pos0-4: title, url, content, img_identify, email
$_SESSION['com_msg'] = array('', '', '', '', '');
//check img identify
if (isset($_POST['c_ident']) && isset($_SESSION['rand_img'])) {
	$img_sign = ' !== ';
	$img_succ = '<span class="span_red">Verify faile: ';
	$_POST['c_ident'] = strtolower(htmlspecialchars(trim($_POST['c_ident']), ENT_QUOTES));
	if ($_POST['c_ident'] === $_SESSION['rand_img'][0]) {
		$check_ident = true;
		$img_sign = ' === ';
		$img_succ = '<span>Verify OK: ';
	}
	$_SESSION['com_msg'][3] = $img_succ.$_POST['c_ident'].$img_sign.$_SESSION['rand_img'][0].'</span><br/>';
	if (strlen($_POST['c_ident']) == 0 || strlen($_POST['c_ident']) > 18)
		$_SESSION['com_msg'][3] = $img_succ.'Please enter the echo word.</span>';
}
//check title
if (isset($_POST['co_tit'])) {
	$_POST['co_tit'] = htmlspecialchars(trim($_POST['co_tit']), ENT_QUOTES);
	if (strlen($_POST['co_tit']) < 2) $_SESSION['com_msg'][0] = '<span class="span_red">Name too short</span>';
	if (strlen($_POST['co_tit']) > 30) $_SESSION['com_msg'][0] = '<span class="span_red">Name too long</span>';
	if ($_SESSION['com_msg'][0] === '') {
		$check_tit = true;
		$_POST['co_tit'] = nl2br($_POST['co_tit']);
	}
}
//check link
$find_html_a = array('"', '\'', '<', '>', ' ', "\t", "\n", "\r", "\0", "\x0B");
if (isset($_POST['co_link'])) {
	$_POST['co_link'] = strtolower(trim($_POST['co_link']));
	$_POST['co_link'] = str_replace($find_html_a, '', $_POST['co_link']);
	if (strlen($_POST['co_link']) > 128) $_SESSION['com_msg'][1] = '<span class="span_red">URL too long</span>';
	else $check_link = true;
}
//check content
if (isset($_POST['co_cont'])) {
	$_POST['co_cont'] = htmlspecialchars(trim($_POST['co_cont']), ENT_QUOTES);
	if (strlen($_POST['co_cont']) < 2) $_SESSION['com_msg'][2] = '<span class="span_red">Content too short</span>';
	$co_cont_max = 1000;
	if (strlen($_POST['co_cont']) > $co_cont_max*3) $_SESSION['com_msg'][2] = '<span class="span_red">Content too long, max: '.$co_cont_max.'</span>';
	if ($_SESSION['com_msg'][2] === '') {
		$check_cont = true;
	}
}
//check email
if (isset($_POST['co_email'])) {
	$_POST['co_email'] = strtolower(trim($_POST['co_email']));
	$_POST['co_email'] = str_replace($find_html_a, '', $_POST['co_email']);
	if (strlen($_POST['co_email']) > 128) $_SESSION['com_msg'][4] = '<span class="span_red">Email too long</span>';
	else $check_email = true;
}
//check all
$comm_data = '';
if ($check_ident && $check_tit && $check_link && $check_cont && $check_email) {
	//stripslashes
	if (get_magic_quotes_gpc()) {
		$_POST['co_cont'] = stripslashes($_POST['co_cont']);
		$_POST['co_tit'] = stripslashes($_POST['co_tit']);
	}
	$ftime = date('ymdHi', time());
	$time_txt = '20'.substr($ftime, 0, 2).'-'.substr($ftime, 2, 2).'-'.substr($ftime, 4, 2);
	$time_txt = $time_txt.' '.substr($ftime, 6, 2).':'.substr($ftime, 8, 2);
	$_POST['co_cont'] = nl2br($_POST['co_cont']);
	//add http
	$show_flink = false;
	if ($_POST['co_link'] !== '') $show_flink = true;
	if ($show_flink) {
		$have_http = '#^[a-z]{0,10}://#';
		$match_res = array();
		preg_match($have_http, $_POST['co_link'], $match_res);
		if (count($match_res) === 0) $_POST['co_link'] = 'http://'.$_POST['co_link'];
	}
	//add html tag
	$comm_data = '<div class="div_commc">';
	//gravatar
	if ($is_gravatar) {
		$comm_data .= '<div class="div_com_ava">'."\r\n".'<img alt="" src="';
		$comm_data .= get_gravatar($_POST['co_email']);
		$comm_data .= '" />'."\r\n".'</div>';
	}
	//
	if ($show_flink) {
		$comm_data .= '<a class="user" href="'.$_POST['co_link'].'" target="_blank">'."\r\n";
		$comm_data .= $_POST['co_tit'].': </a>'."\r\n";
	}
	else {
		$comm_data .= '<span class="span_com_tit">'.$_POST['co_tit'].': </span>'."\r\n";
	}
	$comm_data .= '<span class="span_commc">'.$_POST['co_cont'].
		'</span>'."\r\n".'<div class="div_com_time">'
		.'<span class="span_comsize">['.$comm_size.']</span>'.$time_txt.'</div></div>'."\r\n<!--comm_end-->\r\n";
	$check_all_ok = true;
}
//chunk comments, every $chunk_value in a file
$chunk_value = 50;
$html_comm_readfile = '';
if (file_exists($comm_file)) $html_comm_readfile = file_get_contents($comm_file);
$second_new = ($comm_size-$comm_size%$chunk_value)/$chunk_value;
$second_newfile = $comm_file.$second_new;
$cf_fix = 0;
if ($comm_size%$chunk_value === 0) $cf_fix = $comm_size/$chunk_value;
$comm_file_rename = $comm_file.$cf_fix;
//lock stat
$comm_stat_msg = '';
$go_write = false;
$lock_stat_f = $com_dir.'lock';
$lock_f_exists = file_exists($lock_stat_f);
if ($check_all_ok && $lock_f_exists && ($comm_file !== '')) {
	$lock_txt = file_get_contents($lock_stat_f);
	if ($lock_txt === '') {
		file_put_contents($lock_stat_f, 'can_write');
		$lock_txt = file_get_contents($lock_stat_f);
	}
	if ($lock_txt === 'can_write') {
		file_put_contents($lock_stat_f, 'current_lock');
		$go_write = true;
	}
	else $comm_stat_msg = '<span class="span_red">Exceed the number of concurrent, try again later.</span>';
}
else {
	if (!$check_all_ok) {
		if (isset($_POST['co_tit'])) $comm_stat_msg = '<span class="span_red">Please enter the required info.</span>';
	}
	else {
		if (!$lock_f_exists) $comm_stat_msg = '<span class="span_red">lock file not exists, comment function error.</span>';
		else if ($comm_file === '') $comm_stat_msg = '<span class="span_red">The post is not exists.</span>';
	}
}
//go write comment
if ($go_write) {
	$put_ok = true;
	if ($cf_fix === 0) {
		$html_comm_readfile = $comm_data.$html_comm_readfile;
		$put_ok = file_put_contents($comm_file, $html_comm_readfile);
	}
	else {
		rename($comm_file, $comm_file_rename);
		$put_ok = file_put_contents($comm_file, $comm_data);
		$html_comm_readfile = $comm_data;
	}
	if ($put_ok !== false) {
		++$comm_size;
		file_put_contents($comm_count_file, $comm_size);
		$comm_stat_msg = '<span class="span_blue">Thanks for comment.</span>';
		unset($_SESSION['co_tit']);
		unset($_SESSION['co_cont']);
		unset($_SESSION['co_link']);
		unset($_SESSION['co_email']);
	}
	file_put_contents($lock_stat_f, 'can_write');
	comm_log($comm_log_p, $comm_log_maxsize, $_POST['co_email'], $_POST['co_tit']);
}
//read comments
//O=('-'Q) echo and readfile
echo '<span class="span_l4b"><a name="commtop">Comments: </a>'.$comm_size.'</span><br/><br/>';
if ($comm_file !== '') {
	if ($html_comm_readfile === '') $html_comm_readfile = '<span class="span_l4">-</span><br/>';
	echo $html_comm_readfile;
	if ($second_new !== 0) if (file_exists($second_newfile)) readfile($second_newfile);
	//show all file
	if ($second_new > 1) {
		//max view
		$max_view = 0;
		if ($second_new > 32) $max_view = $second_new-32;
		for ($ix_comm = $second_new-1; $ix_comm !== $max_view; --$ix_comm) {
			if (file_exists($comm_file.$ix)) readfile($comm_file.$ix);
		}
	}
}
//rand send
$rand_send = array();
$e_words = file('font/cet4_s.txt');
$ew_size = count($e_words)-1;
$s_ident = rtrim($e_words[mt_rand(0, $ew_size)]);
$s_pattern = rtrim($e_words[mt_rand(0, $ew_size)]);
array_push($rand_send, $s_ident);
array_push($rand_send, $s_pattern);
$_SESSION['rand_img'] = $rand_send;
//href link
$c_link = '#';
if (isset($_GET['p'])) {
	$c_link = 'index.php?p='.$_GET['p'].'&amp;copost=1#comm';
}
?>
<div>
<div class="div_com_page">Echo all comments</div>
<div class="div_com_top">
<a name="comm" href="#comm" class="page" onclick="
document.getElementById('comment_form01').style.display='inline';
document.getElementById('comment_form02').style.display='inline';
">Add a comment</a>
 | <a id="comment_form02" href="#comm" class="page"<?php 
if (!isset($_GET['copost'])) echo ' style="display: none"';
?> onclick="
document.getElementById('comment_form01').style.display='none';
document.getElementById('comment_form02').style.display='none';
">Collapse</a>
<?php
//O=('-'Q) echo
echo '<span class="span_comm_blank"> </span>'.$comm_stat_msg;
?>
</div>
<?php
require ('comment_w.php');
?>
</div>
</div>