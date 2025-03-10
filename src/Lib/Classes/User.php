<?php

Namespace Application\Lib\Classes;
    
class User
{
    
    private int $userId;
    private string $firstname;
    private string $lastname;
    private string $email;
    private bool $isAdmin;
    
    public function __construct(array $user)
    {
        $this->userId = $user['user_id'];
        $this->firstname = $user['firstname'];
        $this->lastname = $user['lastname'];
        $this->email = $user['email'];
        $this->isAdmin = $user['is_admin'];
    }
    
    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId(int $data)
    {
        $this->userId = $data;
    }
    
    
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname(string $data)
    {
        $this->firstname = $data;
    }
    
    
    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname(string $data)
    {
        $this->lastname = $data;
    }
    
    
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $data)
    {
        $this->email = $data;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $data)
    {
        $this->isAdmin = $data;
    }
    
}