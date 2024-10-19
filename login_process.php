<?php
session_start();
include('./assets/config/dbconn.php');

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
    {
        foreach($result as $data)
        {
            $user_id = $data['id'];
            $user_name = $data['fname'].' '.$data['lname'];
            $user_email = $data['email'];
            $role_as = $data['role_as'];
        }

        $_SESSION['auth'] = true;
        $_SESSION['auth_role'] = $role_as;  // 0=user, 1=employee, 2=admin
        $_SESSION['auth_user'] = [
            'user_id' => $user_id,
            'user_name' => $user_name,
            'user_email' => $user_email,
        ];

        // Redirect based on role
        if($_SESSION['auth_role'] == '2')  // Admin
        {
            $_SESSION['message'] = "Welcome to Dashboard";
            header('Location: ./admin/index.php');
            exit(0);
        }
        elseif($_SESSION['auth_role'] == '1')  // Employee
        {
            $_SESSION['message'] = "You are Logged In";
            header('Location: ./employee/index.php');
            exit(0);
        }
        elseif($_SESSION['auth_role'] == '0')  // User
        {
            $_SESSION['message'] = "You are Logged In";
            header('Location: ./user/index.php');
            exit(0);
        }
    }
    else
    {
        $_SESSION['message'] = "Incorrect Email or Password";
        header('Location: login.php');
        exit(0);
    }
}
?>
