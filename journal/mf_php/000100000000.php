<?php
//function
function album_sel_ix($sel_ix)
{
	$album_alpha = array(
		'&Alpha;', '&Beta;', '&Gamma;', '&Delta;', '&Epsilon;', '&Zeta;', '&Eta;', '&Theta;', '&Iota;', '&Kappa;',
		'&Lambda;', '&Mu;', '&Nu;', '&Xi;', '&Omicron;', '&Pi;', '&Rho;', '&Sigma;', '&Tau', '&Upsilon;',
		'&Phi;', '&Chi;', '&Psi;', '&Omega;', '&bull;'
	);
	if ($sel_ix >= count($album_alpha) || $sel_ix < 0) return $album_alpha[count($album_alpha)-1];
    return $album_alpha[$sel_ix];
}
//album
$album_post = $dir.$view_file_c;
$album_page = 'index.php?p='.$view_file.'&amp;albp=';
$chunk_size = 20;
//
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
	echo '<div class="div_com_page">';
	for ($ix_alb = count($albumi_c); $ix_alb != 0; --$ix_alb) {
		if ($ix_chunk == ($ix_alb-1)) echo ' '.album_sel_ix($ix_alb-1).'';
		else echo ' <a class="album" href="'.$album_page.($ix_alb-1).'">'.album_sel_ix($ix_alb-1).'</a>';
	}
	echo '</div>';
}
?>