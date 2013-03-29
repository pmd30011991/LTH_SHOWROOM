<!DOCTYPE HTML>
<html>
	<head>
		<script src="js/jquery-1.9.1.min.js"></script>
		<script src="js/video.min.js"></script>
		<script src="js/Animate.js"></script>
		<script src="js/Scroller.js"></script>
		<script src="js/render.js"></script>
		<script src="js/jquery.lazyload.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/video-js.css" />
	</head>
	<body>
		<div id="player"></div>
		<div id="wrapper" class="clearfix">
			<div id="header" class="">
				<p class="logo">LOGO HERE</p>
			</div><!-- End Header -->
			<div id="main">
				<div id="products">
					<div class="contents">

					</div>
					<div class="title">Landscape</div>
				</div><!-- End Products -->
			</div><!-- End Main -->
		</div><!-- End Wrapper -->
		<div id="footer">
					<div id="carousel">
					<div class="container">
						<div id="content">
						 <?php 
								require_once('admin/core/class/Category.php');
								$cat = new Category();
								$data = $cat->getAll();
								foreach($data as $d)
								{
									echo '<div class="item" data="'.$d['name'].'"><div class="content">';
									echo '<img class="lazy" align="middle" src="abc"/>';
									echo '</div><div class="title">'.$d['name'].'</div></div>';
								}
								/*$products_folder = "products";
								$directory = dirname(__FILE__)."/".$products_folder;
								 $url = parse_url('http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']);
								 $host = $url['host'];
								 $path = isset($url['path'])?$url['path']:'';
								 $products_url = 'http://'.$host.$path.$products_folder.'/';
								//get all files in specified directory
								$dir_handle = opendir($directory);
								
								//$dirs = readdir($directory);
								 
								while (false !== ($entry = readdir($dir_handle))) {
										if ($entry != "." && $entry != ".." && $entry != ".htaccess") {
												$thumb_dir = $directory.'/'.$entry.'/thumb';
												$thumb_handle = opendir($thumb_dir);
													while (false !== ($thumb = readdir($thumb_handle))) {
														if ($thumb != "." && $thumb != "..") {
															$thumb_img =  $products_url.$entry.'/thumb/'.$thumb;
															echo '<div class="item" data="'.$entry.'"><div class="content">';
															echo '<img class="lazy" align="middle" src="'.$thumb_img.'"/>';
															echo '</div><div class="title">'.$entry.'</div></div>';
														}
													}
												//echo '<a class="project-item" href="'.$products_url.$entry.'"><span><img src="'.$products_url.$entry.'/logo.png" alt="" /></span><span style="display:none">'.$entry.'</span></a>';
										 }
								 }
								 closedir($dir_handle);*/
								 
						?>
						</div>
					</div>
				</div><!-- End Carousel -->
				<div class="copyright">Copyright 2012</div>
		</div><!-- End footer -->
		<script src="js/main.js"></script>
		<script src="js/product.js"></script>
	</body>
</html>