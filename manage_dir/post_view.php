<?php
/**
 * Post edit function
 * All management functions can not be direct visited, the entrance is ../manage.php
 * Notice: the working directory is the root of website
 *
 * Require files:
 *     post_top.php: Top part of post_view.php
 *     post_bottom.php: Bottom of post_view.php
 *
 * External files:
 *     checkreload: Prevent reload
 *     post.php: Send the post to post.php for edit
 *
 * Copyright 2013 Huang Yiting (http://endrollex.com)
 * miniroll is distributed under the terms of the GNU General Public License
*/
//if direct visit, exit
if (!isset($manage_php)) exit();
$echo_log_state = '#Welcome#';
if (isset($_SESSION['v_user'])) $echo_log_state = '<a href="manage.php?m=3&amp;l=1">#Logout#</a>';
//O=('-'Q) echo
echo $echo_log_state.'<br/><br/>';
//var ini
$checkreload = $dir_manage.'checkreload';
$html_po_v_msg = '';
$view_file = '';
$view_file_c = '';
//disabled function
function disa() {
	if (!isset($_POST['view_one']) || !isset($_SESSION['v_user'])) echo ' disabled="disabled"';
}
//noreload
$isreload = false;
//########Authenticate################################################################
if (isset($_POST['noreload']) && isset($_SESSION['v_user'])) {
	$code2 = '';
	$fp = fopen($checkreload, 'rb');
	if ($fp) {$code2 = fgets($fp); fclose($fp);}
	if ($code2 !== $_POST['noreload']) {$isreload = true; $html_po_v_msg = '<span class=span_blue>Do not reload.</span>';}
}
//delete
//########Authenticate################################################################
if (!$isreload && isset($_POST['delete_one']) && isset($_POST['confirm_del']) && isset($_SESSION['v_user'])) {
	if ($_POST['confirm_del'] === 'DELETE') {
	$del_content = substr($_POST['delete_one'], 0, 12);
	if (file_exists($dir.$_POST['delete_one']) && file_exists($dir.$del_content)) {
		if (unlink($dir.$_POST['delete_one']) && unlink($dir.$del_content))
			$html_po_v_msg = 
				'<span class=span_red>The file '.$_POST['delete_one'].' has been deleted.</span>';
	}
	else $html_po_v_msg = '<span class=span_blue>No such file or content file is not exists.</span>';
	}
	else $html_po_v_msg = '<span class=span_blue>Deleting canceled.</span>';
}
//rename
$istime = false;
$rename_ok = false;
//control no tab
//########Authenticate################################################################
if (!$isreload && isset($_POST['f_rename']) && isset($_POST['hi_view_file']) && isset($_SESSION['v_user'])) {
if (strlen($_POST['f_rename']) >= 13) {
	if (preg_match("#^[0-9]{12}#", $_POST['f_rename'])) $istime = true;
}
//use setting lable
if ($istime) {
	$_POST['f_rename'] = substr($_POST['f_rename'], 0, 13);
	if (isset($_POST['lable'])) {
		for ($ix = 0; $ix !== count($_POST['lable']); ++$ix) $_POST['f_rename'] .= $_POST['lable'][$ix].'_';
	}
}
//check target
$f_rename_c = '';
$samefile = false;
$target_error = false;
if ($istime) {
	$f_rename_c = substr($_POST['f_rename'], 0, 12);
	if ($f_rename_c === substr($_POST['hi_view_file'], 0, 12)) $samefile = true;
	if (file_exists($dir.$_POST['f_rename'])) {
		$istime = false;
		$target_error = true;
	}
	if ($istime && !$samefile && file_exists($dir.$f_rename_c)) {
		$istime = false;
		$target_error = true;
	}
}
if ($istime && !$samefile) {
	if (preg_match("#^_([a-z][a-z]_){0,50}$#", substr($_POST['f_rename'], 12)))
		$rename_ok = (rename($dir.$_POST['hi_view_file'], $dir.$_POST['f_rename']) &&
			rename($dir.substr($_POST['hi_view_file'], 0, 12), $dir.$f_rename_c));
}
if ($istime && $samefile) {
	if (preg_match("#^_([a-z][a-z]_){0,50}$#", substr($_POST['f_rename'], 12)))
		$rename_ok = (rename($dir.$_POST['hi_view_file'], $dir.$_POST['f_rename']));
}
if ($rename_ok) $html_po_v_msg =
	'<span class=span_red>Rename OK, old name: '.$_POST['hi_view_file'].', new: '.$_POST['f_rename'].'</span>';
else $html_po_v_msg = '<span class=span_blue>Rename failed, please check the format.</span>';
if ($target_error) $html_po_v_msg = '<span class=span_blue>The filename has existed, please change another.</span>';
}
//show dir
$all_file = array();
$all_file_o = array();
$now_page = 0;
if ($dh = opendir($dir)) {
	while(($file_name = readdir($dh)) !== false) {
		if (strlen($file_name) > 12) array_push($all_file_o, $file_name);
	}
	closedir($dh);
	sort($all_file_o);
}
//regular expression match
$is_regu = false;
if (isset($_POST['rege_str'])) if(strlen($_POST['rege_str']) > 0) $is_regu = true;
if ($is_regu) {
	$_POST['rege_str'] = trim($_POST['rege_str']);
	if (strlen($_POST['rege_str']) > 30) $_POST['rege_str'] = substr($_POST['rege_str'], 0, 30);
	$_POST['rege_str'] = preg_replace("#[^\w_\s]#", '', $_POST['rege_str']);
	$_POST['rege_str'] = preg_replace("#\s+#", '))(?=.*(', $_POST['rege_str']);
	$_POST['rege_str'] = substr_replace('#(?=.*())#', $_POST['rege_str'], 7, 0);
	$all_file_o = preg_grep($_POST['rege_str'], $all_file_o);
	$now_page = 0;
}
//regular expression match
$temp_page = 0;
if (isset($_POST['s_match2']) && isset($_POST['view_one'])) {
	for ($ix = 0; $ix !== count($all_file_o); ++$ix) if ($_POST['view_one'] === $all_file_o[$ix])
		{$temp_page = ($ix-$ix%10)/10; break;}
}
//count file
$f_sum = count($all_file_o);
$all_file_o = array_chunk($all_file_o, 10);
$pag_sum = count($all_file_o);
//last file
if ($f_sum !== 0) $now_page = $pag_sum-1;
else $now_page = 0;
if (isset($_POST['sel_ix1'])) {
	if (isset($_POST['s_match2'])) $now_page = $temp_page;
	else $now_page = $_POST['sel_ix1'];
}
//input
if (isset($_POST['back'])) {
	if ($_POST['back'] > 0) $now_page = $_POST['back'];
	else $now_page = 0;
}
if (isset($_POST['next'])) {
	if ($_POST['next'] < $pag_sum) $now_page = $_POST['next'];
	else $now_page = $pag_sum-1;
}
if ($f_sum !== 0) $all_file = $all_file_o[$now_page];
//view
$noempty = true;
if (count($all_file) === 0) {$noempty = false; $html_po_v_msg = '<span class="span_blue">No file exists.</span>';}
if (isset($_POST['view_one'])) $view_file = $_POST['view_one'];
else if ($noempty) $view_file = $all_file[count($all_file)-1];
if ($noempty) $view_file_c = substr($view_file, 0, 12);
if ($html_po_v_msg === '') $html_po_v_msg = 'Current: <span class="span_blue">'.$view_file.'</span>';
//O=('-'Q) echo
echo 'The total number of files: '.$f_sum.'<br/>';
echo '--------<br/><br/>';
echo $html_po_v_msg.'<br/><br/>';
?>
<form action="manage.php?m=1" method="post" class="form_next">
<input type="hidden" name="back" value="<?php
echo ($now_page-1);
?>"/>
<input type="submit" value="&lt;"<?php if ($now_page == 0) echo ' disabled="disabled"'; ?>/>
</form>
<form action="manage.php?m=1" method="post" class="form_next">
<input type="hidden" name="next" value="<?php
echo ($now_page+1);
?>"/>
<input type="submit" value="&gt;"<?php if ($now_page == $pag_sum-1) echo ' disabled="disabled"'; ?>/>
</form>
<?php echo ' Page: '.$now_page; ?>
<form action="manage.php?m=1" method="post" class="form_rege">
<input type="text" name="rege_str" value=""/>
<input type="hidden" name="s_match1" value="1"/>
<input type="submit" value="Filter"/>
</form>
<form action="manage.php?m=1" method="post">
<?php
for ($ix = 0; $ix != count($all_file); ++$ix) {
	echo '<input type = "radio" name = "view_one" value = "'.$all_file[$ix].'"';
	//checked
	if ($view_file === $all_file[$ix]) echo ' checked="checked"';
	echo '/>'.$all_file[$ix].'<br/>';
}
?>
<?php
//regular expression match
if (isset($_POST['s_match1'])) echo '<input type="hidden" name="s_match2" value="1"/>';
?>
<input type="hidden" name="sel_ix1" value="<?php echo $now_page; ?>"/>
<input type="submit" value="Select"/>
</form>
<br/>
<!--#..............................................................here read post-->
<div class="div_no_class">
<br/>
<?php
if ($noempty) readfile($dir.$view_file);
echo '<br/><br/>';
if ($noempty) readfile($dir.$view_file_c);
echo '<div></div><br/>';
?>
</div>
<!--#..............................................................change tags-->
<div class="post_explain">
<?php
//change tags
if (isset($_POST['view_one'])) echo 'The file is: <span class="span_blue">'.$view_file.'</span><br/>';
else echo 'Please select a file.<br/>';
echo 'Change tags. Changing tags is Not Recommended because of Static URL.<br/>';
?>
<form action="manage.php?m=1" method="post">
<!--#..............................................................if need rename function, make type="text"-->
<input type="hidden" name="f_rename" value = "<?php echo $view_file; ?>"<?php disa(); ?>/>
<input type="submit" value="Change Tags"<?php disa(); ?>/>
<?php
//########Authenticate################################################################
if (isset($_SESSION['v_user'])) {
	$code1 = mt_rand(1, 65536);
	$fp = fopen($checkreload, 'wb');
	if ($fp) {fwrite($fp, $code1); fclose($fp);}
	echo '<input type = "hidden" name = "noreload" value = "'.$code1.'"/>';
}
?>
<input type = "hidden" name="hi_view_file" value="<?php echo $view_file; ?>"/>
<br/>
<?php
for ($ix = 0; $ix != count($label_code); ++$ix) {
	echo '<input type="checkbox" name="lable[]" value="'.$label_code[$ix].'"';
	disa();
	//checked
	if (isset($_POST['view_one'])) {
		$need_checked = false;
		$need_checked = strpos($_POST['view_one'], $label_code[$ix]);
		if ($need_checked !== false) echo ' checked="checked"';
	}
	echo '/>'.$label_text[$ix];
}
?>
</form>
</div><br/>
<!--#..............................................................edit-->
<div class="post_explain">
Edit the journal. Send the title and content to post.php.
<form action="manage.php?m=0" method="post">
<input type="hidden" name="edit_d1" value="<?php echo $view_file; ?>"/>
<input type="submit" value="Edit"<?php disa(); ?>/>
</form>
</div><br/>
<!--#..............................................................delete-->
<div class="post_explain">
<form action="manage.php?m=1" method="post">
If you want to delete the post, please enter the filename and fill "DELETE".<br/>
<input type="text" name="delete_one"<?php disa(); ?>/>
<input type="text" name="confirm_del"<?php disa(); ?>/><br/>
<input type="submit" value="Delete"<?php disa(); ?>/>
</form>
</div>
<br/><br/></div><!--/trace.post_div-->
<!--clear both--><div></div>