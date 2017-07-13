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

    //获取毫秒时间戳
    function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    }

    //判断时间是否过期
    $gettime = $timestamp + 10000;
    $nowtime = getMillisecond();
    if($nowtime > $gettime){
        //跳转到错误页面
        header("Location:".YikooConfig::errorurl."?courseid=".$courseid);
        exit();
    }

    //生成token
    $str = "vguan".$courseid.$timestamp.$nickname;
    $mytoken = substr(md5(sha1(md5($str))),0,10);
    if($mytoken != $token){
        //跳转到错误页面
        header("Location:".YikooConfig::errorurl."?courseid=".$courseid);
        exit();
    }

    //获取课程信息
    
    $mycoursename = $_SESSION['title'];
    $mydescription = $_SESSION['about'];
    $imgurl = $_SESSION['small_picture'];
    $inviteid = $_SESSION['inviteid'];
    $spread = $_SESSION['spread'];
    $openid = $_SESSION['openid'];



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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body >
    <div class="divblock" id="player">
    <!--百度播放器代码区域-->
    </div>
    <div class="bottle">
        <ul class="longli">
            <li class="sortli left active">聊天</li>
            <li class="sortli left"><span class="leftline"></span>支持</li>
        </ul>
        <div>
            <div id="chatbox"  class="modeldisplay focus">
                <textarea id="chat_show"  readonly="readonly"></textarea>
                <div id="rop_context"></div>
                <div class="foot">
                    <textarea  id="idtext" value="hi"onkeydown="keyDown(event)" ></textarea>
                    <button type="button" class="btn btn-info" onClick="Publish();">
                        发送
                    </button>
                </div>
            </div>
            <div class="modeldisplay">
                <img src="./images/ad.jpg" alt="微观直播" class="support"/>
            </div>
        </div> 
    </div>
</body>
</html>
<script type="text/javascript">
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
</script>
<!-- 奥点云DMS -->
<script type="text/javascript" src="http://cdn.aodianyun.com/dms/rop_client.js"></script>
<script type="text/javascript" src="js/dms.js"></script>
<!-- 调用JS接口的页面必须引入如下JS文件 -->
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<!--引用百度云视频播放器-->
<script type="text/javascript" src="./player/cyberplayer.js"></script>
<script type="text/javascript">
    var player = cyberplayer("player").setup({
        width: scwidth,
        height: scheight+40,
        stretching: "uniform",
        file: "http://ggej413e58hxf509j26.exp.bcelive.com/lss-giwk1peqxabzr7rj-L1/live.m3u8",
        autostart: true,
        repeat: false,
        volume: 100,
        controls: true,
        ak: '4695b8ac1da74618b8d1ef35e3f3cb31' // 公有云平台注册即可获得accessKey
    });
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
            desc: "<?= $mydescription;?>",
            link: "<?= YikooConfig::url."?courseid=".$courseid."&inviteid=".$inviteid."&spread=".$openid;?>",
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
    xhr.open('get','./countapi.php?courseid=<?= $courseid;?>&username='+userName,'true');
    xhr.send(null);

    
    //直播间进入记录
    function Refresh(){
        $.ajax({
            type: "get",    //请求方式为get，也可以是设置为post
            url: "./keeplive.php?courseid=<?= $courseid;?>&openid=<?= $openid;?>&timestamp=<?= $nowtime;?>",  
            async: true,　　　　　　　　//是否为异步请求，ture为异步请求，false为同步请求
            success: function(d) {
                console.log(d);
                if(d == 2){
                    alert("您的账号在其他位置登录，您已被迫下线！");
                    timeout = true;
                    window.location.href="<?= YikooConfig::url."?courseid=".$courseid;?>"; 
                }
            } 
        });  
    }
    //定时刷新
    var timeout = true; //启动及关闭按钮  
    function time()  
    { 
      Refresh(); 
      if(timeout) return;  
      setTimeout(time,60000); //time是指本身,延时递归调用自己,100为间隔调用时间,单位毫秒  
    }
    time();
</script>
