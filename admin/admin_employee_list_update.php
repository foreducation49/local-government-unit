<?php 
    include('../admin/assets/config/dbconn.php');


    if(isset($_POST['updateid']))
    {
        $user_id = $_POST['updateid'];

        $sql = "SELECT * FROM employee where id = $user_id";
        $result = mysqli_query($conn, $sql);
        $response =  array();

        while($row = mysqli_fetch_assoc($result))
        {
            $response = $row;
        }
        echo json_encode($response);
    }
    else
    {
        $response['status'] = 200;
        $response['message'] = "Invalid or Data Not Found";
    }



    //update query
    if(isset($_POST['hiddendata']))
    {
        $uniqueid = $_POST['hiddendata'];
        $fname = $_POST['updateFirstname'];
        $lname = $_POST['updateLastname'];
        $email = $_POST['updateEmail'];
        $phone = $_POST['updatePhone'];
        $address = $_POST['updateAddress'];

        $sql = "UPDATE employee SET fname = '$fname', lname = '$lname', email = '$email',  phone = '$phone',  address = '$address' WHERE id = $uniqueid";
        $result = mysqli_query($conn, $sql);
    }
?>