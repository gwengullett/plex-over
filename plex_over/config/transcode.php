<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Config file for transcode library

// specific transcode paths
$config['img_transpath']		= '/photo/:/transcode?';
$config['m3u8_transpath']	= '/video/:/transcode/segmented/start.m3u8?identifier=com.plexapp.plugins.library&';
$config['flash_transpath']	= '/video/:/transcode/generic.flv?format=flv&videoCodec=libx264&vpre=video-embedded-h264&videoBitrate=5000&audioCodec=libfaac&apre=audio-embedded-aac&audioBitrate=128&size=640x480&fakeContentLength=2000000000&';

// acces keys to the video transcode API
$config['public_key']			= 'KQMIY6GATPC63AIMC4R2';
$config['private_key']		= 'k3U6GLkZOoNIoSgjDshPErvqMIFdE0xMTx8kgsrhnC0=';