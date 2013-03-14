$(function(){
    var CONTENT_CLASS = '#products .contents',
		PRODUCT_CLASS ='#products .contents .product'
		CONTENT_WIDTH =0,
        CONTENT_HEIGHT=0,
        ITEM_WIDTH=0,
        ITEM_HEIGHT=0,
        ITEM_MAX_WIDTH=16*16,
        ITEM_MAX_HEIGHT=9*16,
		ROWS=3,COLUMNS=5,
        RATIO = 16/9,
        totalHeight=0,
        product_number=0,
        data_count=0,
        data_rows_number=31;
        // Init
       	CONTENT_WIDTH = $(CONTENT_CLASS).innerWidth();
		CONTENT_HEIGHT = $(CONTENT_CLASS).innerHeight();
        ITEM_WIDTH = CONTENT_WIDTH/COLUMNS;
        ITEM_HEIGHT = ITEM_WIDTH/RATIO;
        
		var getData = function(){
			//get data
            totalHeight = Math.ceil($(PRODUCT_CLASS).length/5)*ITEM_HEIGHT;
            product_number = $(PRODUCT_CLASS).length;
			while(data_count<data_rows_number){
			 if(data_count%COLUMNS==0)
                totalHeight += ITEM_HEIGHT;
            if(totalHeight < CONTENT_HEIGHT){
					$(CONTENT_CLASS).append('<div class="product"><div class="content">1</div></div>');
                    data_count++;
            } else {
                console.log('break');
                break;
            }
		  }
        }
        var removeData = function(){
            totalHeight = Math.ceil($(PRODUCT_CLASS).length/5)*ITEM_HEIGHT;
            product_number = $(PRODUCT_CLASS).length;
			while(totalHeight > CONTENT_HEIGHT){
		      var arr_items_reverse = $(PRODUCT_CLASS).get().reverse();
              r = arr_items_reverse.splice(0,1);
              $(r).remove();
              data_count--;
              totalHeight = Math.ceil($(PRODUCT_CLASS).length/5)*ITEM_HEIGHT;

			}
        }
		var render = function(){
		CONTENT_WIDTH = $(CONTENT_CLASS).innerWidth();
		CONTENT_HEIGHT = $(CONTENT_CLASS).innerHeight();
		ITEM_WIDTH = CONTENT_WIDTH/COLUMNS;
		//ITEM_HEIGHT = CONTENT_HEIGHT/ROWS;
        ITEM_HEIGHT = ITEM_WIDTH/RATIO;
        getData();
		$(PRODUCT_CLASS).outerWidth(ITEM_WIDTH-1,true);
		$(PRODUCT_CLASS).outerHeight(ITEM_HEIGHT-1,true);
        $(PRODUCT_CLASS).css({'max-width':ITEM_MAX_WIDTH,'max-height':ITEM_MAX_HEIGHT});
        removeData();
                            console.log(data_count);
		}
		$(window).bind('resize',render);
		render();
})