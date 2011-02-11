<?php $this->load->view($this->template.'/layouts/top_nav');?>

<div id="content" class="fit" >
	<div id="plugin-directory">
		
		<div class="dir <?= $items->view ?>">
			<?php $this->load->view($this->template.'/third/'.dispatch_views($items, $this->views)) ?>
			<div class="clear"></div>
		</div>
	</div>
</div>