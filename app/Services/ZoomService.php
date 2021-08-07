<?php

namespace App\Services;

class ZoomService
{
    // protected $curl;

    public static function createWebinar($request)
    {
        // dd($request->password);

        $postData = [ 
            "topic" => $request->topic,
            "type"=> 8,
            "start_time"=> "$request->start",
            "duration"=>  $request->duration,
            "password"=> "$request->password",
            "recurrence" => [
                "type"=> "1",
                "repeat_interval"=> "1",
                "weekly_days"=> "4",
                "monthly_day"=> 30,
                "monthly_week"=> "4",
                "monthly_week_day"=> "4",
                "end_times"=> 1,
                "end_date_time"=> "$request->end"
            ],
            "settings"=> [
                "host_video"=> true,
                "participant_video"=> true,
                "cn_meeting"=> false,
                "in_meeting"=> false,
                "join_before_host"=> false,
                "mute_upon_entry"=> false,
                "watermark"=> false,
                "use_pmi"=> false,
                "approval_type"=> 2,
                "registration_type"=> 1,
                "audio"=> "both",
                "auto_recording"=> "none",
                "alternative_hosts"=> "",
                "close_registration"=> false,
                "waiting_room"=> true,
                "contact_name"=> "Umesh",
                "contact_email"=> "abc@gmail.com",
                "registrants_email_notification"=> false,
                "meeting_authentication"=> false,
                "authentication_option"=> "",
                "authentication_domains"=> ""
            ]
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.zoom.us/v2/users/me/webinars',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($postData),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJmQWl5MzNkWlN2dWxNeU9ya2lkbklBIiwiZXhwIjoxNDk2MDkxOTY0MDAwfQ.6LkiOYxfaaQM52eSGI-jgWJqd7eq3cxZhbiFZhMwRQc',
            'Cookie: cred=36C598E1980AD999D34DE15BC4DA7E7C'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public static function getListRegistree($webinarId){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.zoom.us/v2/webinars/'.$webinarId.'/registrants?occurrence_id=dolore%20in%20adipisicing%20culpa%20laborum&status=approved&page_size=30',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJmQWl5MzNkWlN2dWxNeU9ya2lkbklBIiwiZXhwIjoxNDk2MDkxOTY0MDAwfQ.6LkiOYxfaaQM52eSGI-jgWJqd7eq3cxZhbiFZhMwRQc',
            'Cookie: cred=A586860EE2D1D108474EB97F304C5691'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

}
