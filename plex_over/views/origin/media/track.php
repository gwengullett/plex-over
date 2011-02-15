<div id="content" class="fit">
	<?= $views->top_nav ?>
		
	<div class="details">
		<div id="details-main" class="bb">
				<h1 class="txt-shadow "><?= $item->title2 ?></h1>
				<h2 class="txt-shadow ">
					<span id="artist"><?= $item->title1 ?></span>, 
					<small><?= @$item->parentYear ?></small>
				</h2>
			<div class="clear"></div>
		</div>
	</div>
	
	<div id="details-sub">
		<table id="albums">
			<tr>
				<td>
				<table class="album-cover">
				<tr>
					<td>
		    		<?= $this->transcode->img($item, array('width' => 130, 'class' => 'rounded shadow')) ?>
					</td>
				</tr>
				</table>
				<table class="album-content">
				<?php $i = 0; foreach ($item->content as $track): ?>
					<tr id="index_<?= $i ?>" class="item <?= css_alt($i) ?>">
						<td><?= $i+1 ?></td>
						<td><?= character_limiter($track->title, 70) ?></td>
						<td>
							<a href="<?= $this->plex_url.$track->media->Part->attributes()->key ?>"
		    		    class="tip" 
		    		    id="song_<?=$i?>"
		    		    album="<?= $item->title2 ?>"
		    		    rel="<?= $track->title ?>">
		    		    link to song
							</a>
							<span><?= character_limiter($item->title1, 70) ?></span>
						</td>
						<td><?= duration($track->duration)." ".lang('minutes.short' )?></td>
						<td><?=byte_format($track->media->Part->attributes()->size) ?></td>
					</tr>
				<?php $i++; endforeach ?>
				</table>
			</td>
		</tr>
	</table>
	</div>

	<div id="content-bottom" class="dark-gradient">
		<div class="left">
		    <div id="audio"></div>
		</div>
		<div class="left listenning"></div>
	</div>
	<?php $this->load->view($this->template.'/media/audio_script.php') ?>
	
</div>