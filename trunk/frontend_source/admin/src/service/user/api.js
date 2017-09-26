// COUPON主路径
let URL_SUFFIX = '/index.php/iapi/v1/membervip/vapi'
let URL_REQUEST = '/index.php/iapi/v1/membervip/tasklogic'
let URL_REPORT = '/index.php/iapi/v1/report/fans'
let URL_ANALYSIS = '/index.php/iapi/v1/membervip/analysis'

const user = {
  // 发送任务配置
  GET_COUPON_CODE_INFO: `${URL_SUFFIX}/create_coupon_task`,
  // 发送任务列表
  GET_COUPON_LIST: `${URL_SUFFIX}/coupon_task`,
  // 发送任务详情
  GET_COUPON_CONTENT_DETAIL: `${URL_SUFFIX}/task_item`,
  // 新建任务配置
  GET_REQUEST_CONTENT_INFO: `${URL_REQUEST}/save_create`,
  // 删除任务
  GET_REQUEST_CONTENT_DELETE: `${URL_REQUEST}/delete`,
  // 会员注册分销绩效
  GET_REG_STATEMENTS: `${URL_SUFFIX}/reg_distribution_statements`,
  // 购卡充值分销绩效
  GET_DEPOST_STATEMENTS: `${URL_SUFFIX}/deposit_card_statements`,
  // 酒店列表
  GET_HOTEL_LIST: `${URL_SUFFIX}/hotels_list`,
  // 粉丝统计
  GET_FANS_REPORT: `${URL_REPORT}/fans_report`,
  // 群发图文统计
  GET_ARTICLE_TOTAL: `${URL_REPORT}/wx_article_total`,
  // 储值数据分析
  GET_BALANCE_ANALYSIS: `${URL_ANALYSIS}/balance_analysis`,
  // 指定日期下的储值数据分析
  GET_BALANCE_ANALYSIS_BYDATE: `${URL_ANALYSIS}/balance_analysis_by_date`,
  // 积分数据分析
  GET_CREDIT_ANALYSIS: `${URL_ANALYSIS}/credit_analysis`,
  // 指定日期下的积分数据分析
  GET_CREDIT_ANALYSIS_BYDATE: `${URL_ANALYSIS}/credit_analysis_by_date`
}
export {
  user
}

