		<?php foreach ($items->content as $item):?>
			
			<?php if (isset($item->key)): ?>
				<div class="show-list">
					<?= $this->transcode->img($item, array('height' => 50, 'scale' => 'height', 'align' => 'right'))?>
					<div class="show-list-txt">
						<h3><?=anchor(
							$item->key,
							$item->name)?>
						</h3>
					</div>
				</div>
			<?php endif ?>
		
		<?php endforeach ?>
