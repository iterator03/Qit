<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 1:46 PM
 */

//Generating unique ids
if(!isset($_GET['hkey']))
{
    echo "No Hash Key!";
    die();
}

require_once $_SERVER['DOCUMENT_ROOT'].'/dependencies/random.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';

if($_GET['number'])
    $number = $_GET['number'];
else
    $number = 10;

for($var = 0; $var<$number;++$var)
{
    $newstring = generateRandomString(5);
    //Inseting in the POOL of the uid
    $conn_obj = $mysql_conn->prepare('INSERT INTO hintdb.uidpool (hashkey,uidpool) VALUES (:hkey,:uid)');
    $conn_obj->bindParam(':hkey',$_GET['hkey'],PDO::PARAM_STR);
    $conn_obj->bindParam(':uid',$newstring,PDO::PARAM_STR);
    $conn_obj->execute();

}
echo "Pool Creation Done";
die();
