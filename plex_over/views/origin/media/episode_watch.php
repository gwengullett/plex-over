<script>
 $(function(){
		$('a.tip').tipTip({maxWidth: 400, delay : 1000, fadeOut:0, defaultPosition: 'top'});
		var player = VideoJS.setup("show-player");
		var ratio = $(player.video).attr('data-ratio');
		var curWidth = $('#show-player').width();
		$('#show-player').height(Math.round(curWidth / ratio)+'px');
 });
</script>
<div id="content" class="fit">

	<?= $views->top_nav ?>

	<div id="movie-details" class="gradient">
		<div id="details-cover" class="top">
		  <?= transcode_img($item, array('width' => 150, 'height' => 220, 'scale' => 'width', 'class' => 'rounded shadow'))?>
		</div>
		  		
		<div id="movie-tech" class="clear">
		  <ul>
		  	<li>
		  		<strong><?= lang('duration')?>:</strong><br />
		  		<?= duration($episode->duration, 'movie')?>
		  	</li>
		  	<?php foreach ($episode->details as $key => $details): ?>
		  	<li>
		  		<strong><?= pluralize(count($details), lang($key), false) ?>:</strong><br />
		  		<?= movie_details($details) ?>
		  	</li>
		  	<?php endforeach ?>
		  	<?php	if (isset($item->grandparentContentRating)): ?>
		  		<li>
		  			<strong><?= lang('rating') ?>:</strong><br />
		  			<span><?= $item->grandparentContentRating ?></span>
		  		</li>
		  	<?php endif ?>
		  	<?php	if (isset($item->grandparentStudio)): ?>
		  		<li>
		  			<strong><?= lang('studio') ?>:</strong><br />
		  			<span><?= $item->grandparentStudio ?></span>
		  		</li>
		  	<?php endif ?>

		  </ul>
		</div>
		
		<div id="movie-actions">
		  <p><span class="button gradient"><?= anchor_download($episode->media->part[0]->file, $episode->media->part[0]->size) ?></span></p>
		</div>
	</div>
	
	<div id="movie-content">
		<div id="episode-details" class="dark-gradient bb">	
			<h1>
			  <?= $episode->title ?> 
			  <small>- <?= lang('episode')." ".$episode->index ?></small>
			 </h1>
		</div>
		<div id="episode-player">
			<div class="video-js-box left">
				<video data-ratio="<?= $episode->attributes->aspectRatio ?>" id="show-player" class="video-js" controls="controls" x-webkit-airplay="allow">
					<source src="<?= $this->transcode->video($episode->media->part[0], array('ratingKey' => $item->key)) ?>"  type="video/mp4">
					<track kind="subtitles" src="<?= $episode->media->part[0]->subtitles ?>" srclang="en-US" label="English"></track>
				</video>
			</div>
		</div>

		<div id="episodes">
		  <?php foreach ($item->content as $friend): ?>
		  	<div class="jacket">
		  		<a href="<?= link_media($link, $friend->ratingKey.$show_link, $this->uri->segment(9)) ?>"
		  			title="<h3><?= $friend->title ?></h3> <?= $friend->summary ?>" 
		  			class="tp" >
		  			<div class="img <?= active_item((string)$episode->index, (string)$friend->index, 'current') ?>">
		  			<?= transcode_img($friend, array('width' => 130, 'height' => 72, 'scale' => 'both'))?>
		  			<strong><?= ucwords(lang('episode'))." ".$friend->index ?></strong><br />
		  			<span><?= $friend->title ?></span>
		  			</div>
		  		</a>
		  	</div>
		  <?php endforeach ?>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div><!-- movie content -->
</div>