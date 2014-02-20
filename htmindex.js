//for comment.php, comment_w.php
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
//i_dev_width: viewport
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
//post_bottom.php package function
function package_post() {
	if (i_is_mobile) document.getElementById("dom_index01").style.backgroundImage = "url('images/alge_bg1_320b.gif')";
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