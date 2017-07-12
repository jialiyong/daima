<?php
$nums=$_GET["nums"];
$data = array(
    "token" => "$nums"
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, YikooConfig::fang_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$return = curl_exec($ch);
curl_close($ch);
$result1 = json_decode($return,true);
if($result1['code']!=200){
    //跳转到错误页面
    header("Location:".$from_url."/example/Buypage.php?courseid=".$courseid);
    exit();
}
//print_r($result1);die;
