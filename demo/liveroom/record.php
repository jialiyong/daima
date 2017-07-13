<?php
    header("Content-type:text/html;charset=utf-8");
    

    /**
     * 发送curl的get请求
     * @access protected
     * @param string $host 每个接口加上http头 Authorization:dms <DMS的s_key>
     * @param string $url  访问的url链接
     * @param array $data  填写的参数
     * @return json
     */
    function curlGet($host , $url , $data )
    {
        
        $ch = curl_init(); 
        $data = http_build_query($data);
        $url .= '?' . $data;
        curl_setopt($ch, CURLOPT_HTTPHEADER,$host );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);     
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    $host = array("Authorization:dms s_c7fb0e8cd8c57d9aa06c8e788a789c66");
    $url  = 'http://api.dms.aodianyun.com/v1/historys/OPB20170503101210/0/200';
    $http = 'http://api.dms.aodianyun.com/v2/historys';
    $courseid = $_POST['courseid'];
    $get  = array(
        'skip'  => 0,
        'num'   => 200,
        'topic' => $courseid,
        'startTime' => 1459827015,
        'endTime'   => time()
    );
    $data = json_decode(curlGet( $host , $http ,$get),true); 
    // echo "<pre>";

    $flag = array();
    foreach($data as $v){
        $flag[] = $v['time'];
    }
    array_multisort($flag, SORT_ASC, $data);
    $str = null;
    foreach ($data as $key => $value) {
            $str.=$value['msg'];
            $str.="\r\n";
    }
    //    var_dump($data);die;
//var_dump($str);die;
    echo $str;
