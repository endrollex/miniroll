<?php
/**
 * Management entrance, hide the real manage function PHP file.
 * $dir_manage = "manage_dir", can be modified
*/
require('global_var.php');
//here can add some security check and rules
$manage_php = true;
$manage_file = array('post.php', 'post_view.php', 'upload.php', 'login.php');
if (isset($_GET['m'])) {
	$get_m = '';
	for ($ix = 0; $ix != count($manage_file); ++$ix) if ($_GET['m'] == $ix) $get_m = $ix;
	if  ($get_m !== '') {
		require($dir_manage.'post_top.php');
		require($dir_manage.$manage_file[$get_m]);
		if ($get_m == 3) require($dir_manage.'post_bottom2.php');
		else require($dir_manage.'post_bottom.php');
	}
}
?>