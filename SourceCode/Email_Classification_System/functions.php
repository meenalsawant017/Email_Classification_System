<?php
function destroySession($name)
{
    if (isset($_SESSION[$name])) {
        $_SESSION[$name] = NULL;
        unset($_SESSION[$name]);
    }
}

function isUserLoggedIn()
{
    global $loggedInUser, $mysqli, $db_table_prefix;

    if ($loggedInUser == NULL) {
        return false;
    }
    $stmt = $mysqli->prepare("SELECT
		username,
		password
		FROM " . $db_table_prefix . "users
		WHERE
		username = ?
		AND
		password = ?
		
		LIMIT 1");

    //$loggedInUser="ab";
    //echo $loggedInUser;
    $stmt->bind_param("ss", $loggedInUser->username, $loggedInUser->hash_pw);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($loggedInUser == NULL) {
        return false;
    } else {
        if ($num_returns > 0) {
            return true;
        } else {
            destroySession("ThisUser");
            return false;
        }
    }
}




//$password = md5("Smith");
//echo $password."<br><br>";
//$code = md5(uniqid(rand(), TRUE));
//echo $code;


//Generate a unique code
/**
 * @param string $length
 * @return string
 */
function getUniqueCode($length = "")
{
    //$code = md5(uniqid(rand(), TRUE));
    $code = md5(rand(), TRUE);
    if($length != "") {
        return substr($code, 0, $length);
    } else {
        return $code;
    }
}


//$plainText = getUniqueCode(15);
//echo $plainText;


/**
 * @param $plainText
 * @param null $salt
 * @return string
 */
function generateHash($plainText, $salt = NULL)
{
    if($salt == NULL) {
        $salt = substr(md5(uniqid(rand(), TRUE)), 0, 25);
        //$salt = substr(md5(rand(), TRUE), 0, 25);
    } else {
        //echo 'else salt';
        $salt = substr($salt, 0, 25);

    }
    //echo $salt;
    //echo '**';
    //echo $salt . sha1($salt . $plainText);
    return $salt . sha1($salt . $plainText);

}


//echo $newpassword;
//$compare = generateHash($_POST['password'], $newpassword);
//echo $compare;

/**
 * @param $username
 * @param $legal_name
 * @param $company
 * @param $email
 * @param $password
 * @return bool
 */
function createNewUser($username, $legal_name, $company, $email, $password)
{
    global $mysqli, $db_table_prefix;
    //Generate A random userid

    //$character_array = array_merge(range(a, z), range(0, 9));
    //$rand_string = "";
    //for($i = 0; $i < 6; $i++) {
    //    $rand_string .= $character_array[rand(
    //        0, (count($character_array) - 1)
    //    )];
    //}
    //echo $rand_string;
    //echo $username;
    //echo $firstname;
    //echo $lastname;
    //echo $email;
    //echo $password;

    $newpassword = generateHash($password);

    //echo $newpassword;

    $stmt = $mysqli->prepare(
        "INSERT INTO " . $db_table_prefix . "users (
		username,
		legal_name,
		organisation_id,
		email,
		password
		
		)
		VALUES (
		
		?,
		?,
		?,
		?,
		?
		)"
    );
    $stmt->bind_param("sssss", $username, $legal_name, $company, $email, $newpassword);
    //print_r($stmt);
    $result = $stmt->execute();
    //print_r($result);
    $stmt->close();
    return $result;

}

function fetchUserDetails($username)
{

    global $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare("SELECT
        user_id,
        username,
		legal_name,
		organisation_id,
		email,
		password
		FROM " . $db_table_prefix . "users
		WHERE
		username = ?
		LIMIT 1
	");
    $stmt->bind_param("s", $username);
    //print_r($stmt);
    $stmt->execute();
    $row="";
    $stmt->bind_result($UserID, $UserName, $legal_name, $company, $email, $Password);
    while ($stmt->fetch()) {
        $row = array('UserID' => $UserID,
            'UserName' => $UserName,
            'LegalName' => $legal_name,
            'Orgainsation_id' => $company,
            'Email' => $email,
            'Password' => $Password
        );
    }
    $stmt->close();
    return ($row);
}

function fetchUserSubmissions_org()
{

    global $loggedInUser, $mysqli, $db_table_prefix;
    $stmt = $mysqli->prepare("SELECT
        u.user_id, 
        s.submission_id, 
        s.submission_path, 
        s.class_name, 
        u.organisation_id 
        FROM `submissions` s
        inner join users u
        on u.user_id = s.user_id
        WHERE u.organisation_id  = (SELECT organisation_id from users where user_id = ?)
		");
    $stmt->bind_param("s", $loggedInUser->user_id);
    $stmt->execute();
    $stmt->bind_result($user_id, $sid, $Path, $ClassName, $User_org);
    while ($stmt->fetch()) {
        $row[] = array(
            'user_id' => $user_id,
            'submission_id'=>$sid,
            'path' => $Path,
            'class_name' => $ClassName,
            'User_Org' =>$User_org

        );
    }
    $stmt->close();
    return ($row);
}

function fetchUserSubmissions()
{
    global $loggedInUser, $mysqli;

    $stmt = $mysqli->prepare("SELECT
		
		submission_id,
		submission_path,
		class_name,
		user_id
		FROM submissions
		where
		user_id = ?
		");
    $stmt->bind_param("s", $loggedInUser->user_id);
    $stmt->execute();
    $stmt->bind_result($submission_id,$submission_path, $class_name, $userid);
    //$stmt->execute();
    while ($stmt->fetch()) {
        $row[] = array(
            'submission_id' => $submission_id,
            'submission_path' => $submission_path,
            'class_name' => $class_name,
            'UserID' => $userid
        );
    }
    $stmt->close();
    return ($row);

}

function getCountofOrganisations(){
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT
		count(users.user_id), 
		users.organisation_id 
		from submissions
        INNER join users
        on users.user_id = submissions.user_id
        GROUP by users.organisation_id
		");

    $stmt->execute();
    $stmt->bind_result(
        $count,
        $org_id
    );
    while ($stmt->fetch()){
        $row[] = array(
            'count' => $count,
            'org_id'=> $org_id
        );
        //echo "cnt",$count;
        //echo "org",$org_id;
    }
    $stmt->close();


    return ($row);
}

function getCountofUserSubmissions()
{
    global $loggedInUser, $mysqli;

    $stmt = $mysqli->prepare("SELECT
		count(submissions.user_id), 
		users.organisation_id     
        from submissions
        INNER join users
        on users.user_id = submissions.user_id
        where users.user_id = ?
		");
    $stmt->bind_param("s", $loggedInUser->user_id);
    $stmt->execute();
    $stmt->bind_result($countUID, $org_id);
    //$stmt->execute();
    while ($stmt->fetch()) {
        $row[] = array(
            'count' => $countUID,
            'org_id' => $org_id
        );
    }
    $stmt->close();
    return ($row);

}




