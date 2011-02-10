<?php foreach ($items->content as $key => $item): ?>
  <?php if (isset($item->key)): ?>
		<a href="<?= site_url(link_plugin($item)) ?>">
  		<div class="item rounded list">
  			<?= img(array(
  				'src' => $this->thumb->get(link_server($item->thumb, $this->plex_url)),
  				'width' => 120))
  			?>
  			<h4><?= (@$item->name) ? $item->name : $item->title ?></h4>
  		</div>
  	</a>
  <?php endif ?>

<?php endforeach ?>
