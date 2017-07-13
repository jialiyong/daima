<?php
    header("Content-type: text/html; charset = utf-8");

    require_once "YikooConfig.php";

    $courseid = $_GET['courseid'];
    $message = $_GET['message'];

    //通过接口获取发送消息信息

    $ch = curl_init(YikooConfig::reviewurl ."?courseid=$courseid&message=$message") ;  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
    $output = curl_exec($ch) ;
    //$obj = json_decode($output);
    //$activityId = $obj->data;
    //$output = $courseid.$message;
    echo $output;
?>