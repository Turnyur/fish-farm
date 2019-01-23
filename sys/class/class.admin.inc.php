<?php

class Admin extends DB_Connect { 

	private $_saltLength = 7; 

	public function __construct($db=NULL, $saltLength=NULL){         
		parent::__construct($db); 
		if ( is_int($saltLength)){             
			$this->_saltLength = $saltLength;         
		}     
	} 

public function processDuplicate(){
   
    if ( $_POST['action']!='duplicate_user'){            
        return "Invalid action supplied for processDuplicate.";         
    } 

        /*          
        * Escapes the user input for security          
        */         
        $uname = htmlentities($_POST['uname'], ENT_QUOTES);         

        /*          
        * Retrieves the matching info from the DB if it exists          
        */         
        $sql = "SELECT `username` FROM `users` WHERE `username` = :uname LIMIT 1";         

        try{             
            $stmt = $this->db->prepare($sql);             
            $stmt->bindParam(':uname', $uname, PDO::PARAM_STR);             
            $stmt->execute();             
            //$user = array_shift($stmt->fetchAll());  
            $result=  $stmt->fetch(PDO::FETCH_ASSOC);  
            $user=$result;
            $stmt->closeCursor();         
        }catch ( Exception $e ) {            
            die ( $e->getMessage() );         } 

        /*          
        * Fails if username doesn't match a DB entry          
        */         
        //echo var_dump($user);
        if (is_array(($user) )) {             
            return "$_POST[uname] already taken";
                   
        }else{
            return ""; 
        }


}

	public function processLoginForm(){         
 	/*          
 	* Fails if the proper action was not submitted          
 	*/         
 	if ( $_POST['action']!='user_login'){            
 		return "Invalid action supplied for processLoginForm.";         
 	} 

        /*          
        * Escapes the user input for security          
        */         
        $uname = htmlentities($_POST['uname'], ENT_QUOTES);         
        $pword = htmlentities($_POST['pword'], ENT_QUOTES); 

        /*          
        * Retrieves the matching info from the DB if it exists          
        */         
        $sql = "SELECT `user_fname`,`user_lname`,`user_pword`,`user_email`,`user_birthdate`,`user_country`,`user_regdate`,`username`                 
        FROM `users` 
        WHERE `username` = :uname LIMIT 1";         

        try{             
        	$stmt = $this->db->prepare($sql);             
        	$stmt->bindParam(':uname', $uname, PDO::PARAM_STR);             
        	$stmt->execute();             
        	//$user = array_shift($stmt->fetchAll());  
        	$result=  $stmt->fetchAll(PDO::FETCH_ASSOC);  
        	$user=$result[0];
        	$stmt->closeCursor();         
        }catch ( Exception $e ) {            
        	die ( $e->getMessage() );         } 

        /*          
        * Fails if username doesn't match a DB entry          
        */         
       // echo var_dump($user);
        if (!isset($user) ) {             

        	return "Your username or password is invalid.";         
        }

        /*          
        * Get the hash of the user-supplied password          
        */     

        $hash = $this->_getSaltedHash($pword, $user['user_pword']); 
        /*  $pword is same as $_POST['pword'] and $user['user_pass'] is users 
         *  encripted password from the database
        */

//echo '<br>',$hash;
        /*          
        * Checks if the hashed password matches the stored hash          
        */         
        if ( $user['user_pword']==$hash ){             
        	/*
            * Stores user info in the session as an array              
            */             
        	$_SESSION['user'] = array(                     
        		'id' => $user['user_id'],                     
        		'name' => $user['username'],                     
        		'email' => $user['user_email'],
                'fname' => $user['user_fname'],
                'lname' => $user['user_lname'],
                'country' => $user['user_country'],
                'reg_date' => $user['user_regdate']             
        	); 

        	return TRUE;         
        }else{/*          * Fails if the passwords don't match          */              
        return "Sorry your password is invalid.";         
    }


} 

public function processRegister(){
   if ( $_POST['action']!='user_registration'){            
        return "Invalid action supplied for processRegister.";         
    }

        $fname = htmlentities($_POST['fname'], ENT_QUOTES);
        $lname = htmlentities($_POST['lname'], ENT_QUOTES);      
        $pword = htmlentities($_POST['pword'], ENT_QUOTES);       
        //$confirmpword = htmlentities($_POST['confirm_pword'], ENT_QUOTES); 
        $email = htmlentities($_POST['email'], ENT_QUOTES);
        $birthdate = htmlentities($_POST['birthdate'], ENT_QUOTES); 
        $country = htmlentities($_POST['country'], ENT_QUOTES);
        $uname = htmlentities($_POST['uname'], ENT_QUOTES);               
        //$terms= htmlentities($_POST['terms'], ENT_QUOTES);

        $regdate=date('Y-m-d H:s:i');
        
        $hashed_pass=$this->_getSaltedHash($pword);
        //echo $hashed_pass;

$sql="INSERT INTO `users` (`user_fname`,`user_lname`,`user_pword`,`user_email`,`user_birthdate`,`user_country`,`user_regdate`,`username`)
        VALUES(:fname,:lname,:pword,:email,:birthdate,:country,:regdate,:uname)";
        
        try {
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(':fname',$fname,PDO::PARAM_STR);
            $stmt->bindParam(':lname',$lname,PDO::PARAM_STR);
            $stmt->bindParam(':pword',$hashed_pass,PDO::PARAM_STR);
            $stmt->bindParam(':email',$email,PDO::PARAM_STR);
            $stmt->bindParam(':birthdate',$birthdate,PDO::PARAM_STR);
            $stmt->bindParam(':country',$country,PDO::PARAM_STR);
            $stmt->bindParam(':regdate',$regdate,PDO::PARAM_STR);
            $stmt->bindParam(':uname',$uname,PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            return TRUE;  
        } catch (Exception $e) {
            die ( $e->getMessage() );   
        }




}



private function _getSaltedHash($string, $salt=NULL){         
  /*          * Generate a salt if no salt is passed          */         
  if ( $salt==NULL ){             
     $salt = substr(md5(time()), 0, $this->_saltLength);         
 } else{    /*          * Extract the salt from the string if one is passed          */             
   $salt = substr($salt, 0, $this->_saltLength);         
} 


return $salt . sha1($salt . $string);     
}

public function testSaltedHash($string, $salt=NULL){         
  return $this->_getSaltedHash($string, $salt);     
}

public function processLogout(){         
  /*          * Fails if the proper action was not submitted          */         
  if ( $_REQUEST['action']!='user_logout' ){             
     return "Invalid action supplied for processLogout.";         
 } 
 
 /*          * Removes the user array from the current session          */         
 session_destroy();         
 return TRUE;     
} 


} 




?>