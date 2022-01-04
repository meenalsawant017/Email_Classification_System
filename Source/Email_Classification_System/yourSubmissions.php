<?php
include_once("config.php");

$thisUser = fetchUserSubmissions();


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
<>

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
            <div class="jumbotron">

                <h4><p>My Submission Records:</p></h4>

                <div  style="max-height:300px;overflow:auto;">


                <table style="width:100%" border: 1px solid white;
                       border-collapse: collapse;>
                    <col style="width:30%">
                    <col style="width:30%">
                    <col style="width:30%">
                    <col style="width:30%">
                    <col style="width:30%">
                    <col style="width:30%">
        <thead>
        <th>SID</th>
        <th>Path</th>
        <th>Class Name</th>
        <th>UID</th>
        </thead>
        <tbody>
        <?php

        ?>

        <?php
        if($thisUser)
        {

        foreach($thisUser as $displayRecords) { ?>
            <tr>
                <td class="buttonCell"><?php print $displayRecords['submission_id']; ?></a></td>
                <td><?php print $displayRecords['submission_path']; ?></td>
                <td><?php print $displayRecords['class_name']; ?></td>
                <td><?php print $displayRecords['UserID']; ?></td>

            </tr>
        <?php }
        }
        else
        {
        echo "No Records Found."; ?> <br> </br> <?php
        }
        ?>
        </tbody>
    </table>
                </div>
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

