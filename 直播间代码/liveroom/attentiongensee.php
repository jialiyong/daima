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

    //防盗链验证
    require_once "antileech.php";

    //获取展示参数
    require_once "genseeinfo.php";

    //获取课程信息
    require_once "courseinfo.php";

    //获取详情页
    require_once "details.php";

    //获取底部内容
    require_once "genseebottom.php";
    
?>
<!DOCTYPE html>
<html xmlns:gs="http://www.gensee.com/ec">
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
    <!--引入展示-->
    <script type="text/javascript" src="http://static.gensee.com/webcast/static/sdk/js/gssdk.js"></script>
</head>
<body onload="connect();">

    
    <div class="divblock" id="player">
        
        <gs:video-live id="genseeVideo" site="<?= $gensee_url;?>" ctx="webcast"
        ownerid="<?= $ownerid;?>" uid="<?= $uid;?>" uname="<?= $nickname;?>"
        authcode="<?= $authcode;?> " k="<?= $k;?>" video="true"/>

    </div>
    <!--
    <div id="genseeplay">
        <iframe src="./genseevideo.html?gensee_url=<?= $gensee_url;?>&ownerid=<?= $ownerid;?>&uname=<?= $nickname;?>&authcode=<?= $authcode;?>&k=<?= $k;?>&uid=<?= $uid;?>" id="player" class="divblock" type="video" name="submitFrame" allowtransparency="true" style="background-color=transparent" title="player" frameborder="0" scrolling="no"></iframe>
    </div>
    -->
    <div class="bottle">
    
        <!--页面底部信息-->
        
        <?= $bottom;?>

    </div>
    <input type="hidden" id='mydescription' value = "<?= $mydescription;?>"/>
    <!--
    <button class="VideoOrAudio">纯音频</button>
    -->
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
    //音视频切换事件
    $('.VideoOrAudio').click(function(){
        //音频链接
        var genseeaudio = "./genseeaudio.html?gensee_url=<?= $gensee_url;?>&ownerid=<?= $ownerid;?>&uname=<?= $nickname;?>&authcode=<?= $authcode;?>&k=<?= $k;?>&uid=<?= $uid;?>";
        //视频链接
        var genseevideo = "./genseevideo.html?gensee_url=<?= $gensee_url;?>&ownerid=<?= $ownerid;?>&uname=<?= $nickname;?>&authcode=<?= $authcode;?>&k=<?= $k;?>&uid=<?= $uid;?>";
        
        //获取当前状态
        var VAstatus = $('#player').attr('type');

        
        if( VAstatus == "video"){
            //若当前为视频则切换为音频
            $('#player').attr('src',genseeaudio);
            $('#player').attr('type','audio');
            $('.VideoOrAudio').text('视频');
        }else{
            //若当前为音频则切换为视频
            $('#player').attr('src',genseevideo);
            $('#player').attr('type','video');
            $('.VideoOrAudio').text('纯音频');
        }
    });
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
    }
    xhr.open('get','./countapi.php?courseid=<?= $courseid;?>&platform=自定义展示&ip=<?= $ip; ?>&username='+userName,'true');
    xhr.send(null);


</script>
