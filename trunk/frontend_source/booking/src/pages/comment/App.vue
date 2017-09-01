<template>
  <div class="jfk-pages jfk-pages__comment">
    <div class="jfk-pages__theme"></div>
    <div class="choose_prt_top">
      <p class="choose_prt_top_item1 font-size--30" v-if="allData != ''">
        {{allData.order.first_detail.roomname}}
      </p>
      <p class="choose_prt_top_item2 font-size--24 grayColorbf" v-if="allData != ''">
        {{allData.order.first_detail.hname}}
      </p>
      <p class="choose_prt_top_item3 font-size--24 grayColorbf">
        <span v-if="allData != ''">入住{{allData.order.first_detail.startdate}}</span>
        <span v-if="allData != ''">离开{{allData.order.first_detail.enddate}}</span>
        <span>共2晚</span>
      </p>
    </div>
    <!-- 评分容器 -->
    <div class="star_container">
      <div class="star_title">
        酒店评分
      </div>
      <div class="star_list" v-if="allData != ''">
        <p class="star_list_item">
          <span class="star_list_item_name">{{allData.comment_config.clean_score}}</span>
          <jfk-rater
            v-model="value0"
            :font-size="24"
            :margin="20"
            :disabled="false"
            :value="value0">
          </jfk-rater>
        </p>
        <p class="star_list_item">
          <span class="star_list_item_name">{{allData.comment_config.facilities_score}}</span>
          <jfk-rater
            :margin="20"
            v-model="value1"
            :disabled="false"
            :value="value1">
          </jfk-rater>
        </p>
        <p class="star_list_item">
          <span class="star_list_item_name">{{allData.comment_config.net_score}}</span>
          <jfk-rater
            :margin="20"
            v-model="value2"
            :disabled="false"
            :value="value2">
          </jfk-rater>
        </p>
        <p class="star_list_item">
          <span class="star_list_item_name">{{allData.comment_config.service_score}}</span>
          <jfk-rater
            :margin="20"
            v-model="value3"
            :disabled="false"
            :value="value3">
          </jfk-rater>
        </p>
      </div>
    </div>
    <div class="trip_type jfk-pl-30 jfk-pr-30 font-size--30">
      <p class="title">出游类型</p>
      <ul>
        <li>商务出差</li>
      </ul>
    </div>
    <div class="comment_input jfk-pl-30 jfk-pr-30">
        <p class="title">发表评价</p>
        <textarea name="comment_content" id="comment_content" v-model="comment_input_value" :placeholder="placeholderVal" class="font-size--30"></textarea>
        <span class="word_num">
          <span class="real_num">{{comment_input_value.length}}</span>/200
        </span>
    </div>
    <div class="upload_file jfk-pl-30 jfk-pr-30">
      <ul>
         <li>
          <span class="add_container">
            <i class="booking_icon_font font-size--28 icon-booking_icon_addpictures_normal"></i>
            <span class="word">添加图片</span>
            <input type="file" class="file_input">
            <span class="img_con">
              <img src="https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/w%3D268%3Bg%3D0/sign=a15086bc31adcbef01347900949449e0/aec379310a55b3199a363d0d43a98226cefc17fe.jpg" alt="">
              <i class="booking_icon_font font-size--34 icon-mall_icon_orderDetail_delete"></i>
            </span>
          </span>
        </li>
        <li>
          <span class="add_container">
            <i class="booking_icon_font font-size--28 icon-booking_icon_addpictures_normal"></i>
            <span class="word">添加图片</span>
            <!--<input type="file" class="file_input">-->
            <span class="img_con" v-show="false">
              <img src="https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/w%3D268%3Bg%3D0/sign=a15086bc31adcbef01347900949449e0/aec379310a55b3199a363d0d43a98226cefc17fe.jpg" alt="">
              <i class="booking_icon_font font-size--34 icon-mall_icon_orderDetail_delete"></i>
            </span>
          </span>
        </li>
      </ul>
      <div class="submit_comment">
       <p>
          <i class="booking_icon_font font-size--34 icon-font_zh_li_qkbys"></i>
          <i class="booking_icon_font font-size--34 icon-font_zh_ji_qkbys"></i>
          <i class="booking_icon_font font-size--34 icon-font_zh_ping_qkbys"></i>
          <i class="booking_icon_font font-size--34 icon-font_zh_jia__qkbys"></i>
       </p>
      </div>
    </div>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
import { getCommentOrderDetail } from '@/service/http'
export default {
  name: 'comment',
  components: {
  },
  created () {
    this.getOrderDetail()
  },
  beforeCreate () {
  },
  data () {
    return {
      value0: 5,
      value1: 5,
      value2: 5,
      value3: 5,
      placeholderVal: '亲~ 住的舒服吗?服务满意吗?',
      locationParams: [],
      allData: [],
      page_resource: [],
      comment_input_value: ''
    }
  },
  methods: {
    getOrderDetail () {
      this.locationParams = formatUrlParams(location.href)
      let _self = this
      let loading
      loading = _self.$jfkToast({
        iconClass: 'jfk-loading__snake ',
        duration: -1,
        isLoading: true
      })
      let args = {
        oid: _self.locationParams.oid,
        id: _self.locationParams.id
      }
      getCommentOrderDetail(args).then(function (res) {
        console.log(res)
        _self.allData = res.web_data
        _self.allData.order.first_detail.startdate = _self.setDay(_self.allData.order.first_detail.startdate)
        _self.allData.order.first_detail.enddate = _self.setDay(_self.allData.order.first_detail.enddate)
        if (loading) {
          loading.close()
        }
      }).catch(function (e) {
        console.log(e)
      })
    },
    // 截取字符串
    setDay (val) {
      let str = val.substring(4, 6)
      let str1 = val.substring(6)
      return str + '/' + str1
    }
  }
}
</script>
