<template>
  <div class="jfk-pages jfk-pages__hotelAlbum">
    <div class="jfk-pages__theme"></div>
    <div class="gradient_bg wrapper hotel_photo_wrapper">
      <div class="hotel-pictures">
        <div class="hotel-pictures__list">
          <template v-for="(item,index) in cur_gallery">
            <!-- curimg -->
            <template v-if="index === curIndex">
              <div class="hotel-pictures__items"
                   :class="{active: show[curIndex].isActive,picPushOutBack : show[curIndex].isShow1 , picPushOutFront : show[curIndex].isShow2 ,
                   picPushInBack : show[curIndex].isShow3 , picPushInFront : show[curIndex].isShow4}"
                   @touchstart="doStartAction(index)" @touchmove="doMoveAction"
                   @touchend="doEndAction">
                <div class="hotel-pictures__title">
                  {{item.info + '(' + item.gallery_name + ')'}}
                </div>
                <div class="hotel-pictures__photo squareimg">
                  <img :src="item.image_url">
                </div>
              </div>
            </template>
            <template v-else-if="index === nextIndex">
              <div class="hotel-pictures__items active"
                   :class="{active: show[nextIndex].isActive,picPushOutBack : show[nextIndex].isShow1 , picPushOutFront : show[nextIndex].isShow2 ,
                   picPushInBack : show[nextIndex].isShow3 , picPushInFront : show[nextIndex].isShow4}"
                   @touchstart="doStartAction(index)" @touchmove="doMoveAction"
                   @touchend="doEndAction">
                <div class="hotel-pictures__title">
                  {{item.info + '(' + item.gallery_name + ')'}}
                </div>
                <div class="hotel-pictures__photo squareimg">
                  <img :src="item.image_url">
                </div>
              </div>
            </template>
            <template v-else>
              <div class="hotel-pictures__items" :class="{active:selected === index}"
                   @touchstart="doStartAction(index)" @touchmove="doMoveAction"
                   @touchend="doEndAction">
                <div class="hotel-pictures__title">
                  {{item.info + '(' + item.gallery_name + ')'}}
                </div>
                <div class="hotel-pictures__photo squareimg">
                  <img v-if="selected !== 0" :src="default_img">
                  <img v-else :src="item.image_url">
                </div>
              </div>
            </template>
          </template>
        </div>
      </div>
      <div class="hotel-pictures__pagination">
        <template v-if="direction === 'down'">
          <span class="current">{{selected + 2}}</span>
        </template>
        <template v-else-if="direction === 'up'">
          <span class="current">{{selected + 1}}</span>
        </template>
        <template v-else-if="direction ==='' ">
          <span class="current">1</span>
        </template>
        <span class="total"> /{{total_num}}</span>
      </div>
    </div>
  </div>
</template>
<script>
  import {getHotelAlbum} from '@/service/http'

  export default {
    name: 'app',
    components: {},
    created () {
      this.hotel_id = this.getUrlParams('h')
      this.getAlbumData()
    },
    data () {
      return {
        hotel_id: 0,
        cur_gallery: [],
        selected: 0,
        total_num: 0,
        state: {},
        default_img: require('../../assets/hotel_default.png'),
        loadQueueTime: null,
        skipLoadImg: 500,
        animationTime: null,
        // 动画持续时间，由css中定义，如果修改，需要同步修改css
        animationDuration: 300,
        nextIndex: null,
        curIndex: null,
        timeGap: null,
        lastTouchTime: null,
        direction: '',
        animationShow: false,
        show: []
      }
    },
    methods: {
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
      },
      // 获取相册数据
      getAlbumData () {
        getHotelAlbum({h: this.hotel_id}).then((res) => {
          this.cur_gallery = res.web_data.cur_gallery
          this.total_num = res.web_data.total_nums
          this.setShowStatus()
        })
      },
      setShowStatus () {
        for (let i = 0; i < this.cur_gallery.length; i++) {
          this.show[i] = {
            isActive: false,
            isShow1: false,
            isShow2: false,
            isShow3: false,
            isShow4: false
          }
        }
      },
      // 开始触摸
      doStartAction (index, e) {
        var ele = e || window.event
        if (document.all) {
          ele.cancelBubble = true
          ele.returnValue = false
        } else {
          ele.stopPropagation()
          ele.preventDefault()
        }
        this.selected = index
        let _e = ele.touches[0]
        this.state = {
          time: Date.now(),
          pageX: _e.pageX,
          pageY: _e.pageY
        }
      },
      // 移动中
      doMoveAction (e) {
        var ele = e || window.event
        if (document.all) {
          ele.cancelBubble = true
          ele.returnValue = false
        } else {
          ele.stopPropagation()
          ele.preventDefault()
        }
      },
      // 结束触摸
      doEndAction (e) {
        var ele = e || window.event
        if (document.all) {
          ele.cancelBubble = true
          ele.returnValue = false
        } else {
          ele.stopPropagation()
          ele.preventDefault()
        }
        let _e = ele.changedTouches[0]
        let distanceX = _e.pageX - this.state.pageX
        let distanceY = _e.pageY - this.state.pageY
        let time = Date.now() - this.state.time
        let event = ''
        // 倾斜度在30-150之间触发
        let angle = Math.atan2(Math.abs(distanceX), Math.abs(distanceY))
        if (angle < 0.9) {
          // 方向
          this.direction = distanceY < 0 ? 'up' : 'down'
          // 250毫秒
          if (time < 250) {
            if (Math.abs(distanceY) < 50) {
              event = 'tap'
            } else {
              event = 'swipe'
            }
          } else {
            // pan
            event = 'pan'
          }
          this.photoChange({event: event, direction: this.direction})
        }
      },
      // 滑动改变class
      changeDomClass (curIndex, nextIndex) {
        // 重置动画类
        this.show[curIndex].isActive = false
        this.show[nextIndex].isActive = true
        this.resetShowStatus(curIndex, nextIndex)
      },
      // 重置当前图片和下一个图片的动画类
      resetShowStatus (curIndex, nextIndex) {
        this.show[curIndex] = {
          isShow1: false,
          isShow2: false,
          isShow3: false,
          isShow4: false
        }
        this.show[nextIndex] = {
          isShow1: false,
          isShow2: false,
          isShow3: false,
          isShow4: false
        }
      },
      // 改变class名 执行动画
      photoChange (eventObj) {
        let t = Date.now()
        let name = eventObj.event
        let isUp = eventObj.direction === 'up'
        if (this.lastTouchTime) {
          this.timeGap = t - this.lastTouchTime
          if (this.timeGap < this.skipLoadImg) {
            clearTimeout(this.loadQueueTime)
          }
        }
        if (name !== 'tap') {
          // 如果两次事件相隔小于animationDuration，则需要立刻执行changeDomClass

          this.nextIndex = isUp ? this.selected - 1 : this.selected + 1
          if (this.nextIndex >= 0 && this.nextIndex < this.cur_gallery.length) {
            if (this.timeGap < this.animationDuration && this.nextIndex && this.curIndex) {
              this.changeDomClass(this.curIndex, this.nextIndex)
            }
            this.curIndex = this.selected
            // 动画
            if (isUp) {
              this.show[this.curIndex].isShow1 = true
              this.show[this.curIndex].isShow3 = true
            } else {
              this.show[this.curIndex].isShow2 = true
              this.show[this.curIndex].isShow4 = true
            }
            let that = this
            clearTimeout(this.animationTime)
            this.animationTime = setTimeout(function () {
              return that.changeDomClass(that.curIndex, that.nextIndex)
            }, this.animationDuration)
          }
        }
        this.lastTouchTime = t
      }
    }
  }
</script>
