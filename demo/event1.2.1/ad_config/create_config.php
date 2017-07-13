<?php
/**
 *-------------------
 * User: cymsummer
 * Date: 2017/6/9
 *-------------------
 * Time: 20:26
 */
//error_reporting(E_ERROR);
//$host = $_SERVER['SERVER_ADDR'];
//if($host!="123.56.249.145"){
//    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
//    echo "您不是管理员不能修改配置文件";
//    die;
//}

require_once './php-sdk-7.1.3/autoload.php';
require_once './Qiniu.config.php';
// 引入鉴权类
use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;

// 需要填写你的 Access Key 和 Secret Key
$accessKey = QiniuConfig::accessKey;
$secretKey = QiniuConfig::secretKey;

// 构建鉴权对象
$auth = new Auth($accessKey, $secretKey);
// 要上传的空间
$bucket = QiniuConfig::bucket;

//图片域名
$domain=QiniuConfig::domain;
//echo $domain;die;

// 生成上传 Token
$token = $auth->uploadToken($bucket);

//error_reporting(0);
$courseid = $_POST['courseid'];
$ad_id = $_FILES['start_ad_id'];
if(!empty($ad_id)){
    // 要上传文件的本地路径
    $filePath = $ad_id['tmp_name'];
    //图片的后缀类型名称
    $names=strstr($ad_id['name'], '.', TRUE); //参数设定true, 返回查找值.之前的首部
    $name=strstr($ad_id['name'], '.'); //默认返回查找值.之后的尾部，.jpg
    // 上传到七牛后保存的文件名
    $startname =$courseid.strtotime(date("Y-m-d H:i:s",time())).rand(1000,9999).$name;
    // 初始化 UploadManager 对象并进行文件的上传。
    $uploadMgr = new UploadManager();
    // 调用 UploadManager 的 putFile 方法进行文件的上传。
    list($ret, $err) = $uploadMgr->putFile($token, $startname, $filePath);
    if ($err !== null) {
        echo "\n====> putFile result: \n";
        var_dump($err);
    }
}
$end_ad_id = $_FILES['end_ad_id'];
if(!empty($end_ad_id)){
    // 要上传文件的本地路径
    $filePath = $end_ad_id['tmp_name'];
    //图片的后缀类型名称
    $names=strstr($end_ad_id['name'], '.', TRUE); //参数设定true, 返回查找值.之前的首部
    $name=strstr($end_ad_id['name'], '.'); //默认返回查找值.之后的尾部，.jpg
    // 上传到七牛后保存的文件名
    $endname =$courseid.strtotime(date("Y-m-d H:i:s",time())).rand(1000,9999).$name;
    // 初始化 UploadManager 对象并进行文件的上传。
    $uploadMgr = new UploadManager();
    // 调用 UploadManager 的 putFile 方法进行文件的上传。
    list($ret, $err) = $uploadMgr->putFile($token, $endname, $filePath);

    if ($err !== null) {
        echo "\n====> putFile end result: \n";
        var_dump($err);
    }
}
$url=$_POST['url'];
$info = array(
    "courseid" => "$courseid",
    "start_ad_id" => "$domain/$startname",
    "end_ad_id" => "$domain/$endname",
    "url"=>"$url"
);

$json = json_encode($info);
if(!empty($courseid)){
    if(file_put_contents("./file/$courseid.json",$json)){
        echo "<h2><center>广告配置添加成功</center></h2>";
    }else {
        echo "<h1><center>广告配置添加失败</center></h1>";
    }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加广告配置</title>
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
<form action="" method="post" role="form" enctype="multipart/form-data" class="theform">
    <legend>广告配置添加模块</legend>
    <div class="form-group">
        <label for="courseid">课程id</label>
        <input type="text" class="form-control" name="courseid" id="courseid" placeholder="courseid...">
        <label for="number">未开始广告图片</label>
        <input type="file" name="start_ad_id" id="ad_id">
        <label for="number">结束后广告图片</label>
        <input type="file" name="end_ad_id" id="ad_id">
        <label for="pic">图片链接地址</label>
        <input type="text" class="form-control" name="url" id="url" placeholder="默认连接地址http://ehall.vguan.cn/">
    </div>
    <button type="submit" class="btn btn-primary">提交修改</button>
</form>
</body>
</html>

