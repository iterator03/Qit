<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 5:09 AM
 */
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';

if(isset($_POST['username']) && isset($_POST['password']))
{
    $username = preg_replace("/[^A-Za-z0-9]+/", "",$_POST['username']);
    $password = preg_replace("/[^A-Za-z0-9]+/", "",$_POST['password']);
    $login_obj = $mysql_conn->prepare('SELECT * FROM hintdb.login WHERE username = :user LIMIT 1');
    $login_obj->bindParam(':user',$username);
    $login_obj->execute();

    if($login_obj->rowCount() > 0)
    {
        $login_obj->setFetchMode(PDO::FETCH_ASSOC);
        $result = $login_obj->fetch();
        if($result['password'] == $password)
        {
            //Inserting the new Session id to the database
            $session_set =  $mysql_conn->prepare('UPDATE hintdb.login SET sessionvar = :sess WHERE username = :user');
            $session_set->bindParam(':sess',session_id(),PDO::PARAM_STR);
            $session_set->bindParam(':user',$username,PDO::PARAM_STR);
            $session_set->execute();

            $_SESSION['secretvar'] = $result['secretvar'];
            $_SESSION['username'] = $username;
            $_SESSION['designation'] = $result['designation'];
            header('Location: redirect.php');
            die();
        }
        else{
            //No user
            $_SESSION['error'] = "Incorrect Username or Password";
            header('Location: ../index.php');   //Add Location here
            die();
        }
    }else{
        //No user
        $_SESSION['error'] = "Incorrect Username or Password";
        header('Location: ../index.php');   //Add Location here
        die();
    }

}
else{

}