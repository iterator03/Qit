<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 3:03 PM
 */

session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/confidential/connector.php';

//Verify Login Here
if(isset($_SESSION['secretvar']) && isset($_SESSION['designation']) && $_SESSION['designation'] == 'owner')
{
//Be cool
}
else{
    header('Location: ../index.php');
    die();
}

if(isset($_SESSION['pull']))
{
    unset($_SESSION['pull']);
    echo '<script>window.alert("Pool Created Successfully")</script>';
}
?>
<html>

<head>
    <title> Q-It </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link href="student.dashboard.css" rel="stylesheet">
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
        <li class="active"><a href="#">Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
      </ul>
    </div>
  </nav>
<div class="container">
<br>
<div class="well">
<h2 class="text text-warning text-center"><strong>Create Pool</strong></h2>
<br>
  <form class="form-horizontal" role="form" action="pull.php">
      <div class="form-group">
          <label class="col-lg-3 control-label">Enter pool number :</label>
          <div class="col-lg-8">
              <input class="form-control" type="text" name="pnumber" id="pnumber" placeholder="Enter pool number here...." required>
          </div>
      </div>



      <p class="text text-center"><button class="btn btn-success ">Create pool</button></p>
    </form>
  </div>
</div>



</body>

</html>
>
