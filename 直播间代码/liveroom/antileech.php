<?php
require_once "YikooConfig.php";
//获取毫秒时间戳
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}

//判断时间是否过期
$gettime = $timestamp + 10000;
$nowtime = getMillisecond();


if($nowtime > $gettime){
    if(empty($from_url)){
        $from_url = urldecode($_GET['back_url']);
    }
    if(empty($from_url)){
        echo "<h1><center>请从详情页进入</center></h1>";die;
    }
    if($from_url==YikooConfig::free_url){
        //跳转到错误页面
        header("Location:".$from_url."/example/Buypage.php?aid=".$courseid);
        exit();
    }else{
        //跳转到错误页面
        header("Location:".$from_url."/example/Buypage.php?courseid=".$courseid);
        exit();
    }
}

//生成token
$str = "vguan".$courseid.$timestamp.$nickname;
$mytoken = substr(md5(sha1(md5($str))),0,10);
if($mytoken != $token){
    if(empty($from_url)){
        $from_url = urldecode($_GET['back_url']);
    }
    if(empty($from_url)){
        echo "<h1><center>请从详情页进入</center></h1>";die;
    }
    if($from_url==YikooConfig::free_url){
        //跳转到错误页面
        header("Location:".$from_url."/example/Buypage.php?aid=".$courseid);
        exit();
    }else{
        //跳转到错误页面
        header("Location:".$from_url."/example/Buypage.php?courseid=".$courseid);
        exit();
    }
}

?>