<template>
  <transition name="jfk-toast-pop">
    <div class="jfk-share" v-if="visible" @click.stop.prevent="close">
      <div class="jfk-share__content">
        <div class="jfk-ta-r">
          <div class="jfk-share__arrow jfk-d-ib"></div>
        </div>

        <div class="jfk-ta-r">
          <div class="jfk-share__text jfk-d-ib"></div>
        </div>

        <div class="jfk-ta-r">
          <div class="jfk-share__graphic jfk-d-ib"></div>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
  export default {
    name: 'JfkShare',
    props: {
      shadeClose: {
        type: Boolean,
        default: true
      }
    },
    methods: {
      close () {
        if (this.shadeClose) {
          this.visible = false
        }
      }
    },
    data() {
      return {
        visible: true
      }
    }
  }
</script>
