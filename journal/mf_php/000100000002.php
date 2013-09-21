<?php
//recent comments
$comm_log_file = 'az_comment/log/comm_log.php';
$comm_log_last_file = 'az_comment/log/comm_log_last.php';
$url_index = 'http://endrollex.com/index.php?p=';
if (file_exists($comm_log_file)) require($comm_log_file);
if (file_exists($comm_log_last_file)) require($comm_log_last_file);
if (isset($comm_log_lastf)) if (file_exists($comm_log_lastf)) require($comm_log_lastf);
$view_stop = false;
if (!isset($cc_trace)) $view_stop = true;
if (!$view_stop) {
	sort($cc_trace);
	end($cc_trace);
	echo '<br/><br/>';
}
echo '<div>';
while (!$view_stop) {
	$temp_arr = current($cc_trace);
	reset($temp_arr);
	$url_index_p = $url_index.$temp_arr[1].'#'.$temp_arr[2];
	echo '<a class ="m4" target="_blank" href="'.$url_index_p.'">'.$temp_arr[0].', '.$temp_arr[3].'</a>';
	if (prev($cc_trace) === false) $view_stop = true;
	else echo '<br/><br/>';
}
echo '</div>';
?>