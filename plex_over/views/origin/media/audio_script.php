<script type="text/javascript">
var current;
var indexes = '.album-content tr';

function nextSong(event) {
	var nextS = $(indexes).eq(current).nextAll(':visible:first');
  // play the song
  $(nextS).find('a').click();
}

function switchPlay(event) {
	$('.pause').switchClass('pause', 'play');
}
function switchPause(event) {
	$('.play').switchClass('play', 'pause');
}

$(function(){

	var player = $('audio');
	player[0].addEventListener('ended', nextSong, false);
	player[0].addEventListener('play', switchPlay, false);
	player[0].addEventListener('pause', switchPause, false);
			
	$('.album-content a').click(function(){

		var parentTr = $(this).parent('td').parent('tr');
		var trIndex	= parentTr.attr('id').split("_")[0];
		// loading the song
		if (! parentTr.hasClass('play')) {

			// the song is not paused, we are loading it
			if (! parentTr.hasClass('pause')) {
				player[0].src = $(this).attr('href');
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
		
		current = $(indexes).index(parentTr);
		return false;
	});
		
});
</script>