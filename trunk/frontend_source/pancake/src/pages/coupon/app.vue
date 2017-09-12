<template>
  <div class="jfk-pages jfk-pages__coupon">
    <div class="jfk-pages__theme is-default"></div>
    <div class="coupon-box jfk-coupons jfk-ml-30 jfk-mt-30 jfk-mr-30">
      <ul class="jfk-coupons__list font-size--24" v-if="items.length">
        <li
          v-for="(item, index) in items"
          :key="item.prize_type">
          <div class="title font-color-white font-size--38">{{prizeNameMap[item.prize_type]}}</div>
          <div class="tip font-color-light-gray font-size-24">今日还可领取{{item.remain_num}}张</div>
          <div
            v-for="(val, idx) in item.coupon_list"
            :key="val.prize_id"
            class="jfk-coupons__box"
            @click="handlePickCoupon(index, idx)">
            <div class="jfk-coupons__item is-default" :class="couponItemClass(item, val)">
              <div class="jfk-coupons__money">
                <div class="jfk-coupons__money-cont jfk-flex is-align-middle is-justify-center">
                  <span class="color-golden jfk-coupons__money-num jfk-font icon-font_zh_jiang_qkbys"></span>
                </div>
              </div>
              <div class="jfk-coupons__cont">
                <div class="jfk-coupons__name font-color-white">{{val.content}}</div>
                <div class="jfk-coupons__scope font-color-light-gray">{{val.subtitle}}</div>
                <div class="jfk-coupons__expire font-color-light-gray">领取时间<br/>{{val.coupon_start_date}}至{{val.coupon_end_date}}</div>
              </div>
              <div class="jfk-coupons__status">
                <div class="jfk-radio jfk-radio--shape-circle color-golden" :class="radioClass(item, val)">
                  <label class="jfk-radio__label">
                    <span class="jfk-radio__icon">
                      <i class="jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"></i>
                    </span>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
      <div class="empty  font-color-light-gray" v-else>
        <div class="empty-cont">
          <div class="icon">
            <i class="jfk-font icon-blankpage_icon_noorder_bg"></i>
          </div>
          <div class="empty-tip font-size--24">暂无可领取奖品</div>
        </div>
      </div>
      <jfk-support v-once></jfk-support>
    </div>
    <footer class="coupon-footer jfk-clearfix">
      <div class="select  font-size--26 jfk-fl-l" @click="handleCheckAllCoupon">
        <div class="jfk-radio jfk-radio--shape-circle color-golden" :class="{'is-checked': couponAllChecked, 'is-disabled': !items.length}">
        <label class="jfk-radio__label">
          <span class="jfk-radio__icon">
            <i class="jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"></i>
          </span>
          <span class="jfk-radio__text" :class="{'font-color-white': items.length, 'font-color-light-gray': !items.length}">全选可领取的奖品</span>
        </label>
        </div>
      </div>
      <div @click="handleReceiveCoupons" class="control jfk-fl-l">
        <button :disabled="!items.length" class="jfk-button font-size--34 jfk-button--higher jfk-button--free jfk-button--primary">立即领取</button>
      </div>
    </footer>
    <jfk-popup
      class="jfk-popup__pancake is-qrcode"
      :showCloseButton="true"
      :onClose="qrcodeClose"
      v-model="qrcodeVisible">
      <div class="popup-cont">
        <div class="title font-color-white font-size--30 jfk-ta-c">您已成功领取奖品</div>
        <div class="cont font-color-light-gray font-size--24">
          <p class="tip">奖品已放至公众号下个人中心——我的优惠券进行查看，扫描下方二维码即可立即关注，获取更多优惠信息</p>
          <p class="jfk-ta-c"><img :src="qrcode"/></p>
        </div>
      </div>
    </jfk-popup>
    <jfk-popup
      class="jfk-popup__pancake"
      :showCloseButton="true"
      :onClose="handleIndex"
      v-model="rejectVisible">
      <div class="popup-cont">
        <div class="title font-color-white font-size--30 jfk-ta-c">您的残忍拒绝，让我很心痛</div>
        <div class="cont font-color-light-gray font-size--24">
          <p class="tip">未领取奖品您可在“个人战绩”内领取，期待下一次与您的再次相遇 ，祝您开心快乐每一天~</p> 
        </div>
        <div class="btns btns-1">
          <a href="javascript:;" @click="handleIndex" class="jfk-button jfk-button--primary is-plain jfk-button--free">再来一把</a>
        </div>
      </div>
    </jfk-popup>
    <jfk-popup
      class="jfk-popup__pancake"
      :onClose="handleIndex"
      v-model="successVisible">
      <i class="jfk-popup__close font-size--30 jfk-font icon-icon_close" @click="handleClose"></i>
      <div class="popup-cont">
        <div class="title font-color-white font-size--30 jfk-ta-c">您已成功领取奖品</div>
        <div class="cont font-color-light-gray font-size--24">
          <p class="tip">奖品已放至公众号下个人中心——我的优惠券进行查看，感谢您对我们一如既往的支持~</p> 
        </div>
        <div class="btns btns-2">
          <a href="javascript:;" @click="handleIndex" class="jfk-button jfk-button--primary is-plain jfk-button--free">再来一把</a>
          <a href="javascript:;" @click="handleUseCoupon" class="jfk-button jfk-button--primary jfk-button--free">马上使用</a>
        </div>
      </div>
    </jfk-popup>
  </div>
</template>
<script>
  let jfkConfig = window.jfkConfig
  if (process.env.NODE_ENV === 'development') {
    jfkConfig = {
      indexUrl: '/index',
      memberCenterUrl: 'javascript:;'
    }
  }
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { getPancakeGameCouponList, postPancakeGameReceivePrize } from '@/service/http'
  export default {
    name: 'pancake-coupons',
    beforeCreate () {
      let urlParams = formatUrlParams(location.href)
      this.actNum = urlParams.act_num || ''
      this.prizeType = urlParams.prize_type || ''
      this.prizeId = urlParams.prize_id || ''
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
    },
    created () {
      let vm = this
      getPancakeGameCouponList({
        act_num: this.actNum,
        prize_type: this.prizeType,
        prize_id: this.prizeId
      }).then(function (res) {
        vm.toast.close()
        const { list, follow_qrcode: qrcode, subscribe } = res.web_data
        let result = {}
        list.forEach(function (item, index) {
          result[item.prize_type] = {
            length: 0
          }
        })
        vm.items = list
        vm.couponChecked = Object.assign({}, vm.couponChecked, result)
        vm.subscribe = subscribe
        vm.qrcode = qrcode
        if (vm.prizeId) {
          vm.receiveCoupons([vm.prizeId])
        }
      }).catch(function () {
        vm.toast.close()
      })
    },
    data () {
      return {
        items: [],
        couponChecked: {},
        couponAllChecked: false,
        qrcodeVisible: false,
        rejectVisible: false,
        successVisible: false,
        subscribe: false,
        qrcode: '',
        prizeNameMap: {
          1: '一秀',
          2: '二举',
          3: '四进',
          4: '三红',
          5: '对堂',
          11: '四点红',
          12: '五子登科',
          13: '五红',
          14: '黑六勃',
          15: '遍地锦',
          16: '六杯红',
          18: '状元插金花'
        }
      }
    },
    methods: {
      handlePickCoupon (row, col) {
        let item = this.items[row]
        let c = this.couponChecked[item.prize_type]
        let citem = item.coupon_list[col]
        if (!c[citem.prize_id]) {
          if (c.length < item.remain_num) {
            this.couponChecked = Object.assign({}, this.couponChecked, {
              [item.prize_type]: {
                ...this.couponChecked[item.prize_type],
                length: c.length + 1,
                [citem.prize_id]: true
              }
            })
          }
        } else {
          this.couponChecked = Object.assign({}, this.couponChecked, {
            [item.prize_type]: {
              ...this.couponChecked[item.prize_type],
              length: c.length - 1,
              [citem.prize_id]: false
            }
          })
        }
      },
      checkedPrizeItem (list, limit, type) {
        let i = 0
        let len = list.length
        let checked = this.couponChecked[type]
        let result = Object.assign({}, checked)
        while (i < len) {
          let id = list[i].prize_id
          if (!checked[id]) {
            result[id] = true
            result.length = result.length + 1
            if (result.length >= limit) {
              return result
            }
          }
          i++
        }
        return result
      },
      receiveCoupons (ids) {
        let vm = this
        postPancakeGameReceivePrize(`act_num=${this.actNum}&prize_id=${ids.join(',')}&is_all_received=0`, {
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        }).then(function (res) {
          if (vm.subscribe) {
            vm.successVisible = true
          } else {
            vm.qrcodeVisible = true
          }
        }).catch(function (err) {
          // 部分领取成功，需要刷新当前页面
          if (err.status === 1002) {
            if (err.$msgbox) {
              err.$msgbox.then(function () {
                location.reload()
              })
            }
          }
          console.log(err)
        })
      },
      handleReceiveCoupons () {
        let vm = this
        if (!vm.items.length) {
          return
        }
        let checked = this.couponChecked
        let ids = []
        for (let i in checked) {
          let item = checked[i]
          for (let j in item) {
            if (j !== 'length' && item[j]) {
              ids.push(j)
            }
          }
        }
        if (ids.length) {
          vm.receiveCoupons(ids)
        } else {
          this.$jfkToast({
            iconType: 'error',
            message: '请选择要领取的奖品'
          })
        }
      },
      handleCheckAllCoupon () {
        if (!this.items.length) {
          return
        }
        let isChecked = this.couponAllChecked
        if (isChecked) {
          // 取消全部选择
          let result = {}
          this.items.forEach(function (item, index) {
            result[item.prize_type] = {
              length: 0
            }
          })
          this.$set(this, 'couponChecked', result)
        } else {
          let result = {}
          let checked = this.couponChecked
          let vm = this
          this.items.forEach(function (item, index) {
            let type = item.prize_type
            let limit = item.remain_num
            let checkedItem = checked[type]
            if (checkedItem.length < limit) {
              result[type] = vm.checkedPrizeItem(item.coupon_list, limit, type)
            }
          })
          this.couponChecked = Object.assign({}, this.couponChecked, result)
        }
        this.couponAllChecked = !isChecked
      },
      radioClass (prizeList, item) {
        let classes = []
        let type = prizeList.prize_type
        let limit = prizeList.remain_num
        let checked = this.couponChecked
        let id = item.prize_id
        let isChecked = checked[type][id]
        if (limit === 0 || (!isChecked && checked[type].length >= limit)) {
          classes.push('is-disabled')
        }
        if (isChecked) {
          classes.push('is-checked')
        }
        return classes.join(' ')
      },
      couponItemClass (prizeList, item) {
        let classes = []
        let type = prizeList.prize_type
        let limit = prizeList.remain_num
        let checked = this.couponChecked
        let id = item.prize_id
        let isChecked = checked[type][id]
        if (limit === 0 || (!isChecked && checked[type].length >= limit)) {
          classes.push('is-disabled')
        }
        return classes.join(' ')
      },
      qrcodeClose () {
        this.rejectVisible = true
      },
      handleClose () {
        location.reload()
      },
      handleIndex () {
        location.href = jfkConfig.indexUrl
      },
      handleUseCoupon () {
        if (process.env.NODE_ENV === 'development') {
          alert('个人中心')
        }
        location.href = jfkConfig.memberCenterUrl
      }
    }
  }
</script>
