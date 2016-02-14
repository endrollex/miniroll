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
$label_code = array('bo', 'mi', 'mf', 'al', 'do');
$label_text = array(
	'Book', 'Misc', 'Blog Func()', 'Album', 'Download'
);
//which label load PHP script files
$post_load_php = $label_code[2].'_';
//for SEO
//add ',' to every end of keyword,
$label_keywords = array(
	'Book,', 'Misc,', 'Blog Func(),', 'Album,', 'Download,'
);
//top post
$global_var_top_post = 'if_need_top_enter_filename';
//journal dir
$dir_journal = 'journal/';
$dir_abstract = 'journal/abstract/';
$dir_mf = 'journal/mf_php/';
$dir_comment = 'az_comment/';
$dir_leftmenu = 'journal_menu/';
$dir_manage = 'manage_dir/';
//timezone
date_default_timezone_set('Etc/GMT-8');
//session
session_start();
//comment_w.php, determine whether or not the user is human
$force_determine = false;
//server features
$enabled_https = false;
//
?>