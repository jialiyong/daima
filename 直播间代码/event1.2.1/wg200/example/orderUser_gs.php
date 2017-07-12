<?php
	session_start();
    if($_SESSION['is_free'] != "true"){
        echo "<h1><center>不是免费课程</center></h1>";die;
    }
	require_once "../lib/Yikoo.config.php";
	require_once "./GetParams.free.class.php";
	require_once "../lib/DB.php";
    require_once "../lib/WxPay.Config.php";
    require_once "./peopleCounting.php";
	date_default_timezone_set('PRC'); //设置中国时区
    header("Content-type: text/html; charset=utf-8");
    $appid = WxPayConfig::APPID;
	$Params = new PARAMS();
	//时间戳
	$time   = time();
	//处理接收值
    $courseid = $Params -> Getcourseid();
    $inviteid = $Params -> Getinviteid();
    $spread = $Params -> Getspread();
	//获取用户昵称
	$nickname = $Params -> getNickname();
    //echo "hello";die;
    //获取直播平台
    $platform = $_SESSION["platform$courseid"];
    file_put_contents("platform.log", $courseid.json_encode($platformInfo)."---".$platform."---".$_SESSION["platform$courseid"]."\n",FILE_APPEND);
    $_SESSION["url$courseid"] = YikooConfig::url;
    //查询标识字段
	$temp = 0;
	$uid = '10'.rand(100,999).substr(time(),5);
	$minute = substr(date("Y-m-d=H:i",time()),0,14).'pass';
	$mk_free = md5($minute);
    $UserVguanID = $_COOKIE['UserVguanID'];
    //	echo $_SESSION['first_time'].'<br>'.$openid.'<br>'.$courseid.'<br>'.$time.'<br>'.$mk.'<br>'.$_SESSION['tags'];die;
	if(  $_GET['deadline_judge'] == "right" || $time > intval($_SESSION['courseData']['start_time']) - 5){
        // echo "if";
        if($_SESSION["peo$courseid"] != $courseid){
            // echo "first"."<br>";
            //人数控制
            $DBObject = new DB();
            $DBConnect_course = $DBObject -> DBConnect("1");
            $peonum = $DBObject -> selectALL("select lesson_num from course where courseid = '$courseid'");
            echo $peonum['lesson_num']."<br>";
            if($peonum['lesson_num'] > 0 && !empty($UserVguanID) && $UserVguanID != 'null' && $UserVguanID != null){
                if(!($DBObject -> query("update course set lesson_num = (case when lesson_num > 0 then lesson_num - 1 else lesson_num end),student_num = student_num + 1 where courseid = '$courseid'"))){
                    $url = "Buypage.php?courseid=$courseid";
                    header("location:$url");die;
                }else{
                    $_SESSION["peo$courseid"] = $courseid;
                    echo $_SESSION["peo$courseid"]."<br>";
                }
            }else{

                $url = "Buypage.php?courseid=$courseid";
                header("location:$url");die;
            }
        }

        $ip = ($_SERVER['HTTP_VIA']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        //人次人数统计
        $source = "free1.3.0";
        if(!empty($UserVguanID) && $UserVguanID != 'null' && $UserVguanID != null){
            $data = array(
                "courseid" => $courseid,
                "openid" => "null",
                "UserVguanID" => $UserVguanID,
                "inviteid" => $inviteid,
                "spread" => $spread,
                "time" => "$time",
                "status" => 1,
                "appid" => $appid,
                "ip" => $ip,
                "nickname" => $nickname,
                "source" => $source
            );
//        var_dump($data);
            $peoCountAPI = YikooConfig::peopleCountAPI;
            Counting::peopleCounting($peoCountAPI,$data);
        }
//        echo "go to studio";
        $microtime = $Params -> getMicrotime();
        $token = $Params -> get_token($courseid,$microtime,$nickname);
        $all_token = "?courseid=$courseid&aid=1&nickname=".urlencode($nickname)."&timestamp=$microtime&token=$token&back_url=".urlencode(YikooConfig::url);
//        //从广告页跳转回来   或   当前时间距离开播不足五分钟
//        if($platform == "1"){
//            //$url = YikooConfig::gensee_url."/webcast/site/entry/join-".$_SESSION['courseData']['tags']."?nickName=".$nickname."&token=333333&k=".$mk_free."&uid=".$uid;
//            if(!empty($_SESSION["rebroad_data_$courseid"]['url'])){
//                $url = $_SESSION["rebroad_data_$courseid"]['url']."?nickName=".$nickname."&token=".$_SESSION["rebroad_data_$courseid"]['password']."&k=".$mk_free."&uid=".$uid;
//            }else{
//                $url = YikooConfig::gensee_url."/webcast/site/entry/join-".$_SESSION['courseData']['tags']."?nickName=".$nickname."&token=333333&k=".$mk_free."&uid=".$uid;
//            }
//        }else if ($platform == "2"){
//            $url = YikooConfig::letv_url.$all_token;
//        }else if ($platform == "3"){
//            $url = YikooConfig::baidu_url.$all_token;
//        }else if ($platform == "4"){
//            $url = YikooConfig::star_url.$all_token;
//        } else if ($platform == "5"){
//            $url = YikooConfig::jinshan_url.$all_token;
//        } else{
//            echo "<h1><center>error Platform</center></h1>";die;
//        }
        //从广告页跳转回来   或   当前时间距离开播不足五分钟
        if($platform == "1"){
            //$url = YikooConfig::gensee_url."/webcast/site/entry/join-".$_SESSION['courseData']['tags']."?nickName=".$nickname."&token=333333&k=".$mk_free."&uid=".$uid;
            if(!empty($_SESSION["rebroad_data_$courseid"]['url'])){
                $url = $_SESSION["rebroad_data_$courseid"]['url']."?nickName=".$nickname."&token=".$_SESSION["rebroad_data_$courseid"]['password']."&k=".$mk_free."&uid=".$uid;
            }else{
                $url = YikooConfig::gensee_url."/webcast/site/entry/join-".$_SESSION['courseData']['tags']."?nickName=".$nickname."&token=333333&k=".$mk_free."&uid=".$uid;
            }
        }else if ($platform == "2"){
            if($time > $_SESSION['end_time'] + 1800){
                //rebroad time
                $url = YikooConfig::aodianyun_rebroad.$all_token;
            }else{
                //live time
                $agent = check_wap();
                if ($agent) {
                    $type = get_device_type();
                    if ($type == "android") {
                        $url = YikooConfig::letvandroid_url . $all_token;
                    } else {
                        $url = YikooConfig::letv_url . $all_token;
                    }
                } else {
                    $url = YikooConfig::letv_pcurl . $all_token;
                }
            }
        }else if ($platform == "3"){
            if($time > $_SESSION['end_time'] + 1800){
                //echo $time . ">" .($_SESSION['end_time'] + 1800);
                //rebroad time
                $url = YikooConfig::tencent_rebroad . $all_token;
				
            }else{
                //live time
                $url = YikooConfig::baidu_url.$all_token;
            }

        }else if ($platform == "4"){
            //$url = YikooConfig::gensee_url."/webcast/site/entry/join-".$_SESSION['courseData']['tags']."?nickName=".$nickname."&token=333333&k=".$mk_free."&uid=".$uid;
//            if(!empty($_SESSION["rebroad_data_$courseid"]['url'])){
//                $url = $_SESSION["rebroad_data_$courseid"]['url']."?nickName=".$nickname."&token=".$_SESSION["rebroad_data_$courseid"]['password']."&k=".$mk_free."&uid=".$uid;
//            }else{
//                $url = YikooConfig::gensee_url."/webcast/site/entry/join-".$_SESSION['tag']."?nickName=".$nickname."&token=333333&k=".$mk_free."&uid=".$uid;
//            }
            $url = YikooConfig::yikoo888."/webcast/site/entry/join-".$_SESSION['tag']."?nickName=".$nickname."&token=333333&k=".$mk_free."&uid=".$uid;
        } else if ($platform == "5"){
            if($time > $_SESSION['end_time'] + 1800){
                //rebroad time
                $url = YikooConfig::jinshan_rebroad.$all_token;
            }else{
                $agent = check_wap();
                if ($agent) {
                    $type = get_device_type();
                    if ($type == "android") {
                        $url = YikooConfig::aliandroid_url . $all_token;
                    } else {
                        $url = YikooConfig::ali_url . $all_token;
                    }
                } else {
                    $url = YikooConfig::ali_pcurl . $all_token;
                }
            }
        } else{
            echo "<h1><center>error Platform</center></h1>";die;
        }
        //var_dump($url);die;
        header("location: $url ");die;
	}else{
		//当前时间距离开播大于五分钟
		$url = YikooConfig::ad_url."?deadline=".$_SESSION['courseData']['start_time'];
		header("location: $url ");die;
	}



// check if wap
function check_wap()
{
    // 先检查是否为wap代理，准确度高
    if (stristr($_SERVER['HTTP_VIA'], "wap")) {
        return true;
    } // 检查浏览器是否接受 WML.
    elseif (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
        return true;
    } //检查USER_AGENT
    elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function get_device_type()
{
    //全部变成小写字母
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $type = 'other';
    //分别进行判断
    if (strpos($agent, 'iphone') || strpos($agent, 'ipad')) {
        $type = 'ios';
    }
    if (strpos($agent, 'android')) {
        $type = 'android';
    }
    return $type;
}
