<template>
  <div class="jfk-pages jfk-pages__commentContent">
    <div class="jfk-pages__theme"></div>
    <div class="comment_top">
      <div class="container">
        <p class="score">
          <i class="jfk-font-number jfk-price__number font-size--108">{{intNum}}</i>
          <i>.</i>
          <i class="jfk-font-number jfk-price__number font-size--88">{{pointNum}}</i>
          <span class="jfk-font-number jfk-price__number font-size--36">分</span>
        </p>
        <jfk-rater :disabled="true" :value="score.comment_score" :margin="25" :fontSize="28"></jfk-rater>
        <pregress :allWidth="allWidth" :score="score" :comment_config="comment_config"/>
      </div>
    </div>
    <div class="talk">
      <p class="title font-size--24 grayColor80">
        大家都在说
      </p>
      <ul>
        <!--只展示 暂时无法筛选 -->
        <li class="active font-size--24">全部（{{score.comment_count}}）</li>
        <li class="font-size--24">有图评价（{{score.image_count}}）</li>
        <template v-if="score.keyword" v-for="item in score.keyword">
          <li v-if="item.count !== 0" class="font-size--24">
            {{item.keyword}}({{item.count}})
          </li>
        </template>
      </ul>
    </div>
    <ul class="comment-ul" v-if="commentList.length !== 0">
      <li class="content jfk-ml-30 jfk-mr-30" :key="index" v-for="(item,index) in commentList" v-if="(item.content !== '' && item.type && item.type === 'user') && (item.status === '1'
      || (member.open_id && item.openid === member.open_id))">
        <div class="contitle_info">
          <img :src="item.headimgurl" alt="" class="head_img">
          <span class="name font-size--28 grayColor80">{{item.nickname}}</span>
          <span class="date font-size--24 grayColorbf">{{parseTime(item.comment_time)}}</span>
          <span class="score grayColor33">
            <span class="font-size--32">{{item.intNum}}.</span>
            <span class="font-size--28">{{item.pointNum}}</span>
            <span class="font-size--12">分</span>
          </span>
        </div>
        <p :style="{height : setHeight[index]}" class="comment font-size--28" ref="commentHeight">{{item.content}}</p>
        <p v-if="isOpen[index] === 1 " class="show_all goldColor font-size--28" @click="openAll(index)">展开全文</p>
        <p v-else-if="isOpen[index] === 2" class="show_all goldColor font-size--28" @click="closeAll(index)">收起全文</p>
        <template v-if="item.images">
          <commentSwiper :items="item.images"/>
        </template>
        <div class="file">
        </div>
        <div v-if="item.feedback_content && item.feedback_content !== ''">
          <p v-if="item.hotelReplyStatus === '1'" class="check_repeat font-size--28 grayColor80"
             @click="changeHotelReply(index,'2')">
            <span>查看酒店回复</span>
            <i class="booking_icon_font font-size--24 icon-booking_icon_up_normal grayColorbf show_icon"></i>
          </p>
          <p class="check_repeat font-size--28 grayColor80" @click="changeHotelReply(index,'1')" v-else>
            <span>收起酒店回复</span>
            <i class="booking_icon_font font-size--24 icon-booking_icon_up_normal grayColorbf hide_icon"></i>
          </p>
          <div class="repeat_content font-size--28" v-if="item.hotelReplyStatus === '2'">
            <div><span class="hotel_name grayColor80">酒店回复：</span>{{item.feedback_content}}
            </div>
          </div>
        </div>
      </li>
    </ul>
    <button class="booking_now font-size--34" @click="toLocationHref(bookingUrl)">
      立即预定
    </button>
    <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
    <!--<JfkSupport v-once></JfkSupport>-->
  </div>
</template>
<script>
  import {getCommentContent} from '@/service/http'
  import pregress from './module/pregress.vue'
  import commentSwiper from './module/comment_swiper.vue'
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'

  export default {
    created () {
      // 获取酒店id
      this.hotel_id = formatUrlParams(location.href).h || ''
      // 获取评论数据
      this.getCommentData()
    },
    components: {
      pregress,
      commentSwiper
    },
    data () {
      return {
        line: 5,
        hotel_id: 0,
        comment_config: {},
        intNum: 0,
        pointNum: 0,
        allWidth: {},
        score: {},
        commentList: [],
        member: {},
        commentHeight: [],
        isOpen: [],
        swiperOptions: {
          autoplay: 0,
          lazyLoading: true,
          lazyLoadingInPrevNext: true,
          lazyPreloaderClass: 'jfk-image__lazy--preload',
          spaceBetween: 20
        },
        imgUrlKey: 'image_url',
        hotelReply: [{
          text: '查看酒店回复',
          status: '1'
        }, {
          text: '收起酒店回复',
          status: '2'
        }],
        setHeight: [],
        bookingUrl: ''
      }
    },
    methods: {
      // 获取酒店评论
      getCommentData () {
        getCommentContent({h: this.hotel_id}).then((res) => {
          this.score = res.web_data.t_t
          this.commentList = res.web_data.comments
          this.comment_config = res.web_data.comment_config
          this.member = res.web_data.member
          this.bookingUrl = res.web_data.page_resource.links.INDEX
          // 给酒店回复添加状态
          for (let i = 0; i < this.commentList.length; i++) {
            let oIntNum = this.splitNumber(this.commentList[i].score).int
            let oPointNum = this.splitNumber(this.commentList[i].score).point
            this.$set(this.commentList[i], 'hotelReplyStatus', '1')
            this.$set(this.commentList[i], 'intNum', oIntNum)
            this.$set(this.commentList[i], 'pointNum', oPointNum)
          }
          this.$nextTick(() => {
            for (let j = 0; j < this.$refs.commentHeight.length; j++) {
              if (this.$refs.commentHeight[j].offsetHeight / 19 > this.line) {
                console.log('下标是' + j)
                this.setHeight.push(this.line * 19 + 'px')
                this.isOpen.push(1)
              } else {
                this.setHeight.push('auto')
                this.isOpen.push(0)
              }
            }
          })
          this.intNum = this.splitNumber(this.score.comment_score).int
          this.pointNum = this.splitNumber(this.score.comment_score).point
          this.allWidth = {
            clean: this.calculateWidth(this.score.clean_score),
            facilities: this.calculateWidth(this.score.facilities_score),
            service: this.calculateWidth(this.score.service_score),
            net: this.calculateWidth(this.score.net_score)
          }
        })
      },
      // 拆分小数点前后
      splitNumber (value) {
        let reg = /\./
        let strArr = []
        // 将value（number）转换为字符串
        value = value + ''
        if (reg.test(value)) {
          strArr = value.split('.')
        } else {
          strArr.push(value)
          strArr.push(0)
        }
        return {int: strArr[0], point: strArr[1]}
      },
      // 计算宽度
      calculateWidth (value) {
        return (value / 5 * 100) * 1.2 + 'px'
      },
      // 展开全文
      openAll (index) {
        this.$set(this.isOpen, index, 2)
        this.$set(this.setHeight, index, 'auto')
      },
      // 收起全文
      closeAll (index) {
        this.$set(this.isOpen, index, 1)
        this.$set(this.setHeight, index, this.line * 19 + 'px')
      },
      // 修改酒店内容状态
      changeHotelReply (index, status) {
        this.commentList[index].hotelReplyStatus = status
      },
      // 将时间戳改为日期
      parseTime (time) {
        let oDate = new Date(time * 1000)
        let year = oDate.getFullYear()
        let month = oDate.getMonth() + 1
        let day = oDate.getDate()
        if (year >= 0 && year <= 9) {
          year = '0' + year
        }
        if (month >= 0 && month <= 9) {
          month = '0' + month
        }
        if (day >= 0 && day <= 9) {
          day = '0' + day
        }
        return year + '.' + month + '.' + day
      },
      // toLocationHref() 链接跳转
      toLocationHref (href) {
        window.location.href = href
      }
    }
  }
</script>
