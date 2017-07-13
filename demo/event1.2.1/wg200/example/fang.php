<?php
require_once "../lib/Yikoo.config.php";
$nums=$_GET["key"];
//处理接收值
$course	 = 	trim($_GET['course']);;
//课程id
$courseid = $Params -> Getcourseid();
$data = array(
    "k" => "$nums"
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, YikooConfig::fdl_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$return = curl_exec($ch);
curl_close($ch);
//print_r($return);die;
$result1 = json_decode($return,true);
if($result1['code']!==200){
    //跳转到错误页面
    $url = YikooConfig::url."/example/Buypage.php?courseid=".$courseid;
    //重定向浏览器
    header("Location: $url");
    exit;
//    //跳转到错误页面
//    $url = YikooConfig::url."/example/Buypage.php?courseid=".$courseid;
//    echo "<script language='javascript' type='text/javascript'>";
//    echo "window.location.href='$url'";
//    echo "</script>";
}
//print_r($result1);die;
