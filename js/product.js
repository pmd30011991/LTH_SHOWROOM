$(function(){
    var CONTENT_CLASS = '#products .contents',
        TITLE_CLASS = '#products .title',
		PRODUCT_CLASS ='#products .contents .product'
		CONTENT_WIDTH =0,
		CONTENT_HEIGHT=0,
		ITEM_WIDTH=0,
		ITEM_HEIGHT=0,
		ITEM_MAX_WIDTH=16*16,
		ITEM_MAX_HEIGHT=9*16,
		ROWS=3,COLUMNS=5,
		RATIO = 16/9,
		DATA_TYPE='',
		PAGE=0,
		totalHeight=0,
		product_number=0,
		data_count=0,
		data_rows_number=0;
        // Init
       	CONTENT_WIDTH = $(CONTENT_CLASS).innerWidth();
		CONTENT_HEIGHT = $(CONTENT_CLASS).innerHeight();
        ITEM_WIDTH = CONTENT_WIDTH/COLUMNS;
        ITEM_HEIGHT = ITEM_WIDTH/RATIO;
var getData = function(params){
			console.log(params);
			var type = params.type;
			var page = params.page || 0;
			//get data
			if(type!= undefined)
				DATA_TYPE = type;
			else
				type = DATA_TYPE;
			if(type!='' && type!=undefined){
            totalHeight = Math.ceil($(PRODUCT_CLASS).length/5)*ITEM_HEIGHT;
            product_number = $(PRODUCT_CLASS).length;
			while(true){
			 if(data_count%COLUMNS==0)
                totalHeight += ITEM_HEIGHT;
            if(totalHeight < CONTENT_HEIGHT){
					$(CONTENT_CLASS).append('<div class="product" style="display:none"><div class="content"></div></div>');
                    data_count++;
            } else {
               // console.log('break');
                break;
            }
		  }
			$.ajax({
				url:'admin/getContent',
				data:{'category':type,'page':page,'limit':data_count},
				type:'post',
				dataType :'json',
				success:function(json){
					DATA_TYPE = type;
					PAGE = page;
					var data = json.data;
					data_rows_number = json.size;
					var pages = Math.ceil(data_rows_number/data_count);
					if(PAGE < pages) {
					$(PRODUCT_CLASS).hide();
					$.each(data,function(i,e){
						$($(PRODUCT_CLASS).get(i)).fadeIn(300);
						if(e.type=='image')
							$($(PRODUCT_CLASS).get(i)).find('.content').html('<img class="lazy" src="'+e.thumb+'" />');
						else {
     	                 // var content = '<div class="play-overlay">Play</div><object width="100%" height="100%"> <param name="movie" value="js/player.swf"></param><param name="flashvars" value="src=../'+e.thumb+'"></param><param name="allowscriptaccess" value="always"></param><embed src="js/player.swf" type="application/x-shockwave-flash" allowscriptaccess="always"  width="600" height="409" flashvars="src=../'+e.thumb+'"></embed></object>';
						//var content = '<div class="play-overlay">Play</div><object width="100%" height="100%"> <param name="movie" value="js/player.swf"></param><param name="flashvars" value="src=../'+e.thumb+'&controlBarMode=floating&poster="></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="js/player.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="600" height="409" flashvars="src=../'+e.thumb+'&controlBarMode=floating&poster="></embed></object>';
						var content  = '<video preload="metadata"><source src="'+e.thumb+'" type="video/mp4"></source></video>';
						$($(PRODUCT_CLASS).get(i)).find('.content').html(content);
						}
						});
                    	$(TITLE_CLASS).html(json.category);
						if(pages > 1) {
							$('#pagging ul').html('');
							for(i = 0;i < pages ; i++) {
								var actived = '';
								if(page == i)
									actived = 'active';
									
								var elem = $('<li class="p-item '+actived+'" value="'+i+'"><div></div></li>');
								$('#pagging ul').append(elem);
								elem.unbind('click');
								elem.bind('click',changePage);
								
							}
							$('#pagging').fadeIn(300);
						} else {
							$('#pagging').fadeOut(300);
						}
					} else {
						PAGE = pages-1;	
					}
				},
				error:function(){}
			});
		}
}
var changePage = function() {
	getData({
		type: DATA_TYPE,
		page: $(this).val()
	});
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
var render = function(type){
		var page  = $('#pagging ul li.active').val();
		CONTENT_WIDTH = $(CONTENT_CLASS).innerWidth();
		CONTENT_HEIGHT = $(CONTENT_CLASS).innerHeight()+parseFloat($(CONTENT_CLASS).css('margin-bottom'));
		ITEM_WIDTH = CONTENT_WIDTH/COLUMNS;
		//ITEM_HEIGHT = CONTENT_HEIGHT/ROWS;
        ITEM_HEIGHT = ITEM_WIDTH/RATIO;
        getData({
				type:type,
				page: page
			});
		$(PRODUCT_CLASS).outerWidth(ITEM_WIDTH-1,true);
		$(PRODUCT_CLASS).outerHeight(ITEM_HEIGHT-1,true);
        $(PRODUCT_CLASS).css({'max-width':ITEM_MAX_WIDTH,'max-height':ITEM_MAX_HEIGHT});
        removeData();
     // console.log('data_count='+data_count);
     // console.log('data_rows_number='+data_rows_number);
     // console.log('product_number_loaded='+product_number_loaded);
		 $('#carousel .container #content .item').unbind('click');
		 $('#carousel .container #content .item').bind('click',function(){
				data_count = 0;
				$(PRODUCT_CLASS).remove();
				render($(this).attr('data'));
				var img_tmp = $('<img style="display:none" id="img_tmp" src="'+$('img',this).attr('src')+'" />');
				if($('#img_tmp').length == 0 )
					$('body').append(img_tmp);
				else
					$('#img_tmp').attr('src',$('img',this).attr('src'));
						
						boxBlurImage('img_tmp', 'blur', 20, 1 );
			});
		}
		$(window).bind('resize',function(e){
			if(this.resizeTO) clearTimeout(this.resizeTO);
			this.resizeTO = setTimeout(function() {
				render();
			}, 500);
		});
		render();
	$('.controls.next').click(function(){
	  getData({
				type:DATA_TYPE,
				page: PAGE+1
		});
	});	
	$('.controls.prev').click(function(){
	  getData({
				type:DATA_TYPE,
				page: PAGE-1
		});
	});
});