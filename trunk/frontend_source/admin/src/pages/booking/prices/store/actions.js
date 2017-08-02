import {
  GET_PRICE_INFO,
  CODE_CONFIG,
  CODE_INFO,
  CSRF,
  UPDATE_LOADING
} from '@/service/booking/types'
import { getHotelPriceCode } from '@/service/booking/http'
import { omitKeys } from '@/utils/utils'

export default {
  [GET_PRICE_INFO] ({
    commit,
    state
  }, params) {
    commit(UPDATE_LOADING, { loading: true })
    getHotelPriceCode(params).then(function (res) {
      const { list, csrf_token, csrf_value, price_codes, enum_des, bf_fields, levels, pay_ways, coupon_types, is_pms: isPms } = res.web_data
      const {
        price_code: priceCode,
        price_name: priceName,
        type,
        related_code: relatedCode,
        des,
        detail,
        related_cal_value,
        related_cal_way: relatedCalWay,
        is_packages: isPackages,
        status,
        sort,
        unlock_code: unlockCode,
        goods_info,
        time_condition,
        use_condition,
        bookpolicy_condition,
        coupon_condition,
        external_code: externalCode,
        all_rooms: allRooms,
        inter_id: interId
      } = list
      commit('config/' + CODE_CONFIG, { enum_des, price_codes, bf_fields, levels, pay_ways, coupon_types })
      commit('form/' + CSRF, { csrf_token, csrf_value })
      let relatedCalValue = Number(related_cal_value) || 0
       /* eslint-disable camelcase */
      let payWays = []
      let payWayIsAllChecked = false
      if (pay_ways) {
        let noPayWays = use_condition && use_condition.no_pay_way || []
        payWays = omitKeys(noPayWays, pay_ways)
        payWayIsAllChecked = Object.keys(pay_ways).length === payWays.length
      }
      commit('form/' + CODE_INFO, {
        priceCode,
        priceName,
        type,
        relatedCode,
        des,
        detail,
        relatedCalWay,
        relatedCalValue,
        isPackages,
        status,
        sort,
        unlockCode,
        goods_info,
        time_condition,
        use_condition,
        bookpolicy_condition,
        payWays,
        payWayIsAllChecked,
        lastUpdated: Date.now(),
        externalCode,
        isPms,
        allRooms,
        interId,
        coupon_condition
      })
      commit(UPDATE_LOADING, { loading: false })
    }).catch(function (err) {
      commit(UPDATE_LOADING, { loading: false })
      let href
      try {
        href = err.web_data.page_resource.links.next
      } catch (e) {
        href = '/'
      }
      err.$msgbox && err.$msgbox.then(function (action) {
        err.$msgbox = null
        if (process.env.NODE_ENV === 'development') {
          location.href = '/'
          return
        }
        location.href = href
        return
      })
    })
  }
}
