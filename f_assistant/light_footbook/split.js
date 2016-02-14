function setcalc(thisfrom) {
	//input
	var inp1 = thisfrom.input1.value;
	var i_slen = thisfrom.i_slen.value;
	i_slen = i_slen.match(/[0-9]+/g);
	i_slen = Math.round(Number(i_slen));
	var dis = "";
	if (i_slen < 1 || i_slen > inp1.length || i_slen.length == 0) {
		i_slen = 1;
		document.getElementById("dis").innerHTML = "slice length error";
		return false;
	}
	var i_chunk = (inp1.length-(inp1.length%i_slen))/i_slen;
	for (var ix = 0; ix != i_chunk; ++ix) {		
		var i_start = ix*i_slen;
		var i_end = i_start+i_slen;
		dis += inp1.slice(i_start, i_end)+"<br/>";
	}
	if (inp1.length%i_slen != 0) dis += inp1.slice(i_chunk*i_slen)+"<br/>";
	document.getElementById("dis").innerHTML = dis;
	return false;
}
function form_sub() {
	document.getElementById("setcalc").onsubmit();
}
function form_reset() {
	window.location.reload();
}