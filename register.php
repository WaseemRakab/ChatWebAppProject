<?php
/*Waseem Rkab And Hisham Mansour*/

require_once "Register.htm";
require_once "dbWork.php";

$dbWork = new dbWork();
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pword']) && isset($_POST['confirm'])
    && isset($_POST['fname']) && isset($_POST['lname'])) {
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { // if the value is an actual validated email
        if (!strcmp($_POST['confirm'], $_POST['pword'])) { // if the password and confirm password are the same
            $user = new User($_POST['name'], $_POST['email'], $_POST['fname'], $_POST['lname'], $_POST['pword']);
            $dbWork->addUsertoDB($user);//puts the user details to the database
        } else
            echo "<div>Incorrect Password!</div>";
    } else echo "<div>Invalid Email</div>";
}
unset($dbWork);
?>