<?php
require('C:\xampp\htdocs\project\inc\config.php');
require('C:\xampp\htdocs\project\inc\essential.php');
login();

// assigning room
if(isset($_POST['assign_room'])){
    $frm_data=filter($_POST);

    $q="UPDATE `booking_info` SET `status`=?,`room_num`=? WHERE booking_id=?";

    $values=[0,$frm_data['room_no'],$frm_data['booking_id']];

    $res=insert($q,$values,'iii');
    if($res){
        echo 1;
    }else{
        echo 0;
    }
}

// canceling booking 
if(isset($_POST['cancel_booking'])){
    $frm_data=filter($_POST);
    $values=[$frm_data['cancel_booking']];

    $q="UPDATE `booking_info` SET `status`=-1 WHERE booking_id=?";
    $res=delete($q,$values,'i');
    echo $res;
}

// searching booking
if(isset($_POST['search_booking'])){
    $frm_data=filter($_POST);
    $q = "
    SELECT book.*, user.*,room.* FROM `booking_info` book
    INNER JOIN 
        `user_info` user ON book.user_id = user.id
    INNER JOIN 
        `room` room ON book.room_id = room.id WHERE user.user_name LIKE ?
     ORDER BY book.booking_id DESC";
    $res=selection($q,["%$frm_data[name]%"],'s');
    $i=1;
    // $data="";
    if (mysqli_num_rows($res) > 0) {
        while ($data = mysqli_fetch_assoc($res)) {
            $date = date('d-m-Y', strtotime($data['date']));
            $check_in_date = date('d-m-Y', strtotime($data['check_in']));
            $check_out_date = date('d-m-Y', strtotime($data['check_out']));
    
            if($data['status']==1){
                $status="<button type='button'class='btn btn-warning'>
                    <i class='bi bi-clock-fill me-3'></i>Pending
                </button>";
            }elseif($data['status']==0){
                $status="<button type='button'class='btn btn-success'>
                    <i class='bi bi-check-lg me-3'></i>Booked
                </button>";
            }else{
                $status="<button type='button'class='btn btn-Danger'>
                    <i class='bi bi-trash-fill me-3'></i>Deleted
                </button>";
            }
    
            echo "
                <tr>
                    <td>$i</td>
                    <td>
                        <span class='badge bg-primary fw-bold me-3'>Name :</span>$data[user_name]<br>
                        <span class='badge bg-primary fw-bold me-3'>Email :</span>$data[email]<br>
                        <span class='badge bg-primary fw-bold me-3'>Phone No :</span>$data[phoneno]<br>
                    </td>
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
                </tr>";
            $i++;
        }
    }
}

// searching bookings all
if(isset($_POST['search_details'])){
    $frm_data=filter($_POST);
    $q = "
    SELECT book.*, user.*,room.* FROM `booking_info` book
    INNER JOIN 
        `user_info` user ON book.user_id = user.id
    INNER JOIN 
        `room` room ON book.room_id = room.id
    WHERE book.status = 1 AND user.user_name LIKE ? ORDER BY book.booking_id";

    $res=selection($q,["%$frm_data[name]%"],'s');
    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) > 0) {
        while ($data = mysqli_fetch_assoc($res)) {
            $date = date('d-m-Y', strtotime($data['date']));
            $check_in_date = date('d-m-Y', strtotime($data['check_in']));
            $check_out_date = date('d-m-Y', strtotime($data['check_out']));

            echo "
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
}
?>