<?php
namespace App\Helper;

use App\Models\User;
use GuzzleHttp\Client;

class NotificationHelper
{
    protected $client;


    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function sendNotification($message, $id)
    {

        $user = User::where('user_id', $id)->first();
        $token = $user->token;

        $url = "https://fcm.googleapis.com/fcm/send";

        try{
            $headers = [
                'Authorization' => "Key=".env('FCM_SERVER_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];

            $response = $this->client->request('POST', $url,[
                'headers' => $headers,
                'json' => [
                    'to' => $token,
                    'notification' => [
                        'title' => "Hello Title",
                        'message' => $message
                    ]
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                return true;
            }else{
                return false;
            }
        }catch (\Exception $e){
            return $e;
        }

    }

}