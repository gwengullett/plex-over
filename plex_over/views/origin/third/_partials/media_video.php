<div id="flash-media" class="media"></div>
<script type="text/javascript">
$(function(){
	$('.tip').click(function(){
		var anchorMedia	= $(this);
		var linkMedia = anchorMedia.attr('rel');
			// call our parser
		$.ajax({
		  type: 'POST',
		  url: '<?= site_url('convert/parse_stream/') ?>',
		  data: {url: linkMedia},
		  success: function(clip) {
		  	clip = $.parseJSON(clip);
		  	console.log(clip);
		  	if (! clip.connexion_url) raw_media(clip);
		  	else stream_media(clip);
		  }
		});
	});
});

function raw_media(clip) {
	flowplayer("flash-media", '<?= site_url('js/flowplayer/flowplayer-3.2.5.swf') ?>', {
		clip: {
			url:clip.url,
		  scaling: 'fit'
		}
	});
}

function stream_media(clip) {
	flowplayer("flash-media", '<?= site_url('js/flowplayer/flowplayer-3.2.5.swf') ?>', {
		clip: {
		  url:clip.url,
		  provider: 'rtmp',
		  scaling: 'fit'
		},
		plugins: {
		  rtmp: {
		  	url: '<?= site_url('js/flowplayer/flowplayer.rtmp-3.2.3.swf') ?>',
		  	netConnectionUrl : clip.connexion_url
		  }
		}
	});
}
			/*
var video = $('video');
			if (video.length < 1)
			{
				$('#listinfo-media').append('<video class="media" controls="controls" ></video>');
				var video = $('video');
			}
			video[0].load();
			video[0].play();
*/

</script>