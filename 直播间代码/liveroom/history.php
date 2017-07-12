<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2017/5/8
 * Time: 9:52
 */
// 参数数组
$data = array (
    'courseid' => $courseid
);
$ch = curl_init ();
// print_r($ch);
curl_setopt ( $ch, CURLOPT_URL, YikooConfig::history );
curl_setopt ( $ch, CURLOPT_POST, 1 );
curl_setopt ( $ch, CURLOPT_HEADER, 0 );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
$return = curl_exec ( $ch );
curl_close ( $ch );

//print_r($return);
