<?php
include_once("config.php");

$data = getCountofOrganisations();
$countUser = getCountofUserSubmissions();

//print_r($data);
//print_r($countUser);
?>

<body>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }

        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content {height: 450px}

        /* Set gray background color and 100% height */
        .sidenav {
            padding-top: 20px;
            background-color: #f1f1f1;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }
        table, th, td {
            border: 1px solid black;

            border-collapse: collapse;
        }
        tr
        {
            line-height: 25px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {height:auto;}
        }
    </style>
</head>


<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>

            </ul>

        </div>
    </div>
</nav>


<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-2 sidenav">
            <?php include("left-nav.php"); ?>

        </div>
        <div class="col-sm-8 text-left">
            <br>

                <html>
                <head>
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                        google.charts.load("current", {packages:["corechart"]});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Org', 'Submissions'],
                                <?php

                                foreach($data as $displayRecords)
                                {
                                    if($displayRecords['org_id'] == $countUser[0]['org_id'])
                                    {  ?>
                                        [
                                            'Me' ,
                                            <?php print $countUser[0]['count']; ?>
                                        ],
                                        [
                                            'My Org' ,
                                            <?php print ($displayRecords['count'] - $countUser[0]['count']); ?>
                                        ],
                                    <?php
                                    }
                                    else
                                    { ?>
                                        [
                                            'Other Org '+<?php print $displayRecords['org_id']; ?> ,
                                            <?php print $displayRecords['count']; ?>
                                        ],
                                    <?php
                                    }
                                } ?>

                            ]);

                            var options = {
                                title: 'Analyze Submissions.',
                                is3D: true,
                            };

                            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                            chart.draw(data, options);
                        }
                    </script>
                </head>
                <body>
                <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
                </body>
                </html>

            </div>
        </div>

        <div class="col-sm-2 sidenav">


        </div>

    </div>



</div>

<footer class="container-fluid text-center">
    <p></p>
</footer>
</body>
</html>



