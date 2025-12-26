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
    //getting user details
    $q="SELECT * FROM `user_info` where `id`=$_SESSION[uid]";
    $res=run_query($q);
    $data=mysqli_fetch_assoc($res);
?>
<div id="alert-update-container"></div>

<!-- Printing User Details  -->
<div class="my-5 px-4">
   <h2 class="fw-bold font2 text-center">Basic Information</h2>
   <div class="hline bg-dark"></div>
</div>
<div class="container">
    <div class="row">
        <div class="card shadow-lg">
            <div class="card-body">
                <form id="update_form">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <lable class="form-lable">Name: </lable>
                            <input name="name" type="text" class="form-control" value="<?php echo $data['user_name']?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <lable class="form-lable ps-0">Email : </lable>
                            <input type="email" name="email" class="form-control" value="<?php echo $data['email']?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <lable class="form-lable ps-0">Phone Number : </lable>
                            <input type="number" name="phone" class="form-control" value="<?php echo $data['phoneno']?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <lable class="form-lable ps-0">Address : </lable>
                            <textarea class="form-control" name="address" row="2" required><?php echo $data['address']?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <lable class="form-lable ps-0">Pin Code : </lable>
                            <input type="number" class="form-control" name="pin" value="<?php echo $data['pincode']?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <lable class="form-lable ps-0">Date of Birth : </lable>
                            <input type="date" class="form-control" name="DOB" value="<?php echo $data['DOB']?>" required>
                        </div>
                        <div class="d-flex text-center mb-4 mx-auto">
                            <button type="submit" class="btn btn-info fw-bold mt-3 " data-mdb-ripple-init data-mdb-ripple-color="dark">Update Details</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require("inc/footer.php")?>
<script>
    update_form=document.getElementById('update_form');

    update_form.addEventListener('submit',function(e){
        e.preventDefault();
        update();
    });

    // updating data
    function update(){
        let data=new FormData();
        data.append('name',update_form.elements['name'].value);
        data.append('email',update_form.elements['email'].value);
        data.append('phone',update_form.elements['phone'].value);
        data.append('address',update_form.elements['address'].value);
        data.append('pin',update_form.elements['pin'].value);
        data.append('DOB', update_form.elements['DOB'].value);

        data.append('update','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/project/ajax/profile.php", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.responseText== 'email_already_exists') {
                    alert_send("alert-update-container","error","Email Already exist");
                } else if (xhr.responseText == "num_already_exists") {
                    alert_send("alert-update-container","error","Phone number already exist");
                } else if (xhr.responseText == 1) {
                    alert("Info Updated successfully!");
                    update_form.reset();
                    location.reload();
                } else {
                    alert_send("alert-update-container","error","Unexpected response from the server.");
                    console.log(xhr.responseText);
                }
            } else {
                alert_send("alert-update-container","error","Error Updating. Please try again.");
                console.log("Error:", xhr.status, xhr.responseText);
            }
        };
        xhr.send(data);
    }
</script>
</body>
</html>