<template>
  <div class="gradient_bg">
    <section class="number_content">
      <div class="flex between font_16 centers color2 number_list pclight">
        <div @click="list = 1" class="flex_1 center relative" :class="{ active: list === 1}">
          未使用
          <span class="shadow_b"></span>
        </div>
        <span class="main_tab_line"></span>
        <div @click="list = 2" class="flex_1 center relative" :class="{ active: list === 2}">
          已使用
          <span class="shadow_b"></span>
        </div>
        <span class="main_tab_line"></span>
        <div @click="list = 3" class="flex_1 center relative" :class="{ active: list === 3}">
          已过期
          <span class="shadow_b"></span>
        </div>
      </div>
      <div v-show="list === 1" class="padding_0_15 margin_top_25">
        <div v-for='(value,key) in dataList.usableCardLists' class="coupon_rows border_radius layer_bg margin_bottom_15">
          <a :href="value.cardinfo_url">
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
                  <span class="iconfonts select_coupon_money font_40">{{value.card_type_name}}</span>
                </div>
                <div v-else-if="value.card_type === '4'"  class="gradient_gold_bg">
                  <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                  <span class="iconfonts select_coupon_money" :class="getNumberLength(value.money)">{{value.money}}</span>
                </div>
              </div>
              <div class="coupon_img_wrap_zhe"></div>
            </div>
            <div class="coupon_img_content">
              <p class="coupon_state font_14">
                <span v-if="value.is_valid === 'f'" class="color2"  :class="getTypeClass(value.card_type)">未生效</span>
              </p>
              <p class="color1 font_16 mar_t40 margin_bottom_10 font_spacing_4 pclight">{{value.title}}</p><p class="color3 font_12 cardword">{{value.sub_title}}</p>
              <p class="color3 font_12 mar_t10">{{value.use_time_start}} 至 {{value.expire_time}}</p>
            </div>
          </a>
        </div>
        <div v-if="dataList.usableCardLists.length === 0 " class="center font_14">
             <p class="jfk-font margin_top_50p emptyIcons">&#xe680;</p>
             <p class="emptyTitle margin_bottom_30p">没有未使用的卡券</p>
        </div>
      </div>
      <div v-show="list === 2" class="padding_0_15 margin_top_25">
        <div v-for='(value,key) in dataList.unusedCardLists' class="coupon_rows border_radius layer_bg margin_bottom_15">
          <div class="coupon_img_wrap">
            <div class="select_coupon_bg gradient_radial_bg" :class="{ 'main_color1': value.is_use === 't' && value.is_useofff === 't', 'main_color1': value.is_use === 't' && value.is_useofff === 'f', 'color3': value.is_use === 't' && value.is_useofff !== 'f','color3': is_useofff ==='t', 'color_dui': value.is_giving === 't'}">
              <div v-if="value.card_type === '1'" class="gradient_gold_bg">
                  <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                  <span class="iconfonts select_coupon_money" :class="getNumberLength(value.reduce_cost)">{{value.reduce_cost}}</span>
                </div>
                <div v-else-if="value.card_type === '2'" class="color_zhe gradient_blue_bg">
                  <span class="iconfonts select_coupon_money" :class="getNumberLength(value.discount)">{{value.discount}}</span>
                  <span class="font_19 jfk-font">折</span>
                </div>
                <div v-else-if="value.card_type === '3'" class="color_dui gradient_green_bg">
                  <span class="iconfonts select_coupon_money font_40">{{value.card_type_name}}</span>
                </div>
                <div v-else-if="value.card_type === '4'"  class="gradient_gold_bg">
                  <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                  <span class="iconfonts select_coupon_money"  :class="getNumberLength(value.money)">{{value.money}}</span>
                </div>
            </div>
            <div class="coupon_img_wrap_zhe"></div>
          </div>
          <div class="coupon_img_content">
            <p class="coupon_state font_14">
                <span v-if="value.is_use === 't' && value.is_useofff === 't'" class="main_color1" :class="getTypeClass(value.card_type)">已使用、已核销</span>
                <span v-else-if="value.is_use === 't' && value.is_useofff === 'f'" class="main_color1" :class="getTypeClass(value.card_type)">使用中</span>
                <span v-else-if="value.is_use === 't'" class="color3" :class="getTypeClass(value.card_type)">已使用</span>
                <span v-else-if="value.is_useofff === 't'" class="color3" :class="getTypeClass(value.card_type)">已核销</span>
                 <span v-else-if="value.is_giving === 't'" class="color_dui" :class="getTypeClass(value.card_type)">转赠中</span>
              </p>
            <p class="color1 font_16 mar_t40 margin_bottom_10 font_spacing_4 pclight">{{value.title}}</p><p class="color3 font_12 cardword">{{value.sub_title}}</p>
            <p class="color3 h24 mar_t10">{{value.use_time_start}} 至 {{value.expire_time}}</p>
          </div>
        </div>
        <div v-if="dataList.unusedCardLists.length === 0 " class="center font_14">
             <p class="jfk-font margin_top_50p emptyIcons">&#xe680;</p>
             <p class="emptyTitle margin_bottom_30p">没有已使用的卡券</p>
        </div>
      </div>
      <div v-show="list === 3" class="padding_0_15 margin_top_25">
        <div v-for='(value,key) in dataList.expiredCardLists' class="coupon_rows border_radius layer_bg margin_bottom_15">
          <div class="coupon_img_wrap">
            <div class="select_coupon_bg gradient_radial_bg color3">
              <div v-if="value.card_type === '1'" class="gradient_gray_bg">
                  <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                  <span class="iconfonts select_coupon_money" :class="getNumberLength(value.reduce_cost)">{{value.reduce_cost}}</span>
                </div>
                <div v-else-if="value.card_type === '2'" class="color_zhe gradient_gray_bg">
                  <span class="iconfonts select_coupon_money" :class="getNumberLength(value.discount)">{{value.discount}}</span>
                  <span class="font_19 jfk-font">折</span>
                </div>
                <div v-else-if="value.card_type === '3'" class="color_dui gradient_gray_bg">
                  <span class="iconfonts select_coupon_money font_40">{{value.card_type_name}}</span>
                </div>
                <div v-else-if="value.card_type === '4'"  class="gradient_gray_bg">
                  <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                  <span class="iconfonts select_coupon_money" :class="getNumberLength(value.money)">{{value.money}}</span>
                </div>
            </div>
            <div class="coupon_img_wrap_zhe"></div>
          </div>
          <div class="coupon_img_content">
            <p class="coupon_state font_14">
                <span class="color3">已过期</span>
            </p>
            <p class="color3 h32 mar_t40 margin_bottom_10 pclight font_spacing_4">{{value.title}}</p><p class="color3 font_12 cardword">{{value.sub_title}}</p>
            <p class="color3 h24 mar_t10">{{value.use_time_start}} 至 {{value.expire_time}}</p>
          </div>
        </div>
        <div v-if="dataList.expiredCardLists.length === 0 " class="center font_14">
             <p class="jfk-font margin_top_50p emptyIcons">&#xe680;</p>
             <p class="emptyTitle margin_bottom_30p">没有已过期的卡券</p>
        </div>
      </div>
    </section>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
import { getCardInfo } from '@/service/http'
import { formatDate } from '@/utils/utils'
export default {
  data () {
    return {
      dataList: [],
      list: 1
    }
  },
  created () {
    getCardInfo().then((res) => {
      this.dataList = res.web_data
      this.changeData()
    })
  },
  methods: {
    getNumberLength (val) {
      let couponLength = val.toString().length
      return 'coupon' + couponLength
    },
    getTypeClass (val) {
      return 'couponType' + val
    },
    changeData () {
      for (let item in this.dataList.expiredCardLists) {
        if (this.dataList.expiredCardLists[item].reduce_cost !== '') {
          this.dataList.expiredCardLists[item].reduce_cost *= 1
        }
        if (this.dataList.expiredCardLists[item].money !== '') {
          this.dataList.expiredCardLists[item].money *= 1
        }
        if (this.dataList.expiredCardLists[item].discount !== '') {
          this.dataList.expiredCardLists[item].discount *= 1
        }
        this.dataList.expiredCardLists[item].use_time_start = formatDate(this.dataList.expiredCardLists[item].use_time_start, '.')
        this.dataList.expiredCardLists[item].expire_time = formatDate(this.dataList.expiredCardLists[item].expire_time, '.')
      }
      for (let item in this.dataList.usableCardLists) {
        if (this.dataList.usableCardLists[item].reduce_cost !== '') {
          this.dataList.usableCardLists[item].reduce_cost *= 1
        }
        if (this.dataList.usableCardLists[item].money !== '') {
          this.dataList.usableCardLists[item].money *= 1
        }
        if (this.dataList.usableCardLists[item].discount !== '') {
          this.dataList.usableCardLists[item].discount *= 1
        }
        this.dataList.usableCardLists[item].use_time_start = formatDate(this.dataList.usableCardLists[item].use_time_start, '.')
        this.dataList.usableCardLists[item].expire_time = formatDate(this.dataList.usableCardLists[item].expire_time, '.')
      }
      for (let item in this.dataList.unusedCardLists) {
        if (this.dataList.unusedCardLists[item].reduce_cost !== '') {
          this.dataList.unusedCardLists[item].reduce_cost *= 1
        }
        if (this.dataList.unusedCardLists[item].money !== '') {
          this.dataList.unusedCardLists[item].money *= 1
        }
        if (this.dataList.unusedCardLists[item].discount !== '') {
          this.dataList.unusedCardLists[item].discount *= 1
        }
        this.dataList.unusedCardLists[item].use_time_start = formatDate(this.dataList.unusedCardLists[item].use_time_start, '.')
        this.dataList.unusedCardLists[item].expire_time = formatDate(this.dataList.unusedCardLists[item].expire_time, '.')
      }
    }
  }
}
</script>
