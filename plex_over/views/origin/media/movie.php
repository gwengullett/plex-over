<script type="text/javascript">
var uiEffect	= 'slide';
var uiSpeed		= 200;
var convertVideo = '<?= $convert ?>';
var player = null;
var paused = 'paused';
var playing = 'watching';

$(function(){
	
	var playlist	= $('#playlist');
	var downloads	= $('#download');
	var toMove		= $('#movie-prod');
	var playerDiv = $('#player');
	
	$('.button').eq(0).stop().toggle(
	function(){
		toMove.hide(uiEffect, { direction: 'up' }, uiSpeed,function(){
			playerDiv.show(uiEffect, { direction: 'down' }, uiSpeed);
		});
		playlist.show();
	},function(){
		playerDiv.hide(uiEffect, { direction: 'down' }, uiSpeed, function(){
			toMove.show(uiEffect, { direction: 'up' }, uiSpeed);
		});
		playlist.hide();
	});
	
	$('.button').eq(1).stop().toggle(
	function(){
		if (player) {
			$('a.'+playing).switchClass(playing, paused);
			player.video.pause();
		}
		downloads.show();
	},function(){
		downloads.hide();
	});
	
	
	$('.button').toggle(
		function(){
		$('.current').click();
			$(this).addClass('current');
		},function() {
			$(this).removeClass('current');
	});
	
	function convert_vid(file, aRatio)
	{
		$('#video-player h2').text('Conversion au format h264...');
		$.ajax({
			type: 'POST',
			data: {path: file, ratio: aRatio},
			url: '<?= site_url('convert/h264') ?>',
			success:function(response)
			{
				load_video(response);
				return;
			}
		})
	}
	
	// PLaylist video player controls
	$('.playlist-section a').click(function(){
	
		if ($(this).is('.'+playing)) {
			$(this).switchClass(playing, paused);
			player.video.pause();
		}
		else if ($(this).is('.'+paused)) {
			$(this).switchClass(paused, playing);
			player.video.play();
		}
		else {
			var video = $('video');
			var curWidth = $('#show-player').width();
			
			//myPlayer.video.src = $(this).attr('href');
			$('video').attr('src', $(this).attr('href'));
			$('video').find('track').attr('src', $(this).attr('data-sub'));
			
			player = VideoJS.setup("show-player");
			player.subtitlesSource = $(this).attr('data-sub');
			player.video.load();
			$('.playlist-section a').attr('class', '');
			$(this).addClass(playing);
			
			var ratio = $(this).attr('data-ratio');
			$('#show-player').animate({'height': Math.round(curWidth / ratio)+'px'}, 'slow', function(){
					player.video.play();
			});
		}
		return false;
	});
	
	// Player playlisy interactions
	$('.vjs-play-control').live('click', function(){
		if(player.video.paused) {
			$('a.'+playing).switchClass(playing, paused);
		}
		else {
			$('a.'+paused).switchClass(paused, playing);
		}
	});
	
});
</script>
<div id="content" class="fit">
	<?= $views->top_nav ?>

		<div id="movie-details" class="gradient">
			<div id="movie-cover" class="top left">
				<?= transcode_img($item, array('height' => 220, 'width' => 150, 'scale' => 'both', 'class' => 'rounded shadow'))?>
			</div>
			<div id="movie-tech" class="clear">
				<ul>
				<?php foreach ($item->attributes as $name => $value): ?>
					<li>
						<span><?= $name ?></span>:
						<span><?= ($name == 'duration') ? duration($value, 'movie') : $value ?></span>
					</li>
				<?php endforeach ?>
				</ul>
				<div id="movie-actions">
					<span class="button gradient"><?= lang('watch') ?></span>
					<span class="button gradient"><?= lang('download') ?></span>
				</div>
				
				<div id="playlist" class="button-rel" style="display:none">
				<?php $i = 1; foreach ($item->media->part as $part): ?>
	  			<div class="playlist-section">
	  				<?=anchor($this->transcode->video($part, array('ratingKey' => $item->ratingKey)), 
	  					lang('playlist.part_'.$i), 
	  					'data-file="'.$part->file.'"
	  					data-ratio="'.$item->attributes->aspectRatio.'" data-sub="'.$part->subtitles.'"'
	  				)?>
	  			</div>
	  		<?php $i++; endforeach ?>
	  		</div>
	  		
				<div id="download" class="button-rel" style="display:none">
					<?php $i = 1; foreach ($item->media->part as $part): ?>
						<div><?=anchor('download'.$part->file, lang('playlist.part_'.$i).' ('.byte_format($part->size).')')?></div>
					<?php $i++; endforeach ?>
				</div>

			</div>
		</div>
		
		<div id="movie-content" class="dark-gradient">
			<div id="details-text" style="background-image: url(<?= transcode_img($item, array('height' => 500, 'width' => 500, 'force' => 'art'), true)?>)">
			<div class="opacity bb">
				<h1 id="movie-title" class="txt-shadow"><?= $item->title ?> <small>(<?= @$item->year ?>)</small></h1>
				<h2><?= @$item->tagline ?></h2>
				<p id="summary"><?= split_summary(@$item->summary) ?></p>
				</div>
			</div>
			
			<div id="movie-prod" class="media-prod">
				<?php foreach ($item->details as $key => $details): ?>
					<div class="prod movie_<?= count($item->details) ?>">
						<h4><?= pluralize(count($details), lang($key), false) ?></h4>
						<?= movie_details($details, $links->section.'/'.$prod_links.'/'.link_prod($key)) ?>
					</div>
				<?php endforeach ?>
			</div>
			
			<div id="player" class="shadow dark-gradient" style="display:none">
				<div class="video-js-box">
					<video id="show-player" class="video-js vim-css">
						<source type="video/mp4" />
						<track kind="subtitles" src="" srclang="en-US" label="English"></track>
					</video>
				</div>
			</div>
				
		</div> <!-- movie-content -->
	
</div>