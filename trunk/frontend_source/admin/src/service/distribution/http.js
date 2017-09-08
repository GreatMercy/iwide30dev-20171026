import * as apiConfig from './api'
import ajax from '@/utils/http'

/**
 * 获取银行账户管理列表
 * @param {Object} data get请求参数
 * @param {string} [data.type] 账户类型
 * @param {string} [data.keyword] 搜索关键词
 * @param {string} [data.offset] 页码
 * @param {string} [data.limit] 每页数量
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getBankAccountList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BANK_ACCOUNT_LIST || apiConfig['v1'].GET_BANK_ACCOUNT_LIST
  return ajax.get(url, data)
}

/**
 * 删除银行账户
 * @param {Object} data get请求参数
 * @param {string} [data.id] 账户id
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const deleteAccount = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].DELETE_ACCOUNT || apiConfig['v1'].DELETE_ACCOUNT
  return ajax.delete(url, data)
}

/**
 * 获取银行账户信息
 * @param {Object} data get请求参数
 * @param {string} [data.id] 账户id
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getBankAccountInfo = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BANK_ACCOUNT_INFO || apiConfig['v1'].GET_BANK_ACCOUNT_INFO
  return ajax.get(url, data)
}

/**
 * 修改银行账户信息
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const editBankAccountInfo = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].EDIT_BANK_ACCOUNT_INFO || apiConfig['v1'].EDIT_BANK_ACCOUNT_INFO
  return ajax.put(url, data, config)
}

/**
 * 新增银行账户信息
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const addBankAccountInfo = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].ADD_BANK_ACCOUNT_INFO || apiConfig['v1'].ADD_BANK_ACCOUNT_INFO
  return ajax.post(url, data, config)
}

/**
 * 根据公众号id获取其下门店信息
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getHotels = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_HOTELS || apiConfig['v1'].GET_HOTELS
  return ajax.get(url, data, config)
}

/**
 * 根据公众号信息列表
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getPublics = (config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PUBLICS || apiConfig['v1'].GET_PUBLICS
  return ajax.get(url, config)
}

/**
 * 获取交易流水更多选项
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getTradeRecordSearch = (config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_TRADE_RECORD_SEARCH || apiConfig['v1'].GET_TRADE_RECORD_SEARCH
  return ajax.get(url, config)
}

/**
 * 获取结算记录列表
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getSettleRecordList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_SETTLE_RECORD_LIST || apiConfig['v1'].GET_SETTLE_RECORD_LIST
  return ajax.get(url, data, config)
}

/**
 * 获取交易流水列表
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getTradeRecordList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_TRADE_RECORD_LIST || apiConfig['v1'].GET_TRADE_RECORD_LIST
  return ajax.get(url, data, config)
}

/**
 * 获取财务对账单
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const loadFinancialBill = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].LOAD_FINANCE_BILL || apiConfig['v1'].LOAD_FINANCE_BILL
  return ajax.get(url, data, config)
}

/**
 * 获取财务对账单
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getSplitRuleList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_SPLIT_RULE_LIST || apiConfig['v1'].GET_SPLIT_RULE_LIST
  return ajax.get(url, data, config)
}

/**
 * 改变规则状态
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const changeSplitStatus = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].CHANGE_SPLIT_STATUS || apiConfig['v1'].CHANGE_SPLIT_STATUS
  return ajax.put(url, data, config)
}

/**
 * 获取某公众号规则列表
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getSplitDetails = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_SPLIT_DETAILS || apiConfig['v1'].GET_SPLIT_DETAILS
  return ajax.get(url, data, config)
}

/**
 * 获取某个规则
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getSplitRule = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_SPLIT_RULE || apiConfig['v1'].GET_SPLIT_RULE
  return ajax.get(url, data, config)
}

/**
 * 保存规则
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const putSaveRule = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].PUT_SAVE_RULE || apiConfig['v1'].PUT_SAVE_RULE
  return ajax.put(url, data, config)
}

/**
 * 创建新规则
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getAddRule = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_ADD_RULE || apiConfig['v1'].GET_ADD_RULE
  return ajax.get(url, data, config)
}

/**
 * 获取退款列表
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getRefundList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_REFUND_LIST || apiConfig['v1'].GET_REFUND_LIST
  return ajax.get(url, data, config)
}

/**
 * 获取规则模块
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getModule = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_MODULE || apiConfig['v1'].GET_MODULE
  return ajax.get(url, data, config)
}

/**
 * 搜索银行
 * @param {Object} data get请求参数
 * @param {string} [data.keyword] 关键字
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getBranch = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BRANCH || apiConfig['v1'].GET_BRANCH
  return ajax.get(url, data, config)
}

/**
 * 查询申请退款的订单
 * @param {Object} data get请求参数
 * @param {string} data.order_no 订单号
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getRefundOrder = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_REFUND_ORDER || apiConfig['v1'].GET_REFUND_ORDER
  return ajax.get(url, data)
}

/**
 * 申请退款
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const postRefund = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_REFUND || apiConfig['v1'].POST_REFUND
  return ajax.post(url, data, config)
}

/**
 * 银行账户管理列表
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.inter_id] 公众号ID
 * @param {string} [data.hotel_id] 门店ID
 * @param {string} [data.status] 验证状态
 * @param {string} [data.inter_id] 公众号ID
 * @param {string} [data.start_time] 验证时间 - 开始时间
 * @param {string} [data.end_time] 验证时间 - 结束时间
 * @param {string} [data.offset] 当前页码 （默认为1）
 * @param {string} [data.limit] 显示数量/页 （默认为20）
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getBankCheckAccount = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BANK_CHECK_ACCOUNT || apiConfig['v1'].GET_BANK_CHECK_ACCOUNT
  return ajax.get(url, data)
}

/**
 * 发起校验
 * @param {Object} data get请求参数 {很多参数}
 * @param {int} data.id 账户ID
 * @param {string} data.status 状态 发起验证：send, 重新验证：re_send
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const postCheckAccount = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_CHECK_ACCOUNT || apiConfig['v1'].POST_CHECK_ACCOUNT
  return ajax.post(url, data, config)
}

/**
 * 资金概览
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.inter_id] 公众号ID
 * @param {string} [data.hotel_id] 酒店ID
 * @param {string} [data.start_time] 转账时间 - 开始时间 2017-08-08
 * @param {string} [data.end_time] 转账时间 - 结束时间 2017-08-08
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getCapitalOverview = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_CAPITAL_OVERVIEW || apiConfig['v1'].GET_CAPITAL_OVERVIEW
  return ajax.get(url, data, config)
}

/**
 * 资金概览列表
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.inter_id] 公众号ID
 * @param {string} [data.hotel_id] 酒店ID
 * @param {string} [data.start_time] 转账时间 - 开始时间 2017-08-08
 * @param {string} [data.end_time] 转账时间 - 结束时间 2017-08-08
 * @param {string} [data.offset] 当前页码 （默认为1）
 * @param {string} [data.limit] 显示数量/页 （默认为20）
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getCapitalList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_CAPITAL_LIST || apiConfig['v1'].GET_CAPITAL_LIST
  return ajax.get(url, data, config)
}

/**
 * 转账列表
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.status] 状态
 * @param {string} [data.start_time] 转账时间 - 开始时间 2017-08-08
 * @param {string} [data.end_time] 转账时间 - 结束时间 2017-08-08
 * @param {string} [data.offset] 当前页码 （默认为1）
 * @param {string} [data.limit] 显示数量/页 （默认为20）
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getTransferAccounts = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_TRANSFER_ACCOUNTS || apiConfig['v1'].GET_TRANSFER_ACCOUNTS
  return ajax.get(url, data, config)
}

/**
 * 发起转账
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.status] 转账状态 ：send => 发起转账，re_send => 重新转账
 * @param {string} [data.id] 转账记录ID
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getSingleSend = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_SINGLE_SEND || apiConfig['v1'].GET_SINGLE_SEND
  return ajax.get(url, data, config)
}

export default {
  getBankAccountList,
  deleteAccount,
  getBankAccountInfo,
  editBankAccountInfo,
  addBankAccountInfo,
  getHotels,
  getPublics,
  getSettleRecordList,
  getTradeRecordList,
  getTradeRecordSearch,
  loadFinancialBill,
  getSplitRuleList,
  changeSplitStatus,
  getSplitDetails,
  getSplitRule,
  putSaveRule,
  getAddRule,
  getRefundList,
  getModule,
  getBranch,
  getRefundOrder,
  postRefund,
  getBankCheckAccount,
  postCheckAccount,
  getCapitalOverview,
  getCapitalList,
  getTransferAccounts,
  getSingleSend
}
