<?php 
/*  * Enable sessions  */ 
session_start(); 

/*  * Include necessary files  */ 
include_once '../../../sys/config/db_cred.inc.php'; 
 //echo  $_POST['action'];
/*  * Define constants for config info  */ 
foreach ( $C as $name => $val ) { 
	define($name, $val); 
} 

$dsn='mysql:host='.DB_HOST.';dbname='.DB_NAME;
//"mysql:host=localhost;dbname=php-jquery_example"
$db=new PDO($dsn,DB_USER,DB_PASS);

if ($_POST['action']=='user_registration' && ($_SESSION['token']==$_POST['token'])) {
	$performAction=new Admin($db);
	if ( TRUE === $msg=$performAction->processRegister()){      

     	header("location: ../../Success.php?user=$_POST[uname]&action=reg-success&token=$_POST[token]");         
     	exit;  
		//echo "Success";   
	}else {         
     // If an error occured, output it and end execution         
		die ( $msg );     
	} 
}else if ($_POST['action']=='user_login' && ($_SESSION['token']==$_POST['token'])) {
	$performAction=new Admin($db);

	if ( TRUE === $msg=$performAction->processLoginForm()){      

		header('location: ../../ponds.php');         
		exit;     
	}else {         
     // If an error occured, output it and end execution   
        header("location: ../../Success.php?user=$_POST[uname]&action=login-fail&token=$_POST[token]");  
        exit;      
		die ( $msg );     
	} 
}else if ($_REQUEST['action']=='user_logout' && ($_SESSION['token']==$_REQUEST['token'])) {
	$performAction=new Admin($db);
	$performAction->processLogout();
	header('location: ../../');


}else if ($_POST['action']=='duplicate_user') {
	$performAction=new Admin($db);
	echo $performAction->processDuplicate();

} else if ($_REQUEST['action']=='load_ponds') {
	//echo "Index is: ",$_POST['index'];
	$performAction=new Karly($db);

		//function to perfomr required action goes here
	//if (isset($_POST['index'])) {
		//$performAction->loadTeamMember($_POST['index']);
	//}else{
		$performAction->loadPonds();
	//}
	
}else if ($_POST['action']=='load_fishes' && $_POST['stock_method']=='single') {
	$performAction=new Karly($db);
	echo $performAction->loadSingleStock();
	
}elseif ($_POST['action']=='load_fishes' && $_POST['stock_method']=='multiple') {
	$performAction=new Karly($db);
	echo $performAction->loadMultipleStock();
}elseif ($_POST['action']=='stock_fish' && ($_SESSION['token']==$_POST['token']) && ($_POST['stock_method']=='single')) {
	$performAction=new Karly($db);
	$msg=$performAction->insertSingleStock();
	if ($msg==TRUE) {
		$user=$_SESSION['user']['name'];
		echo "<p class='success'> $user your stock has been successfully saved.</p>";
	}else{
		echo "<p class='failure'> $user an unknown error has occurred.</p>";
	}
}elseif ($_POST['action']=='stock_fish' && ($_SESSION['token']==$_POST['token']) && ($_POST['stock_method']=='multiple')) {

	$performAction=new Karly($db);
	$msg=$performAction->insertMultipleStock();
	if ($msg==TRUE) {
		$user=$_SESSION['user']['name'];
		$num_fish=$_POST['number_fishes'];
		echo "<p class='success'> $user, $num_fish fishes has been successfully stocked.</p>";
	}else{
		echo "<p class='failure'> $user an unknown error has occurred.</p>";
	}


}elseif ($_POST['action']=='transfer_fishes' && isset($_POST['fish_type'])) {
	$performAction=new Karly($db);
	$performAction->TransferFishes($_POST['fish_type']);


}elseif ($_POST['action']=='transfer_fishes') {
	$performAction=new Karly($db);
	$performAction->TransferFishes();


}elseif ($_POST['action']=='edit_fish' && isset($_POST['fish_id'])) {

	$performAction=new Karly($db);
	$performAction->EditFish($_POST['fish_id']);
	
}elseif($_POST['action']=='update_fish_pond'){
	/*echo $_POST['hidden-fish-id'];
	return false;
	exit;*/
	$performAction=new Karly($db);
	$msg=$performAction->commitFishTransfer($_POST['hidden-fish-id']);
	if ($msg==TRUE) {
		//header('location:../../ponds.php');

		echo "<p class='success'>".$_POST['hidden-fish-type']." with S/N ".$_POST['hidden-fish-id']." has been transfered to ".$_POST['pond-name']."</p>";
	}
}elseif($_POST['action']=='delete_fish'){
	/*echo $_POST['hidden-fish-id'];
	return false;
	exit;*/
	$performAction=new Karly($db);
	$msg=$performAction->DeleteFish($_POST['fish_id']);
	if ($msg==TRUE) {
		//header('location:../../ponds.php');

		echo "<p class='success'>Fish with S/N ".$_POST['fish_id']." was deleted successfully.</p>";
	}
}elseif($_POST['action']=='create_pond'){
	//echo "Index is: ",$_POST['index'];
	$performAction=new Karly($db);

	if (TRUE==($msg=$performAction->insertPond())) {
		echo "<p class='success'>Creation of ".$_POST['pond-name']." was successful.</p>";
	}
		
	
}elseif($_POST['action']=='delete_pond'){

	$performAction=new Karly($db);

	if (TRUE===($msg=$performAction->deletePond($_POST['pond_id']))) {
		echo "<p class='success'>Pond with id ".$_POST['pond_id'].", was deleted successfully.</p>";
	}else{
		echo $msg;
	}

}elseif($_POST['action']=='update_pond'){
	

	$performAction=new Karly($db);

	if (TRUE===($msg=$performAction->updatePond($_POST['pond_id']))) {
		echo "<p class='success'>Pond with id ".$_POST['pond_id'].", was updated successfully.</p>";
	}else{
		echo $msg;
	}

}elseif($_POST['action']=='update_pond_save'){
	

	$performAction=new Karly($db);

	if (TRUE===($msg=$performAction->updatePondSave($_POST['pond_id']))) {

		echo "<p class='success'>Pond with id ".$_POST['pond_id'].", was updated successfully.</p>";
	}else{
		echo $msg;
	}

}






function __autoload($class_name) {     
	$filename = '../../../sys/class/class.'. strtolower($class_name) . '.inc.php';     
	if ( file_exists($filename) ){         
		include_once $filename;     
	} 
} 
?>