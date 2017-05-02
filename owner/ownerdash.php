<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 5:40 AM
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

//Finding people in Queue
$find_people_obj = $mysql_conn->prepare('SELECT * FROM hintdb.mainqueue WHERE hashkey = :hkey');
$find_people_obj->bindParam(':hkey',$_SESSION['secretvar'],PDO::PARAM_STR);
$find_people_obj->execute();

$waiting_people = $find_people_obj->rowCount();

$served_people = $mysql_conn->prepare('SELECT * FROM hintdb.servedcustomers WHERE hashkey = :hkey');
$served_people->bindParam(':hkey',$_SESSION['secretvar']);
$served_people->execute();

$done_people = $served_people->rowCount();

$return_people = $mysql_conn->prepare('SELECT * FROM hintdb.servedcustomers WHERE hashkey = :hkey');
$return_people->bindParam(':hkey',$_SESSION['secretvar']);
$return_people->execute();

$bounce_people = $return_people->rowCount();
?>
<html>

<head>
    <title> Dashboard QIt </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link href="bootstrap_card.css" rel="stylesheet">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
    <script type="text/javascript" src="js/fusioncharts.js"></script>
    <script type="text/javascript" src="js/themes/fusioncharts.theme.ocean.js"></script>
    <script type="text/javascript">
        FusionCharts.ready(function() {
            var revenueChart = new FusionCharts({
                "type": "area2d",
                "renderAt": "chartContainer",
                "width": "500",
                "height": "500",
                "dataFormat": "json",
                "dataSource": {
                    "chart": {
                        "caption": " Customer flow vs time graph Actions",
                        "xAxisName": "Time of day",
                        "yAxisName": "Number of customers",
                        "theme": "ocean"
                    },
                    "data": [
                        <?php
                            $graph_check_obj  = $mysql_conn->prepare("SELECT * FROM hintdb.analytic WHERE hashkey = :hkey");
                            $graph_check_obj->bindParam(':hkey',$_SESSION['secretvar']);
                            $graph_check_obj->execute();
                            $graph_check_obj->setFetchMode(PDO::FETCH_ASSOC);

                            if($graph_check_obj->rowCount() > 0)
                            {
                                $counter = 1;
                                while($result_graph = $graph_check_obj->fetch())
                                {
                                    if($counter> 1)
                                        echo ',';
                                    $data = $result_graph['time'];
                                    $time_stamp = strtotime($data);
                                    $served = $result_graph['served'];
                                    $time_stamp =  date("h-m-s", $time_stamp);
                                    echo '{
                                        "label": "'.$time_stamp.'",
                                        "value": "'.$served.'"
                                    }';
                                    $counter = $counter + 1;
                                }
                            }
                            else{

                            }

                        ?>
                    ]
                }
            });

            revenueChart.render();
        })
    </script>

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
        <ul class="nav navbar-nav">
            <li><a href="addseller.php">Add Seller</a></li>
        </ul>
        <ul class="nav navbar-nav">
            <li><a href="makepull.php">Make Pull</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="../login/logout.php"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <br>
    <h1 class="text text-center text-success"><strong>Q-It Admin dashboard</strong> </h1>

    <div class="row">
        <div class="col-xs-4">

            <div class="card-begin">
                <br> <br>
                <div class="w3-card-8" style="width:100%;">
                    <header class="card-begin w3-blue">
                        <h3>Waiting customer count</h3>
                    </header>
                    <div class="card-begin">
                        <p>
                        <div class="row">
                            <div class="col-xs-4">
                                <span class="glyphicon glyphicon-edit fa-4x"></span>
                            </div>
                            <div class="col-xs-8">
                                <h1 class="text text-primary"><?php echo $waiting_people;  ?> </h1>
                            </div>
                        </div>
                    </div>
                    <footer class="card-begin w3-blue">
                        &nbsp;
                    </footer>
                </div>
            </div>
        </div>

        <div class="col-xs-4">

            <div class="card-begin">
                <br> <br>
                <div class="w3-card-8" style="width:100%;">
                    <header class="card-begin w3-green">
                        <h3>Total customer count</h3>
                    </header>
                    <div class="card-begin">
                        <p>
                        <div class="row">
                            <div class="col-xs-4">
                                <span class="glyphicon glyphicon-edit fa-4x"></span>
                            </div>
                            <div class="col-xs-8">
                                <h1 class="text text-success"> <?php echo $done_people+ $waiting_people; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <footer class="card-begin w3-green">
                        &nbsp;
                    </footer>
                </div>
            </div>
        </div>

        <div class="col-xs-4">

            <div class="card-begin">
                <br> <br>
                <div class="w3-card-8" style="width:100%;">
                    <header class="card-begin w3-yellow">
                        <h3>Bouncing off customers</h3>
                    </header>
                    <div class="card-begin">
                        <p>
                        <div class="row">
                            <div class="col-xs-4">
                                <span class="glyphicon glyphicon-edit fa-4x"></span>
                            </div>
                            <div class="col-xs-8">
                                <h1 class="text text-success"> <?php echo $bounce_people; ?></h1>
                            </div>
                        </div>
                    </div>
                    <footer class="card-begin w3-yellow">
                        &nbsp;
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <br><br>
    <div class="row">
        <div class="col-md-6">
            <div id="chartContainer">
            </div>
        </div>
        <div class="col-xs-6">
            <br>
            <input type="hidden" value="<?php echo $_SESSION['secretvar'] ?>" id="hashkey123">

            <div class="well">
                <h3 class="text text-center text-success"><strong>Upcoming Codes</strong></h3>
                <br>
                <div id="code_iterator">
                    <div class="alert alert-success">
                        <strong>Called Code: </strong> 84550
                    </div>
                </div>
            </div>





        </div>
    </div>

    <div class="container">
    </div>

</div>
<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>


<script src = "../js/ajaxcodeowner.js"></script>
</body>

</html>

