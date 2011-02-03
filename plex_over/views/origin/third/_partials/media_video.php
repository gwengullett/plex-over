<video class="media" controls="controls"></video>

<script type="text/javascript">

$(function(){
	$('.tip').click(function(){
		var video = $('video');
		video[0].load();
		video[0].play();
	});
});
</script>