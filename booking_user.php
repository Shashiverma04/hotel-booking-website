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
    //checking login
    $login=0;
    if(isset($_SESSION['login']) && $_SESSION['login']==true){
        $login=1;
    }
    else{
        redirect('home.php');
    }
?>

<div class="my-5 px-4 p-4">
   <h2 class="fw-bold font2 text-center">Your Bookings</h2>
   <div class="hline bg-dark"></div>
</div>
<?php
    //getting user and room info using booking info
    $q = "
    SELECT book.*, user.*,room.* FROM `booking_info` book
    INNER JOIN 
        `user_info` user ON book.user_id = user.id
    INNER JOIN 
        `room` room ON book.room_id = room.id
        WHERE $_SESSION[uid]=book.user_id
     ORDER BY book.booking_id DESC";

    $res = run_query($q);
    $i = 1;
    $table_data = "";
    $status=''; //status of booking
    $action=''; //Deleting of booking
    if (mysqli_num_rows($res) > 0) {
        while ($data = mysqli_fetch_assoc($res)) {
            
            $date = date('d-m-Y', strtotime($data['date']));
            $check_in_date = date('d-m-Y', strtotime($data['check_in']));
            $check_out_date = date('d-m-Y', strtotime($data['check_out']));
            
            $action='';

            if($data['status']==1){
                $status="<button type='button'class='btn btn-warning'>
                            <i class='bi bi-clock-fill me-3'></i>Pending
                        </button>";
                $action="<button type='button'class='btn btn-outline-danger' onclick='cancel_booking($data[booking_id])'>
                            <i class='bi bi-trash-fill me-3'></i>Delete
                        </button>";
            }else if($data['status']==0){
                $status="<button type='button'class='btn btn-success'>
                            <i class='bi bi-check-lg me-3'></i>Booked
                        </button>";
            }else{
                $status="<button type='button'class='btn btn-danger'>
                            <i class='bi bi-trash-fill me-3'></i>Deleted
                        </button>";
            }
            $table_data.= "
                <tr>
                    <td>$i</td>
                    <td>
                        <span class='badge bg-primary fw-bold me-3'>Room Name :</span>$data[name]<br>
                        <span class='badge bg-primary fw-bold me-3'>Price : ₹</span>$data[price]<br>
                    </td>
                    <td>
                        <span class='badge bg-primary fw-bold me-3'>Check In :</span>$check_in_date<br>
                        <span class='badge bg-primary fw-bold me-3'>Check Out :</span>$check_out_date<br>
                        <span class='badge bg-primary fw-bold me-3'>Amount : ₹</span>$data[trans_amount]<br>
                        <span class='badge bg-primary fw-bold me-3'>Date :</span>$date<br>
                    </td>
                    <td>
                    $status
                    </td>
                    <td>
                    $action
                    </td>
                </tr>";
            $i++;
        }
    }else{
        $table_data="<tr>
            <td>No Bookings yet.......</td>
        </tr>";
    }
?>
<div class="card border-0 shadow-lg mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="card-title m-0">All Bookings</div>
        </div>
        <div class="tabe-responsive-md" style="overflow-y: auto; max-height:auto;">
            <table class="table table-responsive table-hover border table align-middle" style="max-height: 200px; overflow-y: auto;">
                <thead class="sticky-top table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Room Details</th>
                        <th scope="col">Booking Details</th>
                        <th scope="col">Status</th>
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
<?php require("inc/footer.php")?>

<script>

    //Cancel booking
    function cancel_booking(val) {
    if (confirm("Are you sure you want to cancel the booking?")) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/booking.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert("Booking Canceled");
                location.reload();
            } else {
                console.log("Error: " + xhr.responseText);
            }
        };
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("cancel_booking=" + val);
    }
}
</script>
</body>
</html>