<?php
require('C:\xampp\htdocs\project\inc\config.php');
require('C:\xampp\htdocs\project\inc\essential.php');
    session_start();
    if (isset($_POST['update'])) {
        
        $frm_data = filter($_POST);
        $values = [
            $frm_data['name'],
            $frm_data['email'],
            $frm_data['phone'],
            $frm_data['address'],
            $frm_data['pin'],
            $frm_data['DOB'],
        ];

        $phone=$frm_data['phone'];
        $email=$frm_data['email'];

        //check user
        $email_exist=selection("SELECT * FROM `user_info` WHERE `email`=? AND `id`!=$_SESSION[uid] LIMIT 1",[$email],'s');
        $num_exist=selection("SELECT * FROM `user_info` WHERE `phoneno`=? AND `id`!=$_SESSION[uid] LIMIT 1",[$phone],'i');
            
        if(mysqli_num_rows($email_exist)>0){
            echo 'email_already_exists';
            exit;
        }
        if(mysqli_num_rows($num_exist)>0){
            echo 'num_already_exists';
            exit;
        }

       //insert data
        $q = "UPDATE `user_info` SET `user_name`=?, `email`=?, `phoneno`=?, `address`=?, `pincode`=?, `DOB`=?  WHERE id=$_SESSION[uid]";

        $res = insert($q, $values, 'ssisis');
        $q1=selection("SELECT * FROM `user_info` WHERE id=?",[$_SESSION['uid']],'i');
        $data=mysqli_fetch_assoc($q1);
        if ($res) {
            $_SESSION['uName']=$data['user_name'];
            $_SESSION['uPhone']=$data['phoneno'];
            $_SESSION['uAddress']=$data['address'];
            echo 1;
            
        } else {
            echo 0;
        }
    }
?>