<?php
    header('Content-Type: application/json');
    require('C:\xampp\htdocs\project\inc\config.php');
    require('C:\xampp\htdocs\project\inc\essential.php');
    session_start();

    if(isset($_POST['check_availability'])){
        $frm_data=filter($_POST);
        $status="";
        $result="";

        $today_date=new DateTime(date('Y-m-d'));
        $check_in= new DateTime($frm_data['check_in']);
        $check_out= new DateTime($frm_data['check_out']);

        if($check_in==$check_out){
            $status='check_in_out_equal';
            $result=json_encode(['status'=>$status]);
        }else if($check_out < $check_in){
            $status='check_out_earlier';
            $result=json_encode(['status'=>$status]);
        }else if($check_in < $today_date){
            $status='check_in_earlier';
            $result=json_encode(['status'=>$status]);
        }

        if($status!=''){
            echo $result;
        }else{
            $count_days=date_diff($check_in,$check_out)->days;
            $payment=$_SESSION['room']['price']*$count_days;
            
            $cb_q="SELECT COUNT(*) AS 'total_bookings' FROM `booking_info` 
            WHERE (status=1 OR status=0) AND (check_out>? AND check_in<?) AND room_id=?";

            $values=[$frm_data['check_in'],$frm_data['check_out'],$_SESSION['room']['id']];

            $cb_fetch=mysqli_fetch_assoc(selection($cb_q,$values,'ssi'));

            $room_rq=selection("SELECT `quantity` FROM `room` WHERE id=?",[$_SESSION['room']['id']],'i');
            $room_fetch=mysqli_fetch_assoc($room_rq);

            if($room_fetch['quantity']-$cb_fetch['total_bookings']==0){
                $result=json_encode(['status'=>'Unavailable']);
                echo $result;
                exit;
            }

            $_SESSION['room']['payment']=$payment;
            $_SESSION['room']['available']=true;
            $_SESSION['room']['days']=$count_days;
            
            $result=json_encode(['status'=>'available', 'days'=>$count_days, 'payment'=>$payment]);

            echo $result;
        }

    }

    if(isset($_POST['pay_now'])){
        $stats='';
        $frm_data=filter($_POST);

        $check_in= new DateTime($frm_data['check_in']);
        $check_out= new DateTime($frm_data['check_out']);

        $count_days=date_diff($check_in,$check_out)->days;
        $payment=$_SESSION['room']['price']*$count_days;

        $check_in_str = $check_in->format('Y-m-d H:i:s');
        $check_out_str = $check_out->format('Y-m-d H:i:s');

        $q = "INSERT INTO `booking_info`(`room_id`, `user_id`, `check_in`, `check_out`, `trans_amount`, `status`) VALUES (?, ?, ?, ?, ?, ?) ";
        $values=[$_SESSION['room']['id'],$_SESSION['uid'],$check_in_str,$check_out_str,$payment,1];
        error_log('Query: ' . $q);
        error_log('Values: ' . json_encode($values));

        
        if ($res = insert($q, $values, 'iissii'))
        {
           $status='success';
        }else{
            $status='error';
        }
        echo json_encode(['status'=>$status]);
    }

?>
