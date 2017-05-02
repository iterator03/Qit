<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 11:53 AM
 */

$data_out = array();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';

if(isset($_POST['hashkey']))
{
    $fuckobj = $mysql_conn->prepare('SELECT * FROM hintdb.mainqueue WHERE hashkey = :hkey');
    $fuckobj->bindParam(':hkey',$_POST['hashkey']);
    $fuckobj->execute();
    $fuckobj->setFetchMode(PDO::FETCH_ASSOC);

    if($fuckobj->rowCount() > 0)
    {
        $counter = 1;
        for($var = 0;$var<$fuckobj->rowCount();++$var)
        {
            $data_temp = $fuckobj->fetch();
            $data_bruh =array();
            $data_bruh['qid'] = $data_temp['queueid'];
            $data_bruh['name'] = $data_temp['name'];
            $data_bruh['number'] = $data_temp['number'];
            array_push($data_out,$data_bruh);
            $counter = $counter + 1;
        }
        echo json_encode($data_out);
        die();
    }
    else{
        //No Data Found
        $data_out['error'] =2;
        echo json_encode($data_out);
    }
}
else{
    $data_out['error'] = 1;
    $data_out['message'] = "No Hash Key Received";
    echo json_encode($data_out);
    die();
}
/*
 * Error Codes
 * 0-No Error Actually
 * 1- No Hash Key Received
 * 2-No Hashkey Found Matching that one
 * */