<div id="listinfo-media">
	<?php $this->load->view($this->template.'/third/_partials/media_'.strtolower($items->keyname)) ?>
</div>

<span class="close-button" style="position:absolute; bottom: 100px; display: block; z-index:50"> &lt;story&gt;</span>
<div id="listinfo-summary">

</div>

<div id="tshf_container">
	<div class="thumbScroller">
		<div class="container">
			<?php foreach ($items->content as $item): if (isset($item->key)): ?>
    	<div class="content">
        	<div>
        		<a class="tip" rel="<?= $item->key ?>" href="<?= link_server($item->key, $this->plex_url) ?>" title="<?= $item->title ?>">
        			<?= img(array('src' => link_server($item->thumb, $this->plex_url), 'height' => 70, 'class' => 'rounded')) ?>
        		</a>
        		<div style="display:none">

        			<div>
        				<h3><?= $item->title ?></h3>
        				<p><?= nl2br($item->summary) ?></p>
        			</div>
        		</div>
        	</div>
			</div>
		<?php endif; endforeach ?>
		</div>
	</div>
</div>
<script>
function resize_media() {
		var totH = $('#plugin-directory').height();
		$('#listinfo-media').css('height', (totH - 210)+'px');
}

$(window).load(function() {
	
	var mediaCont		= $('#listinfo-media');
	var summaryCont = $('#listinfo-summary');
	var thumb				= $('.tip');
	var theMedia		= mediaCont.find('.media');
	
	ThumbnailScroller("tshf_container","horizontal",40,800,"easeOutCirc",0.5,300);
	thumb.tipTip({delay:200});
	
	thumb.live('click', function() {
		if (! $(this).is('.selected')) {
			theMedia = mediaCont.find('.media');
			var ref = $(this);
			thumb.removeClass('selected');
			theMedia.attr('src', $(this).attr('href'));
			summaryCont.html(ref.next('div').html());
			resize_media();
			/*
theMedia.load(function(){
				
			});
*/
			$(this).addClass('selected');
		}
		return false;
	});
	
	$('.close-button').toggle(function(){
		$(this).next('div').slideUp();
	}, function(){
		$(this).next('div').slideDown();
	});
	
	// load the first media
	thumb.eq(0).click();

	$(window).resize(function(){
		resize_media();
	});
});

</script>