<?php
require_once __DIR__."/Profile.php";

class Owner extends Profile
{
    function createAccount($password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $GLOBALS['DB']->prepare("INSERT INTO owners (first_name, last_name, email_address, password, role) VALUES (:first_name, :last_name, :email_address, :password, :role)");

        $stmt->bindParam(':first_name', $this->getFirstName(), PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $this->getLastName(), PDO::PARAM_STR);
        $stmt->bindParam(':email_address', $this->getEmailAddress(), PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $this->getRole(), PDO::PARAM_STR);
        $stmt->execute();

        $this->setId($GLOBALS['DB']->lastInsertId());
    }

    function findOwnerByEmailAddress($email_address)
    {
        $stmt = $GLOBALS['DB']->prepare("SELECT * FROM owners WHERE email_address = :email_address");
        $stmt->bindParam(':email_address', $email_address, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $result = $stmt->fetch();
            if ($result) {
              return new Owner($result['first_name'], $result['last_name'], $result['email_address'], $result['role'], $result['id'], $result['password']);
            } else {
              return false;
            }
        } else {
          return false;
        }
    }

    function findOwnerById($owner_id)
    {
        $stmt = $GLOBALS['DB']->prepare("SELECT * FROM owners WHERE id = :id");
        $stmt->bindParam(':id', $owner_id, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetch();
            if ($result) {
              return new Owner($result['first_name'], $result['last_name'], $result['email_address'], $result['role'], $result['id'], $result['password']);
            } else {
              return false;
            }
        } else {
          return false;
        }
    }
}
