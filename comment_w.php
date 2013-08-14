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
<div class="div_com2">*Pen name: <?php
if (isset($_SESSION['com_msg'])) echo $_SESSION['com_msg'][0];
?></div>
<input type="text" class="input_com1" id="input_com_t" name="co_tit" value="<?php
if (isset($_SESSION['co_tit'])) echo $_SESSION['co_tit'];
?>"/>
<div class="div_com2">(Opiton) Link: <?php
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
<div class="div_com2">*Type the word: <?php
if (isset($_SESSION['rand_img'][0])) echo '('.$_SESSION['rand_img'][0].') ';
if (isset($_SESSION['com_msg'])) echo $_SESSION['com_msg'][3];
?></div>
<input type="image" src="img_ident.php" class="img_com1" alt="" /><br/>
<div class="div_com2"></div>
<input type="text" class="input_com1" id="input_com_iden" name="c_ident"/>
<div class="div_com2"></div>
<input type="submit" class="input_com1" id="input_com_subm" value="Add"/>
</form>