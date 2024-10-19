<?php 
    include('../admin/assets/config/dbconn.php');

    extract($_POST);

    if(isset($_POST['fnameSend']) && isset($_POST['lnameSend']) && isset($_POST['emailSend']) && isset($_POST['phoneSend']) && isset($_POST['addressSend']))
    {
        $sql = "INSERT INTO users (fname, lname, email, phone, address) 
                VALUES ('$fnameSend', '$lnameSend', '$emailSend', '$phoneSend', '$addressSend') ";

        $result = mysqli_query($conn, $sql);
    }
?>

