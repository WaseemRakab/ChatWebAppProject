<?php
/*Waseem Rkab And Hisham Mansour*/
class Chat
{
    protected $send; // the current id , in the chat session
    protected $recieve; // who to talk to ? , based on it's id
    protected $message; // the current message

    public function __construct($send, $recieve, $message = "")
    {
        $this->send = $send;
        $this->recieve = $recieve;
        $this->message = $message;
    }
    
    // automatic getters and setters
    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of send
     */
    public function getSend()
    {
        return $this->send;
    }

    /**
     * Set the value of send
     *
     * @return  self
     */
    public function setSend($send)
    {
        $this->send = $send;

        return $this;
    }

    /**
     * Get the value of recieve
     */
    public function getRecieve()
    {
        return $this->recieve;
    }

    /**
     * Set the value of recieve
     *
     * @return  self
     */
    public function setRecieve($recieve)
    {
        $this->recieve = $recieve;

        return $this;
    }
}
?>