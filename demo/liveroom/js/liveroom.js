//2017/6/21 15.00 创建
//解决安卓手机输入框被遮挡问题
    $('body').height($('body')[0].clientHeight);
    //判断安卓 
    var userAgent = navigator.userAgent;
    var isAndroid = userAgent.indexOf('Android') > -1 || userAgent.indexOf('Adr') > -1;
    if(!isAndroid){
    //ios解决第三方软键盘唤起时底部input输入框被遮挡问题
    var bfscrolltop = document.body.scrollTop;//获取软键盘唤起前浏览器滚动部分的高度
    $("input").focus(function(){//在这里‘input.inputframe’是我的底部输入栏的输入框，当它获取焦点时触发事件
        interval = setInterval(function(){//设置一个计时器，时间设置与软键盘弹出所需时间相近
        document.body.scrollTop = document.body.scrollHeight;//获取焦点后将浏览器内所有内容高度赋给浏览器滚动部分高度
        },500)
    }).blur(function(){//设定输入框失去焦点时的事件
        clearInterval(interval);//清除计时器
        document.body.scrollTop = bfscrolltop;//将软键盘唤起前的浏览器滚动部分高度重新赋给改变后的高度
    });
}
        /*播放/暂停*/
        var $switch = $('.switch');
        /*全屏*/
        var $expand = $('.expand');
    //设置播放器的宽高
    my_video.style.width = window.innerWidth + "px";     
    my_video.style.height = window.innerHeight-4 + "px"; 
    my_video.style["object-position"]= "0px 0px";
    window.onresize=function(){
        if(a==2){
            $('body').height(window.innerHeight);
            my_video.style.width = window.innerWidth + "px";     
            my_video.style.height = window.innerHeight-4 + "px"; 
             $(".modeldisplay").height($(".bottle").height()-40);
             $(".foot").css("bottom","5px");
             window.a = 0;
        }else if(a==1){
             $('body').height(window.innerHeight);
             my_video.style.width = window.innerWidth + "px";     
            my_video.style.height = window.innerHeight + "px"; 
            $(".modeldisplay").height($(".bottle").height()-40);
            $(".foot").css("bottom","0px");
            window.a = 0;
        }
    };
	window.onload = function() {
         var obj = document.getElementById("chat_show");
        obj.scrollTop = obj.scrollHeight;
        $("iframe").css("display","none");
    };
      my_video.addEventListener("x5videoenterfullscreen", function(){
         window.a = 2;
        $expand.css("display",'none');
         $(".bottle").css({"position":"absolute","top":"31.5%"});
     }) 
     my_video.addEventListener("x5videoexitfullscreen", function(){
       window.a = 1;
       $switch.addClass('fa-play').removeClass('fa-pause');
        $expand.css("display",'block');
         $(".bottle").css({"position":"relative","top":"0"});
     }) 
     //控制条js
     $switch.on('click',function(){
            if($(this).hasClass('fa-play')){
                my_video.play();
                $(this).removeClass('fa-play').addClass('fa-pause');
            }else if($(this).hasClass('fa-pause')){
                my_video.pause();
                $(this).addClass('fa-play').removeClass('fa-pause');
            }
        });
        $("#playerbutton").click(function () {
           my_video.play();
        });
        $expand.click(function(){
            my_video.webkitRequestFullScreen();
             my_video.play();
            // $(".bottle").css('display','none');
            // my_video.style["object-position"]= "";
        });
        //当视频播放时隐藏控制条
         my_video.onplay = function () {
            $("#playerbutton").css("display","none");
            $switch.removeClass('fa-play').addClass('fa-pause');
            setTimeout(function () {
                $(".controls").fadeOut()
            },2000)
        };
        //当视频播放时显示控制条
         my_video.onpause = function () {
            $("#playerbutton").css("display","block");
            $(".controls").fadeIn();
        };
        //点击视频显示控制条
        my_video.addEventListener('touchstart', function(event) {
　　　　    event.preventDefault();// 阻止浏览器默认事件，重要 
            $(".controls").fadeIn().delay(4000).fadeOut();
        }, false);
    /*退出时间统计start*/
    window.addEventListener("pagehide", function(){
        updateMenusIndex2();//Ajax请求
        setTimeout(function(){},1000);
    }, false);
    //function updateMenusIndex2(){
    //    var url = './exittimeapi.php?courseid=' + courseid + '&username=' + userName + '&unique_id=' + u_id;
    //    $.ajax({
    //        url: url,
    //        async: false                //必须采用同步方法
    //    });
    //}
    //document.addEventListener('visibilitychange', function () {
    //    var isHidden = document.hidden;
    //    if (isHidden) {
    //        var url = './exittimeapi.php?courseid=' + courseid + '&username=' + userName + '&unique_id=' + u_id;
    //        $.ajax({
    //            url: url,
    //            async: false                //必须采用同步方法
    //        });
    //    }
    //});
    /*退出时间end*/

    //面板切换事件
    $('.longli li').each(function(i,item){
        $(item).click(function(){
            $(this).addClass('active').siblings().removeClass('active');
            $('.modeldisplay').eq(i).show().siblings().hide();
        });
    });
    //获取屏幕的宽度
    
    var scwidth = window.innerWidth;     
    //计算iframe的高度
    var scheight = window.innerHeight;
    var oIframe = document.getElementById('myTabContent');
    var oDoc = document.getElementById('doc');
    scheight = scheight*0.685-40;
    //定义模块的宽高
    $('.modeldisplay').width(scwidth);
    $('.modeldisplay').height(scheight);