<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
</head>
<body>
<?php require('inc/header.php');?>

<!-- carousel -->
<div class="container-fluid">
  <div class="swiper mySwiper swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <img src="images/carousel/IMG_15372.png" class="w-100 d-block">
      </div>
      <div class="swiper-slide">
        <img src="images/carousel/IMG_40905.png" class="w-100 d-block"/>
      </div>
      <div class="swiper-slide">
        <img src="images/carousel/IMG_55677.png" class="w-100 d-block"/>
      </div>
      <div class="swiper-slide">
        <img src="images/carousel/IMG_62045.png" class="w-100 d-block"/>
      </div>
      <div class="swiper-slide">
        <img src="images/carousel/IMG_93127.png" class="w-100 d-block"/>
      </div>
      <div class="swiper-slide">
        <img src="images/carousel/IMG_99736.png" class="w-100 d-block"/>
      </div>
    </div>
  </div>
</div>

<!-- availablity form -->
<div class="container ontop">
  <div class="row">
    <div class="col-lg-12 bg-white shadow p-4">
      <h5 class="mb-4 text-info">Check Availablity</h5>
      <form>
        <div class="row align-items-end" style="font-weight:500">
          <div class="col-lg-3 mb-3">
            <div class="form-label text-info">
              Check-In : 
            </div>
            <input type="date" class="form-control">
          </div>
          <div class="col-lg-3 mb-3">
            <div class="form-label text-info">
              Check-Out : 
            </div>
            <input type="date" class="form-control">
          </div>
          <div class="col-lg-3 mb-3">
            <div class="form-label text-info">Adult : </div>
            <select class="form-select" >
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
            </select>
          </div>
          <div class="col-lg-2 mb-3">
            <div class="form-label text-info">Children : </div>
            <select class="form-select" >
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
            </select>
          </div>
          <div class="col-lg-1 mt-2 mb-lg-3">
            <button type="submit" class="btn btn-info" data-mdb-ripple-init>Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Our Rooms  -->
<h2 class="font2 text-center mt-4 pt-4 mb-4 fw-bold text-info">Our Rooms</h2>
<div class="container">
  <div class="row">
  <?php

    //Getting Room Status
    $res=run_query("SELECT * FROM `room` WHERE `room_status`=1");

    while($data=mysqli_fetch_assoc($res)){
      // Getting Features
        $features=run_query("SELECT f.name FROM `features` f INNER JOIN `room_features` rfea on f.id=rfea.features_id WHERE rfea.room_id='$data[id]'");
        $features_data="";
        if ($features && mysqli_num_rows($features)>0) {
            while ($feature=mysqli_fetch_assoc($features)) {
                $features_data.="<span class='badge rounded-pill bg-light text-dark text-wrap'>{$feature['name']}</span> ";
            }
        } else {
            $features_data = "";
        }

        //Getting Facilities
        $facilities=run_query("SELECT faci.name FROM `facilities` faci INNER JOIN `room_facility` rfaci on faci.id=rfaci.facility_id WHERE rfaci.room_id='$data[id]'");
        $facility_data="";
        if ($facilities && mysqli_num_rows($facilities) > 0) {
            while ($facility= mysqli_fetch_assoc($facilities)) {
                $facility_data.="<span class='badge rounded-pill bg-light text-dark text-wrap'>{$facility['name']}</span> ";
            }
        } else {
            $facility_data = "";
        }

        // Getting Room Image 
        $img=run_query("SELECT * FROM `room_image` WHERE `room_id`=$data[id]");
        if(mysqli_num_rows($img)){
            $img_res=mysqli_fetch_assoc($img);
            $room_img=ROOM_IMAGE_PATH.$img_res['image'];
        }

        //Checking if login
        $login=0;
        if(isset($_SESSION['login']) && $_SESSION['login']==true){
          $login=1;
        }
        $book_btn="<button onclick='check_login($login,$data[id])' class='btn btn-sm btn-dark fw-bold p-3' data-mdb-ripple-init data-mdb-ripple-color='dark'>Book Now</button>";

        // Printing Room Cards
        echo "
        <div class='col-lg-4 col-md-6 my-3'>
          <div class='card border-0 shadow' style='max-width:350px; margin:auto;'>
          <img src='$room_img' height='220px' class='card-img-top' alt='...'>
          <div class='card-body'>
            <h5 class='card-title'>$data[name]</h5>
            <h6 class='mb-4'>₹ $data[price] per day</h6>
            <div class='features mb-4'>
              <h6 class='mb-1'>Features</h6>
              $features_data
            </div>
            <div class='facilities mb-4'>
              <h6 class='mb-1'>Facilities</h6>
              $facility_data
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
              <div class='d-flex justify-content-evenly'>
                $book_btn
                <a href='room_detail.php?id=$data[id]' class='btn btn-sm btn-light fw-bold mx-auto p-3 border border-2' data-mdb-ripple-init data-mdb-ripple-color='dark'>More Details</a>
              </div>
            </div>
          </div>
        </div>";
      }
    ?>
  </div>
</div>

<!-- Facilities -->
<h2 class="font2 text-center mt-4 pt-4 mb-4 fw-bold text-info">Facilities</h2>
<div class="container">
  <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
  <?php 
    $q="SELECT * FROM `facilities` LIMIT 4";
    $fetch=run_query($q);
    while($res=mysqli_fetch_assoc($fetch)){
      echo "
          <div class='col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3'>
          <img src='images/facility/$res[facility_image]' width='80px'>
          <h5 class='mt-5'>$res[name]</h5>
          </div>";
    }
  ?>
  </div>
  <div class="col-lg-12 text-center mt-5">
    <a href="#" class="btn btn-sm btn-outline-info fw-bold" data-mdb-ripple-init data-mdb-ripple-color="dark">More Facilities...</a>
  </div>
</div>

<!-- Our Testinomials -->
<h2 class="font2 text-center mt-4 pt-4 mb-4 fw-bold text-info">Testinomials</h2>
<div class="swiper swiper-testinomial m-4 mt-5 ">
  <div class="swiper-wrapper mb-5">
    <div class="swiper-slide bg-white p-3 m-auto shadow">
        <div class="profile d-flex align-items-center p-4">
          <img src="images/Features/star.png" class="me-3" width="30px">
          <h6 class="m-0 ms-2">Jack</h6>
        </div>
        <p class="ms-3">"The room was clean, spacious, and well-maintained. The comfortable bed and modern amenities made my stay relaxing. I especially appreciated the attention to detail in the décor and the quiet atmosphere. Would highly recommend it to others!"</p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
        </div>
    </div>
    <div class="swiper-slide bg-white p-3 m-auto shadow">
        <div class="profile d-flex align-items-center p-4">
        <img src="images/Features/star.png" class="me-3" width="30px">
          <h6 class="m-0 ms-2">Anna</h6>
        </div>
        <p class="ms-3">Absolutely loved the room! It was cozy, spotless, and equipped with everything I needed. The lighting and ambiance were perfect for a relaxing stay. I’ll definitely book this again for my next visit!</p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
        </div>
    </div>
    <div class="swiper-slide bg-white p-3 m-auto shadow">
      <div class="profile d-flex align-items-center p-4">
      <img src="images/Features/star.png" class="me-3" width="30px">
        <h6 class="m-0 ms-2">Andrew</h6>
      </div>
      <p class="ms-3">The room was fantastic—spacious, clean, and well-maintained. The bed was super comfortable, and the amenities provided made the stay even better. Highly recommend it!</p>
      <div class="rating">
        <i class="bi bi-star-fill text-warning"></i>
        <i class="bi bi-star-fill text-warning"></i>
        <i class="bi bi-star-fill text-warning"></i>
        <i class="bi bi-star-fill text-warning"></i>
        <i class="bi bi-star-fill text-warning"></i>
      </div>
    </div>
  </div>
  <div class="swiper-pagination "></div>
</div>

<!-- Reach us  -->
<h2 class="font2 text-center mt-4 pt-4 mb-4 fw-bold text-info">Reach Us</h2>
<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white shadow">
      <iframe class="w-100" height="320" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d448196.5263595192!2d76.76357175795702!3d28.64368462003187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x37205b715389640!2sDelhi!5e0!3m2!1sen!2sin!4v1726917348635!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="col-lg-4 col-md-4">
      <div class="bg-white shadow p-4 mb-3 text-info">
        <h5>Call Us: </h5>
        <a href="tel: +919999999999" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +91-9999999999</a>
        <br>
        <a href="tel: +918888888888" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +91-8888888888</a>
      </div>
    
      <div class="bg-white shadow p-4 mb-3">
        <h5 class="text-info">Follow Us: </h5>
        <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-white text-dark fs-6 p-2"> <i class="bi bi-twitter-x me-1"></i> Twitter</span></a><br>
        <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-white text-dark fs-6 p-2"> <i class="bi bi-facebook me-1"></i> Facebook</span></a><br>
        <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-white text-dark fs-6 p-2"> <i class="bi bi-instagram me-1"></i> Instagram</span></a>
      </div>
    </div>
  </div>
</div>

<?php require("inc/footer.php")?>

  
<script>
  //carousel
  var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
    });

  // testinomials
  var swiper = new Swiper(".swiper-testinomial", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      slidesPerView:"3",
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: false,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      breakpoints: {
        320:{
          slidesPerView:1,
        },
        640:{
          slidesPerView:1,
        },
        768:{
          slidesPerView:2,
        },
        1024:{
          slidesPerView:3,
        },
        
      }
    });
  
</script>
<!-- bootstrap js  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>