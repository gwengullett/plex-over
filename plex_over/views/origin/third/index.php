<?php $this->load->view($this->template.'/layouts/top_nav');?>

<div id="content" class="fit">
	<div id="third">
		
	<div id="browser" class="grid">
		<?php foreach ($items->content as $key => $item): ?>
			
			<div class="item rounded-st <?php echo $item->type.'_'.$item->ratingKey?>">
				
				<a href="<?=link_item($links->item, $item)?>">
					
					<div class="img" >
						<div class="rounded">
							<?= $this->transcode->img($item, array('width' => 150, 'height' => 150))?>
						</div>
					</div>
					<div class="h3">
						<h3 class="h4"><?=character_limiter($item->title, 20)?></h3>
						<span>
							<?php $alt = (isset($item->year)) ? $item->year : '' ?>
							<?= (isset($item->leafCount)) ? $item->leafCount. " ".lang($item->type.'.childs') : $alt ?>
						</span>
					</div>
				</a>
			</div>
		
		<?php endforeach ?>
	
	</div>

</div>
</div>