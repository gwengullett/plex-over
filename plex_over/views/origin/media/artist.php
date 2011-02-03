<?php include_once('audio_script.php') ?>

<div id="content" class="fit">
	
	<?php $this->load->view($this->template.'/layouts/top_nav');?>
		
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