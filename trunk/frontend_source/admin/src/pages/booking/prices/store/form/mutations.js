/*
var data = {
  price_code: "23",//价格代码id
  inter_id: "a429262687",
  price_name: "代码名称",//代码名称
  channel_code: "Weixin",//渠道代码,没用
  edittime: "1495444843",
  status: "1",//状态1有效，2停用，3删除
  use_condition: {
    pre_pay: 0,
    no_pay_way: [//不使用的支付方式
      "balance",
      "weixin"
    ],
    pre_d: 1,//提前天数
    s_date_s: 20170501,//入住日期大于等于
    s_date_e: 20170531,//入住日期小于等于
    e_date_s: 20170517,//离店日期大于等于
    e_date_e: 20170531,//离店日期大于等于
    mxn: 2,//最大间数
    mxd: 2,//最大可定天数
    min_day: 1//最小可定天数
  },
  des: "代码描述",//代码描述
  sort: "1",//排序
  type: "common",//价格类型
  unlock_code: "",//协议代码
  related_code: "0",//关联代码
  related_cal_way: "divide",//计算公式
  related_cal_value: "0.00",//计算值
  must_date: "3",
  external_code: "",//对应PMS价格代码
  external_way: "1",
  add_service_set: null,
  coupon_condition: {//用券规则
    num_type: "order",//roomnight：每个间夜可用、order：每个订单可用
    coupon_num: 2,//可用多少张
    no_coupon: 0,//0可用，1不可用
    couprel: 1000183//关联的券id
  },
  bonus_condition: {
    no_part_bonus: 0,//积分兑换，0可用，1不可用
    poc: 0//积分与券，0可同时使用，1不可同时使用
  },
  time_condition: {
    book_time: {//时租房的时候显示
      s: "0100",//到店时间开始
      e: "2200",//到点时间段结束
      mod: 60//时间间隔，60：1小时；30：半小时
    }
  },
  bookpolicy_condition: {//预订政策
    breakfast_nums: "2",//早餐
    retain_time: {//保留时间
      balance: "18",
      weixin: "18",
      point: "18",
      weifutong: "18",
      unionpay: "18"
    },
    delay_time: {//退房时间
      balance: "12",
      weixin: "12",
      point: "12",
      weifutong: "12",
      unionpay: "12"
    },
    wxpay_favour: 1//微信支付立减多少元
  }
}
*/
import {
  CODE_INFO,
  CSRF,
  GET_HOTEL_ROOM_BY_CODE,
  UPDATE_HOTEL_NUM
} from '@/service/booking/types'
import { dateStrToStr1, timeStrToStr1 } from '@/utils/utils'

let isString = function (s) {
  return typeof s === 'string'
}
/* eslint-disable camelcase */
export default {
  [CSRF] (state, { csrf_token, csrf_value }) {
    state.csrfToken = csrf_token
    state.csrfValue = csrf_value
  },
  [CODE_INFO] (state, payload) {
    console.log(payload)
    for (let key in payload) {
      let val = payload[key]
      if (val !== undefined) {
        // time_comdition[预定时间相关]
        if (key === 'time_condition' && val) {
          let bookTimeStart = ''
          let bookTimeEnd = ''
          let bookTimeMod = ''
          if (val.book_time) {
            const { s = '', e = '', mod } = val.book_time
            bookTimeStart = timeStrToStr1(s)
            bookTimeEnd = timeStrToStr1(e)
            if (mod !== undefined) {
              bookTimeMod = '' + mod
            }
          }
          if (val.limit_weeks) {
            state.limitWeeks = val.limit_weeks
          }
          state.bookTimeStart = bookTimeStart
          state.bookTimeEnd = bookTimeEnd
          state.bookTimeMod = bookTimeMod
        } else if (key === 'goods_info' && val) { // 关联商品信息
          if (val.sale_way) {
            state.goodInfoSaleWay = Number(val.sale_way)
          }
          if (val.count_way) {
            state.goodInfoCountWay = Number(val.count_way)
          }
          if (val.items) {
            state.goodInfoItems = Object.assign({}, state.goodInfoItems, {items: val.items})
          }
          if (val.sale_notice !== undefined) {
            state.goodInfoSaleNotice = val.sale_notice
          }
        } else if (key === 'coupon_condition' && val) { // 用券规则
          console.log(val)
          if (val.num_type !== undefined) {
            state.couponNumType = val.num_type
          }
          if (val.coupon_num !== undefined) {
            console.log(val.coupon_num)
            state.couponNum = val.coupon_num
          }
          if (val.no_coupon !== undefined) {
            state.couponNoUse = val.no_coupon
          }
          if (val.couprel !== undefined) {
            state.couprel = '' + val.couprel
          }
          if (val.is_pms !== undefined) {
            state.couponIsPms = val.is_pms
          }
        } else if (key === 'bonus_condition' && val) {
          if (val.no_part_bonus !== undefined) {
            state.bonusNoPart = val.no_part_bonus
          }
          if (val.poc !== undefined) {
            state.bonusPoc = val.poc
          }
        } else if (key === 'use_condition' && val) {
          if (val.member_level) { // 会员等级
            state.memberLevel = String(val.member_level)
          }
          if (val.pre_pay !== undefined) {
            state.prePay = val.pre_pay
          }
          if (val.pre_d !== undefined) {
            state.preD = val.pre_d
          }
          if (val.s_date_s !== undefined) {
            let ss = dateStrToStr1('' + val.s_date_s)
            state.sDateS = ss
            state.sDateS1 = ss
          }
          if (val.s_date_e !== undefined) {
            let se = dateStrToStr1('' + val.s_date_e)
            state.sDateE = se
            state.sDateE1 = se
          }
          if (val.e_date_s !== undefined) {
            let es = dateStrToStr1('' + val.e_date_s)
            state.eDateS = es
            state.eDateS1 = es
          }
          if (val.e_date_e !== undefined) {
            let ee = dateStrToStr1('' + val.e_date_e)
            state.eDateE = ee
            state.eDateE1 = ee
          }
          if (val.mxn !== undefined) {
            state.mxn = val.mxn
          }
          if (val.mxd !== undefined) {
            state.mxd = val.mxd
          }
          if (val.min_day !== undefined) {
            state.minDay = val.min_day
          }
          if (val.package_only !== undefined) {
            state.packageOnly = val.package_only
          }
        } else if (key === 'bookpolicy_condition' && val) { // 预定政策
          if (val.breakfast_nums !== undefined) {
            state.breakfastNums = val.breakfast_nums
          }
          state.delay_time = Object.assign({}, val.delay_time)
          state.retain_time = Object.assign({}, val.retain_time)
          if (val.wxpay_favour !== undefined) {
            state.wxPayFavour = val.wxpay_favour
          }
          // 还有其余参数需要处理
        } else if (isString(val)) {
          state[key] = val.trim()
        } else {
          state[key] = val
        }
      }
    }
  },
  [GET_HOTEL_ROOM_BY_CODE] (state, hotels) {
    state.limitRoomChecked = Object.assign({}, state.limitRoomChecked, hotels)
  },
  [UPDATE_HOTEL_NUM] (state, { num, gs_id }) {
    const { items } = state.goodInfoItems
    if (items && items[gs_id]) {
      state.goodInfoItems.items = Object.assign({}, state.goodInfoItems.items, {
        [gs_id]: {
          ...items[gs_id],
          num: num
        }
      })
    } else if (process.env.NODE_ENV === 'development') {
      throw Error(`商品ID为${gs_id}的商品未被选中导致数据错误`)
    }
  }
}
