<template>
  <div class="jfk-pages jfk-pages__comment">
    <div class="jfk-pages__theme"></div>
    <div class="choose_prt_top">
      <p class="choose_prt_top_item1 font-size--30">{{postData.room_name}}</p>
      <p class="choose_prt_top_item2 font-size--24 grayColorbf">{{postData.hotel_name}}</p>
      <p class="choose_prt_top_item3 font-size--24 grayColorbf">
        <span>入住<span class="grayColor80">{{startdate}}</span></span><span>离开<span class="grayColor80">{{enddate}}</span></span><span>共{{postData.room_night}}晚</span>
      </p>
    </div>
    <!-- 评分容器 -->
    <div class="star_container">
      <div class="star_title">酒店评分</div>
      <div class="star_list grayColor80">
        <p class="star_list_item">
          <span class="star_list_item_name font-size--28">{{comment_config.clean_score}}</span>
          <jfk-rater v-model="star.value0" 
                      :font-size="1" 
                      :margin="1.25" 
                      :disabled="false" 
                      :value="star.value0" 
                      :max="5">
          </jfk-rater>
        </p>
        <p class="star_list_item">
          <span class="star_list_item_name font-size--28">{{comment_config.facilities_score}}</span>
          <jfk-rater 
              :margin="1.25" 
              v-model="star.value1" 
              :disabled="false" 
              :font-size="1" 
              :value="star.value1">
          </jfk-rater>
        </p>
        <p class="star_list_item">
          <span class="star_list_item_name font-size--28">{{comment_config.net_score}}</span>
          <jfk-rater 
                :margin="1.25"
                :font-size="1" 
                v-model="star.value2" 
                :disabled="false" 
                :value="star.value2"> 
          </jfk-rater>
        </p>
        <p class="star_list_item">
          <span class="star_list_item_name font-size--28">{{comment_config.service_score}}</span>
          <jfk-rater :font-size="1" 
                     :margin="1.25" 
                     v-model="star.value3" 
                     :disabled="false" 
                     :value="star.value3">    
          </jfk-rater>
        </p>
      </div>
    </div>
    <div class="trip_type jfk-pl-30 jfk-pr-30 font-size--30" v-show="tourType !== null">
      <p class="title font-size--24 grayColor80">出游类型</p>
      <ul class="tripType">
        <li v-for="(item, index) in tourType" 
            @click="chooseType(index)" :key="index"
            :class="{'active':selectedTour === index}" class="font-size--30">
          {{item}}
        </li>
      </ul>
    </div>
    <div class="comment_input jfk-pl-30 jfk-pr-30">
      <p class="title">发表评价</p>
      <div class="jfk-pr-30">
          <textarea name="comment_content"
                    id="comment_content"
                    v-model="comment_input_value"
                    :placeholder="placeholderVal"
                    class="font-size--30"
                    maxlength="200">
          </textarea>
      </div>
      <span class="word_num">
          <span class="real_num">{{comment_input_value.length}}</span>/200
        </span>
    </div>
    <div class="upload_file jfk-pl-30 jfk-pr-30">
      <ul>
        <!--用来显示已上传图片的-->
        <li v-for="(item, index) in images">
          <span class="add_container">
            <span class="img_con">
              <img :src="item" alt="">
              <i class="booking_icon_font font-size--34 icon-mall_icon_orderDetail_delete"
                 @click="deletePic(index)"></i>
            </span>
          </span>
        </li>
        <!--显示添加图片-->
        <li @click="chooseImage()">
          <span class="add_container">
            <i class="jfk-font font-size--28 icon-booking_icon_addpictures_normal"></i>
            <span class="word">添加图片</span>
          </span>
        </li>
      </ul>
      <div class="submit_comment" @click="submitOrder()">
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
  import {getCommentOrderDetail, submitComment} from '@/service/http'
//  import jfkRater from '../../../../common/components/src/packages/jfk-rater/src/main.vue'
  export default {
    name: 'comment',
    components: {
//      jfkRater
    },
    created () {
      this.locationParams = formatUrlParams(location.href)
      this.getOrderDetail()
    },
    beforeCreate () {
    },
    computed: {},
    data () {
      return {
        // 评分
        star: {
          value0: 5,
          value1: 5,
          value2: 5,
          value3: 5
        },
        startdate: '',
        enddate: '',
        tourType: [],
        comment_config: {},
        selectedTour: 0,
        placeholderVal: '亲~ 住的舒服吗?服务满意吗?',
        locationParams: {},
        postData: {
          img_url: {}
        },
        comment_input_value: '',
        // 上传数量
        upload_num: 1,
        // 可上传数量
        limited_upload: 4,
        localIds: '',
        t_localIds: '',
        images: [],
        jumpUrl: '',
        orderid: '',
        roomnight: 0,
        imageLength: 0,
        // 存放图片 server id
        imgServerId: []
      }
    },
    methods: {
      // 获取详情
      getOrderDetail () {
        let loading = this.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        let args = {
          orderid: this.locationParams.orderid
        }
        getCommentOrderDetail(args).then((res) => {
          if (loading) {
            loading.close()
          }
          if (res.web_data.page_resource.links.redirect) {
            window.location.href = res.web_data.page_resource.links.redirect
            return
          }
          let ostartdate = res.web_data.order.startdate
          let oenddate = res.web_data.order.enddate
          this.startdate = this.setDay(ostartdate)
          this.enddate = this.setDay(oenddate)
          this.tourType = res.web_data.comment_config.sign
          this.comment_config = res.web_data.comment_config
          this.jumpUrl = res.web_data.index_url
          // 设置参数
          this.postData.hotel_id = parseInt(res.web_data.order.hotel_id)
          this.postData.orderid = res.web_data.order.orderid
          this.postData.hotel_name = res.web_data.order.hname
          this.postData.room_name = res.web_data.order.first_detail.roomname
          this.postData.room_night = res.web_data.order.roomnight
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
        })
      },
      // 截取字符串
      setDay (val) {
        let str = val.substring(4, 6)
        let str1 = val.substring(6)
        return str + '/' + str1
      },
      // 删除图片
      deletePic (index) {
        this.images.splice(index, 1)
        this.imgServerId.splice(index, 1)
      },
      // 微信选择图片
      chooseImage () {
        const wx = window.wx
        if (this.images.length >= this.limited_upload) {
          this.$jfkToast({
            duration: 1000,
            iconType: 'error',
            message: '已超过最大图片数'
          })
          return
        }
        this.upload_num = this.limited_upload - this.images.length
        let that = this
        if (wx) {
          wx.chooseImage({
            // 默认9
            count: this.upload_num,
            // 可以指定是原图还是压缩图，默认二者都有
            sizeType: ['original', 'compressed'],
            // 可以指定来源是相册还是相机，默认二者都有
            sourceType: ['album', 'camera'],
            success: function (res) {
              let length = that.images.length
              for (let j = 0; j < res.localIds.length; j++) {
                that.$set(that.images, length + j, res.localIds[j])
              }
              that.imageLength = 0
              that.imgServerId = []
              that.upload()
            }
          })
        }
      },
      upload () {
        let that = this
        let length = that.images.length
        const wx = window.wx
        wx.uploadImage({
          localId: that.images[that.imageLength],
          success: function (res) {
            that.imgServerId.push(res.serverId)
            that.imageLength ++
            if (that.imageLength < length) {
              that.upload()
            }
          },
          fail: function (res) {
            alert('上传失败请重试')
          }
        })
      },
      // 选择出游类型
      chooseType (index) {
        this.selectedTour = index
      },
      submitOrder () {
        // 注意使用新接口
        this.postData.orderid = this.locationParams.orderid
        this.postData.service_score = this.star.value0
        this.postData.net_score = this.star.value1
        this.postData.facilities_score = this.star.value2
        this.postData.clean_score = this.star.value3
        this.postData.content = this.comment_input_value
        this.postData.img_url = {}
        for (let key in this.imgServerId) {
          this.postData.img_url[key] = this.imgServerId[key]
        }
        this.postData.sign = {0: this.tourType[this.selectedTour]}
        if (this.star.value0 === 0 || this.star.value1 === 0 || this.star.value2 === 0 || this.star.value3 === 0) {
          this.$jfkToast({
            duration: 1000,
            iconType: 'error',
            message: '评分不少于1星'
          })
          return
        }
        if (this.postData.sign.length === 0) {
          this.$jfkToast({
            duration: 1000,
            iconType: 'error',
            message: '请选择出游类型'
          })
          return
        }
        if (this.comment_input_value.length < 10) {
          this.$jfkToast({
            duration: 1000,
            iconType: 'error',
            message: '评论内容不能少于10个字'
          })
          return
        }
        let loading = this.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        submitComment(this.postData).then((res) => {
          if (loading) {
            loading.close()
          }
          this.$jfkToast({
            duration: 1000,
            iconType: 'success',
            message: '评论提交成功！'
          })
          window.location.href = res.web_data.page_resource.links.HOTEL_COMMENT
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
        })
      }
    }
  }
</script>
