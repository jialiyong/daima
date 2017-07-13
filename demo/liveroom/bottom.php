<?php

require_once "YikooConfig.php";

//通过courseid获取聊天配置
//$courseid = $_GET['courseid'];
//获取聊天历史记录
require_once "history.php";

function getFun ( $url, $courseid ){
    $ch  = curl_init("$url" ."$courseid");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
    $result = curl_exec($ch);
    return $result;
}

/*
    获取聊天状态
    返回值：
    "1"：开   "2"，关  "3"，审核
    默认返回 "1"
 */
$chat = getFun(YikooConfig::chatseturl."/",$courseid);

/*
    获取问答状态
    返回值：
    1：开  0：关
    默认返回 1
 */
$isqa = getFun(YikooConfig::isqaurl."?courseid=",$courseid);


//聊天关
if( $chat == '"2"' ){
    //直播详情开
    if( $isok == "1" ){
        //问答开
        if( $isqa == "1" ){
            //  <ul class='longli' style='$display'><a onclick='pic_on()'><img src='$picture'></a></ul>
            $bottom = "
                <ul class='longli'>
                    <li class='sortli left active'>详情</li>
                    <li class='sortli left'><span class='leftline'></span>问答</li>
                </ul>
                <div id='publicshow'>
                    <div class='modeldisplay focus' style='overflow:scroll;'>
                        <!--获取信息显示-->
                        ". $desc ."
                    </div>
                    <iframe src='QA.php?courseid=".$courseid."&nickname=".$nickname."' id='QA' class='modeldisplay focus' name='submitFrame' allowtransparency='true' style='background-color=transparent' title='QA' frameborder='0' scrolling='no'></iframe>
                </div>
            ";
            //问答关
        }else{
            $bottom = "

                <ul class='longli'>
                    <li class=''>详情</li>
                </ul>
                <div id='publicshow'>
                    <div class='modeldisplay focus' style='overflow:scroll;'>
                        <!--获取信息显示-->
                        ". $desc ."
                    </div>
                </div>
            ";
        }

        //直播详情关
    }else{
        //问答开
        if ( $isqa == "1" ) {
            $bottom = "

                <ul class='longli'>
                    <li class=''>问答</li>
                </ul>
                <div id='publicshow'>
                    <iframe src='QA.php?courseid=".$courseid."&nickname=".$nickname."' id='QA' class='modeldisplay focus' name='submitFrame' allowtransparency='true' style='background-color=transparent' title='QA' frameborder='0' scrolling='no'></iframe>
                </div>
            ";
            //问答关
        }else{
            $bottom = "

                <ul class='longli'>
                    <li class=''>暂无内容</li>
                </ul>
                <div id='publicshow'>

                </div>
            ";
        }
    }

//审核聊天开
}elseif ( $chat == '"3"') {
    //直播详情开
    if( $isok == "1" ){
        //问答开
        if ( $isqa == "1" ){
            $bottom = "

                <ul class='longli'>
                    <li class='threeli left active'>聊天</li>
                    <li class='threeli left'><span class='leftline'></span>详情</li>
                    <li class='threeli left'><span class='leftline'></span>问答</li>
                </ul>
                <div id='publicshow'>
                    <div id='chatbox'  class='modeldisplay focus'>
                        <textarea id='chat_show'  readonly='readonly'>$return</textarea>
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
                    <iframe src='QA.php?courseid=".$courseid."&nickname=".$nickname."' id='QA' class='modeldisplay focus' name='submitFrame' allowtransparency='true' style='background-color=transparent' title='QA' frameborder='0' scrolling='no'></iframe>
                </div>
            ";
            //问答关
        }else{
            $bottom = "

                <ul class='longli'>
                    <li class='sortli left active'>聊天</li>
                    <li class='sortli left'><span class='leftline'></span>详情</li>
                </ul>
                <div id='publicshow'>
                    <div id='chatbox'  class='modeldisplay focus'>
                        <textarea id='chat_show'  readonly='readonly'>$return</textarea>
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
        }

        //直播详情关
    }else{
        //问答开
        if ( $isqa == "1" ){
            $bottom = "

                <ul class='longli'>
                    <li class='sortli left active'>聊天</li>
                    <li class='sortli left'><span class='leftline'></span>问答</li>
                </ul>
                <div id='publicshow'>
                    <div id='chatbox'  class='modeldisplay focus'>
                        <textarea id='chat_show'  readonly='readonly'>$return</textarea>
                        <div id='rop_context'></div>
                        <div class='foot'>
                            <input  id='idtext' value='' onkeydown='keyDownReview(event)'/>
                            <button type='button' class='btn btn-info' onClick='PublishReview();'>
                                发送
                            </button>
                        </div>
                    </div>
                    <iframe src='QA.php?courseid=".$courseid."&nickname=".$nickname."' id='QA' class='modeldisplay focus' name='submitFrame' allowtransparency='true' style='background-color=transparent' title='QA' frameborder='0' scrolling='no'></iframe>
                </div>
            ";
            //问答关
        }else{
            $bottom = "

                <ul class='longli'>
                    <li class=''>聊天</li>
                </ul>
                <div id='publicshow'>
                    <div id='chatbox'  class='modeldisplay focus'>
                        <textarea id='chat_show'  readonly='readonly'>$return</textarea>
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
    }
//无审核聊天
}else{
    //直播详情开
    if( $isok == "1"){
        //问答开
        if ( $isqa == "1"){
            if($courseid==YikooConfig::courseid){
                $bottom = "

                <ul class='longli'>
                    <li class='threeli left active' style='width:25%'>聊天</li>
                    <li class='threeli left' style='width:25%'><span class='leftline'></span>解决方案</li>
                    <li class='threeli left' style='width:25%'><span class='leftline'></span>会议日程</li>
                    <li class='threeli left' style='width:25%'><span class='leftline'></span>问答</li>
                </ul>
                <div id='publicshow'>
                    <div id='chatbox'  class='modeldisplay focus'>
                        <textarea id='chat_show'  readonly='readonly'>$return</textarea>
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
                      <div class='modeldisplay' style='overflow:scroll;'>
                        <!--获取信息显示-->
                        ". $desccopy ."
                    </div>
                    <iframe src='QA.php?courseid=".$courseid."&nickname=".$nickname."' id='QA' class='modeldisplay focus' name='submitFrame' allowtransparency='true' style='background-color=transparent' title='QA' frameborder='0' scrolling='no'></iframe>
                </div>
            ";
            }else{
                $bottom = "

                <ul class='longli'>
                    <li class='threeli left active'>聊天</li>
                    <li class='threeli left'><span class='leftline'></span>详情</li>
                     <li class='threeli left'><span class='leftline'></span>问答</li>
                </ul>
                <div id='publicshow'>
                    <div id='chatbox'  class='modeldisplay focus'>
                        <textarea id='chat_show'  readonly='readonly'>$return</textarea>
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
                    <iframe src='QA.php?courseid=".$courseid."&nickname=".$nickname."' id='QA' class='modeldisplay focus' name='submitFrame' allowtransparency='true' style='background-color=transparent' title='QA' frameborder='0' scrolling='no'></iframe>
                </div>
            ";
            }
            //问答关
        }else{
            if($courseid==YikooConfig::jingjiid){
                $bottom = "

                <ul class='longli'>
                   <!-- <li class='sortli left active'>聊天</li>-->
                    <li class='active'>详情</li>
                </ul>
                <div id='publicshow'>
                   <!-- <div id='chatbox'  class='modeldisplay focus'>
                        <textarea id='chat_show'  readonly='readonly'>$return</textarea>
                        <div id='rop_context'></div>
                        <div class='foot'>
                            <input  id='idtext' value='' onkeydown='keyDown(event)'/>
                            <button type='button' class='btn btn-info' onClick='Publish();'>
                                发送
                            </button>
                        </div>
                    </div>
                    -->
                    <div class='modeldisplay focus' style='overflow:scroll;'>
                        <!--获取信息显示-->
                        ". $desc ."
                    </div>
                </div>
            ";
            }else{
                $bottom = "

                <ul class='longli'>
                    <li class='sortli left active'>聊天</li>
                    <li class='sortli left'><span class='leftline'></span>详情</li>
                </ul>
                <div id='publicshow'>
                    <div id='chatbox'  class='modeldisplay focus'>
                        <textarea id='chat_show'  readonly='readonly'>$return</textarea>
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
            }

        }

        //直播详情关
    }else{
        //问答开
        if ( $isqa == "1" ){
            $bottom = "

                <ul class='longli'>
                    <li class='sortli left active'>聊天</li>
                    <li class='sortli left'><span class='leftline'></span>问答</li>
                </ul>
                <div id='publicshow'>
                    <div id='chatbox'  class='modeldisplay focus'>
                        <textarea id='chat_show'  readonly='readonly'>$return</textarea>
                        <div id='rop_context'></div>
                        <div class='foot'>
                            <input  id='idtext' value='' onkeydown='keyDown(event)'/>
                            <button type='button' class='btn btn-info' onClick='Publish();'>
                                发送
                            </button>
                        </div>
                    </div>
                    <iframe src='QA.php?courseid=".$courseid."&nickname=".$nickname."' id='QA' class='modeldisplay focus' name='submitFrame' allowtransparency='true' style='background-color=transparent' title='QA' frameborder='0' scrolling='no'></iframe>
                </div>
            ";
            //问答关
        }else{
            $bottom = "

                <ul class='longli'>
                    <li class=''>聊天</li>
                </ul>
                <div id='publicshow'>
                    <div id='chatbox'  class='modeldisplay focus'>
                        <textarea id='chat_show'  readonly='readonly'>$return</textarea>
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

}
?>
<script>
  function pic_on(){
      location.href="<?=$href?>";
  }
</script>

