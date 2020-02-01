<?php
/*Waseem Rkab And Hisham Mansour*/
require_once "User.php";
require_once "Chat.php";

class dbWork
{
    private $host;
    private $db;
    private $charset;
    private $user;
    private $pass;
    private $opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    private $connection;

    public function __construct(string $host = "localhost", string $db = "project", string $charset = "utf8", string $user = "root", string $pass = "")
    {
        $this->host = $host;
        $this->db = $db;
        $this->charset = $charset;
        $this->user = $user;
        $this->pass = $pass;
    }

    private function connect()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $this->connection = new PDO($dsn, $this->user, $this->pass, $this->opt);
    }

    public function disconnect()
    {
        $this->connection = null;
    }

    public function getHost()
    {
        return $this->host;
    }

    //checking if the user is valid (registration)
    public function checkR(User $user) : bool
    {
        $username = $user->getUsername();
        $email = $user->getEmail();
        $statement = $this->connection->prepare("SELECT * FROM users WHERE UserName = ?");
        $statement1 = $this->connection->prepare("SELECT * FROM users WHERE Email = ?");
        $statement->execute([$username]);
        $statement1->execute([$email]);
        $result = $statement->fetch();
        $result1 = $statement1->fetch();
        if ($result == null && $result1 == null)
            return true;
        return false;
    }

    // adding user to the database
    public function addUsertoDB(User $user)
    {
        $this->connect();
        if ($this->checkR($user) == true) {
            $sql_insert = "INSERT INTO users VALUES(?,?,?,?,?,?)";
            $statement = $this->connection->prepare($sql_insert);
            $statement->execute([null, $user->getUsername(), $user->getEmail(), $user->getFirstName(), $user->getLastName(), $user->getPassword()]);
            $linkToSignIn = "http://{$this->host}/ProjectSemester/SignIn.php";
            echo "<div class='style'>You are registered ,now you can <a href={$linkToSignIn}>Sign In</a></div>";
        } else echo "<div class='style'>This User Name or Email Already Exists!</div";
        $this->disconnect();
    }

    // checking SignIn if valid
    public function checkSignIn($user, $pass)
    {
        $this->connect();
        $statement = $this->connection->prepare("SELECT UserName,Password FROM users WHERE UserName = ?");
        $statement->execute([$user]);
        $result = $statement->fetch();
        if ($result == null)
            return false;
        //if the password is not the same as the user typed in sign in
        $this->disconnect();
        if (!password_verify($pass, $result['Password']))
            return false;
        return true;
    }
    //checking if the current user was logged in before , and forgot to log out
    public function checkIfAlreadySignedBefore($id, $username)
    {
        $this->connect();
        $sql_insert = "SELECT currentID FROM chat JOIN users 
        WHERE chat.currentID=:id AND users.UserName = :username AND chat.currentID=users.ID";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['id' => $id, 'username' => $username]);
        $result = $statement->fetch();
        $this->disconnect();
        if ($result == null) {
            return false;
        }
        return true;
    }
    //gets the current user ID that is logged in - from the databse
    public function getIDfromDatabase($username)
    {
        $this->connect();
        $sql_insert = "SELECT ID FROM users WHERE UserName = :username";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['username' => $username]);
        $this->disconnect();
        return $statement->fetch(PDO::FETCH_COLUMN);
    }
    //gets the the latest currentID from chat , online (currently last logged in)
    public function getCurrentIDfromChat()
    {
        $this->connect();
        $sql_insert = "SELECT currentID FROM chat";
        $statement = $this->connection->query($sql_insert);
        $this->disconnect();
        return $statement->fetch(PDO::FETCH_COLUMN);
    }
    // sets the currentID in databse , logged to system
    public function putCurrentIDtoChat($id)
    {
        $this->connect();
        $sql_insert = "INSERT INTO chat(currentID) VALUES(:id)";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['id' => $id]);
        $this->disconnect();
    }
    //Gets all names of the users that are registered in this Chat Web Site
    public function getNamesFromDatabase($id)
    {
        $this->connect();
        $sql_insert = "SELECT FirstName,LastName FROM users where id <>:id";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['id' => $id]);
        $result = $statement->fetchAll();
        $this->disconnect();
        return $result;
    }
    //logs out from the system
    public function logOutFromDatabase($id)
    {
        $this->connect();
        $sql_insert = "DELETE FROM chat WHERE currentID=:id";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['id' => $id]);
        $this->disconnect();
    }
    //gets the ID of the sender based from his fname and lname
    public function getSender($name)
    {
        $this->connect();
        $sql_insert = "SELECT ID FROM users WHERE FirstName=:Fname AND LastName=:Lname";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['Fname' => $name[0], 'Lname' => $name[1]]);
        $result = $statement->fetch(PDO::FETCH_COLUMN);
        $this->disconnect();
        return $result;
    }
    //chats someone, updates the sendtoID (the ID which i wanted to chat)
    public function addSendTo($sender, $id)
    {
        $this->connect();
        $sql_insert = "UPDATE chat SET sendToID=:sender WHERE currentID=:id";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['sender' => $sender, 'id' => $id]);
        $this->disconnect();
    }
    //gets the username of the the currently logged in user in the site
    public function getUserNameFromChat($id)
    {
        $this->connect();
        $sql_insert = "SELECT UserName FROM users JOIN chat WHERE chat.currentID = :id AND users.ID = :id2";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['id' => $id, 'id2' => $id]);
        $this->disconnect();
        return $statement->fetch(PDO::FETCH_COLUMN);
    }
    //deletes account , and his messages log
    public function delAccount($id) // delete account , with both messages
    {
        $this->connect();
        $sql_insert = "DELETE from users WHERE ID=:id";
        $sql_insert1 = "DELETE from chatlog WHERE fromID=:id";
        $statement = $this->connection->prepare($sql_insert);
        $statement1 = $this->connection->prepare($sql_insert1);
        $statement->execute(['id' => $id]);
        $statement1->execute(['id' => $id]);
        $this->disconnect();
        $this->logOutFromDatabase($id);
    }
    //gets my chat log , which with whom i have talked to.
    public function getMyChatLog($currentID) // your messages that u have sent to someone
    {
        $this->connect();
        $sql_insert = "SELECT FirstName,LastName,message,currentTime FROM chatlog JOIN users WHERE chatlog.toID = users.ID 
        AND chatlog.fromID = :currentID";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['currentID' => $currentID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect();
        return $result;
    }
    //gets the messages that the other users sent me messages
    public function getSentChatLog($currentID) // who sent you messages? , u get the messages , his name and the message
    {
        $this->connect();
        $sql_insert = "SELECT FirstName,LastName,message,currentTime FROM chatlog JOIN users WHERE chatlog.fromID = users.ID 
        AND chatlog.toID = :currentID";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['currentID' => $currentID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect();
        return $result;
    }
    //gets my email from database to send the mail of chatlog to it
    public function getMyEmail($id)
    {
        $this->connect();
        $sql_insert = "SELECT Email FROM users WHERE ID=:id";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['id' => $id]);
        $result = $statement->fetch(PDO::FETCH_COLUMN);
        $this->disconnect();
        return $result;
    }
    //gets my messages to display them in the conversion
    public function getMyMessages($id, $sender)
    {
        $this->connect();
        $sql_insert = "SELECT message FROM chatlog WHERE fromID=:id AND toID=:sender";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['id' => $id, 'sender' => $sender]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect();
        return $result;
    }
    //gets the sender messages,that he sent me messages
    public function getSentMessages($id, $sender)
    {
        $this->connect();
        $sql_insert = "SELECT message FROM chatlog WHERE fromID=:id AND toID=:sender";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['id' => $sender, 'sender' => $id]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->disconnect();
        return $result;
    }
    //puts the message that has been currently sent to the chatlog databse- table
    public function addMessageToDatabase($chat)
    {
        $this->connect();
        $sql_insert = "INSERT INTO chatlog VALUES(?,?,?,?)";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute([$chat->getSend(), $chat->getRecieve(), $chat->getMessage(), null]);
        $this->disconnect();
    }
    //gets the currently chatting with firstname and last name
    public function getTalkingWithName($id)
    {
        $this->connect();
        $sql_insert = "SELECT FirstName,LastName FROM users WHERE ID=:id";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['id' => $id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->disconnect();
        return $result;
    }

    public function someoneOnline($id, $name) // checking if someone is online (while another one trying to sign in)
    {
        $this->connect();
        $sql_insert = "SELECT currentID FROM chat JOIN users 
        WHERE chat.currentID<>:id AND users.UserName <> :username AND chat.currentID<>users.ID";
        $statement = $this->connection->prepare($sql_insert);
        $statement->execute(['id' => $id, 'username' => $name]);
        $result = $statement->fetch();
        if ($result == null)
            return false;
        return true;
    }
}
?>