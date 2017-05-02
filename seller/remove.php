<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 8:08 PM
 */
session_start();
$data_out = array();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';

if(isset($_POST['id']) && $_POST['hashkey'])
{
    $get_det = $mysql_conn->prepare('SELECT * FROM hintdb.mainqueue WHERE id = :uid LIMIT 1');
    $get_det->bindParam(':uid',$_POST['id']);
    $get_det->execute();
    $get_det->setFetchMode(PDO::FETCH_ASSOC);
    $detail_got = $get_det->fetch();

    $rem_obj = $mysql_conn->prepare('DELETE FROM hintdb.mainqueue WHERE id = :uid');
    $rem_obj->bindParam(':uid',$_POST['id'],PDO::PARAM_INT);
    $rem_obj->execute();

    //Now Insert the data in the done thing for the completing of the main task
    $insert_obj = $mysql_conn->prepare('INSERT INTO hintdb.servedcustomers (name,hashkey,queueid) VALUES (?,?,?)');
    $insert_obj->bindParam(1,$detail_got['name'],PDO::PARAM_STR);
    $insert_obj->bindParam(2,$_POST['hashkey'],PDO::PARAM_STR);
    $insert_obj->bindParam(3,$_POST['id'],PDO::PARAM_STR);
    $insert_obj->execute();

    //Done execitomg of the code
    $data_out['error'] = 0;
    echo json_encode($data_out);
    die();
}else{
    $data_out['error'] = 1;
    echo json_encode($data_out);
    die();
}