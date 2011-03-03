<div id="content" class="fit flat">
	
	<div id="flat">
		<?php $this->load->view($this->template.'/layouts/top_nav');?>
		<div id="browser">
			<?php foreach ($items->content as $key => $item): ?>
				<div class="item item-flat <?= css_alt($key).' '.$item->type?>">
					<a href="<?=link_item($link, $item, $this->uri->segment(4))?>">
							<div>
								<?= title($item) ?>
								<?php $alt = (isset($item->year)) ? $item->year : '' ?>
								<?= (isset($item->leafCount)) ? $item->leafCount. " ".lang($item->type.'.childs') : $alt ?>
							</div>
					</a>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>