<template>
  <div class="jfk-pages add-account-outer">
    <el-row>
      <el-col :span="24">
        <div class="grid-content bg-purple">
          <!--步骤-->
          <el-steps :space="400" :active="activeStep" finish-status="success" class="jfk-steps--bg-gray jfk-steps">
            <el-step title="基础信息"></el-step>
            <el-step title="关联公众号"></el-step>
            <el-step v-if="this.SuperTube === '0'" title="账号权限"></el-step>
          </el-steps>
          <!--基础信息填写界面-->
          <el-form v-if="activeStep === 0" :model="accountInfor" :rules="accountRules" ref="accountInfor">
            <el-form-item label="用户名" prop="username">
              <el-input v-model="accountInfor.username" placeholder="请输入用户名"></el-input>
            </el-form-item>
            <el-form-item label="昵称" prop="nickname">
              <el-input v-model="accountInfor.nickname" placeholder="请输入昵称"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="password">
              <el-input v-model="accountInfor.password" type="password" placeholder="请输入字母与数字的组合"></el-input>
            </el-form-item>
            <el-form-item label="确认密码" prop="repassword">
              <el-input v-model="accountInfor.repassword" type="password" placeholder="请再次输入密码"></el-input>
            </el-form-item>
            <el-form-item label="绑定微信">
              <el-button type="primary" size="small" icon="plus">绑定</el-button>
            </el-form-item>
            <el-form-item label="状态" prop="status">
              <el-select v-model="accountInfor.status" placeholder="状态">
                <el-option label="有效" value="有效"></el-option>
                <el-option label="无效" value="无效"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" size="small" style="margin-left: 70px" @click="nextStepBtn('accountInfor')">
                下一步
              </el-button>
            </el-form-item>
          </el-form>
          <!--关联公众号时 初始为空-->
          <div v-else-if="activeStep === 1" class="set-public-account">
            <div v-if="!listShow" style="text-align: center">
              <span>关联公众号、门店、店铺</span>&nbsp&nbsp&nbsp&nbsp
              <el-button type="primary" size="small" icon="plus" @click="addAccount()">添加</el-button>
            </div>
            <!--已经添加的公众号列表-->
            <div v-else class="public-account-module">
              <!--查询-->
              <div class="search-module">
                <el-input placeholder="请输入名称/角色类型">
                  <el-button type="success" slot="append" icon="search">搜索</el-button>
                </el-input>
              </div>
              <!--列表-->
              <!--全选按钮-->
              <div class="choose-all">
                <el-checkbox v-model="chooseAll" @change="chooseAllBtn">全选</el-checkbox>
              </div>
              <table class="public-account-table">
                <tr>
                  <th width="28%">关联公众号</th>
                  <th width="16%">角色类型</th>
                  <th width="28%">门店</th>
                  <th width="28%">店铺</th>
                </tr>
                <tr v-for="item in current.renderList">
                  <td>
                    <el-checkbox v-model="item.publicInfo.status">{{item.publicInfo.inter_name}}</el-checkbox>
                  </td>
                  <td>{{item.publicInfo.role_name}}</td>
                  <td colspan="2">
                    <ul class="combine-ul">
                      <li v-for="(item1,index1) in item.hotels">
                        <div class="left-list">
                          <el-checkbox v-model="item1.status">{{item1.hotel_name}}</el-checkbox>
                        </div>
                        <div class="right-list">
                          <el-checkbox v-model="item2.status" v-for="item2 in item.shops[index1]">{{item2.shop_name}}
                          </el-checkbox>
                        </div>
                      </li>
                    </ul>
                  </td>
                </tr>
              </table>
              <!--分页-->
              <div class="block paging-block">
                <div class="page-infor">
                  当前显示第<span>{{current.page}}</span>页
                  纪录从<span>{{current._from}}</span>条到<span>{{current._to}}</span>条,
                  共
                  <span v-if="searchAccountValue ===''">{{current.total}}</span>
                  <span v-else>{{current.searchTotal}}</span>
                  条
                </div>
                <el-pagination v-if="searchAccountValue === ''" :page-size="current.size" :total=current.total
                               layout="prev, pager, next"
                               @current-change="changePage">
                </el-pagination>
                <el-pagination v-else :page-size="current.size" :total="current.searchTotal" layout="prev, pager, next"
                               @current-change="changePage">
                </el-pagination>
              </div>
              <div style="text-align: center">
                <el-button type="primary" size="small" icon="plus" @click="addAccount()">新增</el-button>
              </div>
              <div class="finish-btn" v-if="this.SuperTube ==='1'">
                <el-button type="primary" size="small">完成</el-button>
              </div>
              <div class="next-btn">
                <el-button type="primary" size="small" v-if="this.SuperTube ==='0'" @click="nextStepTwo()">下一步
                </el-button>
              </div>
              <el-alert v-if="nextAlert" title="请至少输入一个公众号！" type="error">
              </el-alert>
            </div>
            <!--新建公众号-->
            <div v-if="addAccountShow" class="create-account-box">
              <div class="cancel-btn" @click="cancelPopup()">
                <i class="el-icon-close"></i>
              </div>
              <el-form ref="relatedForm" :model="relatedForm" :rules="relatedRules" label-width="">
                <el-form-item prop="choosedPublicAccount" label="选择公众号">
                  <el-select v-model="relatedForm.choosedPublicAccount" @change="changeAccount" placeholder="请选择公众号">
                    <el-option v-for="item in relatedForm.publicAccount" :value="item.inter_id"
                               :label="item.name"></el-option>
                  </el-select>
                </el-form-item>
                <el-form-item prop="choosedRole" label="选择角色">
                  <el-tooltip placement="right-start" class="add-account-tooltip">
                    <div slot="content">
                      <span class="el-icon-information"></span>
                      <br>
                      账号权限与角色权限同步，<br>
                      如不能满足，请重新建立角色!
                    </div>
                    <span class="el-icon-information"></span>
                  </el-tooltip>
                  <el-select v-model="relatedForm.choosedRole" @change="changeRole" placeholder="请选择角色">
                    <el-option v-for="item in relatedForm.role" :value="item.role_id"
                               :label="item.role_name"></el-option>
                  </el-select>
                </el-form-item>
                <el-form-item style="text-align: center;margin-top: 30px;">
                  <el-button type="primary" size="small" @click="confirmAccount('relatedForm')">确定</el-button>
                </el-form-item>
              </el-form>
            </div>
          </div>
          <!--账号权限-->
          <el-form v-else-if="activeStep === 2" :model="authorityForm" ref="authorityForm"
                   :rules="authorityRules"
                   class="account-authority" label-width="">
            <el-form-item prop="account" label="选择公众号">
              <el-select v-model="authorityForm.account" placeholder="请选择公众号" @change="getAuthorityData">
                <el-option v-for="item in relatedInforList" :label="item.publicInfo.inter_name"
                           :value="item.publicInfo.inter_id"></el-option>
              </el-select>
            </el-form-item>
            <div>
              <span>已选角色&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
              <span>{{authorityForm.role_name}}</span>
            </div>
            <template v-if="false">
              <div class="choose-all">
                <el-checkbox>全选</el-checkbox>
              </div>
              <!--账号权限表格-->
              <table>
                <tr>
                  <th>模块</th>
                  <th>权限</th>
                  <th>权限子项</th>
                </tr>
                <tr>
                  <td>
                    <el-checkbox>订房</el-checkbox>
                  </td>
                  <td colspan="2">
                    <ul class="combine-ul">
                      <li>
                        <div class="left-list">
                          <el-checkbox>订单管理</el-checkbox>
                        </div>
                        <div class="right-list">
                          <el-checkbox>查看列表</el-checkbox>
                          <el-checkbox>查看列表</el-checkbox>
                          <el-checkbox>查看列表</el-checkbox>
                          <el-checkbox>查看列表</el-checkbox>
                        </div>
                      </li>
                      <li>
                        <div class="left-list">
                          <el-checkbox>订单管理</el-checkbox>
                        </div>
                        <div class="right-list">
                          <el-checkbox>查看列表</el-checkbox>
                          <el-checkbox>查看列表</el-checkbox>
                          <el-checkbox>查看列表</el-checkbox>
                          <el-checkbox>查看列表</el-checkbox>
                        </div>
                      </li>
                      <li>
                        <div class="left-list">
                          <el-checkbox>订单管理</el-checkbox>
                        </div>
                        <div class="right-list">
                          <el-checkbox>查看列表</el-checkbox>
                          <el-checkbox>查看列表</el-checkbox>
                          <el-checkbox>查看列表</el-checkbox>
                          <el-checkbox>查看列表</el-checkbox>
                        </div>
                      </li>
                    </ul>
                  </td>
                </tr>
              </table>
            </template>
          </el-form>
        </div>
      </el-col>
    </el-row>
    <!--<div class="finish-btn">-->
    <!--<el-button type="primary" size="small">完成</el-button>-->
    <!--</div>-->
  </div>
</template>

<script>
  import {getAccountRelated, getRelatedHotel, getAccountAuthority, getAccountInfor} from '@/service/system/http'

  export default {
    name: 'addrole',
    created () {
      this.getEssentialInfor()
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
      var validatePass2 = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码！'))
        } else if (value !== this.accountInfor.password) {
          callback(new Error('两次输入密码不一致！'))
        } else {
          callback()
        }
      }
      return {
        loading: true,
        // 被编辑角色的id
        account_id: null,
        // 当前步骤
        activeStep: 0,
        addAccountShow: false,
        listShow: false,
        searchAccountValue: '',
        SuperTube: '',
        nextAlert: false,
        accountRules: {
          username: [{required: true, message: '请自定义角色名称', trigger: 'blur'},
            {min: 2, max: 20, message: '长度在 2 到 20 个字符', trigger: 'blur'}],
          nickname: [{required: true, message: '请自定义角色名称', trigger: 'blur'},
            {min: 2, max: 20, message: '长度在 2 到 20 个字符', trigger: 'blur'}],
          password: [{required: true, validator: validatePass, trigger: 'blur'}],
          repassword: [{required: true, validator: validatePass2, trigger: 'blur'}],
          status: [{required: true, message: '请选择您的状态', trigger: 'change'}]
        },
        accountInfor: {
          username: '',
          nickname: '',
          password: '',
          repassword: '',
          status: ''
        },
        relatedForm: {
          publicAccount: [],
          role: [],
          choosedPublicAccount: '',
          choosedRole: '',
          inter_name: '',
          role_name: ''
        },
        relatedRules: {
          choosedPublicAccount: [{required: true, message: '请选择公众号', trigger: 'change'}],
          choosedRole: [{required: true, message: '请选择角色', trigger: 'change'}]
        },
        // 关联的公众号 门店 店铺列表
        relatedInforList: [],
        current: {
          renderList: [],
          page: 1,
          size: 2,
          total: 0,
          searchValue: '',
          _from: 0,
          _to: 0,
          searchTotal: 0
        },
        // 权限
        authorityForm: {
          account: '',
          account_id: '',
          role_id: '',
          role_name: ''
        },
        authorityRules: {
          account: [{required: true, message: '请选择公众号'}]
        },
        chooseAll: false
      }
    },
    methods: {
      // 点击下一步
      nextStepBtn (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.getAccountData()
            this.nextStep()
          } else {
            return false
          }
        })
      },
      nextStep () {
        this.activeStep += 1
      },

      getAccountData () {
        getAccountRelated().then((res) => {
          this.relatedForm.publicAccount = res.web_data.public
          this.relatedForm.role = res.web_data.role
        })
      },
      // 获取账户信息
      getEssentialInfor () {
        getAccountInfor().then((res) => {
          this.SuperTube = res.web_data.SuperTube
        })
      },
      // 获取酒店，店铺数据
      getHotelData () {
        let getData = {
          inter_id: this.relatedForm.choosedPublicAccount,
          inter_name: this.relatedForm.inter_name,
          role_id: this.relatedForm.choosedRole,
          role_name: this.relatedForm.role_name
        }
        getRelatedHotel(getData).then((res) => {
          if (res.status === 1000) {
            this.addAccountShow = false
            this.relatedInforList.push(res.web_data)
            this.removeRepeat()
            this.current.total = this.relatedInforList.length
            this.toRenderList()
            this.setStatus(this.chooseAll)
            this.listShow = true
          }
        })
      },
      // 获取权限列表
      getAuthorityData (value) {
        let obj = this.relatedInforList.find((item) => {
          return item.publicInfo.inter_id === value
        })
        console.log(obj.role_id)
        getAccountAuthority({}).then((res) => {

        })
      },
      toRenderList () {
        let renderFrom = (this.current.page - 1) * this.current.size
        let renderTo = this.current.page * this.current.size
        this.current.renderList = this.relatedInforList.slice(renderFrom, renderTo)

        let renderLength = this.current.renderList.length
        if (this.keyword === '') {
          this.current.total = this.relatedInforList.length
        } else {
          this.current.searchTotal = this.relatedInforList.length
        }
        if (this.current.renderList.length === 0) {
          this.current._from = 0
        } else {
          this.current._from = (this.current.page - 1) * this.current.size + 1
        }
        if (renderLength < this.current.size) {
          this.current._to = (this.current.page - 1) * this.current.size + renderLength
        } else {
          this.current._to = this.current.page * this.current.size
        }
      },
      changeAccount (value) {
        let obj = {}
        obj = this.relatedForm.publicAccount.find((item) => {
          return item.inter_id === value
        })
        this.relatedForm.inter_name = obj.name
      },
      changeRole (value) {
        let obj = {}
        obj = this.relatedForm.role.find((item) => {
          return item.role_id === value
        })
        this.relatedForm.role_name = obj.role_name
      },
      addAccount () {
        this.addAccountShow = true
      },
      confirmAccount (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.getHotelData()
          } else {
            return false
          }
        })
      },
      // 删除已添加的公众号
      removeRepeat () {
        let arr = this.relatedForm.publicAccount
        for (let i = 0; i < arr.length; i++) {
          if (arr[i].inter_id === this.relatedForm.choosedPublicAccount) {
            this.relatedForm.choosedPublicAccount = ''
            arr.splice(i, 1)
          }
        }
      },
      // 关联角色点击下一步
      nextStepTwo () {
//        for (let i = 0; i < this.relatedInforList.length; i++) {
//          this.relatedInforList[i].publicInfo.status === true
//        }
        let choosedItem = this.relatedInforList.find((item) => {
          return item.publicInfo.status === true
        })
        if (choosedItem === undefined) {
          alert('请至少选择一个公众号！')
        } else {
          this.nextStep()
        }
      },
      // 切换页码
      changePage (value) {
        this.current.page = value
        this.toRenderList()
      },
      // 全选按钮
      chooseAllBtn () {
        this.setStatus(this.chooseAll)
      },
      // 设置状态
      setStatus (value) {
        for (let i = 0; i < this.relatedInforList.length; i++) {
          this.$set(this.relatedInforList[i].publicInfo, 'status', value)
          let tempHotels = this.relatedInforList[i].hotels
          for (let j = 0; j < tempHotels.length; j++) {
            let tempShops = this.relatedInforList[i].shops[j]
            this.$set(this.relatedInforList[i].hotels[j], 'status', value)
            for (let m = 0; m < tempShops.length; m++) {
              this.$set(this.relatedInforList[i].shops[j][m], 'status', value)
            }
          }
        }
      },
      // 取消新建
      cancelPopup () {
        this.addAccountShow = false
      }
    }
  }
</script>

<style lang="postcss">
  .add-account-outer {
    color: #48576a;
    .el-form-item {
      width: 600px;
      margin: 25px auto;
      position: relative;
      .el-form-item__label {
        width: 100px;
        text-align: left;
      }
      .el-form-item__error {
        margin-left: 100px;
      }
      .el-icon-information {
        position: absolute;
        left: 70px;
        top: 10px;
      }
      .el-select, .el-input {
        width: 500px;
      }
    }
    .el-steps {
      width: 830px;
      margin: 0 auto;
      margin-bottom: 20px;
    }
    .paging-block {
      width: 60%;
      height: 32px;
      margin: 0 auto;
      margin-top: 20px;
      text-align: center;
      .page-infor {
        float: left;
        span {
          margin: 0 10px;
          font-weight: bold;
        }
      }
    }
    .all-outer {
      padding: 15px 0;
    }
    .next-btn {
      position: fixed;
      left: 50%;
      margin-left: 372px;
      bottom: 20px;
      z-index: 10;
    }
    .create-account-box {
      width: 644px;
      padding-top: 30px;
      border: 1px solid #eee;
      position: fixed;
      background-color: #fff;
      left: 50%;
      margin-left: -322px;
      z-index: 10;
      top: 200px;
      .cancel-btn {
        position: absolute;
        right: 10px;
        top: 10px;
        color: #585151;
        cursor: pointer;
      }
    }
    .search-module {
      width: 300px;
      margin-top: 20px;
      .el-button {
        background-color: rgb(189, 169, 120);
        color: #fff;
        border-radius: 0;
      }
    }
    .choose-all {
      background-color: #f5f5f5;
      padding: 20px 0;
      margin-top: 20px;
      .el-checkbox {
        padding-left: 30px;
      }
    }
    table {
      width: 100%;
      background-color: #f5f5f5;
      text-align: left;
      border: 1px solid #d8cece;
      border-collapse: collapse;
      margin-bottom: 20px;
      th {
        padding: 10px 30px;
        border: 1px solid #d8cece;
      }
      td {
        padding: 10px 30px;
        border: 1px solid #d8cece;
      }
    }
    .combine-ul {
      li {
        list-style: none;
        &:after {
          clear: both;
          height: 0;
          content: "";
          display: block;
        }
      }
      .left-list, .right-list {
        width: 50%;
        float: left;
        margin: 10px 0 20px 0;
        .el-checkbox {
          margin-left: 15px;
        }
      }
    }
    .el-pagination {
      float: right;
    }
    .finish-btn {
      width: 100%;
      left: 0;
      background-color: #f5f5f5;
      padding: 10px 0;
      text-align: center;
      position: fixed;
      bottom: 0;
      z-index: 10;
      button {
        width: 120px;
        border-radius: 0;
      }
    }
    .account-authority {
      margin: 0 auto;
      .el-form-item {
        margin: 20px 0;
      }
    }
  }

  .el-tooltip__popper.is-dark {
    background-color: #fff;
    border: 1px solid #eee;
    color: #999;
    text-align: center;
    .popper__arrow {
      display: none;
    }
  }

</style>
