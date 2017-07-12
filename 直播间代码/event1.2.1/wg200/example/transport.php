<?php 
	/**
	 * 用户修改昵称页
	 */

    session_start();
    $courseid = $_SESSION['courseid'];
    if(!empty($_GET['username'])){
        $_SESSION["nickname".$courseid] = $_GET['username'];
        //echo $courseid.$_GET['username'].$_SESSION["nickname".$courseid] ;die;
        header("location:orderUser_gs.php");die;
    }
    if(empty($_GET['fromBuypage'])){
        header("location:Buypage.php");die;
    }
    require_once "../lib/Yikoo.config.php";
    require_once "GetParams.free.class.php";
    if(empty( $_SESSION["nickname".$courseid])){
        $Params = new PARAMS();
        $nikename = $Params->getNickname();
    }else{
        $nikename = $_SESSION["nickname".$courseid];
    }
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>我的昵称</title>
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <link type="text/css" rel="stylesheet" href="css/main.css">
    <link type="text/css" rel="stylesheet" href="css/load4.css">
    <script type="text/javascript">
       function disabled(){
			var username = $('#username').val();
			if ( username == '' ){
				alert('请输入昵称再提交');
				return false;
			}else{
				 document.getElementById('cloud').style.display="block";
				$("#but").attr({"disabled":"disabled"});
		    	$("#but").val('正在跳转，请稍等。。。');
		    	return true;
			}
        }
    </script>
    <style>
        #divv
        {
            position: absolute;
            text-align: center;
            height: 40%;
            width: 100%;
            margin-top: 40%;
            background-color: #B6E3E6;
        }
        #cloud{
            position: absolute;
            display: none;
            margin-top: -10%;
            height: 40%;
            width: 50%;
            margin-left: 25%;
        }
    </style>
</head>
<body style="background: #CBE6E1">
<div class="load-container load4"  name="cloud" id="cloud">
    <div class="loader">Loading...</div>
</div>
<!--
style="position: absolute;display: none;width: 50%;height: 40%;margin-left: 25%;margin-top: 0;"
style="position: absolute;margin-top: 51%"
-->
<div id="divv" class="alert alert-success">
    <form action="" method="get" onsubmit=" return disabled()"  name="form1">
        <div class="form-group" style="margin-top: 10%">
            <label class="sr-only" for="exampleInputAmount">nickname</label>
            <div class="input-group">
                <div class="input-group-addon">昵称</div>
                <input type="text" class="form-control" name="username" id="username" onkeyup="value=value.replace(/[^(a-z)(A-Z)0-9\u4E00-\u9FA5]/g,'')" value="<?= $nikename;?>">
            </div>
        </div>
        <input type="hidden" name="course" value="<?= $_GET['course']; ?>"/>
        <input id="but"  type="submit" class="btn"  style="color: white;background:#5A8296;width: 94%;height: 20%;align-content: center;margin-left: 3%;margin-top: 0%" value="立即修改">
    </form>
</div>
</body>
</html>

