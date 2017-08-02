<template>
  <div class="gradient_bg">
  <section class="padding_0_15">
    <p class="center padding_top_48">储 值</p>
    <div class="iconfont center main_color1 mar_t40"><font class="iconfont margin_right_7 font_19">&#xe643;</font><em class="iconfonts font_30">{{dataList.total_deposit}}</em></div>
    <p class="padding_top_48 font_14">{{remark}}</p>
    <p class="font_14 color3 mar_t40">储值充值</p>
    <div>
      <div class="condition h30 color1 mar_t40 center">
        <div v-for="(value,key) in dataList.deposit_list" @click="chooseMoney(key,value.remark)" :class="{active:item === key}"><p><em class="font_14">¥</em><em class="font_17">{{value.money}}</em></p><span class="iconfonts main_color1 h48">&#xE031;</span></div>
      </div>
    </div>
    <div class="flex form_item bd_top bd_bottom padding_18 mar_t40">
      <div class="margin_right_42 width_120"><div class="flex between">
        <span class="block font_17">其他金额</span></div></div>
        <div class="flex_1 font_14"><input type="number" v-model="inputmoney" name="money" @click="item='',remark='',sendType=1" placeholder="输入其他金额(充值上限10000元)"></div>
    </div>
  </section>
  <section class="flex layer_bg fixed_btn font_17 color_fff">
    <div class="iconfont center main_bg1 padding_17" @click="submit()" style="width:100%;">{{postText}}</div>
  </section>
</div>
</template>
<script>
import { getBuydepositInfo, postDepositOrder } from '@/service/http'
export default {
  data () {
    return {
      dataList: [],
      item: '',
      remark: '',
      sendType: '',
      money: '',
      inputmoney: '',
      posting: false
    }
  },
  created () {
    getBuydepositInfo().then((res) => {
      this.dataList = res.web_data
    })
  },
  methods: {
    submit () {
      if (this.posting) return
      if (this.sendType === 0) {
        this.money = this.dataList.deposit_list[this.item].money
      } else {
        this.money = this.inputmoney
      }

      if (this.money === '' || this.money === 0) {
        alert('请输入金额!')
      } else if (this.money > 10000) {
        alert('充值金额不能大于10000')
      } else {
        let data = {
          depositId: this.sendType === 0 ? this.dataList.deposit_list[this.item].deposit_card_id : 0,
          depositMoney: this.sendType === 0 ? this.money : 0,
          money: this.money
        }
        this.posting = true
        postDepositOrder(data).then((res) => {
          if (res.status === 1000) {
            window.location.href = res.web_data.page_resource.links.next
          } else {
            alert(res.msg)
            this.posting = false
          }
        })
      }
    },
    chooseMoney (val, str) {
      this.item = val
      this.remark = str
      this.sendType = 0
    }
  },
  computed: {
    postText () {
      return `${this.posting ? '充值中...' : '立即充值'}`
    }
  }
}
</script>
