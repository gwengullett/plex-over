<div id="content" class="fit">
	
	<div id="<?= 'iphoto-main' ?>">
		<?= $views->top_nav ?>
		<div id="browser" class="grid">
			<?php foreach ($items as $key => $item): ?>
				<div class="<?= $item->directory->key ?>">
					<h2><?= lang((string)strtolower($item->directory->title)) ?></h2>
					<?php foreach ($item->content as $key => $content): ?>
						<a href="<?= site_url($link.'/'.$item->directory->key.'/'.$content->key) ?>" >
						<div class="item <?= css_alt($key) ?> clear">
							<?= iphoto_default($item->directory->key, $content->title, 32) ?>
							<span><?= $content->title ?></span>
						</div>
						</a>
					<?php endforeach ?>
				</div>
				<div class="clear"></div>
			<?php endforeach ?>
		</div>
	</div>
</div>