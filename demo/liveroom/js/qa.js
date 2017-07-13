    //定义获取get参数函数
    function getQueryStr(str) {
    var LocString = String(window.document.location.href);
    var rs = new RegExp("(^|)" + str + "=([^&]*)(&|$)", "gi").exec(LocString), tmp;
    if (tmp = rs) {
        return decodeURIComponent(tmp[2]);
    }
    return "";
    }

    //生成随机字符串
    function randomString(len) {
    　　len = len || 32;
    　　var $chars = 'ABCDEFGHJKMNPQRSTWXYZ';    /****默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1****/
    　　var maxPos = $chars.length;
    　　var pwd = '';
    　　for (i = 0; i < len; i++) {
    　　　　pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
    　　}
    　　return pwd;
    }

    //输入框添加回车事件 无审核
    function keyDown(e){
        var ev = window.event||e;
        //13是键盘上固定的回车键
        if( ev.keyCode == 13 ){
            //执行发送方法
            PublishQA();
        }
    }

    //输入框添加回车时间 有审核
    function keyDownReview(e){
        var ev = window.event||e;
        //13是键盘上固定的回车键
        if( ev.keyCode == 13 ){
            //执行发送方法
            PublishReview();
        }
    }

    //获取courseid作为DMS的topic
    var courseid = getQueryStr("courseid");
    var userName = getQueryStr("nickname");
    if (!userName) {
        userName = "观众" + randomString(4);
    }
    courseid = courseid ? courseid : "yoga";     //默认为yoga

    var QAid = courseid + "QA";

    //ajax请求请求审核接口
    var reviewapi = new XMLHttpRequest();

    //当前时间
    var showmoment;
    //完整消息内容
    var message;

    //登陆成功
    ROP.On("enter_suc",
            function() {
                //ShowMsg("您已加入课程，现在可以讨论互动！");
            })
    //重连中
    ROP.On("reconnect",
            function() {
                //ShowMsg("reconnect:");
            })
    //离线状态，之后会重连
    ROP.On("offline",
            function(err) {
                //ShowMsg("offline:" + err);
            })
    //登陆失败
    ROP.On("enter_fail",
            function(err) {
                //ShowMsg("EnterFail:" + err);
            })
    //收到消息
    
    ROP.On("publish_data",
            function(data, topic) {
                ShowQA(data);
                //ShowMsg("用户名：yoga   时间：11：00");
            })

    //彻底断线了
    ROP.On("losed",
            function() {
                //ShowMsg("Losed");
            })

    //显示问题
    function ShowQA(str) {
        //document.getElementById("QA_show").value = str + '\n' + document.getElementById("QA_show").value;
        $('#QA_show').append(str);
        var divQA_show = document.getElementById('QA_show');
         divQA_show.scrollTop = divQA_show.scrollHeight;
    }

    //定义提问推送
    function PublishQA(){
        var question = document.getElementById('QAinput').value;
        question = $.trim(question);
        if (question){
            if(question.length <= 140){
                showmoment = getTimes();
                //发送的消息体
                //message = userName+ "         ("+ showmoment +"):\\n    " + question;
                //ajax请求
                $.ajax({
                  type:'post',
                  url:'./QAapi.php',
                  data:{"courseid":courseid,"nickname":userName,"question":question},
                  success:function(msg){
                    //显示问题
                    var sendquestion = '<div class="question"><div class="q-title"><span class="q-name left">我</span><span class="q-text left">&nbsp;&nbsp;问</span><span class="q-time right">'+ showmoment +'</span></div><div class="q-content">'+ question +'</div></div>';
                    $('#QA_show').append(sendquestion);
                    document.getElementById("QAinput").value = "";
                     var divQA_show = document.getElementById('QA_show');
                    divQA_show.scrollTop = divQA_show.scrollHeight;
                  }
                });
            }else{
                alert("单条消息超过140字！")
            }                     
        }else{
            //alert("发送内容不能为空！");
        }
    }

    //加入实例凭证
    function OnEnter() {
        ROP.Enter("pub_73e6c06c474c6c291ce0b49977c26aba", "sub_3b216fd2fe364c95992aff0ce4c92f0c");
    }
    //加入topic
    function OnJoin(courseid) {
        ROP.Subscribe(courseid);//课程title（房间号）
    }
    function OnUnJoin() {
        ROP.UnSubscribe(document.getElementById("idgroup").value);
    }
    function Clear(){
        document.getElementById("chat_show").value = ""
    }
    function getTimes(){
        //获取时间
        var moment = new Date();
        var h = moment.getHours();
        var m = moment.getMinutes();
        var s = moment.getSeconds();

        m = checktime(m);
        s = checktime(s);
        function checktime(x){
            if(x > 10){}
            else {x="0"+x}
            return x;
        }
        var showmoment = h+":"+m+":"+s;
        return showmoment;
    }
    OnEnter();
    OnJoin(QAid);
