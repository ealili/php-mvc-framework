<?php

namespace App\Models;

class User extends Model
{
    /**
     * Get the table name for the User model
     *
     * @return string
     */
    protected static function getTableName()
    {
        return "users";
    }
}
