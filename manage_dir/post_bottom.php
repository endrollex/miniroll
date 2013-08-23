<?php
/**
 * Bottom part of all management
 * All management functions can not be direct visited, the entrance is ../manage.php
 * So the working directory is the root of website
 *
 * Contain Google Analytics code, curious statistics
*/
//if direct visit, exit
if (!isset($manage_php)) exit();
//google analytics
if (file_exists('f_assistant/google_analytics/analyticstracking.php')) include_once('f_assistant/google_analytics/analyticstracking.php');
?>
</div><!--/trace.div_normal-->
</body>
</html>