<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 10:30 AM
 */
session_start();

if(isset($_SESSION['designation']) && $_SESSION['designation'] == "master")
{
    //Allowed
}else{
    header('Location: ../login/logout.php');
    die();
}

if(isset($_SESSION['done']))
{
    unset($_SESSION['done']);
    echo '<script>window.alert("Company Owner Account Created")</script>';
}
?>
<html>

<head>
    <title> Q-It: Queue It </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">

</head>

<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Q-It Analytics</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="../login/logout.php"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <br>
    <h1 class="text text-warning  text-center"><strong>Create company account  </strong></h1>
    <br> <br>
    <form class="form-horizontal" role="form" method="post" action="../company/make.php">
        <div class="form-group">
            <label class="col-lg-3 control-label">Company Name :</label>
            <div class="col-lg-8">
                <input class="form-control" type="text" name="cname" id="cname" placeholder="Enter company name here....">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Owner User Id:</label>
            <div class="col-lg-8">
                <input class="form-control" type="text" name="oid" id="oid" placeholder="Enter company name here....">
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
        <p class="text text-center"><button class="btn btn-warning ">Create account</button></p>
    </form>
</div>



</body>

</html>

