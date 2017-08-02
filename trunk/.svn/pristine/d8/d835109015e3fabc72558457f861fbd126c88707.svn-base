<?php
class authorityConst {
    const MODULE_STATE_ALL_OPEN = 1; // 模块状态：1全开放，2禁用，3仅普通帐号及管理员，4仅超管及管理员，5仅超管
    const MODULE_STATE_PROHIBITED = 2;
    const MODULE_STATE_ACCOUNT_PUBMAN = 3;
    const MODULE_STATE_SYSMAN_PUBMAN = 4;
    const MODULE_STATE_SYSMAN = 5;
    
    const CTLR_STATE_ALL_OPEN = 1; // 控制器状态：1全开放，2禁用，3仅普通帐号及管理员，4仅超管及管理员，5仅超管
    const CTLR_STATE_PROHIBITED = 2;
    const CTLR_STATE_ACCOUNT_PUBMAN = 3;
    const CTLR_STATE_SYSMAN_PUBMAN = 4;
    const CTLR_STATE_SYSMAN = 5;
    
    const FUNC_STATE_ALL_OPEN = 1; // 功能状态：1全开放，2禁用，3仅普通帐号及管理员，4仅超管及管理员，5仅超管
    const FUNC_STATE_PROHIBITED = 2;
    const FUNC_STATE_ACCOUNT_PUBMAN = 3;
    const FUNC_STATE_SYSMAN_PUBMAN = 4;
    const FUNC_STATE_SYSMAN = 5;
    
    const OPER_STATE_VALID = 1; // 操作权限状态：1有效，2无效
    const OPER_STATE_INVALID = 2;
    
    const ROLE_TYPE_STANDARD = 1; // 角色类型，1标准角色，2自定义角色
    const ROLE_TYPE_CUSTOM = 2;
    
    const ACCOUNT_TYPE_SYSMAN = 1; // 角色类型，1超管，2管理员，3普通
    const ACCOUNT_TYPE_PUBMAN = 2;
    const ACCOUNT_TYPE_ORDINARY = 3;
    
    const TAB_MODULES = 'authority_modules';
    const TAB_CONTROLLERS = 'authority_controllers';
    const TAB_FUNCTIONS = 'authority_functions';
    const TAB_OPERATIONS = 'authority_operations';
    
    const FULL_ACCESS_INTERID = 'fullaccess';
    
    static $accountStates = array (
            self::ACCOUNT_TYPE_SYSMAN => array (
                    'module' => array (
                            self::MODULE_STATE_ALL_OPEN,
                            self::MODULE_STATE_SYSMAN_PUBMAN,
                            self::MODULE_STATE_SYSMAN 
                    ),
                    'controller' => array (
                            self::CTLR_STATE_ALL_OPEN,
                            self::CTLR_STATE_SYSMAN_PUBMAN,
                            self::CTLR_STATE_SYSMAN 
                    ),
                    'function' => array (
                            self::FUNC_STATE_ALL_OPEN,
                            self::FUNC_STATE_SYSMAN_PUBMAN,
                            self::FUNC_STATE_SYSMAN 
                    ) 
            ),
            self::ACCOUNT_TYPE_PUBMAN => array (
                    'module' => array (
                            self::MODULE_STATE_ALL_OPEN,
                            self::MODULE_STATE_ACCOUNT_PUBMAN,
                            self::MODULE_STATE_SYSMAN_PUBMAN 
                    ),
                    'controller' => array (
                            self::CTLR_STATE_ALL_OPEN,
                            self::CTLR_STATE_ACCOUNT_PUBMAN,
                            self::CTLR_STATE_SYSMAN_PUBMAN 
                    ),
                    'function' => array (
                            self::FUNC_STATE_ALL_OPEN,
                            self::FUNC_STATE_ACCOUNT_PUBMAN,
                            self::FUNC_STATE_SYSMAN_PUBMAN 
                    ) 
            ),
            self::ACCOUNT_TYPE_ORDINARY => array (
                    'module' => array (
                            self::MODULE_STATE_ALL_OPEN,
                            self::MODULE_STATE_ACCOUNT_PUBMAN 
                    ),
                    'controller' => array (
                            self::CTLR_STATE_ALL_OPEN,
                            self::CTLR_STATE_ACCOUNT_PUBMAN 
                    ),
                    'function' => array (
                            self::FUNC_STATE_ALL_OPEN,
                            self::FUNC_STATE_ACCOUNT_PUBMAN 
                    ) 
            ) 
    );
}