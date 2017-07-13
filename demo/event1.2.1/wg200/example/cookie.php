<?php
/**
 * Created by PhpStorm.
 * -------------------------
 *Author:NOCNing
 * -------------------------
 *Date:2016/8/31 13:56
 * -------------------------
 *Caution:No comments for u            ( ˇˍˇ )
 *        it was hard to write
 *        so it should be hard to read O(∩_∩)O~
 **/
class cookieSet{
    /**
     * cookie 初始化模块
     */
    function initializeCookie(){
        //初始化 cookie
        if(empty($_COOKIE['UserVguanID'])){
            // expire time of user's cookie
            $expirtime = time() + 365 * 24 * 60 * 60;
            $userid = "vguan".$this -> getRandomChar(17).time();
            setcookie("UserVguanID","$userid",$expirtime,"/");
            //echo "cookid 初始化成功".$_COOKIE['UserVguanID'];
            return $userid;
        }else{
            //echo "欢迎来访".$_COOKIE['UserVguanID']."<br>";
            return $_COOKIE['UserVguanID'];
        }
    }

    /**
     * 随机字符串生成
     * @param $length 随机字符串长度
     * @return null|string 随机字符串
     */
    function getRandomChar($length){
        $pool = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $pool_length = strlen($pool);
        $result = null;
        for($i = 0; $i < $length ;$i++){
            $result .= $pool[rand(0,$pool_length - 1)];
        }
        return $result;
    }
}