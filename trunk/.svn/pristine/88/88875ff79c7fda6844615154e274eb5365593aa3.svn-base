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
        'hotel_id': '',
        'start_time': '',
        'end_time': ''
      }
    },
    publics: [],
    hotels: []
  },
  getSplitDetails: function (a) {
    api.getSplitDetails(a).then(function (res) {
      this.state.normal.page = res.data.page
      this.state.list = res.data.list
      this.state.ext_data = res.data.url.ext_data
      this.state.create = res.data.url.create
    }.bind(this))
  },
  getHotels: function (a) {
    api.getHotels(a).then(function (res) {
      this.state.hotels = res.data
    }.bind(this))
  }
}
