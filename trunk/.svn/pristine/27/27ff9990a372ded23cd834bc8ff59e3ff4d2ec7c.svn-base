<template>
  <div class="formbody">
  	<div class="bought_number">
  		<div><div>购</div><div>买</div><div>数量</div></div>
  		<setnumber :initValue='choicenumber' @Result='getMsg' :jiangray="number === 1 ? true : false" :jiagray="number === 3 ? true : false" :maximum="max"></setnumber>
  	</div>
  	<div class="line">
  		<div><div>购</div><div>买</div><div>人</div></div>
  		<div>涵涵涵</div>
  	</div>
  	<div class="line">
  		<div><div>联</div><div>系</div><div>方</div><div>式</div></div>
  		<div><input placeholder="请输入购买人手机"></div>
  	</div>
  	<div class="line">
  		<div><div>优</div><div>惠</div><div>券</div></div>
  		<div class="arrow"><input placeholder="新用户专享优惠券¥100"></div>
  	</div>
  	<div class="line">
  		<div><div>优</div><div>惠</div><div>活</div><div>动</div></div>
  		<div>已优惠¥30</div>
  	</div>
  	<div class="line">
  		<div><div>支</div><div>付</div><div>方</div><div>式</div></div>
  		<div>微信支付</div>
  	</div>
  </div>
</template>
<script>
import setnumber from './NumberChoice'

export default {
  name: 'formdata',
  props: ['max', 'choicenumber'],
  data () {
    return {
      number: this.choicenumber
    }
  },
  components: {
    setnumber
  },
  methods: {
    sendMsg: function (msg) {
      this.$emit('transferUser', msg)
    },
    getMsg (msg) {
      this.number = msg
      this.sendMsg(msg)
    }
  }
}
</script>
<style lang="postcss" scoped>
	@import '../../styles/postcss/all.postcss';
	.formbody{
		position:relative;
		margin:px2rem(100) px2rem(29) 0 px2rem(29);
		font-size:px2rem(28);
	}
	.formbody>div>div:last-child{
		font-size: px2rem(30);
	}
	.formbody>div>div:first-child{
		width:px2rem(120);
    display:inline-flex;
    @extend between;
	}
	.formbody>div{
		border-bottom:1px solid var(--c363636);
		color:var(--darkwhite);
		padding-bottom:px2rem(28);
		margin-top : px2rem(35);
	}
	.formbody>div:nth-child(1){
		margin-top:0px;
	}
	.bought_number{
		@extend flex;
		@extend between;
	}
	.line{
		@extend flex;
		@extend between;
	}
	.line>div:nth-child(2){
		width:px2rem(490);
		@extend tofle;
		color:var(--white);
	}
	.line>div:nth-child(2) input{
		@extend ci;
		color:var(--white);
		font-size:1rem;
	}
	.arrow::after{
		@extend icon;
		content:"\e60c";
		color:#adadad;
    font-size: px2rem(20);
    vertical-align: middle;
	}
</style>
