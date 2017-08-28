<template>
  <div class="login-outer">
    <div class="login-logo">
      <img :src="login_logo" alt="登陆logo">
    </div>
    <div class="login-box">
      <ul class="tab-navs">
        <li v-for="item in tab_navs.navs" @click="changeLoginWays(item.login_type)"><span
          :class="{'active':tab_navs.selected === item.login_type}">{{item.text}}</span></li>
      </ul>
      <div class="tabs-content">
        <div class="ways" v-if="tab_seen">
          <img src="https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=1565059807,4002951989&fm=26&gp=0.jpg"
               alt="二维码">
          <!--未扫码前文字提示-->
          <p>请用微信扫描二维码登录后台~</p>
          <!--扫码成功 文字提示-->
          <p>
            <span><i class="el-icon-circle-check"></i>扫描成功!</span><br>
            <span>请在微信上进行后续操作</span>
          </p>
        </div>
        <div v-else class="ways account-box">
          <input type="text" placeholder="账号"/>
          <input type="text" placeholder="密码"/>
          <button class="login-btn">登陆</button>
          <a href="">金房卡</a>
          <span class="remember-account"><i class="el-icon-circle-check"></i>记住账号</span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'login',
    data () {
      return {
        login_logo: require('../../../assets/image/jfk_login_logo.png'),
        tab_navs: {
          // 登陆方式navs切换
          selected: 0,
          navs: [{
            login_type: 0,
            text: '扫码登陆'
          }, {
            login_type: 1,
            text: '账号密码登录'
          }]
        },
        tab_seen: true
      }
    },
    methods: {
      changeLoginWays (index) {
        this.tab_navs.selected = index
        this.tab_seen = !this.tab_seen
      }
    }
  }
</script>
<style lang="postcss">
  body, html {
    width: 100%;
    min-height: 100%;
    height: 100%;
    background-color: #f5f8fb;
  }

  .login-outer {
    text-align: center;
    color: #333;
    .login-logo {
      width: 108px;
      height: 61px;
      margin: 0 auto;
      padding-bottom: 45px;
      padding-top: 85px;
      img {
        width: 100%;
        display: block;
      }
    }
    .login-box {
      background-color: #fff;
      margin: 0 auto;
      width: 358px;
      padding: 26px 22px;
      .tab-navs {
        width: 100%;
        &:after {
          clear: both;
          display: block;
          height: 0;
          overflow: hidden;
        }
        li {
          float: left;
          width: 50%;
          list-style: none;
          margin-bottom: 45px;
          span {
            text-align: center;
            display: block;
            margin: 0 35px;
            padding-bottom: 15px;
            font-size: 14px;
            line-height: 14px;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            &.active {
              color: #b69b69;
              border-bottom: 2px solid #b69b69;
            }
          }
        }
      }
      .tabs-content {
        .ways {
          text-align: center;
          img {
            width: 242px;
            margin-bottom: 25px;
          }
          p {
            line-height: 24px;
            margin-bottom: 60px;
          }
          i {
            color: #b69b69;
            padding-right: 3px;
          }
          &.account-box {
            padding: 0 10px;
          }
          input {
            width: 300px;
            padding: 0 20px;
            border-radius: 4px;
            margin-bottom: 15px;
            height: 40px;
            border: 1px solid #eee;
            color: #333;
            outline: none;
            &::-webkit-input-placeholder {
              color: #bfbfbf;
            }
            &:-moz-placeholder {
              color: #bfbfbf;
            }
            &::-moz-placeholder {
              color: #bfbfbf;
            }
            &:-ms-input-placeholder {
              color: #bfbfbf;
            }
          }
          a {
            text-decoration: none;
            color: #333;
          }
          .login-btn {
            width: 100%;
            margin-top: 15px;
            margin-bottom: 22px;
            outline: none;
            border: 0;
            background-color: #b69b69;
            height: 40px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
          }
          .remember-account {
            float: right;
            margin-right: 20px;
          }
        }
      }
    }

  }
</style>
