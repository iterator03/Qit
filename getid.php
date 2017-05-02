<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 1:53 AM
 */
$dataout = array();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';

if(isset($_GET['uid']))
{
    //Now we got the id now we check it with the database for a match
    $uid = preg_replace("/[^A-Za-z0-9]+/", "",$_GET['uid']);
    $check_conn = $mysql_conn->prepare('SELECT * FROM hintdb.uidpool WHERE hashkey = :hkey LIMIT 1');
    $check_conn->bindParam(':hkey',$uid,PDO::PARAM_STR);
    $check_conn->execute();

    if($check_conn->rowCount() > 0)
    {
        $check_conn->setFetchMode(PDO::FETCH_ASSOC);
        $take_detail = $check_conn->fetch();

        //Now delete this id from the db as we have given this id to someone else
        $delete_obj = $mysql_conn->prepare('DELETE FROM hintdb.uidpool WHERE id=:idi');
        $delete_obj->bindParam(':idi',$take_detail['id'],PDO::PARAM_INT);
        $delete_obj->execute();

        $dataout['queueid'] = $take_detail['uidpool'];
        $dataout['error'] = 0;

        //Count Number of Participants before
        $count_obj = $mysql_conn->prepare('SELECT COUNT(*) as prevcount FROM hintdb.mainqueue WHERE hashkey = :myhash');
        $count_obj->bindParam(':myhash',$uid,PDO::PARAM_STR);
        $count_obj->execute();
        $count_obj->setFetchMode(PDO::FETCH_ASSOC);

        $result_prev = $count_obj->fetch();
        $prev_people = $result_prev['prevcount'];

        //Now add it to the main queue for actual processing of the queue in that level
        if(isset($_GET['name']) && isset($_GET['number']))
        {
            $_GET['name'] = preg_replace("/[^A-Za-z0-9]+/", "",$_GET['name']);
            $_GET['number'] = preg_replace("/[^A-Za-z0-9]+/", "",$_GET['number']);
            $add_obj = $mysql_conn->prepare('INSERT INTO hintdb.mainqueue (name,number,hashkey,queueid) VALUES (:name,:number,:hashkey,:queueid)');
            $add_obj->bindParam(':name',$_GET['name'],PDO::PARAM_STR);
            $add_obj->bindParam(':number',$_GET['number'],PDO::PARAM_STR);
            $add_obj->bindParam(':hashkey',$uid,PDO::PARAM_STR);
            $add_obj->bindParam(':queueid',$take_detail['uidpool'],PDO::PARAM_STR);
            $add_obj->execute();
        }
        else{
            $add_obj = $mysql_conn->prepare('INSERT INTO hintdb.mainqueue (hashkey,queueid) VALUES (:hashkey,:queueid)');
            $add_obj->bindParam(':hashkey',$uid,PDO::PARAM_STR);
            $add_obj->bindParam(':queueid',$take_detail['uidpool'],PDO::PARAM_STR);
            $add_obj->execute();
        }

        $dataout['prevcount'] = $prev_people;
        echo json_encode($dataout);
        die();

    }else{
        //Row is already full get the fuck out of here
        $dataout['error'] = "No more queue space";
        $dataout['errorid'] = 2;
        echo json_encode($dataout);
        die();
    }
}
else{
    $dataout['error'] = 'No Id';
    $dataout['errorid'] = 1;
    echo json_encode($dataout);
    die();
}

/*
 * Data Error id:
 * 0-No Error
 * 1- Will be for the error cause when no id  is requested from the server
 * 2-No more queue space or pool empty
*/