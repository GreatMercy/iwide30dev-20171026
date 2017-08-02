export default {
  table_loading: false, // 表格的loading
  express_dialog_visible: false, // dialog 的显示
  express_current_tabs: '0',
  express_providers: [],
  express_shipping_id: '',
  express_tabs: {
    '0': {
      csrf: {},
      status: '', // 当前的订单状态
      keyword: '', // 搜索的内容
      list: [], // 订单的列表
      begin_time: '', // 开始的时间
      end_time: '', // 结束的的时间
      page_num: 1, // 当前页码
      total: 0, // 总条数
      page_size: 20 // 一页多少条
    },
    '1': {
      csrf: {},
      status: '1', // 当前的订单状态
      keyword: '', // 搜索的内容
      list: [], // 订单的列表
      begin_time: '', // 开始的时间
      end_time: '', // 结束的的时间
      page_num: 1, // 当前页码
      total: 0, // 总条数
      page_size: 20 // 一页多少条
    },
    '2': {
      csrf: {},
      status: '2', // 当前的订单状态
      keyword: '', // 搜索的内容
      list: [], // 订单的列表
      begin_time: '', // 开始的时间
      end_time: '', // 结束的的时间
      page_num: 1, // 当前页码
      total: 0, // 总条数
      page_size: 20 // 一页多少条
    }
  }
}

