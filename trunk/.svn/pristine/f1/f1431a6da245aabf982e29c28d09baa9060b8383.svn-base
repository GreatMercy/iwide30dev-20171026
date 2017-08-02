<template>
  <div class="jfk-pages jfk-pages__gift">
    <div class="gift-box">
      <div class="gift-box-envelope">
        <div class="gift-box-wish jfk-ta-c font-size--36" v-html="name + '送你一份礼物'"></div>
        <div class="gift-box-content"></div>
        <div class="gift-box-bg"></div>
        <div class="gift-box-btn jfk-ta-c font-size--34" @click="openGift">打开礼盒</div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'gift',
    data () {
      return {
        name: '小马哥'
      }
    },
    created () {
      // 判断当前礼物是否被打开了
      console.log('check state')
    },
    methods: {
      openGift () {
        console.log('open gift')
      }
    }
  }
</script>
