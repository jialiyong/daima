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
    $u_id=$courseid.strtotime(date("Y-m-d H:i:s",time())).$token;
    //防盗链验证
    require_once "antileech.php";

    //获取课程信息
    require_once "courseinfo.php";

    //通过接口获取activityid
    $ch = curl_init("http://letvbackend.myartkoo.com/Api/Course/course_data?courseid=$courseid") ;  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
    $output = curl_exec($ch) ;
    $obj = json_decode($output);
    $activityId = $obj->data;

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
    <script type="text/javascript">
        var courseid="<?=$courseid?>";
        var userName = "<?= $nickname;?>";
        var u_id="<?=$u_id?>";
    </script>
    <!---数据统计-->
    <script src="./js/record.js"></script>
</head>
<body  onload="connect();">
    <div class="divblock" id="player">
        <!--乐视云或腾讯云代码区域-->
        <script type="text/javascript" charset="utf-8" src="http://yuntv.letv.com/player/live/blive.js"></script>
        <script>
            var player = new CloudLivePlayer();
            player.init({activityId:"<?= $activityId;?>"});
        </script>
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
    xhr.open('get','./countapi.php?courseid=<?= $courseid;?>&platform=乐视&ip=<?= $ip; ?>&username='+userName,'true');
    xhr.send(null);


</script>
