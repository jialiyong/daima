<?php
require_once "YikooConfig.php";

$courseid = $_GET['courseid'];
$nickname = $_GET['username'];
$unique_id = $_GET['unique_id'];
$data = array(
    'sign' => $courseid,
    'username' => $nickname,
    'unique_id' => $unique_id
);
$ch = curl_init();
//file_put_contents(date("Y-m-d") . "$courseid" . "exit", "$nickname" . "\t" . $courseid. "\t".$nickname. "\t".$unique_id. "\t"."\n", FILE_APPEND);
// print_r($ch);
curl_setopt($ch, CURLOPT_URL, YikooConfig::exiturl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$return = curl_exec($ch);
curl_close($ch);
file_put_contents(date("Y-m-d") . "$courseid" . "exit", "$nickname" . "\t" . json_encode($return) . "\n", FILE_APPEND);


?>