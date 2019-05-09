<?php
  session_start();
  if(isset($_SESSION['log'])){
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
  <style type="text/css">
  .wrapper{
      width: 650px;
      margin: 0 auto;
  }
  .page-header h2{
      margin-top: 0;
  }
  table tr td:last-child a{
      margin-right: 15px;
  }
  </style>
  <script type="text/javascript">
      $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
      });
  </script>
</head>
<body>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="page-header clearfix">
            <h2 class="pull-left">Cardholders Details</h2>
            <a href="viewdeactivated.php" class="btn btn-success pull-right">View Deactivated Cardholder</a>
            <a href="add.php" class="btn btn-success pull-right">Add Cardholder</a>

          </div>
          <?php
            // Include config file
            require_once 'connect.php';

            // Attempt select query execution
            $sql = "SELECT person_id, person_image, usergroup_name, prefix_name, person_firstname, person_lastname, person_email FROM `person_details` INNER JOIN prefix ON person_details.prefix_id = prefix.prefix_id INNER JOIN usergroup ON person_details.usergroup_id = usergroup.usergroup_id WHERE person_details.active = 1";
            if($result = mysqli_query($con, $sql)){
              if(mysqli_num_rows($result) > 0){
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>#</th>";
                echo "<th>Image</th>";
                echo "<th>Usergroup</th>";
                echo "<th>Prefix</th>";
                echo "<th>Firstname</th>";
                echo "<th>Lastname</th>";
                echo "<th>Email</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                  while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>" . $row['person_id'] . "</td>";
                    echo "<td><img src=" . $row['person_image']. " width=60 height=60></td>";
                    echo "<td>" . $row['usergroup_name'] . "</td>";
                    echo "<td>" . $row['prefix_name'] . "</td>";
                    echo "<td>" . $row['person_firstname'] . "</td>";
                    echo "<td>" . $row['person_lastname'] . "</td>";
                    echo "<td>" . $row['person_email'] . "</td>";
                    echo "<td>";
                    echo "<a href='read.php?person_id=". $row['person_id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='edit.php?person_id=". $row['person_id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='addpic.php?person_id=". $row['person_id'] ."' title='Add Image' data-toggle='tooltip'><span class='glyphicon glyphicon-picture'></span></a>";
		    echo "<a href='delete.php?person_id=". $row['person_id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";
                    echo "</tr>";
                  }
                echo "</tbody>";
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
              } else{
                  echo "<p class='lead'><em>No records were found.</em></p>";
              }
          } else{
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
          }

          // Close connection
          mysqli_close($con);
          ?>
        </div>
      </div>
      <p>
      <form class="" action="" method="post">
        <input type="submit" name="button1" class="btn btn-primary" value="Home"  >
        <?php
          if (isset($_POST['button1'])){
            if((isset($_POST['button1'])) && $_SESSION['usergroup_id'] == '1'){
                header ("location: superuser.php");
            }elseif((isset($_POST['button1'])) && $_SESSION['usergroup_id'] == '2'){
                header ("location: administrator.php");
            }elseif((isset($_POST['button1'])) && $_SESSION['usergroup_id'] == '3'){
                header ("location: observer.php");
            }else{
                header ("location: cardholder.php");
            }
          }
        ?>
      </form></p>
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
