<template>
  <div class="jfk-image" :style="imageStyle">
    <div class="jfk-image__default" v-if="!showImage">
      <div class="jfk-image__default-img" v-once>
        <div class="jfk-image__default-img-box" v-html="defaultImg" :style="defaultStyle"></div>
      </div>
    </div>
    <div class="jfk-image__box" v-if="showImage">
      <slot name="jfk-image-desc"></slot>
      <img ref="jfk-image" @load="loaded" @error="loadError" :src="img" :alt="alt" :title="title"/>
    </div>
  </div>
</template>
<script>
  let scales = ['3 3', '4 2']
  export default {
    name: 'jperation-image',
    data () {
      let _scale = this.scale.split(/\s+/)
      let defaultStyle = {
        width: 1 / _scale[0] * 100 + '%',
        height: 1 / _scale[1] * 100 + '%'
      }
      let imageStyle = {
        width: this.width,
        height: this.height
      }
      let defaultSrc = this.defaultSrc
      let defaultImg = ''
      if (!defaultSrc) {
        defaultImg = require('!svg-inline-loader!../../assets/default_' + _scale.join('_') + '.svg')
      } else {
        defaultImg = '<img src="' + defaultSrc + '"/>'
      }
      return {
        defaultStyle,
        imageStyle,
        defaultImg,
        img: ''
      }
    },
    props: {
      src: {
        type: String,
        require: true
      },
      alt: String,
      title: String,
      defaultSrc: String,
      errorSrc: String,
      scale: {
        validator: function (value) {
          return scales.indexOf(value) > -1
        },
        default: '3 3'
      },
      width: {
        type: String,
        default: '100%'
      },
      height: {
        type: String,
        default: '100%'
      },
      lazy: {
        default: true,
        type: Boolean
      }
    },
    methods: {
      loaded () {}
    },
    computed: {
      showImage () {
      }
    },
    created () {
      if (!this.lazy) {
      }
    }
  }
</script>
<style lang="postcss">
  .jfk-image{
    &__default-img{
      display: flex;
      justify-content: center;
      align-item: middle;
      svg{
        display: block;
        width: 100%;
        height: 100%;
        overflow: hidden;
      }
    }
  }
</style>
