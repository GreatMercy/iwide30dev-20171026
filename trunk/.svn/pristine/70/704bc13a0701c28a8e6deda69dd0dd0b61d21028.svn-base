import {
  CODE_CONFIG
} from '@/service/booking/types'
/* eslint-disable camelcase */
export default {
  [CODE_CONFIG] (state, {
    enum_des,
    price_codes,
    bf_fields,
    levels,
    pay_ways,
    coupon_types
  }) {
    if (levels) {
      // 添加不关联选项
      levels['-1'] = '不关联'
    }
    if (coupon_types) {
      coupon_types['-1'] = {
        card_id: '-1',
        title: '不关联'
      }
    }
    price_codes = price_codes || {}
    // 价格代码添加不关联选项
    price_codes[0] = {
      price_code: '0',
      price_name: '不关联'
    }
    state.confCodeType = Object.assign({}, state.confCodeType, enum_des.HOTEL_PRICE_CODE_TYPE)
    state.confCodeStatus = Object.assign({}, enum_des.HOTEL_PRICE_CODE_STATUS)
    state.confCodeCalWay = Object.assign({}, enum_des.HOTEL_PRICE_CODE_RELATED_CAL_WAY)
    state.confPackagePaymentSupport = Object.assign({}, enum_des.PACKAGE_PAYMENT_SUPPORT)
    state.confMemberLevels = Object.assign({}, state.confMemberLevels, levels)
    state.confBfFields = bf_fields
    state.confPriceCodes = price_codes
    state.confPayWays = Object.assign({}, state.confPayWays, pay_ways)
    state.confCouponTypes = Object.assign({}, state.confCouponTypes, coupon_types)
  }
}
