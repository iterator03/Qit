<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 5:25 AM
 */

session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';

if(isset($_SESSION['secretvar']) && isset($_SESSION['designation']))
{
    $check_obj = $mysql_conn->prepare('SELECT * FROM hintdb.login WHERE sessionvar = :sess AND designation = :desig AND username = :user');
    $check_obj->bindParam(':sess',session_id(),PDO::PARAM_STR);
    $check_obj->bindParam(':desig',$_SESSION['designation'],PDO::PARAM_STR);
    $check_obj->bindParam(':user',$_SESSION['username'],PDO::PARAM_STR);
    $check_obj->execute();

    if($_SESSION['designation'] == 'master')
    {
       header('Location: ../master/');//Redirect
    }elseif ($_SESSION['designation'] == 'owner')
    {
        header('Location: ../owner/ownerdash.php');
        die();
    }elseif ($_SESSION['designation'] == 'seller')
    {
        header('Location: ../seller/');//Add it
    }
    else{
        //Fucked up
        session_abort();
        session_destroy();
        header('Location: ../index.php');
        die();
    }

}else{
    //No Way get Lost
    header('Location: logout.php');//Send Wherever you want
    die();
}