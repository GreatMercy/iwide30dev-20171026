<template>
  <div class="jfk-pages">
    <el-row :gutter="20">
        <el-form ref="search" :model="storeState.normal.search" label-width="120px">
          <el-col :span="9">
            <el-form-item label="转账时间">
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
          <el-col :span="9">
            <el-form-item label="酒店筛选">
              <el-col :span="11">
                <el-form-item>
                  <el-select filterable @change="formchange" v-model="storeState.normal.search.inter_id" placeholder="所有公众号">
                    <el-option v-for="item in storeState.publics" :key="item.inter_id" :label="item.name" :value="item.inter_id"></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="11" :offset="2">
                <el-form-item>
                  <el-select filterable v-model="storeState.normal.search.hotel_id" placeholder="所有酒店">
                    <el-option v-for="item in storeState.hotels" :key="item.hotel_id" :label="item.hotel_name" :value="item.hotel_id"></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
            </el-form-item>
          </el-col>
          <el-col :span="2">
                <el-button type="primary" @click="submitForm">查  询</el-button>
              </el-col>
          <el-col :span="4" style="text-align:right;">
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
          prop="add_time"
          label="转账时间"
          width="240px"
          >
        </el-table-column>
        <el-table-column
          prop="name"
          label="所属公众号"
          >
        </el-table-column>
        <el-table-column
          prop="hotel_name"
          label="所属门店"
          >
        </el-table-column>
        <el-table-column
          prop="amount"
          label="转账金额"
          width="180"
          >
        </el-table-column>
        <el-table-column
          prop="status"
          label="转账状态"
          width="180"
          >
        </el-table-column>
        <el-table-column
          prop="update_time"
          label="返回状态时间"
          width="220px"
          >
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
  // import qs from 'qs'
  export default {
    data () {
      return {
        storeState: store.state
      }
    },
    methods: {
      submitForm () {
        this.loadList()
      },
      datapicker1 (e) {
        this.storeState.normal.search.start_time = e
      },
      datapicker2 (e) {
        this.storeState.normal.search.end_time = e
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
      formchange () {
        store.getHotels({inter_id: this.storeState.normal.search.inter_id})
      },
      loadList () {
        let init = {
          inter_id: this.storeState.normal.search.inter_id,
          hotel_id: this.storeState.normal.search.hotel_id,
          start_time: this.storeState.normal.search.start_time,
          end_time: this.storeState.normal.search.end_time,
          offset: this.storeState.normal.page.current,
          limit: this.storeState.normal.page.page_size
        }
        store.getRecordList(init)
      }
    },
    mounted: function () {
      let init = {
        inter_id: this.storeState.normal.search.inter_id,
        hotel_id: this.storeState.normal.search.hotel_id,
        start_time: this.storeState.normal.search.start_time,
        end_time: this.storeState.normal.search.end_time,
        offset: this.storeState.normal.page.current,
        limit: this.storeState.normal.page.page_size
      }
      store.getRecordList(init)
      store.getPublics()
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
