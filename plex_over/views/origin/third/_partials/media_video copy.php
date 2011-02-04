<a id="flash-media" class="media"></a>
<script type="text/javascript">
$(function(){
	$('.tip').click(function(){
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
			flowplayer("flash-media", '<?= site_url('js/flowplayer/flowplayer-3.2.5.swf') ?>', {
					clip: {
							url:linkMedia,
							scaling: 'fit'
					}
				});
		}
	});
});
</script>