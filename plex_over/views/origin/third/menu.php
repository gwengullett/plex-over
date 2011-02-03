<?php foreach ($items->content as $item): ?>
  
  <?php if (isset($item->key)): ?>
  	<div class="show-list">
			<?= $this->transcode->img($item, array('height' => 50, 'scale' => 'height', 'align' => 'right'))?>
  		<div class="show-list-txt">
  			<h3><?=anchor(
  				urlencode($item->key),
  				$item->title)?>
  			</h3>
  			<span><?=$item->summary?></span>
  		</div>
  	</div>
  <?php endif ?>

<?php endforeach ?>
