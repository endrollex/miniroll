<?php
//album
$album_post = $dir.$view_file_c;
$album_page = 'index.php?p='.$view_file.'&amp;albp=';
$chunk_size = 30;
if (file_exists($album_post)) require($album_post);
if (isset($albumi) && isset($albums) && isset($album_path)) {
	$albumi_c = array_chunk($albumi, $chunk_size);
	$albums_c = array_chunk($albums, $chunk_size);
	$ix_chunk = count($albumi_c)-1;
	if (isset($_GET['albp'])) if (isset($albumi_c[$_GET['albp']])) $ix_chunk = $_GET['albp'];
	for ($ix_alb = count($albumi_c[$ix_chunk]); $ix_alb != 0; --$ix_alb) {
		if (!isset($albumi_c[$ix_chunk][$ix_alb-1]) || !isset($albums_c[$ix_chunk][$ix_alb-1])) continue;
		$album_imgurl = 's_'.$albumi_c[$ix_chunk][$ix_alb-1];
		echo '<div class="album_div1">';
		echo '<a target="_blank" href="'.$album_path.$albumi_c[$ix_chunk][$ix_alb-1].'">';
		echo '<img class="album_image" alt="'.$album_imgurl.'" src="'.$album_path.$album_imgurl.'" />';
		echo '</a>';
		echo '<div class="album_div2">';
		//text link
		echo $albums_c[$ix_chunk][$ix_alb-1];
		echo '</div></div>';
	}
	echo '<br/>Page:';
	for ($ix_alb = count($albumi_c); $ix_alb != 0; --$ix_alb) {
		echo ' <a class="album" href="'.$album_page.($ix_alb-1).'">'.($ix_alb-1).'</a>';
	}
}
?>