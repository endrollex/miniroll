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
package_post();
</script>
</body>
</html>