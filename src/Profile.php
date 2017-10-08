<?php
class Profile
{
    private $id;
    private $first_name;
    private $last_name;
    private $email_address;
    private $password;
    private $role;

    function __construct($first_name, $last_name, $email_address, $role, $id = null, $password = null)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email_address = $email_address;
        $this->role = $role;
        $this->id = $id;
        $this->password = $password;
    }

    function getId()
    {
        return $this->id;
    }

    function getFirstName()
    {
        return  $this->first_name;
    }

    function getLastName()
    {
        return  $this->last_name;
    }

    function getEmailAddress()
    {
        return $this->email_address;
    }

    function getPassword()
    {
        return $this->password;
    }


    function getRole()
    {
        return $this->role;
    }

    function setId($new_id)
    {
        $this->id = $new_id;
    }

    function setFirstName($new_first_name)
    {
        $this->first_name = $new_first_name;
    }

    function setLastName($new_last_name)
    {
        $this->last_name = $new_last_name;
    }

    function setEmailAddress($new_email_address)
    {
        $this->email_address = $new_email_address;
    }

    function setPassword($new_password)
    {
        $this->password = $new_password;
    }

    function setRole($new_role)
    {
        $this->role = $new_role;
    }
}
