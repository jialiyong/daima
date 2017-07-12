<?php
require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;

$accessKey = 'Ju0OhRR5g3vdCSD2Gbd1DZUfiE1h9wdl6iiPqfXa';
$secretKey = 'a4biVAouc2ku_wT--zxBRwdE_IWCj20cSRDCbXEM';
$auth = new Auth($accessKey, $secretKey);

$bucket = 'testonly';
$upToken = $auth->uploadToken($bucket);

echo $upToken;

// 'secrectKey' => 'a4biVAouc2ku_wT--zxBRwdE_IWCj20cSRDCbXEM',
//            'accessKey' => 'Ju0OhRR5g3vdCSD2Gbd1DZUfiE1h9wdl6iiPqfXa',
//            'domain' => '7xrxhu.com1.z0.glb.clouddn.com',
//            'bucket' => 'testonly',
