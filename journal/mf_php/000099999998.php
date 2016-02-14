<?php
//miniroll title search pulg-in
$this_file = '000099999998';
$search_max = 65536;
$search_msg = 'Test version';
$search_go = false;
$search_all = false;
$search_type = 'tit';
$search_cache = false;
$search_method_elim = false;
if (isset($_POST['search_type'])) {
	if ($_POST['search_type'] === 'all') {$search_all = true; $search_type = 'all';}
}
if (isset($_GET['search_type'])) {
	if ($_GET['search_type'] === 'all') {$search_all = true; $search_type = 'all';}
	if ($_GET['search_type'] === 'cache') $search_cache = true;
}
if (isset($_POST['search_tit'])) $search_tit_keyword_o = trim(htmlspecialchars($_POST['search_tit']));
if (isset($_GET['search_tit'])) $search_tit_keyword_o = trim(htmlspecialchars($_GET['search_tit']));
if (isset($search_tit_keyword_o)) {
	//UTF-8 special whitespace
	$search_tit_keyword = str_replace(' ', 'k1i2n3g4s', $search_tit_keyword_o);
	$search_tit_keyword = preg_replace("#(k1i2n3g4s)+#", ' ', $search_tit_keyword);
	if (strlen($search_tit_keyword) > 1 && strlen($search_tit_keyword) < 100) {
		$search_go = true;
		$search_msg = 'Key word: '.$search_tit_keyword;
	}
	else {if (strlen($search_tit_keyword) > 0) $search_msg = 'Key word too short or too long';}
	if ($search_cache) $search_go = false;
}
echo $search_msg;
//blild search index, test version
//skip tab
if ($search_go) {
$search_index_o = array();
$count_search_index_o = 0;
if ($dh = opendir($dir_journal)) {
	while(($file_name = readdir($dh)) !== false) {
		if (strlen($file_name) > 12) array_push($search_index_o, $file_name);
	}
	closedir($dh);
	//sort
	sort($search_index_o);
	$count_search_index_o = count($search_index_o);
	if ($count_search_index_o > $search_max) {
		$max_cut_temp = array();
		for ($ix98 = $count_search_index_o-$search_max; $ix98 !== $count_search_index_o; ++$ix98)
			array_push($max_cut_temp, $search_index_o[$ix98]);
		$search_index_o = $max_cut_temp;
	}
	$count_search_index_o = count($search_index_o);
}
$newest_file = '';
if ($count_search_index_o > 0) $newest_file = substr($search_index_o[$count_search_index_o-1], 0, 12);
$last_reflush = 0;
$flush_file = $dir_mf.$this_file.'_new';
$flush_file2 = $dir_mf.$this_file.'_tit';
//flush
$search_index_get = array();
if (file_exists($flush_file2)) $search_index_get = file($flush_file2);
if (file_exists($flush_file)) $last_reflush = file_get_contents($flush_file);
$need_rebuild = false;
//when exceed $search_max, !== donot work
if ($newest_file > $last_reflush || !file_exists($flush_file2) || $count_search_index_o !== count($search_index_get))
	$need_rebuild = true;
$search_index_txt = array();
if ($need_rebuild) {
	file_put_contents($flush_file, $newest_file);
	$search_index_txt = array();
	//title+file_name
	for ($ix98 = 0; $ix98 !== $count_search_index_o; ++$ix98)
		array_push($search_index_txt, file_get_contents($dir_journal.$search_index_o[$ix98]).'<!--'.$search_index_o[$ix98].'-->');
	//delete and rebuild
	$fp = false;
	if (file_exists($flush_file2)) file_put_contents($flush_file2, '');
	$fp = fopen($flush_file2, 'ab');
	if ($fp) {
		for ($ix98 = 0; $ix98 !== count($search_index_txt); ++$ix98) fwrite($fp, $search_index_txt[$ix98]."\r\n");
		fclose($fp);
	}
	//flush
	if (file_exists($flush_file2)) $search_index_get = file($flush_file2);
}
//input key
$search_tit_keyword_a = explode(' ', $search_tit_keyword);
//search process
$search_res_ix98 = array();
$search_res_temp = array();
$eliminate_list = array();
$eliminate_line = '_';
for ($ix98 = 0; $ix98 !== $count_search_index_o; ++$ix98) {
	array_push($eliminate_list, false);
	array_push($search_res_temp, $ix98);
}
//ready for search all
$search_res_ix98_all = $search_res_temp;
//process function, pay attention to subscript
function search_proc(
	&$para_search_res_temp,
	&$para_search_res_ix98,
	&$para_search_tit_keyword_a,
	&$para_search_method_elim,
	&$para_eliminate_list,
	&$para_search_index_get,
	&$para_eliminate_line,
	$is_tit,
	&$para_search_index_o,
	&$para_dir) {
	for ($aix98 = 0; $aix98 !== count($para_search_tit_keyword_a); ++$aix98) {
		$search_tit_keyword = $para_search_tit_keyword_a[$aix98];
		$para_search_res_ix98 = array();
		$logic_and = true;
		if (substr($search_tit_keyword, 0, 1) === '-') {
			$search_tit_keyword = substr($search_tit_keyword, 1);
			$logic_and = false;
			//eliminate
			$para_search_method_elim = true;
		}
		for ($ix98 = 0; $ix98 !== count($para_search_res_temp); ++$ix98) {
			if (!$para_eliminate_list[$para_search_res_temp[$ix98]]) {
				$sea_bingo = false;
				$search_nowix = $para_search_res_temp[$ix98];
				if ($is_tit) $sea_bingo = stripos($para_search_index_get[$search_nowix], $search_tit_keyword);
				else $sea_bingo = stripos(strip_tags(file_get_contents($para_dir.substr($para_search_index_o[$search_nowix],
					0, 12))), $search_tit_keyword);
				if ($sea_bingo !== false) {
					if ($logic_and) array_push($para_search_res_ix98, $search_nowix);
					else {$para_eliminate_list[$search_nowix] = true; $para_eliminate_line .= $search_nowix.'_';}
				}
				else {
					if (!$logic_and) array_push($para_search_res_ix98, $search_nowix);
				}
			}
		}
		$para_search_res_temp = $para_search_res_ix98;
	}
}
search_proc($search_res_temp, $search_res_ix98, $search_tit_keyword_a, $search_method_elim, $eliminate_list,
	$search_index_get, $eliminate_line, true, $search_index_o, $dir_journal);
//ready show result
$count_search_res_ix98 = count($search_res_ix98);
//search all text
if ($search_all) {
	//exclude title result
	if (!$search_method_elim && $count_search_res_ix98 > 0) {
		$search_res_ix98_all = array();
		for ($ix98 = 0; $ix98 != $search_res_ix98[0]; ++$ix98) array_push($search_res_ix98_all, $ix98);
		for ($ix98 = 1; $ix98 !== $count_search_res_ix98; ++$ix98) {
			for ($aix98 = 1+$search_res_ix98[$ix98-1]; $aix98 != $search_res_ix98[$ix98]; ++$aix98)
				array_push($search_res_ix98_all, $aix98);
		}
		for ($ix98 = 1+$search_res_ix98[$count_search_res_ix98-1]; $ix98 !== $count_search_index_o; ++$ix98)
			array_push($search_res_ix98_all, $ix98);
	}
	//search all process
	$search_res_temp = $search_res_ix98_all;
	$is_tit = false;
	search_proc($search_res_temp, $search_res_ix98_all, $search_tit_keyword_a, $search_method_elim,
		$eliminate_list, $search_index_get, $eliminate_line, false, $search_index_o, $dir_journal);
	//merge result
	if ($search_method_elim) {
		$search_res_temp = $search_res_ix98;
		$search_res_ix98 = array();
		//eliminate
		for ($ix98 = 0; $ix98 !== count($search_res_temp); ++$ix98)
			if (strpos($eliminate_line, '_'.$search_res_temp[$ix98].'_') === false) array_push($search_res_ix98, $search_res_temp[$ix98]);
	}
	$search_res_temp = array_merge($search_res_ix98, $search_res_ix98_all);
	$count_search_res_ix98 = count($search_res_temp);
	$search_res_temp = array_unique($search_res_temp);
	$search_res_ix98 = array();
	for ($ix98 = 0; $ix98 !== $count_search_res_ix98; ++$ix98) {
		if (isset($search_res_temp[$ix98])) array_push($search_res_ix98, $search_res_temp[$ix98]);
	}
	$count_search_res_ix98 = count($search_res_ix98);
}
//show result
$_SESSION['search_cache'] = '';
if ($count_search_res_ix98 > 0) $_SESSION['search_cache'] = ', Found '.$count_search_res_ix98.' post: <br/><br/>';
else $_SESSION['search_cache'] = ', not found.<br/>';
for ($ix98 = $count_search_res_ix98; $ix98 !== 0; --$ix98) {
	$_SESSION['search_cache'] .= '<a href="index.php?p='.$search_index_o[$search_res_ix98[$ix98-1]].'">';
	$_SESSION['search_cache'] .= $search_index_get[$search_res_ix98[$ix98-1]].'</a><br/><br/>';
}
}//
if ($search_go || $search_cache) {
	if (isset($_SESSION['search_cache'])) echo $_SESSION['search_cache'];
$_SESSION['back_here'] = '?p=000099999998_mf_&amp;search_tit='.$search_tit_keyword_o.'&amp;search_type=cache';
}
?>