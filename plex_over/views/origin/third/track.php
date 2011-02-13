<table id="albums"  style="margin-top:30px">
  <tr>
  	<td>
  	<table class="album-cover">
  	<tr>
  		<td>
    		<?= $this->transcode->img($items, array('width' => 130, 'class' => 'rounded shadow')) ?>
  			<h6><?= @$items->title2 ?></h6>
  		</td>
  	</tr>
  	</table>
  	<table class="album-content">
  	<?php $i = 0; foreach ($items->content as $track): ?>
  		<tr id="index_<?= $i ?>" class="item <?= css_alt($i) ?>">
  			<td><?= $i+1 ?></td>
  			<td>
  				<a href="<?= link_server($track->key, $this->plex_url) ?>" 
    		    title="<?= $track->track ?>"
    		    data-cover="<?= $this->transcode->img($track, array('width' => 110, 'class' => 'rounded shadow'), true) ?>"
    		    rel="<?= $track->artist ?>">
    		    link to song
  				</a>
  				<span><?= character_limiter($track->artist, 40) ?></span>
  			</td>
  			<td><?= character_limiter($track->track, 40) ?></td>
  			<td><?= character_limiter($track->album, 30) ?></td>
  			<td><?= duration($track->totalTime)." ".lang('minutes.short' ) ?></td>
  		</tr>
  	<?php $i++; endforeach ?>
  	</table>
  	</td>
  </tr>
</table>

	<div class="bg-header"></div>

	<div id="content-bottom" class="dark-gradient">
		<div class="left">
		    <div id="audio"></div>
		</div>
		<div class="left listenning"></div>
	</div>
	<?php $this->load->view($this->template.'/media/audio_script.php') ?>

	<script type="text/javascript">
	// flowplayer config
	// cover config
	$(function(){
		var cover, origCover;
		var hoverTr		= $('.album-content tr');
		var imgCover	= $('.album-cover img');
		
		hoverTr.hover(
			function(){
				origCover = imgCover.attr('src');
				cover = $(this).find('a').attr('data-cover');
				imgCover.attr('src', cover);
			},
			function(){
				imgCover.attr('src', origCover);
			}
		);
		hoverTr.find('a').click(function(){
			origCover = cover;
			imgCover.attr('src', cover);
		});
	});
	</script>
