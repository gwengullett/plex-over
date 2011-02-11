<div id="listinfo-media">
	<?php $this->load->view($this->template.'/third/_partials/media_'.strtolower($items->keyname)) ?>
</div>

<div id="listinfo-summary">
	<span class="story-button dark-gradient rounded">&#8505;</span>
	<div style="display:none"></div>
</div>

<div id="tshf_container">
	<div class="prev">Prev</div>
	<div class="thumbScroller">
		<div class="container">
			<?php foreach ($items->content as $item): if (isset($item->key)): ?>
    	<div class="content item">
        		<a class="tip" rel="<?= $item->key ?>" href="<?= link_server($item->key, $this->plex_url) ?>" title="<?= $item->title ?>">
        			<?= transcode_img($item, array('height' => 50, 'scale' => 'height', 'class' => '')) ?>
        		</a>
        		<div style="display:none">
        			<div>
        				<h3><?= $item->title ?></h3>
        				<p><?= nl2br($item->summary) ?></p>
        			</div>
        		</div>
			</div>
		<?php endif; endforeach ?>
		</div>
	</div>
	<div class="next">Next</div>
</div>
<script>
$(function(){
	$('.media').gallery();
});

$(window).load(function(){
	$('#tshf_container').thumbViewer({margin:0});
	$('.tip').eq(0).click();
});
</script>