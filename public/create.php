<?php
session_start();

$user=$_SESSION['user']['name'];
$token=$_SESSION['token'];

$string=<<<EOD
<div id="register-content"> 
	
	<form action="assets/inc/process.inc.php" method="post">         
		<fieldset><legend style="color:#03A9F4;margin-top:20px;">&nbsp;Enter Pond Details Below</legend>
			
			<input type="text" name="uname" id="uname" value="$user" placeholder="" disabled/>                 
			<input type="text" name="pond-name" id="pond-name" value="" placeholder="Pond Name" required/><br>                                  
			<input type="text" name="ave-temp" id="ave-temp" value="" placeholder="Average Temperature" required/>  
			<input type="text" name="pond-admin" id="pond-admin" value="" placeholder="Created By" required/>                 
			                      
			<textarea rows="15" placeholder="Brief Description About Pond"  name="pond-desc" ></textarea>
			<input type="text" name="pond-wlevel" id="pond-wlevel" value="" placeholder="Current Water Level" required/>
			<input type="hidden" name="token" value="$token" />             
			<input type="hidden" name="action" value="create_pond" />          
			<input style="margin-top:4px;" type="submit" name="create_pond_submit" id="create_pond_submit" value="Create" />             
			or <a href="./ponds.php">cancel</a>         
		</fieldset>     
	</form> 
</div>

EOD;

echo $string;

?>