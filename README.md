## Plex Over early preview
Get You Plex Content within a web browser.

### requirement: 
#### server side:  
- PHP 5.2 or newer
- PHP-cURL
- Plex Media Server running

##### Client side:  
- A modern browser (Safari requiered if you enable video transcoding)
- Javascript enabled

### installation:
Copy plex_over folder content somewhere where Plex Over can be served.  

In root folder, you'll find a subfolder "config" with 2 aliases: codeigniter and user_pref.  
Open codeigniter, then set:  
`$config['base_url'] = "plex_over url";`  
`$config['language'] = "english" or "french";`

Open user_pref, then set:  
`$config['plex_local'] = "Plex media server access for plex_over";`  
`$config['plex_url'] = "Plex media server access browsers";`

### configuration:
Read comments in two above aliases for more details about configuration.

### issues / Limitations:
- No 'Secure Server Access' for files served over internet.
However, Plex Over can communicate with PMS with authentication header. You can set them in user_pref config file.

- ATM, video transcoding works only with Safari. (.m3u8 plyalist format)

- Video subtitles are not available in fullscreen. This can be a good reason to leave html5 and use flash...

- As video and audio players are html5, some format can't be played on any browser (ie: mp3 and firefox)

- Not all plugins are compatible.

### More informations:
- CodeIgniter Website: http://codeigniter.com/