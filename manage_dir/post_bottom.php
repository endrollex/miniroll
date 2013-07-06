<?php
/**
 * Bottom part of all management
 * All management function can not be direct visit, the entrance is ../manage.php
 * So the working directory is the root of website
 *
 * Contain Google Analytics code, curious statistics
*/
//if direct visit, exit
if (!isset($manage_php)) exit();
//google analytics
if (file_exists('font/analyticstracking.php')) include_once('font/analyticstracking.php');
?>
</div><!--/trace.div_normal-->
</body>
</html>