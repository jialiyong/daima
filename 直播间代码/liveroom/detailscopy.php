<?php
    //require_once "YikooConfig.php";

    //通过接口获取详情页信息
//    echo YikooConfig::detailsurl . "?courseid=MWK20170608155213";
    $ch = curl_init(YikooConfig::detailsurl . "?courseid=".YikooConfig::id) ;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
    $output = curl_exec($ch) ;

    $obj = json_decode($output);
    //var_dump($obj);
    //获取状态值
    $isok = $obj->data->status;

    $desccopy = $obj->data->desc;
    //判断是否获取成功
    /*
    if( $isok == 200 ){

        $desc = $obj->data->desc;

    }else{

        $desc = '<img src="http://producten-10021492.file.myqcloud.com/images/ad.jpg" alt="微观直播" class=""/>';

    }*/
    
?>