<?php
  session_start();
  if(isset($_SESSION['log'])){
?>
<?php
// Check existence of id parameter before processing further
if(isset($_GET["person_id"]) && !empty(trim($_GET["person_id"]))){
    // Include config file
    require_once 'connect.php';

    // Prepare a select statement
    $sql = "SELECT  person_image, prefix_name, person_firstname, person_lastname, gender_name, person_dob, person_email, usergroup_name FROM `person_details` INNER JOIN prefix ON person_details.prefix_id = prefix.prefix_id INNER JOIN gender ON person_details.gender_id = gender.gender_id INNER JOIN usergroup ON person_details.usergroup_id = usergroup.usergroup_id WHERE person_details.person_id = ?";

    if($stmt = mysqli_prepare($con, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_GET["person_id"]);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $image = $row["person_image"];
                $firstname = $row["person_firstname"];
                $lastname = $row["person_lastname"];
                $gender = $row["gender_name"];
                $prefix = $row["prefix_name"];
                $dob = $row["person_dob"];
                $email = $row["person_email"];
                $usergroup = $row["usergroup_name"];

            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($con);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
        table{
          width: 100%;
        }
        td{

          border-bottom: 1px solid #ddd;
          padding: 8px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                    <table>
                      <tr>
                        <td><b>Image :</b></td>
                        <td><?php echo "<img src=" . $row['person_image']. " width=60 height=60>" ?></td>
                      </tr>
                      <tr>
                        <td><b>Prefix :</b></td>
                        <td><?php echo $row["prefix_name"]; ?></td>
                      </tr>
                      <tr>
                        <td><b>Firstname :</b></td>
                        <td><?php echo $row["person_firstname"]; ?></td>
                      </tr>
                      <tr>
                        <td><b>Lastname :</b></td>
                        <td><?php echo $row["person_lastname"]; ?></td>
                      </tr>
                      <tr>
                        <td><b>Gender :</b></td>
                        <td><?php echo $row["gender_name"]; ?></td>
                      </tr>
                      <tr>
                        <td><b>Date of Birth :</b></td>
                        <td><?php echo $row["person_dob"]; ?></td>
                      </tr>
                      <tr>
                        <td><b>Email :</b></td>
                        <td><?php echo $row["person_email"]; ?></td>
                      </tr>

                      <tr>
                        <td><b>Usergroup :</b></td>
                        <td><?php echo $row["usergroup_name"]; ?></td>
                      </tr>


                    </table>

                  </div>

                    <p>
                    <form class="" action="" method="post">
                      <input type="submit" name="button1" class="btn btn-primary" value="Home"  >
                      <a href="#" class="btn btn-primary" onclick="history.go(-1)">Back</a>
                      <?php
                        if (isset($_POST['button1'])){
                          if((isset($_POST['button1'])) && $_SESSION['usergroup_id'] == '1'){
                              header ("location: superuser.php");
                          }elseif((isset($_POST['button1'])) && $_SESSION['usergroup_id'] == '2'){
                              header ("location: administrator.php");
                          }else{
                              header ("location: observer.php");
                          }
                        }
                      ?>
                    </form></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}else{
  echo "<h1><CENTER>Psyche!!<CENTER></h1>";
  header ("refresh:2;url=index.php");
}
?>
