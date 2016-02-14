function setcalc(thisfrom) {
	function pre_txt(inp_txt) {
		inp_txt = inp_txt.replace(/\r/g, "");
		inp_txt = inp_txt.replace(/\n+/g, "\n");
		inp_txt = inp_txt.replace(/^\n+/, "");
		inp_txt = inp_txt.replace(/\n+$/, "");
		inp_txt = inp_txt.split(/\n/);
		if (inp_txt.length == 1 && inp_txt == "") inp_txt = new Array();
		return inp_txt;
	}
	//input
	var inp1 = thisfrom.input1.value;
	inp1 = pre_txt(inp1);
	if (thisfrom.format.value == 1) inp1 = inp1.sort();
	else inp1 = inp1.reverse();
	var dis = "";
	for (var ix = 0; ix != inp1.length; ++ix) {
		dis += inp1[ix]+"<br/>";
	}
	document.getElementById("dis").innerHTML = dis;
	return false;
}
function form_sub() {
	document.getElementById("setcalc").onsubmit();
}
function form_reset() {
	window.location.reload();
}