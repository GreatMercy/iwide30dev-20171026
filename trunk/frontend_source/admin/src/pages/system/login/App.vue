<template>
  <div class="login-outer">
    <div class="login-logo">
      <img :src="login_logo" alt="登陆logo">
    </div>
    <div class="login-box">
      <ul class="tab-navs">
        <li v-for="item in tabNavs.navs" @click="changeLoginWays(item.login_type)"><span
          :class="{'active': tabNavs.selected === item.login_type}">{{item.text}}</span></li>
      </ul>
      <div class="tabs-content">
        <div class="ways" v-if="tabSeen">
          <img :src="qrImg" alt="二维码">
          <!--未扫码前文字提示-->
          <p v-if="scanCodeStatus">请用微信扫描二维码登录后台~</p>
          <span>{{expireTime}}</span>
          <!--扫码成功 文字提示-->
          <!--<p>-->
          <!--<span><i class="el-icon-circle-check"></i>扫描成功!</span><br>-->
          <!--<span>请在微信上进行后续操作</span>-->
          <!--</p>-->
        </div>
        <div class="ways account-box" v-else>
          <el-form :model="adminForm" :rules="adminRules" ref="adminForm">
            <el-form-item label="" prop="account">
              <el-input v-model="adminForm.account" placeholder="账号"></el-input>
            </el-form-item>
            <el-form-item label="" prop="password">
              <el-input v-model="adminForm.password" placeholder="密码"></el-input>
            </el-form-item>
          </el-form>
          <button class="login-btn">登陆</button>
          <a href="">金房卡</a>
          <span class="remember-account">
            <i class="el-icon-circle-check" v-if="rememberStatus" @click="rememberMe()"></i>
            <i class="notRembered" @click="rememberMe()" v-else></i>
            <span>记住账号</span>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import {getLoginQrcode, getScanStatus} from '@/service/system/http'
  //  import {showFullLayer, formatUrlParams} from '@/utils/utils'
  export default {
    name: 'login',
    created () {
      getLoginQrcode().then((res) => {
        this.qrImg = res.web_data.imgUrl
        // 过期时间
        this.expireTime = res.web_data.expire_time
      })
      console.log(getScanStatus)
    },
    data () {
      var validatePass = (rule, value, callback) => {
        let passReg = /^[a-zA-Z0-9]{6,16}$/
        let numReg = /^[0-9]*$/
        let wordReg = /^[a-zA-Z]*$/
        if (value === '') {
          callback(new Error('请输入密码！'))
        } else if (numReg.test(value) || wordReg.test(value)) {
          callback(new Error('请输入数字和英文的组合！'))
        } else if (!passReg.test(value)) {
          callback(new Error('请输入6-16位的密码!'))
        } else {
          callback()
        }
      }
      return {
        login_logo: require('../../../assets/image/jfk_login_logo.png'),
        tabNavs: {
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
        tabSeen: true,
        rememberStatus: false,
        scanCodeStatus: true,
        adminForm: {
          account: '',
          password: ''
        },
        expireTime: '',
        qrImg: '',
        adminRules: {
          account: [{required: true, message: '请输入2-20位的账号', trigger: 'blur'},
            {min: 2, max: 20, message: '长度在 2 到 20 个字符', trigger: 'blur'}],
          password: [{required: true, validator: validatePass, trigger: 'blur'}]
        }
      }
    },
    methods: {
      changeLoginWays (index) {
        this.tabNavs.selected = index
        this.tabSeen = !this.tabSeen
      },
      rememberMe () {
        this.rememberStatus = !this.rememberStatus
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
            &.notRembered {
              display: inline-block;
              width: 14px;
              height: 14px;
              border-radius: 14px;
              padding: 0;
              vertical-align: middle;
              border: 1px solid #b69b69;
            }
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
    .el-form-item__error {
      margin-left: 20px;
    }

  }
</style>
