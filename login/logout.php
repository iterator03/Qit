<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 9:32 AM
 */
session_start();
session_destroy();
session_abort();
unset($_SESSION);
header('Location: ../index.php');
die();