<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// config fikle for ffmpeg library

// absolute path to ffmpeg bin (type which ffmpeg in terminal)
$config['binaries'] = '/opt/local/bin/ffmpeg';

// where video will be converted
$config['temp_folder'] = 'cache/ffmpeg/';