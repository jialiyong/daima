<?php
/**
 * -------------------------
 *Author:NOCNing
 * -------------------------
 *Date:2016/2/16 14:22
 **/
class YikooConfig{

    //当前服务器域名（到wxpay）       如 http://jeep1.yikoo.com/wxpay
    const url = 'http://jeep1.yikoo.com/test-student-folder/event1.2.1/wg200';

    //【学生端配置部分】
    //广告页面url
    const ad_url = '../../ad/advertisement.php';

    //展视urlhttp://stream.vguan.cn
    const gensee_url = 'http://yikoo888.gensee.com';
    

    //乐视   ->  奥点云 ../../liveroom/attention.php
    const letv_url = 'http://jeep1.yikoo.com/liveroom/attentionAodianyun.php';
    //PC端
    const letv_pcurl = 'http://jeep1.yikoo.com/liveroomPC/attentionAodianyun.php';

    const aodianyun_rebroad = "http://jeep1.yikoo.com/liveroom/attentionAodianyunVod.php";

    //baidu -》  腾讯
    const baidu_url = 'http://jeep1.yikoo.com/liveroom/attentiontencent.php';

    const tencent_rebroad = "http://jeep1.yikoo.com/liveroom/attentiontencentVod.php";

    //金山
    const jinshan_url = 'http://jeep1.yikoo.com/liveroom/attentionali.php';

    //阿里pc端
    const jinshan_pcurl = 'http://jeep1.yikoo.com/liveroomPC/attentionali.php';

    //阿里云
    const ali_url = 'http://jeep1.yikoo.com/liveroom/attentionali.php';

    //阿里云pc
    const ali_pcurl = 'http://jeep1.yikoo.com/liveroomPC/attentionali.php';

    //阿里安卓直播
    const aliandroid_url='http://jeep1.yikoo.com/liveroom/attentionaliandroid.php';

    //奥点云安卓直播
    const letvandroid_url='http://jeep1.yikoo.com/liveroom/attentionAodianyunandroid.php';


    const jinshan_rebroad = "http://jeep1.yikoo.com/liveroom/attentionksyVod.php";

    //星域
    const star_url = 'http://jeep1.yikoo.com/liveroom/attentionxy.php';

    //从liveroom调用展视直播间页面
    const to_gensee = 'http://jeep1.yikoo.com/liveroom/attentionali.php';

    //invite_api 用户访问记录接口地址http://jeep1.yikoo.com/ykapi/invite_api.php
    const invite_api = 'http://jeep1.yikoo.com/test-student-folder/invite_api_3/invite_api.php';

    //直播间用户人次记录 包括白名单与普通观众
    const peopleCountAPI = "http://jeep1.yikoo.com/test-student-folder/peoCountAPI/peoCountAPI.php";

    //【广告配置部分】
    //广告图片目录
    const pic_dir = "../pic/";

    //广告页面 对应 广告图片名称
    const start_ad_url = "../pic/qian.jpg";

    //广告页面 对应 广告图片名称
    const end_ad_url = "../pic/hou.jpg";

    //广告展现量与点击量统计接口 http://logs.biggerfish.cn/adStatisticAPI/adStatisticAPI.php
    const adStatisticAPI = "http://jeep1.yikoo.com/adStatisticAPI/adStatisticAPI.php";

        //点播信息获取接口
    const broadcast_api = 'http://jeep1.yikoo.com/test-student-folder/dianbo_backend/index.php/Api/WebCast/get_info.html';
    
    //默认用户昵称前缀    前缀ABCD
    const namePrefix = "观众";
}
