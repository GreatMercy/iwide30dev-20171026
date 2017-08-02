<template>
  <div class="input-number pr">
    <div class="content dp-f pr" :class="{'disabled':disabled}">
      <div class="minus pr" @click="minus" :class="{'disabled':minusDisabled}"></div>
      <input type="text" @input="change" ref="inputNumber" :value="result" class="dp-b f32 ta-c">
      <div class="plus pr" @click="plus" :class="{'disabled':plusDisabled}"></div>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        result: 1,
        minusDisabled: false,
        plusDisabled: false
      }
    },
    watch: {
      value (val) {
        this.result = parseInt(val)
        this.checkNumber()
        this.checkDisabled()
      },
      defaultValue (val) {
        this.result = parseInt(val)
        this.checkNumber()
        this.checkDisabled()
      },
      max (val) {
        if (val) {
          this.checkDisabled()
        }
      }
    },
    props: {
      auto: {
        type: Boolean,
        default: true
      },
      min: {
        type: [Number, String],
        default: 1
      },
      max: {
        type: [Number, String],
        default: 100
      },
      defaultValue: {
        type: [Number, String],
        default: 1
      },
      disabled: {
        type: Boolean,
        default: false
      },
      limit: {
        type: Boolean,
        default: true
      }
    },
    created () {
      this.$nextTick(() => {
        if (this.defaultValue !== 0 || this.defaultValue) {
          this.result = this.defaultValue
        }
        this.checkNumber()
        this.checkDisabled()
      })
    },
    methods: {
      checkNumber () {
        if (parseInt(this.result) > parseInt(this.max)) {
          this.result = parseInt(this.max)
        } else if (parseInt(this.result) < parseInt(this.min)) {
          this.result = parseInt(this.min)
        }
        if (parseInt(this.max) < parseInt(this.result)) {
          this.result = parseInt(this.max)
        }
        this.$emit('input', parseInt(this.result))
        this.checkDisabled()
      },
      checkDisabled () {
        // 判断是否所有不能点击
        if (this.disabled === false) {
          if (parseInt(this.result) <= parseInt(this.min)) {
            this.minusDisabled = true
            this.plusDisabled = false
          } else if (parseInt(this.result) >= parseInt(this.max)) {
            this.plusDisabled = true
            this.minusDisabled = false
          } else {
            this.plusDisabled = false
            this.minusDisabled = false
          }
          if (parseInt(this.result) === parseInt(this.max)) {
            this.plusDisabled = true
          }
        } else {
          this.plusDisabled = true
          this.minusDisabled = true
        }
      },
      minus () {
        if (parseInt(this.result) === parseInt(this.min)) {
          return false
        }
        if (this.auto === false) {
          this.$emit('minus')
        } else {
          this.result--
        }
        this.checkNumber()
      },
      plus () {
        if (parseInt(this.result) === parseInt(this.max)) {
          return false
        }
        if (this.auto === false) {
          this.$emit('plus')
        } else {
          this.result++
        }
        this.checkNumber()
      },
      change () {
        this.$emit('change', parseInt(this.result))
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../common/scss/include';

  .input-number {
    display: inline-block;
    width: px2rem(216);
    height: px2rem(64);
    overflow: hidden;
    border-radius: px(5);
    border: 1px solid $fontColor;
    vertical-align: top;

    .content {
      overflow: hidden;

      &:after {
        content: "";
        position: absolute;
        width: px2rem(72);
        height: px2rem(64);
        z-index: 99;
        left: px2rem(72);
        top: 0;
      }

      .minus, .plus {
        &.disabled {
          &:after {
            background: $gray;
          }

          &:before {
            background: $gray;
          }
        }
      }

      .minus, .plus {
        width: px2rem(72);
        height: px2rem(64);

        &:after {
          @include center();
          content: '';
          width: px2rem(16);
          height: px2rem(4);
          background: $white;
        }
      }

      .plus {
        &:before {
          @include center();
          content: '';
          height: px2rem(16);
          width: px2rem(4);
          background: $white;
        }

      }

      input {
        color: $white;
        width: px2rem(72);
        height: px2rem(64);
        font-size: px(32);
        background: rgba(0, 0, 0, 0);
        outline: none;
      }

      &.disabled {
        input {
          color: $gray;
        }
        &:before {
          content: "";
          position: absolute;
          width: 100%;
          height: 100%;
          z-index: 99;
        }
      }

    }

  }
</style>
