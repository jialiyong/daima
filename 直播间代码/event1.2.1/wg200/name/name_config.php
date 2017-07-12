<?php
/**
 * Created by PhpStorm.
 * -------------------------
 *Author:NOCNing
 * -------------------------
 *Date:2016/8/17 10:33
 * -------------------------
 *Caution:No comments for u            ( ˇˍˇ )
 *        it was hard to write
 *        so it should be hard to read O(∩_∩)O~
 **/
$ip = ($_SERVER['HTTP_VIA']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
if(!($ip === "182.18.114.87")){
    echo "<h1><center>Not allowed</center></h1>";die;
}
error_reporting(0);
$courseid = $_POST['courseid'];
$prefix = $_POST['nickname'];


$info = array(
    "courseid" => "$courseid",
    "prefix" => "$prefix",
);

$json = json_encode($info);
if(!empty($courseid)){
    if(file_put_contents("$courseid.json",$json)){
        echo "<h2><center>昵称前缀 $prefix 添加成功</center></h2>";
    }else {
        echo "<h1><center>昵称前缀 $prefix 添加失败</center></h1>";
    }
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加昵称配置</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
    <style rel="stylesheet">
        .theform{
            width: 40%;
            margin-left: 30%;
            text-align: center;
        }
        legend{
            font-weight: 600;
        }
        h1{
            color: red;
            position: absolute;
            bottom: 50px;
            text-align: center;
            width: 100%;

        }
        h2{
            color: green;
            position: absolute;
            bottom: 50px;
            text-align: center;
            width: 100%;

        }
    </style>
</head>
<body>
<form action="" method="post" role="form" class="theform">
    <legend>昵称前缀配置</legend>
    <div class="form-group">
        <label for="courseid">课程id</label>
        <input type="text" class="form-control" name="courseid" id="courseid" placeholder="courseid...">
        <label for="number">用户昵称前缀</label>
        <input type="text" class="form-control" name="nickname" id="nickname" placeholder="昵称前缀">
    </div>
    <button type="submit" class="btn btn-primary">提交修改</button>
</form>
</body>
</html>
