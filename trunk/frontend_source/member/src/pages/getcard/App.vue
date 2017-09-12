<template>
  <div class="gradient_bg ">
    <section class="getcard_banner padding_30 padding_0_15">
      <div class="flex between font_18 centers color2 ">
        <img class="radius4" src="../../styles/postcss/image/getcard_logo.png" alt="">
      </div>
      <div class="between font_12 margin_top_43">
        <div class="margin_right_30 relative padding_left_35">
          <div class="line_left absolute"><img src="../../styles/postcss/image/line_03.png" alt=""></div>
        </div>
        <p v-if="dataList.card_info.is_package === 'f'" class="padding_left_35 padding_16 color_fff font_16 getcard-title">尊贵的会员，{{cardText}}{{dataList.card_info.title}}</p>
        <p v-else class="padding_left_35 padding_16 color_fff font_16 getcard-title">尊贵的会员，{{packageText}}{{dataList.card_info.name}}</p>
        <p class="padding_left_35 color3 font_spacing_2 font_12 getcard-word">马上领取享受更多的优惠</p>
      </div>
      <div class="margin_top_40" v-if="dataList.card_info.is_package === 'f'">
        <div class="pad_b40">
          <div class="coupon_rows border_radius layer_bg mar_b30">
            <a href="javascript:;">
              <div class="coupon_img_wrap">
                <div class="select_coupon_bg gradient_radial_bg main_color1">
                  <div v-if="dataList.card_info.card_type === '1'"  class="gradient_gold_bg">
                    <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                    <span class="iconfonts select_coupon_money" :class="getNumberLength(dataList.card_info.reduce_cost)">{{dataList.card_info.reduce_cost}}</span>
                  </div>
                  <div v-else-if="dataList.card_info.card_type === '2'" class="color_zhe gradient_blue_bg">
                    <span class="iconfonts select_coupon_money font_40" :class="getNumberLength(dataList.card_info.discount)">{{dataList.card_info.discount}}</span>
                    <span class="font_19 jfk-font">折</span>
                  </div>
                  <div v-else-if="dataList.card_info.card_type === '3'" class="color_dui gradient_green_bg">
                    <span class="iconfonts select_coupon_money font_40">兑</span>
                  </div>
                  <div v-else-if="dataList.card_info.card_type === '4'"  class="gradient_gold_bg">
                    <span class="font_22 select_coupon_ico iconfonts" :class="getNumberLength(dataList.card_info.money)">&#xFFE5;</span>
                    <span class="iconfonts select_coupon_money font_40">{{dataList.card_info.money}}</span>
                  </div>
                </div>
                <div class="coupon_img_wrap_zhe"></div>
              </div>
              <div class="coupon_img_content">
                <p class="color1 font_16 mar_t40 mar_b10 font_spacing_2">{{dataList.card_info.title}}</p>
                <p class="color3 h24 cardword font_13">有限期至 {{dataList.card_info.time_end}}</p>
                <p class="h24">
                  <span class="color3 inblock  getcard-ctitle">数量 :</span><span class="color2 getcard-cnum"> {{dataList.card_info.count_num}}张</span>
                </p>
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="margin_top_40" v-else>
        <div class="center font_14 mar_b50 lint_title color3">礼包内容</div>
        <div>
          <div v-if="dataList.card_info.lvl_name" class="flex bg_202020 pad_l80 radius_3 getcard-rows">
             <p class="jfk-font txt_show1 main_color1 font_19">&#xe69f;</p>
             <p class="flex_1 mar_l20 color3 font_16">会员等级</p>
             <p class="color1 font_22 flex_1 iconfonts txt_show2 getcard-num">{{dataList.card_info.lvl_name}}</p>
          </div>
          <div v-if="dataList.card_info.credit && dataList.card_info.credit !== '0'  && dataList.card_info.credit !== '0.00'" class="flex bg_202020 pad_l80 radius_3 getcard-rows">
             <p class="jfk-font txt_show1 main_color1 font_17">&#xe622;</p>
             <p class="flex_1 mar_l20 color3 font_16">会员{{dataList.filed_name.credit_name}}</p>
             <p class="color1 font_22 flex_1 iconfonts txt_show2 getcard-num">{{dataList.card_info.credit}}</p>
          </div>
          <div v-if="dataList.card_info.deposit && dataList.card_info.deposit !== '0'  && dataList.card_info.deposit !== '0.00'" class="flex bg_202020 pad_l80 radius_3 getcard-rows">
             <p class="jfk-font txt_show1 main_color1 font_19">&#xe62e;</p>
             <p class="flex_1 mar_l20 color3 font_16">会员{{dataList.filed_name.balance_name}}</p>
             <p class="color1 font_20 flex_1 iconfonts txt_show2 getcard-num"><span class="iconfonts font_14">&#xFFE5; </span><span class="font_22 iconfonts">{{dataList.card_info.deposit}}</span></p>
          </div>
        </div>
        <div class="pad_b40">
          <div v-for='(value,key) in dataList.card_info.card' class="coupon_rows border_radius layer_bg mar_b30">
            <a href="javascript:;">
              <div class="coupon_img_wrap">
                <div class="select_coupon_bg main_color1">
                  <div v-if="value.card_type === '1'" class="gradient_gold_bg">
                    <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                    <span class="iconfonts select_coupon_money" :class="getNumberLength(value.reduce_cost)">{{value.reduce_cost}}</span>
                  </div>
                  <div v-else-if="value.card_type === '2'" class="color_zhe gradient_blue_bg">
                    <span class="iconfonts select_coupon_money" :class="getNumberLength(value.discount)">{{value.discount}}</span>
                    <span class="font_19 jfk-font">折</span>
                  </div>
                  <div v-else-if="value.card_type === '3'" class="color_dui gradient_green_bg">
                    <span class="iconfonts select_coupon_money font_40">兑</span>
                  </div>
                  <div v-else-if="value.card_type === '4'" class="gradient_gold_bg">
                    <span class="font_20 select_coupon_ico iconfonts">&#xFFE5;</span>
                    <span class="iconfonts select_coupon_money" :class="getNumberLength(value.money)">{{value.money}}</span>
                  </div>
                </div>
                <div class="coupon_img_wrap_zhe"></div>
              </div>
              <div class="coupon_img_content">
                <p class="color1 font_16 mar_t40 mar_b10 font_spacing_2">{{value.title}}</p>
                <p class="color3 h24 cardword font_13">{{value.sub_title}}</p>
                <p class="h24">
                  <span class="color3 inblock  getcard-ctitle">数量 :</span><span class="color2 getcard-cnum"> {{value.number}}张</span>
                </p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>
    <section  v-if="dataList.card_info.is_package === 'f'" class="flex layer_bg fixed_btn font_17 color_fff">
      <div v-if="dataList.card_info.frequency <= dataList.gain_count" class="center main_bg1 padding_13" style="width:100%;"><a class="main_bg1" :href="dataList.page_resource.links.cardcenter_url">马上查看</a></div>
      <div v-else @click="addcard" class="center main_bg1 padding_13" style="width:100%;">马上领取</div>
    </section>
    <section v-else class="flex layer_bg fixed_btn font_17 color_fff">
    <div v-if="dataList.card_info.frequency <= dataList.gain_count" class="center main_bg1 padding_13" style="width:100%;"><a  class="main_bg1" :href="dataList.page_resource.links.cardcenter_url">马上查看</a></div>
      <div v-else @click="package" class="center main_bg1 padding_13" style="width:100%;">马上领取</div>
    </section>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
import { JfkMessageBox } from 'jfk-ui'
import { getCardReceive, postPackage, postAddcard } from '@/service/http'
import { formatUrlParams, formatDate } from '@/utils/utils'
export default {
  data () {
    return {
      dataList: [],
      list: 1,
      packageText: '您获得了',
      cardText: '您获得了一张'
    }
  },
  created () {
    let params = formatUrlParams(location.search)
    let setdata = {'card_rule_id': params.card_rule_id}
    getCardReceive(setdata).then((res) => {
      this.dataList = res.web_data
      if (this.dataList.card_info.length !== 0) {
        this.dataList.card_info.discount *= 1
        this.dataList.card_info.reduce_cost *= 1
        this.dataList.card_info.time_start = formatDate(this.dataList.card_info.time_start, '.')
        this.dataList.card_info.time_end = formatDate(this.dataList.card_info.time_end, '.')
      } else {
        JfkMessageBox.alert(this.dataList.err_msg, '', {
          iconType: 'error'
        }).then((res) => {
          window.location.href = this.dataList.page_resource.links.center_url
        })
      }
      this.dataList.card_info.frequency = Number(this.dataList.card_info.frequency)
      this.dataList.gain_count = Number(this.dataList.gain_count)
      if (this.dataList.card_info.frequency <= this.dataList.gain_count) {
        this.cardText = '您已领取了'
        this.packageText = '您已领取了'
      }
      for (let item in this.dataList.card_info.card) {
        if (this.dataList.card_info.card[item].discount !== '') {
          this.dataList.card_info.card[item].discount *= 1
        }
        if (this.dataList.card_info.card[item].reduce_cost !== '') {
          this.dataList.card_info.card[item].reduce_cost *= 1
        }
        this.dataList.card_info.card[item].time_start = formatDate(this.dataList.card_info.card[item].time_start, '.')
        this.dataList.card_info.card[item].time_end = formatDate(this.dataList.card_info.card[item].time_end, '.')
      }
    })
  },
  methods: {
    addcard () {
      let setDate = {
        card_rule_id: this.dataList.card_rule_id
      }
      postAddcard(setDate).then((res) => {
        if (res.status === 1000) {
          JfkMessageBox.alert('领取成功', '', {
            iconType: 'success'
          }).then(() => {
            window.location.href = res.web_data.page_resource.links.cardcenter_url
          })
        } else {
          JfkMessageBox.alert(res.msg, '', {
            iconType: 'error'
          })
        }
      })
    },
    package () {
      let setDate = {
        package_id: this.dataList.card_info.package_id,
        card_rule_id: this.dataList.card_rule_id,
        frequency: this.dataList.card_info.frequency
      }
      postPackage(setDate).then((res) => {
        if (res.status === 1000) {
          JfkMessageBox.alert('领取成功', '', {
            iconType: 'success'
          }).then(() => {
            window.location.href = res.web_data.page_resource.links.cardcenter_url
          })
        } else {
          JfkMessageBox.alert(res.msg, '', {
            iconType: 'error'
          })
        }
      })
    },
    getNumberLength (val) {
      let couponLength = val.toString().length
      return 'coupon' + couponLength
    }
  }
}
</script>
