<?php

namespace App\Lib\SMS;

use Illuminate\Support\Facades\Http;

class AjuratechSMSSender implements ISMSSender
{
    protected $apiUrl;

    protected $apiKey;

    protected $secret;

    protected $callerID;

    public function __construct($apiUrl, $apiKey, $secret, $callerID)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->secret = $secret;
        $this->callerID = $callerID;
    }

    public function send($toUser, $message): bool
    {
        $phone = preg_replace('/^\+?8?8?/', '', preg_replace('/\D/', '', $toUser));

        if (strlen($phone) !=  11) {
            return false;
        }

        $response = Http::timeout(3)->get($this->apiUrl, [
            'apikey' => $this->apiKey,
            'secretkey' => $this->secret,
            'callerID' => $this->callerID,
            'toUser' => $phone,
            'messageContent' => $message,
        ]);

        if ($response->status() !== 200) {
            report(new \Exception('Got status code '.$response->status().' while sending sms to '.$phone));
            return false;
        } else {
            if ($response->json('Status') !== '0') {
                report(new \Exception('Unaccepted response while sending sms to '.$phone.'. Response : '.$response->body()));
                return false;
            }
        }

        return true;
    }
}
