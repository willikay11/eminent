<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/20/17
 * Time: 7:36 PM
 */
namespace eminent\Exceptions;

use Exception;

class AuthorizationFailedException extends Exception
{
    public function __construct($message)
    {
        $message = "Access Denied: You cannot " . strtolower($message);

        parent::__construct($message);
    }
}