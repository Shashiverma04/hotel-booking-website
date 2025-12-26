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
            <!-- Vertical nav bar -->
            <div class="col-lg-2 bg-dark position-sticky dashboard-menu" style="position:absolute;">
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
                    <a href="features.php" class="list-group-item list-group-item-action py-2 ripple  text-white-50">
                        <i class="bi bi-wifi me-3"></i><span>Features</span>
                    </a>
                   <a href="users.php" class="list-group-item list-group-item-action active py-2 ripple text-white-50">
                        <i class="bi bi-person-fill me-3"></i><span>Users</span>
                    </a>
                    <a href="user_queries.php" class="list-group-item list-group-item-action py-2 ripple text-white-50">
                        <i class="bi bi-patch-question-fill me-3"></i><span>User-Queries</span>
                    </a>
                </div>
            </div>

            <!-- side pane  -->
            <div class="col-lg-10 ms-auto p-4 overflow-hidden" style="margin-top: 24px;">
                <h3 class="mb-4">Users</h3>
                <div class="card border-0 shadow-lg mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="card-title m-0">Users</div>
                            <div class="text-end mb-3">
                                <!-- searching option -->
                                <form class="d-flex" role="search">
                                    <input class="form-control me-2" oninput="search_user(this.value)" type="search" placeholder="Search" aria-label="Search">
                                </form>
                            </div>
                        </div>

                        <!-- user details  -->
                        <div class="tabe-responsive-md" style="overflow-y: auto; max-height:auto;">
                            <table class="table table-hover border">
                                <thead class="sticky-top table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone NO.</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Pin Code</th>
                                        <th scope="col">DOB</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="user_data">
                                    <?php
                                    //fetching user details 
                                        $q="SELECT * FROM `user_info`";
                                        $data=run_query($q);
                                        $i=1;
                                        $status='';
                                        $delete='';
                                        if ($data) {
                                            while($row=mysqli_fetch_assoc($data))
                                            {
                                                $status='';
                                                $delete='';
                                                if($row['user_status']==1){
                                                    $status="<button class='btn btn-success btn-sm'>Active</button>";
                                                    $delete="<button class='btn btn-danger btn-sm' type='button' onclick='rem_user($row[id])'>Delete</button>";
                                                }else{
                                                    $status="<button class='btn btn-primary btn-sm'>Deleted</button>";
                                                    $delete="<button class='btn btn-success btn-sm' type='button' onclick='rem_user($row[id])'>Activate</button>";
                                                }

                                                // printing user details
                                                echo "<tr>
                                                        <td>$i</td>
                                                        <td>$row[user_name]</td>
                                                        <td>$row[email]</td>
                                                        <td>$row[phoneno]</td>
                                                        <td>$row[address]</td>
                                                        <td>$row[pincode]</td>
                                                        <td>$row[DOB]</td>
                                                        <td>$status</td>
                                                        <td>$delete</td>
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
            </div>
        </div>
    </div>
</body>
</html>
<script>

    //remove or activate user
    function rem_user(val) {
    if (confirm("Are you sure you want to delete or activate this user?")) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../ajax/users.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert(xhr.responseText);
                location.reload();
            } else {
                alert("Error: " + xhr.responseText);
            }
        };
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("rem_user=" + val);
    }
}

    // live search of user
    function search_user(str){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../ajax/users.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('user_data').innerHTML=this.responseText
            } else {
                alert("Error: " + xhr.responseText);
            }
        };
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("search_user&name="+str);

    }
</script>
