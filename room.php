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
<div class="my-5 px-4 p-4">
   <h2 class="fw-bold font2 text-center">Our Rooms</h2>
   <div class="hline bg-dark"></div>
   <p class="text-center mt-3">"Your Perfect Escape Awaits: Unwind in Style!"</p>
</div>

<?php
    //Printing Rooms
    $res=run_query("SELECT * FROM `room` WHERE `room_status`=1");
    while($data=mysqli_fetch_assoc($res)){

        //Features of room
        $features=run_query("SELECT f.name FROM `features` f INNER JOIN `room_features` rfea on f.id=rfea.features_id WHERE rfea.room_id='$data[id]'");
        $features_data="";
        if ($features && mysqli_num_rows($features)>0) {
            while ($feature=mysqli_fetch_assoc($features)) {
                $features_data.="<span class='badge rounded-pill bg-light text-dark text-wrap'>{$feature['name']}</span> ";
            }
        } else {
            $features_data = "";
        }

        //Facilities of room
        $facilities=run_query("SELECT faci.name FROM `facilities` faci INNER JOIN `room_facility` rfaci on faci.id=rfaci.facility_id WHERE rfaci.room_id='$data[id]'");
        $facility_data="";
        if ($facilities && mysqli_num_rows($facilities) > 0) {
            while ($facility= mysqli_fetch_assoc($facilities)) {
                $facility_data.="<span class='badge rounded-pill bg-light text-dark text-wrap'>{$facility['name']}</span> ";
            }
        } else {
            $facility_data = "";
        }

        //Room image
        $img=run_query("SELECT * FROM `room_image` WHERE `room_id`=$data[id]");
        if(mysqli_num_rows($img)){
            $img_res=mysqli_fetch_assoc($img);
            $room_img=ROOM_IMAGE_PATH.$img_res['image'];
        }
    
        //Checking login
        $login=0;
        if(isset($_SESSION['login']) && $_SESSION['login']==true){
          $login=1;
        }
        $book_btn="<button onclick='check_login($login,$data[id])' class='btn btn-dark fw-bold p-3 w-100 mb-3' data-mdb-ripple-init data-mdb-ripple-color='dark'>Book Now</button>";

        //Echo room
        echo "
        <div class='container'>
            <div class='row justify-content-evenly mb-5 py-4 shadow-lg'>
                <div class='col-lg-4'>
                    <img src='$room_img' height='300px' width='400px'>
                </div>
                <div class='col-lg-5'>
                    <div class='card-body'>
                        <h5 class='card-title fs-3'>$data[name]</h5>
                        <div class='features mb-4 mt-3'>
                            <h6 class='mb-1'>Features</h6>
                            $features_data
                        </div>
                        <div class='facilities mb-4'>
                            <h6 class='mb-1'>Facilities</h6>
                            $facility_data
                        </div>
                        <div class='guests mb-4 mt-3'>
                            <h6 class='mb-1'>Guests</h6>
                            <span class='badge rounded-pill bg-light text-dark text-wrap'>Adult : {$data['adult']}</span> 
                            <span class='badge rounded-pill bg-light text-dark text-wrap'>Children : {$data['children']}</span> 
                        </div>
                        <div class='rating mb-4'>
                        <h6 class='mb-1'>Rating</h6>
                        <span class='badge rounded-pill bg-light'>
                            <i class='bi bi-star-fill text-warning'></i>
                            <i class='bi bi-star-fill text-warning'></i>
                            <i class='bi bi-star-fill text-warning'></i>
                            <i class='bi bi-star-fill text-warning'></i>
                            <i class='bi bi-star text-warning'></i>
                        </span>
                        </div>
                    </div>
                </div>
                <div class='col-lg-3 text-center mt-5'>
                    <h6 class='mb-4'>₹ $data[price] per day</h6>
                    $book_btn
                    <a href='room_detail.php?id=$data[id]' class='btn btn-light fw-bold p-3 border border-2 w-100' data-mdb-ripple-init data-mdb-ripple-color='dark'>More Details</a>
                </div>
            </div>
        </div>";
    }
?>

<?php require("inc/footer.php")?>
</body>
</html>