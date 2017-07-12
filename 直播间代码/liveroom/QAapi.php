<?php
    require_once "YikooConfig.php";
    
    $courseid = $_POST['courseid'];
    $nickname = $_POST['nickname'];
    $question = $_POST['question'];

    //发送问答消息接口
    $url = YikooConfig::qaurl;
    $post_data = array ("courseid" => $courseid,"nick" => $nickname,'content'=>$question);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close($ch);
    //print_r($output);

?>