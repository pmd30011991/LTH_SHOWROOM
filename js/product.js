$(function(){
    var CONTENT_CLASS = '#products .contents',
		PRODUCT_CLASS ='#products .contents .product'
		CONTENT_WIDTH =0,CONTENT_HEIGHT=0,ITEM_WIDTH=0,ITEM_HEIGHT=0,
		ROWS=3,COLUMNS=5;
		var getData = function(){
			//get data 
			for(i=0;i<ROWS;i++){
				for(j=0;j<COLUMNS;j++){
					$(CONTENT_CLASS).append('<div class="product"><div class="content">1</div></div>');
					console.log(i+'-'+j);
				}
			}
		}
		var render = function(){
		CONTENT_WIDTH = $(CONTENT_CLASS).innerWidth();
		CONTENT_HEIGHT = $(CONTENT_CLASS).innerHeight();
		ITEM_WIDTH = CONTENT_WIDTH/COLUMNS;
		ITEM_HEIGHT = CONTENT_HEIGHT/ROWS;
		$(PRODUCT_CLASS).outerWidth(ITEM_WIDTH,true);
		$(PRODUCT_CLASS).outerHeight(ITEM_HEIGHT,true);
		}
		$(window).bind('resize',render);
		getData();
		render();
})