<html>
<head>
<script src="jquery-1.9.1.min.js"></script>
 <style>
	.uploadBlock {
		width: 200px;
		height: 100px;
		border: 1px solid #ccc;
		position: relative;
		padding: 5px;
		float: left;
		display: inline-block;
		margin: 5px;
	}
	.uploadBlock .content {
		width:100%;
		height:100%;
		position:relative;
		overflow: hidden;
	}
	.uploadBlock .content img {
		width:100%;
	}
	.progressbarWrapper {
		height: 4%;
		position: absolute;
		overflow: hidden;
		border-radius: 5px;
		padding: 2px;
		bottom: 10px;
		background: #ccc;
		opacity: 0.7;
		left: 10px;
		right: 10px;
		
	}
	.progressbar {
		background: rgb(28, 158, 245);
		text-align: center;
		height: 100%;
		color: white;
		border-radius: 3px;
	}
	.imageCanvas {
		position: absolute;
		top: 0px;
		left: 0;
		width: 100%;
		height: 100%;
		
	}
    #img_tmp {
        display:none;
    }
	.image_tmp {
	   
       
	}
 </style>
 </head>
 <body>
 <canvas id="img_tmp"></canvas>	
 <form>
        <input type="file" multiple id="file" name="file" /><label for="file"></label>
        <button id="sub">Cancel</button>
 </form>

<div id="result">
</div>
    <script>
	function makeUploadBlock(id){
		return '<div class="uploadBlock" id="'+id+'">'+
			'<div class="content"></div>'+
			'<div class="progressbarWrapper"><div class="progressbar"></div></div>'+
		'</div>';
	}
	function draw(file,id) {
       if($('#img_tmp').length == 0) {
            $('body').append(' <canvas id="img_tmp"></canvas>');
       }
		var canvas = document.getElementById('img_tmp');
		var ctx = canvas.getContext('2d');
		var image = new Image;
		image.src = URL.createObjectURL(file);
        
		image.onload = function() {
			var width = canvas.width;
		   var height = canvas.height;
			var iW =    canvas.width;
			var iH = (image.height*canvas.width)/image.width;
            console.log(iH);
			   // Draw the image to the canvas.
			   ctx.drawImage(image,0,0,iW,iH);

			   // Get the image data from the canvas, which now
			   // contains the contents of the image.
			   var imageData = ctx.getImageData(0, 0, width, height);

			   // The actual RGBA values are stored in the data property.
			   var pixelData = imageData.data;

			   // 4 bytes per pixels - RGBA
			   var bytesPerPixel = 4;

			   // Loop through every pixel - this could be slow for huge images.
			   for(var y = 0; y < height; y++) {
			      for(var x = 0; x < width; x++) {
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
               $("#"+id+' .content').append('<img class="image_tmp" src="'+canvas.toDataURL()+'" />');
		}
        
	}
    function uploadFile(files) {
	$.each(files,function(i,f){
		var uniqueId = (new Date()).getTime();
        var xmlhttp;
		var block='';
        if(window.XMLHttpRequest)
            xmlhttp = new XMLHttpRequest();
        else
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.upload.onprogress = function(e) {
            $("#"+uniqueId+' .progressbar').css('width',Math.floor(e.loaded/e.total*100)+'%');
            
			
        }

        xmlhttp.upload.onload = function(e) {
            //$("#"+uniqueId+' .progressbar').html("Complete");
        }

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                alert(xmlhttp.responseText);
				$("#"+uniqueId+' .progressbarWrapper').fadeOut(3000);
                $("#"+uniqueId+' .content').html('<img class="res_'+uniqueId+'" src="'+xmlhttp.responseText+'"/>');
                $("#"+uniqueId+' .image_tmp').remove();
            }
        }
			xmlhttp.open("put", "get_progress.php", true);
			xmlhttp.setRequestHeader("If-Modified-Since", "Mon, 26 Jul 1997 05:00:00 GMT");
			xmlhttp.setRequestHeader("Cache-Control", "no-cache");
			xmlhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
			xmlhttp.setRequestHeader("X-File-Name", f.name);
			xmlhttp.setRequestHeader("X-File-Size", f.size);
			xmlhttp.setRequestHeader("Content-Type", "multipart/form-data");
			xmlhttp.send(f);
			block = makeUploadBlock(uniqueId);
			$('#result').append(block);
            draw(f,uniqueId);
		});
    }

    $(document).ready(function() {

        $("#file").change(function(e) {
            uploadFile(this.files);
        });

    });

    </script>
</body>
</html>