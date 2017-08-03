import api from '@/service/distribution/http'

export default {
  state: {
    'data': {
      'bank': {
        'id': '',
        'inter_id': '',
        'hotel_id': '',
        'type': '',
        'branch_id': '',
        'bank_user_name': '',
        'account_aliases': '',
        'bank_card_no': '',
        'bank_city': '',
        'bank_code': '',
        'status': '',
        'is_company': ''
      },
      'type': [],
      'hotels': [],
      'publics': [],
      'citys': [],
      'banks': [],
      'bank_type': []
    }
  },
  getBankAccountInfo: function (id, callback, callback2) {
    api.getBankAccountInfo(id).then(function (res) {
      this.state.data = res.data
      if (res.data.bank === '') {
        this.state.data.bank = {
          'id': '',
          'inter_id': '',
          'hotel_id': '',
          'type': '',
          'branch_id': '',
          'bank_user_name': '',
          'account_aliases': '',
          'bank_card_no': '',
          'bank_city': '',
          'bank_code': '',
          'status': '',
          'is_company': ''
        }
      }
      callback(res)
    }.bind(this)).catch(function () {
      callback2()
    })
  },
  editBankAccountInfo: function (par, callback, callback2) {
    api.editBankAccountInfo(par).then(function (res) {
      callback(res)
    }).catch(function (res) {
      callback2(res)
    })
  },
  addBankAccountInfo: function (par, callback, callback2) {
    api.addBankAccountInfo(par, {headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).then(function (res) {
      callback(res)
    }).catch(function (res) {
      callback2(res)
    })
  },
  getHotels: function (interid, callback, callback2) {
    api.getHotels(interid).then(function (res) {
      callback(res)
      this.state.data.hotels = res.data
    }.bind(this)).catch(function () {
      callback2()
    })
  },
  getBranch: function (str, callback, callback2) {
    api.getBranch(str).then(function (res) {
      callback(res)
      this.state.data.banks = res.data.list
    }.bind(this)).catch(function () {
      callback2()
    })
  }
}