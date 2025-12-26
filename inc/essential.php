<?php
//folder path for image
define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/');

//Room images
define('ROOM_Folder', 'project/images/Room/');
define('ROOM_IMAGE_PATH', 'images/Room/');

//Facilities images
define('FACILITY_Folder', 'project/images/facility/');
define('FACILITY_IMAGE_PATH', 'images/facility/');

//Features images
define('FEATURES_Folder', 'project/images/Features/');
define('FEATURES_IMAGE_PATH', 'images/Features/');

// redirect to another page 
function redirect($url){
    echo "<script>
    window.location.href='$url';
    </script>";
}

// admin login 
function login(){
    session_start();
    if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
        redirect('index.php');
    } 
}

// to upload image 
function upload_image($image,$folder){
    $valid=['image/jpeg','image/png','image/webp'];
    $img_typ=$image['type'];

    if(!in_array($img_typ,$valid)){
        return 'inv_img';
    }
    else if(($image['size']/(1024*1024))>2)
    {
        return 'inv_size';
    }
    else{
        $ext=pathinfo($image['name'],PATHINFO_EXTENSION);
        $r_name='img_'.random_int(1111,9999).".$ext";
        $img_path=UPLOAD_IMAGE_PATH.$folder.$r_name;
        if(move_uploaded_file($image['tmp_name'],$img_path)){
            return $r_name;
        }else{
            return 'upd_failed';
        }
        
    }
}
?>