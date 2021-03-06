<?php
/**
 * Google Analytics auto-flush
 * please modify the google track code and domain name (three places)
*/
//filename: f_assistant/google_analytics/analyticstracking.php
//google analytics
$renew_gojs = false;
$renew_try = 0;
$unix_time_file = 'f_assistant/google_analytics/unix_time.txt';
$font_gajs_file = 'f_assistant/google_analytics/ga.js';
$font_gajs_file_tmp = 'f_assistant/google_analytics/ga.js.tmp';
if (file_exists($unix_time_file)) {
	$last_unix_time = file_get_contents($unix_time_file);
	if (time()-$last_unix_time > 82800) $renew_gojs = true;
	if (strlen($last_unix_time) == 1) {
		//if renew_try > 10, stop renew, something wrong
		++$last_unix_time;
		$renew_try = $last_unix_time;
		if (!file_exists($font_gajs_file_tmp)) $renew_gojs = true;
		else {
			if (file_exists($font_gajs_file_tmp)) 
				if (filesize($font_gajs_file_tmp) < 100) $renew_gojs = true;
			else {
				$read_gajs = file_get_contents($font_gajs_file_tmp);
				if (file_put_contents($font_gajs_file, $read_gajs) !== false) {
					file_put_contents($unix_time_file, time());
					$renew_gojs = false;
				}
			}
		}
	}
}
else $renew_gojs = true;
if ($renew_gojs) {
	$read_gajs = file_get_contents('http://www.google-analytics.com/ga.js');
	file_put_contents($font_gajs_file_tmp, $read_gajs);
	file_put_contents($unix_time_file, $renew_try);
}
$run_gojs = false;
if (file_exists($font_gajs_file) && isset($_SERVER['HTTP_HOST'])) {
	if (stripos($_SERVER['HTTP_HOST'], 'endrollex.com') !== false) $run_gojs = true;
}
if (!$run_gojs) echo '<!--';
?>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-38635348-1']);
_gaq.push(['_setDomainName', 'endrollex.com']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.endrollex.com/f_assistant/google_analytics/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<?php
if (!$run_gojs) echo '-->';
?>