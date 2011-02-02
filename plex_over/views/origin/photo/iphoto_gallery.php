<script type="text/javascript">

$(function(){
	var movie;
	var cbpadding = parseInt($('#cboxLoadedContent').css('padding-left'));
	
	// hook color to check if the link correspond to a video
	$(document).bind('cbox_open', function(){
		var element = $.colorbox.element();
		if (element.attr('type') == 'Movie') {
			var video = $('#video_player');
			movie = '<video controls  id="video_player" src="'+element.attr('href')+'"></video>';
			//video.attr('src', element.attr('href')),
			$(movie)[0].addEventListener('canplaythrough', getdim, true);
		}
	});
	// retrieve video dimention and scale our colorbox
	function getdim(e)
	{
		$.colorbox({
			height: (e.srcElement.videoHeight + 30) + 'px',
			width: (e.srcElement.videoWidth + 10) + 'px',
			html: movie
		});
	}
	
	// standard behavior
	$('a.img').colorbox({
		maxHeight: $(window).height()+'px',
		maxWidth: $(window).width()+'px'
	});
	
});
</script>

<div id="content" class="fit">
	<div id="<?= 'iphoto-gallery' ?>">
		<?= $views->top_nav ?>
		<div id="browser" class="grid">
					<h2><?= $item->attributes()->title1 ?> ( <?= pluralize(count($item->Photo), lang('element')) ?> )</h2>
					<?php foreach ($item->Photo as $key => $content): ?>
						<a title="<?= $content->attributes()->title ?>"
							rel="<?= $item->key.$key ?>" 
							type="<?= $content->attributes()->mediaType ?>" 
							class="img" 
							href="<?= iphoto_imglink($link, $content->attributes()->key) ?>"
						>
						<div class="item <?= css_alt($key) ?>">
							<?= $this->transcode->img(
								$content->attributes(), 
								array('width' => 120, 'height' => 100, 'scale' => 'height')
							);?>
							<h3><?= $content->attributes()->title ?></h3>
						</div>
						</a>
					<?php endforeach ?>
				<div class="clear"></div>
		</div>
	</div>
</div>
