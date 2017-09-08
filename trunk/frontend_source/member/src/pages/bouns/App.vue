<template>
  <div class="gradient_bg white_bg">
  <section class="balance_pad">
    <div class="center balance_header main_color1">
        <em class="iconfonts font_30">{{dataList.total_credit}}</em>
        <p class="color3 font_14 margin_top_15">账户{{dataList.filed_name.credit_name}}</p>
    </div>
    <section class="balance_content">
      <div class="flex font_16 centers bd_bottom padding_bottom_35 recharge color2 padding_top_15">
        <div class="flex_1 center relative balance_choose" @click="bouns = true, dataList = bounsList" :class="{ active: bouns}">
          <span class="relative padding_0_26 padding_bottom_5">
              获取记录
              <em class="shadow_b"></em>
          </span>
        </div>
        <div class="flex_1 center relative balance_choose"  @click="bouns = false, dataList = rechargeList" :class="{ active: !bouns}">
          <span class="relative padding_0_26 padding_bottom_5">
              消费记录
              <em class="shadow_b"></em>
          </span>
        </div>
      </div>
      <section class="containers_list">
        <section v-show="bouns">
          <div v-for="(value,key) in bounsList.bonuslist"  class="flex between containers_list_wrap bd_bottom">
            <div>
              <p class="font_16 width_210 txtclip color1">{{value.note}}</p>
              <p class="font_12 margin_top_18 color3">{{value.last_update_time}}</p>  
            </div>
            <div class="jfk-font main_color1">
              <span class="jj-ico" v-if="value.log_type === '1'">+</span><span class="jj-ico" v-else>-</span> <em class="iconfonts font_25"> {{value.amount}}</em>
            </div>
          </div>
          <div v-show="bounsList.bonuslist.length === 0" class="center margin_top_18">
              <p class="jfk-font margin_top_75 emptyIcons">&#xe683;</p>
              <p class="emptyTitle">暂无记录</p>
          </div>
        </section>
        <section v-show="!bouns">
          <div v-for="(value,key) in rechargeList.bonuslist" class="flex between containers_list_wrap bd_bottom">
            <div>
              <p class="font_16 width_210 txtclip color1">{{value.note}}</p>
              <p class="font_12 margin_top_18 color3">{{value.last_update_time}}</p> 
            </div>
            <div class="jfk-font main_color1">
              <span class="jj-ico" v-if="value.log_type === '1'">+</span><span class="jj-ico" v-else>-</span> <em class="iconfonts font_25"> {{value.amount}}</em>
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
import { getBonusInfo } from '@/service/http'
export default {
  data () {
    return {
      dataList: [],
      rechargeList: [],
      bounsList: [],
      bouns: true
    }
  },
  created () {
    getBonusInfo({'credit_type': 1}).then((res) => {
      this.bounsList = res.web_data
      this.dataList = this.bounsList
    })
    getBonusInfo({'credit_type': 2}).then((res) => {
      this.rechargeList = res.web_data
    })
  },
  methods: {
  }
}
</script>
