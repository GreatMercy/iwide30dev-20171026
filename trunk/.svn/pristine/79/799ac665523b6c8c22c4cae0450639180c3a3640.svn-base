<template>
  <div>
    <bc />
    <deadline :endtime='endtime'/>
    <orderinfo :price="theprice"/>
    <formdata :max="max" :choicenumber="choicenumber" @transferUser='getMsg'/>
    <description />
    <fb :price="totalprice" @submit='paynow'/>
  </div>
</template>
<script>
  import deadline from '../../components/common/deadline'
  import bc from '../../components/common/background_color'
  import orderinfo from '../../components/common/order_info'
  import formdata from '../../components/common/formdata'
  import description from '../../components/common/description'
  import fb from '../../components/common/footer'

  export default {
    name: 'pay',
    components: {
      bc,
      deadline,
      orderinfo,
      formdata,
      description,
      fb
    },
    data () {
      let endtime = (new Date()).getTime() + 1000000
      let a = 123
      let b = 2
      let tp = a * b
      return {
        theprice: a,
        totalprice: tp,
        choicenumber: b,
        endtime: endtime,
        max: 3
      }
    },
    methods: {
      getMsg (msg, msg2) {
        this.totalprice = msg * this.theprice
        this.choicenumber = msg
      },
      paynow () {
        console.log('提交')
      }
    }
  }
</script>
<style>
</style>
