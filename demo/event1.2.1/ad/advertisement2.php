<?php
    date_default_timezone_set('PRC'); 
	error_reporting(E_ERROR);
    require_once "../lib/Yikoo.config.php";
    //如果当前时间已经大于开始时间则直接跳转至中转站  省去渲染html和执行js的时间
    $time = time();
    $deadline = $_GET['deadline'];
    $deadline -= 300;
    if($time > intval($deadline)){
        $url = YikooConfig::url."/example/orderUser.php?deadline_judge=right";
        header("location:$url");
    }
    session_start();
	require_once "../lib/WxPay.Config.php";
	//分享功能
	require_once "jssdk.php";
    $appid = WxPayConfig::APPID;
    $jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
    $courseData = $_SESSION['courseData'];
    $courseid = $_SESSION['courseid'];
    $pic = $_SESSION['small_picture'];
    $title = $_SESSION['title'];
    $desc = $_SESSION['about'];
    $inviteid = $_SESSION['inviteid'];
    $UserVguanID = $_SESSION['openid'];
    if($deadline > 1900000000){
        //直播已经结束了
        $timezone = "after";
        //课程已经结束
        $ad_config = json_decode(file_get_contents("../../ad_config/$courseid.json"));
        if(empty($ad_config -> end_ad_id)){
            //无配置 使用默认项
            $ad_id = YikooConfig::end_ad_url;
        }else{
            //有配置 使用配置项
            $ad_id = $ad_config -> end_ad_id;
        }
        //echo "1".$top_ad_id.$bottom_ad_id;
    }else{
        //课程还未开始
        $timezone = "before";
        $content = file_get_contents("../../ad_config/$courseid.json");
        if($content == null){
            //无配置 使用默认项
            $ad_id = YikooConfig::start_ad_url;
        }else{
            //有配置 使用配置项
            $data = json_decode($content);
            $ad_id = $data -> start_ad_id;
        }
        //echo "2".$top_ad_id.$bottom_ad_id;
    }
    $ad_id = YikooConfig::pic_dir . $ad_id;
    //echo $deadline;
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" value="notranslate" >
    <title>微观直播</title>
</head>

<body>
<div id="debuger" style="color:red;z-index: 1;font-size: 20px;text-align: center;position:absolute;right:0;display:none;">000</div>
<input type="text" value="<?=$desc?>" id="describe"  style="display:none">
<a onclick="statistic('click')"><img src="<?=$ad_id?>" style="position: absolute;width: 100%;height: 100%;top: 0;left: 0"></a>
</body>

</html>
<script>
     //alert("<?='跳转时间：'.date("Y-m-d H:i:s",$deadline)?>");
     var now = <?=$time?>;
     var deadline = <?=$deadline?>;
     var debuger = document.getElementById("debuger");
    function timepicker(){
        now  = now +1;
        var time = new Date();
        var time = time.getTime();
        time = parseInt(time/1000);
        if(now >= deadline || time > deadline){
            //alert("直播即将开始");
            window.location.href = "<?=YikooConfig::url?>" + "/example/orderUser.php?course=" + "<?="0".$courseid?>&deadline_judge=right";
            return false;
        }
        debuger.innerHTML = "倒计时：" + stampTodate(deadline - now);
        //debuger.innerHTML = deadline - now + '+' + time + '>?' + deadline;
        setTimeout("timepicker()",1000);
    }
    timepicker();
    function stampTodate(timestamp){
        var content = "无";
        var t_days = parseInt(timestamp / 86400);
        var t_hours = parseInt(timestamp / 3600);
        var t_minutes = parseInt(timestamp / 60);
        if(t_days == 0){
            //没有日
            if(t_hours == 0){
                //没有时
                if(t_minutes == 0){
                    //没有分
                    content = timestamp + "秒";
                }else {
                    //有分
                    content = t_minutes + "分" + (timestamp - t_minutes * 60) + "秒";
                }
            }else {
                //有时
                content = t_hours + "时" + (t_minutes - t_hours * 60) + "分" + (timestamp - t_minutes * 60) + "秒";
            }
        }else {
            content = t_days + "日" + (t_hours - t_days * 24) + "时" + (t_minutes - t_hours * 60) + "分" + (timestamp - t_minutes * 60) + "秒";
        }
        return content;
    }
</script>

<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<script>
    if(typeof jQuery == 'undefined'){
        document.write("<script src='../js/jquery-1.8.3.js'><\/script>");
        //alert("jquery 加载失败");
    }else {
        //alert("jquery 加载成功");
    }
    var theData = new Object();
    //展现量
    function statistic(type){
        theData.courseid = "<?=$courseid?>";
        theData.timezone = "<?=$timezone?>";
        theData.type = type;
        transData = JSON.stringify(theData);
        $.ajax({
            type:"GET",
            timeout:1000,
            url:'<?=YikooConfig::adStatisticAPI?>',
            async:true,
            contentType:"text/json",
            dataType:"jsonp",
            data:{
                theData : transData
            },
            success:function(data){
                console.log(data);
                if(type == "click"){
                    location.href = "http://ehall.vguan.cn";
                }
            },
            error:function(data){
                //alert("fail");
                console.log(data);
            }
        });

    }
    statistic("display");
</script>
<!-- 调用JS接口的页面必须引入如下JS文件 -->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    var describe = document.getElementById('describe').value;
    //分享功能
    wx.config({
        debug: false,
        appId: '<?= $signPackage["appId"];?>',
        timestamp: <?= $signPackage["timestamp"];?>,
        nonceStr: '<?= $signPackage["nonceStr"];?>',
        signature: '<?= $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'openLocation',
            'getLocation',
            'scanQRCode'
        ]
    });


    wx.ready(function () {

        // 在这里调用 API
        var shareData = {
            title: "微观直播：<?=$title?>" ,
            desc: describe,
            link: "<?=YikooConfig::url?>/example/Buypage.php?courseid=<?=$courseid."&inviteid=".$inviteid."&spread=".$UserVguanID?>",
            imgUrl: "<?=$pic?>"
        };
        wx.onMenuShareAppMessage(shareData);
        wx.onMenuShareTimeline(shareData);
        wx.onMenuShareQQ(shareData);
        wx.onMenuShareWeibo(shareData);

        //通过checkJsApi判断当前客户端版本是否支持指定获取地理位置
        wx.checkJsApi({
            jsApiList: [
                'getLocation'
            ],
            success: function (res) {
                if (res.checkResult.getLocation == false) {
                    alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
                    return;
                }
            }
        });
    });

</script>
