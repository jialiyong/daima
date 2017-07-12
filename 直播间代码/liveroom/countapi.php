<?php
require_once "YikooConfig.php";
$courseid = $_GET['courseid'];
$nickname = $_GET['username'];
$ip       = $_GET['ip'];
$platform =$_GET['platform'];
$unique_id = $_GET['unique_id'];
//统计人数接口
$datas=array (
    'sign' => $courseid,
    'username'=>$nickname,
    'platform'=>$platform,
    'ip'=>$ip,
    'unique_id'=>$unique_id,
);
//初始化
$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, YikooConfig::counturl );
curl_setopt ( $ch, CURLOPT_POST, 1 );
curl_setopt ( $ch, CURLOPT_HEADER, 0 );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $datas );
$output = curl_exec ( $ch );
curl_close ( $ch );
//统计人次接口
$data = array (
    'courseid' => $courseid
);
$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, YikooConfig::totalurl );
curl_setopt ( $ch, CURLOPT_POST, 1 );
curl_setopt ( $ch, CURLOPT_HEADER, 0 );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
$output1 = curl_exec ( $ch );
curl_close ( $ch );
file_put_contents(date("Y-m-d")."$courseid",date("Y-m-d H:i:s")."___".$nickname."__".json_encode($output.'--'.$output1)."\n", FILE_APPEND);


?>