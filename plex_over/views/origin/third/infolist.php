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
        		<a class="tip" href="<?= link_server($item->key, $this->plex_url) ?>" title="<?= $item->title ?>">
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
	
	mediaCont = $('#listinfo-media');
	summaryCont = $('#listinfo-summary');
	var orig = summaryCont.html();
	
	resize_media();
	ThumbnailScroller("tshf_container","horizontal",40,800,"easeOutCirc",0.5,300);
	$('.tip').tipTip({delay:200});

	$('.tip').click(function(){
		$('#listinfo-media .media').attr('src', $(this).attr('href'));
		orig = $(this).next('div').html();
		summaryCont.html(orig);
		resize_media();
		return false;
	});
	
	$('.close-button').toggle(function(){
		$(this).next('div').slideUp();
	}, function(){
		$(this).next('div').slideDown();
	});
	
	$(window).resize(function(){
		resize_media();
	});
});

</script>