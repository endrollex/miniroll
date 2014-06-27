//comment.php, comment_w.php
//control comment form
var i_disable_comm = 0;
function form_disp(sel_action) {
	if (sel_action == 1) {
		document.getElementById("comment_form01").style.display = "inline";
		document.getElementById("comment_form02").style.display = "inline";
	}
	if (sel_action == 2) {
		document.getElementById("comment_form01").style.display = "none";
		document.getElementById("comment_form02").style.display = "none";
	}
}
function form_dis_comm() {
	document.getElementById("comm").style.display = "none";
	document.getElementById("comm_span1").innerHTML = "(=&#039;.&#039;=)";
	document.getElementById("comment_form01").style.display = "none";
	document.getElementById("comment_form02").style.display = "none";
}
//if gravatar.com is not available
function rep_err(doc_id) {
	document.getElementById(doc_id).src = "/images/bad_gravatar.gif";
}
//index_top.php, i_dev_width: viewport
var i_dev_width = "device-width";
var i_dev_height = "100%";
if (screen.availWidth) {
	if (screen.availWidth > 636 && screen.availWidth < 1112) i_dev_width = screen.availWidth;
}
//detect mobile browser
var i_is_mobile = false;
if (screen.availWidth) if (screen.availWidth < 760) i_is_mobile = true;
if (navigator.userAgent) {
	var i_get_str = navigator.userAgent.match(/(android|webos|blackberry|windows phone|opera mini|iemobile)/i);
	if (i_get_str) i_is_mobile = true;
}
//force_is_moible: 3 = auto, 4 = pc, 5 = mobile
if (force_is_mobile == 5) i_is_mobile = true;
if (force_is_mobile == 4) i_is_mobile = false;
//post_top.php, css function
function scr_post() {
	if (i_is_mobile) document.getElementById("dom_index01").style.backgroundImage = "none";
}
//     _____
//    `.___,'
//     (___)
//     <   >
//      ) (
//     /`-.\
//    /     \
//   / _    _\
//  :,' `-.' `:
//  |         |
//  :         ;
//   \       /
//    `.___.' SSt
//outermost div width overview: |--80% or 96% of body(screen.availWidth)--|, min-width: 610px, max-width: 1200px
//mobile: 360px
//see htmindex.css
//i_normal_width: div_home_set, div_normal
var i_normal_width = 610;
//desktop style resize, if mobile detected, this is disable
if (screen.availWidth) {
	if (screen.availWidth < 760) i_normal_width = screen.availWidth*0.96;
	if (screen.availWidth >= 760 && screen.availWidth < 1100) i_normal_width = screen.availWidth*0.9;
	if (screen.availWidth >= 1100 && screen.availWidth < 1300) i_normal_width = screen.availWidth*0.8;
	if (screen.availWidth > 1300) i_normal_width = screen.availWidth*0.8;
	i_normal_width = parseInt(i_normal_width, 10);
	if (i_normal_width < 610) i_normal_width = 610;
	if (i_normal_width > 1200) i_normal_width = 1200;
}
//i_right_width: td_cpp03b
var i_right_width = 450;
if (screen.availWidth) i_right_width = i_normal_width-160;
//mobile's menu on top, 20 is blank space
if (i_is_mobile) {
	i_normal_width = 360;
	i_dev_width = 360;
	if (screen.availWidth) i_right_width = i_normal_width-20;
}
//i_right_width_fix, real content width, 20 is difference, no use now but hold this value
var i_right_width_fix = i_right_width-20;
//control screen functions
//index_top.php
function scr_viewp() {
	document.write('<meta name="viewport" content="width='+i_dev_width+', initial-scale=1" />');
	if (i_is_mobile) {
		//change CSS
		var str_css = '<style type="text/css">';
		//title
		str_css += '.div_cpp03b_pd {display: inline; margin: 0px;} .span_l2 {display: none;} .form_cpp03b_pd_edit {display: none;} ';
		str_css += 'pre {white-space: pre-wrap;} img {max-width: 100%;} ';
		str_css += '.div_cpp03b_p1 {background-image: none;} .div_cpp03b_p {background-image: none;} ';
		str_css += '.div_cpp03b_pt {font-size: 20px; margin: 2px 0px -2px 0px;} .h1_cpp03b_pt {font-size: 20px; color: #000000;} .span_cpp03b_pt_shadow {color: #000000;} ';
		str_css += 'a.tit:link {color: #000000; text-decoration: none;} a.tit:visited {color: #000000; text-decoration: none;} '
		//div_cpp03b_pdown
		str_css += '.div_cpp03b_pdown {margin: 0px auto 0px auto; width: 96%;} .div_cpp03b_pdown1 {margin: 0px auto 0px auto; width: 96%;} ';
		str_css += '</style>';
		document.write(str_css);
	}
	
}
//index.php
function scr_nor_width() {
	document.getElementById("dom_div_home_set").style.width = i_normal_width+"px";
}
function scr_rig_width() {
	document.getElementById("dom_td_cpp03b").style.width = i_right_width+"px";
}
//mobile
function scr_mobile_opti1() {
	if (i_is_mobile) {
		document.getElementById("dom_div_cpp02_menu_mo").style.width = (i_right_width-10)+"px";
		document.getElementById("dom_td_cpp03a").style.width = "10px";
		//categories
		var i_menu_str = document.getElementById("dom_div_cpp03a").innerHTML;
		document.getElementById("dom_td_cpp03a").innerHTML = "<span style=\"color: white;\">.</span>";
		i_menu_str = i_menu_str.replace(/<div(.+?)>/ig, "");
		i_menu_str = i_menu_str.replace(/<\/div>/ig, " | ");
		i_menu_str = i_menu_str.replace(/<br.{0,1}>/ig, "<!--.-->");
		i_menu_str = i_menu_str.replace(" | ", "<span style=\"color: #FF9C00;\">CATEGORIES: </span>");
		i_menu_str = i_menu_str.replace(/<img(.+?)>/ig, "");
		document.getElementById("dom_div_cpp02_menu_mo").innerHTML = i_menu_str;
		//div_cpp01
		document.getElementById("dom_div_cpp01").style.backgroundImage = "url('images/sword.png')";
		document.getElementById("dom_div_cpp01").style.backgroundPosition = "top center";
		document.getElementById("dom_div_cpp01").style.backgroundRepeat = "no-repeat";
		//ul_top01
		var i_menu_str = document.getElementById("dom_ul_top01").innerHTML;
		i_menu_str = i_menu_str.replace(/li_top01/ig, "li_top01_mo");
		i_menu_str = "<ul class=\"ul_top01\" id=\"dom_ul_top01\">"+i_menu_str+"<\/ul>";
		document.getElementById("dom_div_cpp01").innerHTML = i_menu_str;
		document.getElementById("dom_ul_top01").style.margin = "0px 0px 0px 10px";
	}
}
function scr_mobile_opti2() {
	if (i_is_mobile) {
		//div_sipage
		document.getElementById("dom_div_sipage").style.clear = "both";
		document.getElementById("dom_div_sipage").style.margin = "30px auto -20px auto";
		document.getElementById("dom_div_cpp03b").className = "div_no_class";
	}
}