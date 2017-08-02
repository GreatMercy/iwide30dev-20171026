<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
class Bgy extends MY_Controller {
    function __construct() {
        parent::__construct ();
        set_time_limit ( 0 );
        ini_set ( 'display_errors', 0 );
        if (version_compare ( PHP_VERSION, '5.3', '>=' )) {
            error_reporting ( E_ALL & ~ E_NOTICE & ~ E_DEPRECATED & ~ E_STRICT & ~ E_USER_NOTICE & ~ E_USER_DEPRECATED );
        } else {
            error_reporting ( E_ALL & ~ E_NOTICE & ~ E_STRICT & ~ E_USER_NOTICE );
        }
        $this->iwide_hotels = array (
                array (
                        'name' => '顺德碧桂园度假村',
                        'hotel_id' => '1' 
                ),
                array (
                        'name' => '碧桂花城大酒店',
                        'hotel_id' => '2' 
                ),
                array (
                        'name' => '广州凤凰城酒店',
                        'hotel_id' => '3' 
                ),
                array (
                        'name' => '广州碧桂园假日半岛酒店',
                        'hotel_id' => '4' 
                ),
                array (
                        'name' => '鹤山碧桂园凤凰酒店',
                        'hotel_id' => '5' 
                ),
                array (
                        'name' => '五邑碧桂园凤凰酒店',
                        'hotel_id' => '6' 
                ),
                array (
                        'name' => '阳江碧桂园凤凰酒店',
                        'hotel_id' => '7' 
                ),
                array (
                        'name' => '长沙碧桂园凤凰酒店',
                        'hotel_id' => '8' 
                ),
                array (
                        'name' => '台山碧桂园凤凰酒店',
                        'hotel_id' => '9' 
                ),
                array (
                        'name' => '肇庆碧桂园凤凰酒店',
                        'hotel_id' => '10' 
                ),
                array (
                        'name' => '新会碧桂园凤凰酒店',
                        'hotel_id' => '11' 
                ),
                array (
                        'name' => '荆门碧桂园凤凰酒店',
                        'hotel_id' => '12' 
                ),
                array (
                        'name' => '随州碧桂园凤凰酒店',
                        'hotel_id' => '13' 
                ),
                array (
                        'name' => '安庆碧桂园凤凰酒店',
                        'hotel_id' => '14' 
                ),
                array (
                        'name' => '咸宁碧桂园凤凰温泉酒店',
                        'hotel_id' => '15' 
                ),
                array (
                        'name' => '高明碧桂园凤凰酒店',
                        'hotel_id' => '16' 
                ),
                array (
                        'name' => '芜湖碧桂园玛丽蒂姆酒店',
                        'hotel_id' => '17' 
                ),
                array (
                        'name' => '重庆长寿碧桂园凤凰酒店',
                        'hotel_id' => '18' 
                ),
                array (
                        'name' => '武汉碧桂园凤凰酒店',
                        'hotel_id' => '19' 
                ),
                array (
                        'name' => '韶关碧桂园凤凰酒店',
                        'hotel_id' => '20' 
                ),
                array (
                        'name' => '滨湖城碧桂园凤凰酒店',
                        'hotel_id' => '21' 
                ),
                array (
                        'name' => '黄山碧桂园凤凰酒店',
                        'hotel_id' => '22' 
                ),
                array (
                        'name' => '佛冈碧桂园假日温泉酒店',
                        'hotel_id' => '23' 
                ),
                array (
                        'name' => '沈阳碧桂园假日酒店',
                        'hotel_id' => '24' 
                ),
                array (
                        'name' => '池州碧桂园凤凰酒店',
                        'hotel_id' => '25' 
                ),
                array (
                        'name' => '天津碧桂园凤凰酒店',
                        'hotel_id' => '26' 
                ),
                array (
                        'name' => '宁乡碧桂园凤凰酒店',
                        'hotel_id' => '27' 
                ),
                array (
                        'name' => '乐昌碧桂园凤凰酒店',
                        'hotel_id' => '28' 
                ),
                array (
                        'name' => '碧桂园欧洲城凤凰酒店',
                        'hotel_id' => '29' 
                ),
                array (
                        'name' => '碧桂园如山湖凤凰酒店（和县）',
                        'hotel_id' => '30' 
                ),
                array (
                        'name' => '泰州碧桂园凤凰温泉酒店',
                        'hotel_id' => '31' 
                ),
                array (
                        'name' => '梅州碧桂园假日酒店',
                        'hotel_id' => '32' 
                ),
                array (
                        'name' => '巢湖碧桂园凤凰酒店',
                        'hotel_id' => '33' 
                ),
                array (
                        'name' => '碧桂园凤凰城酒店（南京）',
                        'hotel_id' => '34' 
                ),
                array (
                        'name' => '碧桂园十里银滩酒店',
                        'hotel_id' => '35' 
                ),
                array (
                        'name' => '通辽碧桂园凤凰酒店',
                        'hotel_id' => '36' 
                ),
                array (
                        'name' => '惠阳碧桂园凤凰酒店',
                        'hotel_id' => '37' 
                ),
                array (
                        'name' => '海城碧桂园凤凰酒店',
                        'hotel_id' => '38' 
                ),
                array (
                        'name' => '云浮碧桂园凤凰酒店',
                        'hotel_id' => '39' 
                ),
                array (
                        'name' => '兴安盟碧桂园凤凰酒店',
                        'hotel_id' => '40' 
                ),
                array (
                        'name' => '茂名碧桂园凤凰酒店',
                        'hotel_id' => '41' 
                ),
                array (
                        'name' => '海南碧桂园金沙滩温泉酒店',
                        'hotel_id' => '42' 
                ),
                array (
                        'name' => '碧桂园十里金滩酒店',
                        'hotel_id' => '43' 
                ),
                array (
                        'name' => '碧桂园小城之春假日酒店',
                        'hotel_id' => '44' 
                ),
                array (
                        'name' => '碧桂园翡翠湾凤凰酒店(开平)',
                        'hotel_id' => '45' 
                ),
                array (
                        'name' => '张家界碧桂园凤凰酒店',
                        'hotel_id' => '50' 
                ),
                array (
                        'name' => '广州碧桂园空港凤凰酒店',
                        'hotel_id' => '54' 
                ),
                array (
                        'name' => '沈阳碧桂园凤凰酒店',
                        'hotel_id' => '59' 
                ),
                array (
                        'name' => '北流碧桂园凤凰酒店',
                        'hotel_id' => '60' 
                ),
                array (
                        'name' => '碧桂园太阳城凤凰酒店',
                        'hotel_id' => '61' 
                ),
                array (
                        'name' => '广州碧桂园凤凰酒店管理有限公司',
                        'hotel_id' => '62' 
                ),
                array (
                        'name' => '贵阳碧桂园假日酒店',
                        'hotel_id' => '63' 
                ),
                array (
                        'name' => '龙江碧桂园凤凰酒店',
                        'hotel_id' => '271' 
                ),
                array (
                        'name' => '阳山碧桂园凤凰酒店',
                        'hotel_id' => '4010' 
                ),
                array (
                        'name' => '海南澄迈碧桂园美浪湾凤凰酒店',
                        'hotel_id' => '4011' 
                ),
                array (
                        'name' => '惠州碧桂园润杨溪谷温泉酒店',
                        'hotel_id' => '4815' 
                ),
                array (
                        'name' => '广州碧桂园空港凤祺公寓',
                        'hotel_id' => '5240' 
                ),
                array (
                        'name' => '佛冈碧桂园假日温泉酒店（公寓）',
                        'hotel_id' => '5241' 
                ),
                array (
                        'name' => '海南碧桂园金沙滩凤祺公寓',
                        'hotel_id' => '5242' 
                ),
                array (
                        'name' => '惠东碧桂园十里银滩凤祺公寓',
                        'hotel_id' => '5244' 
                ) 
        );
    }
    function reind() {
        echo '<html><title>刷新酒店缓存</title><script type="text/javascript" src="http://ihotels.iwide.cn/public/media/scripts/jquery.js"></script>';
        foreach ( $this->iwide_hotels as $h ) {
            echo '<a href="javascript:void(0);" onclick="recache(' . $h ['hotel_id'] . ')">' . $h ['name'] . '</a>  <span style="color:red" id="' . $h ['hotel_id'] . '"></span><br /><br />';
        }
        $url = site_url ( 'hotel/bgy/recache' );
        echo <<<END
<script >
    function recache(hotel_id){
        $('#'+hotel_id).html('刷新中');
        $.get("$url",{hotel:hotel_id},function(data){
            if(data==1){
                $('#'+hotel_id).html('刷新成功');
            }else{
                $('#'+hotel_id).html('刷新失败，请重试');
            }
        });
    }                
</script>
END;
        echo '</html>';
    }
    function recache() {
        $hotel_id = intval ( $this->input->get ( 'hotel' ) );
        if (empty ( $hotel_id )) {
            echo 0;
            exit ();
        }
        $this->load->helper ( 'common' );
        $today = time ();
        $status = 1;
        for($i = 0; $i < 3; $i ++) {
            $url = 'http://biguiyuan30.iwide.cn/index.php/hotel/auto_gogogo/update_ftai_biguiyuan?hotel=' . $hotel_id . '&day=' . $i;
            if (! doCurlGetRequest ( $url, array (), 300 )) {
                $status = 0;
            }
        }
        echo $status;
    }
}