<?php
/**
 * Upload function
 * All management functions can not be direct visited, the entrance is ../manage.php
 * Notice: the working directory is the root of website
 *
 * Require files:
 *     post_top.php: Top part of post_view.php
 *     post_bottom.php: Bottom of post_view.php
 *     post.php: Send the post to post.php for edit
 *
 * Why Use fwrite() to upload: for server's flexible permission, if want to upload big files, please use FTP and so on.
*/
//if direct visit, exit
if (!isset($manage_php)) exit();
$echo_log_state = '#Welcome#';
if (isset($_SESSION['v_user'])) $echo_log_state = '<a href="manage.php?m=3&amp;l=1">#Logout#</a>';
//O=('-'Q) echo
echo $echo_log_state.'<br/><br/>';
echo 'Choose a file or a directory to browse:<br/>--------<br/><br/>';
//var
$upload_dir = 'upload/';
$upload_sub_dir = '';
if (!isset($_SESSION['upload_sub_dir'])) $_SESSION['upload_sub_dir'] = '';
//disabled function
function disa() {
	if (!isset($_SESSION['v_user'])) echo ' disabled="disabled"';
}
//dir
if (isset($_GET['dir_ix'])) {
	$upload_sub_dir_array = explode('/', $_SESSION['upload_sub_dir']);
	$dir_temp = '';
	if ($_GET['dir_ix'] > -1 && $_GET['dir_ix'] < count($upload_sub_dir_array)-1) {
		for ($ix = 0; $ix != $_GET['dir_ix']+1; ++$ix) $dir_temp .= $upload_sub_dir_array[$ix].'/';
		$_SESSION['upload_sub_dir'] = $dir_temp;
	}
	else $_SESSION['upload_sub_dir'] = '';
}
//dir
if (isset($_GET['dir'])) {
	$dir_temp = $_SESSION['upload_sub_dir'].$_GET['dir'].'/';
	if (file_exists($upload_dir.$dir_temp)) $_SESSION['upload_sub_dir'] = $dir_temp;
	else $_SESSION['upload_sub_dir'] = '';
}
if (isset($_GET['dir_up'])) {
	$_SESSION['upload_sub_dir'] = substr($_SESSION['upload_sub_dir'], 0, strlen($_SESSION['upload_sub_dir'])-1);
	$_SESSION['upload_sub_dir'] = substr($_SESSION['upload_sub_dir'], 0, strrpos($_SESSION['upload_sub_dir'], '/')+1 );
	if (strlen($_SESSION['upload_sub_dir']) === 1) $_SESSION['upload_sub_dir'] = '';
}
//apply dir
if (isset($_SESSION['upload_sub_dir'])) $upload_sub_dir = $_SESSION['upload_sub_dir'];
$upload_sub_dir_array = explode('/', $_SESSION['upload_sub_dir']);
$upload_curr_dir = $upload_dir.$upload_sub_dir;
//receive upload, because of permissions, use fwrite() copy file
$html_upload_msg = '...';
$upload_max = 1992295;
$echo_upload_max_mb = round($upload_max/1048576, 2);
//skip tab
if (isset($_FILES['file'])) {
$check_upload = true;
$html_upload_msg = '';
if ($_FILES['file']['error'] > 0) {
	$check_upload = false;
	$html_upload_msg = 'Error: '.$_FILES['file']['error'];
}
if ($_FILES['file']['size'] > $upload_max) {
	$check_upload = false;
	$html_upload_msg = 'The file is too big. (>'.$echo_upload_max_mb.' MB)';
}
if (file_exists($upload_curr_dir.$_FILES['file']['name'])) {
	$check_upload = false;
	$html_upload_msg = $_FILES['file']['name'].' already exists.';
}
if (preg_match('#[^\w\.-]+#', $_FILES['file']['name'])) {
	$check_upload = false;
	$html_upload_msg = 'Error: Please use an English filename with [\0-9a-zA-Z\.-].';
}
//########Authenticate################################################################
if (!isset($_SESSION['v_user'])) $check_upload = false;
if ($check_upload) {
	$fp = fopen($upload_curr_dir.$_FILES['file']['name'], 'wb');
	fwrite($fp, file_get_contents($_FILES['file']['tmp_name']));
	if (fclose($fp)) $html_upload_msg = '<span class=span_red>Upload OK, stored in: '.$upload_curr_dir.$_FILES['file']['name'].'</span>';
}
else $html_upload_msg = '<span class=span_blue>'.$html_upload_msg.'</span>';
}
//mkdir
//########Authenticate################################################################
if (isset($_POST['mkdir_one']) && isset($_SESSION['v_user'])) {
	$check_mkdir_one = true;
	if (preg_match('#[^\w\.-]+#', $_POST['mkdir_one'])) {
		$check_mkdir_one = false;
		$html_upload_msg = '<span class=span_blue>Please use an English dir name.</span>';
	}
	if (is_dir($upload_curr_dir.$_POST['mkdir_one']) || file_exists($upload_curr_dir.$_POST['mkdir_one'])) {
		$check_mkdir_one = false;
		$html_upload_msg = '<span class=span_blue>The floder or file exists.</span>';
	}
	if ($check_mkdir_one) {
		if (mkdir($upload_curr_dir.$_POST['mkdir_one'], 0700))
			$html_upload_msg = '<span class=span_red>mkdir OK: '.$upload_curr_dir.$_POST['mkdir_one'].'</span>';
		else $html_upload_msg = '<span class=span_blue>Failed to create the folder.</span>';
	}
}
//delete
//########Authenticate################################################################
if (isset($_POST['delete_one']) && isset($_POST['confirm_del']) && isset($_SESSION['v_user'])) {
	if ($_POST['confirm_del'] === 'DELETE') {
		$html_upload_msg = '<span class=span_blue>No such attachment or directory.</span>';
		//attachment
		if (file_exists($upload_curr_dir.$_POST['delete_one']) && !is_dir($upload_curr_dir.$_POST['delete_one'])) {
			if (unlink($upload_curr_dir.$_POST['delete_one']) )
				$html_upload_msg = 
					'<span class=span_red>The attachment '.$_POST['delete_one'].' has been deleted.</span>';
		}
		//directory
		if (is_dir($upload_curr_dir.$_POST['delete_one']) && $_POST['delete_one'] != '') {
			$dir = opendir($upload_curr_dir.$_POST['delete_one']);
			$check_empty_dir = true;
			while (($file = readdir($dir)) !== false) {
				if ($file != '.' && $file != '..') {$check_empty_dir = false; break;}
			}
			closedir($dir);
			if ($check_empty_dir) {
				if (rmdir($upload_curr_dir.$_POST['delete_one']))
					$html_upload_msg = 
						'<span class=span_red>The directory '.$_POST['delete_one'].' has been deleted.</span>';
			}
			else $html_upload_msg = '<span class=span_blue>The directory '.$_POST['delete_one'].' must be empty first.</span>';
		}
	}
	else $html_upload_msg = '<span class=span_blue>Deleting canceled.</span>';
}
//show dir
echo 'root/<a class="tit" href="manage.php?m=2&amp;dir_ix=-1">upload/</a>';
for ($ix = 0; $ix != count($upload_sub_dir_array)-1; ++$ix)
	echo '<a class="tit" href="manage.php?m=2&amp;dir_ix='.$ix.'">'.$upload_sub_dir_array[$ix].'/</a>';
echo '<br/>';
//show attachment
$get_scandir = scandir($upload_curr_dir);
for ($ix = 0; $ix !== count($get_scandir); ++$ix) {
	$is_file = false;
	$is_file = !is_dir($upload_curr_dir.$get_scandir[$ix]);
	//uploaded files
	if ($ix === 0) echo '[<a class="m4" href="manage.php?m=2&amp;dir_ix='.(count($upload_sub_dir_array)-2).
		'">'.$get_scandir[$ix].'</a>]<br/>';
	if ($get_scandir[$ix] === '..') echo '[<a class="m4" href="manage.php?m=2&amp;dir_up=1">'.$get_scandir[$ix].'</a>]<br/>';
	if ($ix > 1) {
		if (!$is_file) echo '[<a class="page" href="manage.php?m=2&amp;dir='.$get_scandir[$ix].'">'.$get_scandir[$ix].'</a>]<br/>';
		else echo '<a class="m4" href="'.$upload_curr_dir.$get_scandir[$ix].
			'" target="_blank">'.$get_scandir[$ix].'</a><br/>';
	}
}
echo '<br/>';
//O=('-'Q) echo msg
echo $html_upload_msg.'<br/><br/>';
//google analytics
if (file_exists('font/analyticstracking.php')) include_once('font/analyticstracking.php');
?>
<!--#..............................................................upload-->
<div class="post_explain">
<form action="manage.php?m=2" method="post" enctype="multipart/form-data">
Upload file's size &lt; <?php echo $echo_upload_max_mb; ?> MB.<br/>
<input type="file" name="file"<?php disa(); ?>/><br/>
<input type="submit" name="submit" value="Upload"<?php disa(); ?>/>
</form>
</div><br/>
<!--#..............................................................mkdir-->
<div class="post_explain">
<form action="manage.php?m=2" method="post">
Makes directory.<br/>
<input type="text" name="mkdir_one"<?php disa(); ?>/><br/>
<input type="submit" value="Mkdir"<?php disa(); ?>/>
</form>
</div><br/>
<!--#..............................................................delete-->
<div class="post_explain">
<form action="manage.php?m=2" method="post">
If you want to delete the file or the dir, please enter the name and fill "DELETE".<br/>
<input type="text" name="delete_one"<?php disa(); ?>/>
<input type="text" name="confirm_del" value="DELETE"<?php disa(); ?>/><br/>
<input type="submit" value="Delete"<?php disa(); ?>/>
</form>
</div>
<br/><br/></div><!--/trace.post_div-->
<!--clear both--><div></div>