<template>
  <div class="jfk-pages">
    <el-row :gutter="20">
      <el-form :model="storeState.normal.search" label-width="100px">
        <el-col :span="8">
          <el-form-item label="修改时间">
            <el-col :span="11">
              <el-form-item>
                <el-date-picker type="date" placeholder="选择日期" v-model="storeState.normal.search.date1" @change="datapicker1" style="width: 100%;"></el-date-picker>
              </el-form-item>
            </el-col>
            <el-col class="line" :span="2">至</el-col>
            <el-col :span="11">
              <el-form-item>
                <el-date-picker type="date" placeholder="选择日期" v-model="storeState.normal.search.date2" @change="datapicker2" style="width: 100%;"></el-date-picker>
              </el-form-item>
            </el-col>
          </el-form-item>
        </el-col>
        <el-col :span="8">
          <el-form-item label="所属门店">
            <el-select filterable v-model="storeState.normal.search.hotel_id" placeholder="所有门店">
              <el-option v-for="item in storeState.hotels" :key="item.hotel_id" :label="item.hotel_name" :value="item.hotel_id"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="2">
          <el-button type="primary" @click="submitForm()">查  询</el-button>
        </el-col>
        <el-col :span="6" style="text-align:right;">
            <el-button @click="newrule">创建规则</el-button>
            <el-button @click="output">导出数据</el-button>
        </el-col>
      </el-form>
    </el-row>
    <el-row>
      <el-table
        :data="storeState.list"
        border
        style="width: 100%"
        max-height="auto"
        class="jfk-table--no-border">
        <el-table-column
          prop="edit_time"
          label="修改时间"
          >
        </el-table-column>
        <el-table-column
          prop="hotel_name"
          label="所属门店"
          >
        </el-table-column>
        <el-table-column
          prop="module"
          label="生效模块"
          width="180px"
          >
        </el-table-column>
        <el-table-column
          prop="status"
          label="状态"
          width="150px"
          >
        </el-table-column>
        <el-table-column
          label="操作"
          width="180px"
          >
          <template scope="scope">
            <el-button
              @click.native.prevent="seeRow(scope.$index, tableData4)"
              type="text"
              size="small">
              查看
            </el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row type="flex" justify="end" style="margin-top:20px;">
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page.sync="storeState.normal.page.current"
        :page-sizes="[10, 20, 30, 40]"
        :page-size="storeState.normal.page.page_size"
        layout="sizes, prev, pager, next, jumper"
        :total="storeState.normal.page.total">
      </el-pagination>
    </el-row>
  </div>
</template>
<script>
  import store from './store/main'
  export default {
    data () {
      return {
        id: '',
        storeState: store.state
      }
    },
    methods: {
      newrule () {
        let url = this.storeState.create
        window.location = url
      },
      datapicker1 (e) {
        this.storeState.normal.search.start_time = e
      },
      datapicker2 (e) {
        this.storeState.normal.search.end_time = e
      },
      seeRow (e) {
        let url = this.storeState.list[e].url
        window.location = url
      },
      submitForm () {
        this.loadList()
      },
      output () {
        let url = this.storeState.ext_data
        window.location = url
      },
      handleSizeChange (e) {
        this.storeState.normal.page.page_size = e
        this.loadList()
      },
      handleCurrentChange (e) {
        this.storeState.normal.page.current = e
        this.loadList()
      },
      getQueryString (name) {
        let reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i')
        let r = window.location.search.substr(1).match(reg)
        if (r != null) {
          return unescape(r[2])
        }
        return null
      },
      loadList () {
        let init = {
          inter_id: this.inter_id,
          hotel_id: this.storeState.normal.search.hotel_id,
          start_time: this.storeState.normal.search.start_time,
          end_time: this.storeState.normal.search.end_time,
          offset: this.storeState.normal.page.current,
          limit: this.storeState.normal.page.page_size
        }
        store.getSplitDetails(init)
      }
    },
    mounted: function () {
      this.inter_id = this.getQueryString('inter_id')
      let init = {
        inter_id: this.inter_id,
        hotel_id: this.storeState.normal.search.hotel_id,
        start_time: this.storeState.normal.search.start_time,
        end_time: this.storeState.normal.search.end_time,
        offset: this.storeState.normal.page.current,
        limit: this.storeState.normal.page.page_size
      }
      store.getSplitDetails(init)
      store.getHotels({inter_id: this.inter_id})
    }
  }
</script>
<style>
  .line{
    text-align: center;
  }
  .el-select{
    width: 100%;
  }
  .el-row{
    margin:10px 0px;
  }
  .danger{
    color: #FF4949;
  }
  .jfk-pages{
  padding-top: 2.7%;
}
.el-table--border th, .el-table--border td {
    border-right: 0px !important;
}
.el-col .el-col{
  padding: 0px !important;
}
</style>
