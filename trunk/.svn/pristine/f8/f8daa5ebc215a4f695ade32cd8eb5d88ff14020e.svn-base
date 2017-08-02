<template>
  <div class="main">
    <div>
      <div>
        <div class="left">
          <img src="../../assets/image/goods_icon.png">
        </div>
        <div class="right">
          <div>{{orderProfileObject.goodsName}}</div>
          <div>{{orderProfileObject.validPeriod}}</div>
          <div>{{orderProfileObject.goodsPrice}}</div>
        </div>
      </div>
      <div>
        <div class="liebiao">
          <div>
            <div>&#xe60b;</div>
            <div>预约</div>
          </div>
          <div>
            <div>&#xe636;</div>
            <div>验券</div>
          </div>
          <div>
            <div>&#xe635;</div>
            <div>邮寄</div>
          </div>
          <div>
            <div>&#xe611;</div>
            <div>订房</div>
          </div>
          <div>
            <div>&#xe60f;</div>
            <div>转赠</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default{
  name: 'orderProfile',
  props: ['orderProfileObject']
}
</script>
<style lang="postcss" scoped>
@import '../../styles/postcss/all.postcss';
.main{
  margin: auto px2rem(27);
  position: relative;
  background-color: var(--c1f1f1f);
  border-radius: 5px;
  margin-top: px2rem(84);
}
.main>div{
  padding: px2rem(71) px2rem(41);
}
.main>div>div:nth-child(1){
  padding-bottom:px2rem(70);
  border-bottom:1px solid var(--c363636);
}
.main>div>div:nth-child(2){
  margin-top:px2rem(50);
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
  margin-top:px2rem(25);
}
.right>div:nth-child(3){
  font-size:px2rem(34);
  color:var(--white);
  margin-top:px2rem(25);
  @extend shuzi;
}
.right>div:nth-child(3)::before{
  content:"¥";
  font-size:px2rem(24);
  margin-right:px2rem(10);
}
.right>div:nth-child(3)::after{
  content:"1份";
  font-size:px2rem(24);
  margin-left:px2rem(35);
  color:var(--bfbfbf);
}
.main>div>div{
  position:relative;
  display:flex;
}
.liebiao{
  @extend flex;
  @extend between;
  width:100%;
}
.liebiao>div>div:first-child{
  @extend icon;
}
.liebiao>div{
  text-align:center;
}
.liebiao>div>div:nth-child(1){
  font-size:px2rem(48);
  color:var(--darkgold);
  text-shadow:0px 0px 20px var(--darkgold);
}
.liebiao>div>div:nth-child(2){
  font-size:px2rem(24);
  color:var(--bfbfbf);
  margin-top:px2rem(20);
}
</style>
