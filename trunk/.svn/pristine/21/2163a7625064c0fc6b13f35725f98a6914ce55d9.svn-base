<template>
  <transition name="jfk-toast-pop">
    <div class="jfk-toast" :class="toastClass" v-show="visible">
      <div class="jfk-toast__cont">
        <div class="jfk-toast__main">
          <i class="jfk-toast__icon font-size--80 color-golden" :class="[iconClass, iconTypeClass]" v-if="iconType || iconClass !== ''"></i>
          <div class="jfk-toast__text font-size--28 font-color-extra-light-gray">{{ message }}</div>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
import iconTypeMap from '../../../utils/iconTypeMap.js'
  export default {
    name: 'JfkToast',
    props: {
      message: String,
      className: {
        type: String,
        default: ''
      },
      position: {
        type: String,
        default: 'middle'
      },
      iconClass: {
        type: String,
        default: ''
      },
      modal: {
        type: Boolean,
        default: true
      }
    },
    data() {
      return {
        visible: false,
        iconType: ''
      };
    },
    computed: {
      toastClass () {
        var classes = [];
        classes.push(this.modal ? 'is-modal' : 'no-modal')
        switch (this.position) {
          case 'top':
            classes.push('is-placetop')
            break
          case 'bottom':
            classes.push('is-placebottom')
            break
          default:
            classes.push('is-placemiddle')
        }
        this.className && classes.push(this.className)
        if (this.iconClass || this.iconType) {
          classes.push('is-icon')
        } else {
          classes.push('no-icon')
        }
        console.log(classes)
        return classes.join(' ')
      },
      iconTypeClass: function () {
        return this.iconType && iconTypeMap[this.iconType] ? `jfk-font icon-${ iconTypeMap[this.iconType] }` : ''
      }
    }
  };
</script>