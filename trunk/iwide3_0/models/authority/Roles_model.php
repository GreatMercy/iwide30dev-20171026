<?php
class Roles_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
    const TAB_AC = 'authority_controllers';
    const TAB_AF = 'authority_functions';
    const TAB_AM = 'authority_modules';
    const TAB_AO = 'authority_operations';
    const TAB_AR = 'authority_roles';


    function _load_db() {
        return $this->db;
    }


    function all_modules($status=''){
        $db = $this->_load_db ();
        if(!empty($status)){
            $db->where('module_status',$status);
        }
        return $db->get ( self::TAB_AM )->result_array ();

    }


    function authority_controllers($status=''){
        $db = $this->_load_db ();
        if(!empty($status)){
            $db->where('ctlr_status',$status);
        }
        return $db->get ( self::TAB_AC )->result_array ();

    }


    function authority_func($ctlr_id='',$status=''){
        $db = $this->_load_db ();
        if(!empty($status)){
            $db->where('ctlr_status',$status);
        }
        if(!empty($ctlr_id)){
            $db->where('ctlr_id',$ctlr_id);
        }

        return $db->get ( self::TAB_AF )->result_array ();

    }


    function authority_operations($func_id='',$status=''){
        $db = $this->_load_db ();
        if(!empty($status)){
            $db->where('oper_status',$status);
        }
        if(!empty($func_id)){
            $db->where('func_id',$func_id);
        }

        return $db->get ( self::TAB_AO )->result_array ();

    }



    function all_roles($inter_id,$params=array(),$status=''){

        $db = $this->_load_db ();

        if(!empty($params))$db->limit ( $params['size'], $params['offset'] );

        if(!empty($status)){
            $db->where('status',$status);
        }
        $db->where('inter_id',$inter_id);

        $db->order_by('role_id DESC');

        return $db->get ( self::TAB_AR )->result_array ();
    }



    function standard_roles($status=''){  //所有标准角色

        $db = $this->_load_db ();
        if(!empty($status)){
            $db->where('status',$status);
        }
        $db->where('role_type',1);
        $db->order_by('role_id DESC');

        return $db->get ( self::TAB_AR )->result_array ();
    }



    function getRoleById($inter_id,$role_id){
        $db = $this->_load_db ();
        $db->where(
            array(
                'inter_id'=>$inter_id,
                'role_id'=>$role_id
            )
        );
        return $db->get ( self::TAB_AR )->row_array ();
    }


    function roles_type(){
       return array(
           '1'=>'标准角色',
           '2'=>'自定义角色',
           '3'=>'超级管理员',
           '4'=>'管理员'
       );
    }


    function get_all_authorities(){    //获取整个平台的权限

        $temp = array();
        $all_operations = $this->authority_operations();   //权限操作
        if(!empty($all_operations)){
            foreach($all_operations as $arr_operations){
                $temp['operations'][$arr_operations['func_id']][$arr_operations['oper_id']] = $arr_operations;
            }
        }


        $all_func = $this->authority_func();    //权限方法
        if(!empty($all_func)){
            foreach($all_func as $arr_func){
                $temp['func'][$arr_func['ctlr_id']][$arr_func['func_id']] = $arr_func;
                if(isset($temp['operations'][$arr_func['func_id']])){
                    $temp['func'][$arr_func['ctlr_id']][$arr_func['func_id']]['operations'] = $temp['operations'][$arr_func['func_id']];
                }
            }
        }

        $all_controllers = $this->authority_controllers();   //权限控制器
        if(!empty($all_controllers)){
            foreach($all_controllers as $arr_controllers){
                $temp['ctlr'][$arr_controllers['module']][$arr_controllers['ctlr_id']] = $arr_controllers;
                if(isset($temp['func'][$arr_controllers['ctlr_id']])){
                    $temp['ctlr'][$arr_controllers['module']][$arr_controllers['ctlr_id']]['ctlr'] = $temp['func'][$arr_controllers['ctlr_id']];
                }
            }
        }

        $all_modules = $this->all_modules();   //权限模块
        if(!empty($all_modules)){
            foreach($all_modules as $arr_modules){
                $temp['modules'][$arr_modules['module_code']] = $arr_modules;
                if(isset($temp['ctlr'][$arr_modules['module_code']])){
                    $temp['modules'][$arr_modules['module_code']]['modules'] = $temp['ctlr'][$arr_modules['module_code']];
                }
            }
        }


        $all_authorities=array();
        if(isset($temp['modules'])){        //所有权限
            $all_authorities = $temp['modules'];
        }elseif(isset($temp['ctlr'])){
            $all_authorities = $temp['ctlr'];
        }elseif(isset($temp['func'])){
            $all_authorities = $temp['func'];
        }elseif(isset($temp['operations'])){
            $all_authorities = $temp['operations'];
        }


        return $all_authorities;

    }


    function compare_authorities($all_authorities,$authorities,$role_authority=array()){

        foreach($authorities as $m_key => $module){
            $authorities[$m_key]['name'] = $all_authorities[$m_key]['module_name'];
            $authorities[$m_key]['code'] = $all_authorities[$m_key]['module_code'];
            foreach($module['controllers'] as $c_key => $ctrl){
                $authorities[$m_key]['controllers'][$c_key]['name'] = $all_authorities[$m_key]['modules'][$c_key]['ctlr_name'];
                $authorities[$m_key]['controllers'][$c_key]['code'] = $all_authorities[$m_key]['modules'][$c_key]['ctlr_code'];
                foreach($ctrl['funcs'] as $f_key => $func){
                    $authorities[$m_key]['controllers'][$c_key]['funcs'][$f_key]['name'] = $all_authorities[$m_key]['modules'][$c_key]['ctlr'][$f_key]['func_name'];
                    $authorities[$m_key]['controllers'][$c_key]['funcs'][$f_key]['code'] = $all_authorities[$m_key]['modules'][$c_key]['ctlr'][$f_key]['func_code'];
                    if(isset($role_authority[$m_key]['controllers'][$c_key]['funcs'][$f_key])){
                        $authorities[$m_key]['controllers'][$c_key]['funcs'][$f_key]['check'] = 1;
                        $authorities[$m_key]['controllers'][$c_key]['check'] = 1;
                        $authorities[$m_key]['check'] = 1;
                    }
//                        if(!empty($func['operations'])){
//                            foreach($func['operations'] as $o_key=> $operation){
//
//                            }
//                        }
                }
            }
        }

        return $authorities;

    }



    function new_role($inter_id,$post){

        $authority = serialize($post['role_authority']);
        $create_time = date('Y-m-d H:i:s',time());

        $data = array(
            'inter_id'=>$inter_id,
            'role_type'=>$post['role_type'],
            'role_name'=>$post['role_name'],
            'role_authority'=>$authority,
            'create_time'=>$create_time,
            'update_time'=>$create_time,
            'creator'=>$post['account']
        );

        if(!empty($post['related_role_id']))$data['related_role_id']=$post['related_role_id'];

        return $this->db->insert ( self::TAB_AR, $data );

    }


    function update_role($params,$update){

        $update['update_time'] = date('Y-m-d H:i:s',time());

        $this->db->where($params);

        return $this->db->update(self::TAB_AR,$update);

    }


    function login_authority($inter_id,$role_id){

        $this->load->model('authority/Module_func_model');
        $all_authorities = $this->get_all_authorities();

        $role = $this->getRoleById($inter_id,$role_id);

        $res = array();

        if(!empty($role) && !empty($role['role_authority'])){
            $role_authority = unserialize($role['role_authority']);
            $authorities = $this->compare_authorities($all_authorities,$role_authority);
            if(!empty($authorities)){
                foreach($authorities as $ctrl){
                    foreach($ctrl['controllers'] as $func){
                        foreach($func['funcs'] as $arr){
                            $res['adminhtml'][$ctrl['code']][$func['code']][] = $arr['code'];
                        }
                    }
                }
            }
        }

        return $res;
    }





}