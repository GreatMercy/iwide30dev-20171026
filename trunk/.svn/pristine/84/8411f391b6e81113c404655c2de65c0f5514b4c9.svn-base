<template>
  <div class="gradient_bg ">
    <section class="number_content padding_30">
      <div class="flex between font_18 centers color2 number_list ">
        <div @click="list = 1" class="flex_1 center relative" :class="{ active: list === 1}">
          未使用
          <span class="shadow_b"></span>
        </div>
        <div @click="list = 2" class="flex_1 center relative" :class="{ active: list === 2}">
          已使用
          <span class="shadow_b"></span>
        </div>
        <div @click="list = 3" class="flex_1 center relative" :class="{ active: list === 3}">
          已过期
          <span class="shadow_b"></span>
        </div>
      </div>
      <div v-show="list === 1" class="padding_0_15 margin_top_42">
        <div v-for='(value,key) in dataList.usableCardLists' class="coupon_rows border_radius layer_bg mar_b30">
          <a :href="value.cardinfo_url">
            <div class="coupon_img_wrap">
              <div class="select_coupon_bg gradient_radial_bg main_color1">
                <div v-if="value.card_type === '1'">
                  <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                  <span class="iconfonts select_coupon_money font_45">{{value.reduce_cost}}</span>
                </div>
                <div v-else-if="value.card_type === '2'" class="color_zhe">
                  <span class="iconfonts select_coupon_money font_45">{{value.discount}}</span>
                  <span class="font_22">折</span>
                </div>
                <div v-else-if="value.card_type === '3'" class="color_dui">
                  <span class="iconfonts select_coupon_money font_40">{{value.card_type_name}}</span>
                </div>
                <div v-else-if="value.card_type === '4'">
                  <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                  <span class="iconfonts select_coupon_money font_45">{{value.money}}</span>
                </div>
              </div>
              <div class="coupon_img_wrap_zhe"></div>
            </div>
            <div class="coupon_img_content">
              <p class="coupon_state">
                <span v-if="value.is_use === 't' && value.is_useofff === 't'" class="main_color1">已使用、已核销</span>
                <span v-else-if="value.is_use === 't' && value.is_useofff === 'f'">使用中</span>
                <span v-else-if="value.is_use === 't'" class="color3">已使用</span>
                <span v-else-if="value.is_useofff === 't'" class="color3">已核销</span>
              </p>
              <p class="color1 h32 mar_t60">{{value.title}}</p><p class="color3 h24">{{value.sub_title}}</p>
              <p class="color3 h24 mar_t60">{{value.use_time_start}} 至 {{value.use_time_end}}</p>
            </div>
          </a>
        </div>
        <p v-if="dataList.usableCardLists.length === 0 " class="center">没有未使用的卡券</p>
      </div>
      <div v-show="list === 2" class="padding_0_15 margin_top_42">
        <div v-for='(value,key) in dataList.unusedCardLists' class="coupon_rows border_radius layer_bg mar_b30">
          <div class="coupon_img_wrap">
            <div class="select_coupon_bg gradient_radial_bg main_color1">
              <div v-if="value.card_type === '1'">
                <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                <span class="iconfonts select_coupon_money font_45">{{value.reduce_cost}}</span>
              </div>
              <div v-else-if="value.card_type === '2'" class="color_zhe">
                <span class="iconfonts select_coupon_money font_45">{{value.discount}}</span>
                <span class="font_22">折</span>
              </div>
              <div v-else-if="value.card_type === '3'" class="color_dui">
                <span class="iconfonts select_coupon_money font_40">{{value.card_type_name}}</span>
              </div>
              <div v-else-if="value.card_type === '4'">
                <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                <span class="iconfonts select_coupon_money font_45">{{value.money}}</span>
              </div>
            </div>
            <div class="coupon_img_wrap_zhe"></div>
          </div>
          <div class="coupon_img_content">
            <p class="coupon_state">
                <span v-if="value.is_use === 't' && value.is_useofff === 't'" class="main_color1">已使用、已核销</span>
                <span v-else-if="value.is_use === 't' && value.is_useofff === 'f'">使用中</span>
                <span v-else-if="value.is_use === 't'" class="color3">已使用</span>
                <span v-else-if="value.is_useofff === 't'" class="color3">已核销</span>
              </p>
            <p class="color1 h32 mar_t60">{{value.title}}</p><p class="color3 h24">{{value.sub_title}}</p>
            <p class="color3 h24 mar_t60">{{value.use_time_start}} 至 {{value.use_time_end}}</p>
          </div>
        </div>
        <p v-if="dataList.unusedCardLists" class="center">没有已使用的卡券</p>
      </div>
      <div v-show="list === 3" class="padding_0_15 margin_top_42">
        <div v-for='(value,key) in dataList.expiredCardLists' class="coupon_rows border_radius layer_bg mar_b30">
          <div class="coupon_img_wrap">
            <div class="select_coupon_bg gradient_radial_bg color3">
              <div v-if="value.card_type === '1'">
                <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                <span class="iconfonts select_coupon_money font_45">{{value.reduce_cost}}</span>
              </div>
              <div v-else-if="value.card_type === '2'">
                <span class="iconfonts select_coupon_money font_45">{{value.discount}}</span>
                <span class="font_22">折</span>
              </div>
              <div v-else-if="value.card_type === '3'">
                <span class="select_coupon_money iconfonts font_40">{{value.card_type_name}}</span>
              </div>
              <div v-else-if="value.card_type === '4'">
                <span class="font_22 select_coupon_ico iconfonts">&#xFFE5;</span>
                <span class="iconfonts select_coupon_money font_45">{{value.money}}</span>
              </div>
            </div>
            <div class="coupon_img_wrap_zhe"></div>
          </div>
          <div class="coupon_img_content">
            <p class="coupon_state">
                <span class="color3">已使用</span>
            </p>
            <p class="color3 h32 mar_t60">{{value.title}}</p><p class="color3 h24">{{value.sub_title}}</p>
            <p class="color3 h24 mar_t60">{{value.use_time_start}} 至 {{value.use_time_end}}</p>
          </div>
        </div>
        <p v-if="dataList.expiredCardLists" class="center">没有已过期的卡券</p>
      </div>
    </section>
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
      for (let item in this.dataList.expiredCardLists) {
        this.dataList.expiredCardLists[item].use_time_start = formatDate(this.dataList.expiredCardLists[item].use_time_start, '.')
        this.dataList.expiredCardLists[item].use_time_end = formatDate(this.dataList.expiredCardLists[item].use_time_end, '.')
      }
      for (let item in this.dataList.usableCardLists) {
        this.dataList.usableCardLists[item].use_time_start = formatDate(this.dataList.usableCardLists[item].use_time_start, '.')
        this.dataList.usableCardLists[item].use_time_end = formatDate(this.dataList.usableCardLists[item].use_time_end, '.')
      }
      for (let item in this.dataList.unusedCardLists) {
        this.dataList.unusedCardLists[item].use_time_start = formatDate(this.dataList.unusedCardLists[item].use_time_start, '.')
        this.dataList.unusedCardLists[item].use_time_end = formatDate(this.dataList.unusedCardLists[item].use_time_end, '.')
      }
      console.log(this.dataList.expiredCardLists.length)
    })
  },
  methods: {
  }
}
</script>
