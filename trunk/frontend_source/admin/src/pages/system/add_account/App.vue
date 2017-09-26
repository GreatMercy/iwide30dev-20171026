<template>
  <div class="jfk-pages add-account-outer">
    <el-row>
      <el-col :span="24">
        <div class="grid-content">
          <!--步骤-->
          <el-steps :space="400" :active="activeStep" finish-status="success" class="jfk-steps--bg-gray jfk-steps">
            <el-step title="基础信息"></el-step>
            <el-step title="关联公众号"></el-step>
            <el-step v-if="this.SuperTube === '1'" title="账号权限"></el-step>
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
            <el-form-item label="状态" prop="status">
              <el-select v-model="accountInfor.status" placeholder="状态">
                <el-option label="有效" value="有效"></el-option>
                <el-option label="无效" value="无效"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" size="small" style="margin-left: 70px" @click="oneNextBtn('accountInfor')">
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
                <el-checkbox v-model="chooseAll" @change="chooseAllAction">全选</el-checkbox>
              </div>
              <table class="public-account-table">
                <tr>
                  <th width="28%">关联公众号</th>
                  <th width="16%">角色类型</th>
                  <th width="28%">门店</th>
                  <th width="28%">店铺</th>
                </tr>
                <tr v-for="(item,index) in current.renderList">
                  <!--公众号信息-->
                  <td>
                    <el-checkbox v-model="item.publicInfo.status" @change="choosePublic(index)" class="ml-15">
                      {{item.publicInfo.inter_name}}
                    </el-checkbox>
                  </td>
                  <!--关联角色-->
                  <td><span class="ml-15">{{item.publicInfo.role_name}}</span></td>
                  <td colspan="2">
                    <ul class="combine-ul">
                      <li v-for="(item1,index1) in item.hotels">
                        <div class="left-list">
                          <!--启用-->
                          <!--门店-->
                          <el-checkbox v-if="item.publicInfo.status" v-model="item1.status">{{item1.hotel_name}}
                          </el-checkbox>
                          <!--禁用-->
                          <el-checkbox v-else disabled v-model="item1.status">{{item1.hotel_name}}</el-checkbox>
                        </div>
                        <div class="right-list">
                          <template v-for="item2 in item.shops[index1]">
                            <!--启用-->
                            <!--店铺-->
                            <el-checkbox v-if="item.publicInfo.status && item1.status" v-model="item2.status">
                              {{item2.shop_name}}
                            </el-checkbox>
                            <!--禁用-->
                            <el-checkbox v-else disabled>{{item2.shop_name}}</el-checkbox>
                          </template>
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
                <el-button type="primary" size="small" @click="twoPrevStep()">上一步</el-button>
                <el-button type="primary" size="small" v-if="this.SuperTube ==='1'" @click="twoNextStep()">下一步
                </el-button>
              </div>
              <div class="finish-btn" v-if="this.SuperTube ==='0'">
                <el-button type="primary" @click="postNewAccount()" size="small">完成</el-button>
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
                               :label="item.name" :key="item.inter_id"></el-option>
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
                               :label="item.role_name" :key="item.role_id"></el-option>
                  </el-select>
                </el-form-item>
                <el-form-item style="text-align: center;margin-top: 30px;">
                  <el-button type="primary" size="small" @click="confirmAccount('relatedForm')">确定</el-button>
                </el-form-item>
              </el-form>
            </div>
          </div>
          <!--账号权限-->
          <el-form v-else-if="activeStep === 2" :model="authorityForm" ref="authorityForm" :rules="authorityRules"
                   class="account-authority" label-width="">
            <el-form-item prop="account" label="选择公众号">
              <el-select v-model="authorityForm.account" placeholder="请选择公众号" @change="getAuthorityData">
                <el-option v-for="item in selectedAccountRole" :label="item.publicInfo.inter_name"
                           :value="item.publicInfo.inter_id" :key="item.index"></el-option>
              </el-select>
            </el-form-item>
            <div>
              <span>已选角色&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
              <span>{{authorityForm.role_name}}</span>
            </div>
            <template v-if="authorityList">
              <div class="choose-all">
                <el-checkbox @change="chooseAllAuthority" v-model="chooseAllAuth">全选</el-checkbox>
              </div>
              <!--账号权限表格-->
              <table>
                <tr>
                  <th>模块</th>
                  <th>权限</th>
                  <th>权限子项</th>
                </tr>
                <tr v-for="key in authorityList">
                  <td class="module_name">
                    <el-checkbox v-model="key.status" @change="chooseModuleAction(key)">{{key.name}}</el-checkbox>
                  </td>
                  <td colspan="2">
                    <ul class="combine-ul">
                      <li v-for="key1 in key.controllers">
                        <div class="left-list">
                          <!--启用-->
                          <el-checkbox v-if="key.status" v-model="key1.status"
                                       @change="chooseAuthorityAction(key,key1)">{{key1.name}}
                          </el-checkbox>
                          <!--禁用-->
                          <el-checkbox v-else disabled>{{key1.name}}</el-checkbox>
                        </div>
                        <div class="right-list">
                          <!--启用-->
                          <!--<span>{{key1.status}}</span>-->
                          <template v-for="key2 in key1.funcs">
                            <el-checkbox v-if="key1.status" v-model="key2.status">
                              {{key2.name}}
                            </el-checkbox>
                            <!--禁用-->
                            <el-checkbox v-else disabled>
                              {{key2.name}}
                            </el-checkbox>
                          </template>
                        </div>
                      </li>
                    </ul>
                  </td>
                </tr>
              </table>
            </template>
            <div class="prev-btn">
              <el-button type="primary" size="small" @click="threePrevStep()">上一步</el-button>
            </div>
            <div class="finish-btn" v-if="!loading">
              <el-button type="primary" @click="postNewAccount()" size="small">完成</el-button>
            </div>
          </el-form>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import {
    getAccountRelated,
    getRelatedHotel,
    getAccountInfor,
    getAccountAuthority,
    postAccountData,
    getAccountRole
  } from '@/service/system/http'
  import {showFullLayer, formatUrlParams} from '@/utils/utils'

  export default {
    name: 'addAccount',
    created () {
      // 获取账号id
      this.urlParam = formatUrlParams(window.location.href)
//      console.log(this.urlParam)
      this.getEssentialInfor()
      this.getAccountData()
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
        urlParam: {},
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
        bindWXpopup: null,
        // 新增关联公众号时 弹窗内的公众号列表
        relatedForm: {
          // 获取的公众号列表
          publicAccount: [],
          role: [],
          // 选中的公众号
          choosedPublicAccount: '',
          choosedRole: '',
          inter_name: '',
          role_name: ''
        },
        relatedRules: {
          choosedPublicAccount: [{required: true, message: '请选择公众号', trigger: 'change'}],
          choosedRole: [{required: true, message: '请选择角色', trigger: 'change'}]
        },
        // 关联的所有公众号 门店 店铺列表 包含所有（勾选，非勾选）
        relatedInforList: [],
        current: {
          // 因为有分页 本列表显示的当前页面的项
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
        chooseAll: false,
        choosedAccountId: [],
        authorityList: [],
        totalAuthority: [],
        chooseAllAuth: false,
        selectedAccountRole: []
      }
    },
    methods: {
      // 基础信息点击下一步
      oneNextBtn (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.getAccountData()
            this.addStep()
          } else {
            return false
          }
        })
        // 浏览器返回
        const cb = () => {
          // 建议写死 因为多次返回 会使step值一直减少
          this.activeStep = 0
        }
        showFullLayer(null, '填写基础信息', location.href, cb)
      },
      addStep () {
        this.activeStep += 1
      },
      // 上一步
      twoPrevStep () {
        this.activeStep = 0
      },
      // 关联公众号点击下一步
      twoNextStep () {
        let choosedItem = this.relatedInforList.find((item) => {
          return item.publicInfo.status === true
        })
        this.selectedAccountRole.length = 0
        for (let j = 0; j < this.relatedInforList.length; j++) {
          if (this.relatedInforList[j].publicInfo.status === true) {
            this.selectedAccountRole.push({'index': j, 'publicInfo': this.relatedInforList[j].publicInfo})
          }
        }
        if (choosedItem === undefined) {
          alert('请至少选择一个公众号！')
        } else {
          this.addStep()
          const cb = () => {
            // 建议写死 因为多次返回 会使step值一直减少
            this.activeStep = 1
          }
          showFullLayer(null, '关联公众号', location.href, cb)
        }
      },
      // 账号权限上一步
      threePrevStep () {
        this.activeStep = 1
      },
      // 获取可以关联的公众号列表
      getAccountData () {
        getAccountRelated().then((res) => {
          this.relatedForm.publicAccount = res.web_data.public
        })
      },
      // 获取账户信息
      getEssentialInfor () {
        getAccountInfor().then((res) => {
          // SuperTube 为1的时候 为超管 为0的时候 为普通管理员
          this.SuperTube = res.web_data.SuperTube
//          console.log(this.SuperTube)
        })
      },
      // 新增关联公众号 获取酒店，店铺数据
      getHotelData () {
        let getData = {
          interId: this.relatedForm.choosedPublicAccount,
          inter_name: this.relatedForm.inter_name,
          role_id: this.relatedForm.choosedRole,
          role_name: this.relatedForm.role_name
        }
        getRelatedHotel(getData).then((res) => {
          if (res.status === 1000) {
            this.addAccountShow = false
            this.relatedInforList.push(res.web_data)
            this.removeRepeat()
            let length = this.relatedInforList.length
            this.current.total = length
            this.toRenderList()
            // 将最后添加的公众号默认状态设为未勾选
            this.$set(this.relatedInforList[length - 1].publicInfo, 'status', false)
            // 将店铺等勾选信息也设为false x12测试新增公众号是否被勾选
//            this.setStatus(this.relatedInforList[length - 1].publicInfo.status)
            this.listShow = true
          }
        })
      },
      // 获取权限列表
      getAuthorityData (value) {
        let obj = this.selectedAccountRole.find((item) => {
          // 返回公众id等于value 的项
          return item.publicInfo.inter_id === value
        })
//        console.log('绑定的index是')
//        console.log(obj.index)
        this.authorityForm.role_name = obj.publicInfo.role_name
        let getData = {
          role_id: obj.publicInfo.role_id,
          interId: value
        }
        // 获取权限
        if (obj.hasRequest) {
          this.authorityList = this.relatedInforList[obj.index].authority
          console.log(this.authorityList)
        } else {
          getAccountAuthority(getData).then((res) => {
            this.$set(obj, 'hasRequest', true)
            this.loading = false
            this.authorityList = res.web_data
            for (let key in this.authorityList) {
              let moduleName = this.authorityList[key]
              this.$set(moduleName, 'status', moduleName.check === 1)
              let controllers = moduleName.controllers
              for (let key1 in controllers) {
                this.$set(controllers[key1], 'status', controllers[key1].check === 1)
                let funcs = controllers[key1].funcs
                for (let key2 in funcs) {
                  this.$set(funcs[key2], 'status', funcs[key2].check === 1)
                }
              }
            }
            this.relatedInforList[obj.index].authority = this.authorityList
            this.authorityList.length = 0
//          console.log('权限集合')
//          console.log(this.relatedInforList[obj.index].authority)
//          console.log(this.authorityList)
          })
        }
      },
      // 渲染关联的公众号列表
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
        getAccountRole({interId: value}).then((res) => {
          this.relatedForm.role = res.web_data.role
        })
        this.relatedForm.inter_name = obj.name
        // x8 测试权限集合是否生效
//        console.log(this.totalAuthority)
      },
      changeRole (value) {
        let obj = {}
        obj = this.relatedForm.role.find((item) => {
          return item.role_id === value
        })
        this.relatedForm.role_name = obj.role_name
      },
      addAccount () {
        this.relatedForm.choosedPublicAccount = ''
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
      // 设置状态
      setStatus (value) {
        for (let i = 0; i < this.relatedInforList.length; i++) {
          if (this.relatedInforList[i].publicInfo) {
            this.$set(this.relatedInforList[i].publicInfo, 'status', value)
          }
          let tempHotels = this.relatedInforList[i].hotels
          if (tempHotels) {
            for (let j = 0; j < tempHotels.length; j++) {
              let tempShops = this.relatedInforList[i].shops[j]
              if (tempShops) {
                this.$set(this.relatedInforList[i].hotels[j], 'status', value)
                for (let m = 0; m < tempShops.length; m++) {
                  this.$set(this.relatedInforList[i].shops[j][m], 'status', value)
                }
              }
            }
          }
        }
      },
      // 选择公众号
      choosePublic (index) {
        // 某公众号下的信息 每次获取一个公众号信息 x16 下标问题
        let realIndex = (this.current.page - 1) * this.current.size + index
        let ob = this.relatedInforList[realIndex].publicInfo.status
        let shops = this.relatedInforList[realIndex].shops
        let hotels = this.relatedInforList[realIndex].hotels
        for (let i = 0; i < hotels.length; i++) {
          if (hotels[i]) {
            this.$set(hotels[i], 'status', ob)
          }
          if (shops[i]) {
            for (let j = 0; j < shops[i].length; j++) {
              if (shops[i][j]) {
                this.$set(shops[i][j], 'status', ob)
              }
            }
          }
        }
      },
      // 切换页码
      changePage (value) {
        this.current.page = value
        this.toRenderList()
      },
      // 全选按钮
      chooseAllAction () {
        this.setStatus(this.chooseAll)
      },
      // 全选权限
      chooseAllAuthority () {
        for (let key in this.authorityList) {
          let moduleName = this.authorityList[key]
          if (moduleName) {
            this.$set(moduleName, 'status', this.chooseAllAuth)
            let controllers = moduleName.controllers
            if (moduleName.controllers) {
              for (let key1 in controllers) {
                if (key1) {
                  this.$set(controllers[key1], 'status', this.chooseAllAuth)
                  let funcs = controllers[key1].funcs
                  if (funcs) {
                    for (let key2 in funcs) {
                      this.$set(funcs[key2], 'status', this.chooseAllAuth)
                    }
                  }
                }
              }
            }
          }
        }
      },
      // 权限配置 选择模块
      chooseModuleAction (key) {
        let moduleName = key
        let controllers = moduleName.controllers
        for (let key1 in controllers) {
          this.$set(controllers[key1], 'status', key.status)
          let funcs = controllers[key1].funcs
          for (let key2 in funcs) {
            this.$set(funcs[key2], 'status', key.status)
          }
        }
      },
      // 权限配置 选择权限
      chooseAuthorityAction (key, key1) {
        let funcs = key1.funcs
        for (let key2 in funcs) {
          this.$set(funcs[key2], 'status', key1.status)
        }
      },
      // 取消新建
      cancelPopup () {
        this.addAccountShow = false
      },
      // 提交数据
      postNewAccount () {
        let ids = {}
        // 关联的公众号及酒店数据
        for (let i = 0; i < this.relatedInforList.length; i++) {
          let publicInfo = this.relatedInforList[i].publicInfo
          let hotels = this.relatedInforList[i].hotels
          let shops = this.relatedInforList[i].shops
          if (publicInfo.status === true) {
            ids.inter_id = publicInfo.inter_id
            ids.role_id = publicInfo.role_id
          }
          let entityId = []
          for (let j = 0; j < hotels.length; j++) {
            if (hotels[j].status === true) {
              let shopIds = []
              if (shops[j]) {
                for (let m = 0; m < shops[j].length; m++) {
                  shopIds.push(shops[j][m].shop_id)
                }
              }
              entityId.push({'shop_id': shopIds, 'hotel_id': hotels[j].hotel_id})
            }
          }
          ids.entity_id = entityId
          // 权限数据 写法问题
          let itemAuthor = this.relatedInforList[i].authority
//          console.log('获取数组里面绑定的权限')
//          console.log(itemAuthor)
          let moduleArr = {}
          if (itemAuthor) {
            for (let h in itemAuthor) {
              // 获取每一个模块
              let module = itemAuthor[h]
              let controllersArr = {}
              let funcsArr = {}
              if (module.status === true) {
                // 若模块为选中状态
                for (let h1 in module.controllers) {
                  // 模块下面的权限
                  let contorllers = module.controllers[h1]
                  // 若模块为选中状态
                  if (contorllers.status === true) {
                    for (let h2 in contorllers.funcs) {
                      let funcs = contorllers.funcs[h2]
                      if (funcs.status === true) {
                        console.log('选中的key是:')
                        console.log(h2)
                        funcsArr[h2] = []
                      }
                    }
                    controllersArr[h1] = funcsArr
                    funcsArr = {}
                  }
                }
                moduleArr[h] = controllersArr
              }
            }
          }
          ids.authority = JSON.stringify(moduleArr)
//          console.log('权限的数据')
//          console.log(moduleArr)
//           所有id是
          this.choosedAccountId[i] = ids
        }
//        console.log('总数据')
//        console.log(this.choosedAccountId)
        this.choosedAccountId = this.choosedAccountId
        let postData = {
          username: this.accountInfor.username,
          nickname: this.accountInfor.nickname,
          password: this.accountInfor.password,
          confirmPwd: this.accountInfor.repassword,
          status: this.accountInfor.status === '有效' ? 1 : 0,
          interInfo: this.choosedAccountId
        }
        console.log('参数:')
        console.log(postData)
        postAccountData(postData).then((res) => {
//         新增成功 跳转 链接
          window.location.href = res.web_data.url
        })
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
      text-align: center;
      margin-bottom: 20px;
      margin-left: 400px;
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
    .prev-btn {
      margin-left: 260px;
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
        padding: 15px 0;
        text-align: center;
        border: 1px solid #d8cece;
      }
      td {
        text-align: left;
        border: 1px solid #d8cece;
        .ml-15 {
          margin-left: 15px;
        }
      }
      .module_name {
        .el-checkbox {
          margin-left: 15px;
        }
      }
    }
    .el-popover {
      text-align: center;
    }
    .combine-ul {
      margin-bottom: -2px;
      min-height: 50px;
      li {
        list-style: none;
        border-bottom: 1px solid #d8cece;
        position: relative;
        &::after {
          clear: both;
          height: 0;
          content: "";
          display: block;
        }
        &::before {
          content: "";
          position: absolute;
          height: 100%;
          width: 1px;
          background-color: #d8cece;
          right: 50%;
        }
      }
      .left-list, .right-list {
        width: 50%;
        float: left;
        padding: 15px 0 5px 0;
        .el-checkbox {
          margin-left: 15px;
          margin-bottom: 10px;
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
