<div id="content" class="fit">

	<?= $views->top_nav ?>
	
	<div class="details dark-gradient bb show-list">
		<div id="details-cover" class="left">
			<?= cover($this->thumb->get($this->plex_url.thumb($item)), 70) ?>
		</div>
		
		<div id="details-text" class="left">
		    <h1 class="txt-shadow ">
		    	<?=$item->title1." ".$item->title2?>
		    </h1>
		    <h2>
		    	<?= pluralize($item->size, lang('episode')) ?> 
		    	<small>[ <?= @$item->grandparentStudio .' | '. @$item->grandparentContentRating?> ]</small>
		    </h2>
		</div>
		
		<div class="clear"></div>
	
	</div>
	
	<div class="dir">
		<?php foreach ($item->content as $item): ?>
			
			<?php if (isset($item->ratingKey)): ?>
				<div class="show-list bb">
						<?=img(array('original' => $this->thumb->get($this->plex_url.$item->thumb), 'width' => 130, 'height' => 72, 'class' => 'rounded', 'align' => 'left'))?>
					<div class="show-list-txt">
						<h3><?=anchor(
							$link.$item->ratingKey.$show_link,
							$item->type." ".$item->index.": ".$item->title)?>
						</h3>
						<span><?=$item->summary?></span>
					</div>
				</div>
			<?php endif ?>
		
		<?php endforeach ?>
	</div>	
</div>