<?php
// Include config file
require_once 'connect.php';
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
session_start();
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if email is empty
    if(empty(trim($_POST["person_email"]))){
        $email_err = 'Please enter email.';
    } else{
        $email = trim($_POST["person_email"]);
    }
    // Check if password is empty
    if(empty(trim($_POST['person_password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['person_password']);
    }
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT * FROM person_details WHERE  person_email = '$email' and person_password = '$password'";
        $result = mysqli_query($con, $sql) or die(mysqli_error($con));
        $count = mysqli_num_rows($result);

        if ($count == 1){
          $user = $result->fetch_array();

          $_SESSION['usergroup_id'] = $user['usergroup_id'];

          if (($count ==1) && ($user['usergroup_id'] == '1')){
            echo "Login  Success";
            $_SESSION['usergroup_id']= $user ['usergroup_id'];
            $_SESSION['log']= 1;
            header ("location: superuser.php");
          }elseif (($count ==1) && ($user['usergroup_id']== '2')) {
            echo "Login  Success";
            header ("location: administrator.php");
          }elseif (($count ==1) && ($user['usergroup_id']== '3')) {
            echo "Login  Success";
            header ("location: observer.php");
          }else{
            echo "Login  Success";
            $_SESSION['log']= 1;
            header ("location: cardholder.php");
          }
        }else{
          $password_err="You have entered incorrect email or password";
        }


        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($con);
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style3.css" />
	<style>
		.waa{
			float:left;
		}
	</style>
  </head>
  <body>
    <div class="loginBox">
			<img src="avatar.png" class="user">
			<h2>IPMS login page</h2>
      <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Enter email : <input type="email" name="person_email" value="<?php echo $email; ?>">
        <span class="help-block"><?php echo $email_err; ?></span><br><br>

        Enter password : <input type="password" name="person_password" value="" id="pwd" >
        <span class="help-block"><?php echo $password_err; ?></span><br>

	<!--creating checkbox for password visibility-->
	<div class="waa">
      	<input type="checkbox" onclick="myFunction()"  >
	</div>
	&nbsp;Show Password
        <input type="submit" name="" value="Login" >
      </form>
    </div>
	<script>
      		function myFunction() {
        		var x = document.getElementById("pwd");
         		if (x.type === "password") {
            			x.type = "text";
          		} else {
            			x.type = "password";
          		}
      		}
	</script>
  </body>
</html>
