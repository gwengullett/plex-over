<script type="text/javascript">

</script>
<?php $this->load->view($this->template.'/layouts/top_nav'); ?>

<div id="content" class="fit" >
	
	<div id="plugin-directory">
		<div class="details dark-gradient bb">
			<h1 class="txt-shadow">
				<?= @$items->title1 ?> <small><?= @$items->title2 ?></small>
			</h1>
		</div>
		
		<div class="dir <?= $items->view ?>">
			<?php $this->load->view($this->template.'/third/'.dispatch_views($items, $this->views)) ?>
			<div class="clear"></div>
		</div>
	</div>
</div>