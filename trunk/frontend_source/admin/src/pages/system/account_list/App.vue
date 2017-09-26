<template>
  <div class="jfk-pages account-list-outer" v-loading="loading">
    <el-row class="title">
      <el-col :span="24">
        <div class="grid-content">账号列表</div>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="4">
        <div class="grid-content">
          <div class="search-outer">
            <el-input v-model="searchRoleValue" @keyup.enter.native="searchRole()" placeholder="请输入公众号/用户名">
              <el-button slot="append" icon="search" @click="searchRole()">搜索</el-button>
            </el-input>
          </div>
        </div>
      </el-col>
      <el-col :span="20">
        <div class="grid-content">
          <el-button type="primary" class="add-new-btn" size="small" icon="plus"
            @click="locationHref(addUrl)">新增账号
          </el-button>
        </div>
      </el-col>
    </el-row>
    <el-row class="role-list">
      <el-col :span="24">
        <div class="grid-content">
          <!--为空-->
          <div class="tips" v-if="current.total === 0">您当前还未创建任何一个账号，赶紧新增一个吧！</div>
          <!--角色列表-->
          <el-table v-else :data="accountList" border width="100%">
            <el-table-column prop="admin_id" label="编号"></el-table-column>
            <el-table-column prop="inter_name" label="默认管理公众号" width="500"></el-table-column>
            <el-table-column prop="username" label="用户名"></el-table-column>
            <el-table-column prop="create_time" label="创建时间"></el-table-column>
            <el-table-column prop="status" label="状态"></el-table-column>
            <el-table-column label="操作">
              <template scope="scope">
                <!--前端路径-->
                <!--<el-button @click.native.prevent="locationHref('/system/edit_account?account_id='+scope.row.admin_id)" type="text"-->
                <!--size="small">-->
                <el-button @click.native.prevent="locationHref(scope.row.edit_url)" type="text"
                           size="small">
                  编辑
                </el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </el-col>
    </el-row>
    <!--分页-->
    <div class="block paging-block">
      <div class="page-infor">
        当前显示第<span>{{current.page}}</span>页
        纪录从<span>{{current.itemFrom}}</span>条到<span>{{current.itemTo}}</span>条,
        共
        <span v-if="searchRoleValue === ''">{{current.total}}</span>
        <span v-else>{{current.searchTotal}}</span>
        条
      </div>
      <el-pagination v-if="!isSearch" :page-size="current.size" :total=current.total
                     layout="prev, pager, next"
                     @current-change="changePage">
      </el-pagination>
      <el-pagination :page-size="current.size" :total="current.searchTotal" layout="prev, pager, next"
                     @current-change="changePage" v-else>
      </el-pagination>
    </div>
  </div>
</template>

<script>
  import {getAccountList} from '@/service/system/http'

  export default {
    name: 'accountList',
    created () {
      this.getAccountData()
    },
    data () {
      return {
        loading: true,
        addUrl: '',
        current: {
          page: 1,
          size: 20,
          itemFrom: 0,
          itemTo: 0,
          total: -1,
          searchTotal: 0
        },
        isSearch: false,
        searchRoleValue: '',
        keyword: '',
        accountList: []
      }
    },
    methods: {
      // 页面跳转
      locationHref (href) {
        window.location.href = href
      },
      // 获取账户列表
      getAccountData () {
        this.loading = true
        getAccountList({offset: this.current.page, limit: this.current.size, keyword: this.keyword}).then((res) => {
          this.loading = false
          this.accountList = res.web_data.list
          this.addUrl = res.web_data.add_url
          let accountLength = this.accountList.length
          if (this.isSearch) {
            this.current.searchTotal = parseInt(res.web_data.page.total)
          } else {
            this.current.total = parseInt(res.web_data.page.total)
          }
          this.current.itemFrom = (this.current.page - 1) * this.current.size + 1
          if (accountLength < this.current.size) {
            this.current.itemTo = (this.current.page - 1) * this.current.size + accountLength
          } else {
            this.current.itemTo = this.current.page * this.current.size
          }
        })
      },
      // 改变页码
      changePage (page) {
        this.current.page = page
        this.getAccountData()
      },
      // 搜索账户
      searchRole () {
        this.keyword = decodeURI(this.searchRoleValue)
        this.isSearch = true
        this.current.page = 1
        this.getAccountData()
      },
      deleteRow (index, rows) {
        rows.splice(index, 1)
      }
    }
  }
</script>

<style lang="postcss" scoped>
  .account-list-outer {
    color: #333;
    position: relative;
    .search-outer {
      margin: 20px 0;
    }
    .title {
      font-size: 16px;
      padding: 15px;
      font-weight: bold;
      background-color: #eef1f6;
    }

    .add-new-btn {
      float: right;
      margin-top: 15px;
    }

    .tips {
      padding: 20px;
      text-align: center;
      font-size: 15px;
    }

    .paging-block {
      width: 60%;
      height: 32px;
      margin: 0 auto;
      margin-top: 20px;
      text-align: center;
    }

    .paging-el {
      float: right;
      vertical-align: middle;
      margin-left: 10px;
    }

    .page-infor {
      float: left;
      span {
        margin: 0 10px;
        font-weight: bold;
      }
    }

    .el-pagination {
      float: right;
    }
  }
</style>
