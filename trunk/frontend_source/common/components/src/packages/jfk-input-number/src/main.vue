<template>
  <div class="jfk-input-number">
    <div class="jfk-input-number__box">
      <i class="jfk-input-number__control is-sub" :class="{'is-disabled': subDisabled}" @click="handleSub"></i>
      <div class="jfk-input-number__cont">
        <input
          type="number"
          plattern="[0-9]*"
          v-model.number="currentValue"
          :name="name"
          class="jfk-input-number__input jfk-ta-c"
          :readonly="!fillable"
          :step="step"
          @blur="handleBlur"/>
      </div>
      <span class="jfk-input-number__control is-add" :class="{'is-disabled': addDisabled}" @click="handleAdd">
        <i class="icon-booking_icon_addpictures_normal jfk-font"></i>
      </span>
    </div>
  </div>
</template>
<script>
  const intReg = /^\d+$/
  export default {
    name: 'jfkInputNumber',
    data () {
      return {
        currentValue: this.min || 0
      }
    },
    created () {
      this.currentValue = this.value
    },
    computed: {
      subDisabled () {
        if (this.disabled) {
          return true
        }
        return this.min === undefined ? false : (this.currentValue === '' ? true : this.currentValue <= this.min)
      },
      addDisabled () {
        if (this.disabled) {
          return true
        }
        return this.max === undefined ? false : (this.currentValue === '' ? true : this.currentValue >= this.max)
      }
    },
    watch: {
      currentValue (val) {
        const { min, max } = this
        if (val !== '') {
          if (min !== undefined && val < min) {
            this.currentValue = min
          }
          if (max !== '' && val > max) {
            this.currentValue = max
          }
        }
        this.$emit('input', this.currentValue)
        this.$emit('on-change', this.currentValue)
      },
      value (val) {
        this.currentValue = val
      }
    },
    methods: {
      handleBlur () {
        if (this.currentValue === '') {
          this.currentValue = 1
        }
        if (this.isInt) {
          this.currentValue = Math.ceil(this.currentValue)
        }
      },
      handleSub () {
        if (!this.subDisabled) {
          this.currentValue = this.currentValue - this.step
        }
      },
      handleAdd () {
        if (!this.addDisabled) {
          this.currentValue = this.currentValue + this.step
        }
      }
    },
    props: {
      min: {
        type: Number,
        default: 1
      },
      max: {
        type: Number,
        default: 200
      },
      step: {
        type: Number,
        default: 1
      },
      fillable: {
        type: Boolean,
        default: true
      },
      isInt: {
        type: Boolean,
        default: true
      },
      disabled: Boolean,
      value: {
        validator (value) {
          if (typeof value === 'number') {
            return true
          } else if (typeof value === 'string') {
            return value === ''
          }
          return false
        },
        default: 1
      },
      name: String
    }
  }
</script>
