<?php
/*Waseem Rkab And Hisham Mansour*/

require_once "dbWork.php";
$dbWork = new dbWork();

function printMessages($messages, $who) // true ? me : from
{
    $get = $who ? 'me' : 'from';
    echo "<div class={$get}>";
    for ($i = 0; $i < count($messages); $i++) {
        echo $messages[$i]['message'] . "<br>";
    }
    echo "</div>";
}

if (isset($_POST['exit'])) { // if end chat session was button pressed
    $dbWork = null;
}

if (isset($_GET['id']) && isset($_GET['sender'])) {
    $id = $_GET['id'];
    $sender = $_GET['sender'];
    $senderName = $dbWork->getTalkingWithName($sender);//gets the name of who im talking with in chat
    require_once "Chatting.htm";//need to put this here cause the variable inside htm is DEFINED and known after its set in GET array
    $chat = new Chat($id, $sender);
    $messages = $dbWork->getMyMessages($chat->getSend(), $chat->getRecieve());//get my messages from database
    printMessages($messages, true);
    $messages = $dbWork->getSentMessages($chat->getSend(), $chat->getRecieve());//get the messages the sender sent to me
    printMessages($messages, false);
    if (isset($_POST['message'])) {//if the send message button pressed , sets a new message and add it to chatlog databse
        $chat->setMessage($_POST['message']);
        $dbWork->addMessageToDatabase($chat);
        header("Refresh:0"); //stop page from refreshing and get the message , (prints the updated messsages again)
        exit;
    }
}
?>