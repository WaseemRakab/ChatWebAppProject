<?php
/*Waseem Rkab And Hisham Mansour*/

require_once "dbWork.php";

function selectNames($items) : string // selects the names that are registered in the database
{
    $text = " ";
    foreach ($items as $v) {
        $text .= "<option>" . implode(" ", $v) . "</option>\n";
    }
    return $text;
}

function getLogChatAndConvertToText($log, $who) //gets the chat log bases on the username , myMessages ? true : who sent
{
    if ($who) {
        $text = "Your Messages : " . "\n";
        for ($i = 0; $i < count($log); $i++) {
            $text .= "To : " . $log[$i]['FirstName'] . " " . $log[$i]['LastName'] . " message : " . $log[$i]['message'] .
                " Time Sent : " . $log[$i]['currentTime'] . "\n";
        }
    } else {
        $text = "\nWho talked to you ? Messages : " . "\n";
        for ($i = 0; $i < count($log); $i++) {
            $text .= "From : " . $log[$i]['FirstName'] . " " . $log[$i]['LastName'] . " message : " . $log[$i]['message'] .
                " Time Sent : " . $log[$i]['currentTime'] . "\n";
        }
    }
    return $text;
}

function putChatLogToFile($text) // puts the chat log in a file
{
    file_put_contents(ChatLog, $text);
}

$dbWork = new dbWork();
$host = $dbWork->getHost(); // for making sure its the right address
$id = $dbWork->getCurrentIDfromChat();//my current id where i signed in
$currName = $dbWork->getUserNameFromChat($id); // my username which i signed in
$names = $dbWork->getNamesFromDatabase($id); // all the names that are available to chat
?>

<?php
require_once "HomePage.htm";
define("ChatLog", "ChatLog.txt");

if (isset($_POST['logout'])) { // sign out 
    $dbWork->logOutFromDatabase($id);
    header("Location:http://{$host}/ProjectSemester/SignIn.php");
    exit;
}
if (isset($_POST['delAcc'])) { // chooses to delete the account , and all his chat messages
    $dbWork->delAccount($id);
    header("Location:http://{$host}/ProjectSemester/SignIn.php"); // goes to sign in page
    exit(0);
}

if (file_exists(ChatLog)) { // if the file is already sent before , it will be deleted
    unlink(ChatLog);
}
$myChatLog = $dbWork->getMyChatLog($id);//get my chat log
$sentChatLog = $dbWork->getSentChatLog($id);//get the sender chat log (the messages that he/she sent me)
$text = getLogChatAndConvertToText($myChatLog, true);//put them to string
$text .= getLogChatAndConvertToText($sentChatLog, false);//that too

if (isset($_POST['export'])) { // export the chat log to a file
    fopen(ChatLog, "a");
    putChatLogToFile($text);
    echo "<div class='style'>Your Chat Log Has been Saved in a File.</div>";
}

if (isset($_POST['mail'])) { // sends the chat log in his email
    $email = $dbWork->getMyEmail($id);
    mail($email, "Chat Log", $text, 'From: Admin' . "\r\n");
    echo "<div class='style'>Your Chat Log Has been Saved in your Email.</div>";
}

if (isset($_POST['sel']) && isset($_POST['start'])) {//First Name, Last Name is in POST[sel]
    if (!strcmp($_POST['sel'], "None")) {
        echo "<div class='style'>You Must Choose Someone to talk to !</div>";
    } else {
        $sender = $dbWork->getSender(explode(" ", $_POST['sel'])); // the id u choose to message
        $dbWork->addSendTo($sender, $id);
        header("Location:http://{$host}/ProjectSemester/Chatting.php?id=" . $id . "&sender=" . $sender);
        unset($dbWork);
        exit;
        //sends the current username id and sender id to the chat via GET Method
    }
}
?>