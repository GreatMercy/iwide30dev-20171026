import api from '@/service/distribution/http'

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
        'date1': '',
        'date2': '',
        'inter_id': '',
        'hotel_id': ''
      }
    },
    publics: [],
    hotels: []
  },
  getSplitRuleList: function (a) {
    api.getSplitRuleList(a).then(function (res) {
      this.state.normal.page = res.data.page
      this.state.list = res.data.list
      this.state.exportData = res.data.url.ext_data
    }.bind(this))
  },
  getPublics: function () {
    api.getPublics().then(function (res) {
      this.state.publics = res.data
    }.bind(this))
  },
  changeSplitStatus: function (a, callback) {
    api.changeSplitStatus(a).then(function (res) {
      callback(res)
    })
  }
}
