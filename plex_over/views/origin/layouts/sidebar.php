<div id="sidebar" class="fit">
		<?= form_open('user/set_view') ?>
			<?= form_submit('flat', 'flat' , 'class="'.active_item('flat', $this->section_view).'"') ?>
			<?= form_submit('grid', 'grid', 'class="'.active_item('grid', $this->section_view).'"') ?>
			<?= form_hidden('redirect', $this->uri->uri_string()) ?>
		<?= form_close() ?>
	
	<h4><?= pluralize($sections->size, lang('lib_section')) ?></h4>
	<ul>
	<?php foreach ($sections->content as $key => $item): ?>
		<a href="<?= link_section($links->section, $item) ?>" >
			<li class="sb-<?=$item->type.' '.active_item($active_sb, $item->type.'_'.$item->key) ?>">
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