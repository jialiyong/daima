    if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
    WEB_SOCKET_SWF_LOCATION = "/swf/WebSocketMain.swf";
    WEB_SOCKET_DEBUG = true;
    var ws, name, client_list={};

    // 连接服务端
    function connect() {
       // 创建websocket
       ws = new WebSocket("ws://123.56.49.137:7272");
       // 当socket连接打开时，输入用户名
       ws.onopen = onopen;
       // 当有消息时根据消息类型显示不同信息
       ws.onmessage = onmessage; 
       ws.onclose = function() {

          console.log("连接关闭，定时重连");
          connect();
       };
       ws.onerror = function() {
          console.log("出现错误");
       };
    }

    // 连接建立时发送登录信息
    function onopen()
    {
        name=userName;
        // if(!name)
        // {
        //     show_prompt("张三");
        // }flush_client_list
        // 登录
        //type 类型
        // client_name 用户名
        // room_id 房间号
        var login_data = '{"type":"login","client_name":"'+name.replace(/"/g, '\\"')+'","room_id":"'+courseid+'","ip":"'+Ip+'"}';
        console.log("websocket握手成功，发送登录数据:"+login_data);
        console.log("ip:"+Ip);
        console.log("uname:"+name);
        ws.send(login_data);
    }

    // 服务端发来消息时
    function onmessage(e)
    {
        console.log(e.data);
        var data = eval("("+e.data+")");
        switch(data['type']){
            // 服务端ping客户端
            case 'ping':
                ws.send('{"type":"pong"}');
                break;;
            // 登录 更新用户列表
            case 'login':

                //{"type":"login","client_id":xxx,"client_name":"xxx","client_list":"[...]","time":"xxx"}
                // say(data['client_id'], data['client_name'],  data['client_name']+' 加入了聊天室', data['time']);
                if(data['client_list'])
                {
                    client_list = data['client_list'];
                }
                else
                {
                    client_list[data['client_id']] = data['client_name']; 
                }
                //flush_client_list();
                console.log(data['client_name']+"登录成功");


                console.log(u_id);

                console.log(userName);
                break;
            // 发言
             case 'say':
                //{"type":"say","from_client_id":xxx,"to_client_id":"all/client_id","content":"xxx","time":"xxx"}
                // say(data['from_client_id'], data['client_name'], data['content'], data['time']);
                 break;
            // 用户退出 更新用户列表
            case 'logout':
            // alert(data['from_client_name']+data['client_id'])
               // $.post("http://jeep1.yikoo.com/test-student-folder/api_backend/index.php/Behaviour/updataData",{courseid:courseid,username:userName,unique_id:u_id},function(msg){});
                var xhr = new XMLHttpRequest();
                //./exittimeapi.php?courseid='+courseid+'&username='+userName+'&unique_id='+u_id;
                xhr.open('get','./exittimeapi.php?courseid='+courseid+'&username='+userName+'&unique_id='+u_id,'true');
                xhr.send(null);
                break;
        }
    }

    // 输入姓名
    function show_prompt(names){  
        // name = prompt('输入你的名字：', '');
        // if(!name || name=='null'){  
            name = names;
        // }
    }  

    // 提交对话
    // function onSubmit() {
    //   var input = document.getElementById("textarea");
    //   var to_client_id = $("#client_list option:selected").attr("value");
    //   var to_client_name = $("#client_list option:selected").text();
    //   ws.send('{"type":"say","to_client_id":"'+to_client_id+'","to_client_name":"'+to_client_name+'","content":"'+input.value.replace(/"/g, '\\"').replace(/\n/g,'\\n').replace(/\r/g, '\\r')+'"}');
    //   input.value = "";
    //   input.focus();
    // }

    // 刷新用户列表框
    // function flush_client_list(){
    //     var userlist_window = $("#userlist");
    //     var client_list_slelect = $("#client_list");
    //     userlist_window.empty();
    //     client_list_slelect.empty();
    //     userlist_window.append('<h4>在线用户</h4><ul>');
    //     client_list_slelect.append('<option value="all" id="cli_all">所有人</option>');
    //     for(var p in client_list){
    //         userlist_window.append('<li id="'+p+'">'+client_list[p]+'</li>');
    //         client_list_slelect.append('<option value="'+p+'">'+client_list[p]+'</option>');
    //     }
    //     $("#client_list").val(select_client_id);
    //     userlist_window.append('</ul>');
    // }

    // 发言
    // function say(from_client_id, from_client_name, content, time){
    //     $("#dialog").append('<div class="speech_item"><img src="http://lorempixel.com/38/38/?'+from_client_id+'" class="user_icon" /> '+from_client_name+' <br> '+time+'<div style="clear:both;"></div><p class="triangle-isosceles top">'+content+'</p> </div>');
    // }

    $(function(){
        select_client_id = 'all';
        $("#client_list").change(function(){
             select_client_id = $("#client_list option:selected").attr("value");
        });
    });