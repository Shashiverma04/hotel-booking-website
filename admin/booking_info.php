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

<?php

    // getting info of user room and booking
    $q = "
        SELECT book.*, user.*,room.* FROM `booking_info` book
        INNER JOIN 
            `user_info` user ON book.user_id = user.id
        INNER JOIN 
            `room` room ON book.room_id = room.id
        WHERE book.status = 1 ORDER BY book.booking_id";

    $res = run_query($q);
    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) > 0) {
        while ($data = mysqli_fetch_assoc($res)) {
            $date = date('d-m-Y', strtotime($data['date']));
            $check_in_date = date('d-m-Y', strtotime($data['check_in']));
            $check_out_date = date('d-m-Y', strtotime($data['check_out']));

            // printing table data
            $table_data .= "
                <tr>
                    <td>$i</td>
                    <td>
                        <span class='badge bg-primary fw-bold me-3'>Name :</span>{$data['user_name']}<br>
                        <span class='badge bg-primary fw-bold me-3'>Email :</span>{$data['email']}<br>
                        <span class='badge bg-primary fw-bold me-3'>Phone No :</span>{$data['phoneno']}<br>
                    </td>
                    <td>
                        <span class='badge bg-primary fw-bold me-3'>Room Name :</span>{$data['name']}<br>
                        <span class='badge bg-primary fw-bold me-3'>Price : ₹</span>{$data['price']}<br>
                    </td>
                    <td>
                        <span class='badge bg-primary fw-bold me-3'>Check In :</span>$check_in_date<br>
                        <span class='badge bg-primary fw-bold me-3'>Check Out :</span>$check_out_date<br>
                        <span class='badge bg-primary fw-bold me-3'>Amount : ₹</span>{$data['trans_amount']}<br>
                        <span class='badge bg-primary fw-bold me-3'>Date :</span>$date<br>
                    </td>
                    <td>
                        <button type='button' onclick='assign_room($data[booking_id])' class='btn btn-info' data-bs-toggle='modal' data-bs-target='#assign_room'>
                            <i class='bi bi-check-square-fill me-3'></i>Assign Room
                        </button><br>
                        <button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-danger mt-3 btn-sm'>
                            <i class='bi bi-trash-fill me-3'></i>Cancel Booking
                        </button>
                    </td>
                </tr>";
            $i++;
        }
    }
?>

<body>
    <div class="container-fluid bg-dark text-light p-3 d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Admin Panel</h3>
        <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
    </div>
    <div class="container-fluid">
        <div class="row ">

            <!-- vertical nav bar -->
            <div class="col-lg-2 bg-dark position-sticky dashboard-menu " style=" position: fixed;">
                <div class="list-group list-group-flush mx-3 mt-4 py-4">
                    <a href="dashboard.php" class="list-group-item list-group-item-action py-2 ripple text-white-50">
                        <i class="fas fa-chart-area fa-fw me-3"></i><span>Dashboard</span>
                    </a>
                    <a class="list-group-item list-group-item-action py-2 ripple text-white-50" data-bs-toggle="collapse" href="#booking_link" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="bi bi-cart-fill me-3"></i><span>Booking</span><i class="bi bi-caret-down-square-fill ms-3"></i>
                    </a>
                    <div class="collapse" id="booking_link">
                        <div class="card card-body bg-dark p-0 ">
                            <a href="booking_info.php" class="list-group-item rounded-0 list-group-item-action active py-2 ripple text-white-50">
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

            <!-- side pane -->
            <div class="col-lg-10 ms-auto p-4 overflow-hidden" style="margin-top: 24px;">
                <h3 class="mb-4">Confirm Bookings</h3>
                <div class="card border-0 shadow-lg mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="card-title m-0">Confirm Bookings</div>
                            <div class="text-end mb-3">
                                <!-- searching  -->
                                <form class="d-flex" role="search">
                                    <input class="form-control me-2" oninput="search_details(this.value)" type="search" placeholder="Search" aria-label="Search">
                                </form>
                            </div>
                        </div>
                        <div class="tabe-responsive-md" style="overflow-y: auto; max-height:auto;">
                            <!-- booking info  -->
                            <table class="table table-hover border">
                                <thead class="sticky-top table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room Details</th>
                                        <th scope="col">Booking Details</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table_data">
                                    <?php
                                    echo $table_data;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assign Room modal  -->
            <div class="modal fade" id="assign_room" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="" id="assign_room_form">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Assign Room</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label text-dark">Room number</label>
                                    <input type="number" name="room_num" class="form-control shadow-none" required>
                                </div>
                                <span class="badge mb-3 bg-light-subtle text-danger text-wrap lh-base">
                                    Assign Room Number only when user has arrived.
                                </span>
                                <input type="hidden" name="booking_id">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Assign</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let assign_room_form=document.getElementById('assign_room_form');

        // assigning room id to the form
        function assign_room(id){
            assign_room_form.elements['booking_id'].value=id;
        }

        assign_room_form.addEventListener('submit',function(e){
            e.preventDefault();

            let data=new FormData();
            data.append('room_no',assign_room_form.elements['room_num'].value);
            data.append('booking_id',assign_room_form.elements['booking_id'].value);
            data.append('assign_room','');
            
            let xhr=new XMLHttpRequest();
            xhr.open("POST","../ajax/booking.php",true);

            xhr.onload=function(){
                if(this.responseText==1){
                    alert('Room number alloted! Booking Finalized');
                    assign_room_form.reset();
                }else{
                    alert("Server Down!!");
                }
                window.location.reload();
            }
            xhr.send(data);
        
        })

        // cancel booking
        function cancel_booking(val) {
        if (confirm("Are you sure you want to cancel the booking?")) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../ajax/booking.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert("Booking Canceled");
                    location.reload();
                } else {
                    alert("Error: " + xhr.responseText);
                }
            };
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("cancel_booking=" + val);
        }
    }

        // searching bookings
        function search_details(str){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../ajax/booking.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('table_data').innerHTML=this.responseText
            } else {
                alert("Error: " + xhr.responseText);
            }
        };
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("search_details&name="+str);

    }
</script>
</body>
</html>
