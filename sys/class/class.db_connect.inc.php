<?php 


class DB_Connect{
	
protected $db;



function __construct($db=NULL){

	if (is_object($db)) {
		$this->db=$db;
	}else{
			$dsn="mysql:host=".DB_HOST.";dbname=".DB_NAME;

			try {
				$db=new PDO($dsn,DB_USER,DB_PASS);
			} catch (Exception $e) {
				 // If the DB connection fails, output the error                
				  die ( $e->getMessage() ); 
				  //echo "Error Occurred!";
			}

	}


}

}


?>