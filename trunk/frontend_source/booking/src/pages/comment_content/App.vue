<template>
  <div class="jfk-pages jfk-pages__commentContent">
    <div class="jfk-pages__theme"></div>
    <div class="comment_top">
      <div class="container">
        <p class="score">
          <i class="jfk-font-number jfk-price__number font-size--80">4</i>
          <i class="jfk-font-number jfk-price__number font-size--64">.9</i>
          <span class="jfk-font-number jfk-price__number font-size--38">分</span>
        </p>
        <jfk-rater :disabled="true" :value="3.4"></jfk-rater>
        <div class="pregress_list">
          <div class="pregress_item font-size--24">
            <span class="name">设&nbsp&nbsp施&nbsp&nbsp</span>
            <div class="pregress">
              <span class="bar" style="width: 80%"></span>&nbsp&nbsp
              <span class="grayColor80">5.0</span>
            </div>
          </div>
          <div class="pregress_item font-size--24">
            <span class="name">卫&nbsp&nbsp生&nbsp&nbsp</span>
            <div class="pregress">
              <span class="bar" style="width: 40%"></span>&nbsp&nbsp
              <span class="grayColor80">5.0</span>
            </div>
          </div>
          <div class="pregress_item font-size--24">
            <span class="name">服&nbsp&nbsp务&nbsp&nbsp</span>
            <div class="pregress">
              <span class="bar" style="width: 30%"></span>&nbsp&nbsp
              <span class="grayColor80">5.0</span>
            </div>
          </div>
          <div class="pregress_item font-size--24">
            <span class="name">网&nbsp&nbsp络&nbsp&nbsp</span>
            <div class="pregress">
              <span class="bar" style="width: 30%"></span>&nbsp&nbsp
              <span class="grayColor80">5.0</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="talk">
      <p class="title font-size--24 grayColor80">
        大家都在说
      </p>
      <ul>
        <li class="active font-size--24">全部全部（403）</li>
        <li class="font-size--24">全部（403）</li>
        <li class="font-size--24 bad">全部（403）</li>
      </ul>
    </div>
    <div class="content jfk-pl-30 jfk-pr-30">
      <div class="contitle_info">
        <img
          src="https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/w%3D268%3Bg%3D0/sign=a15086bc31adcbef01347900949449e0/aec379310a55b3199a363d0d43a98226cefc17fe.jpg"
          alt="" class="head_img">
        <span class="name font-size--28 grayColor80">懒茶</span>
        <span class="date font-size--24 grayColorbf">2018.09.09</span>
        <span class="score grayColor66">
          <span class="font-size--28">4.</span><span class="font-size--24 grayColor66">9</span><span
          class="font-size--18 score-text">分</span>
        </span>
      </div>
      <p class="comment font-size--28 font-size--24">
        上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三
      </p>
      <p class="show_all goldColor font-size--28">展开全文</p>
      <div class="file">
        <city-swiper :items="recommendations" :linkPrefix="detailUrl" :emptyLink="indexUrl"></city-swiper>
      </div>
      <p class="check_repeat font-size--28 grayColor80">
        <span>收起酒店回复</span>
        <i class="booking_icon_font font-size--24 icon-booking_icon_up_normal grayColorbf show_icon"></i>
      </p>
      <swiper class="jfk-swiper">
        <swiper-slide class="category__item">
          <span class="category__label font-size--32"></span>
        </swiper-slide>
      </swiper>
      <div class="repeat_content font-size--28">
        <div><span class="hotel_name grayColor80">酒店回复：</span>哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈
        </div>
      </div>
    </div>
    <button class="booking_now font-size--34">
      立 即 预 定
    </button>
    <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
  import {getCommentComment} from '@/service/http'

  export default {
    created () {
      // 获取酒店id
      this.hotel_id = this.getUrlParams('h')
      // 获取评论数据
      this.getCommentData()
    },
    data () {
      return {
        hotel_id: 0
      }
    },
    methods: {
      // 获取酒店评论
      getCommentData () {
        getCommentComment().then((res) => {

        })
      },
      // 获取url 参数
      getUrlParams (urlName) {
        let url = location.href
        let paraString = url.substring(url.indexOf('?') + 1, url.length).split('&')
        let returnValue
        for (let i = 0; i < paraString.length; i++) {
          let tempParas = paraString[i].split('=')[0]
          let parasValue = paraString[i].split('=')[1]
          if (tempParas === urlName) returnValue = parasValue
        }
        if (typeof (returnValue) === 'undefined') {
          return ''
        } else {
          return returnValue
        }
      }
    }
  }
</script>
