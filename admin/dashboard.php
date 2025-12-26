<?php
require('../inc/essential.php');
require('../inc/config.php');
require('../inc/links.php');
login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <?php
        //booking queries
        $all_booking_q=run_query("SELECT * FROM `booking_info`");
        $all_pending_q=run_query("SELECT * FROM `booking_info` WHERE status=1");
        $all_booked_q=run_query("SELECT * FROM `booking_info` WHERE status=0");
        $all_deleted_q=run_query("SELECT * FROM `booking_info` WHERE status=-1");

        // number of rows of booking
        $total_bookings = mysqli_num_rows($all_booking_q);
        $pending_bookings = mysqli_num_rows($all_pending_q);
        $booked_bookings = mysqli_num_rows($all_booked_q);
        $deleted_bookings = mysqli_num_rows($all_deleted_q);

        // booking payments
        $total_amount=0;
        $pending_amount=0;
        $booked_amount=0;
        $deleted_amount=0;

        //calculating payments
        while($row=mysqli_fetch_assoc($all_booking_q)){
           $total_amount+=$row['trans_amount'];
        }
        while($row=mysqli_fetch_assoc($all_pending_q)){
            $pending_amount+=$row['trans_amount'];
         }
         while($row=mysqli_fetch_assoc($all_booked_q)){
            $booked_amount+=$row['trans_amount'];
         }
         while($row=mysqli_fetch_assoc($all_deleted_q)){
            $deleted_amount+=$row['trans_amount'];
         }

        //  user queries
         $total_user=run_query("SELECT * FROM `user_info`");
         $user_q=run_query("SELECT * FROM `cus_queries`");
         $read_user_q=run_query("SELECT * FROM `cus_queries` WHERE status=1");

        //  number of rows of user
         $total_user_num=mysqli_num_rows($total_user);
         $user_q_num=mysqli_num_rows($user_q);
         $read_q_num=mysqli_num_rows($read_user_q);
    ?>
</head>
<body>
    <div class="container-fluid bg-dark text-light p-3 d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Admin Panel</h3>
        <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
    </div>
    <div class="container-fluid">
        <div class="row ">

            <!-- vertical nav bar  -->
            <div class="col-lg-2 bg-dark position-sticky dashboard-menu" style="height:inherit;">
                <div class="list-group list-group-flush mx-3 mt-4 py-4">
                    <a href="dashboard.php" class="list-group-item list-group-item-action py-2 ripple active text-white-50">
                        <i class="fas fa-chart-area fa-fw me-3"></i><span>Dashboard</span>
                    </a>
                    <a class="list-group-item list-group-item-action py-2 ripple text-white-50" data-bs-toggle="collapse" href="#booking_link" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="bi bi-cart-fill me-3"></i><span>Booking</span><i class="bi bi-caret-down-square-fill ms-3"></i>
                    </a>
                    <div class="collapse" id="booking_link">
                        <div class="card card-body bg-dark p-0 ">
                            <a href="booking_info.php" class="list-group-item rounded-0 list-group-item-action py-2 ripple text-white-50">
                                <span>Confirm Booking</span>
                            </a>
                            <a href="all_booking.php" class="list-group-item list-group-item-action py-2 ripple text-white-50">
                                <span>All Bookings</span>
                            </a>
                        </div>
                    </div>
                    <a href="rooms.php" class="list-group-item list-group-item-action py-2 ripple  text-white-50">
                        <i class="bi bi-door-open-fill me-3"></i><span>Rooms</span>
                    </a>
                    <a href="features.php" class="list-group-item list-group-item-action py-2 ripple  text-white-50">
                        <i class="bi bi-wifi me-3"></i><span>Features</span>
                    </a>
                   <a href="users.php" class="list-group-item list-group-item-action py-2 ripple text-white-50">
                        <i class="bi bi-person-fill me-3"></i><span>Users</span>
                    </a>
                    <a href="user_queries.php" class="list-group-item list-group-item-action py-2 ripple text-white-50">
                        <i class="bi bi-patch-question-fill me-3"></i><span>User-Queries</span>
                    </a>
                </div>
            </div>

            <!-- side pane  -->
            <div class="col-lg-10 ms-auto p-4 overflow-hidden" style="margin-top: 24px;">

                <!-- booking info  -->
                <h3 class="mb-5">Dashboard</h3>
                <div class="row">
                    <div class="col-3">
                        <div class="card text-info fw-bold shadow-lg" >
                            <div class="card-body py-3">
                                <h5 class="card-title fs-4 text-center">Total Bookings</h5>
                                <p class="card-text fs-1 text-center"><?php echo $total_bookings?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card text-warning fw-bold shadow-lg" >
                            <div class="card-body py-3">
                                <h5 class="card-title  fs-4 text-center">Pending Bookings</h5>
                                <p class="card-text fs-1 text-center"><?php echo $pending_bookings?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card" >
                            <div class="card-body text-success fw-bold shadow-lg py-3" >
                                <h5 class="card-title  fs-4 text-center">Accepted Bookings</h5>
                                <p class="card-text fs-1 text-center"><?php echo $booked_bookings?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card" >
                            <div class="card-body  text-danger fw-bold shadow-lg py-3">
                                <h5 class="card-title  fs-4 text-center">Deleted Bookings</h5>
                                <p class="card-text  fs-1 text-center"><?php echo $deleted_bookings?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment info -->
                <h3 class="my-5">Booking Analytics</h3>
                <div class="row">
                    <div class="col-3">
                        <div class="card text-info shadow-lg" >
                            <div class="card-body py-3">
                                <h5 class="card-title fs-4 text-center">Total Bookings</h5>
                                <p class="card-text fs-1 text-center"><?php echo $total_bookings?></p>
                                <p class="card-text fs-1 text-center">₹<?php echo $total_amount?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card text-warning shadow-lg" >
                            <div class="card-body py-3">
                                <h5 class="card-title  fs-4 text-center">Pending Bookings</h5>
                                <p class="card-text fs-1 text-center"><?php echo $pending_bookings?></p>
                                <p class="card-text fs-1 text-center">₹<?php echo $pending_amount?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card" >
                            <div class="card-body text-success shadow-lg py-3" >
                                <h5 class="card-title  fs-4 text-center">Accepted Bookings</h5>
                                <p class="card-text fs-1 text-center"><?php echo $booked_bookings?></p>
                                <p class="card-text fs-1 text-center">₹<?php echo $booked_amount?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card" >
                            <div class="card-body  text-danger shadow-lg py-3">
                                <h5 class="card-title  fs-4 text-center">Deleted Bookings</h5>
                                <p class="card-text  fs-1 text-center"><?php echo $deleted_bookings?></p>
                                <p class="card-text fs-1 text-center">₹<?php echo $deleted_amount?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- user and user queries info  -->
                <h3 class="my-5">User Analytics</h3>
                <div class="row">
                    <div class="col-3">
                        <div class="card text-info fw-bold shadow-lg" >
                            <div class="card-body py-3">
                                <h5 class="card-title fs-4 text-center">Total Users</h5>
                                <p class="card-text fs-1 text-center"><?php echo $total_user_num?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card text-warning fw-bold shadow-lg" >
                            <div class="card-body py-3">
                                <h5 class="card-title  fs-4 text-center">Total User Queries</h5>
                                <p class="card-text fs-1 text-center"><?php echo $user_q_num?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card" >
                            <div class="card-body text-success fw-bold shadow-lg py-3" >
                                <h5 class="card-title  fs-4 text-center">Reviewed queries</h5>
                                <p class="card-text fs-1 text-center"><?php echo $read_q_num?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card" >
                            <div class="card-body  text-danger fw-bold shadow-lg py-3">
                                <h5 class="card-title  fs-4 text-center">New Queries</h5>
                                <p class="card-text  fs-1 text-center"><?php echo $user_q_num-$read_q_num?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
