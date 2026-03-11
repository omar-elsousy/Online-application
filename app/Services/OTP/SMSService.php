<?php

namespace App\Services\OTP;

use Illuminate\Support\Facades\Http;

class SMSService
{
    public function sendSMS(string $mobileNumber, string $message)
    {
        $uri = '/JSON/API/A2A/SendSMS';

        $requestBody = [
            "BankCode" => 'MANSOUR',
            "BankPWD"  => 'Man@Orange',
            "SenderID" => 'MANSOUR-DIS',
            "MsgText"  => $message,
            "MobileNo" => '+2' . $mobileNumber
        ];

        return Http::withoutVerifying()
                    ->post('https://marketingportal.access2arabia.com:7755' . $uri, $requestBody);
    }
}