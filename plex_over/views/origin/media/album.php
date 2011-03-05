
<div id="content" class="fit">
	
	<?php $this->load->view($this->template.'/layouts/top_nav');?>
	
	<div class="details dark-gradient bb">
		<div id="details-main">
			<div id="details-cover" class="left">
				<?= $this->transcode->img($item, array('height' => 220, 'width' => 150, 'class' => 'rounded shadow'))?>
			 </div>
				<h1 class="txt-shadow ">
					<?=$item->title2?>
					<small><?= pluralize(childs_count($item->size), lang('album')) ?></small>
				</h1>
				<p id="summary" class="summary"><?= split_summary(@$item->summary) ?></p>
			<div class="clear"></div>
		</div>
	</div>
	
	<div id="details-sub" class="left">
	<?php foreach ($item->content as $album): if (@$album->ratingKey): ?>
			<div class="item left jacket">
				<a href="<?=link_media($links->item, $album->ratingKey.$artist_link, $this->uri->segment(5))?>">
			  	<?= $this->transcode->img($album, array('width' => 130, 'type' => 'src')) ?>
			  	<h4 class="h4">
			  		<?= character_limiter($album->title, 15)?>
			  	</h4>
			  	<span><?=$album->year?> : <?=pluralize($album->leafCount, lang('track'))?></span>
			  </a>
			</div>
	<?php endif; endforeach ?>
	</div>
	
	<div id="content-bottom" class="dark-gradient">
		<span><?= @$item->mediaTagVersion ?></span>
	</div>
	
	<div style="display:none"><div id="sum-hide"></div></div>

</div>