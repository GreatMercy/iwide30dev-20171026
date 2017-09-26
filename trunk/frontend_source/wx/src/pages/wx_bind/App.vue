<template>
  <div class="bind-wx-outer">
    <div class="sign">
      <!--微信登陆computer图标-->
      <!--<i class="jfkfont icon-backstage_icon_rights_login"></i>-->
      <!--<i class="jfkfont icon-backstage_icon_rights_binding"></i>-->
      <i class="jfkfont icon-btn_icon_selected_pressed"></i>
      <!--<i class="jfkfont icon-font_zh_emark_qkbys"></i>-->
      <p>已取消登录</p>
      <!--<p>已确认登录后台</p>-->
      <!--<p>-->
      <!--<span>你确认成为</span><br>-->
      <!--<span>后台账号的绑定者吗？</span>-->
      <!--</p>-->
      <!--<p>已允许绑定该微信账号</p>-->
      <!--<p>你确认要登陆后台吗？</p>-->
    </div>
    <div class="account-list">
      <div class="wx-account">
        <img src="" alt="" class="user">
        <span>iwide7777</span>
      </div>
      <ul class="jfk-account-list">
        <li class="choosed"><span>group1</span><i class=" jfkfont icon-btn_icon_selected_pressed"></i>
          <div class="split-line"></div>
        </li>
        <li><span>group2</span><i class="jfkfont icon-btn_icon_selected_normal"></i>
          <div class="split-line"></div>
        </li>
        <li><span>group3</span><i class="jfkfont icon-btn_icon_selected_normal"></i>
          <div class="split-line"></div>
        </li>
      </ul>
    </div>
    <div class="confirm">
      <button class="yes">确定</button>
      <button class="no">取消</button>
    </div>

  </div>
</template>
<script>
//  import {} from '@/service/system/http'
//  import {showFullLayer, formatUrlParams} from '@/utils/utils'
  export default {
    name: 'login',
    data () {
      return {}
    },
    methods: {}
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
            i{
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
