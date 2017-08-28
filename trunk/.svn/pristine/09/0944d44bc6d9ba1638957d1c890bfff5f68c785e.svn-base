<template>
  <div class="jfk-pages jfk-pages__pancake-list">
    <el-row :gutter="20" class="jfk-mb-20">
      <el-col :span="12">
        <el-input size="small" placeholder="请输入活动名称" v-model="keyword">
          <el-button slot="append" icon="search"></el-button>
        </el-input>
      </el-col>
      <el-col :span="12" class="jfk-ta-r">
        <el-button type="info" size="small" icon="plus" :plain="true" class="jfk-button-tag-a">
          <a href="javascript:;">新增活动</a>
        </el-button>
      </el-col>
    </el-row>
    <div v-loading="tableLoading">
      <el-table
        ref="pancakeListTable"
        tooltip-effect="dark"
        style="width: 100%"
        :data="lists"
        class="jfk-table--wrap-header jfk-table__pancake-list"
        :class="pancakeListClass">
        <el-table-column
          align="center"
          label="编号">
        </el-table-column>
        <el-table-column
          align="center"
          label="活动名称">
        </el-table-column>
        <el-table-column
          align="center"
          label="每日免费投掷次数">
        </el-table-column>
        <el-table-column
          align="center"
          label="活动开始时间">
        </el-table-column>
        <el-table-column
          align="center"
          label="活动结束时间">
        </el-table-column>
        <el-table-column
          align="center"
          label="操作">
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>
<script>
  import { getPancakeList } from '@/service/pancake/http'
  export default {
    name: 'pancake-list',
    created () {
      let that = this
      getPancakeList({
        pageCurrent: 1,
        pageSize: this.size,
        name: ''
      }).then(function (res) {
        that.lists = res.web_data.data
        that.page = res.web_data.page_resource.page
        that.count = +res.web_data.page_resource.count
      })
    },
    data () {
      return {
        keyword: '',
        tableLoading: false,
        lists: [],
        page: 1,
        size: 20,
        count: 0
      }
    },
    computed: {
      pancakeListClass () {
        return {
          'jfk-table--no-border': this.lists.length > 1
        }
      }
    }
  }
</script>
