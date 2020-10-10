<?php

namespace app\models;

use core\base\Model;

class User extends Model {
    public $id;
    public $username;
    public $email;
    public $password;
    protected static $table = 'users';
}