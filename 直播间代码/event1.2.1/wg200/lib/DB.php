<?php
/**
 * Created by PhpStorm.
 * -------------------------
 *Author:NOCNing
 * -------------------------
 *Date:2016/9/28 16:36
 * -------------------------
 *Caution:No comments for u            ( ˇˍˇ )
 *        it was hard to write
 *        so it should be hard to read O(∩_∩)O~
 **/

define('DB_CHARSET',"utf8");
//第一数据库  存储课程信息 位于Buypage.php
define('DB_HOST',"101.200.235.158");
define('DB_USERNAME',"xinfang");
define('DB_PASSWORD',"xinfang123");
define('DB_NAME',"test_huodong");
define('DB_PORT',"3306");
//第二数据库  存储课程切换信息 位于orderUser_gs.php
define('DB_HOST2',"101.200.235.158");
define('DB_USERNAME2',"xinfang");
define('DB_PASSWORD2',"xinfang123");
define('DB_NAME2',"free_white_bacground");
define('DB_PORT2',"3306");


class DB{
    private $DBObject;
    /**
     * connect to DB
     * $DB   可选数据库
     * @return mysqli
     */
    public function DBConnect($DB){
        if(empty($DB) || $DB == "1" || $DB == 1){
            $this -> DBObject = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME,DB_PORT);
        }else{
            $this -> DBObject = new mysqli(DB_HOST2,DB_USERNAME2,DB_PASSWORD2,DB_NAME2,DB_PORT2);
        }
        $this -> DBObject -> set_charset(DB_CHARSET);
        return $this -> DBObject;
    }

    /**
     * select
     * @param $sql
     * @return array
     */
    public function selectALL($sql){
        $data = $this ->DBObject ->query($sql);
        while( $list = $data -> fetch_assoc()){
            $result[] = $list;
        };
        if(count($result) == 1){
            $result = $result[0];
        }
        if(count($result) == 0){
            $result = 0;
        }
        return $result;
    }

    public function query($sql){
        $data = $this -> DBObject -> query($sql);
        var_dump(json_encode($data));
        if($data){
            return true;
        }else{
            return false;
        }
    }
}