<?php
    header("Content-type: text/html; charset = utf-8");
    //接收参数
    $courseid = $_GET['courseid'];
    $openid = $_GET['openid'];
    $entrytime = $_GET['timestamp'];

    //连接数据库
    $con = mysql_connect("123.57.70.26","root","M808723987");
    if (!$con)
      {
      die('Could not connect: ' . mysql_error());
      }
    mysql_query("set names 'utf8'");
    mysql_select_db("livelimit", $con);

    //获取当前用户状态
    $result = mysql_query("SELECT status FROM userlimit WHERE courseid = '$courseid' AND openid = '$openid' AND entrytime = '$entrytime'");

    while($row = mysql_fetch_assoc($result))
      {
        $status = ($row['status']);
      }
    
    //若已有记录则返回记录值，1为有效，2为无效
    if($status == 1 || $status == 2){
        echo $status;
    }else{
        //若无记录则先查询此节课的此用户是否有为1的状态
        $record = mysql_query("SELECT id FROM userlimit WHERE courseid = '$courseid' AND openid = '$openid' AND status = '1'");

        while($cord = mysql_fetch_assoc($record))
        {
            $cordid = ($cord['id']);
        }
        //如果之前已经有状态为1的值，则将上一个状态改为2
        if($cordid){
            mysql_query("UPDATE userlimit SET status = '2' WHERE id = '$cordid'");
        }
        //将本条记录插入数据库
        mysql_query("INSERT INTO userlimit (courseid, openid, entrytime,status) 
            VALUES ('$courseid', '$openid', '$entrytime','1')");

        //返回有效值
        echo "1";
    }

    mysql_close($con);
?>