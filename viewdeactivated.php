<?php
  session_start();
  if(isset($_SESSION['log'])){
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Deactivated</title>
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
            <h2 class="pull-left">Deactivated Employees</h2>
          </div>
          <?php
            // Include config file
            require_once 'connect.php';

            // Attempt select query execution
            $sql = "SELECT * FROM person_details WHERE active = 0";
            if($result = mysqli_query($con, $sql)){
              if(mysqli_num_rows($result) > 0){
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>#</th>";
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
                    echo "<td>" . $row['person_usergroup'] . "</td>";
                    echo "<td>" . $row['prefix_id'] . "</td>";
                    echo "<td>" . $row['person_firstname'] . "</td>";
                    echo "<td>" . $row['person_lastname'] . "</td>";
                    echo "<td>" . $row['person_email'] . "</td>";
                    echo "<td>";
                    echo "<a href='activate.php?person_id=". $row['person_id'] ."' title='Activate Employee' data-toggle='tooltip'><span class='glyphicon glyphicon-plus'></span></a>";
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
        <p><a href="#" class="btn btn-primary" onclick="history.go(-1)">Back</a></p>
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
