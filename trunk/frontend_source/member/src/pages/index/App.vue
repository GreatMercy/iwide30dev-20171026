<template>
  <section class="gradient_bg search_bg">
    <div class="padding_0_15 white_search_bg">
      <section>
        <div class="banner padding_top_15">
          <div class="relative radius_5 overflow"  v-if="data.centerinfo.value === 'login'">
            <div v-if="data.member_status === 2 || data.member_status === 3">
              <a class="block jfk-login-box" :href="data.page_resource.links.login">
                  <div class="banner_img"></div>
                  <div class="banner_txt absolute l_t_0 flex between font_15">
                    <span class="block center flex_1 color1 font_spacing_1 font_14">马上成为会员，享受更多优惠！</span>
                      <span class="jfk-font main_color1 font_16 margin_right_8">登录/注册<em class="jfk-font font_16">&#xe61c;</em>
                      </span>
                  </div>
                </a>
              </div>
          </div>
        </div>
        <div v-if="data.member_status !== 4 || data.centerinfo.value !== 'login'" class="between padding_60 font_12 bd_bottom jfk-index-header">
          <div class="block flex jfk-index-flex">
            <div class="margin_right_30 relative padding_left_35">
              <div class="line_left absolute"><img src="../../styles/postcss/image/line_03.png" alt=""></div>
              <a class="block" :href="data.page_resource.links.perfectinfo">
                <div class="head_img" v-if="data.info">
                  <img v-if="data.info.headimgurl !== '' && data.info && data.info.headimgurl" alt="" :src="data.info.headimgurl">
                  <img v-else src="../../styles/postcss/image/head.png" alt="">
                </div>
                <div class="head_img" v-else>
                  <img src="../../styles/postcss/image/head.png" alt="">
                </div>
                <div class="margin_top_8 center relative jfk-index-name">
                  <em class="jfk-font font_19 bold absolute spot color_338b43">&#xe7b0;</em>
                  <span class="font_12 color1" v-if="data.centerinfo.lvl_name === '微信粉丝' || data.centerinfo.lvl_name === '微信会员' ">{{data.centerinfo.lvl_name}}</span>
                  <span v-else class="font_12 color1 pclight">{{data.centerinfo.lvl_name}}</span>
                </div>
              </a>
            </div>
            <div class="flex_1">
              <a class="block flex between jfk-index-flex" :href="data.page_resource.links.perfectinfo">
                <div>
                  <p class="font_19 mar_b10 jfk-index-nkname">
                     <span class="color1 font_spacing_2" v-if="data.centerinfo.name === '微信用户' || data.centerinfo.name === ''">{{data.centerinfo.nickname}}</span>
                     <span class="color1 font_spacing_2" v-else>{{data.centerinfo.name}}</span>
                  </p>
                  <p class="font_12 font_spacing_2 jfk-index-shipnum">{{data.centerinfo.membership_number}}</p>
                </div>
                <div class="jfk-index-ico" v-if="data.member_status === 1 || data.centerinfo.value !== 'login'">
                  <a :href="data.page_resource.links.perfectinfo">
                    <em class="jfk-font font_16 bold">&#xe61c;</em>
                  </a>  
                </div>
              </a>
              <a class="block margin_top_25 jfk-index-interests" href="javascript:;">
                  <!-- 查看会员权益<em class="jfk-font margin_left_8 font_17">&#xe61e;</em> -->
              </a>
            </div>
          </div>
        </div>
        <div class="pad_420 bd_bottom center"  v-if="data.member_status === 4 && data.centerinfo.value === 'login'">
          <p class="jfk-title-login">会员登录尽享优惠</p>
          <a :href="data.page_resource.links.wxlogin" class="block center index_button relative border_1"><em class="jfk-font font_19 margin_right_8">&#xe64f;</em><em class="jfk-font">微信登录</em></a>
          <a :href="data.page_resource.links.login" class="block center index_button2 color_fff bg_b2945e"><em class="jfk-font">会员登录/注册</em></a>
        </div>
      </section>
      <section class="flex index-wnum around font_12">
        <div class="flex_1 center">
          <a :href="data.assets_bottons.credit_name.link">
            <p>
              <span class="index-width"></span>
              <em class="jfk-font main_color1 margin_right_3 txt_show1 font_12">&#xe622;</em>
              <span class="color3 font_12 jfk-index-name">{{data.assets_bottons.credit_name.name}}</span>
              <span class="index-width"></span>
            </p>
            <p class="font_19 color1 margin_left_8 margin_top_4 jfk-index-num">
              <span v-if="data.centerinfo.value === 'login' &&  data.centerinfo.member_mode === 1 ">-</span>
              <span class="pclight" v-else>{{data.centerinfo.credit}}<em class="jfk-font margin_left_4 font_17 color2">&#xe61e;</em></span>
            </p>
          </a>
        </div>
        <div class="line_center"><img alt="" src="../../styles/postcss/image/line_04.png" /></div>
        <div class="flex_1 center">
          <a :href="data.assets_bottons.balance_name.link">
            <p>
              <span class="index-width"></span>
              <em class="jfk-font main_color1 margin_right_3 txt_show1 font_12">&#xe685;</em>
              <span class="color3 font_12 jfk-index-name">{{data.assets_bottons.balance_name.name}}</span>
              <span class="index-width"></span>
            </p>
            <p class="margin_left_8 margin_top_4 jfk-index-num"><span v-if="data.centerinfo.value === 'login' &&  data.centerinfo.member_mode === 1">-</span><span v-else class="font_19 color1"><em class="font_12">¥</em>{{data.centerinfo.balance}}<em class="jfk-font margin_left_4 font_17 color2">&#xe61e;</em></span>
            </p>
          </a>
        </div>
        <div class="line_center"><img alt="" src="../../styles/postcss/image/line_04.png" /></div>
        <div class="flex_1 center">
          <a :href="data.assets_bottons.coupon_name.link">
            <p>
              <span class="index-width"></span>
              <em class="jfk-font main_color1 margin_right_3 txt_show1 font_12">&#xe61f;</em>
              <span class="color3 font_12 jfk-index-name">{{data.assets_bottons.coupon_name.name}}</span>
              <span class="index-width"></span>
            </p>
            <p class="margin_left_8 margin_top_4 jfk-index-num"><span class="font_19 color1">{{data.centerinfo.card_count}}<em class="jfk-font margin_left_4 font_17 color2">&#xe61e;</em></span></p>
          </a>
        </div>
      </section>
    </div>
    <section class="flex padding_0_15">
      <a v-if="data.page_resource.links.shop" :href="data.page_resource.links.shop" class="block flex_1 center index_gradient radius_3 padding_30 box_shadow2">
        <em class="jfk-font txt_show2 font_16 jfk-big-ico">&#xe62b;</em>
        <span class="jfk-font color1 txt_show2 font_18">商城订单</span>
        <em class="jfk-font font_17 jfk-big-xiala">&#xe61e;</em>
      </a>
      <a v-if="data.page_resource.links.hotel" :href="data.page_resource.links.hotel" class="block flex_1 center index_gradient radius_3 padding_30 margin_left_15 box_shadow2">
        <em class="jfk-font txt_show2 font_17 jfk-big-ico">&#xe62d;</em>
        <span class="jfk-font color1 txt_show2 font_18">订房订单</span>
        <em class="jfk-font font_17 jfk-big-xiala">&#xe61e;</em>
      </a>
    </section>
    <section class="flex jfk-wrap-menu wrap margin_top_35 font_12 padding_0_15">
      <a v-for="(value,key) in menulist" class="block width_25" :href="value.link"> 
        <div class="flex column center padding_20">
          <p><em class="jfk-font font_28 color_fff" v-html="value.icon"></em></p>
          <div class="margin_top_13 color3 font_12 jfk-modelname">{{value.modelname}}</div>
        </div>
      </a>
    </section>
    <JfkSupport v-once></JfkSupport>
  </section>
</template>
<script>
import { getIndexInfo } from '@/service/http'
export default {
  data () {
    return {
      data: [],
      menulist: []
    }
  },
  created () {
    getIndexInfo().then((res) => {
      this.data = res.web_data
      if (this.data.centerinfo.nickname === '') {
        this.data.centerinfo.nickname = '微信用户'
      }
      for (let item in this.data.menu) {
        for (let inItem in this.data.menu[item]) {
          // if (this.data.member_status !== 1 && this.data.centerinfo.value === 'login') {
          //   this.data.menu[item][inItem].link = this.data.page_resource.links.login
          // }
          this.menulist.push(this.data.menu[item][inItem])
        }
      }
      // if (this.data.member_status !== 1 && this.data.centerinfo.value === 'login') {
      //   this.data.page_resource.links.perfectinfo = 'javascript:;'
      // }
    })
  },
  methods: {
  }
}
</script>
