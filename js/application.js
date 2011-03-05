// make the search case unsensitive
jQuery.expr[':'].contains = function(a, i, m) { 
  return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0; 
};

// search plugin
(function($) {

  var Search = function(block) {
    this.callbacks = {};
    block(this);
  }

  Search.prototype.all = function(fn) { this.callbacks.all = fn; }
  Search.prototype.reset = function(fn) { this.callbacks.reset = fn; }
  Search.prototype.empty = function(fn) { this.callbacks.empty = fn; }
  Search.prototype.results = function(fn) { this.callbacks.results = fn; }

  function query(selector) {
    if (val = this.val()) {
      return $(selector + ':contains("' + val + '")');
    } else {
      return false;
    }
  }
  
  $.fn.search = function search(selector, block) {
    var search = new Search(block);
    var callbacks = search.callbacks;

    function perform() {
      if (result = query.call($(this), selector)) {
        callbacks.all && callbacks.all.call(this, result);
        var method = result.size() > 0 ? 'results' : 'empty';
        return callbacks[method] && callbacks[method].call(this, result);
      } else {
        callbacks.all && callbacks.all.call(this, $(selector));
        return callbacks.reset && callbacks.reset.call(this);
      };
    }

    $(this).live('keypress', perform);
    $(this).live('keydown', perform);
    $(this).live('keyup', perform);
    $(this).bind('blur', perform);
    $(this).bind('click', perform); // html 5 type="seach" support
  }	
	
})(jQuery);

// --------------------------------------------------------------------
// Redimentionnement
// --------------------------------------------------------------------
(function($) {
	$.fn.fullBg = function(options)
	{
		var vidRatio, opts, container = $(this);
		
		if (!options) options = {};
		
		if (vidW = container.attr('width')) options.width = vidW;
		if (vidH = container.attr('height')) options.height = vidH;
				
		opts = $.extend({}, $.fn.fullBg.defaults, options);
	    
		if (! vidRatio) vidRatio = (opts.width / opts.height).toFixed(2);

		var dims = resizeBg();
		
		$(window).resize(function(){resizeBg()});
		
		// calcule les dimensions de la vidéo
		function resizeBg()
		{
			var wHeight = $(opts.container).height();
			var wWidth 	= $(opts.container).width();
			var wRatio	= wWidth / wHeight;
			
			if (wRatio >= vidRatio) ratio = wWidth / opts.width;
			else  ratio = wHeight / opts.height;
			
			var output = {};
			output.width   = Math.round(ratio * opts.width, 2); 
			output.height  = Math.round(ratio * opts.height, 2);
			container.attr('width', output.width).attr('height', output.height);
			
			return output;
		}
	}
	// Parametres par defaut
	$.fn.fullBg.defaults = {
		width  : 480,
		height : 270,
		container: 'document'
	};
})(jQuery);


// --------------------------------------------------------------------
// Gallery
// --------------------------------------------------------------------
(function($) {
$.fn.gallery = function (options) {
	var defaults = {
			origin			: '.item a',
			transition	: 'fade',
			resizeFrom	: '#plugin-directory',
			storyDiv		: '#listinfo-summary',
			storyButton	: '.story-button',
			resizeBottom: 110,
			fadeSpeed		: 200,
			activeClass	: 'selected',
			easingSpeed	: 800
		};
	var opts 			= $.extend({}, defaults, options);
	var container	= $(this);
	
	// resize at launch
	resize_media(opts.resizeFrom, opts.resizeBottom);
	
	$(opts.origin).live('click', function(){
		if (! $(this).hasClass(opts.activeClass))
		{
			var story = $(this).next('div').html();
			$('.'+opts.activeClass).removeClass(opts.activeClass);
			if (container.attr('id') != 'flash-media')
			{
				container.stop().fadeTo(0, 0.5);
			}
			container.attr('src', $(this).attr('href'));
			container.load(function(){
				$(this).stop().fadeTo(150, 1);
			});
			$(this).addClass(opts.activeClass);
			$(opts.storyDiv).find('div').html(story);
		}
		return false;
	});
	// resize on window
	$(window).resize(function(){
		resize_media(opts.resizeFrom, opts.resizeBottom);
	});
	
	$(opts.storyButton).toggle(function(){
		$(this).next('div').slideDown();
	}, function(){
		$(this).next('div').slideUp();
	});

}
})(jQuery);

// --------------------------------------------------------------------
// Thumbnail viewer
// --------------------------------------------------------------------
(function($) {
	$.fn.thumbViewer = function (options) {
		var incr = 0, totalWidth = 0;
		var defaults = {
			scroller					: '.thumbScroller',
			scrollerContainer	: '.thumbScroller .container',
			scrollerContent		: '.thumbScroller .content',
			prev							: '#tshf_container .prev',
			next							: '#tshf_container .next',
			margin						: 5,
			opacity						: 0.7,
			fadeSpeed					: 200,
			easingSpeed				: 800,
			easing						: 'linear'
		};
		var container	= $(this);
		var opts 			= $.extend({}, defaults, options);
		// assign margin-left
		$(opts.scrollerContainer).css("marginLeft", opts.margin+"px");
		$(opts.scrollerContent).fadeTo(opts.fadeSpeed, opts.opacity);
		// hide next / prev links
		$(opts.prev+','+opts.next).fadeTo(opts.fadeSpeed, 0);

		// assign width
		$(opts.scrollerContent).each(function(i){totalWidth += $(this).outerWidth(true)});
		$(opts.scrollerContainer).css("width", totalWidth);

		// calculate distance to scroll
		function scroll_to() {
			nbToScroll = Math.floor($(container).outerWidth() / $(opts.scrollerContent).outerWidth());
			toScroll = ($(opts.scrollerContent).outerWidth() * nbToScroll);
			return toScroll;
		}
		
		// navigation next
		function nextN(e) {
			if ((incr + e) <= $(opts.scrollerContainer).outerWidth()) {
				incr += scroll_to();
				$(opts.scrollerContainer).stop().animate({left: -incr}, opts.easingSpeed);
			}
		}
		// navigation prev
		function prevN(e) {
			if ((incr - e) >= 0) incr -= scroll_to();
			else incr = 0;
			$(opts.scrollerContainer).stop().animate({left: -incr}, opts.easingSpeed);
		}
		
		// binding functions
		$(container).hover(
			function(){
				$(opts.prev+','+opts.next).stop().fadeTo(opts.fadeSpeed, 0.7);
			},
			function(){
				$(opts.prev+','+opts.next).stop().fadeTo(opts.fadeSpeed, 0);
			}
		);
		$(opts.scrollerContent).hover(
			function(){
				$(this).stop().fadeTo(opts.fadeSpeed, 1);
			},
			function(){
				$(this).stop().fadeTo(opts.fadeSpeed, opts.opacity);
			}
		);
		// click prev
		$(opts.prev).click(function(event){
			prevN($(opts.scroller).width());
		});
		
		// click next
		$(opts.next).click(function(event){
			nextN($(opts.scroller).width());									  
		});		
	}
})(jQuery);

function resize_media(container, distance) {
		var totH = $(container).height();
		$('#listinfo-media').css('height', (totH - distance)+'px');
}

// --------------------------------------------------------------------
// Custom select
// --------------------------------------------------------------------
(function($){
 $.fn.extend({
 
 	customStyle : function(options) {
	  return this.each(function() {
	  
			var currentSelected = $(this).find(':selected');
			$(this).after('<span class="customStyleSelectBox rounded-st"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', left: '0', opacity:0,fontSize:$(this).next().css('font-size')});
			var selectBoxSpan = $(this).next();
			var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));			
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			$(this).height(selectBoxHeight).change(function(){
				// selectBoxSpanInner.text($(this).val()).parent().addClass('changed');   This was not ideal
			selectBoxSpanInner.text($(this).find(':selected').text()).parent().addClass('changed');
				// Thanks to Juarez Filho & PaddyMurphy
			});
			
	  });
	}
 });
})(jQuery);

// --------------------------------------------------------------------
// DOM ready plugins and stuff configurations
// --------------------------------------------------------------------
$(function(){
	// hide search bar
	if ($('.item').length == 0) $('#search').hide();
	// tooltips
	var defTipPos = ($('.tip').eq(0).parent('td').length > 0) ? 'left' : 'top';
	$('.tip').tipTip({
		delay:0,
		defaultPosition: defTipPos,
		maxWidth:400
	});
	
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
  	});
		
  	on.results(function(results) {
  	  $('#none').hide();
		  $('.item').hide();
  	  results.show();
		});
	});

	// summary read more
	$('#summary .button').click(function(){$('#summary span').slideToggle(600)});
	// select
	$('select#top_nav').customStyle();
	
});