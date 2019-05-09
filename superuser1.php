<?php
  session_start();
  if(isset($_SESSION['log'])){
?>
<html>
<head>
  <title>Home page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" href="style2.css" />
</head>
<body>

<button class="tablink" onclick="openPage('Home', this, 'inherit')"id="defaultOpen">Home</button>
<button class="tablink" onclick="openPage('News', this, 'inherit')" >View Employee Details</button>
<button class="tablink" onclick="openPage('Contact', this, 'inherit')">Add New Employee</button>
<button class="tablink" onclick="openPage('About', this, 'inherit')">View Employee Attendance Log</button>

<div id="Home" class="tabcontent">
    <a href="index.php"> <button type="button" name="logout" style="float:right;">Logout</button> </a>
  <h3>Welcome</h3>


  <section class="portfolio" id="portfolio">


   <div class="portfolio-margin">
   <!-- 1 item portoflio-->
      <ul class="grid">
        <div class="row">
          <div class="column">
         <li>
           <a href="#">
             <img src="man.svg" alt="Portfolio item" />
               <div class="text">
                 <p>My Profile</p>
                 <p class="description">Click to view profile</p>
             </div>
           </a>
         </li>
       </div>
         <!-- 2 item portoflio-->
           <div class="column">
         <li>
           <a href="#">
             <img src="list(1).svg" alt="Portfolio item" />
               <div class="text">
                 <p>View Employee Details</p>
                 <p class="description">Click here to view employees</p>
             </div>
           </a>
         </li>
       </div>
         <!-- 3 item portoflio-->
           <div class="column">
         <li>
           <a href="#">
             <img src="add-contact.svg" alt="Portfolio item" />
               <div class="text">
                 <p>Add New Employee</p>
                 <p class="description">Click here to add new employee</p>
             </div>
           </a>
         </li>
       </div>
         <!-- 4 item portoflio-->
         <li>
           <a href="#">
             <img src="list.svg" alt="Portfolio item" />
               <div class="text">
                 <p>View Attendance Log</p>
                 <p class="description">Click here to view employee attendance log</p>
             </div>
           </a>
         </li>
         <!-- 5 item portoflio-->
         <li>
           <a href="#">
             <img src="code.svg" alt="Portfolio item" />
               <div class="text">
                 <p>Code</p>
                 <p class="description">Click here to edit the code of the system</p>
             </div>
           </a>
         </li>
       </ul>
     </div>
  </div>
  </section>
</div>

<div id="News" class="tabcontent">
  <h3>Employee Details</h3>
  <? php
    require('view.php');
  ?>
</div>

<div id="Contact" class="tabcontent">
  <h3>Add new employee details</h3>
  <p>Get in touch, or swing by for a cup of coffee.</p>
</div>

<div id="About" class="tabcontent">
  <h3>Employee Attendance Log</h3>
  <p>Who we are and what we do.</p>
</div>


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
