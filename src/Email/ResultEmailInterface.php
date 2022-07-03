<?php

namespace App\Email;

interface ResultEmailInterface {

    public function buildResultEmail(array $emailData) : string;
}