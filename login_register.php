<?php
session_start();
require_once('config.php');
if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkEmail = $conn->query("SELECT email FROM users WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['signup_error'] = 'Email already exists';
        $_SESSION['active_form']='signup';
    }
    else{
        $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

    }
   header('location:index.php');
    exit();
}
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            header('location:home.php');
            exit();
        }
    }
    $_SESSION['signup_error'] = 'Wrong email or password';
    $_SESSION['active_form']='login';
    header('location:index.php');
}
?>