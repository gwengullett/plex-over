<script type"text/jqvqscript">
 $(function(){
		$('.tip').tipTip({maxWidth: 400, delay : 1000, fadeOut:0, defaultPosition: 'top'});
		var myPlayer = VideoJS.setup("show-player");
 });
</script>

<div id="content" class="fit">

	<?= $views->top_nav ?>
	
	<div id="details-main" class="details dark-gradient show-list">
		<div id="details-cover" class="left">
			<?= $this->transcode->img($episode, array('width' => 130, 'height' => 72, 'scale' => 'both'))?>
		</div>
		
		<div id="details-text" class="left">
				<h1 class="txt-shadow"><?= $episode->title ?> <small>(<?= lang('episode')." ".$episode->index ?>)</small></h1>
		    <h2><?= $item->title1." ".$item->title2 ?></h2>
		</div>
		<div class="clear"></div>
	</div>
	
	<div id="show-main">
		<div class="video-js-box">
			<video id="show-player" class="video-js" controls="controls" poster="<?= $this->plex_url.thumb($episode) ?>" >
				<source src="<?= $this->transcode->video($episode->media->part[0], array('ratingKey' => $item->key)) ?>"  type="video/mp4" />
				<track kind="subtitles" src="<?= $episode->media->part[0]->subtitles ?>" srclang="en-US" label="English"></track>
			</video>
		</div>
		
		<div id="show-details" class="left">
			<ul>
				<li>
					<strong><?= lang('duration')?>:</strong>
					<?= duration($episode->duration, 'movie')?>
				</li>
				<?php foreach ($episode->details as $key => $details): ?>
				<li>
					<strong><?= pluralize(count($details), lang($key), false) ?>:</strong>
					<?= movie_details($details) ?>
				</li>
			<?php endforeach ?>
				<li>
					<p><?= anchor_download($episode->media->part[0]->file, $episode->media->part[0]->size) ?></p>
				</li>
			</ul>
		</div>
	</div>
	
	<div id="episodes">
		<?php foreach ($item->content as $friend): ?>
			<div class="jacket left">
				<a href="<?= site_url($link.$friend->ratingKey.$show_link) ?>"
					title="<h3><?= $friend->title ?></h3> <?= $friend->summary ?>" 
					class="tip" >
					<div class="img <?= active_item((string)$episode->index, (string)$friend->index, 'current') ?>">
					<?= $this->transcode->img($friend, array('width' => 130, 'height' => 72, 'scale' => 'both'))?>
					<strong><?= ucwords(lang('episode'))." ".$friend->index ?></strong><br />
					<span><?= $friend->title ?></span>
					</div>
				</a>
			</div>
		<?php endforeach ?>
	</div>

</div>