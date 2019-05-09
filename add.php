
<?php
// Include config file
require 'connect.php';

// Define variables and initialize with empty values
$firstname = $lastname = $gender = $prefix = $dob = $email = $password =
$usergroup = "";

$firstname_err = $lastname_err = $gender_err = $prefix_err = $dob_err =
$email_err = $password_err = $usergroup_err = "";

if(isset($_POST['add1'])){
  $input_g = trim($_POST['gender']);
  $sqls = "SELECT * FROM gender WHERE gender_name = '$input_g'";
  $result = mysqli_query($con, $sqls);

  if(empty($input_g)) {
    $gender_err = "Please fill in the box";
  }elseif(!filter_var(trim($_POST["gender"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
    $gender_err =  'Please enter a valid gender.';
  }elseif (mysqli_num_rows($result) > 0) {
    $gender_err = 'That gender already exists';
  }else{
    $squal = "INSERT INTO gender (gender_name) VALUES ('$input_g')";
    if (mysqli_query($con, $squal)) {
      echo "New gender added successfully";
      header("refresh:1;");
    } else {
      echo "Error: " . $squal . "<br>" . mysqli_error($con);
    }
  }
}

if(isset($_POST['add2'])){
  $input_p = trim($_POST['prefix']);
  $sqls = "SELECT * FROM prefix WHERE prefix_name = '$input_p'";
  $result = mysqli_query($con, $sqls);

  if(empty($input_p)) {
    $prefix_err = "Please fill in the box";
  }elseif(!filter_var(trim($_POST["prefix"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
    $prefix_err =  'Please enter a valid prefix.';
  }elseif (mysqli_num_rows($result) > 0) {
    $prefix_err = 'That prefix already exists';
  }else{
    $squal = "INSERT INTO prefix (prefix_name) VALUES ('$input_p')";
    if (mysqli_query($con, $squal)) {
      echo "New prefix added successfully";
      header("refresh:1;");
    } else {
      echo "Error: " . $squal . "<br>" . mysqli_error($con);
    }
  }
}

if(isset($_POST['add3'])){
  $input_u = trim($_POST['usergroup']);
  $sqls = "SELECT * FROM usergroup WHERE usergroup_name = '$input_u'";
  $result = mysqli_query($con, $sqls);

  if(empty($input_u)) {
    $usergroup_err = "Please fill in the box";
  }elseif(!filter_var(trim($_POST["usergroup"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
    $usergroup_err =  'Please enter a valid usergroup.';
  }elseif (mysqli_num_rows($result) > 0) {
    $usergroup_err = 'That usergroup already exists';
  }else{
    $squal = "INSERT INTO usergroup (usergroup_name) VALUES ('$input_u')";
    if (mysqli_query($con, $squal)) {
      echo "New usergroup added successfully";
      header("refresh:1;");
    } else {
      echo "Error: " . $squal . "<br>" . mysqli_error($con);
    }
  }
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name

    $input_email = trim($_POST["person_email"]);
    $sqls = "SELECT * FROM person_details WHERE person_email = '$input_email'";
    $result = mysqli_query($con, $sqls);

    if(empty($input_email)){
        $email_err = "Please enter an email.";
    }elseif (mysqli_num_rows($result) > 0) {
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
        $sql = "INSERT INTO person_details (person_firstname, person_lastname,
                gender_id, prefix_id, person_dob, person_email,
                person_password, usergroup_id, person_date_created, active)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1)";

        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiisssi", $param_firstname, $param_lastname,
                                  $param_genderid, $param_prefixid, $param_dob,
                                  $param_email, $param_password, $param_usergroupid);

            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_genderid = $gender;
            $param_prefixid = $prefix;
            $param_dob = $dob;
            $param_email = $email;
            $param_password = $password;
            $param_usergroupid = $usergroup;


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
                    <p>Please fill this form and submit to add person record to the database.</p>
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
                            </div><br>
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
                            </div><br>
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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="view.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
