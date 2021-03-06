<?php
/**
 * Post function
 * All management functions can not be direct visited, the entrance is ../manage.php
 * Notice: the working directory is the root of website
 *
 * Require files:
 *	   post_top.php: Top part of post.php
 *	   post_bottom.php: Bottom of post.php
 *
 * External files:
 *	   checkreload: Prevent reload
 *
 * if year > 9999, modify the miniroll
 *
 * Copyright 2013 Huang Yiting (http://endrollex.com)
 * miniroll is distributed under the terms of the GNU General Public License
*/
//if direct visit, exit
if (!isset($manage_php)) exit();
$isedit = (isset($_POST['edit_d1']));
$echo_log_state = '#Welcome#';
if (isset($_SESSION['v_user'])) $echo_log_state = '<a href="manage.php?m=3&amp;l=1">#Logout#</a>';
//O=('-'Q) echo
echo $echo_log_state.'<br/><br/>';
//var ini
$checkreload = $dir_manage.'checkreload';
$postok = false;
$writeok = 0;
$isreload = false;
$fp = false;
//minicode ini, note: syntax can not nest
$minicode = array('[code]', '[output]', '[img]', '[url]', '[html]', '[color]', '[b]', '[small]', '[last]', '[h]', '[abst]');
$minicode_e = array('[/code]', '[/output]', '[/img]', '[/url]', '[/html]', '[/color]', '[/b]', '[/small]', '[/last]', '[/h]', '[/abst]');
//minicode assign
function minicode(&$need_eidt, &$which_ix) {
	$delete_char = '#[<>\'"]#';
	switch ($which_ix) {
		case 0: // code
			$need_eidt = htmlspecialchars($need_eidt, ENT_QUOTES);
			$need_eidt = substr_replace($need_eidt, '<pre class="prettyprint linenums">', 0, 6);
			$need_eidt = substr_replace($need_eidt, '</pre><div class="m1"></div>', -7, 7);
			break;
		case 1: // output
			$need_eidt = htmlspecialchars($need_eidt, ENT_QUOTES);
			$need_eidt = substr_replace($need_eidt, '<pre class="pre_output">', 0, 8);
			$need_eidt = substr_replace($need_eidt, '</pre><div class="m2"></div>', -9, 9);
			break;
		case 2: // img
			$need_eidt = preg_replace($delete_char, '', $need_eidt);
			$need_eidt = htmlspecialchars($need_eidt, ENT_QUOTES);
			$need_eidt = substr_replace($need_eidt, '', 0, 5);
			$need_eidt = substr_replace($need_eidt, '', -6, 6);
			$edit_img_alt = '';
			$edit_matches = array();
			if (preg_match("/^.{0,100}?\]/", $need_eidt, $edit_matches) !== 0) {
				$need_eidt = str_replace($edit_matches[0], '', $need_eidt);
				$edit_img_alt = substr($edit_matches[0], 0, strlen($edit_matches[0])-1);
			}
			else  {
				if (preg_match("#/[^/]{0,100}?\.[a-zA-Z]{3}$#", $need_eidt, $edit_matches) !== 0) {
					$edit_img_alt = substr($edit_matches[0], 1, strlen($edit_matches[0])-5);
				}
			}
			//for decode, use junk tags
			$need_eidt = '<!--m3a--><img alt="'.$edit_img_alt
				.'" class="m3" src="'.$need_eidt.'" /><!--m3-->';
			break;
		case 3: //url
			$need_eidt = preg_replace($delete_char, '', $need_eidt);
			$need_eidt = htmlspecialchars($need_eidt, ENT_QUOTES);
			//preg_replace decode
			$need_eidt = substr_replace($need_eidt, '', 0, 5);
			$need_eidt = substr_replace($need_eidt, '', -6, 6);
			$edit_matches = array();
			//endrollex.com
			$tar_blank = 'target="_blank" ';
			if (preg_match("#\[.+$#", $need_eidt, $edit_matches) !== 0) {
				$need_eidt = str_replace($edit_matches[0], '', $need_eidt);
				$edit_matches[0] = substr($edit_matches[0], 1, strlen($edit_matches[0])-1);
				$need_eidt = '<a class="m4b" '.$tar_blank.'href="'.$need_eidt.'"><!--m4a-->'
					.$edit_matches[0].'</a><!--m4-->';
			}
			else $need_eidt = '<a class="m4" '.$tar_blank.'href="'.$need_eidt.'">'.$need_eidt.'</a><!--m4-->';
			break;
		case 4: //html
			$need_eidt = substr_replace($need_eidt, '<!--m5-->', 0, 6);
			$need_eidt = substr_replace($need_eidt, '<!--m5b-->', -7, 7);
			break;
		case 5; //color
			$need_eidt = htmlspecialchars($need_eidt, ENT_QUOTES);
			$need_eidt = substr_replace($need_eidt, '', 0, 7);
			$need_eidt = substr_replace($need_eidt, '', -8, 8);
			$edit_color = '#0000FF';
			$edit_matches = array();
			if (preg_match("/^(#[a-fA-F0-9]{6}|#[a-fA-F0-9]{3}|[a-zA-Z]{3,21}?)\]/", substr($need_eidt, 0, 21), $edit_matches) !== 0) {
				$need_eidt = str_replace($edit_matches[0], '', $need_eidt);
				$edit_color = substr($edit_matches[0], 0, strlen($edit_matches[0])-1);
				if (substr($edit_color, 0, 1) === '#') $edit_color = strtoupper($edit_color);
			}
			$need_eidt = '<span class="m6" style="color: '.$edit_color.'"><!--m6a-->'.$need_eidt.'</span><!--m6-->';
			break;
		case 6; //b
			$need_eidt = htmlspecialchars($need_eidt, ENT_QUOTES);
			$need_eidt = substr_replace($need_eidt, '', 0, 3);
			$need_eidt = substr_replace($need_eidt, '', -4, 4);
			$need_eidt = '<span class="m7">'.$need_eidt.'</span><!--m7-->';
			break;
		case 7; //small
			$need_eidt = htmlspecialchars($need_eidt, ENT_QUOTES);
			$need_eidt = substr_replace($need_eidt, '', 0, 7);
			$need_eidt = substr_replace($need_eidt, '', -8, 8);
			$need_eidt = '<span class="m8">'.$need_eidt.'</span><!--m8-->';
			break;
		case 8; //last
			$need_eidt = '<span class="m9">Last modified: '.date('Y-m-d H:i:s', time()).'</span><!--m9-->';
			break;
		case 9; //h
			$need_eidt = substr_replace($need_eidt, '', 0, 3);
			$need_eidt = substr_replace($need_eidt, '', -4, 4);
			$edit_matches = array();
			$edit_img_alt = '';
			$edit_matches = array();
			if (preg_match("/^.{0,10}?\]/", $need_eidt, $edit_matches) !== 0) {
				$need_eidt = str_replace($edit_matches[0], '', $need_eidt);
				$edit_img_alt = substr($edit_matches[0], 0, strlen($edit_matches[0])-1);
			}
			$need_eidt = '<!--m10--><'.$edit_img_alt.' class="m10">'.$need_eidt.'</'.$edit_img_alt.'><!--m10b-->';
			break;
		case 10; //abst
			$need_eidt = '<!--m11--><!--m11b-->';
			break;
		//
	}
}
//minicode find
function minicode_find(&$process, &$p1, &$p2, &$p_start, &$p_offset,
	&$post_content, &$need_try, &$minicode, &$content_len, &$minicode_e,
	&$p_end, &$p_end_len, &$ix
	) {
	$p1 = strpos($post_content, '[', $p_start+$p_offset);
	$p2 = strpos($post_content, ']', $p_start+$p_offset);
	$lookfor = '';
	$get1code = false;
	if ($p1 !== false && $p2 !== false) {
		if($p2 > $p1) {$lookfor = substr($post_content, $p1, $p2-$p1+1); $get1code = true;}
	}
	else {$need_try = false; $process = false;}
	//begin of minicode
	$lookok = false;
	$ix = 0;
	if ($get1code) {
		while ($lookok === false && $ix !== count($minicode)) {
			if ($lookfor === $minicode[$ix]) $lookok = true;
			else ++$ix;
		}
	}
	//end of minicode
	if ($lookok) $p_end = strpos($post_content, $minicode_e[$ix], $p_start+$p_offset);
	if ($p_end !== false) {
		$p_end_len = $p_end-$p1+strlen($minicode_e[$ix]);
		$need_try = false;
	}
	if ($need_try) $p_offset = $p2-$p_start+1;
	if ($p_start+$p_offset > $content_len-4) {$need_try = false; $process = false;}
}
//minicode decode
function minicode_decode(&$decode_s) {
	$styl_s = array(
		'<pre class="prettyprint linenums">',
		'</pre><div class="m1"></div>',
		'<pre class="pre_output">',
		'</pre><div class="m2"></div>',
		//img
		'<!--m3a--><img alt="',
		'" class="m3" src="',
		'" /><!--m3-->',
		//url
		'</a><!--m4-->',
		'"><!--m4a-->',
		//html
		'<!--m5-->',
		'<!--m5b-->',
		//color
		'<span class="m6" style="color: ',
		'"><!--m6a-->',
		'</span><!--m6-->',
		//span
		'<span class="m7">',
		'</span><!--m7-->',
		'<span class="m8">',
		'</span><!--m8-->',
		//h
		'<!--m10--><',
		' class="m10">',
		//abst
		'<!--m11-->',
		'<!--m11b-->'
	);
	$mini_s = array(
		'[code]', '[/code]',
		'[output]', '[/output]',
		'[img]', ']', '[/img]',
		'[/url]', '[',
		'[html]', '[/html]',
		'[color]', ']', '[/color]',
		'[b]', '[/b]',
		'[small]', '[/small]',
		'[h]', ']',
		'[abst]', '[/abst]'
	);
	//preg_replace
	$styl_p = array(
		'#<a class="m4".+?href=".+?">#',
		'#<a class="m4b".+?href="#',
		'#<span class="m9">.+?</span><!--m9-->#',
		'#</[\w]{1,20}><!--m10b-->#'
	);
	$mini_p = array('[url]', '[url]', '[last][/last]', '[/h]');
	$decode_s = preg_replace($styl_p, $mini_p, $decode_s);
	return str_replace($styl_s, $mini_s, $decode_s);
}
//minicode [lead_define], [lead_define] will be cut and glue
function minicode_lead_define(&$post_content, &$lead_arr_1, &$lead_arr_2, &$lead_str) {
	$is_lead_define = false;
	$p1 = strpos($post_content, '[lead_define]');
	$p2 = strpos($post_content, '[/lead_define]');
	if ($p1 !== false && $p2) if ($p1 < $p2) $is_lead_define = true;
	if ($is_lead_define) {
		$lead_str = substr($post_content, $p1+13, $p2-$p1-13);
		$lead_arr = explode("\n", $lead_str);
		for ($ix = 0; $ix != count($lead_arr); ++$ix) {
			if (strlen(trim($lead_arr[$ix])) !== 0) {
				if (strpos($lead_arr[$ix], '@=') !== false) {
					$lead_temp = explode('@=', $lead_arr[$ix]);
					if (count($lead_temp) === 2) {
						array_push($lead_arr_1, trim($lead_temp[0]));
						array_push($lead_arr_2, trim($lead_temp[1]).'<!--mi'.$ix.'-->');
					}
				}
			}
		}
		$lead_str = '[lead_define]'.$lead_str.'[/lead_define]';
		//$post_content = str_replace($lead_str , '' , $post_content);
		$post_content = substr_replace($post_content, '', $p1, $p2-$p1+14);
	}
	return $is_lead_define;
}
function minicode_lead_define_decode(&$decode_s) {
	$styl_s = array(
		'<span style="display: none;"><!--mi_lead-->',
		'</span><!--mi_lead-->'
	);
	$mini_s = array(
		'[lead_define]', '[/lead_define]');
	return str_replace($styl_s, $mini_s, $decode_s);
}
//disabled function
function disa(&$isedit) {
	if ($isedit || !isset($_SESSION['v_user'])) echo ' disabled="disabled"';
}
function disa2() {
	if (!isset($_SESSION['v_user'])) echo ' disabled="disabled"';
}
//functions end
//
//hold input
$t2_temp = '';
$t1_temp = '';
$t3_temp = array();
if (isset($_POST['title'])) {
	//stripslashes
	if (get_magic_quotes_gpc()) $_POST['title'] = stripslashes($_POST['title']);
	$t1_temp = $_POST['title'];
}
if (isset($_POST['content'])) {
	//stripslashes
	if (get_magic_quotes_gpc()) $_POST['content'] = stripslashes($_POST['content']);
	$t2_temp = $_POST['content'];
}
if (isset($_POST['lable'])) $t3_temp = $_POST['lable'];
//edit
$edit_t = '';
$edit_c = '';
//minicode [lead_define]
$lead_arr_1 = array();
$lead_arr_2 = array();
$lead_str = '';
$lead_find_ready = false;
$lead_find_ok = false;
//
if ($isedit) {
	$edit_t = $_POST['edit_d1'];
	$edit_c = substr($edit_t, 0, 12);
	$t1_temp = '';
	if (file_exists($dir_journal.$edit_t)) $t1_temp = html_entity_decode(file_get_contents($dir_journal.$edit_t), ENT_QUOTES, 'UTF-8');
	//remove enter
	$ent_s = array("<br />\r\n", "<br />\r", "<br />\n");
	$rem_s = array("\r\n", "\r", "\n");
	$t2_temp = '';
	if (file_exists($dir_journal.$edit_t)) {
		$t2_temp = html_entity_decode(str_replace($ent_s, $rem_s, file_get_contents($dir_journal.$edit_c)), ENT_QUOTES, 'UTF-8');
		//minicode [lead_define]
		$t2_temp = minicode_lead_define_decode($t2_temp);
		$lead_find_ok = minicode_lead_define($t2_temp, $lead_arr_1, $lead_arr_2, $lead_str);
		$lead_find_ready = true;
		$t2_temp = str_replace($lead_arr_2, $lead_arr_1, $t2_temp);
		if ($lead_find_ok) $t2_temp = $lead_str.$t2_temp;
		$t2_temp = minicode_decode($t2_temp);
	}
}
if (isset($_POST['f_isedit'])) {
	$isedit = true;
	$edit_t = $_POST['f_isedit'];
	$edit_c = substr($edit_t, 0, 12);
}
//begin post
$html_post_msg = 'minicode (variant of BBCode) - easy editing HTML';
if ($isedit) $html_post_msg = '<span class="span_blue">Post editing: <a href="index.php?p='.$edit_t.'">'.$edit_t.'</a></span>';
//########Authenticate################################################################
if(isset($_POST['title']) && isset($_POST['content']) && isset($_SESSION['v_user']))
{
	$code2 = '';
	$fp = fopen($checkreload, 'rb');
	if ($fp) {$code2 = fgets($fp); fclose($fp);}
	if ($code2 !== $_POST['noreload']) $isreload = true;
	$content_len = strlen($_POST['content']);
	if (strlen($_POST['title']) > 2 && strlen($_POST['title']) < 201 && $content_len > 20) $postok = true;
	if (!$postok) $isreload = false;
	if ($postok && !$isreload) $postok = true;
	else {$postok = false; $html_post_msg = '<span class="span_blue">The title/content is too short, or the title is too long.</span>';}
}
if (!$postok) {
	if ($isreload) $html_post_msg = '<span class="span_blue">Do not reload, please complete the form and click Submit.</span>';
}
else {
	$ftime = date('YmdHi', time());
	$filename = $dir_journal.$ftime;
	$tit_name = $filename.'_';
	if (isset($_POST['lable']))
		for ($ix = 0; $ix !== count($_POST['lable']); ++$ix) $tit_name = $tit_name.$_POST['lable'][$ix].'_';
	//edit
	if ($isedit) {
		$tit_name = $dir_journal.$edit_t;
		$filename = $dir_journal.$edit_c;
	}
	$needwait = 0;
	if (file_exists($filename) || file_exists($tit_name)) $needwait = 1;
	if ($isedit) {
		if ($needwait === 1) $writeok = 1;
		else {$writeok = 2; $html_post_msg = '<span class="span_blue">Can not find original file.</span>';}
	}
	if (!$isedit) {
		if ($needwait === 0) $writeok = 1;
		else {$writeok = 2; $html_post_msg = '<span class="span_blue">You have recently posted, Please wait '.$needwait.' minute.</span>';}
	}
}
//minicode
if ($writeok === 1) {
	//minicode [lead_define]
	if (!$lead_find_ready) $lead_find_ok = minicode_lead_define($_POST['content'], $lead_arr_1, $lead_arr_2, $lead_str);
	//array minicode
	$co_arr = array();
	$process = true;
	$p_start = 0;
	//
	while ($process) {
		//process
		$need_try = true;
		$p_offset = 0;
		$p_end = false;
		$p_end_len = false;
		$ix = 0;
		while ($need_try)
			minicode_find($process, $p1, $p2, $p_start, $p_offset,
				$_POST['content'], $need_try, $minicode, $content_len, $minicode_e,
				$p_end, $p_end_len, $ix);
		if ($process && $p1 !== $p_start)
			//htmlspecialchars
			array_push($co_arr, nl2br(htmlspecialchars(substr($_POST['content'], $p_start, $p1-$p_start), ENT_QUOTES)));
		if ($process) {
			//execute minicode
			$do_edit = substr($_POST['content'], $p1, $p_end_len);
			minicode($do_edit, $ix);
			array_push($co_arr, $do_edit);
			$p_start = $p_end+strlen($minicode_e[$ix]);
			if ($p_start === $content_len) $process = false;
		}
		//htmlspecialchars
		else array_push($co_arr, nl2br(htmlspecialchars(substr($_POST['content'], $p_start), ENT_QUOTES)));
		//minicode array over
	}
	//minicode [lead_define]
	if ($lead_find_ok) {
		$co_arr = str_replace($lead_arr_1, $lead_arr_2, $co_arr);
		$co_temp = array();
		$lead_str = substr($lead_str, 13, strlen($lead_str)-27);
		$lead_str = nl2br(htmlspecialchars($lead_str, ENT_QUOTES));
		$lead_str = '<span style="display: none;"><!--mi_lead-->'.$lead_str.'</span><!--mi_lead-->';
		array_push($co_temp, $lead_str);
		$co_arr = array_merge($co_temp, $co_arr);
	}
	//edit
	if ($isedit) $fp = fopen($filename, 'wb');
	else $fp = fopen($filename, 'xb');
	if ($fp) {
		//write
		for ($ix = 0; $ix !== count($co_arr); ++$ix) fwrite($fp, $co_arr[$ix]);
		if ($isedit) $html_post_msg = '<span class="span_red">'.'Text edit OK!...</span><br/>';
		else $html_post_msg = '<span class="span_red">'.'Text upload OK!...</span><br/>';
	}
	else $writeok = 2;
	fclose($fp);
	//abstract
	$file_abst = str_replace($dir_journal, $dir_abstract, $filename);
	$fp = fopen($file_abst, 'wb');
	if ($fp) {
		//write
		for ($ix = 0; $ix !== count($co_arr); ++$ix) {
			fwrite($fp, $co_arr[$ix]);
			if (strpos($co_arr[$ix], '<!--m11--><!--m11b-->') !== false) break;
		}
		if ($isedit) $html_post_msg .= '<span class="span_red">'.'Abstract edit OK!...</span><br/>';
		else $html_post_msg .= '<span class="span_red">'.'Abstract upload OK!...</span><br/>';
	}
	else $writeok = 2;
	fclose($fp);
}
if ($writeok === 1) {
	//edit
	if ($isedit) $fp = fopen($tit_name, 'wb');
	else $fp = fopen($tit_name, 'xb');
	if ($fp) {
		$_POST['title'] = trim($_POST['title']);
		$_POST['title'] = htmlspecialchars($_POST['title']);
		if (get_magic_quotes_gpc()) $_POST['title'] = stripslashes($_POST['title']);
		fwrite($fp, $_POST['title']);
		if ($isedit) {
			$html_post_msg .= '<span class="span_red"><a href="index.php?p='.$edit_t.'">'.$tit_name.'</a> edit OK!</span>';
			$isedit = false;
		}
		else $html_post_msg .= '<span class="span_red">'.$tit_name.' upload OK!</span>';
		//clear temp
		$t2_temp = '';
		$t1_temp = '';
	}
	fclose($fp);
}
//O=('-'Q) echo
echo 'Write a new post?<br/>--------<br/><br/>';
echo $html_post_msg.'<br/><br/>';
?>
<div class="post_explain">
Simple minicode:<br/>
[code]echo ipconfig[/code]<br/>
[output]ipconfig[/output]<br/>
[img]http://www.endrollex.com/upload/img/2012/hello_world.gif[/img]<br/>
[url]http://google.com[/url], [url]http://baidu.com[baidu[/url]<br/>
[color]#2E8B57]Tomato[/color], [b]Apple[/b], [small]Pear[/small]
<?php
//sytle note
if (file_exists('font/minicode_manual.php'))
	echo '<br/>Manual: <a target="_blank" href="font/minicode_manual.php">minicode_manual.php</a>';
?>
</div >
<!--#..............................................................post input-->
<div class="div_no_class">
<form action="manage.php?m=0" method="post">
<?php
//########Authenticate################################################################
if (isset($_SESSION['v_user'])) {
	$code1 = mt_rand(1, 65536);
	$fp = fopen($checkreload, 'wb');
	if ($fp) {fwrite($fp, $code1); fclose($fp);}
	echo '<input type = "hidden" name = "noreload" value = "'.$code1.'"/>';
}
?>
<?php
//edit hidden
if ($isedit) echo '<input type = "hidden" name = "f_isedit" value = "'.$edit_t.'"/>';
?>
<br/>Title:<br/>
<input type="text" name="title" class="post_input_text" value="<?php echo $t1_temp; ?>"<?php disa2(); ?>/>
<br/>Label:<div class="post_input_text">
<?php
//label
for ($ix = 0; $ix != count($label_code); ++$ix) {
	$checkbox_str = '<input type="checkbox" name="lable[]" value="';
	if (in_array($label_code[$ix], $t3_temp)) echo $checkbox_str.$label_code[$ix].'" checked="checked"';
	else echo $checkbox_str.$label_code[$ix].'"';
	disa($isedit);
	echo '/>'.$label_text[$ix];
}
?>
</div>Content:<br/>
<textarea name="content" rows="35" cols="35" class="post_textarea"<?php disa2(); ?>><?php
$t2_temp = htmlspecialchars($t2_temp, ENT_COMPAT, 'UTF-8');
echo $t2_temp; ?></textarea>
<br/>
<input type="submit" value="Post"<?php disa2(); ?>/>
</form>
</div>
<br/><br/></div><!--/trace.post_div-->
<!--clear both--><div></div>