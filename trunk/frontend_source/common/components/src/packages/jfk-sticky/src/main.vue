<template>
  <div class="jfk-sticky">
    <slot></slot>
  </div>
</template>

<script>
import sticky from './sticky'

export default {
  name: 'JfkSticky',
  mounted () {
    this.$nextTick(() => {
      sticky(this.$el, {
        scrollBox: this.scrollBox,
        offset: this.offset,
        checkStickySupport: typeof this.checkStickySupport === 'undefined' ? true : this.checkStickySupport
      })
    })
  },
  props: ['scrollBox', 'offset', 'checkStickySupport']
}
</script>
