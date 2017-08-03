import { getCouponList } from '@/service/user/http'
export default {
  state: {
    csrf_token: '',
    csrf_value: '',
    content: {},
    data: [],
    page_resource: {
      count: 0,
      page: 0,
      size: 0,
      links: {}
    },
    loading: true
  },
  getDetail (data) {
    this.state.loading = true
    getCouponList(data).then(function (res) {
      if (res.status === 1000) {
        let json = res.web_data
        this.state.csrf_token = json.csrf_token
        this.state.csrf_value = json.csrf_value
        let arr = []
        for (let item in json.data) {
          // json.data[item][9] = item
          arr.push(json.data[item])
          if (json.data[item][4].length > 15) {
            json.data[item][4] = json.data[item][4].substring(0, 15) + '...'
          }
        }
        this.state.data = arr
        this.state.page_resource = json.page_resource
        this.state.loading = false
      } else {
        alert(res.msg)
      }
    }.bind(this))
  }
}