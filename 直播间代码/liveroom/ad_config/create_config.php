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
//error_reporting(0);
$courseid = $_POST['courseid'];
$ad_id = $_FILES['start_ad_id'];
$name=$_FILES['start_ad_id']['name'];
if(!empty($ad_id)){
    move_uploaded_file($_FILES["start_ad_id"]["tmp_name"], "../upload/" . $_FILES["start_ad_id"]["name"]);
}else{
    echo "<h1><center>选择图片</center></h1>";
}
$end_ad_id = $_POST['end_ad_id'];

$info = array(
    "courseid" => "$courseid",
    "picture" => "$name",
    "href" => "$end_ad_id"
);
$json = json_encode($info);
if (!empty($courseid)) {
    if (file_put_contents("$courseid.json", $json)) {
        echo "<h2><center>广告图片添加成功</center></h2>";
    } else {
        echo "<h1><center>广告图片添加失败</center></h1>";
    }
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加广告图片</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
    <style rel="stylesheet">
        .theform {
            width: 40%;
            margin-left: 30%;
            text-align: center;
        }

        legend {
            font-weight: 600;
        }

        h1 {
            color: red;
            position: absolute;
            bottom: 50px;
            text-align: center;
            width: 100%;

        }

        h2 {
            color: green;
            position: absolute;
            bottom: 50px;
            text-align: center;
            width: 100%;

        }
    </style>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data" role="form" class="theform">
    <legend>广告图片添加模块</legend>
    <div class="form-group">
        <label for="courseid">课程id(若该直播为活动则填写 config)</label>
        <input type="text" class="form-control" name="courseid" id="courseid" placeholder="courseid...">
        <label for="number">广告图片</label>
        <input type="file" name="start_ad_id" id="ad_id" placeholder="广告图片默认为空">
        <label for="number">广告链接</label>
        <input type="text" class="form-control" name="end_ad_id" id="end_ad_id" placeholder="广告链接默认为空">
    </div>
    <button type="submit" class="btn btn-primary">提交修改</button>
</form>


</body>
</html>
