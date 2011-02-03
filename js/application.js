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

	// --------------------------------------------------------------------
	// Redimentionnement
	// --------------------------------------------------------------------
	$.fn.fullBg = function resizeVid(options)
	{
		var vidRatio, opts, container = $(this).eq(0);
		
		if (!options) options = {};
		
		if (vidW = container.attr('width')) options.width = vidW;
		if (vidH = container.attr('height')) options.height = vidH;
				
		opts = $.extend({}, $.fn.fullBg.defaults, options);
	    
	    if (! vidRatio) vidRatio = (opts.width / opts.height).toFixed(2);

		var dims = resize();
		
		$(window).resize(function(){resize()});
		
		// calcule les dimensions de la vidéo
		// --------------------------------------------------------------------
		function resize()
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
	// --------------------------------------------------------------------
	$.fn.fullBg.defaults = {
		width  : 480,
		height : 270,
		container: 'document'
	};


	$.fn.serializeObject = function()
	{
	    var o = {};
	    var a = this.serializeArray();
	    $.each(a, function() {
	        if (o[this.name]) {
	            if (!o[this.name].push) {
	                o[this.name] = [o[this.name]];
	            }
	            o[this.name].push(this.value || '');
	        } else {
	            o[this.name] = this.value || '';
	        }
	    });
	    return o;
	};
	
	
	$.fn.audioPlaylist = function(options)
	{
		var defOpts = {
			key		: 'audioPlaylist'
		}
		opts = $.extend({}, defOpts, options);
		
		$(this).click(function(){
			
			var keyt = $.trim($(this).text());
			
			var attrs = { 
				title : keyt,
				album	: $(this).attr('rel'),
				url		: $(this).attr('href'),
				artist: $(this).attr('art')
			};
				//var currentStorage = $.parseJSON(sessionStorage.getItem(opts.key));
				//currentStorage[keyt] = 'test';
				//var toStore = JSON.stringify(attrs);
				sessionStorage.setItem(opts.key, $(attrs).serializeArray());
				//console.log(JSON.parse(sessionStorage.getItem(opts.key)));
		});
	}

})(jQuery);