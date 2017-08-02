<template>
  <div id="user-info">
    <h2 class="title f24">预约信息</h2>
    <ul>
      <li class="pr" :class="{'disabled':disabled}">
        <label for="username" class="dp-f pr">
          <div class="title f28">联<span>系</span>人</div>
          <input type="text" id="username" value="" placeholder="请输入联系人" class="dp-b flex-1 f28" v-model="name">
        </label>

      </li>

      <li class="pr" :class="{'disabled':disabled}">
        <label for="cellphone" class="dp-f pr">
          <div class="title f28">手机号码</div>
          <input type="tel" id="cellphone" value="" maxlength="11" placeholder="请输入手机号码" class="dp-b flex-1 f28"
                 v-model="phone">
        </label>
      </li>

      <li class="pr" :class="{'disabled':disabled}">
        <label for="remarks" class="dp-f pr">
          <div class="title f28">备<span class="remarks-spacing"></span>注</div>
          <input type="text" id="remarks"  placeholder="您的需求我们尽量满足" class="dp-b flex-1 f28"
                 v-model="remarks">
        </label>
      </li>

    </ul>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        name: '',
        phone: '',
        remarks: '',
        verifyId: ''
      }
    },
    watch: {
      userInfo (val) {
        this.name = val.name || val.username || ''
        this.phone = val.phone || ''
        this.verifyId = val['verify_id'] || ''
        this.remarks = val.user_note
        if (this.disabled === true && this.remarks.trim().length === 0) {
          this.remarks = '无'
        }
      },
      disabled (val) {
        if (val === true && this.remarks.trim().length === 0) {
          this.remarks = '无'
        }
      }
    },
    created () {
    },
    props: {
      userInfo: [Object],
      disabled: {
        type: Boolean,
        default: false
      }
    },
    methods: {
      verification () {
        // 判断联系人是否输入错误
        if (this.name.trim().length === 0) {
          return {
            'status': false,
            'msg': '请输入联系人'
          }
        }

        // 判断手机好吗是否正确
        if (this.phone.trim().length === 0) {
          return {
            'status': false,
            'msg': '请输入手机号码'
          }
        }
        if (!/^(13[0-9]|14[57]|15[012356789]|17[0678]|18[0-9])\d{8}$/g.test(this.phone)) {
          return {
            'status': false,
            'msg': '请输入正确的手机号码'
          }
        }

        return {
          'status': true,
          'username': this.name,
          'phone': this.phone,
          'userNote': this.remarks,
          'verifyId': this.verifyId
        }
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../common/scss/include';

  #user-info {
    padding: 0 4%;
    margin: px2rem(94) 0 px2rem(19);

    h2 {
      color: $gray;
      margin-bottom: px2rem(16);
    }

    ul {
      li {
        &.disabled {
          &:after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 99;
          }
        }

        label {
          border-bottom: 1px solid $borderColor;
          padding: px2rem(25) 0;
          .title, input {
            height: px2rem(50);
            line-height: px2rem(50);
          }

          .title {
            width: px2rem(206);
            color: $lightGray;

            span {
              margin: 0 0.5em;
            }

            .remarks-spacing {
              margin: 0 1em;
            }
          }

          input {
            padding-right: px(10);
            border: none;
            background: none;
            color: $white;
            outline: none;

            &::-webkit-input-placeholder {
              color: $gray;
            }

          }

        }
      }
    }

  }
</style>
