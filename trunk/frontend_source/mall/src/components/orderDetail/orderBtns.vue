<template>
  <div class="main">
      <div class="flex">
        <div>&#xe622;&#xe620;&#xe624;&#xe61e;</div>
        <div>&#xe621;&#xe613;&#xe615;&#xe612;</div>
        <div>&#xe61d;&#xe616;&#xe614;&#xe618;</div>
      </div>
  </div>
</template>
<script>
export default{
  name: 'orderBtns',
  props: ['orderInfoObject']
}
</script>
<style lang="postcss" scoped>
@import '../../styles/postcss/all.postcss';
.main{
  margin: auto px2rem(27);
  position: relative;
  margin-top: px2rem(84);
  border-top: 1px solid var(--c363636);
}
.flex{
  @extend flex;
  @extend between;
  position: relative;
}
.flex>div{
  @extend icon;
  width: 33%;
  text-align: center;
  height: px2rem(156);
  line-height: px2rem(156);
  font-size: px2rem(28);
  color: var(--bfbfbf);
}
.flex>div::before{
  margin-right:px2rem(10);
  color: var(--darkgold);
  font-size: px2rem(30);
}
.flex>div:nth-child(1)::before{
  @extend icon;
  content: "\e638";
}
.flex>div:nth-child(2)::before{
  @extend icon;
  content: "\e634";
}
.flex>div:nth-child(3)::before{
  @extend icon;
  content: "\e633";
}
.flex::after{
  content: "";
  width: 1px;
  height: px2rem(18);
  background-color: var(--c3a3a3a);
  position: absolute;
  left: 33%;
  top:50%;
  margin-top:px2rem(-9);
}
.flex::before{
  content: "";
  width: 1px;
  height: px2rem(18);
  background-color: var(--c3a3a3a);
  position: absolute;
  right: 33%;
  top:50%;
  margin-top:px2rem(-9);
}
</style>
