<template>
  <div class="slider-delete pr">
    <div class="animation-item" @touchstart="_touchStart($event)"
         @touchmove="_touchMove($event)"
         @touchend="_touchEnd($event)"
         :style="txtStyle">
      <div class="content" :style="padding">
        <div class="slot" :style="borderRadius">
          <slot></slot>
        </div>
      </div>
      <div class="del pa ta-c f24" @click="del">删除</div>
    </div>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        transform: 0,     // 当前的距离
        startX: 0,       // 触摸位置
        moveX: 0,       // 滑动时的位置
        disX: 0,       // 移动距离
        txtStyle: '',
        pageX: '',  // 用于计算滑动的方向
        pageY: '',  // 用于计算滑动的方向
        delWidth: 60, // 按钮的宽度
        padding: 'padding: 0 4%', // 内容区域的padding
        borderRadius: '' // 圆角效果
      }
    },
    props: {
      ind: [Number],
      open: {
        type: Boolean,
        default: true
      },
      border: [String]
    },
    created () {
      if (this.open) {
        this.borderRadius = 'border-radius: 5px 5px 0 0'
      }
    },
    watch: {
      border (val) {
        if (val) {
          this.borderRadius = val
        }
      }
    },
    methods: {
      calculateAngle (startPoint, endPoint) {
        let x = startPoint.x - endPoint.x
        let y = endPoint.y - startPoint.y
        // 角度
        let r = Math.atan2(y, x)
        // 弧度
        let angle = Math.round(r * 180 / Math.PI)
        if (angle < 0) {
          angle = 360 - Math.abs(angle)
        }
        return angle
      },
      changeStyle (bol) {
        if (this.open) {
          if (bol) {
            this.padding = 'padding: 0 4%'
            this.borderRadius = 'border-radius: 5px 5px 0 0'
          } else {
            this.padding = 'padding: 0'
            this.borderRadius = 'border-radius: 5px 0 0 5px'
          }
        } else {
          if (bol) {
            this.padding = 'padding: 0 4%'
            this.borderRadius = 'border-radius: 5px'
          } else {
            this.padding = 'padding: 0'
            this.borderRadius = 'border-radius: 5px 0 0 5px'
          }
        }
      },
      del () {
        this.$emit('deleteItem')
        this.transform = 0
        this.txtStyle = '-webkit-transform:translate3d(0, 0, 0)'
        this.changeStyle(true)
      },
      _touchStart (ev) {
        ev = ev || event
        if (ev.touches.length === 1) {
          // 手指按下的时候记录按下的位置
          this.startX = ev.touches[0].clientX
          this.pageX = ev.touches[0].pageX
          this.pageY = ev.touches[0].pageY
        }
      },
      _touchMove (ev) {
        ev = ev || event
        let move = () => {
          // 滑动过程中的实时位置
          this.moveX = ev.touches[0].clientX
          // this.moveX = moveX
          // 滑动过程中实时计算滑动距离
          this.disX = this.startX - this.moveX
          // this.disX = disX
          // 如果是向右滑动或者只是点击，不改变滑动位置
          if (this.disX < 0 || this.disX === 0) {
            this.transform = 0
            this.txtStyle = '-webkit-transform:translate3d(0, 0, 0)'
            this.changeStyle(true)
          } else if (this.disX > 0) {
            // 如果是向左滑动，则实时给这个根元素一个向左的偏移 - left，当偏移量到达固定值delWidth时，固定元素的偏移量为delWidth
            this.transform = this.disX
            this.txtStyle = '-webkit-transform:translate3d(-' + this.disX + 'px, 0, 0)'
            this.changeStyle(false)
            if (this.disX >= this.delWidth / 100) {
              this.transform = this.delWidth
              this.txtStyle = '-webkit-transform:translate3d(-' + this.delWidth + 'px, 0, 0)'
              this.changeStyle(false)
            }
          }
        }
        if (ev.touches.length === 1) {
          let moveEndX = ev.touches[0].pageX
          let moveEndY = ev.touches[0].pageY
          let startPoint = {
            x: this.pageX,
            y: this.pageY
          }
          let endPoint = {
            x: moveEndX,
            y: moveEndY
          }
          let angle = this.calculateAngle(startPoint, endPoint)
          if ((angle <= 45) && (angle >= 0)) {
            move()
          } else if ((angle <= 360) && (angle >= 315)) {
            move()
          } else if ((angle >= 135) && (angle <= 225)) {
            move()
          }
        }
      },
      _touchEnd (ev) {
        if (ev.changedTouches.length === 1) {
          this.startX = 0
          // 手指移动结束后的水平位置
          let endX = event.changedTouches[0].clientX
          // 触摸开始与结束,手指移动的距离
          this.disX = this.startX - endX
        }
      }
    }
  }
</script>
<style scoped lang="scss">
  @import "../../../common/scss/include";

  .slider-delete {
    width: 100%;

    .animation-item {
      transition: all 0.3s;

      .content {
        transition: all 0.3s;
        .slot {
          overflow: hidden;
          background: $bgColor;
          border-radius: 5px;
          height: px2rem(262);
        }
      }

      .del {
        border-radius: 0 px2rem(10) px2rem(10) 0;
        color: $white;
        width: px2rem(120);
        height: px2rem(262);
        line-height: px2rem(262);
        background: $orange;
        top: 0;
        right: -(px2rem(120));
      }

    }

  }

</style>
