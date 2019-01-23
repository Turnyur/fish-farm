<!Doctype html>

<head>     
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />    
	<title><?php echo $page_title; ?></title> 
	<?php foreach ( $css_files as $css ): ?>     
	<link rel="stylesheet" type="text/css" media="screen,projection" 
	href="assets/css/<?php echo $css; ?>" />  <?php endforeach ?>

</head> 	


<body> 

	<div id="container">



		<header>
			<div id="branding">
			
				<figure>
					<a id="home" class="active" href="index.php"><img src="assets/images/interface/fish_farm_logo-1.png" alt="site_logo" /></a> 
					<!-- <span class="logo" style="color:rgba(13, 25, 29,1);">FX</span><span class="logo" style="color:#6d0019;">Tracking</span> -->
					

				</figure>

				<!-- <h3> Ultra Modern Fish Farming Software </h3>  -->
			</div>


<?php   
				if(isset($_SESSION['user'])){
$string=<<<EOD
			<div class="icon-bar" id="icon-bar"> <!-- This can be called navbar or primary navbar normally. -->
				<div class="icon-bar-wrapper">
					

				<a id="home" class="active" href="index.php"><img src="assets/images/interface/dashboard.png"> HOME</a> 
				<!-- <a id="tracking" href="ponds.php"><img src="assets/images/interface/pond.png"> DASHBOARD</a> --> 
				<!--  Dropdown Menu Button -->
				<!-- <a id="delivery" href="feeding.php"><img src="assets/images/interface/feeding.png"> FEEDING</a>	-->			
				<a id="gallery" href="records.php" class="active" style="display: none;"><img src="assets/images/interface/records.png"> RECORDS</a> 
				<!-- <a id="contact-us" href="contact-us.php">CONTACT</a>  -->
				<a href="#" style="font-size:15px;" class="icon">&#9776;</a>

				</div>

			</div>
EOD;
echo $string;
}else{


       
} ?>


	</header>
		<div class="login-status">
			
	</div>

