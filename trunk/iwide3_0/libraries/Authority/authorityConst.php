<?php
class authorityConst {
    const AUTH_ROLE_STATE_ALLOPEN = 1; // 权限对角色状态：1全开放，2禁用，3仅管理角色，4仅对特定公众号开放
    const AUTH_ROLE_STATE_PROHIBITED = 2;
    const AUTH_ROLE_STATE_MANAGER= 3;
    const AUTH_ROLE_STATE_HALFOPEN = 4;
    
    const AUTH_ACCOUNT_RANGE_ALLOPEN = 1; // 权限对帐号开放范围：1全开放，2仅普通帐号，3仅超管
    const AUTH_ACCOUNT_RANGE_ORDINARY = 2;
    const AUTH_ACCOUNT_RANGE_SYSMAN = 3;
    
    const OPER_STATE_VALID = 1; // 操作权限状态：1有效，2无效
    const OPER_STATE_INVALID = 2;
    
    const ROLE_TYPE_STANDARD = 1; // 角色类型，1标准角色，2自定义角色，3管理角色
    const ROLE_TYPE_CUSTOM = 2;
    const ROLE_TYPE_MANAGER = 3;
    
    const ACCOUNT_TYPE_SYSMAN = 1; // 帐号类型，1系统管理员，2普通帐号
    const ACCOUNT_TYPE_ORDINARY = 2;
    
    const TAB_MODULES = 'authority_modules';
    const TAB_CONTROLLERS = 'authority_controllers';
    const TAB_FUNCTIONS = 'authority_functions';
    const TAB_OPERATIONS = 'authority_operations';
    const TAB_VALIFY_TOKENS = 'authority_valify_tokens';
    
    const FULL_ACCESS_INTERID = 'fullaccess';
    
    //不同角色类型可用的权限的状态
    static $authStatesForRole = array (
            self::ROLE_TYPE_STANDARD => array (  
                    self::AUTH_ROLE_STATE_ALLOPEN 
            ),
            self::ROLE_TYPE_CUSTOM => array (
                    self::AUTH_ROLE_STATE_ALLOPEN 
            ),
            self::ROLE_TYPE_MANAGER => array (
                    self::AUTH_ROLE_STATE_ALLOPEN,
                    self::AUTH_ROLE_STATE_MANAGER
            ) 
    );
    //不同帐号类型可用的权限范围
    static $authRangesForAccount = array (
            self::ACCOUNT_TYPE_SYSMAN => array (
                    self::AUTH_ACCOUNT_RANGE_ALLOPEN,
                    self::AUTH_ACCOUNT_RANGE_SYSMAN 
            ),
            self::ACCOUNT_TYPE_ORDINARY => array (
                    self::AUTH_ACCOUNT_RANGE_ALLOPEN, 
                    self::AUTH_ACCOUNT_RANGE_ORDINARY 
            ) 
    );
    
    static $valifyTokenTypes = array( 
            1=>'登录验证',
            2=>'绑定微信',
            3=>'应用登录授权码'
    );
    static $valifyTokenConfig = array(
            1=>array(
              'ttl'=>300      
            ),2=>array(
              'ttl'=>300      
            ),3=>array(
              'ttl'=>300      
            ),
    );
}