<!--This is a different way to view a single record-->

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  <form action="#" method="post">


<!-- Firstname-->
<div class="form-group">
    <label>Firstname</label>
    <p class="form-control-static"><?php echo $row["person_firstname"]; ?></p>
</div>

<!-- Lastname-->
<div class="form-group">
    <label>Lastname</label>
    <p class="form-control-static"><?php echo $row["person_lastname"]; ?></p>
</div>

<!-- Gender-->
<div class="form-group">
    <label>Gender</label>
    <p class="form-control-static"><?php echo $row["person_gender"]; ?></p>
</div>

<!-- Prefix -->
<div class="form-group">
    <label>Prefix</label>
    <p class="form-control-static"><?php echo $row["person_prefix"]; ?></p>
</div>

<!--Date of birth-->
<div class="form-group">
    <label>Date Of Birth</label>
    <p class="form-control-static"><?php echo $row["person_dob"]; ?></p>
</div>

<!--Email-->
<div class="form-group">
    <label>Email</label>
    <p class="form-control-static"><?php echo $row["person_email"]; ?></p>
</div>

<!--Password-->
<div class="form-group">
    <label>Password</label>
    <p class="form-control-static"><?php echo $row["person_password"]; ?></p>
</div>

<!--Usergroup-->
<div class="form-group">
    <label>Usergroup</label>
    <p class="form-control-static"><?php echo $row["person_usergroup"]; ?></p>
</div>
</form>
</body>
</html>
