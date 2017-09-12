<template>
  <keep-alive>
    <router-view></router-view>
  </keep-alive>
</template>
<script>
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    created () {
      this.$pageNamespace(params)
    },
    components: {},
    data () {
      return {}
    }
  }
</script>

<style>
</style>
