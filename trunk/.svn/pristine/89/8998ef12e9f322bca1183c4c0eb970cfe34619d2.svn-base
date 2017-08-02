<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
class Module_func_model extends MY_Model {
    function __construct() {
        parent::__construct ();
    }
    public $funcInfoField = array (
            'LOGIN' => ' m.module_code,c.ctlr_id,c.ctlr_code,f.func_id,f.func_code,f.related_func_id,o.oper_id,o.oper_code,o.oper_config',
            'DISP' => ' m.module_code,m.module_name,m.module_des,c.ctlr_id,c.ctlr_code,c.ctlr_name,c.ctlr_des,f.func_id,f.func_code,f.func_name,f.func_des,f.auto_log,f.related_func_id,o.oper_id,o.oper_code,o.oper_name,o.oper_des,o.oper_config' 
    );
    /**获取帐号类型可开通的权限
     * @param int $accountType
     * @param string $listType 'LOGIN'|'DISP'
     * @return unknown[]|unknown
     */
    public function getAccountFuncList($accountType, $listType = 'LOGIN') {
        $selects = isset ( $this->funcInfoField [$listType] ) ? $this->funcInfoField [$listType] : '*';
        $db = $this->_db ( 'iwide_r1' );
        $this->load->library ( 'authority/authorityConst' );
        if (! empty ( authorityConst::$accountStates [$accountType] )) {
            $accountStates = authorityConst::$accountStates [$accountType];
        } else {
            return array ();
        }
        $sql = 'SELECT ' . $selects . ' FROM ' . $db->dbprefix ( authorityConst::TAB_MODULES ) . ' m
                LEFT JOIN ' . $db->dbprefix ( authorityConst::TAB_CONTROLLERS ) . ' c 
                ON c.module = m.module_code  AND c.ctlr_state in (' . implode ( ',', $accountStates ['controller'] ) . ') 
                LEFT JOIN ' . $db->dbprefix ( authorityConst::TAB_FUNCTIONS ) . ' f 
                ON f.ctlr_id = c.ctlr_id AND f.func_state in (' . implode ( ',', $accountStates ['function'] ) . ')
                LEFT JOIN ' . $db->dbprefix ( authorityConst::TAB_OPERATIONS ) . ' o 
                ON o.func_id = f.func_id AND o.oper_state = ' . authorityConst::OPER_STATE_VALID . ' WHERE m.module_state in (' . implode ( ',', $accountStates ['module'] ) . ')';
        $result = $db->query ( $sql )->result_array ();
        $data = array ();
        $func_key_arr = array_column($result, NULL,'func_id');
        foreach ( $result as $r ) {
            if (empty ( $data [$r ['module_code']] )) {
                $data [$r ['module_code']] = array (
                        'controllers' => array () 
                );
                if ($listType == 'DISP') {
                    $data [$r ['module_code']] ['name'] = $r ['module_name'];
                    $data [$r ['module_code']] ['des'] = $r ['module_des'];
                }
            }
            if (! empty ( $r ['ctlr_id'] )) {
                if (empty ( $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] )) {
                    $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] = array (
                            'code' => $r ['ctlr_code'],
                            'funcs' => array () 
                    );
                    if ($listType == 'DISP') {
                        $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['name'] = $r ['ctlr_name'];
                        $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['des'] = $r ['ctlr_des'];
                    }
                }
                if (! empty ( $r ['func_id'] )) {
                    if (empty ( $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']] )) {
                        $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']] = array (
                                'code' => $r ['func_code'],
                                'operations' => array () 
                        );
                        if (!empty ( $r ['related_func_id'] ) && !empty($func_key_arr[$r ['related_func_id']])){
                            $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']]['related_func']=$r ['related_func_id'];
                            $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']]['related_module']=$func_key_arr[$r ['related_func_id']]['module_code'];
                            $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']]['related_ctlr']=$func_key_arr[$r ['related_func_id']]['ctlr_id'];
                        }else {
                            $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']]['related_func']=0;
                        }
                        if ($listType == 'DISP') {
                            $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']] ['name'] = $r ['func_name'];
                            $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']] ['des'] = $r ['func_des'];
                        }
                    }
                    if (! empty ( $r ['oper_id'] )) {
                        $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']] [$r ['oper_id']] = array (
                                'code' => $r ['oper_code'],
                                'oper_config' => $r ['oper_config'] 
                        );
                        if ($listType == 'DISP') {
                            $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']] [$r ['oper_id']] ['name'] = $r ['oper_name'];
                            $data [$r ['module_code']] ['controllers'] [$r ['ctlr_id']] ['funcs'] [$r ['func_id']] [$r ['oper_id']] ['des'] = $r ['oper_des'];
                        }
                    }
                }
            }
        }
        return $data;
    }
}