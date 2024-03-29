<?php 

class quotation_clone
{

public function quotation_master_clone()

{
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$quotation_id = $_POST['quotation_id'];
	$cols=array();

	$result = mysqlQuery("SHOW COLUMNS FROM package_tour_quotation_master"); 
	while ($r=mysqli_fetch_assoc($result)) {
		$cols[]= $r["Field"];
	}

	$result = mysqlQuery("SELECT * FROM package_tour_quotation_master WHERE quotation_id='$quotation_id'");
	while($r=mysqli_fetch_array($result)) {

			$insertSQL = "INSERT INTO package_tour_quotation_master (".implode(", ",$cols).") VALUES (";
			$count=count($cols);
			foreach($cols as $counter=>$col) {

				if($col=='quotation_id'){
					$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(quotation_id) as max from package_tour_quotation_master"));
					$quotation_max = $sq_max['max']+1;
					$insertSQL .= "'".$quotation_max."'";	
				}
				else if($col=='other_desc'){
					$other_desc = addslashes($r[$col]);
					$insertSQL .= "'".$other_desc."'";
				}
				else if($col=='inclusions' || $col=='exclusions'){
					$incl_excl = addslashes($r[$col]);
					$insertSQL .= "'".$incl_excl."'";
				}
				else if($col=='created_at' || $col=='quotation_date'){
					$insertSQL .= "'".date('Y-m-d')."'";
				}
				else{
					$insertSQL .= "'".$r[$col]."'";	
				}

			if ($counter<$count-1) {$insertSQL .= ", "; }
		}
		$insertSQL .= ")";
		$sq_quot = mysqlQuery($insertSQL);

		if(!$sq_quot){
			echo "error--Quotation has not been copied.";
			exit;
		}
		else{
			$this->clone_train_entries($quotation_id, $quotation_max);

			$this->clone_plane_entries($quotation_id, $quotation_max);
			$this->clone_cruise_entries($quotation_id, $quotation_max);

			$this->clone_hotel_entries($quotation_id, $quotation_max);

			$this->clone_transport_entries($quotation_id, $quotation_max);

			$this->clone_excursion_entries($quotation_id, $quotation_max);

			$this->clone_costing_entries($quotation_id, $quotation_max);
			$this->clone_program_entries($quotation_id, $quotation_max);
			$this->clone_images_entries($quotation_id, $quotation_max);
			
			$sq_update  = mysqlQuery("update package_tour_quotation_master set clone='yes' where quotation_id='$quotation_max'");
			
  		echo "Quotation has been successfully copied.";
		}
	}





}




public function clone_transport_entries($quotation_id, $quotation_max)

{

	$cols=array();

	$result = mysqlQuery("SHOW COLUMNS FROM package_tour_quotation_transport_entries2"); 

	 while ($r=mysqli_fetch_assoc($result)) {

	   $cols[]= '`'.$r["Field"].'`';

	}



	  $result = mysqlQuery("SELECT * FROM package_tour_quotation_transport_entries2 WHERE quotation_id='$quotation_id'");

	  while($r=mysqli_fetch_array($result)) {



		    $insertSQL = "INSERT INTO package_tour_quotation_transport_entries2 (".implode(", ",$cols).") VALUES (";

		    $count=count($cols);



		    foreach($cols as $counter=>$col) {



		      if($col=='`id`'){

		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_transport_entries2"));

				$id = $sq_max['max']+1;

				$insertSQL .= "'".$id."'";	

		      }

		      elseif($col=='`quotation_id`'){

 			  	$insertSQL .= "'".$quotation_max."'";		

 			  }

		      else{
 
				$col_name = str_replace('`','',$col);
				$insertSQL .= "'".$r[$col_name]."'";

		      }

		      

			  if ($counter<$count-1) {$insertSQL .= ", ";}



			 }



			  $insertSQL .= ")";
			  
			   mysqlQuery($insertSQL);



	  }



}



public function clone_train_entries($quotation_id, $quotation_max){



	$cols=array();



	$result = mysqlQuery("SHOW COLUMNS FROM package_tour_quotation_train_entries"); 

	 while ($r=mysqli_fetch_assoc($result)) {

	   $cols[]= $r["Field"];

	}





	  $result = mysqlQuery("SELECT * FROM package_tour_quotation_train_entries WHERE quotation_id='$quotation_id'");

	  while($r=mysqli_fetch_array($result)) {



		    $insertSQL = "INSERT INTO package_tour_quotation_train_entries (".implode(", ",$cols).") VALUES (";

		    $count=count($cols);



		    foreach($cols as $counter=>$col) {



		      if($col=='id'){

		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_train_entries"));

				$id = $sq_max['max']+1;

				$insertSQL .= "'".$id."'";	

		      }

 			  elseif($col=='quotation_id'){

 			  	$insertSQL .= "'".$quotation_max."'";		

 			  }

		      else{

		      	$insertSQL .= "'".$r[$col]."'";	

		      }

		      

			  if ($counter<$count - 1) {$insertSQL .= ", ";}



			}

			  $insertSQL .= ")";

			  mysqlQuery($insertSQL);



	  }

}



public function clone_plane_entries($quotation_id, $quotation_max){





	$cols=array();

	$result = mysqlQuery("SHOW COLUMNS FROM package_tour_quotation_plane_entries"); 

	 while ($r=mysqli_fetch_assoc($result)) {

	   $cols[]= $r["Field"];

	}



	  $result = mysqlQuery("SELECT * FROM package_tour_quotation_plane_entries WHERE quotation_id='$quotation_id'");

	  while($r=mysqli_fetch_array($result)) {



		    $insertSQL = "INSERT INTO package_tour_quotation_plane_entries (".implode(", ",$cols).") VALUES (";

		    $count=count($cols);



		    foreach($cols as $counter=>$col) {



		      if($col=='id'){

		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_plane_entries"));

				$id = $sq_max['max']+1;

				$insertSQL .= "'".$id."'";	

		      }

		      elseif($col=='quotation_id'){

 			  	$insertSQL .= "'".$quotation_max."'";		

 			  }

		      else{

		      	$insertSQL .= "'".$r[$col]."'";	

		      }

		      

			  if ($counter<$count-1) {$insertSQL .= ", ";}



			 }



			  $insertSQL .= ")";

			  mysqlQuery($insertSQL);



	  }







}

public function clone_cruise_entries($quotation_id, $quotation_max){



	$cols=array();



	$result = mysqlQuery("SHOW COLUMNS FROM package_tour_quotation_cruise_entries"); 

	 while ($r=mysqli_fetch_assoc($result)) {

	   $cols[]= $r["Field"];

	}





	  $result = mysqlQuery("SELECT * FROM package_tour_quotation_cruise_entries WHERE quotation_id='$quotation_id'");

	  while($r=mysqli_fetch_array($result)) {



		    $insertSQL = "INSERT INTO package_tour_quotation_cruise_entries (".implode(", ",$cols).") VALUES (";

		    $count=count($cols);



		    foreach($cols as $counter=>$col) {



		      if($col=='id'){

		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_cruise_entries"));

				$id = $sq_max['max']+1;

				$insertSQL .= "'".$id."'";	

		      }

 			  elseif($col=='quotation_id'){

 			  	$insertSQL .= "'".$quotation_max."'";		

 			  }

		      else{

		      	$insertSQL .= "'".$r[$col]."'";	

		      }

		      

			  if ($counter<$count - 1) {$insertSQL .= ", ";}



			}

			  $insertSQL .= ")";

			  mysqlQuery($insertSQL);



	  }

}

public function clone_hotel_entries($quotation_id, $quotation_max){





	$cols=array();

	$result = mysqlQuery("SHOW COLUMNS FROM package_tour_quotation_hotel_entries"); 

	 while ($r=mysqli_fetch_assoc($result)) {

	   $cols[]= $r["Field"];

	}



	  $result = mysqlQuery("SELECT * FROM package_tour_quotation_hotel_entries WHERE quotation_id='$quotation_id'");

	  while($r=mysqli_fetch_array($result)) {



		    $insertSQL = "INSERT INTO package_tour_quotation_hotel_entries (".implode(", ",$cols).") VALUES (";

		    $count=count($cols);



		    foreach($cols as $counter=>$col) {



		      if($col=='id'){

		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_hotel_entries"));

				$id = $sq_max['max']+1;

				$insertSQL .= "'".$id."'";	

		      }

		      elseif($col=='quotation_id'){

 			  	$insertSQL .= "'".$quotation_max."'";		

 			  }

		      else{

		      	$insertSQL .= "'".$r[$col]."'";	

		      }

		      

			  if ($counter<$count-1) {$insertSQL .= ", ";}



			 }



			  $insertSQL .= ")";

			  $sq_hotel = mysqlQuery($insertSQL);



	  }





}

public function clone_excursion_entries($quotation_id, $quotation_max)

{

	$cols=array();

	$result = mysqlQuery("SHOW COLUMNS FROM package_tour_quotation_excursion_entries"); 

	 while ($r=mysqli_fetch_assoc($result)) {

	   $cols[]= $r["Field"];

	}



	  $result = mysqlQuery("SELECT * FROM package_tour_quotation_excursion_entries WHERE quotation_id='$quotation_id'");

	  while($r=mysqli_fetch_array($result)) {



		    $insertSQL = "INSERT INTO package_tour_quotation_excursion_entries (".implode(", ",$cols).") VALUES (";

		    $count=count($cols);



		    foreach($cols as $counter=>$col) {



		      if($col=='id'){

		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_excursion_entries"));

				$id = $sq_max['max']+1;

				$insertSQL .= "'".$id."'";	

		      }

		      elseif($col=='quotation_id'){

 			  	$insertSQL .= "'".$quotation_max."'";		

 			  }

		      else{

		      	$insertSQL .= "'".$r[$col]."'";	

		      }

		      

			  if ($counter<$count-1) {$insertSQL .= ", ";}



			 }



			  $insertSQL .= ")";

			  mysqlQuery($insertSQL);



	  }

}

public function clone_program_entries($quotation_id, $quotation_max)
{	
	$cols=array();

	$result = mysqlQuery("SHOW COLUMNS FROM package_quotation_program"); 

	 while ($r=mysqli_fetch_assoc($result)) {

	   $cols[]= $r["Field"];

	}



	  $result = mysqlQuery("SELECT * FROM package_quotation_program WHERE quotation_id='$quotation_id'");

	  while($r=mysqli_fetch_array($result)) {



		    $insertSQL = "INSERT INTO package_quotation_program (".implode(", ",$cols).") VALUES (";

		    $count=count($cols);



		    foreach($cols as $counter=>$col) {



		      if($col=='id'){

		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_quotation_program"));

						$id = $sq_max['max']+1;

						$insertSQL .= "'".$id."'";

		      }

		      elseif($col=='quotation_id'){

 			  	$insertSQL .= "'".$quotation_max."'";		

 			  }

		      else{
				$dyn_content = addslashes($r[$col]);
		      	$insertSQL .= "'".$dyn_content."'";	

		      }

		      

			  if ($counter<$count-1) {$insertSQL .= ", ";}



			 }



			  $insertSQL .= ")";

			  mysqlQuery($insertSQL);



	  }

}
public function clone_images_entries($quotation_id, $quotation_max)
{	
	$cols=array();

	$result = mysqlQuery("SHOW COLUMNS FROM package_tour_quotation_images"); 

	 while ($r=mysqli_fetch_assoc($result)) {

	   $cols[]= $r["Field"];

	}



	  $result = mysqlQuery("SELECT * FROM package_tour_quotation_images WHERE quotation_id='$quotation_id'");

	  while($r=mysqli_fetch_array($result)) {



		    $insertSQL = "INSERT INTO package_tour_quotation_images (".implode(", ",$cols).") VALUES (";

		    $count=count($cols);



		    foreach($cols as $counter=>$col) {



		      if($col=='id'){

		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_images"));

						$id = $sq_max['max']+1;

						$insertSQL .= "'".$id."'";

		      }

		      elseif($col=='quotation_id'){

 			  	$insertSQL .= "'".$quotation_max."'";		

 			  }

		      else{

		      	$insertSQL .= "'".$r[$col]."'";	

		      }

		      

			  if ($counter<$count-1) {$insertSQL .= ", ";}



			 }



			  $insertSQL .= ")";

			  mysqlQuery($insertSQL);



	  }

}


public function clone_costing_entries($quotation_id, $quotation_max){





	$cols=array();

	$result = mysqlQuery("SHOW COLUMNS FROM package_tour_quotation_costing_entries"); 

	 while ($r=mysqli_fetch_assoc($result)) {

	   $cols[]= $r["Field"];

	}



	  $result = mysqlQuery("SELECT * FROM package_tour_quotation_costing_entries WHERE quotation_id='$quotation_id'");

	  while($r=mysqli_fetch_array($result)) {



		    $insertSQL = "INSERT INTO package_tour_quotation_costing_entries (".implode(", ",$cols).") VALUES (";

		    $count=count($cols);



		    foreach($cols as $counter=>$col) {



		      if($col=='id'){

		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_costing_entries"));

				$id = $sq_max['max']+1;

				$insertSQL .= "'".$id."'";	

		      }

		      elseif($col=='quotation_id'){

 			  	$insertSQL .= "'".$quotation_max."'";		

 			  }

		      else{

		      	$insertSQL .= "'".$r[$col]."'";	

		      }

		      

			  if ($counter<$count-1) {$insertSQL .= ", ";}



			 }



			  $insertSQL .= ")";

			  mysqlQuery($insertSQL);



	  }







}



}

?>