<script type="text/javascript">
$(window).load(function(){
	$('img.header').fullBg({container: '#content'});
});

</script>
<?php $this->load->view($this->template.'/layouts/top_nav'); ?>

<div id="content" class="fit" >
		<?= img(array('src' => $this->plex_url.@$items->art, 'class' => 'header')) ?>

 <div id="plugin-directory">
	<div class="details bg-header">

		<div id="details-text" class="left">
		    <h1 class="txt-shadow ">
		    	<?= @$items->title1 ?> <?= @$items->title2 ?>
		    </h1>
		</div>
		
		<div class="clear"></div>
	
	</div>
		
	<div class="dir <?= $items->view ?>">
		<?php $this->load->view($this->template.'/third/'.dispatch_views($items, $this->views)) ?>
	</div>	
	
	</div>
</div>
</div>