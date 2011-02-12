<div id="content" class="fit">
	
	<?= $views->top_nav ?>
	
	<div class="details">
		<div id="details-main">
			<div id="details-cover" class="left">
			 <?= $this->transcode->img($item, array('height' => 150, 'scale' => 'height')) ?>
			 </div>
			<div id="details-text" class="left">
				<h1 class="txt-shadow ">
					<?= $item->title2 ?>
					<small>
						(<?= @$item->parentYear ?>): 
						<?= pluralize(childs_count($item->size), lang('season')) ?>
					</small>
				</h1>
				<div><?= word_limiter(@$item->summary, 100) ?></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	<div id="details-sub" class="left">
	<?php foreach ($item->content as $season): if (@$season->ratingKey): ?>
			<div class="left jacket">
				<a href="<?= link_media($links->item, $season->ratingKey.$show_link, $this->uri->segment(5)) ?>" />
					<?= $this->transcode->img($season, array('height' => 170, 'width' => 130, 'type' => 'src')) ?>
			 		<strong><?= character_limiter($season->title, 15) ?></strong><br />
			 		<span><?= pluralize($season->leafCount, lang('episode')) ?></span>
			 	</a>
			</div>
	<?php endif; endforeach ?>
	</div>
</div>