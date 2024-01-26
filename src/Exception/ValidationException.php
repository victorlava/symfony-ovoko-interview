<?php

namespace App\Exception;

class ValidationException extends \Exception
{
    public function __construct(private readonly array $messages)
    {
        $joinedMessage = implode('. ', $messages);

        parent::__construct($joinedMessage);
    }
}
