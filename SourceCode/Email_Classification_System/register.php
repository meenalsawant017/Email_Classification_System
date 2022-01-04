<?php

require_once("config.php");
//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: myaccount.php"); die(); }



//Forms posted
if(!empty($_POST))
{
	$errors = array();
    $successes = array();
	$email = trim($_POST["email"]);
	$username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_pass = trim($_POST["passwordc"]);
    $legal_name = trim($_POST["legal_name"]);
	$company = $_POST["company"];



    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[]    = "Invalid email format";
    }

	if($username == "")
	{
		$errors[] = "Enter valid username";
	}



    if ($company == '0') {
        $errors[] = "Please select Organisation name";
    }


	if($password == "")
	{
		$errors[] = "Enter valid password";
	}

	if($confirm_pass == "")
	{
		$errors[] = "Enter valid password";
	}

	if($email == "")
	{
		$errors[] = "Enter valid email address";
	}


	if($password =="" && $confirm_pass =="")
	{
		$errors[] = "Enter password";
	}
	else if($password != $confirm_pass)
	{
		$errors[] = "password do not match";

	}

	//End data validation
	if(count($errors) == 0)
	{

        try {
            $user = createNewUser($username, $legal_name, $company, $email, $password);
        }
        catch (Exception $e) {
            $errors[] = "Username/Email Exist";

        }
		if($user <> 1){
			$errors[] = "Username/Email Exist";
		}

	}
	if(count($errors) == 0) {
		$successes[] = "Registration Successful";
	}
}

require_once("header.php");
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
            <h4><p>Create a New User</p></h4>
<br>


                <div id="regbox">
					<form name="newUser" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                        <tr><td>	<label>Email ID:</label></td>
                            <td align="center">	<input type="text" name="email" required></td></tr><br>

                        <tr><td><label>UserName:</label></td>
                            <td align="center"><input type="text" name="username" required/></td></tr><br>

                        <tr><td>	<label>Password :</label><td>
                            <td align="center">	<input type="text" name="password" required/></td></tr><br>

                        <tr><td>		<label>Re-enter Password:</label></td>
                            <td align="center">	<input type="text" name="passwordc" required/></td></tr><br>

                        <tr><td><label>LegalName:</label></td>
                            <td align="left"><input type="text" name="legal_name" /></td></tr><br>

                        <tr><td><label>Organisation:</label></td></tr></tr>
                            <select name = 'company'>
                            <option value="Select">Select</option>}
                            <option value=1>HeartGold</option>}
                            <option value=2>IPM Technologies</option>
                            <option value=3>F3 Inc.</option>
                            </select>

                        <label></label>&nbsp;
						<br>
                        <br>
						<input type="submit" value="Register"/>

                        <?php foreach($errors as $err):?>
                            <li><?php echo $err; ?></li>
                        <?php endforeach; ?>

                        <?php foreach($successes as $sucess):?>
                            <li><?php echo $sucess; ?></li>
                            <li><a href='login.php'>Click here to login.</a></li>
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

