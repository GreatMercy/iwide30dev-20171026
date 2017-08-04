<template>
  <transition
        name="custom-classes-transition"
        enter-active-class="animated fadeIn"
        leave-active-class="animated fadeOut"
      >
    <div class="main">
      <div class="land">
        <div class="neirong">
          <div class="ddh">
            <div class="ib">
              <div>订</div>
              <div>单</div>
              <div>号</div>
            </div>
            <div class="ib">123123123123</div>
          </div>
          <div class="ddh">
            <div class="ib">
              <div>下</div>
              <div>单</div>
              <div>时</div>
              <div>间</div>
            </div>
            <div class="ib">123123123123</div>
          </div>
          <div class="order_info">
            <div class="left">
              <img src="../../assets/image/goods_icon.png">
            </div>
            <div class="right">
              <div>金房卡酒店月饼圆</div>
              <div>金房卡酒店</div>
              <div>123</div>
            </div>
          </div>
          <div class="buyagain">再次购买</div>
          <div class="biaoqian">
            <div>
              <div>&#xe645;</div>
              <div>品质保证</div>
            </div>
            <div>
              <div>&#xe610;</div>
              <div>随时退款</div>
            </div>
            <div>
              <div>&#xe635;</div>
              <div>邮寄到家</div>
            </div>
            <div>
              <div>&#xe60f;</div>
              <div>赠送好友</div>
            </div>
            <div>
              <div>&#xe63a;</div>
              <div>到店自提</div>
            </div>
            <div>
              <div>&#xe646;</div>
              <div>开具发票</div>
            </div>
            <div>
              <div>&#xe611;</div>
              <div>微信订房</div>
            </div>
          </div>
          <div class="jiezhi">
            <div>使用截止时间</div>
            <div>2017/12/12</div>
          </div>
          <div class="dinggou">
            <div>订购须知</div>
            <div>1.商品购买够要什么什么的</div>
            <div>2.商品购买够要什么什么的</div>
            <div>3.商品购买够要什么什么的</div>
          </div>
        </div>
        <div class="thebtn">查看商品详情</div>
        <div class="close" v-on:click="onclose">&#xe654;</div>
      </div>
    </div>
  </transition>
</template>
<script>
  export default {
    name: 'transactionSnapshot',
    methods: {
      onclose: function () {
        this.$emit('TSclose')
      }
    }
  }
</script>
<style lang="postcss" scoped>
@import '../../styles/postcss/all.postcss';
.main{
  width: 100%;
  height: 100%;
  position: fixed;
  background-color: rgba(0,0,0,0.85);
  top: 0px;
  left: 0px;
  @extend flex;
  --margin:px2rem(60);
}
.land{
  margin: px2rem(30);
  width: 100%;
  background-color: var(--c282828);
  border-radius: 5px;
  max-height: calc(100% - var(--margin));
  overflow: auto;
  position: relative;
  max-height: 100%;
  -webkit-overflow-scrolling: touch;
}
.neirong{
  margin: px2rem(42);
}
.ddh{
  font-size: px2rem(24);
  color: var(--c808080);
  margin: px2rem(10) auto;
}
.ib{
  display: inline-block;
  @extend between;
}
.ib:nth-child(1){
  display: inline-flex;
  width: px2rem(100);
  margin-right: px2rem(20);
}
.left,.right{
  display:inline-block;
}
.left{
  width:px2rem(153);
  height:px2rem(153);
  overflow:hidden;
  border-radius:5px;
}
.left>img{
  object-fit:cover;
  width:100%;
  height:100%;
}
.right{
  width:px2rem(455);
}
.right>div{
  margin-left:px2rem(35);
  @extend tofle;
}
.right>div:nth-child(1){
  font-size:px2rem(34);
  color:var(--white);
}
.right>div:nth-child(2){
  font-size:px2rem(24);
  color:var(--c808080);
  margin-top:px2rem(20);
}
.right>div:nth-child(3){
  font-size:px2rem(34);
  color:var(--darkgold);
  margin-top:px2rem(25);
  @extend shuzi;
}
.right>div:nth-child(3)::before{
  font-family: var(--baseFontFamily);
  content:"¥";
  font-size:px2rem(24);
}
.right>div:nth-child(3)::after{
  font-family: var(--baseFontFamily);
  content:"1份";
  font-size:px2rem(24);
  margin-left:px2rem(35);
  color:var(--bfbfbf);
}
.order_info{
  position:relative;
  display:flex;
  margin-top: px2rem(60);
}
.buyagain{
  width: px2rem(193);
  height: px2rem(60);
  line-height: px2rem(60);
  text-align: center;
  border:1px solid var(--darkgold);
  color: var(--white);
  font-size: px2rem(30);
  margin-top: px2rem(79);
}
.biaoqian{
  @extend flex;
  border-top: 1px solid var(--c363636);
  margin-top: px2rem(66);
  position: relative;
  padding: px2rem(20) 0px;
}
.biaoqian>div{
  width: 25%;
  font-size: px2rem(28);
  text-align: center;
  margin:px2rem(30) 0px;
}
.biaoqian>div>div:first-child{
  @extend icon;
  font-size: px2rem(36);
  text-align: center;
  color: var(--c666);
}
.biaoqian>div>div:last-child{
  color: var(--bfbfbf);
  margin-top: px2rem(25);
}
.jiezhi{
  padding-top: px2rem(58);
  border-top: 1px solid var(--c363636);
}
.jiezhi>div:first-child{
  font-size: px2rem(24);
  color: var(--c808080);
}
.jiezhi>div:last-child{
  font-size: px2rem(28);
  color: var(--bfbfbf);
  margin-top: px2rem(35);
}
.dinggou{
  margin-top: px2rem(58);
}
.dinggou>div{
  font-size: px2rem(28);
  color: var(--bfbfbf);
  margin-top: px2rem(15);
}
.dinggou>div:first-child{
  font-size: px2rem(24);
  color: var(--c808080);
  margin-bottom: px2rem(25);
}
.thebtn{
  justify-content: center !important;
  font-size: px2rem(24);
  color: var(--bfbfbf);
  margin: auto 0px !important;
  border-top: 1px dashed var(--c3a3a3a) !important;
  padding: px2rem(24) 0px !important;
  text-align: center;
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
.close{
  @extend icon;
  position: absolute;
  right: px2rem(30);
  top: px2rem(30);
  color: var(--c808080);
}
</style>
