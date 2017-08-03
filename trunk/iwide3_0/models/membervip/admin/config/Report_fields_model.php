<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_fields_model {

    /**
     * excel表字段配置
     * @param int $type
     * @return array
     */
    public function get_fields_conf($type=1,$data = array()){
        $fields_conf = array();
        switch ($type){
            case 1:
                $fields_conf = array(
                    's1'=>array(
                        array(
                            'name'=>'券码',
                            'field'=>'coupon_code'
                        ),
                        array(
                            'name'=>'卡券ID',
                            'field'=>'card_id',
                        ),
                        array(
                            'name'=>'卡券名称',
                            'field'=>'title',
                        ),
                        array(
                            'name'=>'会员ID',
                            'field'=>'member_info_id',
                        ),
                        array(
                            'name'=>'会员卡号',
                            'field'=>'membership_number',
                        ),
                        array(
                            'name'=>'会员昵称',
                            'field'=>'nickname',
                        ),
                        array(
                            'name'=>'会员姓名',
                            'field'=>'name',
                        ),
                        array(
                            'name'=>'领取来源',
                            'field'=>'receive_module',
                            'func'=>'_parsemodule'
                        ),
                        array(
                            'name'=>'领取时间',
                            'field'=>'receive_time',
                            'func'=>'_parse_datetime'
                        ),
                        array(
                            'name'=>'失效时间',
                            'field'=>'expire_time',
                            'func'=>'_parse_datetime'
                        ),
                        array(
                            'name'=>'优惠券状态',
                            'field'=>'card_status',
                            'func'=>'_parse_card_status',
                        ),
                        array(
                            'name'=>'使用场景',
                            'field'=>'use_module',
                            'func'=>'_parse_card_status'
                        ),
                        array(
                            'name'=>'使用时间',
                            'field'=>'use_time',
                            'func'=>'_parse_useoff_time'
                        ),
                        array(
                            'name'=>'核销场景',
                            'field'=>'useoff_module',
                            'func'=>'_parse_card_status'
                        ),
                        array(
                            'name'=>'核销时间',
                            'field'=>'useoff_time',
                            'func'=>'_parse_useoff_time'
                        ),
                        array(
                            'name'=>'使用范围',
                            'field'=>'card_module',
                        ),
                        array(
                            'name'=>'关联礼包编号',
                            'field'=>'package_ids',
                        ),
                        array(
                            'name'=>'关联礼包名称',
                            'field'=>'package_names',
                        ),
                    )
                );
                break;
            case 2:
                $fields_conf = array(
                    's1'=>array(
                        array(
                            'name'=>'领取时间',
                            'field'=>'receive_time',
                            'func'=>'_parse_date'
                        ),
                        array(
                            'name'=>'领取人数',
                            'field'=>'receive_count',
                        ),
                    ),
                    's2'=>array(
                        array(
                            'name'=>'优惠券名称',
                            'field'=>'title',
                        ),
                        array(
                            'name'=>'使用人数',
                            'field'=>'use_count',
                        ),
                        array(
                            'name'=>'使用时间',
                            'field'=>'use_time',
                            'func'=>'_parse_useoff_time'
                        )
                    ),
                    's3'=>array(
                        array(
                            'name'=>'优惠券名称',
                            'field'=>'title',
                        ),
                        array(
                            'name'=>'使用人数',
                            'field'=>'use_count',
                        ),
                        array(
                            'name'=>'核销时间',
                            'field'=>'useoff_time',
                            'func'=>'_parse_useoff_time'
                        ),
                    )
                );
                break;
            case 3:
                $fields_conf = array(
                    's1'=>array(
                        array(
                            'name'=>'会员ID',
                            'field'=>'member_info_id',
                        ),
                        array(
                            'name'=>'会员昵称',
                            'field'=>'nickname',
                        ),
                        array(
                            'name'=>'会员类型',
                            'field'=>'member_mode',
                        ),
                        array(
                            'name'=>'会员名称',
                            'field'=>'name',
                        ),
                        array(
                            'name'=>'会员卡号',
                            'field'=>'membership_number',
                        ),
                        array(
                            'name'=>'会员等级',
                            'field'=>'lvl_name',
                        ),
                        array(
                            'name'=>'PMS等级代码',
                            'field'=>'lvl_pms_code',
                        ),
                        array(
                            'name'=>'会员积分',
                            'field'=>'credit',
                        ),
                        array(
                            'name'=>'会员储值',
                            'field'=>'balance',
                        ),
                        array(
                            'name'=>'有效卡券总数',
                            'field'=>'member_card_count',
                        ),
                        array(
                            'name'=>'手机号码',
                            'field'=>'telephone',
                        ),
                        array(
                            'name'=>'会员生日',
                            'field'=>'birth',
                            'func'=>'_parse_date'
                        ),
                        array(
                            'name'=>'会员邮箱',
                            'field'=>'email',
                        ),
                        array(
                            'name'=>'是否登录',
                            'field'=>'is_login',
                        ),
                        array(
                            'name'=>'注册时间',
                            'field'=>'createtime',
                            'func'=>'_parse_datetime'
                        )
                    )
                );
                break;
            case 4:
                $fields_conf = array(
                    's1'=>array(
                        array(
                            'name'=>'会员卡号',
                            'field'=>'ir_membership_number',
                        ),
                        array(
                            'name'=>'会员名称',
                            'field'=>'ir_name',
                        ),
                        array(
                            'name'=>'邀请时间',
                            'field'=>'invited_time',
                            'func'=>'_parse_datehm'
                        ),
                        array(
                            'name'=>'注册时间',
                            'field'=>'mi_createtime',
                            'func'=>'_parse_datehm'
                        ),
                        array(
                            'name'=>'新会员卡号',
                            'field'=>'membership_number',
                        ),
                        array(
                            'name'=>'新会员名称',
                            'field'=>'name',
                        ),
                        array(
                            'name'=>'邀请资格',
                            'field'=>'lvl_name',
                        )
                    )
                );
                break;
            case 5:
                $fields_conf = array(
                    's1'=>array(
                        array(
                            'name'=>'ID',
                            'field'=>'deposit_card_pay_id',
                        ),
                        array(
                            'name'=>'订单号',
                            'field'=>'order_num',
                        ),
                        array(
                            'name'=>'会员卡名称',
                            'field'=>'member_lvl_name',
                        ),
                        array(
                            'name'=>'会员名称',
                            'field'=>'name',
                        ),
                        array(
                            'name'=>'微信昵称',
                            'field'=>'nickname',
                        ),
                        array(
                            'name'=>'会员卡号',
                            'field'=>'membership_number',
                        ),
                        array(
                            'name'=>'购卡金额(元)',
                            'field'=>'pay_money',
                        ),
                        array(
                            'name'=>'赠储值',
                            'field'=>'deposit',
                        ),
                        array(
                            'name'=>'赠积分',
                            'field'=>'credit',
                        ),
                        array(
                            'name'=>'优惠劵(张)',
                            'field'=>'card_count',
                        ),
                        array(
                            'name'=>'分销号',
                            'field'=>'distribution_num',
                        ),
                        array(
                            'name'=>'购卡时间',
                            'field'=>'createtime',
                            'func'=>'_parse_datetime'
                        ),
                        array(
                            'name'=>'分销员名称',
                            'field'=>'staff_name',
                        ),
                        array(
                            'name'=>'所属酒店',
                            'field'=>'hotel_name',
                        ),
                        array(
                            'name'=>'手机号码',
                            'field'=>'phone'
                        ),
                        array(
                            'name'=>'身份证',
                            'field'=>'idno'
                        )
                    )
                );
                break;
            case 6:
                $fields_conf = [
                    's1'=>[
                        [
                            'name'=>'ID',
                            'field'=>'credit_log_id',
                        ],
                        [
                            'name'=>'昵称',
                            'field'=>'nickname',
                        ],
                        [
                            'name'=>'姓名',
                            'field'=>'name',
                        ],
                        [
                            'name'=>'卡号',
                            'field'=>'membership_number',
                        ],
                        [
                            'name'=>'积分变更',
                            'field'=>'amount',
                        ],
                        [
                            'name'=>'来源',
                            'field'=>'note',
                        ],
                        [
                            'name'=>'记录时间',
                            'field'=>'createtime',
                            'func'=>'_parse_datetime'
                        ]
                    ]
                ];
                break;
            case 7:
                $fields_conf = [
                    's1'=>[
                        [
                            'name'=>'ID',
                            'field'=>'balance_log_id',
                        ],
                        [
                            'name'=>'订单号',
                            'field'=>'order_id',
                        ],
                        [
                            'name'=>'昵称',
                            'field'=>'nickname',
                        ],
                        [
                            'name'=>'姓名',
                            'field'=>'name',
                        ],
                        [
                            'name'=>'卡号',
                            'field'=>'membership_number',
                        ],
                        [
                            'name'=>'储值变更',
                            'field'=>'amount',
                        ],
                        [
                            'name'=>'来源',
                            'field'=>'note',
                        ],
                        [
                            'name'=>'记录时间',
                            'field'=>'createtime',
                            'func'=>'_parse_datetime'
                        ]
                    ]
                ];
                break;
            case 8:
                $fields_conf = [
                    's1'=>[
                        [
                            'name'=>'券码',
                            'field'=>'coupon_code',
                        ],
                        [
                            'name'=>'使用时间',
                            'field'=>'use_time',
                            'func'=>'_parse_useoff_time'
                        ],
                        [
                            'name'=>'优惠券ID',
                            'field'=>'card_id',
                        ],
                        [
                            'name'=>'券名',
                            'field'=>'title',
                        ],
                        [
                            'name'=>'会员号',
                            'field'=>'membership_number',
                        ],
                        [
                            'name'=>'会员名称',
                            'field'=>'name',
                        ],
                        [
                            'name'=>'手机号码',
                            'field'=>'telephone',
                        ],
                        [
                            'name'=>'适用范围',
                            'field'=>'is_online'
                        ],
                        [
                            'name'=>'状态',
                            'field'=>'status',
                        ],
                        [
                            'name'=>'使用方式',
                            'field'=>'use_type',
                        ],
                        [
                            'name'=>'备注',
                            'field'=>'remark',
                        ],
                        [
                            'name'=>'操作员',
                            'field'=>'operator',
                        ]
                    ]
                ];
                break;
            case 9:
                $fields_conf = [
                    's1'=>[
                        [
                            'name'=>'会员ID',
                            'field'=>'member_info_id',
                        ],
                        [
                            'name'=>'会员卡号',
                            'field'=>'membership_number',
                        ],
                        [
                            'name'=>'会员名称',
                            'field'=>'name',
                        ],
                        [
                            'name'=>'会员等级',
                            'field'=>'member_lvl_id',
                        ],
                        [
                            'name'=>'手机号码',
                            'field'=>'telephone',
                        ],
                        [
                            'name'=>'发送结果',
                            'field'=>'state',
                        ],
                        [
                            'name'=>'失败原因',
                            'field'=>'err_msg',
                        ],
                        [
                            'name'=>'发送时间',
                            'field'=>'send_time'
                        ],
                        [
                            'name'=>'发送内容',
                            'field'=>'send_name',
                        ],
                        [
                            'name'=>'数量',
                            'field'=>'send_count',
                        ]
                    ]
                ];
                if(!empty($data['s1'])){
                    $flag = false;
                    foreach ($data['s1'] as $item){
                        if(!empty($item['openid'])){
                            $flag = true;
                            break;
                        }
                    }
                    if($flag === true){
                        $fields_conf['s1'][] = array(
                            'name'=>'OPEN ID',
                            'field'=>'openid',
                        );
                    }
                }
                break;
        }
        return $fields_conf;

    }
}