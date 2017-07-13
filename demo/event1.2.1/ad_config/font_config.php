<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2017/5/5
 * Time: 12:15
 */
//error_reporting(0);
$courseid = $_POST['courseid'];
$ad_id = $_POST['start_ad_id'];

$info = array(
    "courseid" => "$courseid",
    "font_name" => "$ad_id",
);
$json = json_encode($info);
if(!empty($courseid)){
    if(file_put_contents("./font/font$courseid.json",$json)){
        echo "<h2><center>文字配置添加成功</center></h2>";
    }else {
        echo "<h1><center>文字配置添加失败</center></h1>";
    }
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加文字配置</title>
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
    <legend>文字配置添加模块</legend>
    <div class="form-group">
        <label for="courseid">课程id</label>
        <input type="text" class="form-control" name="courseid" id="courseid" placeholder="courseid...">
        <label for="number">文字名称</label>
        <input type="text" class="form-control" name="start_ad_id" id="ad_id" placeholder="默认文字名称微观直播">
    </div>
    <button type="submit" class="btn btn-primary">提交修改</button>
</form>
</body>
</html>
