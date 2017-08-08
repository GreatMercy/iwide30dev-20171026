<template>
  <div class="main">
      <div>说明</div>
      <div>商品超过有效期不能使用也不能退款</div>
  </div>
</template>
<style lang="postcss" scoped>
@import '../../styles/postcss/all.postcss';

.main{
	position:relative;
	margin:px2rem(109) px2rem(29) 0 px2rem(29);
	font-size:px2rem(24);
	padding-bottom: px2rem(214);
}
.main>div:first-child{
	color: var(--darkwhite);
	vertical-align: middle;
}
.main>div:last-child{
	color: var(--c808080);
	margin-top: px2rem(24);
}
.main>div{
	margin-left: px2rem(43);
}
.main>div:first-child::before{
	@extend icon;
	content: "\e63b";
	vertical-align: middle;
  position: absolute;
  left: 0px;
  color: var(--c6e6e6e);
}
</style>
