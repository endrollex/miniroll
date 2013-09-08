<?php
/**
 * Generate homepage's menu, Service for index.php
 *
 * Require files:
 *     index_func.php: Use function menu_mark_show()
 * 
 * There are tow modes for menu
 *     step1:
 *         mode 1: for one by one posts, Please edit $menu_file_list array
 *         mode 2: for same lable posts, Write function menu_mark_show()
 *
 *     step2: Edit index_top.php menu XHTML tags
 *
 *     step3: Edit index.php menu code
 *
 * This file have some CSS class or JS, please modify them for wanted style.
*/
//mode 1: register one by one posts
if (isset($_GET['p'])) {
	$view_file_c = substr($_GET['p'], 0, 12);
	//indicate menu relative files
	$menu_file_list[0] = '000099999998_mf_,000099999997_mf_';
	$menu_file_list[1] = '000099999999_mi_';
	//
	for ($ix_menu = 0; $ix_menu !== count($menu_file_list); ++$ix_menu) {
		if (strpos($menu_file_list[$ix_menu], $view_file_c) !== false) {
			//O=('-'Q) echo
			echo '<div class="div_cpp03a_ct"><img alt="categories" height="17" src="images/categ14px2_what.gif" width="96" /></div>';
			$menu_what_else = array();
			$menu_what_else = explode(',', $menu_file_list[$ix_menu]);
			for ($ix2_menu = 0; $ix2_menu != count($menu_what_else); ++$ix2_menu) {
				if (file_exists($dir.$menu_what_else[$ix2_menu])) {
					$vpass_menu_link = '?p='.$menu_what_else[$ix2_menu];
					$vpass_menu_text = str_replace("\xEF\xBB\xBF", '', file_get_contents($dir.$menu_what_else[$ix2_menu]) );
					$vpass_menu_light = ($menu_what_else[$ix2_menu] === $_GET['p']);
					$vpass_menu_style = 2;
					menu_mark_show($vpass_menu_link, $vpass_menu_text, $vpass_menu_light, $vpass_menu_style);
					$show_left_menu = 2;
				}
			}
			break;
		}
	}
}
//mode 2: for lable
if (isset($_GET['l'])) if ($_GET['l'] === 'do') {
	//O=('-'Q) echo
	echo '<div class="div_cpp03a_ct"><img alt="categories" height="17" src="images/categ14px2_what.gif" width="96" /></div>';
	$vpass_menu_link = '?l=do';
	$vpass_menu_text = 'Download';
	$vpass_menu_light = true;
	$vpass_menu_style = 1;
	menu_mark_show($vpass_menu_link, $vpass_menu_text, $vpass_menu_light, $vpass_menu_style);
	$show_left_menu = 2;
}
?>