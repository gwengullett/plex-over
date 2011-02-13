<!DOCTYPE >
<html>
	<head>
		<title><?= $title ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="<?=site_url('css/styles.css')?>" type="text/css">
		<link rel="stylesheet" href="<?=site_url('css/tiptip.css')?>" type="text/css">
		<link rel="stylesheet" href="<?=site_url('css/video.css')?>" type="text/css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?=site_url('js/lazyload.js')?>"></script>
		<script type="text/javascript" src="<?=site_url('js/application.js')?>"></script>
		<script type="text/javascript" src="<?=site_url('js/tiptip.js')?>"></script>
		<script type="text/javascript" src="<?=site_url('js/video.js')?>" charset="utf-8"></script>
		<script type="text/javascript" src="<?=site_url('js/thumbs.js')?>"></script>
		<script type="text/javascript" src="<?=site_url('js/flowplayer/flowplayer-3.2.4.min.js')?>"></script>
		<script type="text/javascript" charset="utf-8">
  		$(function() {
   			var sum_length	= 400;
  		  
  		  $('img[data-src]').attr('src', '<?=site_url('/images/blank.png')?>');
				$('img[data-src]').live('inview', function(event, isVisible) {
      		if (!isVisible) { return; }
      		var img = $(this);
      		// Show a smooth animation
      		img.fadeTo(0, 0);
      		img.load(function() { img.fadeTo(300, 1); });
      		// Change src
      		img.attr('src', img.attr('data-src'));
      		// Remove it from live event selector
      		img.removeAttr('data-src');
    		});
			  
			  if ($('.summary').text().length > sum_length)
			  {
			  	$('#sum-hide').html($('.summary').html());
			  	to_append = '... <br /><br /><a class="cb button dark-gradient rounded-st"> &#10145; <?= lang('read_more') ?></a>';
			  	$('#details-text .summary').html(function(i, t) { return t.substr(0, sum_length); }).append(to_append);
			  	//alert($('.summary').text().length);
			  }
			  
			  $('input[name="search"]').search('.item', function(on) {
  		  on.all(function(results) {
  		    var size = results ? results.size() : 0
  		    $(this).next('span').find('a').text(size);
  		  });
			
  		  on.reset(function() {
  		    $('#none').hide();
  		    $('.item').show();
  		  });
			
  		  on.empty(function() {
  		    $('#none').show();
			  	$('.item').hide();
			  	//grid.vgrefresh();
  		  });
			
  		  on.results(function(results) {
  		    $('#none').hide();
			  	//grid.vgrefresh();
			  	$('.item').hide();
  		    results.show();
  		  });
  		});
  	});
	</script>
	</head>
	
	<body>