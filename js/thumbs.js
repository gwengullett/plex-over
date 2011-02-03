// JavaScript Document
function ThumbnailScroller(id,tsType,tsMargin,scrollEasing,scrollEasingType,thumbnailOpacity,thumbnailFadeSpeed){
	/* 
	parameters: 
	id: id of the container (div id)  
	tsType: scroller type (values: "horizontal", "vertical")
	tsMargin: first and last thumbnail margin (for better cursor interaction) 
	scrollEasing: scroll easing amount (0 for no easing) 
	scrollEasingType: scroll easing type 
	thumbnailOpacity: thumbnails default opacity 
	thumbnailFadeSpeed: thumbnails mouseover fade speed (in milliseconds) 
	*/

	//caching vars
	var $outer_container=$("#"+id);
	var $thumbScroller=$("#"+id+" .thumbScroller");
	var $thumbScroller_container=$("#"+id+" .thumbScroller .container");
	var $thumbScroller_content=$("#"+id+" .thumbScroller .content");
	var $thumbScroller_thumb=$("#"+id+" .thumbScroller .thumb");

	if(tsType=="horizontal"){
		$thumbScroller_container.css("marginLeft",tsMargin+"px"); //add margin
		$outer_container.data("totalContent",0);
	} else {
		$thumbScroller_container.css("marginTop",tsMargin+"px"); //add margin
	}
	
	var $the_outer_container=document.getElementById(id);
	var $placement=findPos($the_outer_container);

	$thumbScroller_content.each(function (i) {
		if(tsType=="horizontal"){
			$outer_container.data("totalContent",$outer_container.data("totalContent")+$(this).outerWidth(true));
			$thumbScroller_container.css("width",$outer_container.data("totalContent"));
		} else {
			$outer_container.data("totalContent",$thumbScroller_container.height());
		}
	});

	function MouseMove(e){
		if(tsType=="horizontal"){
			if($thumbScroller_container.outerWidth()>$thumbScroller.width()){ //check if content needs scrolling
				var mouseCoords=(e.pageX - $placement[1]);
	  			var mousePercentX=mouseCoords/$outer_container.width();
	  			var destX=-(((($outer_container.data("totalContent")+(tsMargin*2))-($outer_container.width()))-$outer_container.width())*(mousePercentX));
	  			var thePosA=mouseCoords-destX;
	  			var thePosB=destX-mouseCoords;
	  			if(mouseCoords>destX){
					$thumbScroller_container.stop().animate({left: -thePosA}, scrollEasing,scrollEasingType); 
	  			} else if(mouseCoords<destX){
					$thumbScroller_container.stop().animate({left: thePosB}, scrollEasing,scrollEasingType); 
	  			}
			} else {
				$thumbScroller_container.css("left",0);
			}
		} else {
			if($thumbScroller_container.outerHeight()>$thumbScroller.height()){ //check if content needs scrolling
				var mouseCoords=(e.pageY - $placement[0]);
	  			var mousePercentY=mouseCoords/$outer_container.height();
	  			var destY=-(((($outer_container.data("totalContent")+(tsMargin*2))-($outer_container.height()))-$outer_container.height())*(mousePercentY));
	  			var thePosA=mouseCoords-destY;
	  			var thePosB=destY-mouseCoords;
	  			if(mouseCoords>destY){
					$thumbScroller_container.stop().animate({top: -thePosA}, scrollEasing,scrollEasingType); 
	  			} else if(mouseCoords<destY){
					$thumbScroller_container.stop().animate({top: thePosB}, scrollEasing,scrollEasingType); 
	  			}
			} else {
				$thumbScroller_container.css("top",0);
			}
		}
	}
	
	$thumbScroller.bind("mousemove", function(event){
		MouseMove(event);									  
	});
	
	$thumbScroller_thumb.each(function () {
		var $this=$(this);
		$this.fadeTo(thumbnailFadeSpeed, thumbnailOpacity);
	});

	$thumbScroller_thumb.hover(
		function(){ //mouse over thumbnail
			var $this=$(this);
			$this.stop().fadeTo(thumbnailFadeSpeed, 1);
		},
		function(){ //mouse out thumbnail
			var $this=$(this);
			$this.stop().fadeTo(thumbnailFadeSpeed, thumbnailOpacity);
		}
	);
	
	//function to find element Position
	function findPos(obj) {
		var curleft = curtop = 0;
		if (obj.offsetParent) {
			curleft = obj.offsetLeft
			curtop = obj.offsetTop
			while (obj = obj.offsetParent) {
				curleft += obj.offsetLeft
				curtop += obj.offsetTop
			}
		}
		return [curtop, curleft];
	}
	
	$(window).resize(function() {
		$placement=findPos($the_outer_container);
	});
}