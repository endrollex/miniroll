<?php
/**
 * Service for index.php
 * Get post infromations for index.php
 * This file have some CSS class or JS, please modify them for wanted style.
*/
//get meta elements for SEO
function meta_seo_get(
	&$para_get_p,
	&$dir,
	&$label_code,
	&$label_keywords,
	//assign variable
	&$echo_title,
	&$meta_keywords,
	&$meta_description
	) {
	if (file_exists($dir.$para_get_p)) {
		$echo_title = file_get_contents($dir.$para_get_p);
		if (substr($echo_title, 0, 3) == "\xEF\xBB\xBF") $echo_title = substr($echo_title, 3);
		//keywords, keywords is a junk for SEO
		$label_comb = array_combine($label_code, $label_keywords);
		$tag = substr($para_get_p, 11);
		$tag = explode('_', $tag);
		array_pop($tag);
		$meta_keywords = '';
		for ($ix2 = 0; $ix2 !== count($tag); ++$ix2) {
			if (array_key_exists($tag[$ix2], $label_comb)) $meta_keywords .= $label_comb[$tag[$ix2]];
		}
		if ($meta_keywords !== '') $meta_keywords = substr($meta_keywords, 0, strlen($meta_keywords)-1);
		else $meta_keywrods = '';
		//description
		$meta_description = '';
	}
}
//structure dir, ready for reading post data
function structure_dir(
	&$dir,
	&$para_get_p,
	&$global_var_top_post,
	//assign variable
	&$all_file,
	&$all_file_o,
	&$now_page,
	&$pag_sum,
	&$f_sum
	) {
	if (!isset($_SESSION['l'])) $_SESSION['l'] = 'nul';
	//isget_l
	if ($dh = opendir($dir)) {
		while(($file_name = readdir($dh)) !== false) {
			//view label file
			$isget_l = false;
			if ($_SESSION['l'] !== 'nul') {if ($_SESSION['l'] !== 'all') $isget_l = true;}
			if ($isget_l) {
				if(strstr($file_name, $_SESSION['l']) !== false)
					if (strlen($file_name) > 12) array_push($all_file_o, $file_name);
			}
			else if (strlen($file_name) > 12) array_push($all_file_o, $file_name);
		}
		closedir($dh);
		sort($all_file_o);
	}
	//inverse
	if ($para_get_p == '') {
		$file_mt = array();
		$file_normal = array();
		//top
		for ($ix = count($all_file_o)-1; $ix !== -1; --$ix) {
			if (strstr($all_file_o[$ix], $global_var_top_post)) array_push($file_mt, $all_file_o[$ix]); 
			else array_push($file_normal, $all_file_o[$ix]);
		}
		$all_file_o = array_merge($file_mt, $file_normal);
	}
	//view one file
	if ($para_get_p !== '') {
		$file_ready = false;
		for ($ix = 0; $ix !== count($all_file_o); ++$ix)
			if ($all_file_o[$ix] === $para_get_p) {$file_ready = true; break;}
		if ($file_ready) $all_file_o = array($para_get_p);
		else $all_file_o = array();
	}
	//count files
	$f_sum = count($all_file_o);
	$chunk_val = 5;
	if ($_SESSION['l'] !== 'nul') $chunk_val = 10;
	$all_file_o = array_chunk($all_file_o, $chunk_val);
	$pag_sum = count($all_file_o);	
}
//echo menu XHTML
function menu_mark_show(&$menu_link, &$menu_text, &$menu_light, &$menu_style) {
	//$menu_style, value: 2(custom color) other(default color)
	$span_l1 = '';
	$span_l2 = '';
	if ($menu_style === 2 && !$menu_light) {
		$span_l1 = '<span class="span_l_b">';
		$span_l2 = '</span>';
	}
	//color emitting
	if ($menu_light) {
		$span_l1 = '<span class="span_l">';
		$span_l2 = '</span>';
	}
	//O=('-'Q) echo
	echo '<div class="div_cpp03a_c"><a class="lab" href="'.$menu_link.'">'.$span_l1.$menu_text.$span_l2.'</a></div>';
}
//flag for menu_mark_show(..., &$menu_light, ...), control menu style
function light_p($light_get_p) {
	if (isset($_GET['p'])) if ($_GET['p'] == $light_get_p) return true;
	if (isset($_GET['l'])) if ($_GET['l'] == $light_get_p) return true;
	return false;
}
//get post informations
function post_info_get(
	&$view_file,
	&$view_file_c,
	&$dir_comment,
	&$dir,
	&$label_comb,
	&$is_preload_number_to_cn,
	&$para_get_p,
	//assign variable
	&$echo_file_date,
	&$html_view_tag,
	&$echo_comm_size_a,
	&$echo_comm_size_cn,
	&$echo_title,
	&$a_link1,
	&$a_link2,
	&$a_link1v,
	&$a_link1v_comm
	) {
	//file_date
	$echo_file_date = substr($view_file_c, 0, 4).'-'.substr($view_file_c, 4, 2).'-'.substr($view_file_c, 6, 2);
	$echo_file_date .= ' '.substr($view_file_c, 8, 2).':'.substr($view_file_c, 10, 2);
	//tag
	$tag = '';
	$tag = substr($view_file, 13);
	$tag = explode('_', $tag);
	array_pop($tag);	
	$html_view_tag = '';
	for ($ix2 = 0; $ix2 !== count($tag); ++$ix2) {
		if (array_key_exists($tag[$ix2], $label_comb))
			$html_view_tag .= ' <a class="vlink" href="?l='.$tag[$ix2].'">'.$label_comb[$tag[$ix2]].'</a>';
	}
	//show comment size
	$comm_count_file_index = $dir_comment.$view_file_c.'c_count';
	$echo_comm_size_a = 0;
	if (file_exists($comm_count_file_index)) $echo_comm_size_a = (int)file_get_contents($comm_count_file_index);
	if (strlen($echo_comm_size_a) > 10) $echo_comm_size_a = 0;
	//call function change number to chinese
	$echo_comm_size_cn = $echo_comm_size_a;
	if (isset($is_preload_number_to_cn)) if ($is_preload_number_to_cn) number_to_cn($echo_comm_size_a, $echo_comm_size_cn);	
	//link
	if ($para_get_p == '') {
		$a_link2 = '</a>';
		$a_link1 = '<a class="tit" href="?p='.$view_file.'">';
		$a_link1v = '<a class="vlink" href="?p='.$view_file.'">';
		$ex_link = '&amp;copost=1#commtop';
		$a_link1v_comm = '<a class="vlink" href="?p='.$view_file.$ex_link.'">';
	}
	$echo_title = file_get_contents($dir.$view_file);
	if (substr($echo_title, 0, 3) == "\xEF\xBB\xBF") $echo_title = substr($echo_title, 3);
}
//page array
function page_array(
	&$now_page,
	&$pag_sum,
	&$b_cate,
	//	
	&$html_span_page1,
	&$html_span_page2
	) {
	if ($now_page <= 0) $html_span_page1 = '<span class="span_l3">Previous</span> | ';
	else $html_span_page1 = '<a class="page" href="?next='.($now_page-1).$b_cate.'">Previous</a> | ';
	if ($now_page >= $pag_sum-1) $html_span_page1 .= '<span class="span_l3">Next page</span> | ';
	else $html_span_page1 .= '<a class="page" href="?next='.($now_page+1).$b_cate.'">Next page</a> | ';
	if ($pag_sum !== 1) {
		$html_span_page1 .= '<a class="page" href="?next=0'.$b_cate.'">0</a>-'.
			'<a class="page" href="?next='.($pag_sum-1).$b_cate.'">'.($pag_sum-1).'</a>';
	}
	else $html_span_page1 .= '<span class="span_l3">0-0</span>';
	
	for ($ix = 0; $ix != $pag_sum; ++$ix) {
		if ($ix == $now_page) $html_span_page2 .= '<span class="span_l3">'.$ix.'</span> ';
		else {
			$np_offset = 50;
			if ($ix > $now_page-$np_offset && $ix < $now_page+$np_offset)
				$html_span_page2 .= '<a class="page" href="?next='.$ix.$b_cate.'">'.$ix.'</a> ';
		}
	}
}
//######## Preload function: change number to chinese
//# This is not necessary.
//################################
$is_preload_number_to_cn = false;
if (isset($show_top2)) {if ($show_top2) $is_preload_number_to_cn = false;}
function number_to_cn(&$comm_size_index, &$comm_size_cn_num) {
	//function change number to chinese
	$comm_size_cn_num = '零';
	$num_ar = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	$num_cn_ar = array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
	$num_cn_dig = array('拾', '佰', '仟');
	//use "Zhong Shu" system
	$num_abc = array('aa', 'bb', 'cc', 'dd', 'ee', 'ff', 'gg', 'hh');
	$num_shangshu = array('万', '亿', '兆', '京', '垓', '秭', '穰', '溝');
	for ($ix_num_t1 = 0; $ix_num_t1 != count($num_abc); ++$ix_num_t1) {
		for ($ix_num_t2 = 0; $ix_num_t2 != 4; ++$ix_num_t2) {
			$num_temp = $ix_num_t2.$num_abc[$ix_num_t1];
			array_push($num_cn_dig, $num_temp);
		}
	}
	$num_count = strlen($comm_size_index)-1;
	//limit
	if ($num_count > count($num_cn_dig)) {$num_count = 0; $comm_size_cn_num = '超过壹涧';}
	else $comm_size_cn_num = str_replace($num_ar, $num_cn_ar, $comm_size_index);
	if ($comm_size_index == 2) $comm_size_cn_num = '两';
	for ($ix_num = 0; $ix_num != $num_count; ++$ix_num) {
		if ($num_count > $ix_num) {
			$cn_str = $num_cn_dig[$ix_num];
			//when number > 999
			if ($ix_num > 2) {
				$cn_check = substr($cn_str, 1, 2);
				if (strpos($comm_size_cn_num, $cn_check) !== false) $cn_str = substr($cn_str, 0, 1).'00';
			}
			if (substr($comm_size_cn_num, ($ix_num+1)*(-6), 3) === '零') $cn_str = '000';
			$comm_size_cn_num = substr_replace($comm_size_cn_num, $cn_str, $ix_num*(-6)+(-3), 0);
		}
	}
	$comm_size_cn_num = str_replace($num_abc, $num_shangshu, $comm_size_cn_num);
	for ($ix_num = 1; $ix_num != 4; ++$ix_num) 
		$comm_size_cn_num = str_replace($ix_num, $num_cn_dig[$ix_num-1], $comm_size_cn_num);
	$comm_size_cn_num = str_replace('0', '', $comm_size_cn_num);
	$comm_size_cn_num = str_replace('壹拾', '拾', $comm_size_cn_num);
	while (strpos($comm_size_cn_num, '零零') !== false)
		$comm_size_cn_num = str_replace('零零', '零', $comm_size_cn_num);
	if ($comm_size_index != 0 && substr($comm_size_cn_num, -3, 3) === '零')
		$comm_size_cn_num = substr_replace($comm_size_cn_num, '', -3, 3);
}
?>