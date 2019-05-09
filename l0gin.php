<?php
  session_start();
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style3.css" />
  </head>
  <body>
    <div class="loginBox">
			<img src="avatar.png" class="user">
			<h2>IPMS login page</h2>
      <form class="" action="login.php" method="post">
        Enter email : <input type="email" name="person_email" value=""><br><br>
        Enter password : <input type="password" name="person_password" value=""><br><br>
        <input type="submit" name="" value="Login">
      </form>
    </div>
  </body>
</html>
<?php
session_destroy();
?>
