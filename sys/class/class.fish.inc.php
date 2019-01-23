<?php

class Fish
{
	public $id;
	public $type;
	public $username;
	public $pond_name;
	public $fish_desc;
	



	public function __construct($retrieved_fish){        
		if ( is_array($retrieved_fish) ){    
	 
			 $this->id = $retrieved_fish['fish_id'];   
			 $this->type= $retrieved_fish['fish_type'];             
			$this->username = $retrieved_fish['username'];             
			$this->pond_name = $retrieved_fish['pond_name'];                       
			$this->fish_desc = $retrieved_fish['fish_desc'];
			
			
			 

		}else{             
			throw new Exception("No valid data supplied for class Fish.");         
		}   





}



}

?>