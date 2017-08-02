import api from '@/service/distribution/http'

export default {
  state: {
    'data': {
      'page': {
        'start': 0,
        'end': 1,
        'total': 1,
        'current': 1,
        'page_size': 20,
        'page_total': 1
      }
    }
  },
  getList: function (par) {
    api.getBankAccountList(par).then(function (res) {
      this.state.data = res.data
    }.bind(this))
  },
  deleteAccount: function (id, callback) {
    api.deleteAccount(id).then(function () {
      callback()
    })
  }
}
