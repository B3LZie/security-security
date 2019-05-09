<?php
  session_start();
  if(isset($_SESSION['log']) && $_SESSION['usergroup_id'] == '1'){
?>
<html>
<head>
  <title>Home page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style0.css" />
</head>
<body>
  <ul class="topnav">
      <li><a class="active" href="#home">Home</a></li>

  </ul>
  <a href="index.php"><button type="submit" name="logout" style="margin:10px 25px; float:right;">Logout</button></a>

  <h3>Welcome <b><?php echo htmlspecialchars($_SESSION['person_firstname']); ?></b></h3>

  <a href="myprofile.php"><button type="submit" name="logout" style="width:30%; height:8%;">My Profile</button></a> &nbsp;
  <a href="view.php"><button type="submit" name="logout" style="width:30%; height:8%;">View cardholder details</button></a><br><br>
  <a href="viewdeactivated.php"><button type="submit" name="logout" style="width:30%; height:8%;">View Deactivated cardholders</button></a> &nbsp;
  <a href="error.php"><button type="submit" name="logout" style="width:30%; height:8%;">View entry Log</button></a><br><br>

<script>
function openPage(pageName,elmnt,color) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
    }
    document.getElementById(pageName).style.display = "block";
    elmnt.style.backgroundColor = color;
}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>

</body>
</html>
<?php
}else{
  echo "<h1><CENTER>Psyche!!<CENTER></h1>";
  header ("refresh:2;url=index.php");
}
?>
