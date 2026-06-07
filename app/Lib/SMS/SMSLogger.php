<?php

namespace App\Lib\SMS;

use Illuminate\Support\Facades\Log;

class SMSLogger implements ISMSSender
{
    public function send(string $phone, string $message): bool
    {
        Log::info("Sending SMS to $phone : " . PHP_EOL . $message . PHP_EOL);
        return true;
    }
}
