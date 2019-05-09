
<?php
    	require_once 'connect.php';
$pic_err = "";
if(isset($_POST["person_id"]) && !empty($_POST["person_id"])){
          // Get hidden input value
      $id = $_POST["person_id"];

  		if (isset($_FILES['person_image'])) {
    			if (empty($_FILES['person_image']['name'])=== true) {
      				$pic_err = "Please select an image";
   			}
			else {
      				$allowed = array('jpg', 'jpeg', 'gif', 'png');

      				$file_name = $_FILES['person_image']['name'];
      				$file_extn = strtolower (end (explode ('.', $file_name) ) );
      				$file_temp = $_FILES['person_image']['tmp_name'];

      				if (in_array($file_extn, $allowed) === true) {
        				//upload the file
					$file_path = 'photo/' . substr( md5 ( time() ) , 0, 10) . '.' . $file_extn;
					move_uploaded_file( $file_temp, $file_path);
					$querii = "UPDATE `person_details` SET `person_image` = '" . $file_path."' WHERE
								`person_id`  = ? ";

                if($stmt = mysqli_prepare($con, $querii)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "i", $param_id);

                    // Set parameters

                    $param_id= $id;

                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        // Records updated successfully. Redirect to landing page
                        header("location: view.php");
                        exit();
                    } else{
                        $pic_err = "Something went wrong. Please try again later.";
                    }
                }

					header('Location : view.php');
					exit();
				}
				else {
        			  $pic_err = ' Incorrect file type. The allowed file types are: ' . implode(', ', $allowed);

      				}
    	}
  }

} else{
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

            } else{
                $pic_err = "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($con);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add profile picture</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>

  </head>
  <body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Add a picture</h2>
                    </div>
                    <p>Please choose a picture and submit to add image to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

                      <div class="form-group <?php echo (!empty($pic_err)) ? 'has-error' : ''; ?>">
                          <label>Image</label>
                          <input type="file" name="person_image">
                          <span class="help-block"><?php echo $pic_err;?></span>
                      </div>
                      <input type="hidden" name="person_id" value="<?php echo $id; ?>"/>
                      <input type="submit" class="btn btn-primary" name="submit" value="Submit">

                      <a href="view.php" class="btn btn-primary" >Back</a>

                      <input type="hidden" name="person_id" value="<?php echo $id; ?>"/>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </body>
  </html>
