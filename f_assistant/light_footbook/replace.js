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
	var inp2 = thisfrom.input2.value;
	inp1 = pre_txt(inp1);
	inp2 = inp2.replace(/\n/g, "<br/>");
	inp2 = inp2.replace(/\r/g, "");
	var in1s1 = new Array();
	var in1s2 = new Array();
	for (var ix = 0; ix != inp1.length; ++ix) {
		var inp_tmp = inp1[ix].split(",");
		if (inp_tmp[0] && inp_tmp[1]) {
			in1s1.push(inp_tmp[0]);
			in1s2.push(inp_tmp[1]);
		}
	}
	for (var ix = 0; ix != in1s1.length; ++ix) {
		var sea_str = new RegExp(in1s1[ix], "g");
		if (thisfrom.format.value == 2) sea_str = new RegExp(in1s1[ix], "gi");
		inp2 = inp2.replace(sea_str, in1s2[ix]);
	}
	var dis = "";
	dis = inp2;
	document.getElementById("dis").innerHTML = dis;
	return false;
}
function form_sub() {
	document.getElementById("setcalc").onsubmit();
}
function form_reset() {
	window.location.reload();
}