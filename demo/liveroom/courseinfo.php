<?php
    //获取课程信息
    $mycoursename = $_SESSION['title'];
    $mydescription = $_SESSION['about'];
    $imgurl = $_SESSION['small_picture'];
    $inviteid = $_SESSION['inviteid'];
    $spread = $_SESSION['spread'];
    $openid = $_SESSION['openid'];
    $nickname = $_SESSION['nickname'];
//    $mycoursename = $_SESSION['courseData']['title'];
//
//    $mydescription = $_SESSION['courseData']['about'];
//    $imgurl = $_SESSION['courseData']['small_picture'];
//    $inviteid = $_SESSION['inviteid'] ? $_SESSION['inviteid'] : "empty";
//    $spread = $_SESSION['spread'] ? $_SESSION['spread'] : "empty";
//    $openid = $_SESSION['openid'] ? $_SESSION['openid'] : "empty";
//    //$nickname = empty($_SESSION['nickname'.$courseid])?$_SESSION['nickname']:$_SESSION['nickname'.$courseid];
//    $nickname = empty($_SESSION['nickname'.$courseid])?$_SESSION['nickname']:$_SESSION['nickname'.$courseid];
//    $UserVguanID = $_COOKIE['UserVguanID'] ? $_COOKIE['UserVguanID'] : "empty";
//    $myid = empty($openid)?$UserVguanID:$openid;

    //获取IP
    $ip=$_SERVER["REMOTE_ADDR"];
?>