function makeUploadBlock(id) {
    return '<div class="uploadBlockWrapper" id="' + id + '">'+
            '<div class="delete_bt">X</div>'+
        '<div class="uploadBlock">'+
            '<div class="content"></div>'+
            '<div class="progressbarWrapper"><div class="progressbar"></div></div>' +
        '</div>'+
        '<div class="info">'+
                '<div class="info_input"><label>Name: </label><input class="name" name="name[]" /></div>'+
                '<div class="info_input"><label>Description: </label><input class="description" name="description[]" /></div>'+
                '<div class="info_input"><label>Order: </label><input class="order"  name="order[]" /></div>'+
                '<input type="hidden" class="file" name="file[]" value="" />'+
                '<input type="hidden" class="thumb" name="thumb[]" value="" />'+
                '<input type="hidden" class="id" name="id[]" value="0" />'+
                '<input style="display:none" class="info_button save_bt" id="save_bt" type="button" value="Save" />'+
        '</div>'+
    '</div>';
}
function draw(file, id) {
    if ($('#img_tmp').length == 0) {
        $('body').append(' <canvas id="img_tmp"></canvas>');
    }
    var canvas = document.getElementById('img_tmp');
    var ctx = canvas.getContext('2d');
    var image = new Image;
    image.src = URL.createObjectURL(file);

    image.onload = function() {
        var width = canvas.width;
        var height = canvas.height;
        var iW = canvas.width;
        var iH = (image.height * canvas.width) / image.width;
        console.log(iH);
        // Draw the image to the canvas.
        ctx.drawImage(image, 0, 0, iW, iH);

        // Get the image data from the canvas, which now
        // contains the contents of the image.
        var imageData = ctx.getImageData(0, 0, width, height);

        // The actual RGBA values are stored in the data property.
        var pixelData = imageData.data;

        // 4 bytes per pixels - RGBA
        var bytesPerPixel = 4;

        // Loop through every pixel - this could be slow for huge images.
        for (var y = 0; y < height; y++) {
            for (var x = 0; x < width; x++) {
                // Get the index of the first byte of the pixel.
                var startIdx = (y * bytesPerPixel * width) + (x * bytesPerPixel);

                // Get the RGB values.
                var red = pixelData[startIdx];
                var green = pixelData[startIdx + 1];
                var blue = pixelData[startIdx + 2];

                // Convert to grayscale.  An explanation of the ratios
                // can be found here: http://en.wikipedia.org/wiki/Grayscale
                var grayScale = (red * 0.3) + (green * 0.59) + (blue * .11);

                // Set each RGB value to the same grayscale value.
                pixelData[startIdx] = grayScale;
                pixelData[startIdx + 1] = grayScale;
                pixelData[startIdx + 2] = grayScale;
            }
        }

        // Draw the converted image data back to the canvas.
        ctx.putImageData(imageData, 0, 0);
        $("#" + id + ' .content').append('<img class="image_tmp" src="' + canvas.toDataURL() + '" />');
    }

}
function uploadFile(files) {
    var cat = $('#category_id').val();
    $.each(files, function(i, f) {
        var uniqueId = (new Date()).getTime();
        var xmlhttp,
        json;
        var block = '';
        if (window.XMLHttpRequest)
            xmlhttp = new XMLHttpRequest();
        else
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.upload.onprogress = function(e) {
            $("#" + uniqueId + ' .progressbar').css('width', Math.floor(e.loaded / e.total * 100) + '%');


        }

        xmlhttp.upload.onload = function(e) {
            //$("#"+uniqueId+' .progressbar').html("Complete");
        }

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                console.log(xmlhttp.responseText);
                json = JSON.parse(xmlhttp.responseText);
                $("#" + uniqueId + ' .progressbarWrapper').fadeOut(3000);
                $("#" + uniqueId + ' .content').html('<img style="display:none" class="res res_' + uniqueId + '" src="' + json['thumb'] + '"/>');
                $("#" + uniqueId + ' .content .res').fadeIn(1000);
                $("#" + uniqueId + ' .info_button').fadeIn(500);
                $("#" + uniqueId + ' .file').val(json['filename']);
                $("#" + uniqueId + ' .thumb').val(json['thumbname']);
            }
        }
        xmlhttp.open("put", "upload?act=upload&category="+cat, true);
        xmlhttp.setRequestHeader("If-Modified-Since", "Mon, 26 Jul 1997 05:00:00 GMT");
        xmlhttp.setRequestHeader("Cache-Control", "no-cache");
        xmlhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xmlhttp.setRequestHeader("X-File-Name", f.name);
        xmlhttp.setRequestHeader("X-File-Size", f.size);
        xmlhttp.setRequestHeader("Content-Type", "multipart/form-data");
        xmlhttp.send(f);
        block = makeUploadBlock(uniqueId);
        $('#result').append(block);
        draw(f, uniqueId);
        $("#" + uniqueId + ' .save_bt').click(function(){save($("#" + uniqueId));});
        $("#" + uniqueId + ' .delete_bt').click(function(){del($("#" + uniqueId));});
    });
}

function save(block) {
    var name = $('.name',block).val();
    var des = $('.description',block).val();
    var order = $('.order',block).val();
    var image = $('.file',block).val();
    var thumb = $('.thumb',block).val();
    var id = $('.id',block).val();
    var  cat = $('#category_id').val();
    console.log('cat='+cat);
    $.ajax({
        url:'upload',
        data:{'act':'add','category':cat,'id':id,'name':name,'description':des,'order':order,'file':image,'thumb':thumb},
        type:'get',
        success:function(html){
            if(html !='-1'){
                $('.id',block).val(html);
                $(".save_bt",block).val('Update');
            }
            console.log(html);
        },
        error:function(){
    
        }
    });
}
function del(block){
    var id = $('.id',block).val();
    $.ajax({
      url:'upload',
      data:{'act':'delete','id':id},
      type:'get',
      success:function(html){
          if(html =='1'){
              $(block).fadeOut(500,function(){$(this).remove()});
          }
          console.log(html);
      },
      error:function(){

      }
  });
}
// add event
$(document).ready(function() {

    $("#file").change(function(e) {
        uploadFile(this.files);
    });

});
