<?php

include_once '../sys/core/init.inc.php'; 

$css_files=array('main.css','nav.css','font-awesome.min.css', 'ajax.css');
$page_title = "Efficiently Manage Your Fish Farm from Everywhere"; 
include 'assets/common/header.inc';

?>


<main id="pond-page-wrapper">
<section id="admin">
	<div id="admin-menu">
		<a class="active" href="" id="menu-tips"><img src="assets/images/interface/manage.png"> Tips</a>
		
		

	</div>


</section>

	<section id="fish-tips">
		
		<div class="row" >
			<p style="margin-top:30px;margin-left:30px;padding:20px auto;color:rgba(3, 169, 244,1);">
<?php echo $_SESSION['user']['name'] ?>, please select content from menu.  </p>
		</div>

	</section>
	


</main>





<?php

include 'assets/common/footer.inc';
?>

<script>
document.querySelectorAll('a.active')[0].setAttribute('class','');
document.getElementById('delivery').setAttribute('class','active');

</script>