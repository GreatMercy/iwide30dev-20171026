<template>
  <div v-if='end' class="deadline">
      支付截止时间<span>{{lefttime}}</span>
  </div>
  <div v-else class="deadline">
      支付时间已截止
  </div>
</template>
<script>
export default{
  name: 'deadline',
  data () {
    this.load(this.endtime, this)
    return {
      lefttime: '',
      end: true
    }
  },
  props: ['endtime'],
  methods: {
    load: function (e, c) {
      this.actionTime = e
      this.c = c
      this.loop = function () {
        let nowtime = (new Date()).getTime()
        let cha = this.actionTime - nowtime
        if (cha <= 0) {
          this.c.end = false
          return
        }
        let str = this.change('mm:ss', cha)
        this.c.lefttime = str
        setTimeout(function () {
          this.loop()
        }.bind(this), 1000)
      }
      this.change = function (fmt, ts) {
        var days = Math.floor(ts / (24 * 3600 * 1000))
        var leave1 = ts % (24 * 3600 * 1000)
        var hours = Math.floor(leave1 / (3600 * 1000))
        var leave2 = leave1 % (3600 * 1000)
        var minutes = Math.floor(leave2 / (60 * 1000))
        var leave3 = leave2 % (60 * 1000)
        var seconds = Math.round(leave3 / 1000)
        var o = {
          'd+': days,
          'h+': hours,
          'm+': minutes,
          's+': seconds
        }
        for (var k in o) {
          if (new RegExp('(' + k + ')').test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length === 1) ? (o[k]) : (('00' + o[k]).substr(('' + o[k]).length)))
        }
        return fmt
      }
      this.loop()
    }
  }
}
</script>
<style lang="postcss" scoped>
@import '../../styles/postcss/all.postcss';

.deadline{
	position:relative;
	font-size: px2rem(22);
	@extend tac;
	color: var(--c808080);
	background-color: rgba(255,255,255,0.08);
	height: px2rem(65);
	line-height: px2rem(65);
}
.deadline>span{
	color: var(--cd8c67c);
	font-size: px2rem(28);
	margin-left: px2rem(10);
}
</style>
