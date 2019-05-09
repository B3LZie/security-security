<?php
  session_start();
  if(isset($_SESSION['log'])){
?>
<?php
// Include config file
require 'connect.php';

// Define variables and initialize with empty values
$firstname = $lastname = $gender = $prefix = $dob = $email = $password =
$usergroup = "";

$firstname_err = $lastname_err = $gender_err = $prefix_err = $dob_err =
$email_err = $password_err = $usergroup_err = "";

// Processing form data when form is submitted
if(isset($_POST["person_id"]) && !empty($_POST["person_id"])){
    // Get hidden input value
    $id = $_POST["person_id"];
    // Validate name

    $input_email = trim($_POST["person_email"]);
    $sqls = "SELECT * FROM person_details WHERE person_email = '$input_email'";
    $result = mysqli_query($con, $sqls);

    if(empty($input_email)){
        $email_err = "Please enter an email.";
    }elseif (mysqli_num_rows($result) > 1) {
        $email_err = 'User with that email already exists';
    }else{
        $email = $input_email;
    }

    // Validate firstname
    $input_firstname = trim($_POST["person_firstname"]);
    if(empty($input_firstname)){
        $firstname_err = 'Please enter a firstname.';
    }elseif(!filter_var(trim($_POST["person_firstname"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $firstname_err = 'Please enter a valid firstname.';
    } else{
        $firstname = $input_firstname;
    }

    // Validate lastname
    $input_lastname = trim($_POST["person_lastname"]);
    if(empty($input_lastname)){
        $lastname_err = 'Please enter your lastname.';
    }elseif(!filter_var(trim($_POST["person_lastname"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $lastname_err = 'Please enter a valid lastname.';
    } else{
        $lastname = $input_lastname;
    }

    // Validate gender
    $input_gender= trim($_POST["gender_name"]);
    if(empty($input_gender)){
        $gender_err = 'Please select a gender.';
    }else{
        $gender = $input_gender;
    }

    // Validate prefix
    $input_prefix = trim($_POST["prefix_name"]);
    if(empty($input_prefix)){
        $prefix_err = 'Please select a prefix.';
    }else{
        $prefix = $input_prefix;
    }

    // Validate dob
    $input_dob = trim($_POST["person_dob"]);
    if(empty($input_dob)){
        $dob_err = 'Please select a date of birth.';
    }else{
        $dob = $input_dob;
    }

    // Validate password
    $input_password = trim($_POST["person_password"]);
    if(empty($input_password)){
        $password_err = 'Please enter a password.';
    }else{
        $password = $input_password;
    }

    // Validate usergroup
    $input_usergroup = trim($_POST["usergroup_name"]);
    if(empty($input_usergroup)){
        $usergroup_err = 'Please select a usergroup.';
    }else{
        $usergroup = $input_usergroup;
    }

    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($lastname_err) && empty($gender_err)
      && empty($prefix_err) && empty($dob_err) && empty($email_err)
      && empty($password_err) && empty($usergroup_err)){
        // Prepare an insert statement
        $sql = "UPDATE person_details SET person_firstname=?, person_lastname=?,
                gender_id=?, prefix_id=?, person_dob=?, person_email=?,
                person_password=?, usergroup_id=?  WHERE person_id=?";

        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiisssii", $param_firstname, $param_lastname,
                                  $param_gender, $param_prefix, $param_dob,
                                  $param_email, $param_password, $param_usergroup, $param_id);

            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_gender = $gender;
            $param_prefix = $prefix;
            $param_dob = $dob;
            $param_email = $email;
            $param_password = $password;
            $param_usergroup = $usergroup;
            $param_id= $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: view.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($con);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["person_id"]) && !empty(trim($_GET["person_id"]))){
        // Get URL parameter
        $id =  trim($_GET["person_id"]);

        // Prepare a select statement
        $sql = "SELECT person_id, person_firstname, person_lastname, gender_name, prefix_name, person_dob, person_email, person_password, usergroup_name FROM `person_details` INNER JOIN prefix ON person_details.prefix_id = prefix.prefix_id INNER JOIN gender ON person_details.gender_id = gender.gender_id INNER JOIN usergroup ON person_details.usergroup_id = usergroup.usergroup_id WHERE person_details.person_id = ?";
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
                    $firstname = $row["person_firstname"];
                    $lastname = $row["person_lastname"];
                    $gender = $row["gender_name"];
                    $prefix = $row["prefix_name"];
                    $dob = $row["person_dob"];
                    $email = $row["person_email"];
                    $password = $row["person_password"];
                    $usergroup = $row["usergroup_name"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="script/script2.js"></script>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to edit person record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <!--Firstname-->
                        <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                            <label>Firstname</label>
                            <input type="text" name="person_firstname" class="form-control" value="<?php echo $firstname; ?>">
                            <span class="help-block"><?php echo $firstname_err;?></span>
                        </div>

                        <!-- Lastname-->
                        <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                            <label>Lastname</label>
                            <input type="text" name="person_lastname" class="form-control" value="<?php echo $lastname; ?>">
                            <span class="help-block"><?php echo $lastname_err;?></span>
                        </div>

                        <!-- Gender-->
                        <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                            <label>Gender</label>
                            <select class="form-control" name="gender_name" onchange='CheckGender(this.value);'>
                              <option value="" selected="selected">Please select a Gender</option>
                              <?php
                                $sql = "SELECT gender_id, gender_name FROM `gender` WHERE `active` = 1";
                                $record = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($record)) {
                                  echo '<option value="'.$row['gender_id'].'">' . $row['gender_name'] . '</option>';
                                }
                              ?>
                              <option value="Other">Other</option>
                            </select>
                            <div class="" id="gender" style='display:none;'>
                              <input class="form-control" type="text" name="gender" />
                              <input type="submit" class="btn btn-primary" name="add1" value="Add" >
                            </div>
                            <span class="help-block"><?php echo $gender_err;?></span>
                        </div>

                        <!-- Prefix-->
                        <div class="form-group <?php echo (!empty($prefix_err)) ? 'has-error' : ''; ?>">
                            <label>Prefix</label>
                            <select class="form-control" name="prefix_name" onchange='CheckPrefix(this.value);'>
                              <option value="" selected="selected">Please select a Prefix</option>
                              <?php
                                $sql = "SELECT prefix_id, prefix_name FROM `prefix` WHERE `active` = 1";
                                $record = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($record)) {
                                  echo '<option value="'.$row['prefix_id'].'">' . $row['prefix_name'] . '</option>';
                                }
                              ?>
                              <option value="Other">Other</option>
                            </select>
                            <div class="" id="prefix" style='display:none;'>
                              <input class="form-control" type="text" name="prefix" />
                              <input type="submit" class="btn btn-primary" name="add2" value="Add" >
                            </div>
                            <span class="help-block"><?php echo $prefix_err;?></span>
                        </div>

                        <!-- Date Of Birth-->
                        <div class="form-group <?php echo (!empty($dob_err)) ? 'has-error' : ''; ?>">
                            <label>Date Of Birth</label>
                            <input type="date" name="person_dob" class="form-control" value="<?php echo $dob; ?>">
                            <span class="help-block"><?php echo $dob_err;?></span>
                        </div>

                        <!-- Email-->
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="email" name="person_email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>

                        <!-- Password-->
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="text" name="person_password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err;?></span>
                        </div>

                        <!-- Usergroup-->
                        <div class="form-group <?php echo (!empty($usergroup_err)) ? 'has-error' : ''; ?>">
                            <label>Usergroup</label>

                            <select class="form-control" name="usergroup_name" onchange='CheckUsergroup(this.value);'>
                              <option value="" selected="selected">Please select a Usergroup</option>
                              <?php
                                $sql = "SELECT usergroup_id, usergroup_name FROM `usergroup` WHERE `active` = 1";
                                $record = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($record)) {
                                  echo '<option value="'.$row['usergroup_id'].'">' . $row['usergroup_name'] . '</option>';
                                }
                              ?>
                              <option value="Other">Other</option>
                            </select>
                            <div class="" id="usergroup" style='display:none;'>
                              <input class="form-control" type="text" name="usergroup" />
                              <input type="submit" class="btn btn-primary" name="add3" value="Add" >
                            </div><br>
                            <span class="help-block"><?php echo $usergroup_err;?></span>
                        </div>

                        <input type="hidden" name="person_id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="view.php" class="btn btn-default">Cancel</a>
                    </form>
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
