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


// iphoto gallery
function iphoto_gallery($base_url, $item, $width = 64)
{
	$image = array(
		'original'=> $base_url.$item->attributes()->thumb,
		'alt'			=> $item->attributes()->title,
		'height'	=> $width,
		'class'		=> 'rounded'
	);
	return img($image);
}

// get th correct case
function iphoto_imglink($base, $id)
{
	return str_replace('iphoto', 'iPhoto', $base).'/'.$id;	
}