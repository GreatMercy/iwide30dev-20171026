<template>
  <div class="gradient_bg">
  <section class="padding_0_15 bg_show">
    <header class="padding_top_35">
      <div class="center main_color1">
        <p class="color3 font_12">支付金额</p>
<!--         <p class="margin_top_18"><font class="font_13 iconfont margin_right_7">&#xe643;</font><em class="iconfonts font_30">1415</em></p>
        <p class="color3 font_12 margin_top_45">您的储值：<em class="iconfont font_14">¥890</em></p> -->
      </div>
    </header>
    <div class="layer_bg radius_3 padding_45 mar_tb40">
      <div class="width_85 auto">
        <div class="font_12 color3">请输入支付密码</div>
        <div class="post_num margin_top_22 relative" id="payPwd">
            <input type="text" maxlength="6" @keyup="setPsw" class="pwd_input absolute" id="pwd_input">
          <ul class="flex pwd_list_input">
            <li class="flex_1" v-for="(value,key) in psw"><input :value="value" type="password" readonly=""></li>
          </ul>
        </div>
      </div>
      <div class="margin_top_35 font_17">
        <a class="block width_85 auto center padding_15 iconfont entry_btn">&#xe63d;&#xe63c;&#xe618;&#xe60c;</a>
      </div>
    </div>
    <section class="padding_bottom_77">
      <div class="font_12 padding_left_20">
        <p class="color2 relative"><em class="iconfont absolute prompt">&#xe642;</em>温馨提示</p>
        <p class="color3 margin_top_15 ">为了让支付更加安全便捷，请前往“会员中心>储值”页面 设置您的支付密码</p>
      </div>
    </section>
  </section>
</div>
</template>
<script>
import { getBalancePay } from '@/service/http'
import { formatUrlParams } from '@/utils/utils'
export default {
  data () {
    return {
      dataList: [],
      item: '',
      remark: '',
      sendType: '',
      money: '',
      inputmoney: '',
      posting: false,
      psw: new Array(6)
    }
  },
  created () {
    let params = formatUrlParams(location.search)
    let setdata = {'orderId': params.orderId}
    getBalancePay(setdata).then((res) => {
      this.dataList = res.web_data
    })
  },
  methods: {
    setPsw (event) {
      this.psw = new Array(6)
      for (let i = 0; i < event.target.value.length; i++) {
        this.psw[i] = event.target.value[i]
      }
    }
  }
}
</script>
