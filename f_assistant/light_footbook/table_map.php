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
<script type="text/javascript" src="table_map.js"></script>
<form action="#" id="setcalc" onsubmit="return setcalc(this)" method="post" >
Purpose: Table map<br/>
Input: Please use line break separate elements:<br/><br/>
Table: <textarea id="input_name_att" name="input1" rows="10" cols="40">x001,pencil,black
x002,rollerball pen,red
x004,screwdriver,phillips
x009,wrench,6 inch,adjustable</textarea>
Subset: <textarea name="input2" rows="10" cols="20">x001,pen_1
x002,pen_2
004,tool_A
x001,tool_B</textarea><br/><br/>
Matching mode: <select name="format">
<option value="1" selected="selected">Parts of</option>
<option value="2">Accurate</option>
</select><br/>
<input type="button" onclick="form_sub()" value="Map"/>
<input type="button" onclick="form_reset()" value="Reset"/>
</form><br/>
Result: <div id="dis" style="border: 1px solid #C0C0C0; padding: 5px;">No input</div><br/>
Explanation:
</body>
</html>