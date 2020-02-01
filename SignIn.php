<?php
/*Waseem Rkab And Hisham Mansour*/

require_once "dbWork.php";
require_once "SignIn.htm";
if (isset($_POST['name']) && isset($_POST['password'])) {
    $dbWork = new dbWork();
    $host = $dbWork->getHost();
    $name = $_POST['name'];
    $password = $_POST['password'];

    if ($dbWork->checkSignIn($name, $password)) { //user validation successfully
        $id = $dbWork->getIDfromDatabase($name);
        if ($dbWork->someoneOnline($id, $name)) { // if someone is online , 
            //we would not let him chat until the other that's currently online user logs out.
            echo "<div>Someone is already Signed in !, Wait </div>";
            exit;
        }
        if ($dbWork->checkIfAlreadySignedBefore($id, $name)) { // if user was already logged in before , and forgot to logout
            $dbWork->logOutFromDatabase($id);//need to log him out from database , then resign in
        }
        $dbWork->putCurrentIDtoChat($id);
        header("Location:http://{$host}/ProjectSemester/HomePage.php"); // go to homepage
        exit;
    } else { // the username or password was invalid
        echo "<div>Invaild Username Or Password! </div>";
    }
}
?>