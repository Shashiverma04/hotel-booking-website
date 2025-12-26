<?php
require('../inc/config.php');
require('../inc/essential.php');
login();

// remove or activate user
if(isset($_POST['rem_user'])){
    $frm_data=filter($_POST);
    $values=$frm_data['rem_user'];
    $user_check=run_query("SELECT `user_status` FROM `user_info` WHERE id=$values");
    $res=mysqli_fetch_assoc($user_check);
    if($res['user_status']==1)
    {
        $q="UPDATE `user_info` SET `user_status`=0 WHERE id=$values";
    }else{
        $q="UPDATE `user_info` SET `user_status`=1 WHERE id=$values";
    }
    $result=run_query($q);
    echo $result;
}

// searching user
if(isset($_POST['search_user'])){
    $frm_data=filter($_POST);
    $q='SELECT * FROM `user_info` WHERE `user_name` LIKE ?';
    $res=selection($q,["%$frm_data[name]%"],'s');
    $i=1;
    $data="";
    $status='';
    $delete='';

    while($row=mysqli_fetch_assoc($res)){
        
        if($row['user_status']==1){
            $status="<button class='btn btn-success btn-sm'>Active</button>";
            $delete="<button class='btn btn-danger btn-sm' type='button' onclick='rem_user($row[id])'>Delete</button>";
        }else{
            $status="<button class='btn btn-primary btn-sm'>Deleted</button>";
            $delete="<button class='btn btn-success btn-sm' type='button' onclick='rem_user($row[id])'>Activate</button>";
        }
        echo "<tr>
                    <td>$i</td>
                    <td>$row[user_name]</td>
                    <td>$row[email]</td>
                    <td>$row[phoneno]</td>
                    <td>$row[address]</td>
                    <td>$row[pincode]</td>
                    <td>$row[DOB]</td>
                    <td>$status</td>
                    <td>$delete</td>
                </tr>";
            $i++;
    }
}

// reviewing user queries
if(isset($_POST['read']))
{
    $frm_data=filter($_POST);
    $q="UPDATE `cus_queries` SET `status`=1 WHERE sr_no=$frm_data[id]";
    
    $res=run_query($q);
    if($res){
        echo 1;
    }else{
        echo 0;
    }
}

// remove user queries
if(isset($_POST['rem_q']))
{
    $frm_data=filter($_POST);
    $q="DELETE FROM `cus_queries` WHERE sr_no=$frm_data[id]";
    
    $res=run_query($q);
    if($res){
        echo 1;
    }else{
        echo 0;
    }
}

//sending user queries
if(isset($_POST['send'])){
    $frm_data=filter($_POST);
    $q="INSERT INTO `cus_queries` (`name`,`email`,`subject`,`message`) VALUES (?,?,?,?)";
    $values= [$frm_data['name'],$frm_data['email'],$frm_data['sub'],$frm_data['message']];
    $res=insert($q,$values,'ssss');

    if($res){
        echo 1;
    }
    else{
        echo 0;
    }
}
?>