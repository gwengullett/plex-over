<script type="text/javascript">
var uiEffect = 'slide';
var uiSpeed = 400;
var toMove = '#details-sub';
var dirMove = 'up';
var convertVideo = '<?= $convert ?>';
var player = null;

$(function(){

	$('#watch-btn').toggle(function(){
		$(toMove).hide(uiEffect, { direction: dirMove }, uiSpeed, function(){
			$('#player').fadeTo(200, 1);
		});
	}, function(){
		$('#player').fadeOut(uiSpeed, 0).fadeTo(0, 0, function(){
			$(toMove).show(uiEffect, { direction: dirMove }, uiSpeed);
		});
	});
	
	// update the player with parts
	$('.playlist-section a').click(function(){
		$('#video-player').append('<h2 class="txt-shadow-d"></h2>');
		if (convertVideo)
		{
			convert_vid($(this).attr('data-file'), $(this).attr('data-ratio'));
			return false;
		}
		load_video($(this).attr('href'));
		return false;
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
	
	<div class="details">
		<div id="details-main">
			
			<div id="details-cover" class="left">
			<?= cover($this->thumb->get($this->plex_url.thumb($item))) ?>
			</div>
			
			<div id="details-text" class="left">
				<h1 class="txt-shadow "><?= $item->title ?> <small>(<?= @$item->year ?>)</small></h1>
				<h2><?= @$item->tagline ?></h2>
				<p><?= @$item->summary ?></p>
			</div>
			<div class="clear"></div>
		</div>

		<div id="details-sub">
			<ul>
			<li>
				<strong><?= lang('duration')?>: </strong>
				<?= duration($item->duration, 'movie')?>
			</li>
			<?php foreach ($item->details as $key => $details): ?>
				<li>
					<strong><?= pluralize(count($details), lang($key), false) ?>: </strong>
					<?= movie_details($details) ?>
				</li>
			<?php endforeach ?>
			</ul>
		</div>
	</div>
	
	<div id="player" class="shadow gradient">
		<div id="video-player">
			<video controls></video>
		</div>
		<div id="playlist" class="dark-gradient">
			<?php $i = 1; foreach ($item->media->part as $part): ?>
				<div class="playlist-section">
					<?=anchor(
						$this->plex_url.$part->key, 
						lang('playlist.part').' '.$i, 
						'class="block" data-file="'.$part->file.'"
						data-ratio="'.$item->attributes->aspectRatio.'"')?>
				</div>
			<?php $i++; endforeach ?>
		</div>
	</div>

	<div id="content-bottom" class="dark-gradient">
		<?php $i = 1; foreach ($item->media->part as $part): ?>
			<?=anchor('download'.$part->file, lang('playlist.part').' '.$i, 'class="dl button dark-gradient rounded-st"')?>
		<?php $i++; endforeach ?>
		<div class="right">
			<a id="watch-btn" class="button dark-gradient rounded-st">Watch</a>
		</div>
	</div>
</div>