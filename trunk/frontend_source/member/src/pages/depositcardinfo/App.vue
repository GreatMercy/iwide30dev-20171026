<template>
<div class="gradient_bg pad_b60">
  <section class="padding_0_15 padding_top_25">
    <div class="padding_0_14 pad_b20">
      <div class="padding_0_9">
        <div class="radius_10 overflow ka relative">
          <!-- <img src="../../styles/postcss/image/platinum.jpg" alt=""> -->
          <img v-if="dataList.card.logo_url !== ''" :src="dataList.card.logo_url"  alt="">
          <!-- <div class="hotel_logo absolute"><img class="block" :src="dataList.card.logo_url" alt=""/></div> -->
        </div>
      </div>
    </div>
    <section class="font_16 mar_t40">
      <div class="overflow">
        <p class="float font_15 depoinfo-title">{{dataList.card.title}}</p>
        <p class="floatr main_color1 deposit-price">
          <em class="jfk-font font_19">&#xe643;</em>
          <span class="iconfonts font_25">{{dataList.card.money * 1}}</span>
        </p>
      </div>
      <p class="font_12 deposit-notice color3">{{dataList.card.notice}}</p>
      <div v-if="this.payNum !== 1">
        <div class="pad_t60">
          <div class="width_109 center relative auto color_fff">
            支付方式
            <span class="shadow_b" style="display:block"></span>
          </div>
        </div>
        <div class="flex pay_mode">
          <div v-for="(value,key) in dataList.pay_type" @click="payChoose(key)" class="layer_bg flex_1 center radius_3 pay_mode_item relative mar_lr10 white_bg" :class="{check_item: paytype === key }">
            <div class="check"><em></em></div>
            <div>
              <em v-if="key === 'balance'" class="jfk-font font_22">&#xe640;</em>
              <em v-else class="jfk-font font_22">&#xe64e;</em>
            </div>
            <div class="margin_top_15 relative">
                <font class="font_16 font_spacing_1 depo-pay-title">{{value}}</font>
                <font v-if="balanceBol && key === 'balance'" class="absolute balance font_12 center color3">余额不足</font>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="margin_top_50">
      <div class="font_12 padding_left_20">
        <p class="color2 relative"><em class="jfk-font absolute prompt cardinfo-word-ico">&#xe642;</em><span class="cardinfo-word-title">使用说明</span></p>
        <p class="color3 margin_top_15 cardinfo-word" v-html="dataList.card.description"></p>
      </div>
    </section>
  </section>
  <section class="flex layer_bg fixed_btn font_17 color_fff white_bg">
    <div class="flex_1 padding_left_30 depoinfo-total"><font class="font_13">¥ </font><em class="font_25">{{dataList.card.money * 1}}</em></div>
    <div class="jfk-font width_150 center main_bg1 padding_13 font_19" @click="submit()">&#xe63b;&#xe63a;&#xe639;&#xe638;</div>
  </section>
  <JfkSupport v-once></JfkSupport>
</div>
</template>
<script>
import { getDepositcardDetail, getBuyCard } from '@/service/http'
import { formatUrlParams } from '@/utils/utils'
export default {
  data () {
    return {
      dataList: [],
      paytype: '',
      balanceBol: false,
      payNum: 0
    }
  },
  created () {
    let params = formatUrlParams(location.search)
    let setdata = {'cardId': params.cardId}
    getDepositcardDetail(setdata).then((res) => {
      this.dataList = res.web_data
      this.payNum = 0
      for (let item in this.dataList.pay_type) {
        this.payNum++
        if (item === 'wechat') {
          this.paytype = 'wechat'
        } else if (this.payNum === 1) {
          this.paytype = item
        }
      }
      if (Number(this.dataList.extra.loginFlag.data.balance) < Number(this.dataList.card.money)) {
        this.balanceBol = true
      }
    })
  },
  methods: {
    payChoose (val) {
      if (val === 'balance' && this.balanceBol) return
      this.paytype = val
    },
    submit () {
      let data = {
        cardId: this.dataList.card.deposit_card_id,
        pay: this.paytype
      }
      getBuyCard(data).then((res) => {
        window.location.href = res.web_data.page_resource.links.redirect
      })
    }
  }
}
</script>
