<script type="text/javascript">
$(function(){
	var plex_uri = '<?= site_url() ?>';
	
	var current_val = $('#top_nav option:selected').val();
	
	$('#top_nav').click(function() {
		var new_val = $('#top_nav option:selected').val();
		if (current_val != new_val)
		{
  		$(location).attr('href',plex_uri + new_val);
  	}
	});
});

</script>
<div id="breadcrumb" class=" gradient fixed">

	<div class="b-path left">
		<?php if (isset($this->breadcrumb)): ?>
			
			<?php foreach ($this->breadcrumb as $key => $title):?>
					<?= ($key) ? anchor($key, $title) : $title ?>
			<?php endforeach ?>
		<?php endif ?>

		<input type="search" name="search" id="search" placeholder="<?= lang('search') ?>" />	
	</div>
	
	<div class="b-filter right">
		<?php if (isset($filters)): ?>
	    	<?= topnav_select($links->top_nav, $filters, $this->segments) ?>
	   <?php endif ?>
	</div>

</div>