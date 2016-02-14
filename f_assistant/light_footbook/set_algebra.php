<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Light Footbook</title>
<style type="text/css">
textarea {font-size: 14px;}
</style>
</head>
<body style="font-family: 'Courier New', Courier, monospace; font-size: 14px;">
<script type="text/javascript" src="set_algebra.js"></script>
<form action="#" id="setcalc" onsubmit="return setcalc(this)" method="post" >
Purpose: Set algebra<br/>
Input: Please use line break separate elements:<br/><br/>
A = <textarea name="input1" rows="10" cols="20">apple
orange
tomato</textarea>, B = 
<textarea name="input2" rows="10" cols="20">tomato
pea</textarea><br/><br/>
Display format: <select name="format">
<option value="1" selected="selected">Comma</option>
<option value="2">Line break</option>
</select><br/>
<input type="button" id="calc1" onclick="form_sub('calc1')" value="A+B"/>
<input type="button" id="calc2" onclick="form_sub('calc2')" value="A*B"/>
<input type="button" id="calc3" onclick="form_sub('calc3')" value="A*B'"/>
<input type="button" id="calc4" onclick="form_sub('calc4')" value="A'*B"/>
</form><br/>
Result: <div id="dis" style="border: 1px solid #C0C0C0; padding: 5px;">No input</div><br/>
Explanation: a set A' is a complement of a set A
</body>
</html>