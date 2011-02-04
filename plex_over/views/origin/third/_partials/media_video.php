<a id="flash-media" class="media"></a>
<script type="text/javascript">
$(function(){
	$('.tip').click(function(){
		var v = document.createElement("video");
		var anchorMedia	= $(this);
		var linkMedia = anchorMedia.attr('href');
		if (linkMedia.substring(0, 7) == "rtmp://")
		{
			// call our parser
			$.ajax({
				type: 'POST',
				url: '<?= site_url('convert/parse_stream/') ?>',
				data: {url: linkMedia},
				success: function(clip) {
					clip = $.parseJSON(clip);
					
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
			});
		}
		else
		{
			var video = $('video');
			if (video.length < 1)
			{
				$('#listinfo-media').append('<video class="media shadow" controls="controls" ></video>');
				var video = $('video');
			}
			video[0].load();
			video[0].play();
		}
	});
});
</script>