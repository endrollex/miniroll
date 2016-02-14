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
	//accurate add
	function acc_add(arg1, arg2) {
	    var r1, r2, m;
	    try {r1 = arg1.toString().split(".")[1].length} catch (e) {r1 = 0};
	    try {r2 = arg2.toString().split(".")[1].length} catch (e) {r2 = 0};
	    m = Math.pow(10, Math.max(r1, r2));
	    return (arg1*m+arg2*m)/m;
	}
	//input
	var inp1 = thisfrom.input1.value;
	inp1 = pre_txt(inp1);
	var dis = "";
	var in1s1 = new Array();
	var in1s2 = new Array();
	if (thisfrom.format.value == 2) {
		for (var ix = 0; ix != inp1.length; ++ix) {
			var inp_tmp = inp1[ix].split(",");
			if (inp_tmp[0] && inp_tmp[1]) {
				in1s1.push(inp_tmp[0]);
				in1s2.push(inp_tmp[1]);
			}
		}
		//organize
		inp1 = new Array();
		var inp1_att = new Array();
		var inp1_cnt = new Array();
		for (var ix = 0; ix != in1s1.length; ++ix) {
			var isorg = false;
			for (var ix2 = 0; ix2 != inp1.length; ++ix2) {
				if (in1s1[ix] == inp1[ix2]) {
					isorg = true;
					break;
				}
			}
			if (!isorg) {
				inp1.push(in1s1[ix]);
				var str_push = "="+in1s2[ix];
				inp1_att.push(str_push);
				inp1_cnt.push(1);
			}
			else {
				for (var ix3 = 0; ix3 != inp1.length; ++ix3) {
					if (in1s1[ix] == inp1[ix3]) {
						inp1_att[ix3] = inp1_att[ix3]+"+"+in1s2[ix];
						++inp1_cnt[ix3];
					}
				}
			}
		}
		for (var ix = 0; ix != inp1.length; ++ix) {
			dis = dis+inp1[ix]+","+inp1_cnt[ix]+","+inp1_att[ix]+"<br/>";
		}
		dis = "name,count,sum<br/>"+dis;
		document.getElementById("dis").innerHTML = dis;
	}
	else {
		dis = 0;
		for (var ix = 0; ix != inp1.length; ++ix) {
			var inp_tmp = inp1[ix].split(",");
			if (inp_tmp[0] && inp_tmp[1]) {
				in1s1.push(inp_tmp[0]);
				in1s2.push(inp_tmp[1]);
			}
			else in1s1.push(inp_tmp[0]);
		}
		for (var ix = 0; ix != in1s1.length; ++ix) {
			//if (!isNaN(in1s1[ix])) dis = dis+Number(in1s1[ix]);
			if (!isNaN(in1s1[ix])) dis = acc_add(dis, Number(in1s1[ix]));
			
		}
		for (var ix = 0; ix != in1s2.length; ++ix) {
			//if (!isNaN(in1s2[ix])) dis = dis+Number(in1s2[ix]);
			if (!isNaN(in1s2[ix])) dis = acc_add(dis, Number(in1s2[ix]));
		}
		document.getElementById("dis").innerHTML = dis;
	}
	return false;
}
function form_sub() {
	document.getElementById("setcalc").onsubmit();
}
function form_reset() {
	window.location.reload();
}