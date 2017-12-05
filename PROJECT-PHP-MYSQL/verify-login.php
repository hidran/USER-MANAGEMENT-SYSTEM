<?php
session_start();
require 'functions.php';

if (!empty($_POST)) {

    $token = $_POST['_csrf'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
 // echo 'hash='. password_hash($password, PASSWORD_DEFAULT);
    $resultValidation = verifyUserData($email, $password, $token);
    if ($resultValidation['success']) {

        $userRecord = getUserByEmail($email);
     //   var_dump($userRecord);
        if ($userRecord) {
            if (password_verify($password, $userRecord['password'])) {
                unset($userRecord['password']);
                
                session_regenerate_id(true);
                
                $_SESSION['userIsLogged'] = 1;
                $_SESSION['userData'] = $userRecord;
            } else {
                $resultValidation['success'] = false;
                $resultValidation['message'] = 'Wrong  password';
            }
        } else {
            $resultValidation['success'] = false;
            $resultValidation['message'] = 'User not found';
        }

    } 
    
    echo json_encode($resultValidation);
  

} else {
    header('Location: login.php');
    exit;
}