// api v1版本
let API_URL_SUFFIX = '/index.php/iwidepay/IwidepayApi'

const v1 = {
  GET_REFUND_ORDER: `${API_URL_SUFFIX}/refund_order`,
  POST_REFUND: `${API_URL_SUFFIX}/send_refund`,
  GET_PUBLICS: `${API_URL_SUFFIX}/get_publics`,
  GET_HOTELS: `${API_URL_SUFFIX}/get_hotels`,
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
