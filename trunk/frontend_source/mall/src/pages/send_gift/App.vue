<template>
  <keep-alive>
    <router-view></router-view>
  </keep-alive>
</template>
<script>
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    name: 'sendGift',
    components: {},
    beforeCreate () {
      this.$pageNamespace(params)
    },
    created () {
    },
    data () {
      return {}
    },
    watch: {}
  }
</script>

<style>
</style>
