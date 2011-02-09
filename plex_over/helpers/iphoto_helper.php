<?php

function iphoto_default($image = 'event', $title = 'gallery', $size = 64)
{
	$image = array(
		'src'			=> 'images/iphoto_'.strtolower($image).'.png',
		'alt'			=> $title,
		'width'		=> $size,
		'height'	=> $size,
		'align'		=> 'left'
	);
	
	return img($image);
}