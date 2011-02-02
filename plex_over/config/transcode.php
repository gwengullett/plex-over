<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Config file for transcode library

// specific transcode paths
$config['img_transpath']		= '/photo/:/transcode?';
$config['video_transpath']	= '/video/:/transcode/segmented/start.m3u8?identifier=com.plexapp.plugins.library&';
$config['audio_transpath']	= '/video/:/transcode/segmented/start.m3u8?';

// acces keys to the video transcode API
$config['public_key']			= 'KQMIY6GATPC63AIMC4R2';
$config['private_key']		= 'k3U6GLkZOoNIoSgjDshPErvqMIFdE0xMTx8kgsrhnC0=';