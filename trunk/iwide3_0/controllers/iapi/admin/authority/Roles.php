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

        $inter_id = $this->inter_id;
        $account = $this->input->post();  //账号信息

        $params=array();
        if(isset($account['pages']) && isset($account['size'])){
            $params['offset'] = $account['pages'];
            $params['size'] = $account['size'];
        }


        $role_id = $account['role_id'];

        $myRole = $this->Roles_model->getRoleById($inter_id,$role_id);

//        if(!isset($myRole['role_type']) || $myRole['role_type']!=3 || $myRole['role_type']!=4){  //没有对应的角色或者角色不为管理员
//
//        }

        $data['roles_type'] = $this->Roles_model->roles_type();
        $data['roles'] = $this->Roles_model->all_roles($inter_id,$params);

        $this->out_put_msg(1,'',$data,'authority/roles/roles_list',200,$params);


    }


    public function edit_role(){   //角色编辑

/*                $test = array(
                    'app'=>array(
                        'controllers'=>array(
                            '2'=>array(
                                'funcs'=>array(
                                  '6'=>array(),
                                  '7'=>array(),
                                  '8'=>array()
                                )
                            ),
                            '1'=>array(
                                'funcs'=>array(
                                    '1'=>array(),
                                    '2'=>array(),
                                    '3'=>array(),
                                    '4'=>array(),
                                    '5'=>array()
                                )
                            )
                        )
                    ),
                    'club'=>array(
                        'controllers'=>array(
                            '96'=>array(
                                'funcs'=>array(
                                    '586'=>array(),
                                    '587'=>array(),
                                    '588'=>array()
                                )
                            ),
                            '97'=>array(
                                'funcs'=>array(
                                    '590'=>array(),
                                    '595'=>array(),
                                    '596'=>array(),
                                    '599'=>array(),
                                    '603'=>array()
                                )
                            ),
                            '98'=>array(
                                'funcs'=>array(
                                    '604'=>array(),
                                    '605'=>array(),
                                    '607'=>array(),
                                    '608'=>array(),
                                    '612'=>array()
                                )
                            )
                        )
                    )
                );*/


        $data = $this->common_data;
        $inter_id = $this->inter_id;
        $this->load->model("authority/Roles_model");
        $this->load->library ( 'authority/authorityConst' );//权限系统常量
        $this->load->model('authority/Module_func_model');

        $all_authorities = $this->Roles_model->get_all_authorities();

        $user = $this->session->userdata();
$user['account_type'] = 2;

        if($user['account_type'] != 2){
            $authorities=$this->Module_func_model->getAccountFuncList($user['account_type']);//1标准角色，2自定义角色，3超管，4管理员
        }else{
$user['admin_profile']['role_id']=1;
            $myrole = $this->Roles_model->getRoleById($inter_id,$user['admin_profile']['role_id']);
            $authorities = unserialize($myrole['role_authority']);
        }



        $edit_role_id = $this->input->get('role_id');
        $data['edit_role'] = array();
        if(!empty($edit_role_id)){
            $data['edit_role'] = $this->Roles_model->getRoleById($inter_id,$edit_role_id);
            if(isset($data['edit_role']['role_authority']) && !empty($data['edit_role']['role_authority'])){
                $role_authority = unserialize($data['edit_role']['role_authority']);
            }
        }


        if(!empty($authorities)){

            $authorities = $this->Roles_model->compare_authorities($all_authorities,$authorities,$role_authority);

        }

        $data['result'] = $authorities;

        $this->out_put_msg(1,'',$data,'authority/roles/edit_role',200);

    }



    public function edit_role_post(){

        $data = $this->common_data;
        $this->load->model("authority/Roles_model");

        $role_id = $this->input->post('role_id');
        $inter_id = $this->inter_id;

        $info = array(
            'status' => 0,
            'message' => '编辑失败'
        );

        $account = array();

        $post_data['role_type'] = $this->input->post('role_type');
        $post_data['role_name'] = $this->input->post('role_name');
        $post_data['status'] = $this->input->post('status');
        $post_data['role_authority'] = $this->input->post('role_authority');
        $post_data['creator'] = $account;

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
            $info['status'] = 1;
            $info['message'] = '编辑成功';
        }

        echo json_encode($info);

    }

}
