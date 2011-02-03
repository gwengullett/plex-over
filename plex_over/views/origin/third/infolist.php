<div id="listinfo-media">
	<?php $this->load->view($this->template.'/third/_partials/media_'.strtolower($items->type)) ?>
</div>

<div id="listinfo-summary" class="">

</div>

<div id="tshf_container">
	<div class="thumbScroller">
		<div class="container">
			<?php foreach ($items->content as $item): if (isset($item->key)): ?>
    	<div class="content">
        	<div>
        		<a class="tip" href="<?= $item->key ?>" title="<?= $item->title ?>">
        			<?= $this->transcode->img($item, array('width' => 100, 'height' => 70, 'scale' => 'height', 'type' => 'normal')) ?>
        		</a>
        		<div style="display:none">
        			<div>
        				<h3><?= $item->title ?></h3>
        				<p><?= $item->summary ?></p>
        			</div>
        		</div>
        	</div>
			</div>
		<?php endif; endforeach ?>
		</div>
	</div>
</div>
<script>
var summ = 0;
function resize_media() {
		var totH = $('#plugin-directory').height();
		if ($('video').length > 0) summ = summaryCont.height();
		$('#listinfo-media').css('height', (totH - 240 - summ)+'px');
}

$(window).load(function() {
	
	mediaCont = $('#listinfo-media');
	summaryCont = $('#listinfo-summary');
	var orig = summaryCont.html();
	
	resize_media();
	ThumbnailScroller("tshf_container","horizontal",40,800,"easeOutCirc",0.5,300);
	$('.tip').tipTip({delay:0});

	$('.tip').click(function(){
		$('#listinfo-media .media').attr('src', $(this).attr('href'));
		orig = $(this).next('div').html();
		summaryCont.html(orig);
		resize_media();
		return false;
	});
	
	$(window).resize(function(){
		resize_media();
	});
});

</script>