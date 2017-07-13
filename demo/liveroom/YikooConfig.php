<?php
//配置信息
class YikooConfig{

    //免费学生端链接
    const free_url = 'http://jeep1.yikoo.com/event1.2.0/wg200';

   //获取详情页信息接口地址
    const detailsurl = "http://jeep1.yikoo.com/test-student-folder/XM/index.php/Home/Webkast/info";

    //获取历史记录
    const history="http://jeep1.yikoo.com/liveroom/record.php";

    //获取聊天配置接口地址
    const chatseturl = "http://jeep1.yikoo.com/test-student-folder/setchat/index.php/Home/Index/setchat/courseid";

    //聊天审核接口地址
//    const reviewurl = "http://jeep1.yikoo.com/review/reviewapi.php";
    const reviewurl = "http://jeep1.yikoo.com/test-student-folder/review/index.php/Api/info";

    //问答接口地址
    const qaurl = "http://jeep1.yikoo.com/case/index.php/Home/Data/add";

    //问答配置接口地址
    const isqaurl = "http://jeep1.yikoo.com/case/index.php/Home/Api/SwitchCourse.html";

    //用户行为统计接口
    const exiturl = "http://jeep1.yikoo.com/test-student-folder/api_backend/index.php/Behaviour/updataData";

    //人数统计接口
    const counturl = "http://jeep1.yikoo.com/test-student-folder/api_backend/index.php/Behaviour/addData";

    //人次统计接口
    const totalurl = "http://jeep1.yikoo.com/test-student-folder/tongji/api/index.php/Home/Count/total_add";

     //奥点云获取直播地址
    const aodianyunUrl = "http://jeep1.yikoo.com/test-student-folder/aodianyun/index.php/Home/Api/api_info.html";

    //奥点云获取点播地址
    const aodianyunVodUrl = "http://jeep1.yikoo.com/aodianyunVodBackend/getUrl.php";

    //腾讯云获取点播地址
    const tencentVodUrl = "http://vod-tecent-test.myartkoo.com/index.php/Home/Api/VideoUrl";

    //防盗链链接
    const fang_url="http://test-sites.biggerfish.cn/API/index.php/Home/Api/validation";

    //定制的courseid
    const courseid="IBE20170614093818";

    //经济id
    const jingjiid="DMJ20170619134122";

    //附属courseid
    const id="MWK20170608155213";

    //广告图片链接
    const picurl = "http://jeep1.yikoo.com/test-student-folder/liveroom/upload";
}
?>