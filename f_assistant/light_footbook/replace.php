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
<script type="text/javascript" src="replace.js"></script>
<form action="#" id="setcalc" onsubmit="return setcalc(this)" method="post" >
Purpose: Batch replace<br/>
Input: Please use line break separate elements:<br/><br/>
Search: <textarea id="input_name_att" name="input1" rows="10" cols="20">Fox,cat
quick brown,tabby
j[A-z\s]+er,touch</textarea>
Subject: <textarea name="input2" rows="10" cols="20">The quick brown fox jumps over the lazy dog.</textarea><br/><br/>
RegExp option: <select name="format">
<option value="1" selected="selected">Case-sensitive</option>
<option value="2">Case-insensitive</option>
</select><br/>
<input type="button" onclick="form_sub()" value="Replace"/>
<input type="button" onclick="form_reset()" value="Reset"/>
</form><br/>
Result: <div id="dis" style="border: 1px solid #C0C0C0; padding: 5px;">No input</div><br/>
Explanation:
</body>
</html>