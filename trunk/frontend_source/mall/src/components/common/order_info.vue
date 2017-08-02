<template>
  <div class="order_info">
  	<div class="order_body">
      <div>“欢乐一家”一晚套餐</div>
      <div>金房卡大酒店提供<span class="label">限购3份</span></div>
      <div><span>午餐</span><span>单人</span></div>
      <div>{{price}}</div>
    </div>
  </div>
</template>
<script>
export default{
  name: 'order_info',
  props: ['price']
}
</script>
<style lang="postcss" scoped>
@import '../../styles/postcss/all.postcss';
.order_info{
	position: relative;
}
.order_body{
	margin:auto px2rem(30);
	margin-top:px2rem(42);
}
.order_body>div{
	margin-left: px2rem(77);
}
.order_body>div:nth-child(1){
	font-size: px2rem(38);
	color: var(--white);
	margin-top: px2rem(72);
	position: relative;
}
.order_body>div:nth-child(1)::before{
	content: "";
	width: px2rem(22);
	height: px2rem(103);
	background-image: url(../../assets/image/goldlight.png);
	position: absolute;
	background-size: 100% 100%;
	top: -50%;
	left: px2rem(-77);
}
.order_body>div:nth-child(2){
	font-size: px2rem(23);
	color: var(--c808080);
	margin-top: px2rem(28)
}
.label{
	font-size: px2rem(21);
	color: var(--white);
	margin-left: px2rem(20);
	background: linear-gradient(left , #987e54 , #b2a074);
	padding: px2rem(8) px2rem(12);
	border-radius: 3px;
}
.order_body>div:nth-child(3){
	font-size: px2rem(24);
	color: var(--c808080);
	margin-top: px2rem(39);
}
.order_body>div:nth-child(3)>span{
	margin-right: px2rem(10);
}
.order_body>div:nth-child(3)>span:nth-child(1)::before{
	content: "" !important;
}
.order_body>div:nth-child(3)>span::before{
	content: "|";
	margin-right: px2rem(10);
}
.order_body>div:nth-child(4){
	@extend shuzi;
	font-size: px2rem(40);
	margin-top: px2rem(70);
	color: var(--darkgold);
}
.order_body>div:nth-child(4)::before{
	content: "\ffe5";
	font-size: px2rem(24);
	color: var(--darkgold);
	padding-right: px2rem(10);
}
</style>
