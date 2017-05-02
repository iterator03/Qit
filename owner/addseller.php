<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 5:46 AM
 */
session_start();
if(isset($_SESSION['secretvar']) && isset($_SESSION['designation']) && $_SESSION['designation'] == 'owner')
{
//Be cool
}
else{
    header('Location: ../index.php');
    die();
}
if(isset($_SESSION['error']))
{
    echo '<script>window.alert("'.htmlspecialchars($_SESSION['error']).'")</script>';
    unset($_SESSION['error']);
}elseif (isset($_SESSION['success']))
{
    if($_SESSION['success'] == true)
    {
        echo '<script>window.alert("'.htmlspecialchars($_SESSION['message']).'")</script>';
        unset($_SESSION['message']);
        unset($_SESSION['success']);
    }
}
?>

<html>

<head>
    <title> Adding Seller </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link href="bootstrap_card.css" rel="stylesheet">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
    <script type="text/javascript" src="js/fusioncharts.js"></script>
    <script type="text/javascript" src="js/themes/fusioncharts.theme.ocean.js"></script>


</head>

<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Q-It Analytics</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="ownerdash.php">Home</a></li>
        </ul>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Add Seller</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="../login/logout.php"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <br>
    <h1 class="text text-warning text-center"><strong>Make seller account</strong></h1>
    <br>
    <form class="form-horizontal" role="form" action="../makeuser/seller.php" method="post">
        <div class="form-group">
            <label class="col-lg-3 control-label">Username :</label>
            <div class="col-lg-8">
                <input class="form-control" type="text" name="username" id="username" placeholder="Enter username here....">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Seller name: </label>
            <div class="col-lg-8">
                <input class="form-control" type="text" name="sellername" id="sellername" placeholder="Enter seller name here....">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Password: </label>
            <div class="col-lg-8">
                <input class="form-control" type="password" name="password" id="password" placeholder="Enter password here....">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Confirm Password: </label>
            <div class="col-lg-8">
                <input class="form-control" type="password" name="password2" id="password2" placeholder="Re-enter password number here....">
            </div>
        </div>
        <p class="text text-center"><button class="btn btn-success ">Create account</button></p>
    </form>
</div>



</body>

</html>

