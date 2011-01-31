<div id="content" class="fit">
<div id="<?= (! isset($id)) ? 'section' : $id ?>">
	
	<?= $views->top_nav ?>
	
	<div id="browser" class="grid">
		
		<?php foreach ($items->content as $key => $item): ?>
			
			<div class="item rounded-st <?php echo $item->type.'_'.$item->ratingKey?>">
				
				<a href="<?=link_item($link, $item)?>">
					<div class="img" >
						<div class="rounded">
							<img class="rounded" original="<?=$this->thumb->get($this->plex_url.$item->thumb)?>" width="200" />
						</div>
					</div>
					<div class="h3">
						<h3 class="h4"> <?=character_limiter(title($item), 15) ?></h3>
						<span><?= (@$item->album) ? @$item->artist : @$item->year ?></span>
					</div>
				</a>
			</div>
		
		<?php endforeach ?>
	
	</div>

</div>
</div>