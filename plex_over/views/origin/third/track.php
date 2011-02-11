<?php $this->load->view($this->template.'/media/audio_script.php') ?>

	<div id="details-sub">
			<table class="album-content" id="albums">
				<tbody>
				<?php $i = 0; foreach ($items->content as $track): ?>
					<tr id="index_<?= $i ?>" class=" <?= css_alt($i) ?>">
						<td><?= $i+1 ?></td>
						<td>
							<a href="<?= link_server($track->key, $this->plex_url) ?>"
		    		    class="tip" 
		    		    id="song_<?=$i?>"
		    		    album="<?= $track->album ?>"
		    		    rel="<?= $track->artist ?>">
		    		    link to song
							</a>
							<span><?= character_limiter($track->artist, 70) ?></span>
						</td>
						<td><?= character_limiter($track->track, 70) ?></td>
						<td><?= character_limiter($track->album, 70) ?></td>
						<td><?= duration($track->totalTime)." ".lang('minutes.short' ) ?></td>
					</tr>
				<?php $i++; endforeach ?>
				</tbody>
		</table>
	</div>
	<div id="content-bottom" class="dark-gradient">
		<div class="left">
		    <audio controls></audio>
		</div>
		<div class="left listenning"></div>
	</div>
