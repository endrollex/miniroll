<?php
/**
 * Login function
 * All management functions can not be direct visited, the entrance is ../manage.php
 * Notice: the working directory is the root of website
 * 
 * Require files:
 *     post_top.php: Top part of login.php
 *     post_bottom2.php: Bottom of login.php
 * 
 * External files:
 *     login_data.php: Where store admin data, delete it can reset admin account
 *     login_hash.php: If this file exists, password's algorithm will use this mothod replace the default mothod
 *     check_time: The max of try password times, if exceed, all login request will be drop, delete it can reset
 *     log/login_log.php: Records success login action
 *     log/login_log_err.php: Records failed login action
 *
 * Copyright 2013 Huang Yiting (http://endrollex.com)
 * miniroll is distributed under the terms of the GNU General Public License
*/
//if direct visit, exit
if (!isset($manage_php)) exit();
//pass list
$login_log = $dir_manage.'log/login_log.php';
$login_log_err = $dir_manage.'log/login_log_err.php';
$login_log_maxsize = 60000;
$auth = array();
$auth['user'] = '';
$auth['pass'] = '';
$login_file = $dir_manage.'login_data.php';
$login_data = false;
$echo_lo_msg = '...';
$login_hash_f = $dir_manage.'login_hash.php';
$check_time = $dir_manage.'check_time';
if (file_exists($login_hash_f)) require($login_hash_f);
//function
function sha1_lock(&$lock_str) {
	$salt1 = '7G2mF~ZOcRf!%u]8IY-(K(2eua0Jd4';
	$login_hash_f = 'login_hash.php';
	if (file_exists($login_hash_f)) return hash_lock($lock_str);
	else return sha1(sha1($salt1.$lock_str));
}
function save_pass(&$save_user, &$save_pass, &$login_file) {
	$temp = "<?php\r\n";
	$temp .= "\t".'$auth[\'user\'] = \''.$save_user."';\r\n";
	$temp .= "\t".'$auth[\'pass\'] = \''.$save_pass."';\r\n";
	$temp .= '?>';
	file_put_contents($login_file, $temp);	
}
function login_log(&$login_log, &$login_log_maxsize) {
	if (file_exists($login_log))
		if (filesize($login_log) > $login_log_maxsize) file_put_contents($login_log, '');
	$fp = fopen($login_log, 'ab');
	if ($fp) {
		$temp_str = "<?php\r\n//";
		$temp_str .= date('Y-m-d H:i:s', time());
		if (isset($_SERVER['REMOTE_ADDR'])) $temp_str .= ','.$_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['REMOTE_HOST'])) $temp_str .= ','.$_SERVER['REMOTE_HOST'];
		if (isset($_SERVER['REMOTE_USER'])) $temp_str .= ','.$_SERVER['REMOTE_USER'];
		if (isset($_SERVER['HTTP_USER_AGENT'])) $temp_str .= ','.$_SERVER['HTTP_USER_AGENT'];
		$temp_str .= "\r\n?>\r\n";
		fwrite($fp, $temp_str);
		fclose($fp);
	}
}
//
if (file_exists($login_file)) {
	require($login_file);
	if ($auth['user'] != '' && $auth['pass'] != '') $login_data = true;
}
//change password
$change_pass = false;
if ($login_data && isset($_SESSION['v_user']) && isset($_POST['x_pass_o']) && isset($_POST['x_pass']) && isset($_POST['x_pass2'])) {
	$change_pass = true;
	$change_run = true;
	$_POST['x_pass_o'] = sha1_lock($_POST['x_pass_o']);
	if ($_POST['x_pass_o'] !== $auth['pass']) {
		$echo_lo_msg = '<span class=span_red>Old password error.</span>';
		$change_run = false;
	}
	if ($change_run && $_POST['x_pass'] !== $_POST['x_pass2'])  {
		$echo_lo_msg = '<span class=span_red>Re-enter password error.</span>';
		$change_run = false;
	}
	if ($change_run && strlen($_POST['x_pass']) < 6) {
		$echo_lo_msg = '<span class=span_red>Password too short.</span>';
		$change_run = false;
	}
	if ($change_run) {
		$_POST['x_pass'] = sha1_lock($_POST['x_pass']);
		save_pass($_SESSION['v_user'], $_POST['x_pass'], $login_file);
		$echo_lo_msg = '<span class=span_blue>The password has been changed, place logout and re-login.</span>';
	}
}
//create admin account
if (!$login_data) {
	$echo_lo_msg = '<span class=span_red>It seems that you are the first visitor of this page, plase create the admin account.</span>';
	if (isset($_POST['user']) && isset($_POST['pass'])) {
		if (strlen($_POST['user']) > 2 && strlen($_POST['pass']) > 5) {		
			$_POST['pass'] = sha1_lock($_POST['pass']);
			save_pass($_POST['user'], $_POST['pass'], $login_file);
			$echo_lo_msg = '<span class=span_blue>Account created, please reload and check the operation.</span>';
		}
		else $echo_lo_msg = '<span class=span_red>Username or password too short.</span>';
	}
}
$kick_time = 0;
$kick_out = 51;
if (!$change_pass && $login_data && isset($_POST['user']) && isset($_POST['pass'])) {
	$stop_run = true;
	if (strlen($_POST['user']) > 2 && strlen($_POST['pass']) > 5) $stop_run = false;
	if (!$stop_run) {
		$fp = false;
		if (file_exists($check_time)) {
			$fp = fopen($check_time, 'rb');
		}
		if ($fp) {$kick_time = fgets($fp); fclose($fp); ++$kick_time;}
		if ($kick_time > $kick_out) $stop_run = true;
	}
	if (!$stop_run) {
		if ($_POST['user'] == $auth['user'] && sha1_lock($_POST['pass']) === $auth['pass']) {
			$_SESSION['v_user'] = $_POST['user'];
			//log
			login_log($login_log, $login_log_maxsize);
		}
		else {
			$echo_lo_msg = 'Authenticate failed.';
			$fp = fopen($check_time, 'wb');
			if ($fp) {fwrite($fp, $kick_time); fclose($fp);}
			//log
			login_log($login_log_err, $login_log_maxsize);			
		}
	}
	else $echo_lo_msg = 'Username or passwd too short.';
	if ($kick_time > $kick_out) $echo_lo_msg = 'Login function is Blocked, please delete check_time file.';
}
//login or logout
$echo_log_state = '#Welcome#';
//########Authenticate################################################################
if (isset($_SESSION['v_user'])) {
	$echo_log_state = '<a href="manage.php?m=3&amp;l=1">#Logout#</a>';
	if (!$change_pass) $echo_lo_msg = 'You are logged as '.$auth['user'].'.';
}
if (isset($_GET['l'])) {
	$isuser = isset($_SESSION['v_user']);
	session_destroy();
	if ($isuser) {
		$echo_log_state = '#Welcome#';
		$echo_lo_msg = 'Session is destoried.';
	}
}
//disabled function
function disa() {
	if (isset($_SESSION['v_user']) && !isset($_GET['l'])) echo ' disabled="disabled"';
}
function disa2(&$login_data) {
	if (!isset($_SESSION['v_user']) || !$login_data || isset($_GET['l'])) echo ' disabled="disabled"';
}
//O=('-'Q) echo
echo $echo_log_state.'<br/><br/>';
echo 'Login or logout:<br/>--------<br/><br/>';
echo $echo_lo_msg.'<br/><br/>';
//do not include or require special file for security
?>
<!--#..............................................................user and passwd-->
<form action="manage.php?m=3" method="post">
Username:<br/>
<input type="text" name="user"<?php disa(); ?>/><br/>
Password:<br/>
<input type="password" name="pass"<?php disa(); ?>/><br/>
<input type="submit" value="<?php if ($login_data) echo 'Login'; else echo 'Create account'; ?>"<?php disa(); ?>/>
</form><br/>
<div class="post_explain">
<form action="manage.php?m=3" method="post">
Change password for the login user, old password:<br/>
<input type="password" name="x_pass_o"<?php disa2($login_data); ?>/><br/>
New password:<br/>
<input type="password" name="x_pass"<?php disa2($login_data); ?>/><br/>
New password re-enter:<br/>
<input type="password" name="x_pass2"<?php disa2($login_data); ?>/><br/>
<input type="submit" value="Change"<?php disa2($login_data); ?>/>
</form>
</div>
<br/><br/></div><!--/trace.post_div-->
<!--clear both--><div></div>