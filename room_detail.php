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

<?php

    //checking if we get id
    if(!isset($_GET['id'])){
        redirect('room.php');
    }

    //Getting Room info
    $data=filter($_GET);
    $res=run_query("SELECT * FROM `room` WHERE `id`=$data[id] AND `room_status`=1");

    //checking if room is active
    if(mysqli_num_rows($res)==0){
        redirect('room.php');
    }
    
    //fetching room data
    $room_data=mysqli_fetch_assoc($res);

    //getting features
    $features=run_query("SELECT f.name FROM `features` f INNER JOIN `room_features` rfea on f.id=rfea.features_id WHERE rfea.room_id='$room_data[id]'");
    $features_data="";
    if ($features && mysqli_num_rows($features)>0) {
        while ($feature=mysqli_fetch_assoc($features)) {
            $features_data.="<span class='badge rounded-pill bg-light text-dark text-wrap'>{$feature['name']}</span> ";
        }
    } else {
        $features_data = "";
    }

    //getting facilities
    $facilities=run_query("SELECT faci.name FROM `facilities` faci INNER JOIN `room_facility` rfaci on faci.id=rfaci.facility_id WHERE rfaci.room_id='$room_data[id]'");
    $facility_data="";
    if ($facilities && mysqli_num_rows($facilities) > 0) {
        while ($facility= mysqli_fetch_assoc($facilities)) {
            $facility_data.="<span class='badge rounded-pill bg-light text-dark text-wrap'>{$facility['name']}</span> ";
        }
    } else {
        $facility_data = "";
    }

    //getting room image
    $img=run_query("SELECT * FROM `room_image` WHERE `room_id`=$data[id]");
    if(mysqli_num_rows($img)){
        $img_res=mysqli_fetch_assoc($img);
        $room_img=ROOM_IMAGE_PATH.$img_res['image'];
    }

    //checking login
    $login=0;
    if(isset($_SESSION['login']) && $_SESSION['login']==true){
        $login=1;
    }
    $book_btn="<button onclick='check_login($login,$data[id])' class='btn btn-dark fw-bold p-3 w-100 mb-3' data-mdb-ripple-init data-mdb-ripple-color='dark'>Book Now</button>";
?>

<!-- Printing room details -->
<div class='container'>
    <div class='row justify-content-evenly mb-5 py-4 shadow-lg'>
        <div class=' col-12 my-5 px-4 p-4'>
            <h2 class='fw-bold font2 text-center'><?php echo $room_data['name']?></h2>
            <div class='hline bg-dark'></div>
            <p class='text-center mt-3'>Your Perfect Escape Awaits: Unwind in Style!</p>
        </div>
        <div class='col-lg-7 shadow-none p-5'>
            <img src=<?php echo $room_img?> class="ing-fluid rounded mb-3" height='400px' class="w-100">
        </div>
        <div class='col-lg-5 shadow-lg p-5 '>
            <div class='card-body'>
                <h4><?php echo '₹ '.$room_data['price'] ?></h4>
                <span class='badge rounded-pill bg-light'>
                    <i class='bi bi-star-fill text-warning'></i>
                    <i class='bi bi-star-fill text-warning'></i>
                    <i class='bi bi-star-fill text-warning'></i>
                    <i class='bi bi-star-fill text-warning'></i>
                    <i class='bi bi-star text-warning'></i>
                </span>
                <div class='features mb-4 mt-3'>
                    <h6 class='mb-1'>Features</h6>
                    <?php echo $features_data?>
                </div>
                <div class='facilities mb-4'>
                    <h6 class='mb-1'>Facilities</h6>
                    <?php $facility_data ?>
                </div>
                
                <div class='guests mb-4 mt-3'>
                    <h6 class='mb-1'>Guests</h6>
                    <span class='badge rounded-pill bg-light text-dark text-wrap'>Adult : <?php echo $room_data['adult'] ?></span> 
                    <span class='badge rounded-pill bg-light text-dark text-wrap'>Children : <?php echo $room_data['children'] ?></span> 
                </div>
                <div class='area mb-4'>
                    <h6 class='mb-1'>Area</h6>
                    <?php echo "<span class='badge rounded-pill bg-light text-dark text-wrap'>$room_data[area]. sq.ft.</span>"?>
                </div>
                <?php
                    echo"$book_btn";
                ?>
            </div>
        </div>
        <div class="col-12 mt-4 mx-4 p-3 px-5">
            <div class="mb-4">
                <h4 class="mb-2">Description</h4>
                <p>
                    <?php echo $room_data['description'] ?>
                </p>
            </div>
        </div>
        <div class="col-12 mt-2 mb-3 mx-4 p-3 px-5">
            <div class="mb-4">
                <h4 class="mb-2">Reviews</h4>
                <p>
                    <div class="profile d-flex align-items-center p-4">
                        <img src="images/Features/star.png" class="me-3" width="30px">
                        <h6 class="m-0">Random User</h6>
                    </div>
                    <p>The room is simple and cozy, with a bed, a wooden nightstand, and soft lighting. Natural light from the window adds warmth. Minimal yet inviting, it's perfect for a peaceful retreat.</p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>
<?php require("inc/footer.php")?>
</body>
</html>