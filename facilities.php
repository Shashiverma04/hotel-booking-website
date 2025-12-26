<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
   <?php require('inc/links.php') ?>
</head>
<body>
<?php require('inc/header.php');?>

<div class="my-5 px-4">
   <h2 class="fw-bold font2 text-center">Our Facilities</h2>
   <div class="hline bg-dark"></div>
   <p class="text-center mt-3">"Stay Connected, Relax, and Experience Comfort: Your Home Away From Home."</p>
</div>
<div class="container">
   <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
      <?php
         $q=run_query("SELECT * FROM `facilities` LIMIT 4");
         while($res=mysqli_fetch_assoc($q)){
            echo "
            <div class='col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 '>
               <img src='images/facility/$res[facility_image]' class='' height=150px width=150px >
               <p class='card-text mt-3 h5'>$res[name]</p>
            </div>";
         }
      ?>
   </div>
</div>

<div class="my-5 mt-5 px-4">
   <h2 class="fw-bold font2 text-center">Our Features</h2>
   <div class="hline bg-dark"></div>
   <p class="text-center mt-3">"Modern rooms with Wi-Fi, AC, and cozy bedding for a luxurious stay."</p>
</div>
<div class="container">
   <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
      <?php
         $q=run_query("SELECT * FROM `features` LIMIT 4");
         while($res=mysqli_fetch_assoc($q)){
            echo "
            <div class='col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 '>
               <img src='images/Features/$res[features_image]' class='' height=150px width=150px >
               <p class='card-text mt-3 h5'>$res[name]</p>
            </div>";
         }
      ?>
   </div>
</div>
<?php require("inc/footer.php")?>
</body>
</html>