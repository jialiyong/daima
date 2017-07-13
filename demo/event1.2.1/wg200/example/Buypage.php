<?php
    date_default_timezone_set('PRC');
    session_start();
	error_reporting(E_ERROR);
	require_once "../lib/DB.php";
    require_once "../lib/Yikoo.config.php";
    require_once "./GetParams.free.class.php";
    require_once "../lib/WxPay.Config.php";
    require_once "./cookie.php";
	//分享功能
	require_once "jssdk.php";
    $appid = WxPayConfig::APPID;
    //微信分享 jssdk类
    $jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
    //基本方法封装类
    $Params = new PARAMS();
    $courseid = $Params -> Getcourseid();
    $inviteid = $Params -> Getinviteid(true);
    $spread = $Params -> Getspread(true);
    //cookie 封装类
    $cookieSet = new cookieSet();
    //初始化cookie 中的 UserVguanID
    $UserVguanID = $cookieSet -> initializeCookie();
    $ipaddress = ($_SERVER['HTTP_VIA']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    $time = time();
	//连接数据库
	$DBObject = new DB();
    $DBConnect = $DBObject ->DBConnect("1");
//echo $courseid;die;
	//查询出课程的信息
	$sql 	= 	"select * from course where courseid = '$courseid' ";
	$data 	= 	$DBObject ->selectALL($sql);
//     var_dump($data);
    //直播基本信息存入session  供广告页分享调用
    $_SESSION['courseData'] = $data;
    //预防有 蠢货 把开始时间定在结束时间之后
    $the_end_time = $data['start_time']>$data['end_time']?$data['start_time']:$data['end_time'];
    $the_start_time =  $data['start_time']<$data['end_time']?$data['start_time']:$data['end_time'];
    $_SESSION['start_time'] = $the_start_time;
    $_SESSION['end_time'] = $the_end_time;
//echo time();echo "------".$the_end_time;die;
	//查询课程是否结束
    if( time() > $the_end_time + 1800 ){
        //课程已经讲完了30分钟
        $timechecker = 1;
    }else{
        //课程还处于可用状态
        $timechecker = 2;
    }
    //echo $_SESSION['courseid']."-".$_SESSION['inviteid']."-".$_SESSION['spread']."-".$_COOKIE['UserVguanID'];
    //var_dump($_SESSION['courseData']);
    // $mainContent = str_replace("\r\n","<br>",str_replace(' ','&nbsp', $data['free_details']));
    $mainContent = str_replace("\r\n","<br>",$data['free_details']);
    $mainContent = str_replace(" ","&nbsp;",$mainContent);
    $mainContent = str_replace("&lt;","<",$mainContent);
    $mainContent = str_replace("&gt;",">",$mainContent);
    if($data['lesson_num'] < 1){
       if($_SESSION["peo$courseid"] != $courseid){
           $peo_limit = 1;
       }else{
           $peo_limit = 0;
       }
    }else{
        $peo_limit = 0;
    }
    // echo "标识：".$_SESSION["peo$courseid"];
    // echo "num:".$data['lesson_num']."<br>";
    // echo "swich".$peo_limit;
    //是否是免费课程
    if($data['price'] < 2){
        //free
        $permisson = '1';
        $_SESSION['is_free'] = "true";
    }else{
        //not free
        $permisson = '0';
        $_SESSION['is_free'] = "false";
    }
    //平台标识1：展视 2：乐视 3：百度 4：星域 5：金山
    $DBConnect = $DBObject ->DBConnect("2");
    $platformInfo = $DBObject ->selectALL("select * from free_white where courseid = '$courseid' and status = 1");
    
    if( $platformInfo == 0 || empty($platformInfo['type']) ){
        //未找到相应记录 默认为展视
        if( empty($_SESSION["platform$courseid"]) ){
            $platform = "1";
        }else{
            $platform = $_SESSION["platform$courseid"];
        }
    }else{
        $platform = $platformInfo['type'];
        //要切换直播id信息。
        $_SESSION['tag'] = $platformInfo['tag'];
    }
    //课程平台信息存储到session orderuser.php进行调用
    $_SESSION["platform$courseid"] = $platform;
//    $button_content = "进入直播间";
//    $result = "0";
//    if($data['live_provider'] == 1 && time() > $the_end_time + 1800){
//        //echo "true";
//        //点播时间 获取点播信息
//        $rebroad_data = json_decode($Params -> getBroadCast(YikooConfig::broadcast_api,$courseid),true);
//        //var_dump($rebroad_data);
//        if($rebroad_data['code'] == "0" && !empty($rebroad_data['data']['url'])){
//            $_SESSION["rebroad_data_$courseid"] = $rebroad_data['data'];
//            $result = "success";
//            $_SESSION[$courseid.'rebroad'] = 1;
//            $button_content = "进入回看";
//            //课程处于可用状态
//            $timechecker = 2;
//        }else{
//            $_SESSION["rebroad_data_$courseid"] = "";
//            $_SESSION[$courseid.'rebroad'] = 0;
//            $timechecker = 1;
//            $result = "fail";
//            file_put_contents("../logs/rebroad_data.log",json_encode($rebroad_data),FILE_APPEND);
//        }
//    }
    $button_content = "进入直播间";
    $result = "0";
    if($data['live_provider'] == 1 && time() > $the_end_time + 1800){
        //echo "true";
        //点播时间 获取点播信息
        if( $platform == "1" || $platform == 1){
            //平台是展视直播
            $rebroad_data = json_decode($Params -> getBroadCast(YikooConfig::broadcast_api,$courseid),true);
            //var_dump($rebroad_data);
            if($rebroad_data['code'] == "0" && !empty($rebroad_data['data']['url'])){
                $_SESSION["rebroad_data_$courseid"] = $rebroad_data['data'];
                $result = "success";
                $_SESSION[$courseid.'rebroad'] = 1;
                $button_content = "进入回看";
                //课程处于可用状态
                $timechecker = 2;
            }else{
                $_SESSION["rebroad_data_$courseid"] = "";
                $_SESSION[$courseid.'rebroad'] = 0;
                $timechecker = 1;
                $result = "fail";
                file_put_contents("../logs/rebroad_data.log",json_encode($rebroad_data),FILE_APPEND);
            }
        }else{
            $result = "success";
            $_SESSION[$courseid.'rebroad'] = 1;
            $button_content = "进入回看";
            //课程处于可用状态
            $timechecker = 2;
        }

    }
    $font_config=json_decode(file_get_contents("../../ad_config/font/font$courseid.json"));
    if($font_config == null){
        //无配置标题文字 使用默认项
        $title="微观直播";
    }else{
        //有配置标题文字 使用配置项
        $title=$font_config->font_name;
        $display="display:none;";
    }
//print_r($font_config);die;
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?=$title?></title>
    <link type="text/css" rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="./css/style.css">
    <style type="text/css">

        *{
            margin: 0;
            padding: 0;
        }
        html,body{
            width: 100%;
            height: 100%;
        }

        .weui_toast {
            position: fixed;
            z-index: 50000;
            width: 7.6em;
            min-height: 7.6em;
            top: 180px;
            left: 50%;
            margin-left: -3.8em;
            background: rgba(40, 40, 40, 0.75);
            text-align: center;
            border-radius: 5px;
            color: #FFFFFF;
        }
        .weui_icon_toast {
            margin: 22px 0 0;
            display: block;
            content: '\EA08';
            color: #FFFFFF;
            font-size: 55px;
        }
        .weui_toast_content {
            margin: 10px 0 15px;
        }
    </style>
</head>
<body>
	<div class="imgheadbox" style="z-index: -1">
    <img class="imghead" style="z-index: -1" src="<?=$data['large_picture'];?>">
	</div>
	<section style="width:92%;margin-left: 4%;margin-top:0;">
	    <p class="title" style="font: normal 1em '黑体';">
	        <?=$mainContent?>
	    </p>

	</section>
	<input type="hidden" name="courseid" id="courseid"      value="<?= $data['courseid']; ?>"  readonly>
	<input  type="hidden" id="about"      value="<?=$data['about']; ?>" >

<!--<button id="join" type="button" onclick="dianji()"  class="buybut">进入直播间</button>-->
<?php
if($timechecker == 2){
    if($peo_limit == 1){
        echo <<<EOF
        <button type="submit" id="immBuy"   class=" buybut" style="opacity: 0.5" disabled >直播间人数已满</button>
EOF;
    }else{
        echo <<<EOF
        <button id="changename" type="button" onclick="nickname()" class="nickname">昵称</button>
        <button id="join" type="button" onclick="dianji()"  class="buybut">{$button_content}</button>
        </form>
EOF;
    }
}else{
    if($result == "fail"){
        $button_content = "进入回看";
        echo <<<EOF
            <div class="weui_toast">
                <i class="weui_icon_toast">
                <div class="glyph fs1">
                    <div class="clearfix bshadow0 pbs">
                        <div class="icon-spinner11">

                        </div>
                    </div>
                </div>
                </i>
                <p class="weui_toast_content">网速不给力<br>请刷新重试</p>
            </div>

EOF;
    }else{
        $button_content = "直播已经结束";
    }
    echo <<<EOF
    <button type="submit" id="immBuy"   class=" buybut" style="opacity: 0.5" disabled >{$button_content}</button>
EOF;
}
?>
<div style="<?=$display?>font: normal 0.5rem '黑体';color: darkgray;position: absolute;bottom: 10px;text-align: center;width: 100%">由微观直播<a style="text-decoration:none;" href="http://www.Vguan.cn">Vguan.cn</a>提供移动直播技术支持</div>
</body>
</html>

<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<!-- 调用JS接口的页面必须引入如下JS文件 -->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    if(typeof jQuery == 'undefined'){
        document.write("<script src='../js/jquery-1.8.3.js'><\/script>");
        //alert("jquery 加载失败");
    }else {
        //alert("jquery 加载成功");
    }
    $(function(){
        $.ajax({
            type:"POST",
            timeout:1000,
            url:'<?=YikooConfig::invite_api?>',
            async:true,
            dataType:"jsonp",
            data:{
                courseid : "<?=$courseid?>",
                UserVguanID : "<?=$UserVguanID?>",
                openid : "none",
                inviteid : "<?=$inviteid?>",
                spread : "<?=$spread?>",
                appid : "<?=$appid?>",
                status : "0",
                ip : "<?=$ipaddress?>"
            },
            // error:function(){
            //     // alert("trans fail");
            // },
            // success:function(data){
            //     // alert("trans success");
            // }
        });
    });
    iobja = document.getElementById("join");
    //直播结束检测
    if(<?=$timechecker?>==1){
        setTimeout("guanggao()",2000);
    }
    //不是免费课程
    if(<?=$permisson?> == 0){
        iobja.disabled = true;
        iobja.style.opacity = "0.5";
        document.getElementById("join").innerHTML="请前往收费直播观看";
    }

    //点击跳到修改昵称
    function nickname(){
        var course = document.getElementById('courseid').value;
        courseid = 0+course;
        location.href = "transport.php?course="+courseid+"&fromBuypage=1";
    }

    function guanggao(){
        location.href = "<?=YikooConfig::ad_url?>?deadline=1999999999";
    }
    var about = document.getElementById('about').value;

	//如果已经购买过了点击跳到支付完成的页面，去直播间去
	function dianji(){
			//需要加密
            location.href = "orderUser_gs.php?courseid=<?=$courseid?>";
	}
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
        var local_url = window.location;
        // 在这里调用 API
        var shareData = {
            title: "<?= $title.'：'.$data['title'];?>" ,
            desc: about,
            link: "<?=YikooConfig::url."/example/Buypage.php?aid=".$courseid."&inviteid=$inviteid&spread=$UserVguanID";?>",
            imgUrl: "<?=$data['small_picture'];?>"
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
                // alert(JSON.stringify(res));
                // alert(JSON.stringify(res.checkResult.getLocation));
                if (res.checkResult.getLocation == false) {
                    alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
                    return;
                }
            }
        });  
    });
</script>
