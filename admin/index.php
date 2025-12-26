<?php 
require('../inc/config.php');
require('../inc/essential.php');
session_start();
if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']== true)){
    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        .login{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            width :350px;
        }
    </style>
    <?php require("../inc/links.php") ?>
</head>
<body class="bg-light">
    <div class="login text-center shadow-lg bg-white ">
        <form method="POST">
            <h4 class="bg-dark text-light p-3">ADMIN LOGIN PANEL</h4>
            <div class="mb-4 mt-4 px-3">
                <input name="admin_name" type="TEXT" required class="form-control shadow-sm text-center border border-dark" placeholder="Admin Name">
            </div>
            <div class="mb-4 mt-4 px-3">
                <input name="admin_pass" type="password" required class="form-control shadow-sm text-center border border-dark" placeholder="Password">
            </div>
            <button name="login" type="submit" class="btn btn-dark text-center mb-4" data-mdb-ripple-init>Login</button>
        </form>
    </div>

    <?php
    if(isset($_POST['login'])){
        $frm=filter($_POST);
        $query='SELECT * FROM `admin_info` WHERE `admin_name`=? AND `admin_pass`=? ';
        $value=[$frm['admin_name'], $frm['admin_pass']];
        $res=selection($query,$value,"ss");
        if($res->num_rows==1){
            $row=mysqli_fetch_assoc($res);
            $_SESSION['adminLogin']=true;
            redirect('dashboard.php');
        }else{
            alert_send('error','Invalid Credentials, Please Try again!!! ');
        }
    }
    ?>
</body>

</html>