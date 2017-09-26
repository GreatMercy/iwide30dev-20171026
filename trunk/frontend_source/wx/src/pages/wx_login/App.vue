<template>
  <div class="bind-wx-outer">
    <div class="sign">
      <!--微信登陆computer图标-->

      <!--登陆（电脑图标）-->
      <!--<i class="jfkfont wx-icon-backstage_icon_rights_login"></i>-->
      <template v-if="loadStatus === 1">
        <!--绑定-->
        <i class="jfkfont wx-icon-backstage_icon_rights_binding"></i>
        <p>你确认要登陆后台吗？</p>
      </template>
      <template v-else-if="loadStatus === 2">
        <!--取消-->
        <i class="jfkfont wx-icon-font_zh_emark_qkbys"></i>
        <p>已取消登录</p>
      </template>
      <template v-else-if="loadStatus === 3">
        <!--成功-->
        <i class="jfkfont wx-icon-btn_icon_selected_pressed"></i>
        <p>已确认登录后台</p>
      </template>
    </div>
    <div class="account-list" v-if="loadStatus === 1">
      <div class="wx-account">
        <img :src="userInfo.headimgurl" alt="" class="user">
        <!--微信公众号昵称-->
        <span>{{userInfo.nickname}}</span>
      </div>
      <!--微信公众号绑定的登陆账号 暂无数据 先不嵌套-->
      <ul class="jfk-account-list">
        <li v-for="(item,index) in accountList" :key="index" :class="{'choosed' : index === selected}"
            @click="changeAccount(index)">
          <span>{{item.username}}</span>
          <i class="jfkfont icon-btn_icon_selected_pressed"></i>
          <div class="split-line"></div>
        </li>
      </ul>
    </div>
    <div class="confirm" v-if="loadStatus === 1">
      <button class="yes" @click="toConfirmAction()">确定</button>
      <button class="no" @click="toCancelAction()">取消</button>
    </div>

  </div>
</template>
<script>
  import {getAccountData, postQrLogin} from '@/service/http'
  //  import {showFullLayer, formatUrlParams} from '@/utils/utils'
  export default {
    name: 'login',
    data () {
      return {
        accountList: [],
        selected: 0,
        loadStatus: 1,
        userInfo: {}
      }
    },
    created () {
      getAccountData({
        token: 'dec4b908684ee3acd3d0f3d8f8cdcdad',
        openid: 'oX3WojvNJIjnJdykJUJfb0AmFi8k'
      }).then((res) => {
        this.userInfo = res.web_data.user_info
        this.accountList = res.web_data.list
      })
    },
    methods: {
      changeAccount (index) {
        this.selected = index
      },
      toConfirmAction () {
        let putData = {
          token: 'dec4b908684ee3acd3d0f3d8f8cdcdad',
          admin_id: this.accountList[this.selected].admin_id
        }
        console.log(putData)
        console.log(postQrLogin)
        postQrLogin(putData).then((res) => {
          alert('修改状态')
          this.loginStatus = 3
        })
      },
      toCancelAction () {
        this.loadStatus = 2
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
      /*background: radial-gradient(#ceb689 30%, #c5ad7f 10%,#bba67e 10%,#1d1c19 10%, #0e0d0c 30%);*/
      /*opacity: 0.2;*/
      /*height: 272px;*/
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
      position: fixed;
      width: 100%;
      padding: 0 40px;
      box-sizing: border-box;
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
    .account-list {
      padding: 0 40px;
      .wx-account {
        height: 49px;
        border: 1px solid #808080;
        border-radius: 4px;
        color: #fff;
        font-size: 15px;
        line-height: 49px;
        img {
          width: 28px;
          height: 28px;
          border-radius: 28px;
          margin: 10px 15px;
          vertical-align: middle;
        }
      }
      .jfk-account-list {
        margin-bottom: 50px;
        li {
          list-style: none;
          line-height: 50px;
          height: 50px;
          color: #fff;
          opacity: 0.4;
          text-align: left;
          text-indent: 12px;
          .split-line {
            height: 1px;
            background-color: #fff;
            opacity: 0.4;
          }
          &.choosed {
            opacity: 1;
            i {
              color: #ad9565;
              opacity: 1;
            }
          }
          i {
            float: right;
            margin-right: 12px;
            color: #fff;
            font-size: 15px;
            opacity: 0.4;
          }
        }
      }
    }
  }
</style>
