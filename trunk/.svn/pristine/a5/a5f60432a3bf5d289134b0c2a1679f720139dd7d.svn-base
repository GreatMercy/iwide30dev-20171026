<template>
  <div class="gradient_bg">
  <section class="padding_0_15">
    <div class="iconfont center padding_top_48 main_color1"><font class="iconfont margin_right_7 font_13">&#xe643;</font><em class="iconfonts font_30">{{dataList.total_deposit}}</em></div>
    <div class="flex between centers font_12 margin_top_42">
      <a href="/depositcard"><div class="width_100 center relative border_1_808080 line_height_20 height_20 radius_3 margin_right_38 border_b2945e main_color1">马上充值</div></a>
      <div class="width_100 center relative border_1_808080 line_height_20 height_20 radius_3 color1 border_fff">设置支付密码</div>
    </div>
    <section>
      <div class="flex font_16 centers margin_top_42 bd_bottom padding_bottom_35 recharge color2">
        <div class="flex_1 center relative" @click="balance = true, dataList = rechargeList" :class="{ active: balance}">
          马上充值
          <span class="shadow_b"></span>
        </div>
        <div class="flex_1 center relative"  @click="balance = false, dataList = balanceList" :class="{ active: !balance}">
          消费记录
          <span class="shadow_b"></span>
        </div>
      </div>
      <section class="containers_list">
        <section v-show="balance">
          <div v-for="(value,key) in dataList.bonuslist"  class="flex between padding_30 bd_bottom">
            <div>
              <p class="font_16 width_210 txtclip">{{value.note}}</p>
              <p class="font_12 margin_top_18 color3">{{value.last_update_time}}</p>  
            </div>
            <div class="iconfont main_color1">
              <span v-if="value.log_type === 1">+</span><span v-else>-</span> &#xe643;<em class="iconfonts font_17 ">{{value.amount}}</em>
            </div>
          </div>
          <p v-show="dataList.bonuslist" class="center margin_top_18">暂无记录</p>
        </section>
        <section v-show="!balance">
          <div v-for="(value,key) in dataList.bonuslist" class="flex between padding_30 bd_bottom">
            <div>
              <p class="font_16 width_210 txtclip">{{value.note}}</p>
              <p class="font_12 margin_top_18 color3">{{value.last_update_time}}</p> 
            </div>
            <div class="iconfont main_color1">
              <span v-if="value.log_type === 1">+</span><span v-else>-</span> &#xe643;<em class="iconfonts font_17 ">{{value.amount}}</em>
            </div>
          </div>
          <p v-show="dataList.bonuslist" class="center margin_top_18">暂无记录</p>
        </section>
      </section>
    </section>
  </section>
</div>
</template>
<script>
import { getBalanceInfo } from '@/service/http'
export default {
  data () {
    return {
      dataList: [],
      rechargeList: [],
      balanceList: [],
      balance: true
    }
  },
  created () {
    getBalanceInfo({'credit_type': 1}).then((res) => {
      this.balanceList = res.web_data
    })
    getBalanceInfo({'credit_type': 2}).then((res) => {
      this.rechargeList = res.web_data
      this.dataList = this.rechargeList
    })
  },
  methods: {
  }
}
</script>
