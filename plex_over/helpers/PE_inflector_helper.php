<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// auto pluralize our strings
function pluralize($count, $text, $rcount = true)
{
	$string =  ($rcount == true) ? $count." " : null;
	
	return ($count > 1) ? $string.plural($text) : $string.singular($text);
}