<?php
class Karly extends DB_Connect{

function __construct($dbo=NULL)
	{
		parent::__construct($dbo);
    } 

	public function loadPonds($id=null){         
 	/*          
 	* Fails if the proper action was not submitted          
 	*/         
 	if ( $_POST['action']!='load_ponds'){            
 		return "Invalid action supplied for loadPonds";         
 	} 

    if (!empty($id)) {
     // echo var_dump($_POST['index']);
         $pond_array=$this->_loadPondData($id);
         //echo var_dump($team_array) ;      
       	$ponds=new Pond($pond_array[0]);

$team_list="";

$team_string=<<<EOD

$team_list.="<div class='column'>";
    $team_list.="<div class='card'>";
     $team_list.="<img src='$pond_individual->pond_image' style='width:100%' alt='$pond_individual->pond_desc'>";
      $team_list.="<div class='container'>";
        $team_list.="<h2>$pond_individual->pond_name</h2>";
        $team_list.="<p class='date_time'>$pond_individual->date_created</p>";
        $team_list.="<p><span>$pond_individual->ave_temp</span>";
        $team_list.="<span>$pond_individual->pond_wlevel</p>";
        $team_list.="<p class='desc'>$pond_individual->pond_desc</p>";
        $team_list.="<p><span class='date_time'>$pond_individual->last_modified</span>";
        $team_list.="<span>$pond_individual->pond_admin</span></p>";
        
      $team_list.="</div>";
    $team_list.="</div>";
  $team_list.="</div>";
   
EOD;

echo $team_string;


             }else if ($id==null) {

             	$pond_obj=array();
              $number_fishes=count($this->_readFishesForEdit());
             	$pond_array=$this->_loadPondData();
              $number_pond=count($pond_array);
             	foreach ($pond_array as $key => $pond) {
             		$pond_obj[$key]=new Pond($pond);
             		//echo var_dump($key);
             	}

//$testTeam=$team_obj['2'];
              $logged_in_user=$_SESSION['user']['name'];
$team_list="<div style='margin:20px;color:rgba(25, 191, 95,1);'><h2> $logged_in_user, you have a total of $number_fishes fishes in $number_pond ponds</h2></div>";

foreach ($pond_obj as $pond_individual) {
	
$fish_counter=count($this->_loadFishPond($pond_individual->pond_name));
$count_tilapia=count($this->_loadFishDataaccordingToPond("Electric Fish",$pond_individual->pond_name));
$count_electric_fish=count($this->_loadFishDataaccordingToPond("Tilapia",$pond_individual->pond_name));
$count_cat_fish=count($this->_loadFishDataaccordingToPond("Cat Fish",$pond_individual->pond_name));
//echo var_dump($this->_loadFishPond($pond_individual->pond_name));


	$team_list.="<div class='column' id='manage-ponds'>";
    $team_list.="<div class='card'><h2>POND ID: $pond_individual->id</h2>";
    
     $team_list.="<img src='$pond_individual->pond_image' alt='$pond_individual->pond_desc'>";
      $team_list.="<div class='container' style='padding:30px;line-height:1.7;word-spacing:3px;;'>";
        $team_list.="<h4><strong>Pond Name:</strong> $pond_individual->pond_name</h4>";
        $team_list.="<h4><strong>Number of Fishes in Pond:</strong> $fish_counter</h4>";
        $team_list.="<h4><strong>Number of Tilapia:</strong> $count_tilapia</h4>";
        $team_list.="<h4><strong>Number of Electric Fish:</strong> $count_electric_fish</h4>";
        $team_list.="<h4><strong>Number of Cat Fish:</strong> $count_cat_fish</h4>";

        $team_list.="<p class='date_time'><strong>Date Created: </strong>$pond_individual->date_created</p>";
        $team_list.="<p><span><strong>Ave. Temperature: </strong>$pond_individual->ave_temp</span> ";
        $team_list.="<span><strong>Water Level: </strong>$pond_individual->pond_wlevel</p>";
        $team_list.="<p class='desc'><strong>Description: </strong><br>$pond_individual->pond_desc</p>";
        $team_list.="<p><span class='date_time'><strong>Last Modified: </strong>$pond_individual->last_modified</span>";
        $team_list.="<span><strong> By: </strong>$pond_individual->pond_admin</span></p>";
        
      $team_list.="</div>";
    $team_list.="</div>";
  $team_list.="</div>";
}
echo $team_list;

             	
             }      

}


private function _loadFishPond($pond_name=null){ 
     
   

     if($pond_name=="POND_1"){
        $pond_name="Pond1";
     }else if($pond_name=="POND_2"){
      $pond_name="Pond2";
     }else if($pond_name=="POND_3"){
      $pond_name="Pond3";
     }


      $sql="SELECT `fish_id`, `fish_type`, `username`, `pond_name`, `fish_desc`
      FROM `fishes`";
      if ( !empty($pond_name) ){            
        $sql .= " WHERE `pond_name`=:pond_name AND `username`=:user ";         
      }else{
            $sql .= " WHERE `username`=:user";
              
      } 

$user=$_SESSION['user']['name'];

      try {             
        $stmt = $this->db->prepare($sql); 
            if ( !empty($pond_name) ){                 
              $stmt->bindParam(":pond_name", $pond_name, PDO::PARAM_STR);             
            } 
            $stmt->bindParam(":user", $user, PDO::PARAM_STR);  
            //echo var_dump($stmt); 
            //exit;
            $stmt->execute();             
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);   //convert Fetched rows into an associated array     
            $stmt->closeCursor(); 
            //var_dump($results);
            return $results;         
        }catch ( Exception $e ){             
          die ( $e->getMessage() );         
        }     
} 

 private function _loadPondData($index=null){ 
    	/*$sql = "SELECT team_id, team_name, team_title, team_resume, team_email, team_phone_number, cover_image
    	FROM `team`"; */
    	$sql="SELECT `pond_id`, `username`, `pond_name`, `ave_temp`, `pond_admin`, `pond_desc`, `pond_wlevel`, `pond_image`, `date_created`, `last_modified`
    	FROM `ponds`";
    	if ( !empty($index) ){            
    		$sql .= "WHERE `pond_id`=:id AND `username`=:user LIMIT 1";         
    	}else{
            $sql .= "WHERE `username`=:user";
              
    	} 

$user=$_SESSION['user']['name'];
    	try {             
    		$stmt = $this->db->prepare($sql); 

            if ( !empty($index) ){                 
            	$stmt->bindParam(":id", $index, PDO::PARAM_INT);      
               $stmt->bindParam(":user", $user, PDO::PARAM_STR);         
            }else{
             $stmt->bindParam(":user", $user, PDO::PARAM_STR);
            }
            
             
            $stmt->execute();             
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);   //convert Fetched rows into an associated array     
            $stmt->closeCursor(); 
            // count($results);
            return $results;         
        }catch ( Exception $e ){             
        	die ( $e->getMessage() );         
        }     
    } 

public function insertPond(){


        $username= $_SESSION['user']['name'];
        $pname= htmlentities($_POST['pond-name'], ENT_QUOTES);
        $temperature=htmlentities($_POST['ave-temp'], ENT_QUOTES);
        $admin=htmlentities($_POST['pond-admin'], ENT_QUOTES);
        $description= htmlentities($_POST['pond-desc'], ENT_QUOTES);
        $wlevel= htmlentities($_POST['pond-wlevel'], ENT_QUOTES);
        $image= "assets/images/ponds.jpg";
        $date=date('Y-m-d H:i:s');
        $modified= date('Y-m-d H:i:s');


$sql="INSERT INTO `ponds` (`username`, `pond_name`,`ave_temp`,`pond_admin`, `pond_desc`, `pond_wlevel`,`pond_image`,`date_created`,`last_modified`)
        VALUES(:uname,:pname,:temp,:admin,:descr,:wlevel,:image,:date_created,:modified)"; 

      try {             
        $stmt = $this->db->prepare($sql); 

                            
                         
            $stmt->bindParam(":uname", $username, PDO::PARAM_STR);   
            $stmt->bindParam(":pname", $pname, PDO::PARAM_STR);   
            $stmt->bindParam(":temp", $temperature, PDO::PARAM_STR);   
            $stmt->bindParam(":admin", $admin, PDO::PARAM_STR);   
            $stmt->bindParam(":descr", $description, PDO::PARAM_STR);   
            $stmt->bindParam(":wlevel", $wlevel, PDO::PARAM_STR);   
            $stmt->bindParam(":image", $image, PDO::PARAM_STR);   
            $stmt->bindParam(":date_created", $date, PDO::PARAM_STR);   
            $stmt->bindParam(":modified", $modified, PDO::PARAM_STR);   
            $stmt->execute();             
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);   //convert Fetched rows into an associated array     
            $stmt->closeCursor(); 
            //var_dump($results);
            return TRUE;         
        }catch ( Exception $e ){             
          die ( $e->getMessage() );         
        }     
    } 



public function updatePondSave($pond_id=null){


        $username= $_SESSION['user']['name'];
        $pname= htmlentities($_POST['pond-name'], ENT_QUOTES);
        $temperature=htmlentities($_POST['ave-temp'], ENT_QUOTES);
        $admin=htmlentities($_POST['pond-admin'], ENT_QUOTES);
        $description= htmlentities($_POST['pond-desc'], ENT_QUOTES);
        $wlevel= htmlentities($_POST['pond-wlevel'], ENT_QUOTES);
        $image= "assets/images/ponds.jpg";
        $date=htmlentities($_POST['date_created'], ENT_QUOTES);
        $modified= htmlentities($_POST['last_modified'], ENT_QUOTES);

      /*  foreach ($_POST as $key => $value) {
          
          print_r($_POST[$key]);
          echo "<br>";



        }*/





$sql="UPDATE `ponds` SET `pond_name`=:pname,`ave_temp`=:temp,`pond_admin`=:admin, `pond_desc`=:descr, `pond_wlevel`=:wlevel,`pond_image`=:image,`date_created`=:date_created,`last_modified`=:modified WHERE `username`=:uname AND `pond_id`=:pond_id";
        
        try {
            $stmt=$this->db->prepare($sql);

            $stmt->bindParam(":uname", $username, PDO::PARAM_STR);   
            $stmt->bindParam(":pond_id", $pond_id, PDO::PARAM_STR);   
            $stmt->bindParam(":pname", $pname, PDO::PARAM_STR);   
            $stmt->bindParam(":temp", $temperature, PDO::PARAM_STR);   
            $stmt->bindParam(":admin", $admin, PDO::PARAM_STR);   
            $stmt->bindParam(":descr", $description, PDO::PARAM_STR);   
            $stmt->bindParam(":wlevel", $wlevel, PDO::PARAM_STR);   
            $stmt->bindParam(":image", $image, PDO::PARAM_STR);   
            $stmt->bindParam(":date_created", $date, PDO::PARAM_STR);   
            $stmt->bindParam(":modified", $modified, PDO::PARAM_STR); 
            //echo var_dump($stmt);
        
            $query_status=$stmt->execute();
            //echo var_dump($query_status);
           /* return 0;
            exit;
            */

            if ($query_status==true) {
                
                 return TRUE;
            }else{
                return FALSE;
            }

            $stmt->closeCursor();

           
        } catch (Exception $e) {
            die ( $e->getMessage() );   
        }







    } 




public function deletePond($id){
if ( $_POST['action']!='delete_pond'){            
        return "Invalid action supplied for deletePond.";         
    } 

  $id=(int)$id;
  if ($id==0) {
    return "<p class='failure'>Please enter an integer e.g: 5.</p>";
  }else{

$exist_pond=$this->_loadPondData($id);
//return var_dump($exist_pond);
    if(count($exist_pond)==0){
      return "<p class='failure'>You have No pond with id $id. Please enter valid pond id .</p>";
 
    }
  
    $sql = "DELETE FROM `ponds` WHERE `pond_id`=:id";         
        
        try {
            $stmt=$this->db->prepare($sql);
          
           
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
           
            $stmt->execute();
            $stmt->closeCursor();

            return TRUE;  
        } catch (Exception $e) {
            die ( $e->getMessage() );   
        }
  }

    } 






public function updatePond($id){
if ( $_POST['action']!='update_pond'){            
        return "Invalid action supplied for updatePond.";         
    } 

  $id=(int)$id;
  if ($id==0) {
    return "<p class='failure'>Please enter an integer e.g: 5.</p>";
  }else{

$exist_pond=$this->_loadPondData($id);
//return var_dump($exist_pond);
    if(count($exist_pond)==0){
      return "<p class='failure'>You have No pond with id $id. Please enter valid pond id .</p>";
 
    }


//$pond_array=$this->_loadPondData($id);
         //echo var_dump($team_array) ;      
        $pond_individual=new Pond($exist_pond[0]);



$pond_string=<<<EOD

<div class='column'">
    <div class='card'>
      <div class='container' style="overflow-x:auto;">
      <form action="assets/inc/process.inc.php" method="post">
      <table>
  <tr>
    <th>S/N</th>
    <th>Pond Name</th>
    <th>Average Temperature</th>
    <th>Created By</th>
    <th>Description</th>
    <th>Water Level</th>
    <th>Createtion date</th>
    <th>Last Modified</th>
  </tr>
 


  <tr>
  <tr><img src='$pond_individual->pond_image' alt='$pond_individual->pond_desc'> </tr>
  <td>$pond_individual->id</td>
    <td><input style="border:1px solid orange;" type="text" name="pond-name" value="$pond_individual->pond_name" ></td>
    <td><input style="border:1px solid orange;" type="text" name="ave-temp" value="$pond_individual->ave_temp" ></td>
    <td><input style="border:1px solid orange;" type="text" name="pond-admin" value="$pond_individual->pond_admin" ></td>
    <td><input style="border:1px solid orange;" type="text" name="pond-desc" value="$pond_individual->pond_desc" ></td>
    <td><input style="border:1px solid orange;" type="text" name="pond-wlevel" value="$pond_individual->pond_wlevel" ></td>
    <td><input style="border:1px solid orange;" type="text" name="date_created" value="$pond_individual->date_created" ></td>
    <td><input style="border:1px solid orange;" type="text" name="last_modified" value="$pond_individual->last_modified" ></td>
    
    
      <tr><input type=hidden name="action" value="update_pond_save"></tr>
      <input type=hidden name="pond_id" value="$pond_individual->id">
      <tr><input type="submit" id="update_pond_submit_save" value="Update"></tr>
  </tr>
</table>
</form>
      </div>
    </div>
  </div>
   
EOD;

echo $pond_string;
  
   
  }
 

 }
     
       



public function EditFish($id=null){     

  /*          
  * Fails if the proper action was not submitted          
  */         
  if ( $_POST['action']!='edit_fish'){            
    return "Invalid action supplied for EditFish";         
  } 

    if (!empty($id)) {
  
      
        $fish_array=$this->_readFishesForEdit($id);
        // echo var_dump($fish_array) ;      
        $fish=new Fish($fish_array[0]);

$ponds=$this->_loadPondData();
$num_ponds=count($ponds);
$user_ponds="";
for ($i=1; $i <= $num_ponds; $i++) { 
  $user_ponds.="<option value='Pond$i'>Pond$i</option>";
  
}

 $fish_list="";
       
$fish_string=<<<EOD

  <div id="register-content"> 
  <form action="assets/inc/process.inc.php" method="post">         
    <fieldset><legend>&nbsp;</legend>             
      
      <input type="text" name="fish-id" value="$fish->id" placeholder="" disabled/>    
      <input type="hidden" name="hidden-fish-id" value="$fish->id" placeholder=""/>            
      <input type="hidden" name="hidden-fish-type" value="$fish->type" placeholder=""/>            
      <input type="text" name="fish-type" value="$fish->type" placeholder="" disabled/> 
       <select id="pond-name" name="pond-name">
      $user_ponds
      </select>
      
      <textarea rows="15" placeholder="$fish->fish_desc" name="fish_desc" disabled></textarea>
      <input type="hidden" name="token" value="$_SESSION[token]" />             
      <input type="hidden" name="action" value="update_fish_pond" />            
      <input style="margin-top:4px;" type="submit" name="transfer_submit" value="Transfer" id="transfer_fish_submit" />             
       <a href="./">cancel</a>         
    </fieldset>     
  </form> 
</div>
EOD;

echo $fish_string;


             }



}



public function TransferFishes($fish_type=null){     
  

  /*          
  * Fails if the proper action was not submitted          
  */         
  if ( $_POST['action']!='transfer_fishes'){            
    return "Invalid action supplied for loadFishes";         
  } 

    if (!empty($fish_type)) {
     
         //$fish_array=$this->_loadFishData($fish_type);
        // $counter=count($fish_array);
         //echo var_dump($fish_array) ;      
        //$fishes=new Fish($fish_array[0]);

      $fish_obj=array();
              $fish_array=$this->_loadFishData($fish_type);

              foreach ($fish_array as $key => $fish) {
                $fish_obj[$key]=new Fish($fish);
                //echo var_dump($key);
              }

 $fish_list="";
             
foreach ($fish_obj as   $fish) {
  $fish_list.="<tr><td>$fish->id</td><td>$fish->type</td><td>$fish->pond_name</td><td>$fish->fish_desc</td><td><button class='edit' id='$fish->id'>Edit</button</td></tr>";
}
  

$fish_string=<<<EOD

<div class='column'>
    <div class='card'>
      <div class='container'>
      <table>
  <tr>
    <th>S/N</th>
    <th>Fish Category</th>
    <th>Pond</th>
    <th>Comment</th>
  </tr>
  $fish_list
  
</table>
      </div>
    </div>
  </div>
   
EOD;

echo $fish_string;


             }



else if ($fish_type==null) {

              $fish_obj=array();
              $fish_array=$this->_loadFishData();
              //echo var_dump($fish_array);
              foreach ($fish_array as $key => $fish) {
                $fish_obj[$key]=new Fish($fish);
                //echo var_dump($key);
              }


$fish_list="";
             
foreach ($fish_obj as   $fish) {
  $fish_list.="<tr><td>$fish->id</td><td>$fish->type</td><td>$fish->pond_name</td>
  <td>$fish->fish_desc</td><td><button class='edit' id='$fish->id'>Delete</button</td></tr>";
}
  

$fish_string=<<<EOD

<div class='column'>
    <div class='card'>
      <div class='container'>
      <table>
  <tr>
    <th>S/N</th>
    <th>Fish Category</th>
    <th>Pond</th>
    <th>Comment</th>
  </tr>
  $fish_list
  
</table>
      </div>
    </div>
  </div>
   
EOD;

echo $fish_string;

              
             }      

}

public function loadSingleStock(){
/*echo "<h1>string</h1>";
return false;
exit;*/

$ponds=$this->_loadPondData();
$num_ponds=count($ponds);
$user_ponds="";
for ($i=1; $i <= $num_ponds; $i++) { 
  $user_ponds.="<option value='Pond$i'>Pond$i</option>";
  
}


$stock_form=<<<EOD
<div id="register-content"> 
  
  <form action="assets/inc/process.inc.php" method="post">         
    <fieldset><legend><h2 style="color: rgba(2, 172, 249,1);">Stock fishes into ponds</h2></legend>
      
      <select id="fish-type" name="fish-type">
            <option value="">Fish Type</option>
             <option value="Tilapia">Tilapia</option>
            <option value="Electric Fish">Electric Fish</option>
            <option value="Cat Fish">Cat Fish</option>
          </select>
      <select id="pond-name" name="pond-name">
      $user_ponds
      </select>
      <textarea rows="15" placeholder=" Enter Text Here" name="fish_desc"></textarea>  
      <input type="hidden" name="token" value="$_SESSION[token]" />             
      <input type="hidden" name="action" value="stock_fish" />  
      <input type="hidden" name="stock_method" value="single" />        
      <input style="margin-top:4px;" type="submit" name="stock_save" value="Save" id="stock_save"/>             
      or <a href="./">cancel</a>         
    </fieldset>     
  </form> 
</div>
   
EOD;

return $stock_form;



}

public function loadMultipleStock(){



$ponds=$this->_loadPondData();
$num_ponds=count($ponds);
$user_ponds="";
for ($i=1; $i <= $num_ponds; $i++) { 
  $user_ponds.="<option value='Pond$i'>Pond$i</option>";
  
}


$stock_form=<<<EOD
<div id="register-content"> 
  
  <form action="assets/inc/process.inc.php" method="post">         
    <fieldset><legend><h2 style="color: rgba(2, 172, 249,1);">Stock fishes into ponds</h2></legend>
      
      <select id="fish-type" name="fish-type">
            <option value="">Fish Type</option>
             <option value="Tilapia">Tilapia</option>
            <option value="Electric Fish">Electric Fish</option>
            <option value="Cat Fish">Cat Fish</option>
          </select>
      <select id="pond-name" name="pond-name">
      $user_ponds
      </select>
      <div class="slidecontainer">
      <input type="range" min="1" max="1000" name="number_fishes" value="1" class="slider" id="myRange">
      <p style="margin-top:20px;color:rgba(0, 120, 215,1);">Number of Fishes: <span id="demo" ></span></p>
      </div>
      <textarea rows="15" placeholder=" Enter Text Here" name="fish_desc"></textarea>  
      <input type="hidden" name="token" value="$_SESSION[token]" />             
      <input type="hidden" name="action" value="stock_fish" />          
      <input type="hidden" name="stock_method" value="multiple" />    
      <input style="margin-top:4px;" type="submit" name="stock_save" value="Save" id="stock_save"/>             
      or <a href="./">cancel</a>         
    </fieldset>     
  </form> 
</div>
   
EOD;

return $stock_form;



}

public function insertSingleStock(){
     if ( $_POST['action']!='stock_fish'){            
        return "Invalid action supplied for insertSingleStock.";         
    }

                 
        $type= htmlentities($_POST['fish-type'], ENT_QUOTES);
        $username= $_SESSION['user']['name'];
        $pname= htmlentities($_POST['pond-name'], ENT_QUOTES);
        $description= htmlentities($_POST['fish_desc'], ENT_QUOTES);
       
        

$sql="INSERT INTO `fishes` (`fish_type`, `username`,`pond_name`,`fish_desc`)
        VALUES(:type,:uname,:pond_name,:descr)";
        
        try {
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(':type',$type,PDO::PARAM_STR);
             $stmt->bindParam(':uname',$username,PDO::PARAM_STR);
            $stmt->bindParam(':pond_name',$pname,PDO::PARAM_STR);
            $stmt->bindParam(':descr',$description,PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            return TRUE;  
        } catch (Exception $e) {
            die ( $e->getMessage() );   
        }


}

public function insertMultipleStock(){
     if ( $_POST['action']!='stock_fish'){            
        return "Invalid action supplied for insertMultipleStock.";         
    }

                 
        $type= htmlentities($_POST['fish-type'], ENT_QUOTES);
        $username= $_SESSION['user']['name'];
        $pname= htmlentities($_POST['pond-name'], ENT_QUOTES);
        $num_fish=$_POST['number_fishes'];
        $num_fish=(int)$num_fish;
        //echo var_dump($num_fish);
        $description= htmlentities($_POST['fish_desc'], ENT_QUOTES);
       
        

$sql="INSERT INTO `fishes` (`fish_type`, `username`,`pond_name`,`fish_desc`)
        VALUES(:type,:uname,:pond_name,:descr)";
        
           try {
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(':type',$type,PDO::PARAM_STR);
             $stmt->bindParam(':uname',$username,PDO::PARAM_STR);
            $stmt->bindParam(':pond_name',$pname,PDO::PARAM_STR);
            $stmt->bindParam(':descr',$description,PDO::PARAM_STR);
            for ($i=0; $i < $num_fish; $i++) { 
            $stmt->execute();
                    }
            $stmt->closeCursor();

            return TRUE;  
        } catch (Exception $e) {
            die ( $e->getMessage() );   
        }

       


}

private function _loadFishDataaccordingToPond($fish_type=null,$pond_name=null){ 


     if($pond_name=="POND_1"){
        $pond_name="Pond1";
     }else if($pond_name=="POND_2"){
      $pond_name="Pond2";
     }else if($pond_name=="POND_3"){
      $pond_name="Pond3";
     }


 $sql="SELECT `fish_id`, `fish_type`, `username`, `pond_name`, `fish_desc`
      FROM `fishes`";
      if ( !empty($fish_type) ){            
        $sql .= "WHERE (`fish_type`=:mtype AND `username`=:user) AND `pond_name`=:pond_name ";         
      }else{
            $sql .= "WHERE `username`=:user";
              
      } 
$user=$_SESSION['user']['name'];

      try {             
        $stmt = $this->db->prepare($sql); 

            if ( !empty($fish_type) ){                 
              $stmt->bindParam(":mtype", $fish_type, PDO::PARAM_STR);             
              $stmt->bindParam(":pond_name", $pond_name, PDO::PARAM_STR);             
            } 
            $stmt->bindParam(":user", $user, PDO::PARAM_STR);   
            $stmt->execute();             
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);   //convert Fetched rows into an associated array     
            $stmt->closeCursor(); 
            //var_dump($results);
            return $results;         
        }catch ( Exception $e ){             
          die ( $e->getMessage() );         
        }     




}


private function _loadFishData($fish_type=null){ 
    
      $sql="SELECT `fish_id`, `fish_type`, `username`, `pond_name`, `fish_desc`
      FROM `fishes`";
      if ( !empty($fish_type) ){            
        $sql .= "WHERE `fish_type`=:mtype AND `username`=:user ";         
      }else{
            $sql .= "WHERE `username`=:user";
              
      } 
$user=$_SESSION['user']['name'];

      try {             
        $stmt = $this->db->prepare($sql); 

            if ( !empty($fish_type) ){                 
              $stmt->bindParam(":mtype", $fish_type, PDO::PARAM_STR);             
            } 
            $stmt->bindParam(":user", $user, PDO::PARAM_STR);   
            $stmt->execute();             
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);   //convert Fetched rows into an associated array     
            $stmt->closeCursor(); 
            //var_dump($results);
            return $results;         
        }catch ( Exception $e ){             
          die ( $e->getMessage() );         
        }     
    } 


private function _readFishesForEdit($id=null){ 
    
      $sql="SELECT `fish_id`, `fish_type`, `username`, `pond_name`, `fish_desc`
      FROM `fishes` ";     
      if(!empty($id)){
         $sql.= "WHERE `fish_id`=:id AND `username`=:user";
      }else{
        $sql.= "WHERE `username`=:user";
      }    
       



$user=$_SESSION['user']['name'];
      try {             
        $stmt = $this->db->prepare($sql); 
         if(!empty($id)){            
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            
            }        


            $stmt->bindParam(":user", $user, PDO::PARAM_STR);   
            $stmt->execute();             
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);   //convert Fetched rows into an associated array     
            $stmt->closeCursor(); 
            //var_dump($results);
            return $results;         
        }catch ( Exception $e ){             
          die ( $e->getMessage() );         
        }     
    }


public function commitFishTransfer($id=null){
echo $id;
  if ( $_POST['action']!='update_fish_pond'){            
        return "Invalid action supplied for commitFishTransfer.";         
    } 
        $pname= htmlentities($_POST['pond-name'], ENT_QUOTES);  

$sql = "UPDATE `fishes` SET `pond_name`=:pond_name WHERE `fish_id`=:id";         
         
        try {
            $stmt=$this->db->prepare($sql);
          
            $stmt->bindParam(':pond_name',$pname,PDO::PARAM_STR);
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
           
            $stmt->execute();
            $stmt->closeCursor();

            return TRUE;  
        } catch (Exception $e) {
            die ( $e->getMessage() );   
        }


}

public function DeleteFish($id=null){
echo $id;
  if ( $_POST['action']!='delete_fish'){            
        return "Invalid action supplied for DeleteFish.";         
    } 
       

$sql = "DELETE FROM `fishes` WHERE `fish_id`=:id";         
        
        try {
            $stmt=$this->db->prepare($sql);
          
           
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
           
            $stmt->execute();
            $stmt->closeCursor();

            return TRUE;  
        } catch (Exception $e) {
            die ( $e->getMessage() );   
        }


}


public function processContactForm(){
   if ( $_POST['action']!='contact-us'){            
        return "Invalid action supplied for processContactForm.";         
    }

        $fname = $_SESSION['user']['fname'];
        $lname = $_SESSION['user']['lname'];
        $email = $_SESSION['user']['email'];
        $uname = $_SESSION['user']['name'];               
        $feedback_text= htmlentities($_POST['feedback_text'], ENT_QUOTES);

        $submission_date=date('Y-m-d H:s:i');
        
       // $hashed_pass=$this->_getSaltedHash($pword);
        //echo $hashed_pass;

$sql="INSERT INTO `feedback` (`username`, `user_email`, `user_fname`,`user_lname`,`feedback_sub_date`,`feedback_text`)
        VALUES(:uname,:email,:fname,:lname,:feedback_date,:feedback_text)";
        
        try {
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(':uname',$uname,PDO::PARAM_STR);
             $stmt->bindParam(':email',$email,PDO::PARAM_STR);
            $stmt->bindParam(':fname',$fname,PDO::PARAM_STR);
            $stmt->bindParam(':lname',$lname,PDO::PARAM_STR);
            $stmt->bindParam(':feedback_date',$submission_date,PDO::PARAM_STR);
            $stmt->bindParam(':feedback_text',$feedback_text,PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            return TRUE;  
        } catch (Exception $e) {
            die ( $e->getMessage() );   
        }




}





}

?>