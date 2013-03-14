$(function(){
		var NUMBER_ITEMS_X=7,
				ITEM_WIDTH=192,
				ITEM_HEIGHT=0,
				CLIENT_WIDTH = 0,
				CLIENT_HEIGHT = 0,
				CONTENT_WIDTH =0,
				CONTENT_HEIGHT =0,
				CLASS_CONTAINER ='#carousel .container',
				CLASS_CONTENT ='#carousel .container #content',
				CLASS_ITEMS = '.item',
				scroller=null,
				number_items=0,
				mousedown = false;
		
		//init
		scroller = new Scroller(render, {
			scrollingY: false
		});
		// Reflow handling
		var reflow = function() {
			number_items = $(CLASS_ITEMS,CLASS_CONTAINER).length,
			item_padding = 0,
			item_margin = 0;
			$(CLASS_ITEMS,CLASS_CONTAINER).each(function(){
				item_padding = parseFloat($(this).css('padding-left'))+ parseFloat($(this).css('padding-right'));
				item_margin = parseFloat($(this).css('margin-left'))+ parseFloat($(this).css('margin-right'));
			});
			CLIENT_WIDTH = $(CLASS_CONTAINER).innerWidth();
			//console.log(CLIENT_WIDTH);
			CLIENT_HEIGHT = $(CLASS_CONTAINER).innerHeight();

			//ITEM_WIDTH = CLIENT_WIDTH/NUMBER_ITEMS_X;

			ITEM_HEIGHT = CLIENT_HEIGHT;
			
			CONTENT_WIDTH = ITEM_WIDTH*number_items
			CONTENT_HEIGHT = CLIENT_HEIGHT;

			$(CLASS_CONTENT).width(CONTENT_WIDTH);
			
			//set width & height for item 
			$(CLASS_ITEMS,CLASS_CONTAINER).outerWidth(ITEM_WIDTH,true);
			$(CLASS_ITEMS,CLASS_CONTAINER).outerHeight(ITEM_HEIGHT,true);
			//console.log(ITEM_HEIGHT);
			//console.log('width='+$(CLASS_ITEMS,CLASS_CONTAINER).width());
		//	console.log('outerWidth(true)='+$(CLASS_ITEMS,CLASS_CONTAINER).outerWidth(true));
			//console.log('outerWidth='+$(CLASS_ITEMS,CLASS_CONTAINER).outerWidth());
			//console.log('innerWidth='+$(CLASS_ITEMS,CLASS_CONTAINER).innerWidth());
			//set dimention of Scroller	
			scroller.setDimensions(CLIENT_WIDTH, CLIENT_HEIGHT, CONTENT_WIDTH, CONTENT_HEIGHT);
		};
		reflow();
		//bind event
		$(CLASS_CONTAINER).bind("mousedown", function(e) {
			if (e.target.tagName.match(/input|textarea|select/i)) {
				return;
			}
			var timeStamp = e.timeStamp
			if(timeStamp === undefined){
				var d = new Date;
				timeStamp = d.getTime();
			}
			
			scroller.doTouchStart([{
				pageX: e.pageX,
				pageY: e.pageY
			}],timeStamp);

			mousedown = true;
		});

		$(document).bind("mousemove", function(e) {
			if (!mousedown) {
				return;
			}
			//console.log($('.item:active'));
			$('.item:active').focusout();
			var timeStamp = e.timeStamp
			if(timeStamp === undefined){
				var d = new Date;
				timeStamp = d.getTime();
			}
			scroller.doTouchMove([{
				pageX: e.pageX,
				pageY: e.pageY
			}], timeStamp);

			mousedown = true;
		});

		$(document).bind("mouseup", function(e) {
			if (!mousedown) {
				return;
			}
			var timeStamp = e.timeStamp
			if(timeStamp === undefined){
				var d = new Date;
				timeStamp = d.getTime();
			}
			scroller.doTouchEnd(timeStamp);

			mousedown = false;
		});

		$(CLASS_CONTAINER).bind(navigator.userAgent.indexOf("Firefox") > -1 ? "DOMMouseScroll" :  "mousewheel", function(e) {
			scroller.doMouseZoom(e.detail ? (e.detail * -120) : e.wheelDelta, e.timeStamp, e.pageX, e.pageY);
		});
		$(window).bind('resize',reflow);
		//window.addEventListener("resize", reflow, false);
	    $('img').on('dragstart', function(event) { event.preventDefault(); });
		$('.item',CLASS_CONTENT).click(function(){
			$.ajax({
				url:'admin/get_content.php',
				data:{'type':$(this).attr('data')},
				type:'post',
				dataType :'json',
				success:function(html){
					console.log(html);
				},
				error:function(){}
			});
		});
		window.addItem = function(){
			$(CLASS_CONTENT).append('<div class="item"><div class="content">add<div></div>');
			reflow();
		}
       
});