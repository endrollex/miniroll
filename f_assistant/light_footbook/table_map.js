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
	inp2 = pre_txt(inp2);
	//
	var in1s_arr = new Array();
	var in1s_match = new Array();
	for (var ix = 0; ix != inp1.length; ++ix) {
		var tmp = inp1[ix].split(",");
		in1s_arr.push(tmp);
		in1s_match.push(false);
	}
	//
	var in2s1 = new Array();
	var in2s2 = new Array();
	for (var ix = 0; ix != inp2.length; ++ix) {
		var inp_tmp = inp2[ix].split(",");
		if (inp_tmp[0] && inp_tmp[1]) {
			in2s1.push(inp_tmp[0]);
			in2s2.push(inp_tmp[1]);
		}
	}
	var in_map = new Array();
	for (var ix = 0; ix != in2s1.length; ++ix) {
		var match_done = false;
		for (var ix2 = 0; ix2 != in1s_arr.length; ++ix2) {
			var in_offset = in1s_arr[ix2][0].length-in2s1[ix].length;
			if (thisfrom.format.value == 2) in_offset = 0;
			if (in2s1[ix] == in1s_arr[ix2][0].substr(in_offset) && !in1s_match[ix2]) {
				var tmp = new Array(in2s2[ix]);
				tmp = tmp.concat(in1s_arr[ix2]);
				in_map.push(tmp);
				in1s_match[ix2] = true;
				match_done = true;
				break;
			}
		}
		if (!match_done) {
			var tmp2 = new Array(in2s2[ix], in2s1[ix],
				'<span style="color: blue;">[ <span style="background-color: #FF9632;">MISMATCH</span> ]</span>');
			in_map.push(tmp2);
		}
	}
	for (var ix = 0; ix != in1s_match.length; ++ix) {
		if (!in1s_match[ix]) {
			var tmp = new Array('<span style="color: blue;">[ <span style="background-color: #FF9632;">MISMATCH</span> ]</span>');	
			tmp = tmp.concat(in1s_arr[ix]);
			in_map.push(tmp);
		}
	}
	var dis = "";
	for (var ix = 0; ix != in_map.length; ++ix) {
		dis += in_map[ix]+"<br/>";
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