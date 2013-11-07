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