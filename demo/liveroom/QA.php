<?php
require_once "YikooConfig.php";
//获取问答记录
$courseid = $_GET["courseid"];
// 参数数组
$data = array(
    'courseid' => $courseid . "QA"
);
$ch = curl_init();
// print_r($ch);
curl_setopt($ch, CURLOPT_URL, YikooConfig::history);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$question = curl_exec($ch);
//print_r($question);die;

curl_close($ch);
//print_r($question);die;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
          value="notranslate">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title></title>
    <link href="http://producten-10021492.file.myqcloud.com/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/qa.css"/>
    <script src="http://producten-10021492.file.myqcloud.com/js/jquery.js"></script>
    <script src="http://producten-10021492.file.myqcloud.com/js/bootstrap.min.js"></script>
</head>
<body>
<div id='QA' class='modeldisplay focus'>
    <div id='QA_show'>
        <?= $question ?>
    </div>
    <div id='rop_context'></div>
    <div class='foot'>
        <input id='QAinput' value='' onkeydown='keyDown(event)'/>
        <button type='button' class='btn btn-info send' onClick='PublishQA();'>
            提问
        </button>
    </div>
</div>
</body>
<script>
    var userAgent = navigator.userAgent;
    var isAndroid = userAgent.indexOf('Android') > -1 || userAgent.indexOf('Adr') > -1;
    if(!isAndroid){
//解决第三方软键盘唤起时底部input输入框被遮挡问题
        var bfscrolltop = $('body', parent.document)[0].scrollTop;//获取软键盘唤起前浏览器滚动部分的高度
        $("input").focus(function(){//在这里‘input.inputframe’是我的底部输入栏的输入框，当它获取焦点时触发事件
            interval = setInterval(function(){//设置一个计时器，时间设置与软键盘弹出所需时间相近
                $('body', parent.document)[0].scrollTop = $('body', parent.document)[0].scrollHeight;//获取焦点后将浏览器内所有内容高度赋给浏览器滚动部分高度
            },500)
        }).blur(function(){//设定输入框失去焦点时的事件
            clearInterval(interval);//清除计时器
            $('body', parent.document)[0].scrollTop = bfscrolltop;//将软键盘唤起前的浏览器滚动部分高度重新赋给改变后的高度
        });
    }
</script>
<!-- 奥点云DMS -->
<script type="text/javascript" src="http://cdn.aodianyun.com/dms/rop_client.js"></script>
<script type="text/javascript" src="js/qa.js"></script>
<script type="text/javascript">
    window.onload = function () {
        var divQA_show = document.getElementById('QA_show');
        divQA_show.scrollTop = divQA_show.scrollHeight;
    }
    var QA = window.parent.document.getElementById('publicshow');
    var list = $(QA).prev().children().length;
    if (list == 1) {
        scheight = QA.offsetHeight;
    } else {
        scheight = QA.offsetHeight * 0.5;
    }
    //定义模块的宽高
    $('.modeldisplay').height(scheight);
</script>
</html>