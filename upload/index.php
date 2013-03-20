<script src="jquery-1.9.1.min.js"></script> <style>	.uploadBlock {		width: 200px;		height: 100px;		border: 1px solid #ccc;		position: relative;		padding: 5px;		float: left;		display: inline-block;		margin: 5px;	}	.uploadBlock .content {		width:100%;		height:100%;		position:relative;		overflow: hidden;	}	.uploadBlock .content img {		width:100%;	}	.progressbarWrapper {		height: 4%;		position: absolute;		overflow: hidden;		border-radius: 5px;		padding: 2px;		bottom: 10px;		background: rgb(255, 255, 255);		opacity: 0.7;		left: 10px;		right: 10px;			}	.progressbar {		background: rgb(28, 158, 245);		text-align: center;		height: 100%;		color: white;		border-radius: 3px;	}	 </style>	 <form>        <input type="file" multiple id="file" name="file" /><label for="file"></label>        <button id="sub">Cancel</button> </form><div id="result"></div>    <script>	function makeUploadBlock(id){		return '<div class="uploadBlock" id="'+id+'">'+			'<div class="content"></div>'+			'<div class="progressbarWrapper"><div class="progressbar"></div></div>'+		'</div>';	}    function uploadFile(files) {	$.each(files,function(i,f){		var uniqueId = (new Date()).getTime();        var xmlhttp;		var block='';        if(window.XMLHttpRequest)            xmlhttp = new XMLHttpRequest();        else            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");        xmlhttp.upload.onprogress = function(e) {            //$("#aaa").empty().append(e.loaded + " - " + e.total);            $("#"+uniqueId+' .progressbar').css('width',Math.floor(e.loaded/e.total*100)+'%');            			        }        xmlhttp.upload.onload = function(e) {            //$("#"+uniqueId+' .progressbar').html("Complete");        }        xmlhttp.onreadystatechange = function() {            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {               // alert(xmlhttp.responseText);				//$("#"+uniqueId+' .progressbar').fadeOut(2000);				$("#"+uniqueId+' .content').html(xmlhttp.responseText);            }        }			xmlhttp.open("put", "get_progress.php", true);			xmlhttp.setRequestHeader("If-Modified-Since", "Mon, 26 Jul 1997 05:00:00 GMT");			xmlhttp.setRequestHeader("Cache-Control", "no-cache");			xmlhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");			xmlhttp.setRequestHeader("X-File-Name", f.name);			xmlhttp.setRequestHeader("X-File-Size", f.size);			xmlhttp.setRequestHeader("Content-Type", "multipart/form-data");			xmlhttp.send(f);			block = makeUploadBlock(uniqueId);			$('#result').append(block);		});    }    $(document).ready(function() {        $("#file").change(function() {			console.log(this.files);            uploadFile(this.files);        });    });    </script>