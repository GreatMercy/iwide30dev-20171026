import api from '@/service/distribution/http'
export default {
  state: {
    'hotel': [{
      'hotel_id': '',
      'hotel_name': '',
      'status': '1'
    }],
    'module': [{
      'value': '',
      'name': '',
      'status': ''
    }],
    'module2': [],
    'form': [{
      'choice': '',
      'module': '',
      'regular_jfk_cost': '',
      'regular_jfk': '',
      'regular_group': '',
      'regular_hotel': '',
      'regular_dist': '',
      'select': {
        regular_jfk_cost: '1',
        regular_jfk: '1',
        regular_group: '1',
        regular_hotel: '1',
        regular_dist: '4'
      }
    }],
    'inter_id': '',
    'hotel_id': '',
    'inter_name': '',
    'rule_id': ''
  },
  getAddRule: function (a, callback) {
    api.getAddRule(a).then(function (res) {
      this.state.hotel = res.data.hotel
      this.state.inter_name = res.data.rule.inter_name
    }.bind(this))
  },
  putSaveRule: function (res, callback, callback2) {
    api.putSaveRule(res).then(function (res) {
      callback(res)
    }).catch(function (res) {
      callback2(res)
    })
  },
  getModule: function (res) {
    api.getModule(res).then(function (res) {
      this.state.module = res.data
      for (let i in res.data) {
        if (res.data[i].status === '1') {
          this.state.module2.push({
            status: '1'
          })
        } else {
          this.state.module2.push({
            status: '0'
          })
        }
      }
    }.bind(this))
  }
}
