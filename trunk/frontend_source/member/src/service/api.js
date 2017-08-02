// member主路径
let MEMBER_URL_SUFFIX = '/index.php/iapi/membervip'
let MEMBER_URL = '/index.php/membervip'
const member = {
  // 获取会员中心
  GET_INDEX_INFO: `${MEMBER_URL_SUFFIX}/center/member_center`,
  // 获取登录页面信息
  GET_LOGIN_INFO: `${MEMBER_URL_SUFFIX}/login/index`,
  // 获取注册页面信息
  GET_REG_INFO: `${MEMBER_URL_SUFFIX}/reg/index`,
  // 获取存重置密码
  GET_RESETPSW_INFO: `${MEMBER_URL_SUFFIX}/resetpassword/index`,
  // 保存重置密码
  POST_RESETPSW_SAVE: `${MEMBER_URL_SUFFIX}/resetpassword/saveresetpassword`,
  // 注册请求接口
  POST_REG_INTERFACE: `${MEMBER_URL_SUFFIX}/reg/savereg`,
  // 登录接
  POST_LOGIN_INTERFACE: `${MEMBER_URL_SUFFIX}/login/savelogin`,
  // 会员信息
  GET_MEMBER_INFO: `${MEMBER_URL_SUFFIX}/center/info`,
  // 修改会员信息
  GET_PERFECTINFO_INFO: `${MEMBER_URL_SUFFIX}/perfectinfo/index`,
  // 保存会员信息
  POST_PERFECTINFO_SAVE: `${MEMBER_URL_SUFFIX}/perfectinfo/save`,
  // 余额记录
  GET_BALANCE_INFO: `${MEMBER_URL_SUFFIX}/balance/index`,
  // 储值充值支付
  GET_BALANCE_PAY: `${MEMBER_URL_SUFFIX}/balance/pay`,
  // 提交充值
  POST_BALANCE_SUBPAY: `${MEMBER_URL_SUFFIX}/balance/sub_pay`,
  // 储值支付成功
  GET_BALANCE_OKPAY: `${MEMBER_URL_SUFFIX}/balance/okpay`,
  // 储值支付失败
  GET_BALANCE_NOPAY: `${MEMBER_URL_SUFFIX}/balance/nopay`,
  // 积分记录
  GET_BONUS_INFO: `${MEMBER_URL_SUFFIX}/bonus/index`,
  // 会员可购卡列表
  GET_DEPOSITCARD_INFO: `${MEMBER_URL_SUFFIX}/depositcard/index`,
  // 会员购卡详细信息
  GET_DEPOSITCARD_DETAIL: `${MEMBER_URL_SUFFIX}/depositcard/info`,
  // 会员开始购卡
  GET_DEPOSITCARD_BUYCARD: `${MEMBER_URL_SUFFIX}/depositcard/buycard`,
  // 购卡支付
  GET_BUYCARD: `${MEMBER_URL_SUFFIX}/depositcard/pay`,
  // 优惠券详情列表
  GET_CARD_INFO: `${MEMBER_URL_SUFFIX}/card/index`,
  // 优惠券详情
  GET_CARD_DETAIL: `${MEMBER_URL_SUFFIX}/card/cardinfo`,
  // 领取优惠券
  GET_CARD_RECEIVE: `${MEMBER_URL_SUFFIX}/card/getcard`,
  // 优惠券消费码核销
  POST_DEPOSITCARD_PASSWDUSEOFF: `${MEMBER_URL_SUFFIX}/card/passwduseoff`,
  // 获取验证码
  GET_SENDSMS: `${MEMBER_URL}/sendsms`,
  // 创建储值订单
  POST_DEPOSIT_ORDER: `${MEMBER_URL_SUFFIX}/depositcard/save_deposit_order`,
  // 开始创建订单
  GET_ORDER: `${MEMBER_URL_SUFFIX}/depositcard/save_order`,
  // 储值充值页面
  GET_BUYDEPOSIT_INFO: `${MEMBER_URL_SUFFIX}/depositcard/buydeposit`,
  // 退出登录
  OUT_LOGIN: `${MEMBER_URL_SUFFIX}/login/outlogin`
}
export {
  member
}
