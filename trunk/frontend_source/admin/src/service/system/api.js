// api v1版本
let API_URL_SUFFIX = '/index.php/iapi'
let API_URL_SUFFIX_V1 = `${API_URL_SUFFIX}/v1`

// V1版本
// HOTEL相关部分
let API_SOMA_V1 = `${API_URL_SUFFIX_V1}/soma`
// express(快递)相关部分
let API_EXPRESS_V1 = `${API_URL_SUFFIX_V1}/soma/express`
// 角色相关
let API_ROLE_V1 = `${API_URL_SUFFIX_V1}/authority/roles`
// 账号相关
let API_ACCOUNT_V1 = `${API_URL_SUFFIX_V1}/authority/accounts`
let API_LOGIN_V1 = `${API_URL_SUFFIX_V1}/authority/auth`
const v1 = {
  // 获取商品套餐列表
  GET_PACKAGE_LIST_DATAS: `${API_SOMA_V1}/package/index`,
  // 邮寄发货
  POST_EXPRESS_DELIVERY: `${API_EXPRESS_V1}/create_other_shipping_order`,
  // 订单列表
  GET_EXPRESS_ORDER_LIST: `${API_EXPRESS_V1}/get_order_list`,
  // 物流列表
  GET_EXPRESS_LIST: `${API_EXPRESS_V1}/get_express_list`,
  // 导出订单列表
  GET_EXPRESS_EXPORT_ORDER_LIST: `${API_EXPRESS_V1}/export_order_list`,
  // 导入订单列表
  POST_EXPRESS_BATCH_POST: `${API_EXPRESS_V1}/batch_post`,
  // 上传csv
  POST_EXPRESS_UPLOAD: `${API_EXPRESS_V1}/do_upload`,
  // 批量下单至顺丰
  POST_EXPRESS_BATCH_CREATE_ORDER: `${API_EXPRESS_V1}/batch_create_order`,
  // 权限 获取角色列表
  GET_ROLE_LIST: (process.env.NODE_ENV === 'development') ? `${API_ROLE_V1}/rolesList?debug=1` : `${API_ROLE_V1}/rolesList`,
  // 权限 新增或者修改角色-->获取基础信息
  GET_ROLE_INFOR: (process.env.NODE_ENV === 'development') ? `${API_ROLE_V1}/edit_role?debug=1` : `${API_ROLE_V1}/edit_role`,
  // 权限 新增或者修改角色 -->获取权限
  GET_ROLE_AUTHORITY: (process.env.NODE_ENV === 'development') ? `${API_ROLE_V1}/edit_authorities?debug=1` : `${API_ROLE_V1}/edit_authorities`,
  // 权限 新增或者修改角色 -->提交新建
  POST_ROLE_DATA: (process.env.NODE_ENV === 'development') ? `${API_ROLE_V1}/edit_role_post?debug=1` : `${API_ROLE_V1}/edit_role_post`,
  // 权限 权限清单 -->权限模块列表
  GET_AUTHORITY_MODULE: (process.env.NODE_ENV === 'development') ? `${API_ROLE_V1}/modules_list?debug=1` : `${API_ROLE_V1}/modules_list`,
  // 权限 权限清单 --> 权限列表
  GET_AUTHORITY_LIST: (process.env.NODE_ENV === 'development') ? `${API_ROLE_V1}/authorities_list?debug=1` : `${API_ROLE_V1}/authorities_list`,
  //  权限 权限清单 --> 提交权限新增或修改数据
  POST_AUTHORITY_CHANGE: (process.env.NODE_ENV === 'development') ? `${API_ROLE_V1}/edit_ctrl_post?debug=1` : `${API_ROLE_V1}/edit_ctrl_post`,
  // 权限 权限清单 --> 提交子项新增或修改数据
  POST_SUB_CHANGE: (process.env.NODE_ENV === 'development') ? `${API_ROLE_V1}/edit_func_post?debug=1` : `${API_ROLE_V1}/edit_func_post`,
  // 权限 权限清单 --> 提交子项操作新增或修改数据
  POST_OPERATION_CHANGE: (process.env.NODE_ENV === 'development') ? `${API_ROLE_V1}/edit_operate_post?debug=1` : `${API_ROLE_V1}/edit_operate_post`,
  // 权限 账户 --> 账户列表
  GET_ACCOUNT_LIST: (process.env.NODE_ENV === 'development') ? `${API_ACCOUNT_V1}/accountsList?debug=1` : `${API_ACCOUNT_V1}/accountsList`,
  // 权限 账户-->获取公众号和角色
  GET_ACCOUNT_RELATED: (process.env.NODE_ENV === 'development') ? `${API_ACCOUNT_V1}/getInter?debug=1` : `${API_ACCOUNT_V1}/getInter`,
  // 权限 账户 --> 获取酒店信息
  GET_ACCOUNT_HOTEL: (process.env.NODE_ENV === 'development') ? `${API_ACCOUNT_V1}/loadInterData?debug=1` : `${API_ACCOUNT_V1}/loadInterData`,
  // 权限 账户 -->获取角色权限
  GET_ACCOUNT_AUTHORITY: (process.env.NODE_ENV === 'development') ? `${API_ACCOUNT_V1}/getAccountAuth?debug=1` : `${API_ACCOUNT_V1}/getAccountAuth`,
  // 权限 账户 -->获取账户信息
  GET_ACCOUNT_INFOR: (process.env.NODE_ENV === 'development') ? `${API_ACCOUNT_V1}/getAccountInfo?debug=1` : `${API_ACCOUNT_V1}/getAccountInfo`,
  // 权限 账户 -->提交新增账户数据
  POST_NEW_ACCOUNT: (process.env.NODE_ENV === 'development') ? `${API_ACCOUNT_V1}/addAccount?debug=1` : `${API_ACCOUNT_V1}/addAccount`,
  // 权限 账户 --> 搜索账户数据
  GET_SEARCH_PUBLIC: (process.env.NODE_ENV === 'development') ? `${API_ACCOUNT_V1}/accountsList?debug=1` : `${API_ACCOUNT_V1}/accountsList`,
  // 权限 账户 -->获取角色
  GET_ACCOUNT_ROLE: (process.env.NODE_ENV === 'development') ? `${API_ACCOUNT_V1}/getRoles?debug=1` : `${API_ACCOUNT_V1}/getRoles`,
  // 权限 账户 -->生成登陆二维码
  GET_LOGIN_QRCODE: (process.env.NODE_ENV === 'development') ? `${API_LOGIN_V1}/createQrCode?debug=1` : `${API_LOGIN_V1}/createQrCode`,
  // 权限 账户 -->获取扫码状态
  GET_CODE_SCAN: (process.env.NODE_ENV === 'development') ? `${API_LOGIN_V1}/checkCodeStatu?debug=1` : `${API_LOGIN_V1}/checkCodeStatu`,
  // 权限 账户 -->编辑账户
  POST_EDIT_ACCOUNT: (process.env.NODE_ENV === 'development') ? `${API_ACCOUNT_V1}/editAccount?debug=1` : `${API_LOGIN_V1}/editAccount`,
  // 权限 账户 -->生成绑定二维码
  GET_BIND_QRCODE: (process.env.NODE_ENV === 'development') ? `${API_ACCOUNT_V1}/createQrCode?debug=1` : `${API_LOGIN_V1}/createQrCode`
}

export {
  v1
}
