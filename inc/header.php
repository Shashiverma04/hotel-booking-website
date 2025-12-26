<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<?php require('inc/files_info.php');?>

<!-- navbar -->
<nav class="navbar text-primary bg-body-tertiary navbar-expand-lg navbar-light px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 font2 text-info" href="home.php">Tropical Hotels</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list text-info"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active me-2 text-info " aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active me-2 text-info" href="room.php">Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active me-2 text-info" href="facilities.php">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active me-2 text-info" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active me-2 text-info" href="about.php">About</a>
                </li>
            </ul>
        </div>
        <!-- login -->
        <div class="d-flex mb-2" role="search">

            <!-- showing buttons according to login status  -->
            <?php
                if(isset($_SESSION['login']) && $_SESSION['login']==true){
                    echo<<<data
                    <div class="btn-group btn-primary shadow-none ">
                        <button type="button" class="btn btn-info btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <span id="word" style="font-size:17px;" class="fw-bold pe-3 shadow-none font2">{$_SESSION['uName'][0]}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end ">
                            <li><a class="dropdown-item" href=profile.php>Profile</a></li>
                            <li><a class="dropdown-item" href="booking_user.php">Bookings</a></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </div>
                    data;
                }else{
                    echo<<<data
                        <button type="button" class="btn btn-danger me-3" data-mdb-ripple-init data-mdb-ripple-color="dark" data-bs-toggle="modal" data-bs-target="#loginmodal">Login</button>
                        <button type="button" class="btn btn-info " data-mdb-ripple-init data-mdb-ripple-color="dark" data-bs-toggle="modal" data-bs-target="#registermodal">Register</button>
                    data;

                }
            ?>
        </div>
    </div>
</nav>

<!-- Login  -->
<form id="login_form"> 
    <div class="modal fade " id="loginmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div id="alert-container"></div>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger d-flex align-items-center"> <i class="bi bi-person-circle fs-3 me-3"></i>User Login</h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label text-danger">Email address</label>
                        <input type="email" name="email" class="form-control shadow-sm">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-danger">Password</label>
                        <input type="password" name="password" class="form-control shadow-sm">
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <button type="submit" class="btn btn-light btn-outline-danger" data-mdb-ripple-init data-mdb-ripple-color="dark">Submit</button>
                        <a href="javascript: void(0)" data-bs-toggle="modal" data-bs-target="#forgot" class="">Forget Password</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</form>

<!-- register -->
<form id="register_form" method="POST">
    <div class="modal fade modal-lg" id="registermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div id="alert-container-register"></div>    
    <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-info d-flex align-items-center"><i class="bi bi-person-lines-fill me-2 fs-3"></i> User Registration</h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge mb-3 bg-light-subtle text-primary-emphasis text-wrap lh-base">Note: Your details should match your valid id-card that will required at check-in time. </span>
                    <div class="container text-info">
                        <div class="row">
                                <div class="col-md-6 mb-3">
                                    <lable class="form-lable">Name: </lable>
                                    <input name="name" type="text" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable class="form-lable ps-0">Email : </lable>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <lable class="form-lable ps-0">Phone Number : </lable>
                                    <input type="number" name="phone" class="form-control" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <lable class="form-lable ps-0">Address : </lable>
                                    <textarea class="form-control" name="address" row="2" required></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable class="form-lable ps-0">Pin Code : </lable>
                                    <input type="number" class="form-control" name="pin" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable class="form-lable ps-0">Date of Birth : </lable>
                                    <input type="date" class="form-control" name="DOB" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable class="form-lable ps-0">Password : </lable>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable class="form-lable ps-0">Confirm Password : </lable>
                                    <input type="password" class="form-control" name="c_password" required>
                                </div>
                                
                        </div>
                    </div>
                </div>
                <div class="d-flex text-center mb-4 mx-auto">
                    <button type="submit" class="btn btn-light btn-outline-info" data-mdb-ripple-init data-mdb-ripple-color="dark">Register</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- forgot password modal  -->
<div class="modal fade" id="forgot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body p-4">
        Please contact customer support.
        <br><br>
        <a href="tel: +919999999999" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +91-9999999999</a>
        <br>
        <a href="tel: +918888888888" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +91-8888888888</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
