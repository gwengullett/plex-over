<script type="text/javascript">
$(function(){
	
	// declare current a.play in relative scope
	var current;
	var player = $('audio');
	// Listenner to switch to the next song automatically
	player[0].addEventListener('ended', nextSong, false);
	
	$('.tip').tipTip({maxWidth: 400, delay : 0, fadeOut:0, defaultPosition: 'left'});

	
	// clickable links into html
	$('.track a').click(function(){
		// show the player if hidden
		if (player.is(':hidden')) player.fadeIn(200);
		
		var parentLi = $(this).parent('li');
		var liIndex	= parentLi.attr('class').split(" ")[0];
		
		// loading the song
		if (! parentLi.hasClass('play')) {
			// the song is not paused, we are loading it
			if (! parentLi.hasClass('pause')) {
				$('.album_content li').removeClass('play').removeClass('pause');
				player.attr('src', $(this).attr('href'));
			}
			// add clas 'play' then play the song
			$('.'+liIndex).addClass('play').removeClass('pause');
			player[0].play();			
		}
		// song is paused, we play it again
		else {
			$('.'+liIndex).addClass('pause').removeClass('play');
			player[0].pause();
		}
		
		// add informations in bottom about song, artist and album
		$('.listenning').html(
			'<strong>'+$(this).text()+'</strong>' +
			'<small>(' +
			$(this).attr('title') + ' - ' + 
			$(this).attr('rel') +
			')</small>');
		
		current = $(this).attr('id');
		// don't follow href link...
		return false;
	});
	
	function nextSong(event) {
		var nextS = current.split('_');
		// convert to int and increment
		nextS[1] = parseInt(nextS[1]) + 1;
		// assign next song, or first if we are at the end
		nextS = ($('#'+nextS.join('_')).length > 0) ? '#'+nextS.join('_') : '#'+nextS[0]+'_0';
		// play the song
		$(nextS).click();
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
		
		<?php $e = 0; $f = 0; foreach ($item->albums as $album):?>
		    	<div class="album_content album-container">
					<div class="album">
		    		<?= $this->transcode->img($album, array('width' => 130, 'class' => 'rounded shadow')) ?>
						<h4 class="h4"><?= @$album->album ?></h4>
						<small><?= @$album->year ?></small>
		    	</div>
		    		
		    		<div class="track">
		    		    <ul>
					    	<?php $i = 0; foreach ($album->tracks as $track): ?>
		    		    		<li class="index_<?= $f.$i ?> <?= css_alt($i) ?>">
		    		    			<span><?= $i+1 ?>.</span>
		    		    			<a href="<?= link_itunes($link, $album, $track) ?>"
		    		    				class="tip" 
		    		    				id="song_<?=$e?>"
		    		    				title="<?= $track->artist ?>" 
		    		    				rel="<?= $track->album ?>">
		    		    				<?= character_limiter($track->track, 70) ?>
		    		    			</a>
		    		    		</li>
		    		    	<?php $i++; $e++; endforeach ?>
		    		    </ul>
		    		</div>
		    		<div class="duration">
		    		    <ul>
					    	<?php $i = 0; foreach ($album->tracks as $track): ?>
		    		    		<li class="index_<?= $f.$i ?> <?= css_alt($i) ?>">
		    		    			<a><?= duration((int)$track->totalTime)." ".lang('minutes.short' )?></a>
		    		    		</li>
		    		    	<?php $i++; endforeach ?>
		    		    </ul>
		    		</div>
		    		<div class="size">
		    		    <ul>
					    	<?php $i = 0; foreach ($album->tracks as $track):  ?>
		    		    		<li class="index_<?= $f.$i ?> <?= css_alt($i) ?>">
		    		    			<a><?=byte_format((int) $track->size) ?></a>
		    		    		</li>
		    		    	<?php $i++; endforeach ?>
		    		    </ul>
		    		</div>
		    	</div>
		
		<?php $f++;endforeach ?>		
	</div>
	
	<div id="content-bottom" class="dark-gradient">
		<div class="left">
		    <audio controls></audio>
		</div>
		<div class="left listenning"></div>
	</div>
	
</div>