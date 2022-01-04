<?php

require_once("config.php");


//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: myaccount.php"); die(); }



//Forms posted
if(!empty($_POST))
{
    $errors = array();
    $success = array();
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    //Perform some validation

    if($username == "")
    {
        $errors[] = "Enter username";
    }
    if($password == "")
    {
        $errors[] = "Enter password";
    }

    if(count($errors) == 0)
    {
        //retrieve the records of the user who is trying to login
        $userdetails = fetchUserDetails($username);
        if(!$userdetails)
        {
            $errors[] = "No Account found";
        }
        //See if the user's account is activated

        ///Hash the password and use the salt from the database to compare the password.

        else {
            $entered_pass = generateHash($password, $userdetails["Password"]);
            //echo "entered password : " . $entered_pass . "<br><br>";
            //echo "";
            //echo "database password : " . $userdetails['Password'];


            if ($entered_pass != $userdetails["Password"]) {

                $errors[] = "invalid password";

            } else {
                //Passwords match! we're good to go'
                //Transfer some db data to the session object
                $loggedInUser = new loggedInUser();


                $loggedInUser->user_id = $userdetails["UserID"];
                $loggedInUser->username = $userdetails["UserName"];
                $loggedInUser->legal_name = $userdetails["LegalName"];
                $loggedInUser->hash_pw = $userdetails["Password"];
                $loggedInUser->Orgainsation_id = $userdetails["Orgainsation_id"];
                $loggedInUser->email = $userdetails["Email"];


                //pass the values of $loggedInUser into the session -
                // you can directly pass the values into the array as well.

                $_SESSION["ThisUser"] = $loggedInUser;
                if(isUserLoggedIn()) { header("Location: myaccount.php"); die(); }

                //now that a session for this user is created
                //Redirect to this users account page
                //header("Location: myaccount.php");
                //die();
            }

        }
    }
}
?>

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
<body>

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
                <h4>Enter the below details:</h4>



                <div id="regbox">
                    <form name="login" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                        <h6>
                            <label style="font-size:15px;">Username:</label>
                            <input style="font-size:15px;" type="text" name="username" required/>
                        </h6>
                        <h6>
                            <label style="font-size:15px;">Password:</label>
                            <input style="font-size:15px;" type="password" name="password" required/>
                        </h6>
                        <p>
                            <label>&nbsp;</label>
                            <input style="font-size:15px;" type="submit" value="Login" class="submit" />
                        </p>
                        <?php foreach($errors as $err):?>
                            <li><?php echo $err; ?></li>
                        <?php endforeach; ?>


                    </form>
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






