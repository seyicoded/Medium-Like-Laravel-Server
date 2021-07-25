<?php

namespace App\Http;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TermiiSms {
    public static function test(){
        echo 'a';
    }

    public static function get_all_state(){
        $arr = [
            "Abia",
            "Adamawa",
            "Akwa Ibom",
            "Anambra",
            "Federal Capital Territory",
            "Bauchi",
            "Bayelsa",
            "Benue",
            "Borno",
            "Cross River",
            "Delta",
            "Ebonyi",
            "Edo",
            "Ekiti",
            "Enugu",
            "Gombe",
            "Imo",
            "Jigawa",
            "Kaduna",
            "Kano",
            "Katsina",
            "Kebbi",
            "Kogi",
            "Kwara",
            "Lagos",
            "Nasarawa",
            "Niger",
            "Ogun",
            "Ondo",
            "Osun",
            "Oyo",
            "Plateau",
            "Rivers",
            "Sokoto",
            "Taraba",
            "Yobe",
            "Zamfara"
        ];

        $s = [];
        foreach ($arr as $value ) {
            $s[$value] = $value;
        }
        return $arr;
    }

    public static function send_notification_from_article_created($a_data){
        // real function later :: it's time

        // $a_data = (DB::select('SELECT * from articles where a_id', [$a_id]))[0];
        $a_title = $a_data->a_title;
        $a_desc = $a_data->a_desc;
        $a_location = $a_data->a_location;

        $c_id = $a_data->c_id;

        // loop through all users
        $auser_dt = DB::select('SELECT * from users AS a INNER JOIN push_noti AS b ON a.u_id=b.account_id WHERE a.loc_state LIKE ?', ["%$a_location%"]);

        foreach ($auser_dt as $dt) {
            $cat = $dt->categories;
            $cat_arr = explode(",", $cat);

            $is_subscrib = false;
            foreach ($cat_arr as $data) {
                if($data == $c_id){
                    $is_subscrib = true;
                    continue;
                }
            }

            if(!($is_subscrib)){
                return false;
            }

            // send push notification to user
            $device_token = $dt->device_token;

            TermiiSms::sendPushNotiA($device_token, "NEWS UPDATE: $a_title", "$a_desc");
        }

        return true;
    }

    public static function sendPushNotiA($device_token, $title, $message){
        $send_data = [
            'to' => $device_token,
            "sound" => "default",
            'title' => $title,
            'body' => $message,
            'channelId' => 'default',
            'priority' => 'high',
        ];

        $send = curl_init();
        curl_setopt($send, CURLOPT_URL, "https://exp.host/--/api/v2/push/send");
        curl_setopt($send, CURLOPT_POST, true);
        curl_setopt($send, CURLOPT_POSTFIELDS, http_build_query($send_data));
        curl_setopt($send, CURLOPT_RETURNTRANSFER, true);

        $sent = curl_exec($send);

        curl_close($send);

}
}
