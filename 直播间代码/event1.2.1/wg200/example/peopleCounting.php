<?php
/**
 * Created by PhpStorm.
 * -------------------------
 *Author:NOCNing
 * -------------------------
 *Date:2016/8/29 10:43
 * -------------------------
 *Caution:No comments for u            ( ˇˍˇ )
 *        it was hard to write
 *        so it should be hard to read O(∩_∩)O~
 **/

class Counting{
    public static function peopleCounting($api_url,$data){
        $ch = curl_init();
        $url = "$api_url";
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_TIMEOUT,1);
        $result = curl_exec($ch);
        //var_dump($result);
        //var_dump(curl_error($ch));
        curl_close($ch);
    }
}
