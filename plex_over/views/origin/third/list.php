<?php foreach ($items->content as $key => $item): ?>
  
  <?php if (isset($item->key)): ?>
  	<div class="show-list">
  		<?= img(array('src' => link_server($item->thumb, $this->plex_url),'height' => 50, 'scale' => 'height', 'align' => 'left'))?>
  		<div class="show-list-txt">
  			<h3><?=anchor(
  				link_plugin($item),
  				(@$item->name) ? $item->name : $item->title
  			)?>
  			</h3>
  		</div>
  	</div>
  <?php endif ?>

<?php endforeach ?>
