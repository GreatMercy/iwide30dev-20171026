<template>
  <div class="jfk-pages">
  <el-form ref="search" :model="storeState.normal.search" label-width="120px">
    <el-row :gutter="20">
      <el-col :span="18">
          <el-col :span="12">
            <el-form-item label="交易时间">
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
          <el-col :span="12">
            <el-form-item label="酒店筛选">
              <el-col :span="12">
                <el-form-item>
                  <el-select filterable @change="formchange" v-model="storeState.normal.search.inter_id" placeholder="所有公众号">
                    <el-option v-for="item in storeState.publics" :key="item.inter_id" :label="item.name" :value="item.inter_id"></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="12" style="padding-left:20px !important;">
                <el-form-item>
                  <el-select filterable v-model="storeState.normal.search.hotel_id" placeholder="所有酒店">
                    <el-option v-for="item in storeState.hotels" :key="item.hotel_id" :label="item.hotel_name" :value="item.hotel_id"></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
            </el-form-item>
          </el-col>
      </el-col>
      <el-col :span="2">
        <el-button type="primary" @click="submitForm('search')">查  询</el-button>
      </el-col>
      <el-col :span="4" style="text-align:right;">
        <el-button @click="output">导出数据</el-button>
      </el-col>
    </el-row>
    <el-row>
      <template v-if="more">
            <el-col :span="6">
              <el-form-item label="来源模块">
                <el-select v-model="storeState.normal.search.module" placeholder="请选择模块">
                  <el-option v-for="item in storeState.module" :key="item.value" :label="item.name" :value="item.value"></el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="6">
              <el-form-item label="订单状态">
                <el-select v-model="storeState.normal.search.order_status" placeholder="请选择订单状态">
                  <el-option v-for="item in storeState.order_status" :key="item.value" :label="item.name" :value="item.value"></el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="6">
              <el-form-item label="分账状态">
                <el-select v-model="storeState.normal.search.transfer_status" placeholder="请选择分账状态">
                  <el-option v-for="item in storeState.transfer_status" :key="item.value" :label="item.name" :value="item.value"></el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="6">
              <el-form-item label="订单号">
                <el-input v-model="storeState.normal.search.order_no"></el-input>
              </el-form-item>
            </el-col>
          </template>
    </el-row>
    <el-row>
            <el-form-item style="text-align:center;">
              <el-button type="text" @click="showmore">{{more ? '收起' : '打开'}}高级选项</el-button>
            </el-form-item>
          </el-row>
    </el-form>
    <el-row>
      <el-table
        :data="storeState.list"
        border
        style="width: 100%;font-size: 12px;"
        max-height="auto"
        class="jfk-table--no-border">
        <el-table-column
          prop="add_time"
          label="交易时间"
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
          prop="order_no"
          label="订单号"
          >
        </el-table-column>
        <el-table-column
          prop="module"
          label="来源模块"
          width="100px"
          >
        </el-table-column>
        <el-table-column
          prop="trans_amt"
          label="交易金额"
          width="100px"
          >
        </el-table-column>
        <el-table-column
          prop="is_dist"
          label="是否分销"
          width="100px"
          >
        </el-table-column>
        <el-table-column
          prop="order_status"
          label="订单状态"
          width="130px"
          >
        </el-table-column>
        <el-table-column
          prop="transfer_status"
          label="分账状态"
          width="100px"
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
  export default {
    data () {
      return {
        more: false,
        storeState: store.state
      }
    },
    methods: {
      showmore () {
        this.more = !this.more
        if (!this.more) {
          this.storeState.normal.search.order_status = ''
          this.storeState.normal.search.module = ''
          this.storeState.normal.search.transfer_status = ''
          this.storeState.normal.search.order_no = ''
        }
      },
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
          limit: this.storeState.normal.page.page_size,
          order_status: this.storeState.normal.search.order_status,
          module: this.storeState.normal.search.module,
          transfer_status: this.storeState.normal.search.transfer_status,
          order_no: this.storeState.normal.search.order_no
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
        limit: this.storeState.normal.page.page_size,
        order_status: this.storeState.normal.search.order_status,
        module: this.storeState.normal.search.module,
        transfer_status: this.storeState.normal.search.transfer_status,
        order_no: this.storeState.normal.search.order_no
      }
      store.getRecordList(init)
      store.getPublics()
      store.getSearch()
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
