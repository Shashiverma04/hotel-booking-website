<?php
require('../inc/config.php');
require('../inc/essential.php');


if (isset($_POST['add_room'])) {
    $frm_data = filter($_POST);
    $features = filter(json_decode($_POST['features']));
    $facilities = filter(json_decode($_POST['facilities']));

    $values = [
        $frm_data['name'],
        $frm_data['area'],
        $frm_data['price'],
        $frm_data['quantity'],
        $frm_data['adult'],
        $frm_data['child'],
        $frm_data['description'],
        1
    ];
    $q = "INSERT INTO `room` (`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `room_status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $res = insert($q, $values, 'siiiiisi');

    $room_id = mysqli_insert_id($con);
        $q2 = "INSERT INTO `room_features` (`room_id`, `features_id`) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($con, $q2)) {
            foreach ($features as $f) {
                mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }

        $q3 = "INSERT INTO `room_facility` (`room_id`, `facility_id`) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($con, $q3)) {
            foreach ($facilities as $f) {
                mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
    
}

if(isset($_POST['toggleStatus'])){
    $frm_data=filter($_POST);
    $q="UPDATE `room` SET `room_status`=? WHERE `id`=?";
    $values=[$frm_data['value'],$frm_data['toggleStatus']];

    $res=insert($q,$values,'ii');
    echo $res;
}

if(isset($_POST['get_detail'])){
    $frm_data=filter($_POST);
    $values=$frm_data['get_detail'];
    $q="SELECT * FROM `room` WHERE `id`=$values";
    $q1="SELECT * FROM `room_features` WHERE `room_id`=$values";
    $q2="SELECT * FROM `room_facility` WHERE `room_id`=$values";
    
    $res=run_query($q);
    $res1=run_query($q1);
    $res2=run_query($q2);

    $features=[];
    $facilities=[];

    $room_data=mysqli_fetch_assoc($res);

    if(mysqli_num_rows($res1)>0){
        while($row=mysqli_fetch_assoc($res1)){
            array_push($features,$row['features_id']);
        }
    }

    if(mysqli_num_rows($res2)>0){
        while($row=mysqli_fetch_assoc($res2)){
            array_push($facilities,$row['facility_id']);
        }
    }

    $data=["room_data" => $room_data, "features" => $features, "facilities" => $facilities];
    $data=json_encode($data);
    echo $data;
}

if(isset($_POST['update_room'])){
    $frm_data = filter($_POST);

    $features = filter(json_decode($_POST['features']));
    $facilities = filter(json_decode($_POST['facilities']));
    
    $flag=0;

    $values = [
        $frm_data['name'],
        $frm_data['area'],
        $frm_data['price'],
        $frm_data['quantity'],
        $frm_data['adult'],
        $frm_data['child'],
        $frm_data['description'],
        $frm_data['room_id']
    ];
    
    $q = "UPDATE `room` SET `name`=?,`area`=?,`price`=?,`quantity`=?,`adult`=?,`children`=?,`description`=? WHERE `id`=?";
    $res = insert($q, $values, 'siiiiisi');
    if($res){
        $flag=1;
    }

    $del_feature=delete("DELETE FROM `room_facility` WHERE `room_id`=?",[$frm_data['room_id']],'i');
    $del_facility=delete("DELETE FROM `room_features` WHERE `room_id`=?",[$frm_data['room_id']],'i');

    if(!($del_facility && $del_feature)){
        $flag=0;
    }

    $room_id =$frm_data['room_id'];
    $q2 = "INSERT INTO `room_features` (`room_id`, `features_id`) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($con, $q2)) {
        foreach ($features as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        $flag=1;
        mysqli_stmt_close($stmt);
    }

    $q3 = "INSERT INTO `room_facility` (`room_id`, `facility_id`) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($con, $q3)) {
        foreach ($facilities as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        $flag=1;
        mysqli_stmt_close($stmt);
    }
}

if(isset($_POST['add_image'])){
    $frm_data=filter($_POST);
    $img=upload_image($_FILES['image'],ROOM_Folder);
    $room_id=$frm_data['room_id'];
    $search=run_query("SELECT * FROM `room_image` WHERE `room_id`=$room_id");
    if(mysqli_num_rows($search)){
        $del=run_query("DELETE FROM `room_image` WHERE `room_id`=$room_id");
    }
    if($img=='inv_img'){
        echo $img;
    } else if($img=='inv_size'){
        echo $img;
    }else if($img=='upd_failed'){
        echo $img;
    }else{
        $q="INSERT INTO `room_image`(`room_id`, `image`) VALUES (?,?)";
        $values=[$frm_data['room_id'],$img];
        $res=insert($q,$values,'is');
        if($res)
        {
            echo 'success';
        }else{
            echo 'error';
        }
    }
}
?>