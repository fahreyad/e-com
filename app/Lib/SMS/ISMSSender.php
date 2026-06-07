<?php

namespace App\Lib\SMS;

interface ISMSSender
{
    public function send(string $phone, string $message): bool;
}
