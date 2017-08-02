<template>
  <div class="main">
      <div class="orderInfoTitle">订单信息</div>
      <div class="orderNumber"><span>订单编号</span>{{orderInfoObject.orderNumber}}</div>
      <div class="orderNumber"><span>下单时间</span>{{orderInfoObject.offerTime}}</div>
      <div class="flex">
        <div class="orderNumber2">
          <span>订单总价</span>
          <span class="theprice">{{orderInfoObject.orderPrice}}</span>
        </div>
        <div v-on:click="TSshow" class="arrow">交易快照</div>
      </div>
  </div>
</template>
<script>
export default{
  name: 'orderInfo',
  props: ['orderInfoObject'],
  methods: {
    TSshow: function () {
      this.$emit('TSshow')
    }
  }
}
</script>
<style lang="postcss" scoped>
@import '../../styles/postcss/all.postcss';
.main{
  margin: auto px2rem(27);
  position: relative;
  margin-top: px2rem(84);
}
.orderInfoTitle{
  font-size:px2rem(24);
  color:var(--c808080);
  margin-bottom:px2rem(44);
}
.orderNumber{
  font-size:px2rem(30);
  color:var(--white);
  margin:px2rem(30) auto;
}
.orderNumber2{
  font-size:px2rem(30);
  color:var(--white);
}
.orderNumber>span:nth-child(1),.orderNumber2>span:nth-child(1){
  font-size:px2rem(28);
  color:var(--bfbfbf);
  margin-right:px2rem(60);
}
.theprice{
  @extend shuzi;
}
.theprice::before{
  content:"\ffe5";
  font-size:px2rem(24);
  margin-right:px2rem(10);
}
.flex{
  @extend flex;
  @extend between;
}
.arrow{
  font-size:px2rem(24);
  color:var(--bfbfbf);
}
.arrow::after{
  @extend icon;
  content:"\e60c";
  margin-left:px2rem(10);
  font-size: px2rem(20);
}
</style>
