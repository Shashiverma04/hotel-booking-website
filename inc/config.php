<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$hname = "localhost";
$uname = "your_user";
$pass = "your_password";
$db = "your_database";;

// Connect to the database
$con = mysqli_connect($hname, $uname, $pass, $db);

// if connection didnt formed
if (!$con) {
    die("Cannot connect to database: " . mysqli_connect_error());
}

// filter the data got from forms 
function filter($data){
    foreach($data as $key => $value){
        $data[$key]=trim($value);
        $data[$key]=stripcslashes($value);
        $data[$key]=htmlspecialchars($value);
        $data[$key]=strip_tags($value);
    }
    return $data;
}

// to run a query
function run_query($query) {
    $con = $GLOBALS['con'];  
    
    $data = mysqli_query($con, $query);
    if (!$data) {
        die('Query failed: ' . mysqli_error($con));
    }
    
    return $data;
}

// sending alert
function alert_send($type,$msg){
    $bs_class= ($type=="success")?"alert-success":"alert-danger";
    echo <<<alert
            <div class="alert $bs_class alert-dismissible fade show" role="alert">
            <strong class="me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
}

//to insert values in database
function insert($sql,$values,$datatypes){
    $con=$GLOBALS['con'];
    if($stmt=mysqli_prepare($con,$sql)){
        mysqli_stmt_bind_param($stmt,$datatypes,...$values);
        if(mysqli_stmt_execute($stmt))
        {
            $result=mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return 1;
        }else{
            mysqli_stmt_close($stmt);
            die("Query cannot be executed");
        }
    }
    else{die("Query Cannot be Executed");}
}

// to delete values from database
function delete($sql,$values,$datatypes){
    $con=$GLOBALS['con'];
    if($stmt=mysqli_prepare($con,$sql)){
        mysqli_stmt_bind_param($stmt,$datatypes,...$values);
        if(mysqli_stmt_execute($stmt))
        {
            $result=mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        }else{
            mysqli_stmt_close($stmt);
            die("Delete Query cannot be executed");
        }
    }
    else{die("Query Cannot be Executed");}
}

// to select record from database 
function selection($query,$values,$datatypes){
    $con=$GLOBALS['con'];
    if($stmt=mysqli_prepare($con,$query)){
        mysqli_stmt_bind_param($stmt,$datatypes,...$values);
        if(mysqli_stmt_execute($stmt))
        {
            $result=mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        }else{
            mysqli_stmt_close($stmt);
            die("Query cannot be executed");
        }
    }
    else{die("Query Cannot be Executed");}
}
?>
