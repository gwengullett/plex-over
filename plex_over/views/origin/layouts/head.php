<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
<title><?= $title ?></title>
<?= link_tag('css/styles.css') ?>
<?= link_tag('css/tiptip.css') ?>
<?= link_tag('css/video.css') ?>
<?= script_tag('js/jquery.js') ?>
<?= script_tag('js/jquery-ui.js') ?>
<?= script_tag('js/lazyload.js') ?>
<?= script_tag('js/application.js') ?>
<?= script_tag('js/tiptip.js') ?>
<?= script_tag('js/video.js') ?>
<?= script_tag('js/flowplayer/flowplayer-3.2.4.min.js') ?>
<script type="text/javascript" charset="utf-8">
  $(function() {
		var sum_length	= 400;
    
    $('img[data-src]').attr('src', '<?= base_url().'/images/blank.png' ?>');
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
  });
</script>
