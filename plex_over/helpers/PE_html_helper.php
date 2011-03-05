<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * script_tag function.
 * fonctionne sur le principe du $link_tag de l'helper html, mais pour le javascript
 * 
 * @access public
 * @param string $linksArray. (default: '')
 * @return void
 */
function script_tag($link = '')
{
	if (! $link) return false;
	
	$source = (strpos($link, 'http://') !== false) ? $link : base_url().$link;
		
	$return = '<script type="text/javascript" src="'.$source.'"></script>'."\n";
	
	return $return;
}
