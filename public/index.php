<?php

include_once '../sys/core/init.inc.php'; 

$css_files=array('main.css','nav.css','font-awesome.min.css', 'ajax.css');
$page_title = "Efficiently Manage Your Fish Farm from Everywhere"; 
include 'assets/common/header.inc';

?>




<main>
	<section>
	<?php 
include 'assets/common/slideshow.inc';
?>
</section>

<section>
	
	<?php
include 'assets/common/hero_image.inc';
?>
</section>

<section>
	<div id="service_content">
		<div >
			&nbsp;
			<h1 style="font-size:30px">Real Time Control</h1>
    <p>Use Andrah to measure and track your production in real time, understand what is happening, why it is happening, as it happens.  Know if there are high mortalities, what is the behaviour of the fish, the water temperature and the feed in stock. Be immediately notified.</p>
    <!-- <button>READ MORE</button> -->
		</div>
		<div>
			<h1>The Andrah Team</h1>
		<p>All the valuable insight gained from working with leading acquaculture companies around the world, was integrated into a fresh, innovative and low cost cloud based fish management software</p>
		</div>
	</div>
</section>

<div class="cover-image">
  <div class="cover-text">
    <h3>Lets Get Started</h3>
    <p>Get up and running immediately and enjoy the benefits of Andrah in just a few minutes</p>
				<?php 
   if (!isset($_SESSION['user'])) {
	
$string=<<<EOD
<a href="login.php?action=login&token=$_SESSION[token]"> Get Started</a> 
 <a href="login.php?action=register&token=$_SESSION[token]">REGISTER</a> 
EOD;
echo $string;
}
?>

  </div>
</div>


</main>





<?php

include 'assets/common/footer.inc';
?>
<script>
document.querySelectorAll('a.active')[0].setAttribute('class','');
document.getElementById('home').setAttribute('class','active');
</script>
