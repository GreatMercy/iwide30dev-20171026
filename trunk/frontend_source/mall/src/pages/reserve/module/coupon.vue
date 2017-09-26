<template>
  <div class="jfk-coupons jfk-pl-30 jfk-pr-30">
    <ul class="jfk-coupons__list font-size--24 jfk-pt-30">
      <li
        class="jfk-coupons__box"
        v-for="item in items"
        :key="item.member_card_id"
        :title="item.title">
        <div class="jfk-coupons__item" @click="handlePickCoupon(item.member_card_id, item.usable)" :class="{'is-disabled': !item.usable, 'is-exchange': item.card_type === '3', 'is-offset': item.card_type === '1', 'is-discount': item.card_type === '2'}">
          <div class="jfk-coupons__money">
            <div class="jfk-coupons__money-cont jfk-flex is-align-middle is-justify-center">
              <span class="jfk-coupons__money-num jfk-font icon-font_zh_dui_qkbys" v-if="item.card_type === '3'"></span>
              <span class="jfk-coupons__money-num" v-else-if="item.card_type === '2'">
                <i class="jfk-font-number jfk-coupons__money-number">{{item.discount}}</i>
                <i class="jfk-font jfk-coupons__money-unit icon-font_zh_zhe_qkbys"></i>
              </span>
              <span class="jfk-coupons__money-num color-golden" :class="'jfk-coupons__money-num--length-' + item.reduce_cost.length" v-else-if="item.card_type === '1'">
                <i class="jfk-coupons__money-currency jfk-font-number">￥</i>
                <i class="jfk-coupons__money-number jfk-font-number">{{item.reduce_cost}}</i>
              </span>
            </div>
          </div>
          <div class="jfk-coupons__cont">
            <div class="jfk-coupons__name font-color-white">{{item.title}}</div>
            <div class="jfk-coupons__scope font-color-light-gray-common">{{item.scopeType}}</div>
            <div class="jfk-coupons__expire font-color-light-gray-common">{{item.expire_time}}</div>
          </div>
          <div class="jfk-coupons__status">
            <span class="jfk-radio jfk-radio--shape-circle color-golden" :class="{'is-checked': item.member_card_id === cid}" v-show="item.usable">
              <label class="jfk-radio__label">
                <span class="jfk-radio__icon"><i class="jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"></i></span>
              </label>
            </span>
            <span class="jfk-coupons__status-text color-golden" v-show="!item.usable">不可用</span>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
  export default {
    name: 'jfk-coupons',
    data () {
      return {
        cid: this.couponId
      }
    },
    props: {
      items: {
        type: Array,
        required: true,
        default: function () {
          return []
        }
      },
      couponId: String
    },
    watch: {
      couponId (val) {
        this.cid = val
      }
    },
    methods: {
      handlePickCoupon (cid, usable) {
        if (!usable) {
          return
        }
        if (this.cid === cid) {
          this.cid = '-1'
        } else {
          this.cid = cid
        }
        this.$emit('coupon-picked', this.cid)
      }
    }
  }
</script>
