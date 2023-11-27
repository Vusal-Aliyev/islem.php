<?php 
ob_start();
session_start();
require 'baglan.php';

if(isset($_POST['epiz_33820934_kayit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_again = @$_POST['password_again'];

    if(!$username){
        echo "<script>alert('Enter the agent code from the CIA database!');</script>";
        header('Refresh:0; kayit.php');
    } elseif(!$password || !$password_again){
        echo "<script>alert('re-enter your password!!');</script>";
        header('Refresh:0; kayit.php');
    } elseif($password != $password_again){
        echo "<script>alert('Passwords did not match. If you are not authorized to login, contact an authorized person !');</script>";
        header('Refresh:0; kayit.php');
    }
    else{
        //veritabani kayit islemi
        $sorgu = $db->prepare('INSERT INTO users SET user_name = ?, user_password = ?');
        $ekle = $sorgu->execute([
            $username,$password
        ]);
        if($ekle){
            echo "<script>alert('Registration Successful! You can log in by entering your registration information.');</script>";
            header('Refresh:0; login.php');
        } else{
            echo "<script>alert('Unexpected error please try again!');</script>";
            header('Refresh:0; kayit.php');
        }
    }
}

if(isset($_POST['giris'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!$username){
        echo "<script>alert('Enter the username!');</script>";
        header('Refresh:0; login.php');
    } elseif(!$password){
        echo "<script>alert('Enter your password!');</script>";
        header('Refresh:0; login.php');
    } else {
        $kullanici_sor = $db->prepare('SELECT * FROM users WHERE user_name = ? && user_password = ?');
        $kullanici_sor->execute([
            $username, $password
        ]);
        $say = $kullanici_sor->rowCount();
        if($say==1){
            $_SESSION['username']=$username;
            header('Location: terrorist_act.html');
            exit;
        } else{
            $error = "No such authorized user found! Make sure you enter the correct login information!";
        }
    }
}


?>
