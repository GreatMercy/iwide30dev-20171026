<template>
  <div class="bind-wx-outer">
    <div class="sign">
      <template v-if="!cancelStatus">
        <i v-if="bindStatus" class="jfkfont wx-icon-backstage_icon_rights_binding"></i>
        <i class="jfkfont wx-icon-btn_icon_selected_pressed" v-else></i>
        <p v-if="bindStatus">
          <span>你确认成为</span><br>
          <span>后台账号的绑定者吗？</span>
        </p>
        <p v-else>已允许绑定该微信账号</p>
      </template>
      <template v-else>
        <i class="jfkfont wx-icon-font_zh_emark_qkbys"></i>
        <p>已取消绑定</p>
      </template>
    </div>
    <div class="confirm" v-if="!cancelStatus || !bindStatus">
      <button class="yes" @click="toBindAction()">确定</button>
      <button class="no" @click="cancelAction()">取消</button>
    </div>
  </div>
</template>
<script>
  import {putBindWx} from '@/service/http'
  import {formatUrlParams} from '@/utils/utils'

  export default {
    name: 'login',
    data () {
      return {
        bindStatus: true,
        cancelStatus: false,
        urlParams: {}
      }
    },
    created () {
      this.urlParams = formatUrlParams(window.location.href)
    },
    methods: {
      cancelAction () {
        this.cancelStatus = true
      },
      toBindAction () {
        putBindWx({
          token: this.urlParams.token
        }).then((res) => {
          this.bindStatus = false
        })
      }
    }
  }
</script>
<style type="postcss">
  body, html {
    width: 100%;
    min-height: 100%;
    background-color: #000;
  }

  .bind-wx-outer {
    text-align: center;
    .sign {
      width: 100%;
      margin-top: 85px;
      i {
        font-size: 90px;
        color: #cbb790;
        margin-top: 85px;
        &.icon-font_zh_emark_qkbys {
          border: 3px solid #cbb790;
          border-radius: 50px;
        }
      }
      p {
        color: #fff;
        font-size: 17px;
        margin-top: 50px;
        margin-bottom: 50px;
      }
    }
    .confirm {
      padding: 0 40px;
      .yes, .no {
        width: 100%;
        height: 44px;
        line-height: 44px;
        outline: none;
        box-sizing: border-box;
        border: 0;
        background-color: #000;
      }
      .yes {
        color: #fff;
        font-size: 17px;
        margin-bottom: 12px;
        border: 1px solid #ad9565;
      }
      .no {
        color: #808080;
      }
    }
  }
</style>
