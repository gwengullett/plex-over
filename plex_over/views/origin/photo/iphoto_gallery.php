<?php $this->load->view($this->template.'/layouts/top_nav'); ?>

<div id="content" class="fit">
	<div id="plugin-directory">
		<div class="dir">
			<div id="listinfo-media">
			<?= img(array('src' => $link.'/'.$item->Photo[0]->attributes()->key, 'class' => 'media shadow'));?>
			</div>
			<div id="tshf_container">
				<div class="prev">Prev</div>
				<div class="thumbScroller">
					<div class="container">
					<?php foreach ($item->Photo as $key => $content): ?>
						<div class="content item">
							<a class="tip" href="<?= $link.'/'.$content->attributes()->key ?>" title="<?= $content->attributes()-> title ?>">
								<?= transcode_img(
									$content->attributes(), 
									array('width' => 80, 'height' => 50,'scale' => 'height', 'class' => '')
									);?>
							</a>
						</div>
					<?php endforeach ?>
					</div>
				</div>
				<div class="next">Next</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$('.media').gallery();
});

$(window).load(function(){
	$('#tshf_container').thumbViewer({margin:0});
});
</script>
