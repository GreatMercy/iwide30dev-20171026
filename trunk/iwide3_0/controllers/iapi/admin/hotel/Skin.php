<?php

use App\libraries\Iapi\BaseConst;
use App\services\hotel\SkinService;

defined('BASEPATH') or exit ('No direct script access allowed');

class Skin extends MY_Admin_Iapi
{
    protected $label_module = NAV_HOTEL;
    protected $label_controller = '商品管理';
    protected $label_action = '';

    function __construct()
    {
        parent::__construct();
        $this->inter_id = $this->session->get_admin_inter_id();
        $this->module = 'hotel';
        $this->common_data ['csrf_token'] = $this->security->get_csrf_token_name();
        $this->common_data ['csrf_value'] = $this->security->get_csrf_hash();
    }

    protected function main_model_name()
    {
        return 'hotel/goods/Goods_info_model';
    }

    /**
     * 皮肤管理首页
     * @author daikanwu <daikanwu@jperation.com>
     */
    public function index()
    {
        $this->load->model('common/Skins_model');

        $sel_skin = [];

        //拉取选中的皮肤和所有皮肤
        $selected_skin = $this->Skins_model->get_skin_set($this->inter_id, $this->module);
        $hotel_skins = $this->Skins_model->get_skins($this->module, 'skin_id,intro_img,skin_name,skin_title');

        foreach ($hotel_skins as $k => $v) {
            $skin_name = isset($selected_skin['skin_name']) ? $selected_skin['skin_name'] : 'default2';
            if ($v['skin_name'] == $skin_name) {
                $sel_skin = [
                    'id' => isset($selected_skin['id']) ? $selected_skin['id'] : 0,
                    'skin_name' => $skin_name,
                    'skin_title' => $v['skin_title'],
                    'img_url' => $v['intro_img']
                ];
                unset($hotel_skins[$k]);
            }
        }

        //二维码
        $this->load->helper('phpqrcode');
        $this->load->model('wx/Publics_model');
        $public = $this->Publics_model->get_public_by_id($this->inter_id, 'inter_id', 0);

        $url = empty($public['domain']) ? '' : 'http://' . $public['domain'] . '/index.php/hotel/hotel/search?id=' . $this->inter_id;
        if (!is_dir('public/qrcode/skin')) {
            mkdir('public/qrcode/skin');
        }
        $file_path = 'public/qrcode/skin/' . $this->inter_id . '.png';
        QRcode::png($url, $file_path, 'L', 6, 2);

//        ob_start();
//        QRcode::png($url,null);
//        $code = base64_encode(ob_get_contents());
//        ob_end_clean();

        $res = [
            'selected_skin' => $sel_skin,
            'hotel_skins' => $hotel_skins,
            'code' => $file_path
        ];

        $this->out_put_msg(BaseConst::OPER_STATUS_SUCCESS, '', $res);

    }

    /**
     * 选择某个皮肤
     * $POST['skin_name']
     * @author daikanwu <daikanwu@jperation.com>
     */
    public function save_skin()
    {
        $post = $this->get_source();

        if (empty($post['skin_name'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '皮肤必选');
        }

        if (empty($post['skin_id'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, 'skin_id必填');
        }

//        $post = [
//            'id' => 17,
//            'skin_id' => 3,
//            'skin_name' => 'su8'
//        ];

        $this->load->model('common/Skins_model');
//
//        $skin_set = $this->Skins_model->get_skin_set($this->inter_id, $this->module);
//        if (empty($skin_set)) {
//            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '皮肤设置为空');
//        }
        $set = [
            'skin_id' => $post['skin_id'],
            'skin_name' => $post['skin_name']
        ];

        $this->Skins_model->update_skin_set($this->inter_id, 'hotel', $post['id'], $set);
        $this->out_put_msg(BaseConst::OPER_STATUS_SUCCESS, '');
    }

    /**
     * 获取皮肤的配置详情
     * 前端数据格式
     * $_GET['skin_name'] = '';
     * @author daikanwu <daikanwu@jperation.com>
     */
    public function get_setting()
    {
        //校验皮肤是不是默认皮肤
        $skin_name = $this->input->get('skin_name');
        if (empty($skin_name)) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '皮肤名称必填');
        }

        $this->load->model('hotel/Views_model');
        $model = $this->Views_model;
        if ($skin_name != $model::DEFAULT_SKIN) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '只有默认皮肤才支持首页设置');
        }

        $res = SkinService::getInstance()->get_setting();
        $this->out_put_msg(BaseConst::OPER_STATUS_SUCCESS, '', $res);
    }

    /**
     * todo 待跟前端确认接口格式
     * 交换轮播图的顺序
     * 前端数据格式 POST请求
     * [
     *  't' => 1
     *  ['id' => 1, 'sort' => 2],
     *  ['id' => 2, 'sort' => 3],
     * ]
     *  t= 1向下 2向上
     * @author daikanwu <daikanwu@jperation.com>
     */
    public function exchange_position()
    {
        $post = $this->get_source();

        //获取顺序最小的和最大的
        $this->load->model('wx/Publics_model');
        $roast = $this->Publics_model->get_pub_imgs($this->inter_id, 'hotelslide');
        if (empty($roast)) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '轮播图设置为空');
        }
        $first = $roast[0];
        $end = end($roast);

        if ($post['t'] == 1) {

        } else {

        }

    }

    /**
     * 保存皮肤的设置
     * 前端数据格式
     *
     * [
     *  'share_setting' => array('id' => '', 'page_title' => '', 'page_desc' => '', 'share_icon' => ''),
     *  'roasting_setting' => array(['id'=> 1, 'link'=> '', 'img_url' => 'xxx', sort=>'1'])
     *  'font_setting' => ['font_color'=> '', 'font_size'=>11],
     *   'home_setting' => [
     *     'id'=> '1997',
     *     'home_disp'=>'new',
     *     'logo'=> 'xxxxx',
     *     'menu'=>[
     *     1=>['code' => 'always', 'desc' => '描述1'],
     *     2=>['code' => 'collect', 'desc' => '描述2'],
     *     3=>['code' => 'order', 'desc' => '描述3'],
     * ]]
     * home_disp 简约版传ori 标准版传new
     * 如果轮播是新增的话 id传0
     * )
     * @author daikanwu <daikanwu@jperation.com>
     */
    public function save_setting()
    {
        //校验参数
        $post = $this->get_source();

//        $post = [
//            'share_setting' => array('id' => '1996', 'page_title' => 'title', 'page_desc' => '测试', 'share_icon' => 'icon'),
//            'roasting_setting' => array(['id'=> 77, 'link'=> 'xxxx', 'image_url' => 'www.baidu.com', 'sort'=>'5'],
//                ['id'=> 78, 'link'=> 'yyy', 'image_url' => 'www.google.com', 'sort'=>'4'],
//                ['id'=> 0, 'link'=> 'zz', 'image_url' => 'www.google.com2', 'sort'=>'3'],
//                ['id'=> 0, 'link'=> 'yzabc', 'image_url' => 'www.google.com2', 'sort'=>'2'],
//                ['id'=> 0, 'link'=> 'wowowo', 'image_url' => 'www.google.com3', 'sort'=>'4'],
//                ),
//            'font_setting' => ['font_color'=> '#999999', 'font_size'=>11],
//            'home_setting' => [
//            'id'=> '1',
//            'home_disp'=>'new',
//            'logo'=> 'logo',
//            'menu'=>
//                [
//                  1=>['code' => 'always', 'desc' => '描述1111'],
//                  2=>['code' => 'collect', 'desc' => '描述2222'],
//                  3=>['code' => 'order', 'desc' => '描述3333'],
//                ]
//            ]
//        ];
        if (empty($post['share_setting']['page_title'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '页面标题必填');
        }

        if (empty($post['share_setting']['page_desc'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '页面描述必填');
        }

        if (empty($post['share_setting']['share_icon'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '分享图标必填');
        }

        if (empty($post['home_setting']['logo'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '页面logo必填');
        }

        foreach ($post['roasting_setting'] as $v) {
            if (empty($v['image_url'])) {
                $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '轮播图图片必填');
            }
        }

        if (empty($post['font_setting']['font_color'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '字体颜色必填');
        }

        if (empty($post['font_setting']['font_size'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '字体大小必填');
        }

        $this->load->model('common/Skins_model');
        $model = $this->_load_model('hotel/Views_model');

        //校验皮肤是不是默认皮肤
        $skin_set = $this->Skins_model->get_skin_set($this->inter_id, $this->module);
        if (!empty ($skin_set)) {
            if ($skin_set ['skin_name'] != $model::DEFAULT_SKIN) {
                $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '只有默认皮肤才支持首页设置');
            }
        }
        $post['skin_name'] = $model::DEFAULT_SKIN;

        if (!SkinService::getInstance()->save_setting($post)) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '保存失败');
        }

        $this->out_put_msg(BaseConst::OPER_STATUS_SUCCESS, '');

    }

    /**
     * 删除轮播图
     * $_POST['id']
     * status 更新成 2
     * @author daikanwu <daikanwu@jperation.com>
     */
    public function del_focus()
    {
        $post = $this->get_source();
//        $post['id'] = 89;
        if (empty($post['id'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, 'id必填');
        }

        //校验状态是不是删除
        $focus = $this->Publics_model->get_pub_img_by_id($post['id']);
        if (empty($focus)) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '该轮播图不存在');
        }
        if ($focus['status'] == 2) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '该轮播图不可编辑');
        }


        $this->load->model('wx/Publics_model');
        $this->Publics_model->del_focus_new($post);

        $this->out_put_msg(BaseConst::OPER_STATUS_SUCCESS, '');
    }

    /**
     * 更新轮播图
     * ['id'=>1, 'image_url'=>'', 'link'=>'']
     * @author daikanwu <daikanwu@jperation.com>
     */
    public function update_focus()
    {
        $post = $this->get_source();
//        $post = [
//            'id' => 89,
//            'image_url' => 'go.com',
//            'link' => 'wwww.youyou.com'
//        ];
        if (empty($post['id'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, 'id必填');
        }
        if (empty($post['image_url'])) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, 'image_url必填');
        }

        $this->load->model('wx/Publics_model');

        //校验状态是不是删除
        $focus = $this->Publics_model->get_pub_img_by_id($post['id']);
        if (empty($focus)) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '该轮播图不存在');
        }
        if ($focus['status'] == 2) {
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST, '该轮播图不可编辑');
        }

        $this->Publics_model->update_focus_new($post);

        $this->out_put_msg(BaseConst::OPER_STATUS_SUCCESS, '');

    }

}