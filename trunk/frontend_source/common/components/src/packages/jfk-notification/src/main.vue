<template>
  <div class="jfk-notification">
    <div class="jfk-notification_wrap jfk-pl-30 jfk-pr-30">
      <div class="jfk-flex is-align-middle jfk-notification_content">
        <span class="jfk-d-ib jfk-font" :class="icon"></span>
        <i v-text="message"></i>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'jfkNotification',
    props: {
      message: {
        type: String,
        default: ''
      },
      icon: {
        type: String,
        default: 'icon-msg_icon_warning_no'
      }
    }
  }
</script>
