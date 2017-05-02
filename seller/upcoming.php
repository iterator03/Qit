<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 7:10 PM
 */

session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';
$data_out = array();
if(isset($_POST['hashkey']))
{
    $conn_obj = $mysql_conn->prepare('SELECT * FROM hintdb.mainqueue WHERE hashkey = :hkey ORDER BY id');
    $conn_obj->bindParam(':hkey',$_POST['hashkey'],PDO::PARAM_STR);
    $conn_obj->execute();
    if($conn_obj->rowCount() > 0)
    {
        $data_out['errors'] = 0;
        $conn_obj->setFetchMode(PDO::FETCH_ASSOC);
        while ($data_temp = $conn_obj->fetch())
        {
            array_push($data_out,$data_temp);
        }
        echo json_encode($data_out);
        die();
    }else{
        $data_out['errors'] = 2;
        $data_out['message'] = "Invalid Hashkey";
        die();
    }
}else{

    $data_out['errors'] = 1;
    $data_out['message'] = "Invalid Data sent";
    echo json_encode($data_out);
    die();
}
