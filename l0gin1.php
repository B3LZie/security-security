<?php
  require ("connect.php");
  $uname = $_POST['person_email'];//these are the text box naames!!!
  $password = $_POST['person_password'];
  session_start();

  $result = mysqli_query($con, "SELECT * FROM `person_details` WHERE `person_email`= '$uname' && `person_password`= '$password'  ");
  $count = mysqli_num_rows($result);
  if ($count ==1){
    $user = $result->fetch_array();

    $_SESSION['person_usergroup'] = $user['person_usergroup'];
    $_SESSION['person_firstname'] = $user['person_firstname'];
    $_SESSION['person_lastname'] = $user['person_lastname'];
    $_SESSION['person_pic'] = $user['person_pic'];
    $_SESSION['person_id'] = $user['person_id'];
    $_SESSION['person_prefix'] = $user['person_prefix'];


    if (($count ==1) && ($user['person_usergroup'] == 'Superuser')){
      echo "Login  Success";
      $_SESSION['person_usergroup']= $user ['person_usergroup'];
      $_SESSION['person_id']= $user['person_id'];
      $_SESSION['person_prefix']= $user['person_prefix'];
      $_SESSION['log']= 1;
      header ("location: superuser.php");
    }elseif (($count ==1) && ($user['person_usergroup']== 'Administrator')) {
      echo "Login  Success";
      $_SESSION['person_id']= $user['person_id'];
      header ("location: administrator.php");
    }elseif (($count ==1) && ($user['person_usergroup']== 'Observer')) {
      echo "Login  Success";
      $_SESSION['person_prefix']= $user['person_prefix'];
      header ("location: observer.php");
    }else{
      echo "Login  Success";
      $_SESSION['log']= 1;
      header ("location: cardholder.php");
    }
  }else{
    echo "Incorrect information";
    header ("refresh:2;url=index.php");
  }

?>
