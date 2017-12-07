<?php

if(isset($_SESSION['verify']['OTP']))
{
            if(!isset($_SESSION))
                session_start();
            //echo $_SESSION['verify']["mobile"];
            //echo $_SESSION['verify']["OTP"];
        $mobile="91".$_SESSION['verify']["mobile"];
        $message = "Your Gaintschool verification code : ".$_SESSION['verify']["OTP"];
        $authKey = "171224AfNsKlSZ599d1821";
        $senderId = "vhacks";
        $route = "4";

        $postData = array(
        'authkey' => $authKey,
        'mobiles' => $mobile,
        'message' => $message,
        'sender' => $senderId,
        'route' => $route
        );
            $url="https://control.msg91.com/api/sendhttp.php?authkey=".$authKey."&mobiles=".$mobile."&message=".$message."&sender=".$senderId."&route=4&country=91";
            //header('location:'.$url);
        $ch = curl_init();
        curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
        //,CURLOPT_FOLLOWLOCATION => true
        ));
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //get response
        $output = curl_exec($ch);
        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
}

?>