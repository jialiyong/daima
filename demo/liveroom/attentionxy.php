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

    //防盗链验证
    require_once "antileech.php";

    //获取课程信息
    require_once "courseinfo.php";
    
    //获取详情页
    require_once "details.php";

    //获取底部内容
    require_once "bottom.php";
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
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <script src="http://producten-10021492.file.myqcloud.com/js/jquery.js"></script>
    <script src="http://producten-10021492.file.myqcloud.com/js/bootstrap.min.js"></script>
    <!--videojs-->
    <link href="http://producten-10021492.file.myqcloud.com/css/video-js.css" rel="stylesheet">
    <!-- If you'd like to support IE8 -->
    <script src="http://producten-10021492.file.myqcloud.com/js/videojs-ie8.min.js"></script>
    <script src="http://producten-10021492.file.myqcloud.com/js/video.js"></script>
    <script type="text/javascript">
        var courseid="<?=$courseid?>";
        var userName = "<?= $nickname;?>";
        var u_id="<?=$u_id?>";
    </script>
    <!---数据统计-->
    <script src="./js/record.js"></script>
</head>
<body onload="connect();">
    <div class="divblock" id="player">
        <!--星域CDN代码区域-->
        <video id="my-video" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" webkit-playsinline=""
        poster="" data-setup="{}">
            <source src="rtmp://xy01.biggerfish.cn/wg/<?= $courseid;?>" type="rtmp/flv">
            <!-- 如果上面的rtmp流无法播放，就播放hls流 -->
            <source src="http://xy01.biggerfish.cn/wg/<?= $courseid;?>.m3u8" type='application/x-mpegURL'>
            <p class="vjs-no-js">
                To view this video please enable JavaScript, and consider upgrading to a web browser that
                <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
        </video>
    </div>
    <div class="bottle">
    
        <!--页面底部信息-->
        <?= $bottom;?>

    </div>
    <input type="hidden" id='mydescription' value = "<?= $mydescription;?>"/>
</body>
</html>
<script type="text/javascript">
    document.addEventListener('visibilitychange', function() {
        var isHidden = document.hidden;
        if (isHidden) {
            var url ='./exittimeapi.php?courseid='+courseid+'&username='+userName+'&unique_id='+u_id;
            $.ajax({
                url:url,
                async:false                //必须采用同步方法
            });
        }
    });
    //面板切换事件
    $('.longli li').each(function(i,item){
        $(item).click(function(){
            $(this).addClass('active').siblings().removeClass('active');
            $('.modeldisplay').eq(i).show().siblings().hide();
        });
    });
    //获取屏幕的宽度
    var scwidth = document.documentElement.clientWidth;
    //计算iframe的高度
    var scheight = document.documentElement.clientHeight;
    var oIframe = document.getElementById('myTabContent');
    var oDoc = document.getElementById('doc');
    scheight = scheight*0.5-40;
    //定义模块的宽高
    $('.modeldisplay').width(scwidth);
    $('.modeldisplay').height(scheight);
    //定义播放器的宽高
    //$('.divblock').width(scwidth);
    $('.divblock').height(scheight+40);
</script>
<!-- 奥点云DMS -->
<script type="text/javascript" src="http://cdn.aodianyun.com/dms/rop_client.js"></script>
<script type="text/javascript" src="js/dms.js"></script>
<!-- 调用JS接口的页面必须引入如下JS文件 -->
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    var mydescription = document.getElementById('mydescription').value;
    //设置播放器的宽高
    $("#my-video").width(scwidth);
    $("#my-video").height(scheight+40);
    //设置横竖屏触发事件
    window.addEventListener("orientationchange", function() {
        // 宣布新方向的数值
        //alert(window.orientation);
        if(window.orientation == 0 || window.orientation == 180){
            //$('.divblock').width(scwidth);
            $("#my-video").width(scwidth);
        }else{
            //获取屏幕横屏宽度
            var crowidth = document.documentElement.clientWidth;
            //$('.divblock').width(crowidth);
            $("#my-video").width(crowidth);
        }
    }, false);

    //分享功能
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: '<?php echo $signPackage["timestamp"];?>',
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
            link: "<?= YikooConfig::url."?aid=".$courseid."&inviteid=".$inviteid."&spread=".$UserVguanID;?>",
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
    }
    xhr.open('get','./countapi.php?courseid=<?= $courseid;?>&platform=星域&ip=<?= $ip; ?>&username='+userName,'true');
    xhr.send(null);
    
</script>
