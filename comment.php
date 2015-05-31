<?php
/**
 * The guest comment main module
 *
 * Require files:
 *     htmindex.js: Control comment form
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
function comm_log(&$comm_log_p, &$comm_log_maxsize, &$post_co_email, $post_co_tit, &$time_txt, &$comm_t_id, &$comm_id) {
	$comm_log = $comm_log_p.'.php';
	if (file_exists($comm_log))
		if (filesize($comm_log) > $comm_log_maxsize) {
			$temp_str = date('YmdHis', time());
			$comm_log_hist = $comm_log_p.'_'.$temp_str.'.php';
			$comm_log_last = $comm_log_p.'_last.php';
			$comm_log_last_f = "<?php\r\n".'$comm_log_lastf = '."'".$comm_log_hist."';\r\n?>";
			$temp_read = file_get_contents($comm_log);
			file_put_contents($comm_log_hist, $temp_read);
			file_put_contents($comm_log, '');
			file_put_contents($comm_log_last, $comm_log_last_f);
	}
	$fp = fopen($comm_log, 'ab');
	if ($fp) {
		$cc_trace_t = '$cc_trace['.time().mt_rand(1000, 9999).']';
		$temp_addr = '';
		$temp_user_ag = '';
		if (isset($_SERVER['REMOTE_ADDR'])) $temp_addr = $_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['HTTP_USER_AGENT'])) $temp_user_ag = htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES);
		//
		$temp_str = "<?php\r\n";
		$temp_str .= $cc_trace_t."[0] = '".$time_txt."';\r\n";
		$temp_str .= $cc_trace_t."[1] = '".$comm_t_id."';\r\n";
		$temp_str .= $cc_trace_t."[2] = '".$comm_id."';\r\n";
		$temp_str .= $cc_trace_t."[3] = '".$post_co_tit."';\r\n";
		$temp_str .= $cc_trace_t."[4] = '".$post_co_email."';\r\n";
		$temp_str .= $cc_trace_t."[5] = '".$temp_addr."';\r\n";
		$temp_str .= $cc_trace_t."[6] = '".$temp_user_ag."';\r\n";
		$temp_str .= "?>\r\n";
		fwrite($fp, $temp_str);
		fclose($fp);
	}
}
//var
$com_dir = 'az_comment/';
if (isset($dir_comment)) $com_dir = $dir_comment;
$comm_file = '';
$comm_count_file = '';
$comm_c_id = '';
$comm_t_id = '';
if (isset($view_file)) $comm_t_id = $view_file;
$comm_size = 0;
$comm_id = '';
$time_txt = '';
//read comment count
if (isset($_SESSION['view_file_c'])) {
	$comm_c_id = $_SESSION['view_file_c'];
	$comm_file = $com_dir.$_SESSION['view_file_c'].'c';
	$comm_count_file = $comm_file.'_count';
	if (file_exists($comm_count_file)) $comm_size = file_get_contents($comm_count_file);
}
//temp input
if (isset($_POST['co_tit'])) $_SESSION['co_tit'] = $_POST['co_tit'];
if (isset($_POST['co_cont'])) $_SESSION['co_cont'] = $_POST['co_cont'];
if (isset($_POST['co_link'])) $_SESSION['co_link'] = $_POST['co_link'];
if (isset($_POST['co_email'])) $_SESSION['co_email'] = $_POST['co_email'];
//check
$check_all_ok = false;
$check_tit = false;
$check_link = false;
$check_cont = false;
$check_ident = false;
$check_email = false;
//$_SESSION['com_msg'] pos0-4: title, url, content, img_identify, email
$_SESSION['com_msg'] = array('', '', '', '', '');
//once identify success, keep ident flag for a while
if (!isset($_SESSION['keep_ident'])) $_SESSION['keep_ident'] = array(false, 0);
//check img identify
$check_ident_fail = false;
if (isset($_POST['c_ident']) && isset($_SESSION['rand_img'])) {
	$img_sign = ' !== ';
	$img_succ = '<span class="span_red">Verify faile: ';
	$_POST['c_ident'] = strtolower(htmlspecialchars(trim($_POST['c_ident']), ENT_QUOTES));
	if ($_POST['c_ident'] === $_SESSION['rand_img'][0]) {
		$check_ident = true;
		$img_sign = ' === ';
		$img_succ = '<span>Verify OK: ';
		$_SESSION['keep_ident'][0] = true;
	}
	else {
		$check_ident_fail = true;
		$_SESSION['keep_ident'][0] = false;
	}
	$_SESSION['com_msg'][3] = $img_succ.$_POST['c_ident'].$img_sign.$_SESSION['rand_img'][0].'</span><br/>';
	if (strlen($_POST['c_ident']) == 0 || strlen($_POST['c_ident']) > 18)
		$_SESSION['com_msg'][3] = $img_succ.'Please enter the echo word.</span>';
}
if (isset($_POST['c_ident']) && !isset($_SESSION['rand_img'])) {
	$check_ident_fail = true;
	$_SESSION['com_msg'][3] = '<span class="span_red">The image is time out.</span>';
}
//max keep_ident lifetime
if (isset($_SESSION['keep_ident'])) if ($_SESSION['keep_ident'][1] > 5) $_SESSION['keep_ident'] = array(false, 0);
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
	$_POST['co_link'] = htmlspecialchars(strtolower(trim($_POST['co_link'])), ENT_QUOTES);
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
	if ($_SESSION['com_msg'][2] === '') $check_cont = true;
}
//check email
if (isset($_POST['co_email'])) {
	$_POST['co_email'] = htmlspecialchars(strtolower(trim($_POST['co_email'])), ENT_QUOTES);
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
	$time_txt = date('Y-m-d H:i', time());
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
	$comm_id = 'cc'.$comm_c_id.'_'.$comm_size;
	//gravatar
	if ($is_gravatar) {
		$comm_data .= '<div class="div_com_ava">'."\r\n".'<img src="';
		if ($_POST['co_email'] != '') $comm_data .= get_gravatar($_POST['co_email'], 64, 'identicon');
		else $comm_data .= get_gravatar($_POST['co_email']);
		$comm_data .= '"'."\r\n".'alt="avatar" class="img_commc" id="'.
			$comm_id.'i" onerror="rep_err('."'".$comm_id."i'".');" />'."\r\n".'</div>';
	}
	//
	if ($show_flink) {
		$comm_data .= '<span id="'.$comm_id.'" class="span_com_tit"><a class="user" href="'.$_POST['co_link'].'" target="_blank">'."\r\n";
		$comm_data .= $_POST['co_tit'].': </a></span>'."\r\n";
	}
	else {
		$comm_data .= '<span id="'.$comm_id.'" class="span_com_tit">'.$_POST['co_tit'].': </span>'."\r\n";
	}
	$comm_data .= '<span class="span_commc">'.$_POST['co_cont'].
		'</span>'."\r\n".'<div class="div_com_time">'
		.'<span class="span_comsize">['.$comm_size.']</span>'.$time_txt.'</div></div>'."\r\n<!--comm_end-->\r\n";
	$check_all_ok = true;
}
//chunk comments, every $chunk_value in a file
$chunk_value = 30;
$html_comm_readfile = '';
if (file_exists($comm_file)) $html_comm_readfile = file_get_contents($comm_file);
$second_new = ($comm_size-$comm_size%$chunk_value)/$chunk_value;
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
		//comment order direction
		$html_comm_readfile = $html_comm_readfile.$comm_data;
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
	comm_log($comm_log_p, $comm_log_maxsize, $_POST['co_email'], $_POST['co_tit'], $time_txt, $comm_t_id, $comm_id);
}
//read comments
//O=('-'Q) echo and readfile
echo '<span class="span_l4b"><a id="ctop">Comments: </a>'.$comm_size.'</span><br/><br/>';
if ($comm_file !== '') {
	//show file
	$comm_readix = $second_new;
	if (isset($_GET['comp'])) {
		if ($_GET['comp'] < 1 || $_GET['comp'] > $second_new) $_GET['comp'] = $second_new;
		$comm_readix = $_GET['comp'];
	}
	if (file_exists($comm_file.$comm_readix)) readfile($comm_file.$comm_readix);
	if ($html_comm_readfile === '' && $second_new === 0) $html_comm_readfile = '<span class="span_l4">-</span><br/>';
	if ($comm_readix == $second_new) echo $html_comm_readfile;
	//O=('-'Q) echo comm page
	$comm_page = 'index.php?p='.$comm_t_id.'&amp;comp=';
	echo '<div class="div_com_page">';
	$ix_comm = $second_new;
	if ($ix_comm === 0) echo '.';
	for ($ix_comm = $second_new; $ix_comm != 0; --$ix_comm) {
		if ($comm_readix == $ix_comm) echo ' '.$ix_comm;
		else echo ' <a class="user" href="'.$comm_page.$ix_comm.'#comm">'.$ix_comm.'</a>';
	}
	echo '</div>';
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
	$c_link = 'index.php?p='.$_GET['p'].'&amp;co=1#comm';
}
?>
<div>
<script type="text/javascript">
function tit_onfocus() {
document.getElementById('input_com_iden').value = '<?php
if (isset($_SESSION['rand_img'][0])) echo $_SESSION['rand_img'][0];
?>';}
</script>
<div class="div_com_top">
<a id="comm" href="#comm" class="page" onclick="form_disp(1)">Add a comment</a>
<span id="comm_span1"> | </span><a id="comment_form02" href="#comm" class="page"<?php 
if (!isset($_GET['co'])) echo ' style="display: none"';
?> onclick="form_disp(2)">Collapse</a>
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