<?php

namespace App\Services;

class Billplz{

    // public static function auth(){

    //     $host = 'https://www.billplz.com/api/v4/webhook_rank';
    //     $api_key = '3f78dfad-7997-45e0-8428-9280ba537215';
    //     $process = curl_init($host);
    //     curl_setopt($process, CURLOPT_USERPWD, $api_key . ":");
    //     $return = curl_exec($process);
    //     echo $return;

    // }
    

    // public static function get_payment_codes(){

    //     $host = 'https://www.billplz.com/api/v4/payment_gateways';
    //     $api_key = '3f78dfad-7997-45e0-8428-9280ba537215';
    //     $process = curl_init($host);
    //     curl_setopt($process, CURLOPT_USERPWD, $api_key . ":");
    //     $return = curl_exec($process);
    //     echo $return;

    // }

    // public static function create_collection(){

    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://www.billplz.com/api/v3/collections',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => array('title' => 'aaa'),
    //         CURLOPT_HTTPHEADER => array(
    //             'Authorization: Basic M2Y3OGRmYWQtNzk5Ny00NWUwLTg0MjgtOTI4MGJhNTM3MjE1Og=='
    //         ),
    //     ));

    //     $response = json_decode(curl_exec($curl));

    //     curl_close($curl);

    //     $id = $response->id;

    //     return $id;
    // }

    public static function create_bill($stud, $lvl, $invoice){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.billplz.com/api/v3/bills',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'collection_id' => 'pszpi_yy',
                'email' => $stud->email,
                'mobile' => $stud->phoneno,
                'name' => $stud->first_name,
                // 'amount' => $lvl->price.'00',
                'amount' => '100',
                'description' => 'Payment for '.$lvl->name,
                // 'callback_url' => 'https://mims.momentuminternet.my/student/receive-payment/'.$stud->stud_id.'/'.$lvl->level_id.'/'.$invoice,
                // 'redirect_url' => 'https://mims.momentuminternet.my/student/receive-payment/'.$stud->stud_id.'/'.$lvl->level_id.'/'.$invoice
                'callback_url' => 'cuba',
                'redirect_url' => 'http://127.0.0.1:8000/student/receive-payment/'.$stud->stud_id.'/'.$lvl->level_id.'/'.$invoice,
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic M2Y3OGRmYWQtNzk5Ny00NWUwLTg0MjgtOTI4MGJhNTM3MjE1Og=='
            ),
        ));
        
        $response = json_decode(curl_exec($curl));
        
        curl_close($curl);

        return $response;

    }

    public static function test_create_bill($stud, $lvl, $invoice){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.billplz-sandbox.com/api/v3/bills',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'collection_id' => 'tfpkz0mw',
                'email' => $stud->email,
                'mobile' => $stud->phoneno,
                'name' => $stud->first_name,
                'amount' => $lvl->price.'00',
                'description' => 'Payment for '.$lvl->name,
                'callback_url' => 'cuba',
                'redirect_url' => 'http://127.0.0.1:8000/student/receive-payment/'.$stud->stud_id.'/'.$lvl->level_id.'/'.$invoice),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic MzJjNzBmZGUtNWVlYS00OWU2LTllMjAtMzc1NmY1NzEyNTZmOg=='
            ),
        ));
        
        $response = json_decode(curl_exec($curl));
        
        curl_close($curl);

        return $response;

    }
}
