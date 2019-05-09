<?php
  session_start();
  if(isset($_SESSION['log'])){
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 750px;
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
                        <h1>Invalid Request</h1>
                    </div>
                    <div class="alert alert-danger fade in">
                        <p><form class="" action="" method="post">
                          Sorry, you've made an invalid request. Please
                          <input type="submit" name="button1" value="go back"  >
                          and try again.
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
                        </form> </p>
                    </div>
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
