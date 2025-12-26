<?php
    require('C:\xampp\htdocs\project\inc\config.php');
    require('C:\xampp\htdocs\project\inc\essential.php');

    if (isset($_POST['add_info'])) {
        
        $frm_data = filter($_POST);
        $values = [
            $frm_data['name'],
            $frm_data['email'],
            $frm_data['phone'],
            $frm_data['address'],
            $frm_data['pin'],
            $frm_data['DOB'],
            $frm_data['password']
        ];
        $phone=$frm_data['phone'];
        $email=$frm_data['email'];

        if($frm_data['password']!=$frm_data['c_password']){
            echo 'password_mismatch';
            exit;
        }

        //check user
        $user_exist=selection("SELECT * FROM `user_info` WHERE `email`=? OR `phoneno`=? LIMIT 1",[$email,$phone],'si');

        // deleted user registeration
        $deleted_user_exist=selection("SELECT * FROM `user_info` WHERE (`email`=? OR `phoneno`=?) AND user_status=0 LIMIT 1",[$email,$phone],'si');

        if(mysqli_num_rows($deleted_user_exist)>0){
            echo 'deleted_by_admin';
            exit;
        }
        if(mysqli_num_rows($user_exist)>0){
            echo 'User already Exists';
            exit;
        }
        
       //insert data
        $q = "INSERT INTO `user_info`(`user_name`, `email`, `phoneno`, `address`, `pincode`, `DOB`, `password`) VALUES (?,?,?,?,?,?,?)";
        $res = insert($q, $values, 'ssisiss');
        if ($res) {
            echo 'success';
        } else {
            echo 'Error';
        }
    }

    if (isset($_POST['login_user'])) {
        
        $frm_data = filter($_POST);
        $values = [
            $frm_data['email'],
            $frm_data['password'],
        ];

        $user_exist=selection("SELECT * FROM `user_info` WHERE `email`=? LIMIT 1",[$frm_data['email']],'s');
        $deleted_user_exist=selection("SELECT * FROM `user_info` WHERE `email`=? AND user_status=0 LIMIT 1",[$frm_data['email']],'s');
        $search=selection("SELECT * FROM `user_info` WHERE `email`=? AND `password`=?",[$frm_data['email'],$frm_data['password']],'ss');
        $user_data=mysqli_fetch_assoc($search);
        
        if(mysqli_num_rows($deleted_user_exist)>0){
            echo 'deleted_by_admin';
            exit;
        }else if(mysqli_num_rows($user_exist)==0){
            echo "User_doesnt_exist";
            exit;
        }else if(mysqli_num_rows($search)==0){
            echo "incorrect_password";
        }
        else{
            session_start();
            $_SESSION['login']=true;
            $_SESSION['uid']=$user_data['id'];
            $_SESSION['uName']=$user_data['user_name'];
            $_SESSION['uPhone']=$user_data['phoneno'];
            $_SESSION['uAddress']=$user_data['address'];
            echo 1;
        }
    }
?>
