<div id="content" class="fit">

	<?= $views->top_nav ?>
	
	<div class="details dark-gradient bb show-list">
		<div id="details-cover" class="left">
			 <?= $this->transcode->img($item, array('height' => 100, 'scale' => 'height')) ?>
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
		<?php foreach ($item->content as $episode): ?>
			
			<?php if (isset($episode->ratingKey)): ?>
				<div class="show-list bb">
						<?= $this->transcode->img($episode, array('width' => 130, 'height' => 72, 'align' => 'left'))?>
					<div class="show-list-txt">
						<h3><?=anchor(
							$link.$episode->ratingKey.$show_link,
							$episode->type." ".$episode->index.": ".$episode->title)?>
						</h3>
						<span><?=$episode->summary?></span>
					</div>
				</div>
			<?php endif ?>
		
		<?php endforeach ?>
	</div>	
</div>