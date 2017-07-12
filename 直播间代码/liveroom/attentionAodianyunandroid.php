<?php
    header("Content-type: text/html; charset=utf-8"); 
    date_default_timezone_set('PRC');
    require_once "YikooConfig.php";
    session_start();

    //分享功能
    require_once "jssdk.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
    $u_id=$courseid.strtotime(date("Y-m-d H:i:s",time())).$token;
    //接收GET值
    $courseid = $_GET['courseid'];
    if($_GET['aid']==1){
        $id="aid";
        $title="V蓝直播";
    }else{
        $id="courseid";
        $title="微观直播";
    }
    $nickname = $_GET['nickname'];
    $timestamp = $_GET['timestamp'];
    $token = $_GET['token'];
    $from_url = $_SESSION["url$courseid"];


    //获取奥点云拉流地址
    function send_post($url, $post_data) {    
      $postdata = http_build_query($post_data);    
      $options = array(    
            'http' => array(    
                'method' => 'POST',    
                'header' => 'Content-type:application/x-www-form-urlencoded',    
                'content' => $postdata,    
                'timeout' => 15 * 60 // 超时时间（单位:s）    
            )    
        );    
        $context = stream_context_create($options);    
        $result = file_get_contents($url, false, $context);             
        return $result;    
    }

    $post_data = array(
        'courseid' => $courseid
    );
    $aodianyunurl = send_post(YikooConfig::aodianyunUrl, $post_data);
    $aodianyunurl = json_decode($aodianyunurl,true);
    $rtmpurl = $aodianyunurl["data"]["rtmp_stream"];
    $hlsurl = $aodianyunurl["data"]["http_stream"];
    $ip = ($_SERVER['HTTP_VIA']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
//    echo $ip
//    ;die;
    //防盗链验证
    require_once "antileech.php";

    //获取课程信息
    require_once "courseinfo.php";

    //获取详情页
    require_once "details.php";

    $content = file_get_contents("./ad_config/$courseid.json");
    if($content == null){
        //无配置 使用默认项
        $display='display: none';
    }else{
        //有配置 使用配置项
        $data = json_decode($content);
        $picture =YikooConfig::picurl."/".$data -> picture;
        $href=$data->href;

    }
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
    <!--奥点云播放js-->
    <script type="text/javascript" src="http://cdn.aodianyun.com/lss/aodianplay/player.js"></script>
    <script type="text/javascript">
        var courseid="<?=$courseid?>";
        var userName = "<?= $nickname;?>";
        var u_id="<?=$u_id?>";
        var ip="<?=$ip?>";
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
                <source src="<?= $rtmpurl;?>" type='application/x-mpegURL'>
                <source src="<?= $hlsurl;?>" type="rtmp/flv">
            </video>
        </div>
    <div class="controls">
            <!-- 播放/暂停 -->
            <a href="javascript:;" class="switch fa fa-play"></a>
            <a href="javascript:;" class="livebroadcast">Live broadcast</a>
            <!-- 全屏 -->
            <a href="javascript:;" class="expand fa fa-expand" ></a>
        </div>
    <div id="playerbutton"><img src="./images/Playbutton.png">
    </div>
<!--    <div class="logobox">-->
<!--        <img src="./images/logo.jpg" alt="">-->
<!--    </div>-->
</div>
 <div class="bottle">
    <!--页面底部信息-->
    <?= $bottom;?>
</div>
    <input type="hidden" id="play" value="<?=$display?>">
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
            title: "<?=$title.'：'. $mycoursename;?>",
            desc: mydescription,
            link: "<?= $from_url."/example/Buypage.php?$id=$courseid&inviteid=$inviteid&spread=$myid"?>",
            imgUrl: "<?= $imgurl;?>"
        };
//        alert(shareData.link);
        wx.onMenuShareAppMessage(shareData);
        wx.onMenuShareTimeline(shareData);
        wx.onMenuShareQQ(shareData);
        wx.onMenuShareWeibo(shareData);
    });

    //异步请求计算人数接口
//    var xhr = new XMLHttpRequest();
//    xhr.onreadystatechange = function(){
//        if (xhr.readyState == 4){
//            var msg = xhr.responseText;
//            if(msg=="(2)"){
//                console.log("缺少课程");
//            }else if(msg=="(7)"){
//                console.log("缺少用户名");
//            }else if(msg=="(8)"){
//                console.log("用户已存在");
//            }else if(msg=="(9)"){
//                console.log("添加失败");
//            }else if(msg=="(200)"){
//                console.log("成功");
//            }else{
//                console.log(msg);
//            }
//        }
//    }
//    xhr.open('get','./countapi.php?courseid=<?//= $courseid;?>//&platform=奥点云&unique_id='+u_id+'&ip=<?//= $ip; ?>//&username='+userName,'true');
//    xhr.send(null);


</script>
