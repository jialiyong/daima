 <?php
    header("Content-type: text/html; charset=utf-8");
    date_default_timezone_set('PRC');
    require_once "YikooConfig.php";
    session_start();

    //分享功能
    require_once "jssdk.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();

    //接收GET值
    $courseid = $_GET['courseid'];
    $nickname = $_GET['nickname'];
    $timestamp = $_GET['timestamp'];
    $token = $_GET['token'];
    $from_url = $_SESSION["url$courseid"];
    $u_id=strtotime(date("Y-m-d H:i:s",time()));
    //防盗链验证
    require_once "antileech.php";

    //获取课程信息
    require_once "courseinfo.php";

    //获取详情页
    require_once "details.php";

    //获取底部内容
    require_once "bottomandroid.php";


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" value="notranslate" >
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title><?= $mycoursename;?></title>
    <link href="http://producten-10021492.file.myqcloud.com/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/styleandroid.css" />
    <link rel="stylesheet" type="text/css" href="./css/font-awesome.min.css">
    <script src="http://producten-10021492.file.myqcloud.com/js/jquery.js"></script>
    <script src="http://producten-10021492.file.myqcloud.com/js/bootstrap.min.js"></script>
    <!--videojs-->
    <!-- <link href="http://producten-10021492.file.myqcloud.com/css/video-js.css" rel="stylesheet"> -->
    <!-- If you'd like to support IE8 -->
    <!-- <script src="http://producten-10021492.file.myqcloud.com/js/videojs-ie8.min.js"></script> -->
    <!-- <script src="http://producten-10021492.file.myqcloud.com/js/video1.js"></script> -->   
    <script type="text/javascript">
        var courseid="<?=$courseid?>";
        var userName = "<?= $nickname;?>";
        var u_id="<?=$u_id?>";

    </script>
    <!---数据统计-->
    <script src="./js/record.js"></script>
</head>
<body onload="connect();">
<div style="width: 100%;height: 100%;background-color: #000;position: absolute;top: 0;z-index: -666"></div>
<div class="tcplayerbox">
    <div class="divblock" id="player">
        <video id="my_video" x5-video-player-type="h5" x5-video-player-fullscreen="true"  preload="auto" webkit-playsinline=""
               poster="" data-setup="{}">
            <source src="http://test-ali.myartkoo.com/online/<?= $courseid;?>.m3u8" type='application/x-mpegURL'>
            <source src=" rtmp://test-ali.myartkoo.com/online/<?= $courseid;?>" type="rtmp/flv">
        </video>
    </div>
    <div class="controls">
            <!-- 播放/暂停 -->
            <a href="javascript:;" class="switch fa fa-play"></a>
            <a href="javascript:;" class="livebroadcast">Live broadcast</a>
            <!-- 全屏 -->
            <a href="javascript:;" class="expand fa fa-expand" ></a>
        </div>
    <div id="playerbutton"><img src="./images/Playbutton.png"></div>
    <div class="logobox">
        <img src="./images/logo.jpg" alt="">
    </div>
   

</div>
 <div class="bottle">
    <!--页面底部信息-->
    <?= $bottom;?>
</div>
<input type="hidden" id='mydescription' value = "<?= $mydescription;?>"/>
</body>
</html>
<script type="text/javascript" src="./js/liveroom.js"></script>
<!-- 奥点云DMS -->
<script type="text/javascript" src="http://cdn.aodianyun.com/dms/rop_client.js"></script>
<script type="text/javascript" src="js/dms.js"></script>
<!-- 调用JS接口的页面必须引入如下JS文件 -->
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    //分享功能
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
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
            title: "微观直播：<?= $mycoursename;?>",
            desc: mydescription,
            link: "<?= $from_url."/example/Buypage.php?courseid=$courseid&inviteid=$inviteid&spread=$myid"?>",
            imgUrl: "<?= $imgurl;?>"
        };
        wx.onMenuShareAppMessage(shareData);
        wx.onMenuShareTimeline(shareData);
        wx.onMenuShareQQ(shareData);
        wx.onMenuShareWeibo(shareData);
    });

    //异步请求计算人数接口
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (xhr.readyState == 4){
            var msg = xhr.responseText;
            if(msg=="(2)"){
                console.log("缺少课程");
            }else if(msg=="(7)"){
                console.log("缺少用户名");
            }else if(msg=="(8)"){
                console.log("用户已存在");
            }else if(msg=="(9)"){
                console.log("添加失败");
            }else if(msg=="(200)"){
                console.log("成功");
            }else{
                console.log(msg);
            }
        }
    };
//    xhr.open('get','./countapi.php?courseid=<?//= $courseid;?>//&platform=金山&ip=<?//= $ip; ?>//&username='+userName,'true');
    xhr.open('get','./countapi.php?courseid=<?= $courseid;?>&platform=金山&unique_id='+u_id+'&ip=<?= $ip; ?>&username='+userName,'true');
    xhr.send(null);


</script>
