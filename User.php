<?php
/*Waseem Rkab And Hisham Mansour*/
class User
{
    protected $UserName; // account username
    protected $Email; // his email
    protected $FirstName; // his first name
    protected $LastName; // last name
    protected $Password; // password

    public function __construct($UserName, $Email, $FirstName, $LastName, $Password)
    {
        $this->UserName = $UserName;
        $this->Email = $Email;
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
        $this->Password = password_hash($Password, PASSWORD_DEFAULT);
    }

    //automatic Getters and Setters
    /**
     * Get the value of UserName
     */
    public function getUserName()
    {
        return $this->UserName;
    }

    /**
     * Set the value of UserName
     *
     * @return  self
     */
    public function setUserName($UserName)
    {
        $this->UserName = $UserName;

        return $this;
    }

    /**
     * Get the value of Email
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * Set the value of Email
     *
     * @return  self
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * Get the value of Password
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * Set the value of Password
     *
     * @return  self
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;

        return $this;
    }

    /**
     * Get the value of FirstName
     */
    public function getFirstName()
    {
        return $this->FirstName;
    }

    /**
     * Set the value of FirstName
     *
     * @return  self
     */
    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    /**
     * Get the value of LastName
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * Set the value of LastName
     *
     * @return  self
     */
    public function setLastName($LastName)
    {
        $this->LastName = $LastName;

        return $this;
    }
}
?>