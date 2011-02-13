<script type="text/javascript">
var uiEffect	= 'slide';
var uiSpeed		= 200;
var convertVideo = '<?= $convert ?>';
var player = null;

$(function(){
	
	var playlist	= $('#playlist');
	var downloads	= $('#download');
	var toMove		= $('#movie-prod');
	player = $('#player')
	
	$('.button').eq(0).stop().toggle(
	function(){
		toMove.hide(uiEffect, { direction: 'up' }, uiSpeed,function(){
			player.show(uiEffect, { direction: 'down' }, uiSpeed);
		});
		playlist.show(uiEffect, { direction: 'up' }, uiSpeed);
	},function(){
		player.hide(uiEffect, { direction: 'down' }, uiSpeed, function(){
			toMove.show(uiEffect, { direction: 'up' }, uiSpeed);
		});
		playlist.hide(uiEffect, { direction: 'up' }, uiSpeed);
	});
	
	$('.button').eq(1).stop().toggle(
	function(){
		downloads.show(uiEffect, { direction: 'up' }, uiSpeed);
	},function(){
		downloads.hide(uiEffect, { direction: 'up' }, uiSpeed);
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
	
	function load_video(source)
	{
		$('#video-player h2').text('Chargement de la video...');
		var video = $('video');
		video[0].src = source;
		video[0].load();
		video[0].addEventListener("canplay", resize_player, false);
	}
	
	$('.playlist-section a').click(function(){
		var video = $('video');
		var curWidth = $('#show-player').width();

		//myPlayer.video.src = $(this).attr('href');
		$('video').attr('src', $(this).attr('href'));
		$('video').find('track').attr('src', $(this).attr('data-sub'));
		
		var myPlayer = VideoJS.setup("show-player");
		myPlayer.subtitlesSource = $(this).attr('data-sub');
		myPlayer.video.load();
		$('watching').removeClass('watching');
		$(this).addClass('watching');
		
		var ratio = $(this).attr('data-ratio');
		$('#show-player').animate({'height': Math.round(curWidth / ratio)+'px'}, 'slow', function(){
				myPlayer.video.play();
		});
		
		return false;
		//video[0].addEventListener("canplay", resize_player, false);
	});
	
	function resize_player()
	{
		var video = $('video');
		$('#player').animate({'height': video.height()+'px'}, 'slow');
		$('#video-player h2').fadeTo(0, 200, function(){$(this).remove()});
		video[0].play();
	}	
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
					<span class="button gradient rounded">Watch</span>
					<span class="button gradient rounded">download</span>
				</div>
				
				<div id="playlist" class="button-rel" style="display:none">
				<?php $i = 1; foreach ($item->media->part as $part): ?>
	  			<div class="playlist-section">
	  				<?=anchor($this->transcode->video($part, array('ratingKey' => $item->ratingKey)), 
	  					lang('playlist.part').' '.$i, 
	  					'data-file="'.$part->file.'"
	  					data-ratio="'.$item->attributes->aspectRatio.'" data-sub="'.$part->subtitles.'"'
	  				)?>
	  			</div>
	  		<?php $i++; endforeach ?>
	  		</div>
	  		
				<div id="download" class="button-rel" style="display:none">
					<?php $i = 1; foreach ($item->media->part as $part): ?>
						<div><?=anchor('download'.$part->file, lang('playlist.part').' '.$i, 'class="dl"')?></div>
					<?php $i++; endforeach ?>
				</div>

			</div>
		</div>
		
		<div id="movie-content" class="dark-gradient">
			<div id="details-text" style="background-image: url(<?= transcode_img($item, array('height' => 1000, 'width' => 1000, 'force' => 'art'), true)?>)">
			<div class="opacity">
				<h1 id="movie-title" class="txt-shadow"><?= $item->title ?> <small>(<?= @$item->year ?>)</small></h1>
				<h2><?= @$item->tagline ?></h2>
				<p><?= @$item->summary ?></p>
				</div>
			</div>
			
			<div id="movie-prod">
				<?php krsort($item->details); foreach ($item->details as $key => $details): ?>
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