<?php
/**
 * index.php, main producer creates HTML tags, default entrance.
 *
 * Require files (Entire website front):
 *     htmindex.css: All in one CSS
 *     htmindex.js: Get browser's screen size
 *     index_top.php: Top part of index.php
 *     comment.php: Comment module
 *     comment_w.php: Echo guest comment form
 *     journal_menu/register_menu.php: Where left menu's protocol
 *     global_var.php: Global variable
 *     index_func.php: Functions for index.php
 *     journal/mf_php: The dir which label load PHP files, see index.php and global_var.php
 *
 * Third party codes:
 *     f_assistant/jwplayer: JW Player, media player
 *     f_assistant/prettify: prettify, syntax highlighting
 *
 * Copyright 2013 Huang Yiting (http://endrollex.com)
 * miniroll is distributed under the terms of the GNU General Public License
*/
//show_top2 means index echo a signle journal with top2 style
$show_top2 = false;
require('global_var.php');
require('index_func.php');
//meta elements
$echo_title = 'Sample Blog';
$meta_keywords = 'Blog';
$meta_description = 'Sample Blog';
$para_get_p = '';
if (isset($_GET['p'])) {
	if (strlen($_GET['p']) < 10) $_GET['p'] = 'bad_value';
	$para_get_p = $_GET['p'];
	meta_seo_get(
		$para_get_p,
		$dir_journal,
		$label_code,
		$label_keywords,
		$echo_title,
		$meta_keywords,
		$meta_description);
}
if (isset($_GET['l']) || isset($_GET['next'])) {
	if (isset($_GET['l'])) if (strlen($_GET['l']) < 1) $_GET['l'] = 'bad_value';
	$show_desc = true;
	if (isset($_GET['next']) && !isset($_GET['l'])) {if ($_GET['next'] == 0) $show_desc = false;}
	if ($show_desc) $meta_description = '';
}
if (isset($_GET['p'])) if (!strstr($_GET['p'], '0000999999')) $show_top2 = true;
//top or top2
if ($show_top2) require('index_top2.php');
else require('index_top.php');
//variable initialize
$view_file = '';
$view_file_c = '';
//browse control's parameters for individual pages:
//$_GET['l']: post's label
//$_GET['p']: post's filename
//$_SESSION['l']: post's label session store
//$_SESSION['next_sav']: which page is reading
if (!isset($_SESSION['l'])) $_SESSION['l'] = 'nul';
if (isset($_GET['p'])) {if(strstr($_GET['p'], $_SESSION['l']) === false) $_SESSION['l'] = 'nul';}
else $_SESSION['l'] = 'nul';
if (isset($_GET['l'])) $_SESSION['l'] = $_GET['l'];
if (!isset($_SESSION['next_sav'])) $_SESSION['next_sav'] = 0;
//
$http_str .= <<<EOT
<div class="div_cpp02" id="dom_div_cpp02"><!--trace.div_cpp02-->
<div class="div_cpp02_menu_mobile" id="dom_div_cpp02_menu_mo"></div>
<!--#..............................................................table-->
<table class="table_cpp02" id="dom_table_cpp02"><tr><td class="td_cpp03a" id="dom_td_cpp03a">
<!--#..............................................................left area show menu-->
<div class="div_cpp03a" id="dom_div_cpp03a"><!--trace.div_cpp03a-->
<br/>
EOT;
//
//browse control back button
if (isset($_SESSION['back_here'])) unset($_SESSION['back_here']);
//label ini
$label_comb = array_combine($label_code, $label_text);
//menu code
//$show_left_menu, value: 0(home menu), 1(temp value), other(other menu or show nothing)
$show_left_menu = 0;
if (isset($_GET['l'])) if ($_GET['l'] === 'do') $show_left_menu = 1;
if (isset($_GET['p']) || $show_left_menu === 1) {
	//other menu
	if (file_exists($dir_leftmenu.'register_menu.php')) require($dir_leftmenu.'register_menu.php');
}
//menu code, echo home menu
if ($show_left_menu === 0) {
	//
	$http_str .= '<div class="div_cpp03a_ct"><img alt="categories" height="17" src="images/categ14px2.gif" width="108" /></div>';
	$vpass_menu_link = '?l=all';
	$vpass_menu_text = 'All';
	$vpass_menu_light = ($_SESSION['l'] === 'all');
	$vpass_menu_style = 1;
	menu_make($vpass_menu_link, $vpass_menu_text, $vpass_menu_light, $vpass_menu_style, $http_str);
	//hidden last label
	for ($ix_index = 0; $ix_index !== count($label_text); ++$ix_index) {
		if (in_array($label_code[$ix_index], $label_hidden)) continue;
		$menu_light = false;
		if ($_SESSION['l'] !== 'nul' && $_SESSION['l'] !== 'all') if ($_SESSION['l'] === $label_code[$ix_index]) {
			$menu_light = true;
		}
		$vpass_menu_link = '?l='.$label_code[$ix_index];
		$vpass_menu_style = 1;
		menu_make($vpass_menu_link, $label_text[$ix_index], $menu_light, $vpass_menu_style, $http_str);
	}
}
//structure dir
$all_file = array();
$all_file_o = array();
$now_page = 0;
$pag_sum = 0;
$f_sum = 0;
structure_dir(
	$dir_journal,
	$para_get_p,
	$global_var_top_post,
	$suffix_not_show_in_all,
	$all_file,
	$all_file_o,
	$now_page,
	$pag_sum,
	$f_sum);
//page get
if (isset($_GET['next'])) {
	if ($_GET['next'] >= 0 && $_GET['next'] <= $pag_sum-1) $now_page = $_GET['next'];
}
if (isset($_SESSION['next_sav'])) $_SESSION['next_sav'] = $now_page;
if ($f_sum !== 0) $all_file = $all_file_o[$now_page];
//ready view
$is_empty = true;
if (isset($all_file[0])) $is_empty = false;
//
$http_str .= <<<EOT
</div><!--/trace.div_cpp03a-->
<!--|..............................................................table-->
</td><td class="td_cpp03b" id="dom_td_cpp03b">
<script type="text/javascript">
scr_nor_width();
scr_rig_width();
scr_mobile_opti1();
</script>
<!--|..............................................................right area show detail-->
EOT;
//
//float style let code show completed
$hatt_div_c = ' class="div_cpp03b"';
if (!isset($_GET['p'])) $hatt_div_c = '';
$hatt_div_c .= ' id="dom_div_cpp03b"';
//read, $a_link2 for all a_link* end tag
$a_link1 = '';
$a_link2 = '';
$a_link1v = '';
$a_link1v_comm = '';
//control read content or not
//the view control setting please see index_top.php and post_top.php
$show_content = false;
if (isset($_GET['p']) || $_SESSION['l'] === 'nul') $show_content = true;
$show_viewlink = false;
if ($_SESSION['l'] === 'nul' && !isset($_GET['p'])) $show_viewlink = true;
//data
$html_data_err = '';
if ($is_empty) {
	header("HTTP/1.0 404 Not Found");
	$html_data_err = '<div class="div_cpp03b_pt_content"><br/>404 (not found)<br/></div>';
}
//O=('-'Q) echo
$http_str .= '<div'.$hatt_div_c.'>';//trace.hatt_div_c
$http_str .= $html_data_err;
echo $http_str;
//
if (!$is_empty) for ($ix_index = 0; $ix_index !== count($all_file); ++$ix_index) {
	$view_file = $all_file[$ix_index];
	$view_file_c = substr($view_file, 0, 12);
	//get post infomation
	post_info_get(
		$view_file,
		$view_file_c,
		$dir_comment,
		$dir_journal,
		$label_comb,
		$para_get_p,
		$echo_file_date,
		$html_view_tag,
		$echo_comm_size_a,
		$echo_comm_size_cn,
		$echo_title,
		$a_link1,
		$a_link2,
		$a_link1v,
		$a_link1v_comm);
	//brief view
	$hatt_cpp03b_p = ' class="div_cpp03b_p"';
	if ($show_viewlink) $hatt_cpp03b_p = ' class="div_cpp03b_p1"';
	//full view, max-height
	if (isset($_GET['p'])) $hatt_cpp03b_p = ' class="div_cpp03b_p"';
	//O=('-'Q) echo
	echo '<div'.$hatt_cpp03b_p.'>';//trace.hatt_cpp03_p
	echo '<div class="div_cpp03b_pd">';
	echo $echo_file_date;
	echo '<span class="span_l2"> | Lable: </span>';
	echo $html_view_tag;
	//for public view, if want private, modify if statement
	//########Authenticate################################################################
	if (isset($_SESSION['v_user']) || !isset($_SESSION['v_user'])) {
		echo "\r\n".'<span class="span_l2"> | </span><form class="form_cpp03b_pd_edit" action="manage.php?m=0" method="post">';
		echo "\r\n".'<input type="hidden" name="edit_d1" value="'.$view_file.'"/>';
		echo '<input type="image" src="images/i_04b_03b_edit.gif" alt="edit" /></form>'."\r\n";
	}
	if (isset($_GET['l'])) echo '<span class="span_l2"> | '.$a_link1v_comm.'Comments: '.$echo_comm_size_a.$a_link2.'</span>';
	echo '</div>';
	//title
	$html_view_title = '';
	if (isset($_GET['p']) && $show_top2) $html_view_title = '<div class="div_cpp03b_pt">'.$echo_title.'<h1 class="h1_cpp03b_pt">'
		.$echo_title.'</h1></div>';
	else $html_view_title = '<div class="div_cpp03b_pt">'.$echo_title.'<span class="span_cpp03b_pt_shadow">'
		.$a_link1.$echo_title.$a_link2.'</span></div>';
	echo $html_view_title;
	//content
	if ($show_content) {
		//session save file name
		$_SESSION['view_file_c'] = $view_file_c;
		//O=('-'Q) echo and readfile
		echo '<br/><div class="div_cpp03b_pt_content">';
		if (!$show_viewlink) {
			if (file_exists($dir_journal.$view_file_c)) readfile($dir_journal.$view_file_c);
			else echo $view_file_c.'Journal file lost.';
		}
		else {
			if (file_exists($dir_abstract.$view_file_c)) readfile($dir_abstract.$view_file_c);
			else echo $view_file_c.'Abstract file lost.';
		}
		//which label load PHP files
		if (strstr($view_file, $post_load_php) !== false) {
			if (file_exists($dir_mf.$view_file_c.'.php')) require($dir_mf.$view_file_c.'.php');
		}
		//O=('-'Q) echo
		echo '</div>';
	}
	//relative links, comments
	if (isset($_GET['p'])) {
		if (file_exists($dir_leftmenu.'register_link.php')) {
			//O=('-'Q) echo
			echo '<div class="div_cpp03b_pt_content">';
			require_once($dir_leftmenu.'register_link.php');
			echo '</div>';
		}
		require_once('comment.php');
	}
	//link bottom
	$html_viewlink = '';
	$hatt_pdown_sty = ' class="div_cpp03b_pdown"';
	if ($show_viewlink) {
		$html_viewlink = $a_link1v.'&gt;View all&lt;'.$a_link2;
		$html_viewlink .= '<span class="span_comm_size1">'.$a_link1v_comm.$echo_comm_size_cn.' Comments&gt;&gt;'.$a_link2.'</span>';
		$hatt_pdown_sty = ' class="div_cpp03b_pdown1"';
	}
	//O=('-'Q) echo
	echo '</div>';///trace.hatt_cpp03_p
	//note 1 space, IE11 not show empty element sometime
	echo '<div'.$hatt_pdown_sty.'> '.$html_viewlink.'</div>';
}
//page array
$b_cate = '';
if ($_SESSION['l'] !== 'nul') $b_cate = '&amp;l='.$_SESSION['l'];
$html_span_page1 = '';
$html_span_page2 = '';
page_array($now_page, $pag_sum, $b_cate, $html_span_page1, $html_span_page2);
//O=('-'Q) echo
echo '<br/><div class="div_page">';
echo $html_span_page1;
echo ' |&nbsp;</div><div class="div_sipage" id="dom_div_sipage">';
echo $html_span_page2;
echo '</div>';
echo '</div>';///trace.hatt_div_c
?>
<script type="text/javascript">
scr_mobile_opti2();
</script>
<!--#..............................................................table-->
</td></tr></table>
<!--#..............................................................right area end-->
<div class="div_cpp_bottom">
<a class="tit" href="index.php?p=000099999999_mi_">Sample Blog</a> | 
<a class="tit" href="manage.php?m=3">management</a> | 
Hello
<?php
//########Authenticate################################################################
$html_li_user = '';
if (isset($_SESSION['v_user'])) {
	$html_li_user = '<a class="tit" href="manage.php?m=3&amp;l=1" target="_blank"> | Logout</a>';
}
//O=('-'Q) echo
echo $html_li_user;
?></div>
</div><!--/trace.div_cpp02-->
</div><!--/trace.div_home_set-->
</body>
</html>