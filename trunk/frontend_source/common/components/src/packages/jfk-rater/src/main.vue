<template>
  <div class="jfk-rater">
    <input v-model="currentValue" style="display:none">
    <a class="jfk-rater-box jfk-rater__default" v-for="(i, index) in max" :key="index"
       @click="handleClick(i-1)"
       :class="{ 'jfk-rater__active' : currentValue > 0 && currentValue > i-1 && cutIndex !== i-1 }"
       :style="{marginRight:margin+'px',fontSize: fontSize + 'px', width: fontSize + 'px', height: fontSize + 'px', lineHeight: fontSize + 'px'}">
      <span class="jfk-rater-inner">{{star}}<span class="jfk-rater-outer jfk-rater__active" :style="{width: cutPercent + '%'}"
                                                  v-if="cutPercent > 0 && cutIndex === i-1">{{star}}</span></span>
    </a>
  </div>
</template>

<script>
  export default {
    name: 'jfkRater',
    created () {
      this.currentValue = this.value
    },
    mounted () {
      this.updateStyle()
    },
    props: {
      max: {
        type: Number,
        default: 5
      },
      value: {
        type: Number,
        default: 0
      },
      disabled: Boolean,
      star: {
        type: String,
        default: '★'
      },
      margin: {
        type: Number,
        default: 2
      },
      fontSize: {
        type: Number,
        default: 25
      }
    },
    computed: {
      sliceValue () {
        const _val = this.currentValue.toFixed(2).split('.')
        return _val.length === 1 ? [_val[0], 0] : _val
      },
      cutIndex () {
        return this.sliceValue[0] * 1
      },
      cutPercent () {
        return this.sliceValue[1] * 1
      }
    },
    methods: {
      handleClick (i, force) {
        if (!this.disabled || force) {
          if (this.currentValue === i + 1) {
            // 限制最低一星 不能选 0 星
            if (this.currentValue === 1) return
            this.currentValue = i
            this.updateStyle()
          } else {
            this.currentValue = i + 1
          }
        }
      },
      updateStyle () {
        for (var j = 0; j < this.max; j++) {
          if (j <= this.currentValue - 1) {
            this.$set(this.colors, j, this.activeColor)
          } else {
            this.$set(this.colors, j, '#ccc')
          }
        }
      }
    },
    data () {
      return {
        colors: [],
        currentValue: 0
      }
    },
    watch: {
      currentValue (val) {
        this.updateStyle()
        this.$emit('input', val)
      },
      value (val) {
        this.currentValue = val
      }
    }
  }
</script>

