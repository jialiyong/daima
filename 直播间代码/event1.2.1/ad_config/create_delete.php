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
if (!empty($courseid)) {
    if (unlink("./file/$courseid.json")) {
        echo "<h2><center>广告配置删除成功</center></h2>";
    } else {
        echo "<h1><center>广告配置删除失败</center></h1>";
    }
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>删除广告配置</title>
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
    <legend>广告配置删除模块</legend>
    <div class="form-group">
        <label for="courseid">课程id</label>
        <input type="text" class="form-control" name="courseid" id="courseid" placeholder="courseid...">
    </div>
    <button type="submit" class="btn btn-primary">提交修改</button>
</form>
</body>
</html>

