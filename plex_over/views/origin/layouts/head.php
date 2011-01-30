<!DOCTYPE >
<html>
	<head>
		<title><?= $title ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="<?=site_url('css/styles.css')?>" type="text/css">
		<link rel="stylesheet" href="<?=site_url('css/tiptip.css')?>" type="text/css">
		<link rel="stylesheet" href="<?=site_url('css/colorbox.css')?>" type="text/css">
		<script type="text/javascript" src="<?=site_url('js/jquery.js')?>"></script>
		<script type="text/javascript" src="<?=site_url('js/jquery-ui.js')?>"></script>
		<script type="text/javascript" src="<?=site_url('js/lazyload.js')?>"></script>
		<script type="text/javascript" src="<?=site_url('js/application.js')?>"></script>
		<script type="text/javascript" src="<?=site_url('js/tiptip.js')?>"></script>
		<script type="text/javascript" src="<?=site_url('js/colorbox.js')?>"></script>
		<script type="text/javascript" charset="utf-8">
  		$(function() {
  			var sum_length = 400;
  		  var grid = null,hsort_flg = false;         
  		  	$("img[original]").lazyload({
  		  		placeholder : '<?=site_url('css/images/grey.gif')?>',
  		  		effect: 'fadeIn',
  		  		effectspeed: 200
  		  	});
  		 /*
			  if ($(".grid").length > 0) {
			  	var grid = $(".grid").vgrid({
			  		easeing: "easeOutExpo",
			  		time: 500,
			  		delay: 0
			  	});
			  }
				*/		
			  // tooltip (show title attr content)
			  $('.tip').tipTip({maxWidth: 400, delay : 1000, fadeOut:0, defaultPosition: 'top'});
			  
			  if ($('.summary').text().length > sum_length)
			  {
			  	$('#sum-hide').html($('.summary').html());
			  	to_append = '... <br /><br /><a class="cb button dark-gradient rounded-st"> &#10145; <?= lang('read_more') ?></a>';
			  	$('#details-text .summary').html(function(i, t) { return t.substr(0, sum_length); }).append(to_append);
			  	//alert($('.summary').text().length);
			  }
			  $('.cb').colorbox({
			  	inline: true,
			  	href: '#sum-hide',
			  	width: '500px',
			  	opacity: 0.5
			  });
			  
			  $('input[name="search"]').search('div.item', function(on) {
  		  on.all(function(results) {
  		    var size = results ? results.size() : 0
  		    $(this).next('span').find('a').text(size);
  		  });
			
  		  on.reset(function() {
  		    $('#none').hide();
  		    $('div.item').show();
  		  });
			
  		  on.empty(function() {
  		    $('#none').show();
			  	$('div.item').hide();
			  	//grid.vgrefresh();
  		  });
			
  		  on.results(function(results) {
  		    $('#none').hide();
			  	//grid.vgrefresh();
			  	$('div.item').hide();
  		    results.show();
  		  });
  		});
  		
  		function sort()
  		{
  			hsort_flg = !hsort_flg;
			  $("#browser").vgsort(function(a, b){
			  	var _a = $(b).css('display');
			  	var _b = $(a).css('display');
			  	var _c = hsort_flg ? 1 : -1 ;
			  	return (_a > _b) ? _c * -1 : _c ;
			  }, "easeInOutExpo", 300, 0);
			  return false;
  		}
  	});
	</script>
	</head>
	
	<body>