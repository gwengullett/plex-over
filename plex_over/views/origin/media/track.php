<script type="text/javascript">
$(function(){
	
	// local storage for playlist
	$('.song').audioPlaylist({key : 'audio'});
	
	// declare current a.play in relative scope
	var current;
	var player = $('audio');
	// Listenner to switch to the next song automatically
	player[0].addEventListener('ended', nextSong, true);

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
			$(this).attr('art') + ' - ' + 
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
<?php
$e = 0;
//print_r($item);
?>
<div id="content" class="fit">

	<?= $views->top_nav ?>
		
	<div class="details">
				
		<div id="details-main">
				<h1 class="txt-shadow "><?= $item->title2 ?></h1>
				<h2 class="txt-shadow ">
					<span id="artist"><?= $item->title1 ?></span>, 
					<small><?= @$item->parentYear ?></small>
				</h2>
			<div class="clear"></div>
		</div>
	
	</div>
	
	<div id="details-sub">
		<div class="album_content album-container">
		<div class="album">
		<?= cover($this->thumb->get($this->plex_url.thumb($item))) ?>
		</div>
				<div class="track">
				  <ul>
				  	<?php $i = 0; foreach ($item->content as $track): ?>
		        		<li class="index_<?=$i?> <?=css_alt($i)?>">
		        			<span><?=$track->index?>.</span>
		        			<a class="song" href="<?= $this->plex_url.$track->media->Part->attributes()->key ?>"
		        				id="song_<?=$e?>"
		        				art="<?= $item->title1 ?>" 
		        				rel="<?= $item->title2 ?>"
		        				codec="<?= $track->media->attributes()->audioCodec ?>" >
		        				<?=$track->title?>
		        			</a>
		        		</li>
		        	<?php $i++; $e++; endforeach ?>
		        </ul>
		    </div>
		    <div class="duration">
		        <ul>
				  	<?php $i = 0; foreach ($item->content as $track):?>
		        		<li class="index_<?= $i ?> <?= css_alt($i) ?>">
		        			<a><?= duration($track->duration)." ".lang('minutes.short') ?></a>
		        		</li>
		        	<?php $i++; endforeach ?>
		        </ul>
		    </div>
		    <div class="size">
		        <ul>
				  	<?php $i = 0; foreach ($item->content as $track):?>
		        		<li class="index_<?=$i?> <?=css_alt($i)?>">
		        			<a><?=byte_format($track->media->Part->attributes()->size)?></a>
		        		</li>
		        	<?php $i++; endforeach ?>
		        </ul>
		    </div>
		   </div>
		</div>
	</div>
	
	<div id="content-bottom" class="dark-gradient">
		<div class="left">
		    <audio src="" controls="controls" type="audio/mpeg">
		    	Your browser doesnt support audio player.
		    </audio>
		</div>
		<div class="left listenning"></div>
	</div>
	
</div>