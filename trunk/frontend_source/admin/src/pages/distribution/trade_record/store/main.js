import api from '@/service/distribution/http'
const end = new Date()
const start = new Date()
start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
export default {
  state: {
    'normal': {
      'page': {
        'start': 0,
        'end': 1,
        'total': 1,
        'current': 1,
        'page_size': 20,
        'page_total': 1
      },
      'search': {
        'date1': start,
        'date2': end,
        'inter_id': '',
        'hotel_id': '',
        'order_status': '',
        'module': '',
        'transfer_status': '',
        'order_no': '',
        'start_time': start.toJSON().substring(0, 10),
        'end_time': end.toJSON().substring(0, 10)
      }
    },
    publics: [],
    hotels: [],
    module: [],
    order_status: [],
    transfer_status: []
  },
  getRecordList: function (a) {
    api.getTradeRecordList(a).then(function (res) {
      this.state.normal.page = res.data.page
      this.state.list = res.data.list
      this.state.ext_data = res.data.url.ext_data
    }.bind(this))
  },
  getPublics: function () {
    api.getPublics().then(function (res) {
      this.state.publics = res.data
    }.bind(this))
  },
  getHotels: function (a) {
    api.getHotels(a).then(function (res) {
      this.state.hotels = res.data
    }.bind(this))
  },
  getSearch: function () {
    api.getTradeRecordSearch().then(function (res) {
      this.state.module = res.data.module
      this.state.order_status = res.data.order_status
      this.state.transfer_status = res.data.transfer_status
    }.bind(this))
  }
}
