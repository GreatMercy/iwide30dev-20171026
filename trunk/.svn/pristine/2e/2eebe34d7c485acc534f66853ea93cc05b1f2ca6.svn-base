import { getCouponDetail } from '@/service/user/http'
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
    openbol: false,
    loading: true,
    tableloading: false
  },
  getDetail (data) {
    this.state.tableloading = true
    this.state.openbol = false
    getCouponDetail(data).then(function (res) {
      if (res.status === 1000) {
        let json = res.web_data
        let openid = ''
        this.state.csrf_token = json.csrf_token
        this.state.csrf_value = json.csrf_value
        let arr = []
        for (let item in json.data) {
          arr.push(json.data[item])
          openid = json.data[item][4]
          if (openid !== '') {
            openid = openid.substring(0, 5) + '*****' + openid.substring(openid.length - 5, openid.length)
            this.state.openbol = true
          }
          json.data[item][4] = openid
        }
        this.state.data = arr
        this.state.content = json.content
        this.state.page_resource = json.page_resource
        this.state.loading = false
        this.state.tableloading = false
      } else {
        alert(res.msg)
      }
    }.bind(this))
  }
}
