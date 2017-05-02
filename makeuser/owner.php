<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 9:57 AM
 */
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/dependencies/random.php';

if(isset($_POST['username']) && isset($_POST['password']))
{

    $newhashkey = generateRandomString(10);
    $username = $_POST['username'];
    $password = $_POST['password'];

    $insert_obj = $mysql_conn->prepare('INSERT INTO hintdb.login (username,password,secretvar,designation) VALUES (:user,:pass,:secvar,:desig)');
    $insert_obj->bindParam(':user',$username,PDO::PARAM_STR);
    $insert_obj->bindParam(':pass',$password,PDO::PARAM_STR);
    $insert_obj->bindParam(':secvar',$newhashkey,PDO::PARAM_STR);
    $insert_obj->bindValue(':desig',"owner");
    $insert_obj->execute();

    $_SESSION['success'] = true;
    $_SESSION['message'] = "Owner Account Added";
    header('Location: ');
    die();
}
else{
    //No thing
    header('Location: ../index.php');
    die();
}