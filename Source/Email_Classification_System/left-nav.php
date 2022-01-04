
<?php
require_once("functions.php");
// Links for logged in user
if (isUserLoggedIn()) { ?>

    <ul>
        <li><a href='myaccount.php'>Account Home</a></li>
        <li><a href="yourSubmissions.php">My submissions</a></li>
        <li><a href="ViewAllSubmissions.php"> View All submissions</a></li>
        <li><a href="Analyze_Tool.php"> Analyze Tool</a></li>
        <li><a href='logout.php'>Logout</a></li>

<?php } else { ?>

    <ul>
        <li><a href='index.php'>Home</a></li>

    </ul>
<?php } ?>
