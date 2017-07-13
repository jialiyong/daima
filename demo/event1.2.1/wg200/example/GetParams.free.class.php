<?php
/**
 * Created by PhpStorm.
 * -------------------------
 *Author:NOCNing
 * -------------------------
 *Date:2016/4/22 15:06
 * -------------------------
 *Caution:No comments for u            ( ˇˍˇ )
 *        it was hard to write
 *        so it should be hard to read O(∩_∩)O~
 **/
class PARAMS{
    public function Getcourseid(){
        if(empty($_GET['aid'])){
            if(empty($_SESSION['courseid'])){
                echo '<h1><center>error courseid</center></h1>';die;
            }else{
                return $_SESSION['courseid'];
            }
        }else{
            if(empty($_SESSION['courseid']) || $_SESSION['courseid'] != $_GET['aid']){
                $_SESSION['courseid'] = $_GET['aid'];
            }
            return $_GET['aid'];
        }
    }
    public function Getinviteid($update = false){
        if(empty($_GET['inviteid'])){
            if($update){
                $_SESSION['inviteid'] = "empty";
                return "empty";
            }else{
                if(empty($_SESSION['inviteid'])){
                    $_SESSION['inviteid'] = "empty";
                    return "empty";
                }else{
                    return $_SESSION['inviteid'];
                }
            }
        }else{
            $_SESSION['inviteid'] = $_GET['inviteid'];
            return $_GET['inviteid'];
        }
    }
    public function Getspread($update = false){
        if(empty($_GET['spread'])){
            if($update){
                $_SESSION['spread'] = "empty";
                return "empty";
            }else{
                if(empty($_SESSION['spread'])){
                    $_SESSION['spread'] = "empty";
                    return "empty";
                }else{
                    return $_SESSION['spread'];
                }
            }
        }else{
            $_SESSION['spread'] = $_GET['spread'];
            return $_GET['spread'];
        }
    }

    function getNickname(){
        global $courseid;
        if(empty($_SESSION['nickname'.$courseid])){
            //echo "if".$courseid.$_SESSION['nickname'.$courseid];die;
            if(file_exists("../name/$courseid.json")){
                $data = json_decode(file_get_contents("../name/$courseid.json"),true);
                if(!empty($data['prefix'])){
                    $prefix = $data['prefix'];
                }else{
                    $prefix = YikooConfig::namePrefix;
                }
            }else{
                $prefix = YikooConfig::namePrefix;
            }
            if(substr($_SESSION['nickname'.$courseid],0,strlen($prefix)) === $prefix){
                return $_SESSION['nickname'.$courseid];
            }else{
                $_SESSION['nickname'.$courseid] = $prefix.$this -> getRandomChar(4);
                return $_SESSION['nickname'.$courseid];
            }
        }else{
            return $_SESSION['nickname'.$courseid];
        }
    }

    public function getRandomChar($num){
        $pool = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $length = strlen($pool) - 1;
        $str = null;
        for($i = 0;$i < $num;$i++){
            $str = $str.$pool[rand(0,$length)];
        }
        return $str;
    }

    public function get_token($courseid,$microtime,$nickname){
        $piece = "vguan";
        $param = $piece.$courseid.$microtime.$nickname;
        $token_prime = md5($param);
        $token = substr(md5(sha1($token_prime)),0,10);
        return $token;
    }

    public function getMicrotime(){
        list($t1,$t2) = explode(' ',microtime());
        return $t2.substr($t1,3,3);
    }
    /**
     * 获取时间token值
     * @param $time
     * @param $timeout
     * @return string
     */
    public function get_time_token($time,$timeout){
        $param = $time + $timeout;
        $time_token = md5($param);
        return $time_token;
    }

    function getBroadCast($api_url,$courseid){
        $ch = curl_init();
        $url = "$api_url";
        $data = array(
            "courseid" => "$courseid"
        );
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_TIMEOUT,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,1);
        $result = curl_exec($ch);
//        var_dump($result);
//        var_dump(curl_error($ch));
        curl_close($ch);
        return $result;
    }
}