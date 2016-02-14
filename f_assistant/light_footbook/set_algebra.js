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
	function set_add(set_a, set_b) {
		var ret = set_a.concat(set_b);
		return ret;
	}
	function set_mul(set_a, set_b) {
		var ret = new Array();
		for (var ix = 0; ix != set_a.length; ++ix) {
			for (var ix2 = 0; ix2 != set_b.length; ++ix2) {
				if (set_a[ix] == set_b[ix2]) ret.push(set_a[ix]);
			}
		}
		return ret;
	}
	function set_sub(set_a, set_b) {
		var ret = new Array();
		var set_b_line = "\n";
		for (var ix = 0; ix != set_b.length; ++ix) {
			set_b_line = set_b_line+set_b[ix]+"\n";
		}
		for (var ix = 0; ix != set_a.length; ++ix) {
			if (set_b_line.indexOf(set_a[ix]) == -1) {
				ret.push(set_a[ix]);
			}
		}
		return ret;
	}
	function exist_id(what_tag, find_id) {
		var tagget = document.getElementsByTagName(what_tag);
		for (var ix = 0; ix != tagget.length; ++ix) {
			if (tagget[ix].id == find_id) return true;
		}
		return false;
	}
	//input
	var inp1 = thisfrom.input1.value;
	var inp2 = thisfrom.input2.value;
	inp1 = pre_txt(inp1);
	inp2 = pre_txt(inp2);
	var disp_t = new Array();
	if (exist_id("input", "calc1b")) disp_t = set_add(inp1, inp2);
	if (exist_id("input", "calc2b")) disp_t = set_mul(inp1, inp2);
	if (exist_id("input", "calc3b")) disp_t = set_sub(inp1, inp2);
	if (exist_id("input", "calc4b")) disp_t = set_sub(inp2, inp1);
	//delete repeat
	var disp = new Array();
	for (var ix = 0; ix != disp_t.length; ++ix) {
		var ismatch = false;
		for (var ix2 = 0; ix2 != disp.length; ++ix2) {
			if (disp[ix2] == disp_t[ix]) ismatch = true;
		}
		if (!ismatch) disp.push(disp_t[ix]);
	}
	if (disp.length == 0) disp.push("Empty Set");
	if (thisfrom.format.value == 2) {
		disp_t = disp;
		disp = "";
		for (var ix = 0; ix != disp_t.length; ++ix) {
			disp = disp+disp_t[ix]+"<br/>"
		}
	}	
	document.getElementById("dis").innerHTML = disp;
	return false;
}
function form_sub(ori_id) {
	var now_id = ori_id+"b";
	document.getElementById(ori_id).id = now_id;
	document.getElementById("setcalc").onsubmit();
	document.getElementById(now_id).id = ori_id;
}