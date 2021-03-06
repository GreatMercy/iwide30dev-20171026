// api v1版本
let API_URL_SUFFIX = '/index.php/iwidepay/IwidepayApi'

const v1 = {
  GET_BANK_ACCOUNT_LIST: `${API_URL_SUFFIX}/bank_account`,
  DELETE_ACCOUNT: `${API_URL_SUFFIX}/del_bank_account`,
  GET_BANK_ACCOUNT_INFO: `${API_URL_SUFFIX}/bank_account_detail`,
  EDIT_BANK_ACCOUNT_INFO: `${API_URL_SUFFIX}/edit_bank_account`,
  ADD_BANK_ACCOUNT_INFO: `${API_URL_SUFFIX}/add_bank_account`,
  GET_HOTELS: `${API_URL_SUFFIX}/get_hotels`,
  GET_PUBLICS: `${API_URL_SUFFIX}/get_publics`,
  GET_SETTLE_RECORD_LIST: `${API_URL_SUFFIX}/sum_record`,
  GET_TRADE_RECORD_LIST: `${API_URL_SUFFIX}/transaction_flow`,
  GET_TRADE_RECORD_SEARCH: `${API_URL_SUFFIX}/get_order_search`,
  LOAD_FINANCE_BILL: `${API_URL_SUFFIX}/financial`,
  GET_SPLIT_RULE_LIST: `${API_URL_SUFFIX}/split_rule`,
  CHANGE_SPLIT_STATUS: `${API_URL_SUFFIX}/change_split_status`,
  GET_SPLIT_DETAILS: `${API_URL_SUFFIX}/hotel_rule`,
  GET_SPLIT_RULE: `${API_URL_SUFFIX}/rule_detail`,
  PUT_SAVE_RULE: `${API_URL_SUFFIX}/save_rule`,
  GET_ADD_RULE: `${API_URL_SUFFIX}/rule_data`,
  GET_REFUND_LIST: `${API_URL_SUFFIX}/refund_list`,
  GET_MODULE: `${API_URL_SUFFIX}/get_module`,
  GET_BRANCH: `${API_URL_SUFFIX}/get_branch`,
  GET_REFUND_ORDER: `${API_URL_SUFFIX}/refund_order`,
  POST_REFUND: `${API_URL_SUFFIX}/send_refund`,
  GET_BANK_CHECK_ACCOUNT: `${API_URL_SUFFIX}/bank_check_account`,
  POST_CHECK_ACCOUNT: `${API_URL_SUFFIX}/check_account`,
  GET_CAPITAL_OVERVIEW: `${API_URL_SUFFIX}/capital_overview`,
  GET_CAPITAL_LIST: `${API_URL_SUFFIX}/capital_list`,
  GET_TRANSFER_ACCOUNTS: `${API_URL_SUFFIX}/transfer_accounts`,
  GET_SINGLE_SEND: `${API_URL_SUFFIX}/single_send`
}

export {
  v1
}
