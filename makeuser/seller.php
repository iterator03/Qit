<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 5:49 AM
 */
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';

if(isset($_POST['username']) && isset($_POST['sellername']) && isset($_POST['password']) && isset($_POST['password2']))
{
    if($_POST['password'] == $_POST['password2'])
    {
    }
    else{
        $_SESSION['error'] = "Password not Matched";
        header('Location: ../owner/addseller.php');
        die();
    }

    //Adding to the login Table
    $username = $_POST['username'];
    $sellername = $_POST['sellername'];
    $password = $_POST['password'];


    $insert_obj = $mysql_conn->prepare('INSERT INTO hintdb.login (username,password,secretvar,designation) VALUES (:user,:pass,:secvar,:desig)');
    $insert_obj->bindParam(':user',$username,PDO::PARAM_STR);
    $insert_obj->bindParam(':pass',$password,PDO::PARAM_STR);
    $insert_obj->bindParam(':secvar',$_SESSION['secretvar'],PDO::PARAM_STR);
    $insert_obj->bindValue(':desig',"seller");
    $insert_obj->execute();

    //Now Save the Name
    $insert_obj = $mysql_conn->prepare('INSERT INTO hintdb.sellerinfo (hashkey,sellername) VALUES (:hashkey,:sellername)');
    $insert_obj->bindParam(':hashkey',$_SESSION['secretvar']);
    $insert_obj->bindParam(':sellername',$_POST['sellername']);
    $insert_obj->execute();

    $_SESSION['success'] = true;
    $_SESSION['message'] = "Seller Account Added Succesfully";
    header('Location: ../owner/addseller.php');
    die();
}else{

}