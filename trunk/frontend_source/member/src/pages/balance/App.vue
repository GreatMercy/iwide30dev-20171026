<template>
  <div class="gradient_bg white_bg">
  <section class="balance_pad">
    <div class="jfk-font center balance_header main_color1 gray_bg">
      <font class="jfk-font margin_right_fu font_23">&#xe643;</font>
      <em class="iconfonts font_30">{{dataList.total_deposit}}</em>
      <p class="color3 font_14 margin_top_15 jfk-main-name">账户{{dataList.filed_name.balance_name}}</p>
    </div>

   <!--  <div class="flex between centers font_12 mar_tb60">
      <a href=""><div class="width_100 center relative border_1_808080 line_height_20 height_20 radius_3 border_b2945e main_color1">马上充值</div></a>
      <a href="/balancesetpsw.html"><div class="width_100 center relative border_1_808080 line_height_20 height_20 radius_3 color1 border_fff">设置支付密码</div></a>
    </div> -->
    <section class="balance_content">
      <div class="flex font_16 centers bd_bottom padding_bottom_35 padding_top_15 recharge color2">
        <div class="flex_1 center relative balance_choose" @click="balance = true, dataList = balanceList" :class="{ active: balance}">
          <span class="relative padding_0_26 padding_bottom_5">
              充值记录
              <em class="shadow_b"></em>
          </span>
        </div>
        <div class="flex_1 center relative balance_choose"  @click="balance = false, dataList = rechargeList" :class="{ active: !balance}">
          <span class="relative padding_0_26 padding_bottom_5">
              消费记录
              <em class="shadow_b"></em>
          </span>
        </div>
      </div>
      <section class="containers_list">
        <section v-show="balance">
          <div v-for="(value,key) in balanceList.bonuslist"  class="flex between containers_list_wrap bd_bottom">
            <div>
              <p class="font_16 width_210 txtclip color1">{{value.note}}</p>
              <p class="font_12 margin_top_18 color3">{{value.last_update_time}}</p>  
            </div>
            <div class="main_color1">
              <span class="jj-ico" v-if="value.log_type === '1'">+</span><span class="jj-ico" v-else>-</span><em class="jfk-font font_19">&#xe643;</em><em class="iconfonts font_26">{{value.amount}}</em>
            </div>
          </div>
          <div v-show="balanceList.bonuslist.length === 0" class="center margin_top_18">
              <p class="jfk-font margin_top_75 emptyIcons">&#xe683;</p>
              <p class="emptyTitle">暂无记录</p>
          </div>
        </section>
        <section v-show="!balance">
          <div v-for="(value,key) in rechargeList.bonuslist" class="flex between containers_list_wrap bd_bottom">
            <div>
              <p class="font_16 width_210 txtclip color1">{{value.note}}</p>
              <p class="font_12 margin_top_18 color3">{{value.last_update_time}}</p> 
            </div>
            <div class="main_color1">
              <span class="jj-ico" v-if="value.log_type === '1'">+</span><span class="jj-ico" v-else>-</span><em class="jfk-font font_19">&#xe643;</em><em class="iconfonts font_26">{{value.amount}}</em>
            </div>
          </div>
          <div v-show="rechargeList.bonuslist.length === 0" class="center margin_top_18">
              <p class="jfk-font margin_top_75 emptyIcons">&#xe683;</p>
              <p class="emptyTitle">暂无记录</p>
          </div>
        </section>
      </section>
    </section>
  </section>
  <JfkSupport v-once></JfkSupport>
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
