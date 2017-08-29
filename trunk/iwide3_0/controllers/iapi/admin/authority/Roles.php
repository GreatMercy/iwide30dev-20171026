<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Roles extends MY_Admin_Iapi {
    protected $label_module = NAV_HOTEL;
    protected $label_controller = '交易订单';
    protected $label_action = '';
    function __construct() {
        parent::__construct ();
        $this->inter_id = $this->session->get_admin_inter_id ();
        $this->module = 'hotel';
        $this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
        $this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
        // $this->output->enable_profiler ( true );
    }
    protected function main_model_name() {
        return 'hotel/order_model';
    }


    public function rolesList(){    //角色列表

        $data = $this->common_data;
        $this->load->model("authority/Roles_model");

        $get = $this->input->get();
        $inter_id = $this->inter_id;
        $account = $this->session->userdata();  //账号信息

        if(isset($account['admin_profile']['type'])){
            $params['type'] = $account['admin_profile']['type'];
            if($params['type']==1)$inter_id = 'fullaccess';
        }


        $params=array();
        if(isset($get['pages']) && isset($get['size'])){
            $params['offset'] = ($get['pages']-1)*$get['size'];
            $params['size'] = $get['size'];
        }

        if(isset($get['keyword']) && !empty($get['keyword'])){
            $params['keyword'] = addslashes($get['keyword']);
            $total = $this->Roles_model->count_roles($inter_id,$params['keyword']);
        }else{
            $total = $this->Roles_model->count_roles($inter_id);
        }



        $data['roles_type'] = $this->Roles_model->roles_type();
        $data['roles'] = $this->Roles_model->all_roles($inter_id,$params);

        $data['total'] = $total['total'];
        $data['link'] = site_url('authority/roles/add_role');

        $this->out_put_msg(1,'',$data,'authority/roles/roles_list',200,$params);


    }


    public function edit_role(){   //角色编辑

        $data = $this->common_data;
        $inter_id = $this->inter_id;
        $this->load->model("authority/Roles_model");
        $this->load->library ( 'authority/authorityConst' );//权限系统常量
        $this->load->model('authority/Module_func_model');
        $user = $this->session->userdata();

        $edit_role_id = $this->input->get('role_id');
        $data['edit_role'] = array();

        if(!empty($edit_role_id)){
            $data['edit_role'] = $this->Roles_model->getRoleById($inter_id,$edit_role_id);
        }

$user['admin_profile']['type'] = 2;
        if($user['admin_profile']['type'] ==2){
            //获取可以管理的公众号
            $this->load->model('wx/Publics_model');
            $this->load->model('authority/accounts_entities_model');
            $array_inter_id = $this->accounts_entities_model-> accountEntities(array('admin_id' => $user['admin_profile']['admin_id']));
            if(!empty($array_inter_id)){
                foreach($array_inter_id as $temp_inter_id){
                    $data['arr_inter_id'][]=array(
                        'inter_id' => $temp_inter_id['inter_id'],
                        'inter_name' => $temp_inter_id['inter_name']
                    );
                }
            }else{
                $public = $this->Publics_model->get_public_by_id($user['admin_profile']['inter_id']);
                $data['arr_inter_id'][]=array(
                    'inter_id' => $user['admin_profile']['inter_id'],
                    'inter_name' => $public['name']
                );
            }
            //所有标准角色
            $standard_roles = $this->Roles_model->standard_roles(1);
            $data['standard_roles'] = array();
            if(!empty($standard_roles)){
                foreach($standard_roles as $temp_standard_roles){
                    $data['standard_roles'][$temp_standard_roles['role_id']] = array(
                        'role_id' => $temp_standard_roles['role_id'],
                        'role_name' => $temp_standard_roles['role_name']
                    );
                }
            }

        }

        $data['admin_type'] = $user['admin_profile']['type'];
        $this->out_put_msg(1,'',$data,'authority/roles/edit_role',200);

    }


    public function edit_authorities(){

        $data = $this->common_data;
        $inter_id = $this->inter_id;
        $this->load->model("authority/Roles_model");
        $this->load->model('authority/Module_func_model');
        $this->load->library ( 'authority/authorityConst' );//权限系统常量
        $user = $this->session->userdata();

        $related_role_id = $this->input->get('related_role_id');
        $edit_role_id = $this->input->get('role_id');


$user['admin_profile']['role']['role_id']=1;
        $myrole = $this->Roles_model->getRoleById($inter_id,$user['admin_profile']['role']['role_id']);
//        $authorities = unserialize($myrole['role_authority']);


$user['admin_profile']['type'] = 2;
//        $all_authorities = $this->Roles_model->get_all_authorities();
        $all_authorities=$this->Module_func_model->getAccountFuncList($user['admin_profile']['type'],$myrole['role_type'],'DISP');//1.系统管理员，2.公众号管理员，3.普通账号


        //获取当前编辑角色权限
        $edit_role = array();
        $edit_role_authorities = array();
        $extra_authorities = array();
        if(!empty($edit_role_id)){
            $edit_role = $this->Roles_model->getRoleById($inter_id,$edit_role_id);
            if(isset($edit_role['related_role_id']) && !empty($edit_role['related_role_id'])){
                //有关联角色的还要检查关联后改动的权限
                if(empty($related_role_id))$related_role_id = $edit_role['related_role_id'];
                $related_role = $this->Roles_model->getRoleById('fullaccess',$related_role_id);
                $related_authorities = !empty($related_role['role_authority'])?unserialize($related_role['role_authority']):array();
                if(isset($edit_role['extra_authorities']) && !empty($edit_role['extra_authorities'])){
                    $edit_role_authorities = $this->Roles_model->defined_authorities($related_authorities,$edit_role['extra_authorities']);
                }else{
                    $edit_role_authorities = $related_authorities;
                }
            }else{
                //没有关联角色的直接读取权限
                $edit_role_authorities = !empty($edit_role['role_authority'])?unserialize($edit_role['role_authority']):array();
            }
        }



        $data['role_authorities'] = $this->Roles_model->compare_authorities($all_authorities,$edit_role_authorities);

        if(!empty($data['role_authorities'])){   //格式转换
            $temp_auth = array();
            foreach($data['role_authorities'] as $m_key => $temp_module){
                $t_c = array();
                $temp['module'] = $m_key;
                $temp['name'] = $temp_module['name'];
                $temp['des'] = $temp_module['des'];
                $temp['check'] = $temp_module['check'];
                $temp['all_private'] = 2;
                if(isset($temp_module['all_private']))$temp['all_private'] = $temp_module['all_private'];
                $temp['controllers']=array();
                if(!empty($temp_module['controllers'])){
                    $tc = array();
                    foreach($temp_module['controllers'] as $c_key => $temp_ctrl){
                        $t_c = array();
                        $t_c['ctrl_id'] = $c_key;
                        $t_c['name'] = $temp_ctrl['name'];
                        $t_c['des'] = $temp_ctrl['des'];
                        $t_c['check'] = $temp_ctrl['check'];
                        $t_c['all_private'] = 2;
                        if(isset($temp_ctrl['all_private']))$t_c['all_private'] = $temp_ctrl['all_private'];
                        $t_c['funcs'] = array();
                        if(!empty($temp_ctrl['funcs'])){
                            $tf = array();
                            foreach($temp_ctrl['funcs'] as $f_key => $temp_func){
                                $t_f = array();
                                $t_f['ctrl_id'] = $f_key;
                                $t_f['name'] = $temp_func['name'];
                                $t_f['des'] = $temp_func['des'];
                                $t_f['check'] = $temp_func['check'];
                                $t_f['operations'] = array();
                                if(!empty($temp_func['operations'])){
                                    $to = array();
                                    foreach($temp_func['operations'] as $o_key => $temp_oper){
                                        $t_o = array();
                                        $t_o['oper_id'] = $f_key;
                                        $t_o['name'] = $temp_oper['name'];
                                        $t_o['des'] = $temp_oper['des'];
                                        $t_o['check'] = $temp_oper['check'];
                                        $to[] = $t_o;
                                    }
                                    $t_f['operations'] = $to;
                                }
                                $tf[] = $t_f;
                            }
                            $t_c['funcs'] = $tf;
                        }
                        $tc[] = $t_c;
                    }
                    $temp['controllers']=$tc;
                }
                $temp_auth[] = $temp;
            }
            $data['role_authorities'] = $temp_auth;
        }

        $data['link'] = site_url('authority/roles/role_list');

        $this->out_put_msg(1,'',$data,'authority/roles/edit_authorities',200);

    }



    public function edit_role_post(){

        $data = $this->common_data;
        $this->load->model("authority/Roles_model");
        $this->load->helper('array');

        $inter_id = $this->inter_id;

        $info = array(
            'status' => 2,
            'message' => '编辑失败'
        );

        $temp_data = json_decode($this->input->raw_input_stream,true);

        $account =$this->session->userdata();
        $post_data['creator'] = $account['admin_profile']['admin_id'];

        $post_data['role_type'] = isset($temp_data['role_type'])?$temp_data['role_type']:'';
        $post_data['role_name'] = isset($temp_data['role_name'])?$temp_data['role_name']:'';
        $post_data['status'] = isset($temp_data['status'])?$temp_data['status']:1;
        $temp_post_data['role_authority'] = isset($temp_data['role_authority'])?$temp_data['role_authority']:'';
        $post_data['related_role_id'] = isset($temp_data['related_role_id'])?intval($temp_data['related_role_id']):'';

        if($post_data['role_type']!=1){
            $post_inter_id = isset($temp_data['inter_id'])?$temp_data['inter_id']:'';
        }else{
            $post_inter_id = 'fullaccess';
        }


        $role_id = isset($temp_data['role_id'])?$temp_data['role_id']:'';


        if(empty($post_data['role_type']) || empty($post_data['role_name']) || empty($post_data['status'])){
            $info['message'] = '缺少参数';
            $data['return_info'] = $info;
            $this->out_put_msg(1,'',$data,'authority/roles/edit_role_post',200);
            return;
        }

        if(!empty($post_inter_id)){
            $inter_id = $post_inter_id;
        }


//$post_data['role_authority'] = '[{"name":"modules[]","value":"app"},{"name":"modules[]","value":"club"},{"name":"controllers_app[]","value":"2"},{"name":"controllers_app[]","value":"1"},{"name":"controllers_club[]","value":"96"},{"name":"controllers_club[]","value":"97"},{"name":"controllers_club[]","value":"98"},{"name":"funcs_96[]","value":"586"},{"name":"funcs_96[]","value":"587"},{"name":"funcs_96[]","value":"588"},{"name":"funcs_97[]","value":"590"},{"name":"funcs_97[]","value":"595"},{"name":"funcs_97[]","value":"596"},{"name":"funcs_97[]","value":"599"},{"name":"funcs_97[]","value":"603"},{"name":"funcs_98[]","value":"604"},{"name":"funcs_98[]","value":"605"},{"name":"funcs_98[]","value":"607"},{"name":"funcs_98[]","value":"608"},{"name":"funcs_98[]","value":"612"}]';

        if(!empty($temp_post_data['role_authority'])){
            $post_authorities=jqjson2arr($temp_post_data['role_authority']);
            $authorities = array();
            if(!empty($post_authorities['modules'])){
                foreach($post_authorities['modules'] as $temp_modules){
                    if(!isset($authorities[$temp_modules]))$authorities[$temp_modules] = array();
                    $authorities[$temp_modules]['all_private'] = (!empty($post_authorities['modules_all']) && in_array($temp_modules,$post_authorities['modules_all']))?1:2;
                    if(!empty($post_authorities['controllers_'.$temp_modules])){
                        foreach($post_authorities['controllers_'.$temp_modules] as $temp_controllers){
                            if(!isset($authorities[$temp_modules]['controllers'][$temp_controllers]))$authorities[$temp_modules]['controllers'][$temp_controllers] = array();
                            $authorities[$temp_modules]['controllers'][$temp_controllers]['all_private'] = (isset($post_authorities['controllers_all'][$temp_modules]) && in_array($temp_controllers,$post_authorities['controllers_all'][$temp_modules]))?1:2;
                            if(!empty($post_authorities['funcs_'.$temp_controllers])){
                                foreach($post_authorities['funcs_'.$temp_controllers] as $temp_funcs){
                                    if(!isset($authorities[$temp_modules]['controllers'][$temp_controllers]['funcs'][$temp_funcs]))$authorities[$temp_modules]['controllers'][$temp_controllers]['funcs'][$temp_funcs] = array();
                                    if(!empty($post_authorities['operations_'.$temp_funcs])){
                                        foreach($post_authorities['operations_'.$temp_funcs] as $temp_operations){
                                            $authorities[$temp_modules]['controllers'][$temp_controllers]['funcs'][$temp_funcs][] = $temp_operations;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            print_r($authorities);
            if(empty($post_data['related_role_id'])){
                $post_data['role_authority'] = $authorities;
            }else{
                $related_role = $this->Roles_model->getRoleById('fullaccess',$post_data['related_role_id']);

            }
            print_r(unserialize($related_role['role_authority']));exit;
        }


        if(!empty($role_id)){
            $params = array(
                'role_id'=>$role_id,
                'inter_id'=>$inter_id
            );
            $result = $this->Roles_model->update_role($params,$post_data);
        }else{
            $result = $this->Roles_model->new_role($inter_id,$post_data);
        }

        if($result){

            $info['data'] = $post_data;

//            $this->load->library('MYLOG');
//            MYLOG::w ( $log_datas, 'hotel'.DS.'admin_log' . DS . $log_dir );
//            MYLOG::w('send_content:'.json_encode($params).'||'.'receive_content:'.json_encode($s).'||'.'record_time:'.$now.'||'.'inter_id:'.$inter_id.'||'.'service_type:youcheng'.'||'.'web_path:'.$url.'||'.'wait_time:'.$wait_time,'pms_log');

            $info['status'] = 1;
            $info['message'] = '编辑成功';
        }

        $data['return_info'] = $info;
        $this->out_put_msg(1,'',$data,'authority/roles/edit_role_post',200);



    }

    public function modules_list(){    //模块列表

        $data = $this->common_data;
        $this->load->model("authority/Roles_model");

        $data['modules'] = $this->Roles_model->all_modules();

        $data['link'] = site_url('authority/roles/authority_list');

        $this->out_put_msg(1,'',$data,'authority/roles/modules_list',200);

    }


    public function authorities_list(){   //权限列表

        $data = $this->common_data;
        $this->load->model("authority/Roles_model");
        $module_code = $this->input->get('module_code');

        $authorities=$this->Roles_model->get_all_authorities();

        $data['authorities'] = isset($authorities[$module_code])?$authorities[$module_code]:array();

        $data['link'] = site_url('authority/roles/authority_list');

        $this->out_put_msg(1,'',$data,'authority/roles/authorities_list',200);

    }


    public function edit_ctrl_post(){    //提交编辑控制器

        $data = $this->common_data;
        $this->load->model("authority/Roles_model");
        $post = json_decode($this->input->raw_input_stream,true);
        $ctrl_id = isset($post['ctlr_id'])?$post['ctlr_id']:'';
        $post_data = array();

        $post_data['module']=  isset($post['module_code'])?$post['module_code']:'';
        $post_data['ctlr_code']=  isset($post['ctlr_code'])?$post['ctlr_code']:'';
        $post_data['ctlr_name']=  isset($post['ctlr_name'])?$post['ctlr_name']:'';
        $post_data['ctlr_des']= isset($post['ctlr_des'])?$post['ctlr_des']:'';
        $post_data['ctlr_state']=  isset($post['ctlr_state'])?$post['ctlr_state']:'';
//        $post_data['account_range']=  $this->input->post('account_range');


        $info = array(
            'status'=>2,
            'message'=>'提交失败'
        );

        if(empty($post_data['module']) || empty($post_data['ctlr_code']) || empty($post_data['ctlr_name'])){
            $info['message'] = '缺少参数';
        }else{

            $check = $this->Roles_model->check_controllers($post_data['ctlr_code'],$post_data['module'],$ctrl_id);
            if(empty($check)){
                if(!empty($ctrl_id)){
                    $res = $this->Roles_model->edit_controllers($ctrl_id,$post_data);
                }else{
                    $res = $this->Roles_model->new_controllers($post_data);
                }

                if($res){
                    $info['status']=1;
                    $info['message']='提交成功';
                }
            }else{
                $info['message']='数据重复';
            }
        }

        $data['return_info'] = $info;

        $this->out_put_msg(1,'',$data,'authority/roles/edit_ctrl_post',200);

    }


    public function edit_func_post(){    //提交编辑功能

        $data = $this->common_data;
        $this->load->model("authority/Roles_model");
        $post = json_decode($this->input->raw_input_stream,true);
        $func_id = isset($post['func_id'])?$post['func_id']:'';
        $post_data = array();

        $post_data['ctlr_id']=  isset($post['ctlr_id'])?$post['ctlr_id']:'';
        $post_data['func_code']=  isset($post['func_code'])?$post['func_code']:'';
        $post_data['func_name']=  isset($post['func_name'])?$post['func_name']:'';
        $post_data['func_des']=  isset($post['func_des'])?$post['func_des']:'';
        $post_data['func_state']=  isset($post['func_state'])?$post['func_state']:'';
        $post_data['account_range']=  isset($post['account_range'])?$post['account_range']:'';

        $info = array(
            'status'=>2,
            'message'=>'提交失败'
        );

        if(empty($post_data['ctlr_id']) || empty($post_data['func_code']) || empty($post_data['func_name'])){
            $info['message'] = '缺少参数';
        }else{
            $check = $this->Roles_model->check_funcs($post_data['func_code'],$post_data['ctlr_id'],$func_id);
            if(empty($check)){
                if(!empty($func_id)){
                    $res = $this->Roles_model->edit_function($func_id,$post_data);
                }else{
                    $res = $this->Roles_model->new_function($post_data);
                }

                if($res){
                    $info['status']=1;
                    $info['message']='提交成功';
                }
            }else{
                $info['message']='数据重复';
            }
        }

        $data['return_info'] = $info;

        $this->out_put_msg(1,'',$data,'authority/roles/edit_func_post',200);


    }


    public function edit_operate_post(){  //提交编辑操作

        $data = $this->common_data;
        $this->load->model("authority/Roles_model");
        $post = json_decode($this->input->raw_input_stream,true);
        $oper_id = isset($post['oper_id'])?$post['oper_id']:'';
        $post_data = array();

        $post_data['func_id']=  isset($post['func_id'])?$post['func_id']:'';
        $post_data['oper_code']=  isset($post['oper_code'])?$post['oper_code']:'';
        $post_data['oper_name']=  isset($post['oper_name'])?$post['oper_name']:'';
        $post_data['oper_des']=  isset($post['oper_des'])?$post['oper_des']:'';
        $post_data['oper_state']=  isset($post['oper_state'])?$post['oper_state']:'';

        $info = array(
            'status'=>2,
            'message'=>'提交失败'
        );

        if(empty($post_data['func_id']) || empty($post_data['oper_code']) || empty($post_data['oper_name'])){
            $info['message'] = '缺少参数';
        }else{
            $check = $this->Roles_model->check_operations($post_data['oper_code'],$post_data['func_id'],$oper_id);
            if(empty($check)){
                if(!empty($oper_id)){
                    $res = $this->Roles_model->edit_operation($oper_id,$post_data);
                }else{
                    $res = $this->Roles_model->new_operation($post_data);
                }

                if($res){
                    $info['status']=1;
                    $info['message']='提交成功';
                }
            }else{
                $info['message']='数据重复';
            }
        }


        $data['return_info'] = $info;

        $this->out_put_msg(1,'',$data,'authority/roles/edit_oper_post',200);


    }

}
