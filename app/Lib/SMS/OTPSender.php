<?php

namespace App\Lib\SMS;

class OTPSender
{
    protected $sender;

    public function __construct(ISMSSender $sender)
    {
        $this->sender = $sender;
    }

    public function sendOTP(string $phone, $otp): bool
    {
        $company = config('app.name');
        $otpText = <<<EOT
Your Verification Code is $otp

Don't share it with anyone.

From : $company
EOT;

        return $this->sender->send($phone, $otpText);
    }

    public function generateOTP(int $digits = 6): int
    {
        return random_int(10 ** ($digits - 1), (10 ** $digits) - 1);
    }
}
