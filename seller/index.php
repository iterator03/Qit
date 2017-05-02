<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/3/17
 * Time: 6:51 PM
 */
session_start();

?>
<html>

<head>
    <title> Q-It  </title>
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

    <input type="hidden" value="<?php echo $_SESSION['secretvar']; ?>" id="hashkey123">
    <br>
    <div class="well well-sm">
        <h2 class="text text-success text-center"><strong><span class="glyphicon glyphicon-list-alt"></span> Seller Dashboard</strong></h2>
    </div>
    <br><br>
    <div class="col-xs-6">
        <div class="well">
            <div class="alert alert-warning" style="padding-bottom: 5px;"><h4 class="text text-success text-center"><strong>Orders on deck</strong></h4> </div>
            <div class="alert alert-danger" id="showup" style="display: none">
                <h3 class="text text-center">No more orders </h3>
            </div>
            <div class="order_app" id="order_app">

                <div class="alert alert-success" id="super1">
                    <div class="row" >
                        <div class="col-xs-10 text-sb" style="padding-top: 5px;">
                            <span class="glyphicon glyphicon-hand-right"></span><strong class="qstrong">&nbsp; Open Shop: </strong>
                        </div>
                        <div class="col-xs-2 text-mb">
                            <button class="btn btn-success btn-sm order-deck" id="p11">Start</button>
                        </div>
                    </div>
                </div>



            </div>

        </div>
    </div>
    <div class="col-xs-6">

        <div class="well">
            <div class="alert alert-warning" style="padding-bottom: 5px;"><h4 class="text text-success text-center"><strong>Upcoming Orders</strong></h4> </div>
            <div id="refreshhere">
                <div class="alert alert-info" id="refreshhere">
                    <div class="row">

                        <div class="col-xs-8" style="padding-top: 5px;">
                            <span class="glyphicon glyphicon-hand-up"></span><strong> Order from Id: </strong> 552454
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                var hashvar = $('#hashkey123').val();
                $('.order-deck').click(function () {
                    var remdeck = this.id;
                    $('super' + remdeck).empty();
                    $.ajax({
                        type: "POST", 		//GET or POST or PUT or DELETE verb
                        url: 'upcoming.php', 		// Location of the service
                        data: {hashkey: hashvar}, 		//Data sent to server
                        dataType: "json", 	//Expected data format from server
                        processdata: true, 	//True or False
                    }).done(function (data) {
                        $('#order_app').empty();
                        console.log(data);
                        $.each(data, function (key, value) {
                            console.log(value.id);
                            if (value.id != undefined)
                                $('#order_app').prepend('<div class="alert alert-success" id="super' + value.id + '"><div class="row" ><div class="col-xs-10 text-sb" style="padding-top: 5px;"><span class="glyphicon glyphicon-hand-right"></span><strong class="qstrong">&nbsp; Order Id: </strong> ' + value.queueid + '</div><div class="col-xs-2"><button class="btn btn-success btn-sm order-deck" id="' + value.id + '">Done</button></div></div></div>');

                        });
                    });

                });
                function refresh2() {
                    var remdeck = this.id;
                    $('super' + remdeck).empty();
                    $.ajax({
                        type: "POST", 		//GET or POST or PUT or DELETE verb
                        url: 'upcoming.php', 		// Location of the service
                        data: {hashkey: hashvar}, 		//Data sent to server
                        dataType: "json", 	//Expected data format from server
                        processdata: true, 	//True or False
                    }).done(function (data) {
                        $('#order_app').empty();
                        console.log(data);
                        $.each(data, function (key, value) {
                            console.log(value.id);
                            if (value.id != undefined)
                                $('#order_app').prepend('<div class="alert alert-success" id="super' + value.id + '"><div class="row" ><div class="col-xs-10 text-sb" style="padding-top: 5px;"><span class="glyphicon glyphicon-hand-right"></span><strong class="qstrong">&nbsp; Order Id: </strong> ' + value.queueid + '</div><div class="col-xs-2"><button class="btn btn-success btn-sm order-deck" id="' + value.id + '">Done</button></div></div></div>');

                        });
                    });

                }

                $(document).on("click","button.order-deck",function () {
                    $(this).parent().parent().parent().remove();
                    var hashvar = $('#hashkey123').val();
                        $.ajax({
                            type: "POST", 		//GET or POST or PUT or DELETE verb
                            url: 'remove.php', 		// Location of the service
                            data: {hashkey: hashvar,id : this.id}, 		//Data sent to server
                            dataType: "json", 	//Expected data format from server
                        }).done(function (data) {
                            console.log(data);
                            });
                        refresh2();
                });
                function refreshfeed() {
                    console.log("Refreshing");
                    $.ajax({
                        type: "POST", 		//GET or POST or PUT or DELETE verb
                        url: '../cronjob/listerqueue.php', 		// Location of the service
                        data: {hashkey : $('#hashkey123').val()}, 		//Data sent to server
                        dataType: "json", 	//Expected data format from server
                        processdata: true, 	//True or False
                    }).done(function (data) {
                        $('#refreshhere').empty();
                        console.log(data);
                        $.each( data, function( key, value ) {
                            var name_temp = value.name;
                            var qid_temp = value.qid;
                            var number = value.number;
                            $('#refreshhere').prepend('<div class="alert alert-info" id="refreshhere"><div class="row"><div class="col-xs-8" style="padding-top: 5px;"> <span class="glyphicon glyphicon-hand-up"></span><strong> Order from Id: </strong> '+qid_temp+' </div></div></div>');
                        });
                    });
                }
                setInterval(refreshfeed,3000);
            });


        </script>
        <script>

        </script>


    </div>



</div>
</body>
</html>

