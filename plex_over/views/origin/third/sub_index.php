<?php $this->load->view($this->template.'/layouts/top_nav'); ?>

<div id="content" class="fit" >
		<?= img(array('src' => $this->plex_url.$items->art, 'class' => 'header')) ?>

 <div id="plugin-directory">
	<div class="details bb bg-header">

		<div id="details-text" class="left">
		    <h1 class="txt-shadow ">
		    	<?=$items->title1?>
		    </h1>
		</div>
		
		<div class="clear"></div>
	
	</div>
		
	<div class="dir">
		<?php $this->load->view($this->template.'/third/'.strtolower($items->view)) ?>
	</div>	
	
	</div>
</div>
</div>