<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  APPLICATION CONFIGURATION
| -------------------------------------------------------------------
*/
$config['thumbs_folder']	= 'cache/thumbs/';
// set the cache expiration (empty for no cache)
$config['cache_expire']	= '';
// Size of thumbs (fit the width)
$config['thumb_width']	= 150;
// You can set a specific section to load from your home page
$config['home_section']	= null;
// Debug plex server url request
$config['debug_uri']		= false;
// General Codeigniter debugging
$config['debug_ci']			= false;
// primitive bool for video conversion with ffmpeg, experimental ATM.
$config['video_conv']		= false;

// -------------------------------------------------------------------
// Serveur sections path (if it change some time)
$config['section_url']	= 'library/sections/';
$config['meta_url']			= 'library/metadata/';

/*
| -------------------------------------------------------------------
|  UTILITARIES
| -------------------------------------------------------------------
| Keep some specific filters for types.
*/

// Music
$config['artist_filters']	= array('albums', 'collection', 'genre', 'all', 'recentlyadded', 'artists','podcasts', 'ratings', 'playlists');
// Movies
$config['movie_filters']	= array('all', 'collection', 'genre', 'recentlyadded', 'recentlyviewed', 'actor', 'director');
// TV Shows
$config['show_filters']		= array('all', 'collection', 'genre', 'recentlyadded', 'recentlyviewed', 'newest') ;