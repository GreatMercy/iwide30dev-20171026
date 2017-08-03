<?php
use App\services\soma\KillsecService;
use App\services\soma\WxService;
use App\services\soma\ExpressService;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Killsec
 *
 *
 *
 * @property Activity_killsec_model $activityKillsecModel
 */
class Killsec extends MY_Front_Soma
{

    public $themeConfig;
    public $theme = 'default';

    public function __construct()
    {
        parent::__construct();
        //theme
        $this->load->model('soma/Theme_config_model');
        $this->themeConfig = $themeConfig = $this->Theme_config_model->get_using_theme($this->inter_id);
        $this->theme = $themeConfig['theme_path'];
    }

    //展示为以后的皮肤做扩展
    protected function _view($file, $datas = array())
    {
//        parent::_view('package'. DS. $file, $datas);
        parent::_view('package' . DS . $file, $datas);
    }

    /* 兼容函数 */
    public function killsec_pay()
    {
        $this->package_pay();
    }

    public function killsec_detail()
    {
        $this->package_detail();
    }

    public function package_detail()
    {
        $uparams = $this->input->get();
        $url = Soma_const_url::inst()->get_url('*/package/package_detail', $uparams);
    }

    /**
     * 秒杀库存信息
     */
    public function find_killsec_stock_ajax()
    {
        $actId = $this->input->post('act_id');
        $result = KillsecService::getInstance()->getStock($actId);
        $this->json($result->getData());
    }
//    public function find_killsec_stock_ajax()
//    {
//        $return = array('status'=>Soma_base::STATUS_FALSE, 'total'=>1, 'stock'=>1, 'percent'=>'100%');
//
//        $actId = $this->input->post('act_id');
//        $this->load->model('soma/Activity_killsec_model','activityKillsecModel');
//        $killsec = $this->activityKillsecModel->get_aviliable_activity( array('act_id'=>$actId ) );
//        if( $killsec && !empty($killsec[0])) {
//            $killsec = $killsec[0];
//            $ks_model= $this->activityKillsecModel;
//            $instance= $ks_model->get_aviliable_instance( array(
//                'act_id'=>$killsec['act_id'], 'status'=> array_keys($ks_model->get_instance_status())
//            ) );
//
//            if( !isset($instance[0]) ){
//                //没有任何活动实例，适用于新活动
//                $ks_count = $killsec['killsec_count'];
//                $ks_stock = $killsec['killsec_count'];
//
//            } else {
//                if( $instance[0]['status']==$ks_model::INSTANCE_STATUS_GOING ){
//                    //活动进行中的库存显示
//                    $cache= $this->_load_cache();
//                    $redis= $cache->redis->redis_instance();
//                    $key= $this->activityKillsecModel->redis_token_key($instance[0]['instance_id']);
//                    $ks_stock = $redis->lSize($key);
//
//                } elseif( $instance[0]['status']==$ks_model::INSTANCE_STATUS_PREVIEW ){
//                    //活动开始半小时内的库存显示
//                    $ks_stock = $killsec['killsec_count'];
//
//                } elseif( $instance[0]['close_time']< date('Y-m-d H:i:s') ){
//                    //活动上一轮结束 - 开始半小时前的库存显示
//                    $ks_stock = $killsec['killsec_count'];
//
//                } else {
//                    //活动卖光的库存显示
//                    $ks_stock = 0;
//                }
//                $ks_count = $killsec['killsec_count'];
//            }
//            $ks_stock= ($ks_stock>= $ks_count)? $ks_count: $ks_stock;
//            $ks_percent= round($ks_stock / $ks_count, 2) * 100;
//            $return= array('status'=>Soma_base::STATUS_TRUE, 'total'=>$ks_count, 'stock'=>$ks_stock, 'percent'=> $ks_percent );
//        }
//        echo json_encode( $return );
//    }

    /**
     * 订阅秒杀信息
     *
     */
    public function subscribe_killsec_notice_ajax()
    {
        $return= array('status'=> Soma_base::STATUS_FALSE, 'data'=>array(), 'message'=> '找不到活动信息。' );
        $actId = $this->input->post('act_id');
        
        $this->load->model('soma/Activity_killsec_model', 'activityKillsecModel');
        $activity= $this->activityKillsecModel->get_aviliable_activity( array('act_id'=>$actId ) );
        
        if( !empty($activity) && !empty($activity[0]) && $activity[0]['inter_id'] === $this->inter_id ){
            $activity = $activity[0];
            if( isset($activity['status']) && $activity['status'] == Activity_killsec_model::STATUS_TRUE ){

                if( $activity['killsec_time'] < date('Y-m-d H:i:s', strtotime('+10 minute')) ){
                    //已经超过订阅时间
                    $return['message'] = $this->lang->line('subscription_overtime');
                    
                } else {

                    $data= array(
                        'act_id'=> $actId,
                        'openid'=> $this->openid,
                        'inter_id'=> $activity['inter_id'],
                        'product_id'=> $activity['product_id'],
                        'product_name'=> $activity['product_name'],
                        'killsec_price'=> $activity['killsec_price'],
                        'killsec_time'=> $activity['killsec_time'],
                    );
                    $result = $this->activityKillsecModel->save_waiting_notice_list($activity['inter_id'], $data);
                    if($result){

                        $this->load->model('wx/Fans_model', 'fansModel');
                        $subscribeStatus = $this->fansModel->subscribeStatus($this->inter_id, $this->openid);

                        $return['status']= Soma_base::STATUS_TRUE;
                        $return['message']= $this->lang->line('subscription_success');

                        if (!$subscribeStatus) {
                            $return['message']= $this->lang->line('subscibe_follow_tip');
                            $qrcodeResult = WxService::getInstance()->getQrcode(WxService::QR_CODE_KILLSEC_SUBSCRIBE);

                            $return['data'] = '';
                            if ($qrcodeResult->getStatus() === \App\services\Result::STATUS_OK && $activity['is_subscribe'] == Activity_killsec_model::STATUS_TRUE) {
                                $return['data'] = $qrcodeResult->getData();
                            }
                        }
                    
                    } else {
                        $return['message']= $this->lang->line('subscription_fail');
                    }
                }
            }
        }
        $this->json($return);
    }


    /**
     * 获取秒杀资格
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function rob_ajax()
    {
        $instanceID = $this->input->post_get('inid');

        $result = KillsecService::getInstance()->getOpporunity($this->inter_id, $instanceID, $this->openid);

        $this->json($result->toArray());
    }

    //获取秒杀token
    public function get_killsec_token_ajax()
    {
        $return = array('status'=> Soma_base::STATUS_FALSE, 'data'=>array(), 'message'=> '活动尚未开始，你可以订阅提醒，活动开始前5-10分钟将提醒您' );
        $actId = $this->input->post_get('act_id');

        if($actId){
            $this->load->model('soma/Activity_killsec_model','activityKillsecModel');
            $instance= $this->activityKillsecModel->get_aviliable_instance( array('act_id'=>$actId ) );
            if(isset($instance[0]) ) $instance= $instance[0];

            //防止前端没有加载完，用户就点击秒杀购买按钮，穿透过来
            if( !$instance )
            {
                echo json_encode( $return ); exit;
            }

            if( isset($instance['status']) && $instance['status']==Activity_killsec_model::INSTANCE_STATUS_PREVIEW ){
                //token发放之前做提醒
                $return['message']= $this->lang->line('activity_not_begin_tip');
                if( $this->input->get('prev')=='t' ) {
                    $in_blacklist = $this->activityKillsecModel->set_redis_white_user($instance['instance_id'], $this->openid );
                }elseif( $this->input->get('prev')=='f' ) {
                    $in_blacklist = $this->activityKillsecModel->set_redis_white_user($instance['instance_id'], $this->openid, TRUE );
                }
                
            } elseif( isset($instance['instance_id']) && $instance['instance_id'] ){
                $instance_id = $instance['instance_id'];
                
                $now_time = date('Y-m-d H:i:s');
                if(strtotime($now_time) < strtotime($instance['start_time'])) {
                    $return['message']= $this->lang->line('activity_not_begin_tip');
                    echo json_encode( $return ); exit;
                }

                //检查是否处于黑名单
                $in_blacklist = $this->activityKillsecModel->get_redis_black_user($instance_id, $this->openid);
                    
                //检查是否已经购买过
                $join_data = $this->activityKillsecModel->get_redis_order_user($instance_id, $this->openid);
                
                if( $in_blacklist ){
                    $return['message'] = $this->lang->line('too_many_people_wait_tip');
                    
                } elseif( $join_data ){
                    $return['message'] = $this->lang->line('flash_sale_is_limit_tip');
                    
                } else {
                    //未成功购买过 开始-------------------
                    $token = $this->activityKillsecModel->get_redis_token($instance_id, $this->openid);
                    
                    if( $token ){
                        $return['data']= array(
                            'instance_id'=> $instance_id,
                        );
                        if($token== intval($token)){
                            $return['data']['token']= $token;
                    
                            $insert_user= array(
                                'instance_id'=> $instance_id,
                                'inter_id'=> $this->inter_id,
                                'business'=> 'package',
                                'token'=> $token,
                                'act_id'=> $actId,
                                'openid'=> $this->openid,
                                'join_time'=> date('Y-m-d H:i:s'),
                                'remote_ip'=> $this->input->ip_address(),
                                'status'=> Activity_killsec_model::USER_STATUS_JOIN,
                            );
                            $this->activityKillsecModel->save_instance_user($this->inter_id, $insert_user);
                    
                        } else {
                            //从缓存中得到token
                            $return['data']['token']= $token['token'];
                        }
                    
                        $return['status']= Soma_base::STATUS_TRUE;
                        //$return['message']= '还有机会，未支付订单将会逐步释放 。';
                        $return['message']= $this->lang->line('paying_and_release_tip');
                    
                    } else {
                        $return['message']= $this->lang->line('paying_and_release_tip');
                    }
                    //未成功购买过 结束-------------------
                }
                
            } else {
                $return['message']= $this->lang->line('flash_sale_end_tip');;
            }
            
        } else {
            $return['message']= $this->lang->line('parameter_error_tip');
        }
        echo json_encode( $return );
    }

    /**
     *  套票支付
     *  eg: index.php/soma/killsec/package_pay?id=a450089706&act_id=10337&pid=10029&instance_id=15&token=936930
     */
    public function package_pay()
    {
        $ticketId = '';
        if( $this->session->userdata('tkid') ) {
            $ticketId = $this->session->userdata('tkid');
        }

        //门票皮肤没有详情页，先默认为v1皮肤的。ticket有自己的header头
        $themeArr = array(
            'ticket',
            'zongzi',
            'mooncake4'
        );
        if( in_array( $this->theme, $themeArr ) || $ticketId )
        {
            $this->theme = 'v1';
        }

        $productId = intval($this->input->get('pid'));
        $act_id = intval($this->input->get('act_id'));
        $instance_id= $this->input->get('instance_id');
        $token= $this->input->get('token');

        $back_url= Soma_const_url::inst()->get_url('*/package/package_detail',
            array('id'=> $this->inter_id, 'pid'=> $productId)
        );
        
        if( !$productId || !$instance_id || !$act_id || !$token ){
            redirect($back_url);die;
        }

        $this->load->model('soma/Activity_killsec_model','activityKillsecModel');
        $this->load->model('soma/Product_package_model','productPackageModel');

        $killsec = $this->activityKillsecModel->find( array('act_id'=> $act_id, 'inter_id'=> $this->inter_id) );
        if( !$killsec ){
            redirect($back_url);die;
        }
        $productDetail = $this->productPackageModel->get_product_package_detail_by_product_id($killsec['product_id'],$this->inter_id);
        if( !$productDetail ){
            redirect($back_url);die;
        }

        $validResult = KillsecService::getInstance()->vaild($this->inter_id, $instance_id, $this->openid);
        if ($validResult->getStatus() === \App\services\Result::STATUS_FAIL) {
            redirect($back_url);die;
        }

        $userRow = $validResult->getData();

        $cache_hash = [
            'create_at' => $userRow['join_time'],
            'max_stock' => $userRow['max_stock']
        ];


//        $cache= $this->_load_cache();
//	    $redis= $cache->redis->redis_instance();
//        $cache_key= $this->activityKillsecModel->redis_token_key($instance_id, 'cache');
//        if( ! $redis->hExists($cache_key, $this->openid) ){
//            redirect($back_url);die;
//        }
//        $cache_hash= (array) json_decode($redis->hGet($cache_key, $this->openid));
//        if( !isset( $cache_hash['token']) || $token != $cache_hash['token'] ){
//            redirect($back_url);die;
//        }

        $header = array('title' => '购买支付');

        $productModel = $this->productPackageModel;

        if( $productDetail['date_type'] == $productModel::DATE_TYPE_STATIC ){
            $time = time();
            $expireTime = isset( $productDetail['expiration_date'] ) ? strtotime( $productDetail['expiration_date'] ) : NULL;
            if( $expireTime && $expireTime < $time ){
                redirect($back_url);die;
            }
        }
        $this->datas['killsec']= $killsec;
        $this->datas['is_expire']= false;

        //点击分享之后开启这些按钮
        $js_menu_show = array( 'menuItem:share:appMessage', 'menuItem:share:timeline' );
        $uparams= $this->input->get()+ array('id'=> $this->inter_id);

        //取出分享配置 
        $this->load->model( 'soma/Share_config_model', 'ShareConfigModel' );
        $ShareConfigModel = $this->ShareConfigModel;
        $position = $ShareConfigModel::POSITION_DEFAULT;//分享类型
        $share_config_detail = $ShareConfigModel->get_share_config_list( $position, $this->inter_id );
        $share_config = array(
            'title'=> isset( $share_config_detail['share_title'] ) && !empty( $share_config_detail['share_title'] ) ? $share_config_detail['share_title'] : '发现一家好去处，快点开看看',
            'desc'=> isset( $share_config_detail['share_desc'] ) && !empty( $share_config_detail['share_desc'] ) ? $share_config_detail['share_desc'] : '优惠不等人',
            'link'=> Soma_const_url::inst()->get_share_url( $this->openid, '*/package/package_detail', $uparams ),
            'imgUrl'=> isset( $share_config_detail['share_img'] ) && !empty( $share_config_detail['share_img'] ) ? $share_config_detail['share_img'] : base_url('public/soma/images/sharing_package.png'),
        );

        //取出联系人和电话
        $filter = array();
        $filter['openid'] = $this->openid;
        $customer_info = $this->productPackageModel->get_customer_contact( $filter );
        $this->datas['customer_info']= $customer_info;


        // 储值类型商品读取购买人的储值信息
        $this->datas['balance'] = null;
        if($productDetail['type'] 
            && $productDetail['type'] == Product_package_model::PRODUCT_TYPE_BALANCE) {
            $this->load->library('Soma/Api_member');
            $api= new Api_member($this->inter_id);
            $result = $api->get_token();
            $result['data'] = isset($result['data']) ? $result['data']:array();
            $api->set_token($result['data']);
            $balance = $api->balence_info($this->openid);
            $balance['data'] = isset($balance['data']) ? $balance['data']:0;
            $this->datas['balance'] = $balance['data'];
            $this->datas['balance_url'] = $api->balence_deposit_url($this->inter_id);
        }

        $this->datas['show_balance_passwd'] = Soma_base::STATUS_FALSE;
        $balance_inter_ids = array('a457946152', 'a471258436','a450089706');
        if(in_array($this->inter_id, $balance_inter_ids)) {
          $this->datas['show_balance_passwd'] = Soma_base::STATUS_TRUE;
        }

        /**
         * 邮寄
         */
        $defaultAddress = array();
        if( isset($productDetail['can_mail']) &&  $productDetail['can_mail'] == Product_package_model::CAN_T){
            $userAddressList = ExpressService::getInstance()->getUserAddressList($this->openid,$this->inter_id,100);
            if(!empty($userAddressList))
                $defaultAddress = $userAddressList[0];

            $userAddress = json_encode($userAddressList);
        }else{
            $userAddress = "null";
        }
        $this->datas['userAddress'] = $userAddress;
        $this->datas['defaultAddress'] = $defaultAddress;


        $this->datas['packageModel'] =  $this->productPackageModel;
        $this->datas['package'] = $productDetail;
        $this->datas['cache_hash'] = $cache_hash;
        $this->datas['js_menu_show']= $js_menu_show;
        $this->datas['js_share_config']= $share_config;

/** 检测 自己saler_id ********************************/
        $this->datas = $this->getDistribute( $this->datas );
/**  ***********************/
        
        $this->_view("header",$header);
        $this->_view("killsec_pay",$this->datas);
    }

    /**
     *
     * 抢尾房活动
     * @author renshuai  <renshuai@mofly.cn>
     *
     */
    public function group()
    {
        $serviceName = $this->serviceName(Kill_Service::class);
        $serviceAlias = $this->serviceAlias(Kill_Service::class);
        $this->load->service($serviceName, null, $serviceAlias);


        $group = $this->soma_kill_service->groupOnly($this->current_inter_id);
        if (empty($group)) {
            redirect('/notfound', 'get', 404);
        }


        $times = $this->soma_kill_service->groupTimes($group);

        $currentTime = time();

        //wechat config
        $js_menu_show = array('menuItem:share:appMessage', 'menuItem:share:timeline', 'menuItem:copyUrl');
        if ($currentTime > $times['show_time']  && $currentTime < $times['end_time']) {

            $data = $this->soma_kill_service->groupMain($this->current_inter_id);

            $data['js_menu_show'] = $js_menu_show;

            //wechat share info
            $share_config = array(
                'title' => isset($data['group']['share_info']) ? $data['group']['share_info']['title'] : '',
                'desc' => isset($data['group']['share_info']) ? $data['group']['share_info']['desc'] : '',
                'link' => current_url() . '?id=' . $this->current_inter_id,
                'imgUrl' => isset($data['group']['share_info']) ? $data['group']['share_info']['img'] : '',
            );
            $data['js_share_config'] = $share_config;

            $data['times'] = $times;

            $this->_view("killsec_group_main", $data);

        } elseif ($currentTime > date_create($group['end_time'])->getTimestamp() ) {  //活动结束
            $this->_view("killsec_group_end");
        } elseif (date('Y-m-d') == date_create($group['end_time'])->format('Y-m-d') && $currentTime > $times['end_time'] ) {
            $this->_view("killsec_group_end");
        }else {

            //wechat share info
            $share_config = array(
                'title' => isset($group['share_info']) ? $group['share_info']['title'] : '',
                'desc' => isset($group['share_info']) ? $group['share_info']['desc'] : '',
                'link' => current_url() . '?id=' . $this->current_inter_id,
                'imgUrl' => isset($group['share_info']) ? $group['share_info']['img'] : '',
            );

            $group['js_share_config'] = $share_config;
            $group['js_menu_show'] = $js_menu_show;
            $group['times'] = $times;

            $this->_view("killsec_group", $group);
        }
    }

    /**
     * 通过产品ID获得秒杀活动ID
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function product()
    {
        $productId = intval($this->input->post('pid'));

        $this->load->library('form_validation');

        $rules = array(
            'product_id' => array(
                'field' => 'product_id',
                'rules' => 'is_natural_no_zero'
            ),
        );
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_data(
            array(
                'product_id' => $productId
            )
        );

        $serviceName = $this->serviceName(Kill_Service::class);
        $serviceAlias = $this->serviceAlias(Kill_Service::class);
        $this->load->service($serviceName, null, $serviceAlias);

        $return= array('status'=>Soma_base::STATUS_TRUE, 'act_id'=> '' );

        if ($this->form_validation->run() == FALSE) {
            $return['status'] = Soma_base::STATUS_FALSE;
            $return['message'] = '活动未开始或已结束';
        } else {
            $killsec = $this->soma_kill_service->getKillsecOfProduct($productId, $this->inter_id);
            $return['act_id'] = !empty($killsec) ? $killsec['act_id'] : 0;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($return));

    }
    
    #  以下为测试方法    ######################################################
    
    public function index()
    {
        $instance_id= 11;
        $count= 10;
	    $key= "SOMA_KILLSEC_TOKEN_{$instance_id}";
        $cache= $this->_load_cache();
        
        $cache->redis->select_db(2);
        $redis= $cache->redis->redis_instance();
        
        $this->load->helper('soma/math');
        $token_array= gen_unique_rand(100000, 999999, $count);
        
        foreach ($token_array as $k=>$v){
            $redis->lPush($key, $v );
        }
        $redis->expireAt($key, time()+ 3600);
        
    }
}