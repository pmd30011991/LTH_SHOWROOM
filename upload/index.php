<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script> <form>        <input type="file" id="file" name="file" /><label for="file"></label><label id="aaa"></label>        <button id="sub">abc</button>    </form>    <script src="js/jquery-1.7.1.min.js"></script>    <script>    function uploadFile(files) {        var xmlhttp;        if(window.XMLHttpRequest)            xmlhttp = new XMLHttpRequest();        else            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");        xmlhttp.upload.onprogress = function(e) {            $("#aaa").empty().append(e.loaded + " - " + e.total);        }        xmlhttp.upload.onload = function(e) {            $("#aaa").empty().append("finish");        }        xmlhttp.onreadystatechange = function() {            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {                alert(xmlhttp.responseText);            }        }        xmlhttp.open("post", "get_progress.php", true);        xmlhttp.setRequestHeader("If-Modified-Since", "Mon, 26 Jul 1997 05:00:00 GMT");        xmlhttp.setRequestHeader("Cache-Control", "no-cache");        xmlhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");        xmlhttp.setRequestHeader("X-File-Name", files[0].fileName);        xmlhttp.setRequestHeader("X-File-Size", files[0].fileSize);        xmlhttp.setRequestHeader("Content-Type", "multipart/form-data");        xmlhttp.send(files[0]);    }    $(document).ready(function() {        $("#file").change(function() {            uploadFile(this.files);        });    });    </script>