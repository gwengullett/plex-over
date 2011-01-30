<div id="content" class="fit">
	
	<?= $views->top_nav ?>
	
	<div class="details">
		<div id="details-main">
			<div id="details-cover" class="left">
			 <?= cover($this->thumb->get($this->plex_url.thumb($item))) ?>
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
				<a href="<?=site_url($links->item.'/'.$season->ratingKey.$show_link)?>" />
			 		<?= cover($this->thumb->get($this->plex_url.thumb($season)), 130) ?>
			 		<strong><?= character_limiter($season->title, 15) ?></strong><br />
			 		<span><?= pluralize($season->leafCount, lang('episode')) ?></span>
			 	</a>
			</div>
	<?php endif; endforeach ?>
	</div>
</div>