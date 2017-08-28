<template>
  <div class="gradient_bg padding_30 padding_0_15">
    <div class="layer_bg radius_3 padding_20 padding_0_15 overflow mar_b30" v-if="dataList.public">
      <img :src="dataList.public.logo" class="card_logo">
      <p class="card_name font_14">{{dataList.public.name}}</p>
    </div>
    <div class="between font_12">
        <div class="margin_right_30 relative padding_left_35">
          <div class="line_left absolute"><img src="../../assets/image/line_03.png" alt=""></div>
        </div>
        <p class="padding_0_20 padding_18 color_fff font_19">{{dataList.card_info.title}}</p>
        <p class="padding_0_20 mar_b20">{{dataList.card_info.notice}}</p>
        <p class="padding_0_20 color1" v-if="dataList.card_info.is_giving === 't' && dataList.card_info.member_info_id !== dataList.gift_mem_info.member_info_id">
          <span v-if="dataList.gift_mem_info.name">您的好友{{dataList.gift_mem_info.name}}赠送你一张</span>
          <span v-else>您的好友{{dataList.card_info.nickname}}赠送你一张</span>
          <span v-if="dataList.card_info.card_type === '3'">兑换券</span>
          <span v-else>优惠券</span>
        </p>
        <p class="padding_0_20 color1" v-if="dataList.card_info.is_giving === 't'">转赠中</p>
      </div>
      <div class="mar_t40 pad_t40 pad_b80">
        <p class="mar_t20">
          <span class="h26 width_75 inblock">使用场景</span>
          <span class="h30 color1" v-if="dataList.card_info.is_online === '1'">仅线上可用</span>
          <span class="h30 color1" v-else>仅线下可用</span>
        </p>
        <p class="mar_t20">
          <span class="h26 width_75 inblock">使用方式</span>
          <span class="h30 color1">{{dataList.card_info.use_way}}</span>
        </p>
        <p class="mar_t20">
          <span class="h26 width_75 inblock">券&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码</span>
          <span class="h30 color1">{{dataList.card_info.coupon_code}}</span>
        </p>
        <p class="mar_t20">
          <span class="h26 width_75 inblock">使用期限</span>
          <span class="h30 color1">{{time}}</span>
        </p>
        <p class="mar_t20">
          <span class="h26 width_75 inblock">使用说明</span>
          <p class="h30 color1 font_14" v-html="dataList.card_info.description"></p>
        </p>
      </div>
      <div  v-if="dataList.can_received === 1" @click="getcoupon" class="block center btn_height auto jfk-font entry_btn" style="width:80%;">
        {{postText}}
      </div>
      <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
import { JfkMessageBox } from 'jfk-ui'
import { formatDate } from '@/utils/utils'
import ajax from '@/utils/http'
export default {
  data () {
    return {
      dataList: [],
      getBol: true,
      time: ''
    }
  },
  created () {
    let url = window.URL
    if (url) {
      ajax.get(url).then((res) => {
        this.dataList = res.web_data
        this.time = formatDate(this.dataList.card_info.time_start, '.') + ' - ' + formatDate(this.dataList.card_info.time_end, '.')
      })
    } else {
      JfkMessageBox.alert('暂无数据', '', {
        iconType: 'error'
      })
    }
  },
  methods: {
    getcoupon () {
      if (this.getBol) {
        this.getBol = false
        this.getcouponAjax().then((res) => {
          if (res.status === 1000) {
            JfkMessageBox.alert('领取成功', '', {
              iconType: 'success'
            }).then(() => {
              window.location.href = res.web_data.page_resource.links.cardcenter_url
            })
          } else {
            this.getBol = true
            JfkMessageBox.alert(res.msg, '', {
              iconType: 'error'
            })
          }
        })
      }
    },
    getcouponAjax () {
      let postUrl = this.dataList.page_resource.links.iapi.receive_card_url
      let setdata = {
        ec_code: this.dataList.ec_code
      }
      return ajax.post(postUrl, setdata)
    }
  },
  computed: {
    postText () {
      return `${this.getBol ? '立即领取' : '领取中...'}`
    }
  }
}
</script>
