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
</head>
<body>
    <div class="container-fluid bg-dark text-light p-3 d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Admin Panel</h3>
        <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
    </div>
    <div class="container-fluid">
        <div class="row ">
            <!-- vertical navbar  -->
            <div class="col-lg-2 bg-dark position-sticky dashboard-menu" style=" height:inherit">
                <div class="list-group list-group-flush mx-3 mt-4 py-4">
                    <a href="dashboard.php" class="list-group-item list-group-item-action py-2 ripple text-white-50">
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
                    <a href="features.php" class="list-group-item list-group-item-action active py-2 ripple  text-white-50">
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

            <!-- side panel -->
            <div class="col-lg-10 ms-auto p-4 overflow-hidden" style="margin-top: 24px;">
                <h3 class="mb-4">Features & Facilities</h3>

                <!-- Features  -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body" style="height:400px;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="card-title m-0">Features</div>
                            <!-- add features -->
                            <div class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#feature">
                                <i class="bi bi-plus-square"></i>Add
                            </div>
                        </div>

                        <div class="tabe-responsive-md" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-hover border">
                                <thead class="sticky-top table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // fetching features
                                        $q="SELECT * FROM `features`";
                                        $data=run_query($q);
                                        $i=1;
                                        if ($data) {
                                            while($row=mysqli_fetch_assoc($data))
                                            {
                                                echo "<tr>
                                                        <td>$i</td>
                                                        <td>$row[name]</td>
                                                        <td><img src='../images/Features/$row[features_image]' height=100px width=100px class='rounded'></td>
                                                        <td><button class='btn btn-danger btn-sm' type='button' onclick='rem_feature($row[id])'>Delete</button></td>
                                                    </tr>";
                                                $i++;
                                            }
                                        }

                                        
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Facility  -->
                <div class="card border-0 shadow-sm mb-4" style="height:400px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="card-title m-0">Facilities</div>

                            <!-- add facilities  -->
                            <div class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility">
                                <i class="bi bi-plus-square"></i>Add
                            </div>
                        </div>

                        <div class="table-responsive-md" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-hover border">
                                <thead class="sticky-top table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Fetching facilities
                                        $q="SELECT * FROM `facilities`";
                                        $data1=run_query($q);
                                        $i1=1;
                                        if ($data1) {
                                            while($row1=mysqli_fetch_assoc($data1))
                                            {
                                                echo "<tr>
                                                        <td>$i1</td>
                                                        <td>$row1[name]</td>
                                                        <td><img src='../images/facility/$row1[facility_image]' height=100px width=100px class='rounded'></td>
                                                        <td><button class='btn btn-danger btn-sm' type='button' onclick='rem_facility($row1[id])'>Delete</button></td>
                                                    </tr>";
                                                $i1++;
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- add Features Modal  -->
                <div class="modal fade" id="feature" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="" id="feature_form" class="feature_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Features</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label text-dark">Name</label>
                                        <input type="text" name="feature_name" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="from-label fw-bold">Add Image</label>
                                        <input type="file" name="feature_image" accept=".jpg, .png, .jpeg, .webp" class="form-control shadow-none my-3" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- add Facilities Modal  -->
                <div class="modal fade" id="facility" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="" id="facility_form" class="facility_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Facility</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label text-dark">Name</label>
                                        <input type="text" name="facility_name" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="from-label fw-bold">Add Image</label>
                                        <input type="file" name="facility_image" accept=".jpg, .png, .jpeg, .webp" class="form-control shadow-none my-3" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" name="submit1" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="/project/js/features.js"></script>