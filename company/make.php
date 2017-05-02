<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 2:19 PM
 */
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/dependencies/random.php';

if(isset($_POST['cname']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['oid']))
{
    if(!($_POST['password'] == $_POST['password2']))
    {
        $_SESSION['error'] = "Sorry Passwords didnt matched";
        header('Location: ../master/index.php');
        die();
    }
    //Make  a Unqiue id for him .. For now just make one and hope its not there
    do{
        $newhash = generateRandomString(5);
        //Check the string for already present or not
        $new_check = $mysql_conn->prepare('SELECT * FROM hintdb.login WHERE secretvar = :hkey LIMIT 1');
        $new_check->bindParam(':hkey',$newhash);
        $new_check->execute();
    }while($new_check->rowCount() > 0);

    //Now Saving the details
    $conn_obj = $mysql_conn->prepare('INSERT INTO hintdb.login (username,password,secretvar,designation) VALUES (:user,:pass,:secvar,:desig)');
    $conn_obj->bindParam(':user',$_POST['oid']);
    $conn_obj->bindParam(':pass',$_POST['password']);
    $conn_obj->bindParam(':secvar',$newhash);
    $conn_obj->bindValue(':desig','owner');
    $conn_obj->execute();

    //Now Saving the details about the comapany
    $conn_obj = $mysql_conn->prepare('INSERT INTO hintdb.companydetails (hashkey,company) VALUES (?,?)');
    $conn_obj->bindParam(1,$newhash);
    $conn_obj->bindParam(2,$_POST['cname']);
    $conn_obj->execute();

    $_SESSION['done'] = true;
    header('Location: ../master/index.php');
    die();

}else{
    $_SESSION['error']="Invalid Credentials!";
    header('Location: ../master/');
    die();
}
