<?php
/**
 * Bottom part of all management
 * All management functions can not be direct visited, the entrance is ../manage.php
 * So the working directory is the root of website
 *
 * Not contain third party code for login.php
*/
//if direct visit, exit
if (!isset($manage_php)) exit();
?>
</div><!--/trace.div_normal-->
<script type="text/javascript">
//<![CDATA[
if (screen.availWidth) {
	if (screen.availWidth < 760) {
		document.getElementById("dom_index01").style.backgroundImage = "url('images/alge_bg1_320b.gif')";
	}
}
//]]>
</script>
</body>
</html>