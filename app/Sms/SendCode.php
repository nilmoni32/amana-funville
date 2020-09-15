<?php

namespace App\Sms;
use GuzzleHttp\Client;

class SendCode{

    public static function sendCode($mobile, $code){   

        // Nexmo package : to send sms to mobile number.
                                 
        // $nexmo = app('Nexmo\Client');
        // $nexmo->message()->send([
        //     'to'   => ,
        //     'from' => 'Amana Funville',
        //     'text' => 'Verification Code:' . $code,
        // ]);  

        // GuzzleHttp\Client : send message to mobile number   
        
        // $api = 'b3c6b0eda3b46d9878df961d4c1c6b07d6cf886d';
        // $mobile = '880'. (int) $mobile;
        // $sender_id = '8801552146120';

        // $client = new Client(['base_uri' => 'https://portal.smsinbd.com/smsapi']);
        // $response = $client->request('GET', '?api_key='.$api.'&type=text&senderid='.$sender_id.'&contacts='.$mobile.'&msg=Verification+Code%3A+'.$code.'&method=api');

        


        //php curl method : sending message to mobile.

         $post_url = 'https://portal.smsinbd.com/smsapi' ;

            $post_values = array(
            'api_key' => 'b3c6b0eda3b46d9878df961d4c1c6b07d6cf886d',
            'type' => 'text', 
            'senderid' => '8801552146120',
            'contacts' => '880'. (int) $mobile,
            'msg' => 'Verification Code: ' . $code,
            'method' => 'api'
            );

            $post_string = "";
            foreach( $post_values as $key => $value )
            { $post_string .= "$key=" . urlencode( $value ) . "&"; }
            $post_string = rtrim( $post_string, "& " );


            $request = curl_init($post_url);
            curl_setopt($request, CURLOPT_HEADER, 0);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($request, CURLOPT_POST, 1);
            curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
            $post_response = curl_exec($request);
            curl_close ($request);


 
    }

}