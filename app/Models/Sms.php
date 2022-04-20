<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    public function sendSMS($mobileNumber,$message,$template_id){
        $authKey = "";
        $senderId = "ECstre";
        $route = 4;
        $postData = array(
            'authkey' => $authKey,
            'mobiles' => $mobileNumber,
            'message' => $message,
            'sender' => $senderId,
            'route' => $route,
            'DLT_TE_ID'=>$template_id
        );
        $url="http://sms.moplet.com/api/sendhttp.php";
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        if(curl_errno($ch))
        {
            return response()->json(['status'=>false,'output'=>curl_error($ch)]);
        }
        curl_close($ch);
        return response()->json(['status'=>true,'output'=>$output]);
    }
}
