<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 2:59 PM
 */
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/dependencies/random.php';


//Verify Login Here
if(isset($_SESSION['secretvar']) && isset($_SESSION['designation']) && $_SESSION['designation'] == 'owner')
{
//Be cool
}
else{
    header('Location: ../index.php');
    die();
}
$number = $_GET['pnumber'];

for($var = 0; $var<$number;++$var)
{
    $newstring = generateRandomString(5);
    //Inseting in the POOL of the uid
    $conn_obj = $mysql_conn->prepare('INSERT INTO hintdb.uidpool (hashkey,uidpool) VALUES (:hkey,:uid)');
    $conn_obj->bindParam(':hkey',$_SESSION['secretvar'],PDO::PARAM_STR);
    $conn_obj->bindParam(':uid',$newstring,PDO::PARAM_STR);
    $conn_obj->execute();
}
$_SESSION['pull'] = true;
header('Location: makepull.php');
die();

