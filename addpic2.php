<?php
// Include config file
require_once 'connect.php';
// Define variables and initialize with empty values
$person_image  = "";
$person_image_err =  "";
// Processing form data when form is submitted
if(isset($_POST["person_id"]) && !empty($_POST["person_id"])){
	// Get hidden input value
    	$id = $_POST["person_id"];
    	// Validate name
    	$input_pic = trim($_POST["person_image"]);
    	$sqls = "SELECT * FROM person_details WHERE person_image = '$input_pic'";
    	$result = mysqli_query($con, $sqls);
	$allowed = array('jpg', 'jpeg', 'gif', 'png');
      	$file_name = $_FILES['person_image']['name'];
      	$file_extn = strtolower (end (explode ('.', $file_name) ) );
      	$file_temp = $_FILES['person_image']['tmp_name'];

    	if(empty($input_pic)){
        	$person_image_err = "Please choose a  file";
    	}
	elseif(in_array($file_extn, $allowed) === false) {
		$person_image_err = ' Incorrect file type. The allowed file types are:' . implode(', ', $allowed);
	}
	else{
		$person_image = $input_pic;
	}
    	// Check input errors before inserting in database
    	if(empty($person_image_err) ){
        	// Prepare an insert statement
		$file_path = 'photo/' . substr( md5 (time () ) , 0, 10) . ' . ' . $file_extn;
		move_uploaded_file($file_temp, $file_path);
        	$sql = "UPDATE person_details SET person_image = '"  .$file_path. "' WHERE person_id=?";

		if($stmt = mysqli_prepare($con, $sql)){
            		// Attempt to execute the prepared statement
            		if(mysqli_stmt_execute($stmt)){
                		// Records updated successfully. Redirect to landing page
                		header("location: view.php");
                		exit();
            		}
			else{
                		echo "Something went wrong. Please try again later.";
            		}
        	}
        	// Close statement
        	mysqli_stmt_close($stmt);
    	}
    	// Close connection
    	mysqli_close($con);
	}
	else{
    		// Check existence of id parameter before processing further
    		if(isset($_GET["person_id"]) && !empty(trim($_GET["person_id"]))){
        		// Get URL parameter
        		$id =  trim($_GET["person_id"]);
        		// Prepare a select statement
        		$sql = "SELECT * FROM person_details WHERE person_id = ?";

			if($stmt = mysqli_prepare($con, $sql)){
            		// Bind variables to the prepared statement as parameters
            		mysqli_stmt_bind_param($stmt, "i", $param_id);
            		// Set parameters
            		$param_id = $id;
            		// Attempt to execute the prepared statement
            		if(mysqli_stmt_execute($stmt)){
                		$result = mysqli_stmt_get_result($stmt);
                		if(mysqli_num_rows($result) == 1){
                    			/* Fetch result row as an associative array. Since the result set
                    			contains only one row, we don't need to use while loop */
                    			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    			// Retrieve individual field value
                    			$name = $row["person_name"];
                    			$address = $row["person_address"];
                    			$lastname = $row["person_lastname"];
                		}
            		} else{
                		echo "Oops! Something went wrong. Please try again later.";
            		}
        	}
        	// Close statement
        	mysqli_stmt_close($stmt);
        	// Close connection
        	mysqli_close($con);
    	}
}
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add profile picture</title>
    <link rel="stylesheet" href="stylee.css">
  </head>
  <body>
    <div class="profile">
      <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="person_image" >
        <input type="submit" name="submit">
      </form>
    </div>
  </body>
</html>
