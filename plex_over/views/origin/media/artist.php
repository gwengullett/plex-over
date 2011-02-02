<script type="text/javascript">
$(function(){
	
	// declare current a.play in relative scope
	var current;
	var player = $('audio');
	// Listenner to switch to the next song automatically
	player[0].addEventListener('ended', nextSong, false);
	
	$('.tip').tipTip({maxWidth: 400, delay : 0, fadeOut:0, defaultPosition: 'left'});

	
	// clickable links into html
	$('.album-content a').click(function(){
		// show the player if hidden
		if (player.is(':hidden')) player.fadeIn(200);
		
		var parentTr = $(this).parent('td').parent('tr');
		var trIndex	= parentTr.attr('id').split("_")[0];
						
		// loading the song
		if (! parentTr.hasClass('play')) {
			// the song is not paused, we are loading it
			if (! parentTr.hasClass('pause')) {
				player.attr('src', $(this).attr('href'));
				$('.album-content tr').removeClass('play').removeClass('pause');
			}

			// add clas 'play' then play the song
			parentTr.addClass('play').removeClass('pause');
			player[0].play();			
		}
		// song is paused, we play it again
		else {
			parentTr.addClass('pause').removeClass('play');
			player[0].pause();
		}
		
		// add informations in bottom about song, artist and album
		$('.listenning').html(
			'<strong>'+$(this).next('span').text()+'</strong>' +
			'<small> (' +
			$(this).attr('rel') + ' - ' + 
			$(this).attr('album') +
			')</small>');
		
		current = parentTr.attr('id');
		// don't follow href link...
		return false;
	});
	
	function nextSong(event) {
		var nextS = current.split('_');
		console.log(nextS);
		// convert to int and increment
		nextS[1] = parseInt(nextS[1]) + 1;
		// assign next song, or first if we are at the end
		nextS = ($('#'+nextS.join('_')).length > 0) ? '#'+nextS.join('_') : '#'+nextS[0]+'_0';
		// play the song
		$(nextS).find('a').click();
	}
		
});
</script>

<div id="content" class="fit">
	<?= $views->top_nav ?>
		
	<div class="details">
		<div id="details-main">
				<h1 class="txt-shadow ">
					<?= @$item->title2 ?>
					<small>( <?= pluralize($item->size, $content_type) ?> )</small>
				</h1>
			<div class="clear"></div>
		</div>
	</div>
	
	<div id="details-sub">
	<?php $i = 0; foreach ($item->albums as $album): ?>
		<table id="albums">
			<tr>
				<td>
				<table class="album-cover">
				<tr>
					<td>
		    		<?= $this->transcode->img($album, array('width' => 130, 'class' => 'rounded shadow')) ?>
						<h4 class="h4"><?= @$album->album ?></h4>
						<small><?= @$album->year ?></small>
					</td>
				</tr>
				</table>
				<table class="album-content">
				<?php $ii = 0; foreach ($album->tracks as $track): ?>
					<tr id="index_<?= $i ?>" class=" <?= css_alt($ii) ?>">
						<td><?= $i+1 ?></td>
						<td><?= character_limiter($track->track, 70) ?></td>
						<td>
							<a href="<?= link_itunes($link, $album, $track) ?>"
		    		    class="tip" 
		    		    id="song_<?=$i?>"
		    		    title="<?= $track->album ?>"
		    		    album="<?= $track->album ?>"
		    		    rel="<?= $track->artist ?>">
		    		    link to song
							</a>
							<span><?= character_limiter($track->artist, 70) ?></span>
						</td>
						<td><?= duration((int)$track->totalTime)." ".lang('minutes.short' )?></td>
						<td><?=byte_format((int) $track->size) ?></td>
					</tr>
				<?php $ii++;  $i++; endforeach ?>
				</table>
			</td>
		</tr>
	</table>
	<?php endforeach ?>
	</div>

	
	<div id="content-bottom" class="dark-gradient">
		<div class="left">
		    <audio controls></audio>
		</div>
		<div class="left listenning"></div>
	</div>
	
</div>