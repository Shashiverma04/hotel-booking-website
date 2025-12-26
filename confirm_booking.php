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
    //checking room id
    if(!isset($_GET['id'])){
        redirect('room.php');
    }

    // checking login 
    $login=0;
    if(isset($_SESSION['login']) && $_SESSION['login']==true){
        $login=1;
    }
    else{
        redirect('room.php');
    }
    
    $data=filter($_GET);
    $res=run_query("SELECT * FROM `room` WHERE `id`=$data[id] AND `room_status`=1");

    //checking if room is active
    if(mysqli_num_rows($res)==0){
        redirect('room.php');
    }

    $room_data=mysqli_fetch_assoc($res);

    $book_btn="<button onclick='check_login($login,$data[id])' class='btn btn-dark fw-bold p-3 w-100 mb-3' data-mdb-ripple-init data-mdb-ripple-color='dark'>Book Now</button>";

    //creating room session
    $_SESSION['room']=[
        'id'=>$room_data['id'],
        'name'=>$room_data['name'],
        'price'=>$room_data['price'],
        'days'=>0,
        'payment'=>null,
        'available'=>false
    ];

    //Getting Room image
    $img=run_query("SELECT * FROM `room_image` WHERE `room_id`=$data[id]");
    if(mysqli_num_rows($img)){
        $img_res=mysqli_fetch_assoc($img);
        $room_img=ROOM_IMAGE_PATH.$img_res['image'];
    }
?>

<div class='container'>
    <div class='row justify-content-evenly mb-5 py-4'>

        <!-- Printing Room Details  -->
        <div class='col-lg-7 shadow-m p-5'>
            <?php
                echo<<<data
                    <div class="card p-3 shadow-sm rounded">
                        <img src=$room_img class="img-fluid mb-4 rounded" height='400px' class="w-100">
                        <h5>$room_data[name]</h5>
                        <h6 class='mb-2'>₹ $room_data[price] per night</h6>
                    </div>
                data
            ?>
        </div>

        <!-- Printing Booking Details  -->
        <div class='col-lg-5 shadow-lg p-5' style="height: auto;  display: flex; " >
            <div class='card-body align-items-center' style="height: auto; min-height: 100px; ">
                <form  id="booking_form" >
                    <h4 class="mb-3">BOOKING DETAILS</h4>
                    <div class="row ">
                        <div class="col-md-12 mb-4">
                            <label class="form-lable">Name: </label>
                            <input name="name" type="text" value="<?php echo $_SESSION['uName'] ?>" class="form-control mt-2" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-lable">Phone Number: </label>
                            <input name="phone" type="number" value="<?php echo $_SESSION['uPhone'] ?>" class="form-control mt-2" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-lable">Address : </label>
                            <textarea class="form-control mt-2" name="address" rows="2" required><?php echo $_SESSION['uAddress'] ?></textarea>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="form-label text-info">Check-In : </div>
                            <input type="date" name="check_in" class="form-control mt-2" onchange="check_availability()" required>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="form-label text-info">Check-Out : </div>
                            <input type="date" name="check_out" class="form-control mt-2" onchange="check_availability()" required>
                        </div>
                        <div class="col-12">
                            <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                <span class="visually-hidden">Loading</span>
                            </div>
                            <h6 class="text-danger mb-2" id="pay_info">Please enter Check-in & Check-out date!</h6>
                            <button name="pay_now" class='btn btn-dark fw-bold p-3 w-100 mt-3' data-mdb-ripple-init data-mdb-ripple-color='dark' data-bs-toggle="modal" data-bs-target="#staticBackdrop" disabled>Continue</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- PAYMENT MODAL  -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <?php
                            echo<<<data
                                <div class="card p-3 shadow-sm rounded">
                                    <img src=$room_img class="img-fluid mb-4 rounded" height='400px' class="w-100">
                                    <h5>$room_data[name]</h5>
                                    <h6 class='mb-2'>₹ $room_data[price] per night</h6>
                                </div>
                            data
                        ?>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col" id="reciept" ></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h2>Press Confirm to Confirm Booking.....</h2>
                                <h3>Thankyou for choosing us.</h3>
                                <h3>You can Pay this amount at time of check in.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="pay_now()" class="btn btn-secondary" data-bs-dismiss="modal">Confirm</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
    let booking_form=document.getElementById('booking_form');
    let payment_form=document.getElementById('payment_form');
    let info_loader=document.getElementById('info_loader');
    let pay_info=document.getElementById('pay_info');

    booking_form.addEventListener('submit',function(e){
        e.preventDefault();
    });

    //Check if room available
    function check_availability(){
        let check_in=booking_form.elements['check_in'].value;
        let check_out=booking_form.elements['check_out'].value;

        booking_form.elements['pay_now'].setAttribute('disabled',true);

        if(check_in!='' && check_out!=''){
            pay_info.classList.add('d-none');
            pay_info.classList.replace('text-dark','text-danger');
            info_loader.classList.remove('d-none');
            let reciept=document.getElementById('reciept');

            let data=new FormData();

            data.append('check_availability','');
            data.append('check_in',check_in);
            data.append('check_out',check_out);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/project/ajax/confirm_booking.php", true);

            xhr.onload = function () {
                console.log(this.responseText);
                if (xhr.status === 200) {
                    let data=JSON.parse(this.responseText);

                    if(data.status=='check_in_out_equal'){
                        pay_info.innerText="You cannot Check_in and Check out on same day !";
                    }
                    else if(data.status=='check_out_earlier'){
                        pay_info.innerText="Check_out date is earlier than Check_in date ! ";
                    }
                    else if(data.status=='check_in_earlier'){
                        pay_info.innerText="Check_in date is earlier than Current_date ! ";
                    }
                    else if(data.status=='Unavailable'){
                        pay_info.innerText="Room not available ! ";
                    }
                    else{
                        pay_info.classList.replace('text-danger','text-dark');
                        pay_info.innerHTML="No. of Days: "+data.days+" <br>Total amount to pay: ₹"+data.payment; 
                        reciept.innerHTML+="<div class='card p-3 shadow-sm rounded'><h5>Reciept Summary</h5><div class='row'><h6 class='col-6 mb-2'>₹ "+"<?php echo $_SESSION['room']['price']?>"+" x "+data.days+" night </h6>"+"<h6 class='col-6 mb-2'>₹ "+data.payment+"</h6>"+"<h6 class='col-6 mb-2'> Total: </h6><h6 class='col-6 mb-2'> ₹ "+data.payment+"</h6>"+"</div></div>";
                        booking_form.elements['pay_now'].removeAttribute('disabled');
                    }
                    pay_info.classList.remove('d-none');
                    info_loader.classList.add('d-none');
                } else {
                    alert("Error adding info. Please try again.");
                    console.log("Error:", xhr.status, xhr.responseText);
                }
            };
            xhr.send(data);
        }
    }

    //Payment modal working
    function pay_now(){
        let check_in=booking_form.elements['check_in'].value;
        let check_out=booking_form.elements['check_out'].value;

            let data=new FormData();

            data.append('pay_now','');
            data.append('check_in',check_in);
            data.append('check_out',check_out);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/project/ajax/confirm_booking.php", true);

            xhr.onload = function () {
                console.log("Raw Response:", this.responseText); 
                
                if (xhr.status === 200) {
                    let data=JSON.parse(this.responseText);

                    if(data.status==='success'){
                        alert("Booking Confirmed");
                        window.location.href='home.php';
                    }else{
                        alert('Error please try again later');
                    }
                } else {
                    alert("Error adding info. Please try again.");
                    console.log("Error:", xhr.status, xhr.responseText);
                }
            };
            xhr.send(data);
    }

    
</script>
<?php require("inc/footer.php")?>
</body>
</html>