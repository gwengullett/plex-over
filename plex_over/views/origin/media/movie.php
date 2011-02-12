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
		//myPlayer.video.src = $(this).attr('href');
		$('video').attr('src', $(this).attr('href'));
		$('video').find('track').attr('src', $(this).attr('data-sub'));
		
		var myPlayer = VideoJS.setup("show-player");
		myPlayer.subtitlesSource = $(this).attr('data-sub');
		myPlayer.video.load();
		
		$('#player').animate({'height': video.height()+'px'}, 'slow');
		myPlayer.video.play();
		
		return false;
		//video[0].addEventListener("canplay", resize_player, false);
	});
	
	function resize_player()
	{
		var video = $('video');
		//$('#player').animate({'height': video.height()+'px'}, 'slow');
		//$('#video-player h2').fadeTo(0, 200, function(){$(this).remove()});
		video[0].play();
	}	
});
</script>
<style type="text/css">
.top {
	margin-top: 40px;
}
#movie-details {
	min-height: 100%;
	width: 200px;
	float: left;
	border-right: 1px solid #444;
	margin-right: 20px;
	position: relative;
}

#movie-cover {
	width: 100%;
	text-align: center;
}

#movie-content {
	margin-left: 200px;
	min-height: 100%;
}
#movie-content h1 {
	margin-top: 0;
}

#movie-content #details-text {
	background: left top no-repeat;
	background-size: 100% auto;
	padding-bottom: 0;
}
.opacity {
	background: url(../../../../css/images/content-opacity.png);
	padding-bottom: 20px;
}
#movie-tech ul {
	list-style: none;
	padding-top: 20px;
	margin-left: 0;
	padding-left: 20px;
}
#movie-prod, #details-text p {
	overflow: hidden;
	color: silver;
	padding-right: 20px;
}
#movie-prod div {
	float: left;
}

.movie_3 {
	width: 33%;
}
.movie_4 {
	width: 25%;
}

#movie-title {
	padding-top: 50px;
}

#movie-content h4 {
	color: #ff5e27;
}

#movie-actions {
	margin-left: 20px;
}

#movie-actions span {
	border: 1px solid #83afdb;
	padding: 5px 10px;
}

</style>
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
				<div class="movie_<?= count($item->details) ?>">
					<h4><?= pluralize(count($details), lang($key), false) ?></h4>
					<?= movie_details($details) ?>
				</div>
			<?php endforeach ?>
			</div>
		</div>
	
</div>