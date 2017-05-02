<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 3:15 AM
 */
$data_out = array();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';

if(isset($_GET['uid']) && $_GET['queueid'])
{
    $uid = preg_replace("/[^A-Za-z0-9]+/", "",$_GET['uid']);
    $queueid = preg_replace("/[^A-Za-z0-9]+/", "",$_GET['queueid']);

    //Get the id
    $get_id = $mysql_conn->prepare('SELECT * FROM hintdb.mainqueue WHERE hashkey = :hkey AND queueid = :qid');
    $get_id->bindParam(':hkey',$uid);
    $get_id->bindParam(':qid',$queueid,PDO::PARAM_STR);
    $get_id->execute();
    $get_id->setFetchMode(PDO::FETCH_ASSOC);
    $result_temp = $get_id->fetch();

    $temp_id = $result_temp['id'];

    //Checking the exact people before this guy right now
    $check_obj = $mysql_conn->prepare('SELECT COUNT(*) as realcount FROM hintdb.mainqueue WHERE hashkey = :hashkey AND id < :myid');
    $check_obj->bindParam(':hashkey',$uid,PDO::PARAM_STR);
    $check_obj->bindParam(':myid',$temp_id,PDO::PARAM_INT);
    $check_obj->execute();
    unset($result_temp);
    $check_obj->setFetchMode(PDO::FETCH_ASSOC);
    $result_temp = $check_obj->fetch();
    $ans_count = $result_temp['realcount'];
    $data_out['prevcount'] = $ans_count;
    $data_out['error'] = 0;
    echo json_encode($data_out);
    die();
}
else{
    $data_out['error'] = "Improper Data";
    $data_out['errorcode'] = 1;
    echo json_encode($data_out);
    die();
}
