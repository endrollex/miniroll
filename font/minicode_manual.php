<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="zh-cn" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<style type="text/css">
body {font-family: "Courier New", Courier, monospace; font-size: 12px;}
</style>
</head>
<body>
<?php
$style_note_arr = array('Can not find the file.');
$replace_arr = array('<span style="color: white; background-color: #3297FD;">{', '}</span>');
$echo_note = '';
if (file_exists('minicode_manual.txt')) {
	$style_note = file_get_contents('minicode_manual.txt');
	if (substr($style_note, 0, 3) == "\xEF\xBB\xBF") $style_note = substr($style_note, 3);	
	$style_note = nl2br(htmlspecialchars($style_note));
	$style_note_arr = explode('<br />', $style_note);
}
for ($ix_style = 0; $ix_style != count($style_note_arr); ++$ix_style) {
	$style_note_arr[$ix_style] = str_replace(' ', '&nbsp', $style_note_arr[$ix_style]);
	if (strpos($style_note_arr[$ix_style], '#') !== false)
		$style_note_arr[$ix_style] = '<span style="color: blue;">'.$style_note_arr[$ix_style].'</span>';
	$echo_note .= $style_note_arr[$ix_style].'<br />';
}
$echo_note = str_replace('{-', $replace_arr[0], $echo_note);
$echo_note = str_replace('-}', $replace_arr[1], $echo_note);
echo $echo_note;
?>
</body>
</html>