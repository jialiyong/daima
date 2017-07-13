<?php
require_once __DIR__ . '/../autoload.php';
// 'secrectKey' => 'a4biVAouc2ku_wT--zxBRwdE_IWCj20cSRDCbXEM',
//            'accessKey' => 'Ju0OhRR5g3vdCSD2Gbd1DZUfiE1h9wdl6iiPqfXa',
//            'domain' => '7xrxhu.com1.z0.glb.clouddn.com',
//            'bucket' => 'testonly',
// 引入鉴权类
use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;

// 需要填写你的 Access Key 和 Secret Key
$accessKey = 'Ju0OhRR5g3vdCSD2Gbd1DZUfiE1h9wdl6iiPqfXa';
$secretKey = 'a4biVAouc2ku_wT--zxBRwdE_IWCj20cSRDCbXEM';

// 构建鉴权对象
$auth = new Auth($accessKey, $secretKey);

// 要上传的空间
$bucket = 'testonly';

// 生成上传 Token
$token = $auth->uploadToken($bucket);

// 要上传文件的本地路径
$filePath = './php-logo.png';

// 上传到七牛后保存的文件名
$key = 'my-php-logo.png';

// 初始化 UploadManager 对象并进行文件的上传。
$uploadMgr = new UploadManager();

// 调用 UploadManager 的 putFile 方法进行文件的上传。
list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
echo "\n====> putFile result: \n";
if ($err !== null) {
    var_dump($err);
} else {
    var_dump($ret);
}
