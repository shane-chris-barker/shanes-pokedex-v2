<?php

namespace App\Message;

use App\Email\ResultEmail;

class SendResultEmail {

    public ResultEmail $resultEmail;

    public function __construct(ResultEmail $resultEmail)
    {
        $this->resultEmail = $resultEmail;
    }

}