<template>
  <div class="main">
      <div class="lt">包含券码</div>
      <transition
        name="custom-classes-transition"
        enter-active-class="animated fadeIn"
        leave-active-class="animated fadeOut"
      >
        <div class="juanbody">
          <template v-for="todo in lingshi">
            <div :class="todo.status">
              <div class="left">
                <div class="qm">券码</div>
                <div class="number">{{todo.coupons}}</div>
              </div>
              <div class="right">{{todo.status === 'used' ? '已使用' : todo.status === 'send' ? '已邮寄' : todo.status === 'gift' ? '已赠送' : '&#xe637;'}}</div>
            </div>
          </template>
          <div v-on:click="kat(theswtich = !theswtich)" ref="oc" class="thebtn" :class="theswtich ? 'trun' : ''">{{theswtich ? '显示其他' + orderCouponObject.length + '张卷' : '收起'}}</div>
        </div>
      </transition>
  </div>
</template>
<script>
export default{
  name: 'orderCoupon',
  props: ['orderCouponObject'],
  data () {
    return {
      theswtich: true,
      lingshi: [this.orderCouponObject[0]]
    }
  },
  methods: {
    kat: function (e) {
      if (e) {
        this.lingshi = [this.orderCouponObject[0]]
      } else {
        this.lingshi = this.orderCouponObject
        setTimeout(function () {
          this.$refs.oc.scrollIntoView(false)
        }.bind(this), 10)
      }
    }
  }
}
</script>
<style lang="postcss" scoped>
@import '../../styles/postcss/all.postcss';
.main{
  margin: auto px2rem(27);
  position: relative;
  margin-top: px2rem(78);
}
.lt{
  font-size:px2rem(24);
  color:var(--c808080);
}
.normal>.right{
  font-size: px2rem(34) !important;
}
.juanbody{
  background-color: var(--c1f1f1f);
  border-radius: 5px;
  margin-top: px2rem(36);
  padding: px2rem(21) px2rem(40);
}
.juanbody>div{
  @extend flex;
  @extend between;
  padding : px2rem(45) 0px;
  border-top: 1px dashed var(--c3a3a3a);
}
.juanbody>div:first-child{
  border-top: 0px;
}
.left{
  display: inline-flex;
  align-items: center;
}
.qm{
  font-size: px2rem(28);
  color: var(--c808080);
  letter-spacing: px2rem(26);
  display: inline-flex;
  align-items: center;
  position: relative;
}
.normal .qm::before{
  content: "";
  width: px2rem(4);
  height: px2rem(20);
  background: linear-gradient(left top,#d6bf94,#b3945e);
  position: relative;
  vertical-align: middle;
  box-shadow: 0px 0px 10px var(--darkgold);
  margin-right: px2rem(38);
}
.used .qm::before{
  content: "";
  width: px2rem(4);
  height: px2rem(20);
  background: linear-gradient(left top,#a5a5a5,#6d6d6d);
  position: relative;
  vertical-align: middle;
  box-shadow: 0px 0px 10px #a1a1a1;
  margin-right: px2rem(38);
}
.send .qm::before{
  content: "";
  width: px2rem(4);
  height: px2rem(20);
  background: linear-gradient(left top,#81d6cc,#21dac4);
  position: relative;
  vertical-align: middle;
  box-shadow: 0px 0px 10px #6fd7cb;
  margin-right: px2rem(38);
}
.gift .qm::before{
  content: "";
  width: px2rem(4);
  height: px2rem(20);
  background: linear-gradient(left top,#e69c8d,#e86c54);
  position: relative;
  vertical-align: middle;
  box-shadow: 0px 0px 10px #e78e7d;
  margin-right: px2rem(38);
}
.number{
  margin-left: px2rem(10);
  font-size: px2rem(32);
  color: var(--white);
  font-family:var(--baseFontFamily);
}
.right{
  font-size: px2rem(24);
  color: var(--c808080);
  display: inline-flex;
  align-items: center;
}
.right::after{
  @extend icon;
  content:"\e60c";
  margin-left:px2rem(10);
  font-size: px2rem(20);
  vertical-align: middle;
}
.used .number{
  color: var(--c808080);
  text-decoration: line-through;
}
.send .right{
  color: #21dac4;
}
.gift .right{
  color: #e86c54;
}
.normal .right{
  @extend icon;
}
.thebtn{
  justify-content: center !important;
  font-size: px2rem(24);
  color: var(--bfbfbf);
  padding: 0px !important;
  margin: auto 0px !important;
  border-top: 1px solid var(--c3a3a3a) !important;
  padding-top: px2rem(36) !important;
}
.thebtn::after{
  @extend icon;
  content: "\e60d";
  margin-left: px2rem(16);
  transition:all 0.5s;
  transform: rotate(180deg);
}
.trun::after{
  transform: rotate(0deg);
}
</style>
