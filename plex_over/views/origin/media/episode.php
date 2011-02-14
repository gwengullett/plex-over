<div id="content" class="fit">

	<?= $views->top_nav ?>
	
	<div class="details dark-gradient bb">
		    <h1 class="txt-shadow ">
		    	<?=$item->title1." ".$item->title2?> <small class="right"><?= pluralize($item->size, lang('episode')) ?> </small>
		    </h1>
	</div>
	
	<div class="dir">
		<?php foreach ($item->content as $episode): ?>
			
			<?php if (isset($episode->ratingKey)): ?>
				<div class="show-list bb">
						<?= transcode_img($episode, array('width' => 130, 'height' => 72, 'align' => 'left', 'type' => 'src'))?>
					<div class="show-list-txt">
						<h3>
							<a href="<?= link_media($link, $episode->ratingKey.$show_link, $this->uri->segment(7)) ?>">
								<?= $episode->type." ".$episode->index.": ".$episode->title ?>
							</a>
						</h3>
						<span><?=$episode->summary?></span>
					</div>
				</div>
			<?php endif ?>
		
		<?php endforeach ?>
	</div>	
</div>