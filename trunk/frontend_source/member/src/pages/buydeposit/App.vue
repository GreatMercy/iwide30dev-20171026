<template>
  <div class="gradient_bg">
  <section class="padding_0_15 bg_show">
    <p class="center padding_top_48 font_14 buydeposit-title">{{dataList.filed_name.balance_name}}</p>
    <div class="jfk-font center main_color1 margin_top_20"><font class="jfk-font font_25">&#xe643;</font><em class="iconfonts font_30 font_spacing_1">{{dataList.total_deposit}}</em></div>
    <p class="padding_top_78 font_14 color1 mar_l40">{{remark}}</p>
    <p class="font_14 color3 mar_t40">{{dataList.filed_name.balance_name}}充值</p>
    <div>
      <div class="condition h30 color1 mar_t40 txt_l">
        <div v-for="(value,key) in dataList.deposit_list" @click="chooseMoney(key,value.remark)" :class="{active:item === key}"><p><em class="font_15 margin_right_2 pclight">¥</em><em class="font_21 pclight">{{value.money}}</em></p><span class="iconfonts main_color1 h48">&#xE031;</span></div>
      </div>
    </div>
    <div class="flex form_item buydeposit-input bd_top bd_bottom margin_top_20 white_bg">
      <div class="margin_right_23 width_130"><div class="flex between">
        <span class="block font_15">其他金额</span></div></div>
        <div class="flex_1 font_14"><input type="number" class="color1 font_16" v-model="inputmoney" name="money" @click="item='',remark='',sendType=1" placeholder="输入其他金额(充值上限10000元)"></div>
    </div>
  </section>
  <section class="flex layer_bg fixed_btn font_17 color_fff">
    <div class="jfk-font center main_bg1 padding_14" @click="submit()" style="width:100%;">立即充值</div>
  </section>
  <JfkSupport v-once></JfkSupport>
</div>
</template>
<script>
import { JfkMessageBox } from 'jfk-ui'
import { getBuydepositInfo, postDepositOrder } from '@/service/http'
export default {
  data () {
    return {
      dataList: [],
      item: 0,
      remark: '',
      sendType: 0,
      money: '',
      inputmoney: ''
    }
  },
  created () {
    getBuydepositInfo().then((res) => {
      this.dataList = res.web_data
      if (this.dataList.page_resource.links.redirect) {
        window.location.replace(res.web_data.page_resource.links.redirect)
      }
      for (let item in this.dataList.deposit_list) {
        this.dataList.deposit_list[item].money *= 1
      }
      this.remark = this.dataList.deposit_list[0].remark
    })
  },
  methods: {
    submit () {
      if (this.sendType === 0) {
        this.money = this.dataList.deposit_list[this.item].money
      } else {
        this.money = this.inputmoney
      }

      if (this.money === '' || this.money === 0) {
        JfkMessageBox.alert('请输入金额', '', {
          iconType: 'error'
        })
      } else if (this.money <= 0) {
        JfkMessageBox.alert('充值金额不能小于或等于0', '', {
          iconType: 'error'
        })
      } else if (this.sendType === 1 && this.money % 10 !== 0) {
        JfkMessageBox.alert('充值金额只能为10的整数倍', '', {
          iconType: 'error'
        })
      } else {
        let data = {
          depositId: this.sendType === 0 ? this.dataList.deposit_list[this.item].deposit_card_id : 0,
          depositMoney: this.sendType === 0 ? this.money : 0,
          money: this.money
        }
        if (this.toast) {
          this.toast.close()
        }
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        postDepositOrder(data).then((res) => {
          this.toast.close()
          if (res.status === 1000) {
            window.location.href = res.web_data.page_resource.links.next
          } else {
            JfkMessageBox.alert(res.msg, '', {
              iconType: 'error'
            })
          }
        })
      }
    },
    chooseMoney (val, str) {
      this.item = val
      this.remark = str
      this.sendType = 0
    }
  }
}
</script>
