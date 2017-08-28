<template>
  <div class="jfk-pages role-list-outer" v-loading="loading">
    <el-row class="title">
      <el-col :span="24">
        <div class="grid-content">角色列表</div>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="4">
        <div class="grid-content">
          <div class="search-outer">
            <el-input placeholder="请输入名称/角色类型" v-model="searchRoleValue" @keyup.enter.native="searchRole()">
              <el-button slot="append" icon="search" @click="searchRole()">搜索
              </el-button>
            </el-input>
          </div>
        </div>
      </el-col>
      <el-col :span="20">
        <div class="grid-content">
          <el-button type="primary" class="add-new-btn" size="small" icon="plus"
                     @click="locationHref(link)">新增角色
          </el-button>
        </div>
      </el-col>
    </el-row>
    <el-row class="role-list">
      <el-col :span="24">
        <div class="grid-content">
          <!--为空-->
          <div v-if="current.total === 0" class="tips">您当前还未创建任何一个角色，赶紧新增一个吧！</div>
          <!--角色列表-->
          <el-table v-else :data="roleList" border width="100%">
            <el-table-column prop="role_id" label="编号"></el-table-column>
            <el-table-column prop="role_name" label="名称" width="400"></el-table-column>
            <el-table-column prop="role_type" label="角色类型">
              <template scope="scope">
                {{scope.row.role_type === '1' ? '标准角色' : '自定义角色'}}
              </template>
            </el-table-column>
            <el-table-column prop="create_time" label="创建时间"></el-table-column>
            <el-table-column prop="status" label="状态">
              <template scope="scope">
                {{scope.row.status === '1' ? '有效' : '失效'}}
              </template>
            </el-table-column>
            <el-table-column label="操作">
              <template scope="scope">
                <el-button type="text" @click="locationHref(link+'?role_id='+scope.row.role_id)"
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
        纪录从<span>{{current._from}}</span>条到<span>{{current._to}}</span>条,
        共
        <span v-if="searchRoleValue ===''">{{current.total}}</span>
        <span v-else>{{current.searchTotal}}</span>
        条
      </div>
      <el-pagination v-if="searchRoleValue === ''" :page-size="current.size" :total=current.total
                     layout="prev, pager, next"
                     @current-change="changePage">
      </el-pagination>
      <el-pagination v-else :page-size="current.size" :total="current.searchTotal" layout="prev, pager, next"
                     @current-change="changePage">
      </el-pagination>
    </div>
  </div>
</template>

<script>
  import {getRoleList} from '@/service/system/http'

  export default {
    name: 'roleList',
    created () {
      this.getRoleData()
    },
    data () {
      return {
        roleList: [],
        current: {
          page: 1,
          size: 20,
          _from: 0,
          _to: 0,
          total: -1,
          searchTotal: 0
        },
        loading: true,
        searchRoleValue: '',
        keyword: '',
        link: ''
      }
    },
    methods: {
      // 页面跳转
      locationHref (href) {
        window.location.href = href
      },
      changePage (page) {
        this.current.page = page
        this.getRoleData()
      },
      // 获取角色列表
      getRoleData () {
        this.loading = true
        getRoleList({pages: this.current.page, size: this.current.size, keyword: this.keyword}).then((res) => {
          this.loading = false
          this.roleList = res.web_data.roles
          this.link = res.web_data.link
          let roleLength = this.roleList.length
          if (this.keyword === '') {
            this.current.total = parseInt(res.web_data.total)
          } else {
            this.current.searchTotal = parseInt(res.web_data.total)
          }
          if (roleLength === 0) {
            this.current._from = 0
          } else {
            this.current._from = (this.current.page - 1) * this.current.size + 1
          }
          if (roleLength < this.current.size) {
            this.current._to = (this.current.page - 1) * this.current.size + roleLength
          } else {
            this.current._to = this.current.page * this.current.size
          }
        })
      },
      searchRole () {
        this.keyword = decodeURI(this.searchRoleValue)
        this.current.page = 1
        this.getRoleData()
      }
    }
  }
</script>

<style lang="postcss" scoped>
  .role-list-outer {
    color: #333;
    position: relative;
    margin-top: 50px;
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
      margin-top: 25px;
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
