<template>
  <div ref="scroll" class="scroll-view">
    <slot></slot>
  </div>
</template>

<script>
  export default {
    name: 'scrollView',
    computed: {},
    components: {},
    props: {
      more: Function
    },
    data () {
      return {
        timer: null
      }
    },
    methods: {
      throttle () {
        clearTimeout(this.timer)
        this.timer = setTimeout(() => {
          this.more()
        }, 500)
      }
    },
    created () {
    },
    mounted () {
      window.addEventListener('scroll', () => {
        let scrollTop = document.documentElement.scrollTop || document.body.scrollTop
        let scrollHeight = document.body.clientHeight
        let windowHeight = window.innerHeight
        if (scrollTop + windowHeight >= scrollHeight) {
          this.throttle()
        }
      })
    }
  }
</script>

<style scoped lang="scss">
  @import "../../common/scss/include";

  .scroll-view {
    margin-bottom: px2rem(120);
  }
</style>
