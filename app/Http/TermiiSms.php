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

    public static function send_notification_from_article_created($a_id){
        // real function later
        return true;
    }
}
