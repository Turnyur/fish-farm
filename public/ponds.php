<?php

include_once '../sys/core/init.inc.php'; 

if (!isset($_SESSION['user'])) {
	header('location:./');
}
$css_files=array('main.css','nav.css','font-awesome.min.css', 'ajax.css');
$page_title = "Efficiently Manage Your Fish Farm from Everywhere"; 
include 'assets/common/header.inc';

?>


<main id="pond-page-wrapper">
<section id="admin">
	<div id="admin-menu">
		<form action="assets/inc/process.inc.php" method="post"> 
	<input style="border-radius: 5px; border:1px solid orange;padding: 7px 17px;width: 90%;" type="text" name="pond_id" value="" placeholder="Enter Pond Id">
         <input type="submit" id="delete_pond_submit" value="Search" style="position: relative;top: -22px;padding: 5px 10px;background-color: rgba(3, 169, 244,1);color: white;">
         <input type="hidden" name="action" value="update_pond">
         </form>

		<a class="active" href=""><img src="assets/images/interface/manage.png"> View Ponds</a>
		<a id="create-pond" href=""><img src="assets/images/interface/create.png"> Create Pond</a>
		<a id="stock-pond" href=""><img src="assets/images/interface/stock.png"> Stock Pond</a>
		<a id="update-pond" href=""><img src="assets/images/interface/update.png"> Update Pond</a>
		<a id="transfer-fish" href=""><img src="assets/images/interface/transfer.png"> Transfer Fish</a>
		<!-- <a id="record-lost-fish" href=""><img src="assets/images/interface/lost.png"> Record Lost Fish</a> -->
		<a id="record-motality" href=""><img src="assets/images/interface/motality.png"> Fish Records</a>
		<a href=""><img src="assets/images/interface/delete.png"> Delete Pond</a>
    
    <a href="" id="menu-tips"><img src="assets/images/interface/feeding.png"> Tips</a>
		<span id="meta-menu"><?php   
				if(isset($_SESSION['user'])){
				echo "<p style='color:rgba(187, 88, 27,1);'>" .$_SESSION['user']['fname']." ".$_SESSION['user']['lname']."</p>".
				"<a href='assets/inc/process.inc.php?action=user_logout&token=$_SESSION[token]'>"
				."Log Out</a>";
			}else{

$string=<<<EOD
         	<a href="login.php?action=login&token=$_SESSION[token]">Login</a> | <a href="login.php?action=register&token=$_SESSION[token]">Sign Up</a>
EOD;
echo $string;
		} ?>
		</span>

	</div>


</section>

	<section id="ponds">
		
		<div class="row" >
			
		</div>

	</section>
	


</main>





<?php

include 'assets/common/footer.inc';
?>
<script>
document.querySelectorAll('a.active')[0].setAttribute('class','');
document.getElementById('tracking').setAttribute('class','active');
</script>