<div id="content" class="fit">
	
<?= $views->top_nav ?>
<div class="dark-gradient" style="height:100%">

	<div id="season" class=" bb" style="background-image: url(<?= transcode_img($item, array('height' => 500, 'width' => 500, 'force' => 'art'), true)?>)">
		<div class="details opacity">
				<div id="details-main">
					<div id="details-cover" class="left">
				 		<?= $this->transcode->img($item, array('height' => 150, 'scale' => 'height', 'class' => 'rounded shadow')) ?>
				 	</div>
					<h1 class="txt-shadow "><?= $item->title2 ?>
						<small>(<?= @$item->parentYear ?>) </small>
					</h1>
					<h2><?= pluralize(childs_count($item->size), lang('season')) ?></h2>
					<p><?= word_limiter(@$item->summary, 100) ?></p>
				</div>
			<div class="clear"></div>
		</div>
	</div>
	
	<div id="details-sub">
	<?php foreach ($item->content as $season): if (@$season->ratingKey): ?>
			<div class="jacket">
				<a href="<?= link_media($links->item, $season->ratingKey.$show_link, $this->uri->segment(5)) ?>" />
					<div class="img">
						<?= transcode_img($season, array('height' => 150, 'width' => 110, 'type' => 'src')) ?>
					</div>
			 		<strong><?= character_limiter($season->title, 15) ?></strong><br />
			 		<span><?= pluralize($season->leafCount, lang('episode')) ?></span>
			 	</a>
			</div>
	<?php endif; endforeach ?>
	</div>
	
	</div>
</div>