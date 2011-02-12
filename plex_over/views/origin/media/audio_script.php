<script type="text/javascript">
var current;	
var player = flowplayer("audio", '<?= site_url('js/flowplayer/flowplayer-3.2.5.swf') ?>', { 
  // fullscreen button not needed here
  width:400,
  clip: {
    onFinish: function() {
    	nextSong();
    }
  },
  plugins: { 
    controls: { 
        fullscreen: false,
        autoHide: false,
        autoPlay: false, 
        height: 30,
        width: 400
    },
    audio: {
    	url: '<?= site_url('js/flowplayer/flowplayer.audio-3.2.1.swf') ?>'
  	}
  }
});

function nextSong(event) {
  var nextS = current.split('_');
  // convert to int and increment
  nextS[1] = parseInt(nextS[1]) + 1;
  // assign next song, or first if we are at the end
  nextS = ($('#'+nextS.join('_')).length > 0) ? '#'+nextS.join('_') : '#'+nextS[0]+'_0';
  // play the song
  $(nextS).find('a').click();
}
$(function(){
	// declare current a.play in relative scope
	// create dynamically <source> element to lef flow player create his object
	// Listenner to switch to the next song automatically
	//player.addEventListener('ended', nextSong, false);
	$('.tip').tipTip({maxWidth: 400, delay : 0, fadeOut:0, defaultPosition: 'left'});
	// clickable links into html
	$('.album-content a').click(function(){
		// show the player if hidden
		var parentTr = $(this).parent('td').parent('tr');
		var trIndex	= parentTr.attr('id').split("_")[0];
		// loading the song
		if (! parentTr.hasClass('play')) {
			// the song is not paused, we are loading it
			if (! parentTr.hasClass('pause')) {
				player.setClip($(this).attr('href'));
				$('.album-content tr').removeClass('play').removeClass('pause');
			}
			// add clas 'play' then play the song
			parentTr.addClass('play').removeClass('pause');
			player.play();
		}
		// song is paused, we play it again
		else {
			parentTr.addClass('pause').removeClass('play');
			player.pause();
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
		
});
</script>