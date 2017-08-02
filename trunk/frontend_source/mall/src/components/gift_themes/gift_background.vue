<template>
  <div class="gift-theme">
    <div class="gift-theme-bg"></div>
    <div class="gift-theme-logo"></div>
    <div class="gift-theme-wish jfk-ta-c jfk-pl-30 jfk-pr-30">
      <div class="gift-theme-wish__content" v-html="wish"></div>
    </div>
  </div>
</template>
<script>
  export default {
    props: {
      wish: {
        type: String,
        default: ''
      }
    }
  }
</script>
