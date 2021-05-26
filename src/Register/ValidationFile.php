<?php

namespace App\Register;

use App\Auth;
use App\Database;
use App\User;

class ValidationFile
{
    private $username;
    private $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
    
    /**
     * isValid the validation for the filed in the login
     *
     * @return bool
     */
    public function isValid() : bool
    {
        if(empty($this->username) || empty($this->password)){
            return false;
        }
        return true;
    }
    
    /**
     * loginUser
     *
     * @return User
     */
    public function loginUser() : ?User
    {
        if($this->isValid()){
            $auth = new Auth(Database::getPdo(), "/dashboard");
            $user =  $auth->login($_POST["pseudo"], $_POST["password"]);
            if($user){
                return $user;
            }
            return null;
        }
    }

}