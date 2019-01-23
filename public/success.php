
<?php 

/*  * Include necessary files  */ 
include_once '../sys/core/init.inc.php'; 

/*  * Output the header  */ 
$page_title = "Thanks For Form Submission"; 
$css_files = array('main.css', 'nav.css', 'font-awesome.min.css'); 
include_once 'assets/common/header.inc'; 
?>

<?php
$username=str_split($_GET['user']);
$replace=$username[0];
$conv_username=strtoupper($username[0]);
foreach ($username as $value) {
if ($replace!==$value) {
	$conv_username.=$value;
}
	
}
	

if($_GET['action']=='reg-success' && ($_SESSION['token']==$_GET['token'])){
		
$string=<<<EOD
<div id="login-content"> 
	<p style="padding:20px 40px;;background-color:rgba(0,200,0,.1);color:rgba(0,100,0,1);">
	<strong>$conv_username</strong>, your registration was successful. Please log in to continue.</p>
	<form action="assets/inc/process.inc.php" method="post">         
		<fieldset><legend></legend>             
			<label for="uname">Username</label> 
			<input type="text" name="uname" id="uname" value="" />            
			<label for="pword">Password</label>             
			<input type="password" name="pword" id="pword" value="" />             
			<input type="hidden" name="token" value="$_SESSION[token]" />             
			<input type="hidden" name="action" value="user_login" />            
			<input style="margin-top:4px;" type="submit" name="login_submit" value="Log In" />             
			or <a href="./">cancel</a>         
		</fieldset>     
	</form> 
</div>
EOD;


echo $string;

}

if($_GET['action']=='login-fail' && ($_SESSION['token']==$_GET['token'])){
		
$string=<<<EOD
<div id="login-content"> 
	<p style="padding:20px 40px;background-color:rgba(200,0,0,.1);color:rgba(200,0,0,1);">Username or password is incorrect.</p>
	<form action="assets/inc/process.inc.php" method="post">         
		<fieldset><legend></legend>             
			<label for="uname">Username</label> 
			<input type="text" name="uname" id="uname" value="" />            
			<label for="pword">Password</label>             
			<input type="password" name="pword" id="pword" value="" />             
			<input type="hidden" name="token" value="$_SESSION[token]" />             
			<input type="hidden" name="action" value="user_login" />            
			<input style="margin-top:4px;" type="submit" name="login_submit" value="Log In" />             
			or <a href="./">cancel</a>         
		</fieldset>     
	</form> 
</div>
EOD;


echo $string;

}


if($_GET['action']=='contact-us' && ($_SESSION['token']==$_GET['token'])){

$string=<<<EOD
<div id="login-content"> 
<div class="imgcontainer">
      <img src="assets/images/interface/img_avatar2.png" alt="Avatar" class="avatar">
    </div>
	<p style="padding:20px 40px;background-color:rgba(0,200,0,.1);color:rgba(0,200,0,1);">Thanks for contacting our team. We will respond as soon as possible</p>
</div>
EOD;

echo $string;


}


?>
<?php 

/*  * Output the footer  */ 
include_once 'assets/common/footer.inc'; 



?> 