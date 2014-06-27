<?php
/**
 * Service for comment.php
 * Echo guest comment form
*/
?>
<form id="comment_form01"<?php 
if (!isset($_GET['copost'])) echo ' style="display: none"';
?> action="<?php
if (!isset($c_link)) $c_link = '#';
echo $c_link;
?>" method="post"><br/>
<div class="div_com2">*Name: <?php
if (isset($_SESSION['com_msg'])) echo $_SESSION['com_msg'][0];
?></div>
<input type="text" class="input_com1" id="input_com_t" name="co_tit" onfocus="tit_onfocus()" value="<?php
if (isset($_SESSION['co_tit'])) echo $_SESSION['co_tit'];
?>"/>
<div class="div_com2">Email: (Won't be published.) <?php
if (isset($_SESSION['com_msg'])) echo $_SESSION['com_msg'][4];
?></div>
<input type="text" class="input_com1" id="input_com_t1" name="co_email" value="<?php
if (isset($_SESSION['co_email'])) echo $_SESSION['co_email'];
?>"/>
<div class="div_com2">Website: <?php
if (isset($_SESSION['com_msg'])) echo $_SESSION['com_msg'][1];
?></div>
<input type="text" class="input_com1" id="input_com_tl" name="co_link" value="<?php
if (isset($_SESSION['co_link'])) echo $_SESSION['co_link'];
?>"/>
<div class="div_com2">*Content: <?php
if (isset($_SESSION['com_msg'])) echo $_SESSION['com_msg'][2];
?></div>
<textarea name="co_cont" rows="22" cols="7" class="input_com1" id="input_com_c"><?php
if (isset($_SESSION['co_cont'])) echo $_SESSION['co_cont'];
?></textarea>
<?php
if ($check_ident_fail) echo '<div class="div_com2">*Type the word: ';
if ($check_ident_fail && isset($_SESSION['com_msg'])) echo $_SESSION['com_msg'][3];
if ($force_determine || $check_ident_fail) echo '</div><input type="image" src="img_ident.php" class="img_com1" alt="" /><br/>';
?>
<div class="div_com2"></div>
<input type="<?php
if(!$check_ident_fail) echo 'hidden';
else echo 'text';
?>" class="input_com1" id="input_com_iden" name="c_ident" value="<?php
//assume the bots do not run JS dom event
if (!$force_determine && isset($_SESSION['keep_ident'])) {
	if ($_SESSION['keep_ident'][0] && isset($_SESSION['rand_img'][0])) {
		echo $_SESSION['rand_img'][0];
		$_SESSION['keep_ident'][1] += 1;
	}
}
?>"/>
<div class="div_com2"></div>
<input type="submit" class="input_com1" id="input_com_subm" value="Post"/>
<div class="div_com2"><br/>
Avatar support: <a href="http://en.gravatar.com/" class="page" target="_blank">gravatar.com</a><br/>
Comment needs to be plain text.<br/>
*: Required
</div></form>
<script type="text/javascript">
if (i_disable_comm == 1) form_dis_comm();
</script>