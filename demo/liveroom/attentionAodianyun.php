<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC');
require_once "YikooConfig.php";
session_start();

//分享功能
require_once "jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();
$token = $_GET['token'];
$u_id = $courseid . strtotime(date("Y-m-d H:i:s", time())) . $token;
//接收GET值
$courseid = $_GET['courseid'];
if ($_GET['aid'] == 1) {
    $id = "aid";
    $title = "V蓝直播";
} else {
    $id = "courseid";
    $title = "微观直播";
}
$nickname = $_GET['nickname'];
$_SESSION["nickname"]=$nickname;
$timestamp = $_GET['timestamp'];
$from_url = $_SESSION["url$courseid"];

$ip = ($_SERVER['HTTP_VIA']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
//echo $ip;die;
//获取奥点云拉流地址
function send_post($url, $post_data)
{
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
$aodianyunurl = json_decode($aodianyunurl, true);
$rtmpurl = $aodianyunurl["data"]["rtmp_stream"];
$hlsurl = $aodianyunurl["data"]["http_stream"];

//防盗链验证
require_once "antileech.php";
//echo $nicknames;die;
//获取课程信息
require_once "courseinfo.php";

//获取详情页
require_once "details.php";

$content = file_get_contents("./ad_config/$courseid.json");
if ($content == null) {
    //无配置 使用默认项
    $display = 'display: none';
} else {
    //有配置 使用配置项
    $data = json_decode($content);
    $picture = YikooConfig::picurl . "/" . $data->picture;
    $href = $data->href;

}
//获取底部内容
require_once "bottom.php";

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
          value="notranslate">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title><?= $mycoursename; ?></title>
    <link href="http://producten-10021492.file.myqcloud.com/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/style.css"/>
    <script src="http://producten-10021492.file.myqcloud.com/js/jquery.js"></script>
    <script src="http://producten-10021492.file.myqcloud.com/js/bootstrap.min.js"></script>
    <!--奥点云播放js-->
    <script type="text/javascript" src="http://cdn.aodianyun.com/lss/aodianplay/player.js"></script>
    <script type="text/javascript">
        var courseid = "<?=$courseid?>";
        var userName = "<?=$_SESSION['nickname']?>";
        var u_id = "<?=$u_id?>";
        var Ip = "<?=$ip?>";
    </script>
    <!---数据统计-->
    <script src="./js/record.js"></script>
</head>
<body onload="connect();">
<div class="tcplayerbox">
    <div class="divblock" id="player">
    </div>
    <!--  <div class="logobox">
         <img src="./images/logo.jpg" alt="">
     </div> -->
</div>

<div class="bottle">

    <!--页面底部信息-->
    <?= $bottom; ?>

</div>
<input type="hidden" id="play" value="<?= $display ?>">
<input type="hidden" id='mydescription' value="<?= $mydescription; ?>"/>
</body>
</html>
<script>
    //解决安卓手机输入框被遮挡问题
    $('body').height($('body')[0].clientHeight);
    //判断安卓
    var userAgent = navigator.userAgent;
    var isAndroid = userAgent.indexOf('Android') > -1 || userAgent.indexOf('Adr') > -1;
    if (!isAndroid) {
//ios解决第三方软键盘唤起时底部input输入框被遮挡问题
        var bfscrolltop = document.body.scrollTop;//获取软键盘唤起前浏览器滚动部分的高度
        $("input").focus(function () {//在这里‘input.inputframe’是我的底部输入栏的输入框，当它获取焦点时触发事件
            interval = setInterval(function () {//设置一个计时器，时间设置与软键盘弹出所需时间相近
                document.body.scrollTop = document.body.scrollHeight;//获取焦点后将浏览器内所有内容高度赋给浏览器滚动部分高度
            }, 500)
        }).blur(function () {//设定输入框失去焦点时的事件
            clearInterval(interval);//清除计时器
            document.body.scrollTop = bfscrolltop;//将软键盘唤起前的浏览器滚动部分高度重新赋给改变后的高度
        });
    }
</script>
<script type="text/javascript">
    //window.onload = function() {
    //         var obj = document.getElementById("chat_show");
    //        obj.scrollTop = obj.scrollHeight;
    //        $("iframe").css("display","none");
    //    }
    //document.addEventListener('visibilitychange', function() {
    //    var isHidden = document.hidden;
    //    if (isHidden) {
    //        var url ='./exittimeapi.php?courseid='+courseid+'&username='+userName+'&unique_id='+u_id;
    //        $.ajax({
    //            url:url,
    //            async:false                //必须采用同步方法
    //        });
    //    }
    //});
    //面板切换事件
    $('.longli li').each(function (i, item) {
        $(item).click(function () {
            $(this).addClass('active').siblings().removeClass('active');
            $('.modeldisplay').eq(i).show().siblings().hide();
        });
    });
    var id = document.getElementById("play").value;
    //获取屏幕的宽度
    var scwidth = document.documentElement.clientWidth;
    //计算iframe的高度
    var scheight = document.documentElement.clientHeight;
    var oIframe = document.getElementById('myTabContent');
    var oDoc = document.getElementById('doc');
    if (id) {
        scheight = scheight * 0.5 - 40;

    } else {
        scheight = scheight * 0.5 - 80;

    }

    //定义模块的宽高
    $('.modeldisplay').width(scwidth);
    $('.modeldisplay').height(scheight);
    console.log(scheight)
    //定义播放器的宽高
    //$('.divblock').width(scwidth);
    if (id) {
        $('.divblock').height(scheight + 40);
    } else {
        $('.divblock').height(scheight + 80);
    }
    //    $('.divblock').height(scheight+40);
</script>
<!-- 奥点云DMS -->
<script type="text/javascript" src="http://cdn.aodianyun.com/dms/rop_client.js"></script>
<script type="text/javascript" src="js/dms.js"></script>
<!-- 调用JS接口的页面必须引入如下JS文件 -->
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    var mydescription = document.getElementById('mydescription').value;

    var objectPlayer = new aodianPlayer({
        container: 'player',//播放器容器ID，必要参数
        rtmpUrl: '<?= $rtmpurl;?>',//控制台开通的APP rtmp地址，必要参数
        hlsUrl: '<?= $hlsurl;?>',//控制台开通的APP hls地址，必要参数
        /* 以下为可选参数*/
        width: scwidth,//播放器宽度，可用数字、百分比等
        height: scheight + 40,//播放器高度，可用数字、百分比等
        autostart: true,//是否自动播放，默认为false
        bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
        maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
        stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
        controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
        //adveDeAddr: '',//封面图片链接
        //adveWidth: 320,//封面图宽度
        //adveHeight: 240,//封面图高度
        //adveReAddr: '',//封面图点击链接
        //isclickplay: false,//是否单击播放，默认为false
        isfullscreen: true//是否双击全屏，默认为true
    });
    /* rtmpUrl与hlsUrl同时存在时播放器优先加载rtmp*/
    /* 以下为Aodian Player支持的事件 */
    /* objectPlayer.startPlay();//播放 */
    /* objectPlayer.pausePlay();//暂停 */
    /* objectPlayer.stopPlay();//停止 hls不支持*/
    /* objectPlayer.closeConnect();//断开连接 */
    /* objectPlayer.setMute(true);//静音或恢复音量，参数为true|false */
    /* objectPlayer.setVolume(volume);//设置音量，参数为0-100数字 */
    /* objectPlayer.setFullScreenMode(1);//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。手机不支持 */

    //设置横竖屏触发事件
    window.addEventListener("orientationchange", function () {
        // 宣布新方向的数值
        //alert(window.orientation);
        if (window.orientation == 0 || window.orientation == 180) {
            //$('.divblock').width(scwidth);
            $("#player").width(scwidth);
        } else {
            //获取屏幕横屏宽度
            var crowidth = document.documentElement.clientWidth;
            //$('divblock').width(crowidth);
            $("#player").width(crowidth);
        }
    }, false);

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
            title: "<?=$title . '：' . $mycoursename;?>",
            desc: mydescription,
            link: "<?= $from_url . "/example/Buypage.php?$id=$courseid&inviteid=$inviteid&spread=$myid"?>",
            imgUrl: "<?= $imgurl;?>"
        };
//        alert(shareData.link);
        wx.onMenuShareAppMessage(shareData);
        wx.onMenuShareTimeline(shareData);
        wx.onMenuShareQQ(shareData);
        wx.onMenuShareWeibo(shareData);
    });

    //异步请求计算人数接口
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            var msg = xhr.responseText;
            if (msg == "(2)") {
                console.log("缺少课程");
            } else if (msg == "(7)") {
                console.log("缺少用户名");
            } else if (msg == "(8)") {
                console.log("用户已存在");
            } else if (msg == "(9)") {
                console.log("添加失败");
            } else if (msg == "(200)") {
                console.log("成功");
            } else {
                console.log(msg);
            }
        }
    }
    xhr.open('get', './countapi.php?courseid=<?= $courseid;?>&platform=奥点云&unique_id=' + u_id + '&ip=<?= $ip; ?>&username=' + userName, 'true');
    xhr.send(null);


</script>
