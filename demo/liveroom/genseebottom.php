<?php

//require_once "YikooConfig.php";

//通过courseid获取聊天配置
//$courseid = $_GET['courseid'];
//聊天配置接口
$chatset = curl_init(YikooConfig::chatseturl ."/$courseid");
curl_setopt($chatset, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
curl_setopt($chatset, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
$chat = curl_exec($chatset);

//返回值：
// "1"：开   "2"，关  "3"，审核
// 默认返回 "1"

if( $chat == '"2"' ){

    //只有  文档  直播详情  聊天关
    if( $isok == 200 ){
        $bottom = " 
            <ul class='longli'>
                <li class='sortli left active'>文档</li>
                <li class='sortli left'><span class='leftline'></span>直播详情</li>
            </ul>
            <div>
                <div class='modeldisplay  focus'>
                    <!--获取信息显示-->
                    <gs:doc id='docComponent' site=". $gensee_url ." ownerid=". $ownerid ." />
                </div>
                <div class='modeldisplay' style='overflow:scroll;'>
                    <!--获取信息显示-->
                    ". $desc ."
                </div>
            </div>
        ";
    }else{
        //直播详情关  聊天关  只用聊天
        $bottom = " 
            <ul class='longli'>
                <li class=''>文档</li>
            </ul>
            <div>
                <div class='modeldisplay  focus'>
                    <!--获取信息显示-->
                    <gs:doc id='docComponent' site=". $gensee_url ." ownerid=". $ownerid ." />
                </div>
            </div>
        ";
    }


}elseif ( $chat == '"3"') {

    //有审核聊天、直播详情、文档
    if( $isok == 200 ){
        $bottom = "
            <ul class='longli'>
                <li class='threeli left active'>文档</li>
                <li class='threeli left'><span class='leftline'></span>聊天</li>
                <li class='threeli left'><span class='leftline'></span>详情</li>
            </ul>
            <div>
                <div class='modeldisplay  focus'>
                    <!--获取信息显示-->
                    <gs:doc id='docComponent' site=". $gensee_url ." ownerid=". $ownerid ." />
                </div>
                <div id='chatbox'  class='modeldisplay'>
                    <textarea id='chat_show'  readonly='readonly'></textarea>
                    <div id='rop_context'></div>
                    <div class='foot'>
                        <input  id='idtext' value='' onkeydown='keyDownReview(event)'/>
                        <button type='button' class='btn btn-info' onClick='PublishReview();'>
                            发送
                        </button>
                    </div>
                </div>
                <div class='modeldisplay' style='overflow:scroll;'>
                    <!--获取信息显示-->
                    ". $desc ."
                </div>
            </div>
        ";       
    }else{
        //有 文档  审核聊天 直播详情关
        $bottom = "
            <ul class='longli'>
                <li class='sortli left active'>文档</li>
                <li class='sortli left'><span class='leftline'></span>聊天</li>
            </ul>
            <div>
                <div class='modeldisplay  focus'>
                    <!--获取信息显示-->
                    <gs:doc id='docComponent' site=". $gensee_url ." ownerid=". $ownerid ." />
                </div>
                <div id='chatbox'  class='modeldisplay'>
                    <textarea id='chat_show'  readonly='readonly'></textarea>
                    <div id='rop_context'></div>
                    <div class='foot'>
                        <input  id='idtext' value='' onkeydown='keyDownReview(event)'/>
                        <button type='button' class='btn btn-info' onClick='PublishReview();'>
                            发送
                        </button>
                    </div>
                </div>
            </div>
        ";
    }

}else{
    //无审核聊天和直播详情
    if( $isok == 200){
        $bottom = "
            <ul class='longli'>
                <li class='threeli left active'>文档</li>
                <li class='threeli left'><span class='leftline'></span>聊天</li>
                <li class='threeli left'><span class='leftline'></span>详情</li>
            </ul>
            <div>
                <div class='modeldisplay  focus'>
                    <!--获取信息显示-->
                    <gs:doc id='docComponent' site=". $gensee_url ." ownerid=". $ownerid ." />
                </div>
                <div id='chatbox'  class='modeldisplay'>
                    <textarea id='chat_show'  readonly='readonly'></textarea>
                    <div id='rop_context'></div>
                    <div class='foot'>
                        <input  id='idtext' value='' onkeydown='keyDown(event)'/>
                        <button type='button' class='btn btn-info' onClick='Publish();'>
                            发送
                        </button>
                    </div>
                </div>
                <div class='modeldisplay' style='overflow:scroll;'>
                    <!--获取信息显示-->
                    ". $desc ."
                </div>
            </div>
        ";       
    }else{
        //无审核聊天  直播详情关
        $bottom = "
            <ul class='longli'>
                <li class='sortli left active'>文档</li>
                <li class='sortli left'><span class='leftline'></span>聊天</li>
            </ul>
            <div>
                <div class='modeldisplay  focus'>
                    <!--获取信息显示-->
                    <gs:doc id='docComponent' site=". $gensee_url ." ownerid=". $ownerid ." />
                </div>
                <div id='chatbox'  class='modeldisplay'>
                    <textarea id='chat_show'  readonly='readonly'></textarea>
                    <div id='rop_context'></div>
                    <div class='foot'>
                        <input  id='idtext' value='' onkeydown='keyDown(event)'/>
                        <button type='button' class='btn btn-info' onClick='Publish();'>
                            发送
                        </button>
                    </div>
                </div>
            </div>
        ";
    }


}
