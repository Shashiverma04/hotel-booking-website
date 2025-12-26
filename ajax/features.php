<?php
require('C:\xampp\htdocs\project\inc\config.php');
require('C:\xampp\htdocs\project\inc\essential.php');
login();

if (isset($_POST['add_feature'])) {
    $frm_data = filter($_POST);
    $img=upload_image($_FILES['image'],FEATURES_Folder);
    $q="INSERT INTO `features`(`name`,`features_image`) VALUES (?,?)";

    $status='';
    $values=[$frm_data['name'],$img];
    
    if($img=='inv_img'){
        $status=$img;
    } else if($img=='inv_size'){
        $status=$img;
    }else if($img=='upd_failed'){
        $status=$img;
    }else{
        $res=insert($q,$values,'ss');
        if($res)
        {
            $status='success';
        }else{
            $status='error';
        }
    }
    echo json_encode(['status'=>$status]);
}

if(isset($_POST['rem_feature'])){
    $frm_data=filter($_POST);
    $values=[$frm_data['rem_feature']];

    $q="DELETE FROM `features` WHERE `id`=?";
    $res=delete($q,$values,'i');
    echo $res;
}

if (isset($_POST['add_facility'])) {
    $frm_data = filter($_POST);
    $img=upload_image($_FILES['image'],FACILITY_Folder);
    $q="INSERT INTO `facilities`(`name`,`facility_image`) VALUES (?,?)";

    $status='';
    $values=[$frm_data['name'],$img];

    if($img=='inv_img'){
        $status=$img;
    } else if($img=='inv_size'){
        $status=$img;
    }else if($img=='upd_failed'){
        $status=$img;
    }else{
        $res=insert($q,$values,'ss');
        if($res)
        {
            $status='success';
        }else{
            $status='error';
        }
    }
    echo json_encode(['status'=>$status]);
}

if(isset($_POST['rem_facility'])){
    $frm_data=filter($_POST);
    $q="DELETE FROM `facilities` WHERE `id`=$frm_data[rem_facility]";
    $res=run_query($q);
    echo $res;
}

?>
