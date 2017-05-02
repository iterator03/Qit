<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 10:41 AM
 */

session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';

$_GET['hashkey'] = "testhash";  //Making a  bit of Cheating :-p

//Finding people in Queue
$find_people_obj = $mysql_conn->prepare('SELECT * FROM hintdb.mainqueue WHERE hashkey = :hkey');
$find_people_obj->bindParam(':hkey',$_SESSION['secretvar'],PDO::PARAM_STR);
$find_people_obj->execute();

$waiting_people = $find_people_obj->rowCount();

$served_people = $mysql_conn->prepare('SELECT * FROM hintdb.servedcustomers WHERE hashkey = :hkey');
$served_people->bindParam(':hkey',$_SESSION['secretvar']);
$served_people->execute();

$done_people = $served_people->rowCount();

$return_people = $mysql_conn->prepare('SELECT * FROM hintdb.turnback WHERE hashkey = :hkey');
$return_people->bindParam(':hkey',$_SESSION['secretvar']);
$return_people->execute();

$bounce_people = $return_people->rowCount();

$tot= ($served_people+$bounce_people);

$inserter_obj = $mysql_conn->prepare('INSERT INTO hintdb.analytic (hashkey,served,bounced,total) VALUES (:hkey,:serv,:boun,:tot)');
$inserter_obj->bindParam(':hkey',$_GET['hashkey']);
$inserter_obj->bindParam(':serv',$done_people);
$inserter_obj->bindParam(':boun',$bounce_people);
$inserter_obj->bindParam(':tot',$tot);
$inserter_obj->execute();

die();
