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
    <title>Admin Panel- Queries</title>
</head>


<body>
    <div class="container-fluid bg-dark text-light p-3 d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Admin Panel</h3>
        <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
    </div>

    <div class="container-fluid">
        <div class="row ">
    
        <!-- Vertical Navbar -->
        <div class="col-lg-2 bg-dark position-sticky dashboard-menu" style=" position: fixed;">
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
                   <a href="users.php" class="list-group-item list-group-item-action py-2 ripple text-white-50">
                        <i class="bi bi-person-fill me-3"></i><span>Users</span>
                    </a>
                    <a href="user_queries.php" class="list-group-item list-group-item-action active py-2 ripple text-white-50">
                        <i class="bi bi-patch-question-fill me-3"></i><span>User-Queries</span>
                    </a>
                </div>
            </div>

            <!-- Side Panel -->
            <div class="col-lg-10 ms-auto p-4 overflow-hidden" style="margin-top: 24px;">
                <h3 class="mb-4">User Queries</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="tabel-responsive-md" style="height:450px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Message</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        //Fetching queries data 
                                        $q="SELECT * FROM `cus_queries` ORDER BY `sr_no` DESC";
                                        $data=run_query($q);
                                        $i=1;
                                        $read_button='';
                                        if ($data) {
                                            while($row=mysqli_fetch_assoc($data))
                                            {
                                                //checking if queries are reviewed or not
                                                if(!$row['status']){
                                                    $read_button="<button class='btn btn-Success btn-sm me-3' type='button' onclick='read($row[sr_no])'>Mark as Read</button>";
                                                }

                                                // printing query data
                                                echo "<tr>
                                                        <td>$i</td>
                                                        <td>$row[Name]</td>
                                                        <td>$row[email]</td>
                                                        <td>$row[subject]</td>
                                                        <td>$row[message]</td>
                                                        <td>$row[date]</td>
                                                        <td>
                                                            $read_button
                                                            <button class='btn btn-danger btn-sm' type='button' onclick='rem_q($row[sr_no])'>Delete</button>
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
            </div>
        </div>
    </div>
</body>
<script>

// Reviewing user query
function read(num){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/users.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            if(xhr.responseText==1){
                alert("Query Read");
                location.reload();
            }else{
                alert("Server not working. Please try again later");
            }

        } else {
            alert("Error: " + xhr.responseText);
        }
    };
    xhr.send('read&id=' + num);
}

// delete user query 
function rem_q(num){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/users.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            if(xhr.responseText==1){
                alert("Query Deleted");
                location.reload();
            }else{
                alert("Server not working. Please try again later");
            }

        } else {
            alert("Error: " + xhr.responseText);
        }
    };
    xhr.send('rem_q&id=' + num);
}

</script>
</html>
