<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  APPLICATION CONFIGURATION
| -------------------------------------------------------------------
*/

// Specify the template folder
$config['template']			= "origin";
// Cache folder for thumbs
$config['cache_folder']	= 'cache/thumbs/';
// set the cache expiration (empty for no cache)
$config['cache_expire']	= '';
// Size of thumbs (fit the width)
$config['thumb_width']	= 250;
// You can set a specific section to load from your home page
$config['home_section']	= null;
// Debug plex server url request
$config['debug_uri']		= false;
// General Codeigniter debugging
$config['debug_ci']			= false;

/*
| -------------------------------------------------------------------
|  PLEX SERVER CONFIGURATION
| -------------------------------------------------------------------
*/

// the PRIVATE url of the Plex Server (no trailing slash !!!!)
// Used to retrive xml files. If your running plex server on same
// host, prefer localhost (no name/dns resolution required = faster)
$config['plex_local']		= 'http://localhost:32400';
// the PUBLIC url of the Plex Server (no trailing slash !!!!)
// used in frontend for downloads and images
$config['plex_url']			= 'http://localhost:32400';
// path to sections
$config['section_url']	= 'library/sections/';
// path to metadata
$config['meta_url']			= 'library/metadata/';
// itunes
$config['itunes_url']		= 'music/iTunes/';

/*
| -------------------------------------------------------------------
|  UTILITARIES
| -------------------------------------------------------------------
*/
// Only keep some specific filters for types.

// Music
$config['artist_filters']	= array('albums', 'genre', 'all', 'recentlyAdded');
// Itunes
$config['itunes_filters'] = array_push($config['artist_filters'], 'artists','podcasts', 'ratings');
// Movies
$config['movie_filters']	= array('all', 'genre', 'recentlyadded', 'recentlyviewed', 'actor', 'director');
// TV Shows
$config['show_filters']		= $config['movie_filters'];