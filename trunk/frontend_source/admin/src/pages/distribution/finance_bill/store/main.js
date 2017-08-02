import api from '@/service/distribution/http'

export default {
  state: {
    'normal': {
      'search': {
        'start_time': '',
        'end_time': ''
      }
    }
  },
  loadFinancialBill: function (a) {
    api.loadFinancialBill(a).then(function (res) {
      window.location.href = res.data.download_url
    })
  }
}
