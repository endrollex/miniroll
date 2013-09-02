<?php
/**
 * Global and inital variable, Service for all PHP
 * Define labels, SEO, dir, post load PHP
 * $label_code, $label_text, $label_keywords, all array length require equal
 *
 * Copyright 2013 Huang Yiting (http://endrollex.com)
 * miniroll is distributed under the terms of the GNU General Public License
*/
//Encoding Type: UTF-8(w/o BOM)
//label ini
$label_code = array('bo', 'mi', 'mf', 'do');
$label_text = array(
	'Book', 'Misc', 'plug-in', 'Download'
);
//which label load PHP script files
$post_load_php = $label_code[2].'_';
//for SEO
$label_keywords = array(
	'Book,', 'Misc,', 'plug-in,', 'Download,'
);
//top post
$global_var_top_post = 'if_need_top_enter_filename';
//journal dir
$dir = 'journal/';
$dir_mf = 'journal/mf_php/';
$dir_comment = 'az_comment/';
$dir_leftmenu = 'journal_menu/';
$dir_manage = 'manage_dir/';
//timezone
date_default_timezone_set('Etc/GMT-8');
//session
session_start();
//addition...
?>