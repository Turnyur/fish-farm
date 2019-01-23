<?php

class Pond
{
	public $id;
	public $username;
	public $pond_name;
	public $ave_temp;
	public $pond_admin;
	public $pond_desc;
	public $pond_wlevel;
	public $pond_image;
	public $date_created;
	public $last_modified;
	



	public function __construct($retrieved_pond){  
	//echo var_dump($team);       
		if ( is_array($retrieved_pond) ){    
		//echo var_dump($team),"<br>";
		//echo  $team['team_resume'] ;      
			//$this->id = $parcel['shipment_id']; 
			 $this->id = $retrieved_pond['pond_id'];             
			$this->username = $retrieved_pond['username'];             
			$this->pond_name = $retrieved_pond['pond_name'];             
			$this->ave_temp = $retrieved_pond['ave_temp'];             
			$this->pond_admin = $retrieved_pond['pond_admin']; 
			$this->pond_desc = $retrieved_pond['pond_desc'];
			$this->pond_wlevel =$retrieved_pond['pond_wlevel'];
			$this->pond_image =$retrieved_pond['pond_image'];
			$this->date_created =$retrieved_pond['date_created'];
			$this->last_modified =$retrieved_pond['last_modified'];
			
			
			 

		}else{             
			throw new Exception("No valid data supplied for class Pond.");         
		}   





}



}

?>