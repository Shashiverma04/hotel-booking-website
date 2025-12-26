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
        <div class="row " >
        
            <!-- Vertical Navbar -->
            <div class="col-lg-2 bg-dark position-sticky dashboard-menu" style="height:inherit;">
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
                    <a href="rooms.php" class="list-group-item list-group-item-action py-2 active ripple  text-white-50">
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

            <!-- side panel -->
            <div class="col-lg-10 ms-auto p-4 overflow-hidden" style="margin-top: 24px;">
                <h3 class="mb-4">Rooms</h3>

                <!-- Room  -->
                <div class="card border-0 shadow-lg mb-4" style="height:550px;">
                    <div class="card-body">
                        <div class="text-end mb-3">
                            <div class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#room">
                                <i class="bi bi-plus-square"></i>Add
                            </div>
                        </div>
                        <div class="tabe-responsive-lg" style="max-height: 450px; overflow-y: auto;">
                            <table class="table table-hover border">
                                <thead class="sticky-top table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Guest</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- fetching room data -->
                                    <?php
                                        $q="SELECT * FROM `room`";
                                        $data=run_query($q);
                                        $i=1;
                                        if ($data) {
                                            while($row=mysqli_fetch_assoc($data))
                                            {
                                                // room active inactive status
                                                if($row['room_status']==1){
                                                    $status="<button class='btn btn-success btn-sm' onclick='toggleStatus($row[id],0)'>Active</button>";
                                                }else{
                                                    $status="<button class='btn btn-secondary btn-sm' onclick='toggleStatus($row[id],1)'>Inactive</button>";
                                                }

                                                // printing room details
                                                echo "<tr class='room-data'>
                                                        <td>$i</td>
                                                        <td>$row[name]</td>
                                                        <td>$row[area] sq.ft.</td>
                                                        <td>
                                                            <span class='badge rounded-pill bg-light text-dark'>
                                                            Adult : $row[adult]
                                                            </span>
                                                            <span class='badge rounded-pill bg-light text-dark'>
                                                            Child : $row[children]
                                                            </span>
                                                        </td>
                                                        <td>₹ $row[price]</td>
                                                        <td>$row[quantity]</td>
                                                        <td>$status</td>
                                                        <td>
                                                        <div class=' mb-3'>
                                                            <div class='btn btn-secondary shadow-none btn-sm' data-bs-toggle='modal' onclick='edit($row[id])' data-bs-target='#editroom'>
                                                                <i class='bi bi-pencil-square'></i>
                                                            </div>
                                                            <div class='btn btn-primary shadow-none btn-sm' onclick=\"room_image($row[id],'$row[name]')\" data-bs-toggle='modal' data-bs-target='#imageroom'>
                                                                <i class='bi bi-image'></i>
                                                            </div>
                                                        </div>
                                                        </td>
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
                
                <!-- Adding Room Modal  -->
                <div class="modal modal-lg fade" id="room" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="" id="room_form" class="facility_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Room</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Name</label>
                                            <input type="text" name="room_name" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Area</label>
                                            <input type="number" min="1" name="area" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Price</label>
                                            <input type="number" min="1" name="price" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Quantity</label>
                                            <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Adult (Max.) </label>
                                            <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Children (Max.)</label>
                                            <input type="number" min="1" name="child" class="form-control shadow-none" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-dark">Features</label>
                                            <div class="row">
                                                <?php
                                                    // fetching features to fill checkbox
                                                    $q="SELECT * FROM `features`";
                                                    $res=run_query($q);
                                                    while($opt=mysqli_fetch_assoc($res))
                                                    {
                                                        echo "
                                                        <div class='col-md-3'>
                                                            <label>
                                                                <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                                                $opt[name]
                                                            </label>
                                                        </div>
                                                        ";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-dark">Facilities</label>
                                            <div class="row">
                                                <?php

                                                    // fetching facilities to fill checkbox
                                                    $q="SELECT * FROM `facilities`";
                                                    $res=run_query($q);
                                                    while($opt=mysqli_fetch_assoc($res))
                                                    {
                                                        echo "
                                                        <div class='col-md-3'>
                                                            <label>
                                                                <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                                                                $opt[name]
                                                            </label>
                                                        </div>
                                                        ";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    
                                        <div class="mb-3">
                                            <label class="form-label text-dark">Description</label>
                                            <textarea name="description" class="form-control shadow-none" rows="4" required></textarea>
                                        </div>
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

                <!-- edit room modal  -->
                <div class="modal modal-lg fade" id="editroom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="" id="edit_form" class="facility_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Room</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Name</label>
                                            <input type="text" name="room_name" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Area</label>
                                            <input type="number" min="1" name="area" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Price</label>
                                            <input type="number" min="1" name="price" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Quantity</label>
                                            <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Adult (Max.) </label>
                                            <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-dark">Children (Max.)</label>
                                            <input type="number" min="1" name="child" class="form-control shadow-none" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-dark">Features</label>
                                            <div class="row">
                                                <?php
                                                    // fetching features to fill checkbox autotmatically
                                                    $q="SELECT * FROM `features`";
                                                    $res=run_query($q);
                                                    while($opt=mysqli_fetch_assoc($res))
                                                    {
                                                        echo "
                                                        <div class='col-md-3'>
                                                            <label>
                                                                <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                                                $opt[name]
                                                            </label>
                                                        </div>
                                                        ";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-dark">Facilities</label>
                                            <div class="row">
                                                <?php

                                                    // fetching facilities to fill checkbox autotmatically
                                                    $q="SELECT * FROM `facilities`";
                                                    $res=run_query($q);
                                                    while($opt=mysqli_fetch_assoc($res))
                                                    {
                                                        echo "
                                                        <div class='col-md-3'>
                                                            <label>
                                                                <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                                                                $opt[name]
                                                            </label>
                                                        </div>
                                                        ";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    
                                        <div class="mb-3">
                                            <label class="form-label text-dark">Description</label>
                                            <textarea name="description" class="form-control shadow-none" rows="4" required></textarea>
                                        </div>
                                        <input type="hidden" name="room_id">
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

                <!-- room image modal  -->
                <div class="modal fade" id="imageroom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="head_name">Room Name</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-3">
                            <form action="" id="imageform">
                                <label class="from-label fw-bold">Add Image</label>
                                <input type="file" name="room_image" id="room_image" accept=".jpg, .png, .jpeg, .webp" class="form-control shadow-none my-3" required>
                                <button type="submit" name="submit1" class="btn btn-primary my-2">Add</button>
                                <input type="hidden" name="room_id">
                            </form>
                        </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="/project/js/room.js"></script>
