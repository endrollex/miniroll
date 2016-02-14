<?php
/**
 * Link relative posts, Service for index.php
 * Please edit $menu_file_list array
*/
?>
<?php
//here register menu
if (isset($_GET['p']) && isset($view_file_c)) {
	//indicate relative links
	$menu_file_list = array();
	$menu_file_list[0] = '201301291539_ph_,201301141050_ph_';
	$menu_file_list[1] = '201302221548_wa_,201302241812_wa_';
	$menu_file_list[2] = '201303222300_fo_rp_,201303222327_fo_rp_,201303222342_fo_rp_';
	//
	function link_make($menu_link, $menu_text) {
		//O=('-'Q) echo
		echo '<br/><a class="m4b" href="'.$menu_link.'">'.$menu_text.'</a>';
	}
	for ($ix_menu = 0; $ix_menu !== count($menu_file_list); ++$ix_menu) {
		if (strpos($menu_file_list[$ix_menu], $view_file_c) !== false) {
			//O=('-'Q) echo
			echo '<br/>Relative posts: ';
			$menu_file_list[$ix_menu] .= ',';
			$menu_file_list[$ix_menu] = str_replace($_GET['p'].',', '', $menu_file_list[$ix_menu]);
			$menu_file_list[$ix_menu] = substr($menu_file_list[$ix_menu], 0, strlen($menu_file_list[$ix_menu])-1);
			$menu_what_else = array();
			$menu_what_else = explode(',', $menu_file_list[$ix_menu]);
			for ($ix2_menu = 0; $ix2_menu != count($menu_what_else); ++$ix2_menu) {
				if (file_exists($dir_journal.$menu_what_else[$ix2_menu]))
					link_make('?p='.$menu_what_else[$ix2_menu],
						str_replace("\xEF\xBB\xBF", '', file_get_contents($dir_journal.$menu_what_else[$ix2_menu]) ) );
			}
			break;
		}
	}
}
?>