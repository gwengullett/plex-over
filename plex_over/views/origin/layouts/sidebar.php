<div id="sidebar" class="fit">
	
	<h4><?= pluralize($sections->size, lang('lib_section')) ?></h4>
	<ul>
	<?php foreach ($sections->content as $key => $item):?>
		<a href="<?= link_section($links->section, $item) ?>" >
			<li class="sb-<?=$item->type.' '.active_item($active_sb, $item->type) ?>">
				<?= $item->title ?>
			</li>
		</a>
	<?php endforeach ?>
	</ul>
	
	<h4><?= pluralize(count($third_party), lang('lib_third'), false) ?></h4>
	<ul>
	<?php foreach ($third_party as $key => $item): ?>
		<a href="<?= site_url($item->key) ?>" >
			<li class="sb-<?=$item->key.' '.active_item($active_sb, $item->key) ?>">
				<?= lang((string)$item->title) ?>
			</li>
		</a>
	<?php endforeach ?>
	</ul>

</div>