<template>
  <div class="setn">
    <div v-on:touchstart='jian' :style="jiangray ? 'color:#333;' : ''">-</div>
    <div><input v-model="setnum" disabled="disabled" v-on:change='result'></div>
    <div v-on:touchstart='jia' :style="jiagray ? 'color:#333;' : ''">+</div>
  </div>
</template>
<script>
export default{
  name: 'NumberChoice',
  data () {
    let choicenumber = this.initValue ? this.initValue : 1
    return {
      setnum: choicenumber
    }
  },
  props: ['initValue', 'maximum', 'jiangray', 'jiagray'],
  methods: {
    result: function () {
      this.setnum = parseInt(this.setnum)
      if (this.setnum <= 0 || this.setnum === '') {
        this.setnum = 1
      }
      if (this.setnum > this.maximum && this.maximum) {
        this.setnum = this.maximum
      }
      this.$emit('Result', this.setnum, function (e) {
        this.setnum = e
      }.bind(this))
    },
    jian: function () {
      this.setnum--
      if (this.setnum <= 0) {
        this.setnum = 1
      }
      if (this.setnum > this.maximum && this.maximum) {
        this.setnum = this.maximum
      }
      this.$emit('Result', this.setnum, function (e) {
        this.setnum = e
      }.bind(this))
    },
    jia: function () {
      this.setnum++
      if (this.setnum <= 0) {
        this.setnum = 1
      }
      if (this.setnum > this.maximum && this.maximum) {
        this.setnum = this.maximum
      }
      this.$emit('Result', this.setnum, function (e) {
        this.setnum = e
      }.bind(this))
    }
  }
}
</script>
<style lang="postcss" scoped>
  @import '../../styles/postcss/all.postcss';
  .setn{
    height:px2rem(60);
    line-height:px2rem(60);
    text-align:center;
    border:1px solid var(--c666);
    @extend flex;
    justify-content: space-between;
    border-radius:3px;
    display:inline-block;
    width: px2rem(210);
  }
  .setn>div{
    display:inline-block;
    color:var(--darkwhite);
    font-size:px2rem(32);
    text-align:center;
    padding:0px px2rem(10);
  }
  .setn>div>input{
    background-color:transparent;
    border:none;
    width:px2rem(64);
    color:var(--darkwhite);
    text-align:center;
    outline:none;
  }
</style>
