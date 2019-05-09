<?php
  session_start();
  if(isset($_SESSION['log'])){
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cardholder</title>
  </head>
  <body>
    <h3>SORRY SO SORRY YOU CANNOT LOG IN TO THIS SYSTEM
    <b><?php echo htmlspecialchars($_SESSION['person_firstname']); ?></b></h3>
  </body>
</html>
<?php
}else{
  echo "<h1><CENTER>Psyche!!<CENTER></h1>";
  header ("refresh:2;url=index.php");
}
?>
