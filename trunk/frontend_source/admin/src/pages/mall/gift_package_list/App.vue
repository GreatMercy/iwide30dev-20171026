<template>
  <div class="gift-package-list__wrap">
    <el-form :model="form" :rules="rules" ref="form" :inline="true">
      <el-row class="gift-package-list__input">
        <el-form-item prop="startTime" class="gift-package-list__item">
          <el-date-picker
            type="date"
            size="small"
            @change="changeStartTime"
            v-model="form.startTime"
            placeholder="请选择开始时间">
          </el-date-picker>
        </el-form-item>

        <el-form-item prop="endTime" class="gift-package-list__item">
          <el-date-picker
            v-model="form.endTime"
            type="date"
            size="small"
            @change="changeEndTime"
            placeholder="请选择结束时间">
          </el-date-picker>
        </el-form-item>

        <el-form-item class="gift-package-list__item">
          <el-input size="small" placeholder="订单号" v-model="orderId"></el-input>
        </el-form-item>

        <el-form-item class="gift-package-list__item">
          <el-input size="small" placeholder="创建人" v-model="name"></el-input>
        </el-form-item>

        <el-form-item class="gift-package-list__item">
          <el-input size="small" placeholder="登记信息" v-model="info"></el-input>
        </el-form-item>

        <el-form-item class="gift-package-list__item">
          <el-button type="primary" icon="search" size="small" @click="search">查&nbsp;&nbsp;找</el-button>
        </el-form-item>

        <el-form-item class="gift-package-list__item is-special">
          <el-button size="small" @click="exportTable">导出报表</el-button>
        </el-form-item>
      </el-row>
    </el-form>

    <el-row class="gift-package-list__table">
      <el-table :data="list" :class="{'jfk-table--no-border': tableClass['jfk-table--no-border']}"
                v-loading.body="loading">
        <el-table-column prop="order_id" label="订单号" align="center"></el-table-column>
        <el-table-column prop="name" label="商品名称" align="center"></el-table-column>
        <el-table-column prop="saler_name" label="创建人" align="center"></el-table-column>
        <el-table-column prop="record_info" label="登记信息" align="center"></el-table-column>
        <el-table-column prop="nickname" label="领取人" align="center"></el-table-column>
        <el-table-column prop="add_time" label="领取时间" align="center"></el-table-column>
        <el-table-column prop="gift_num" label="领取份数" align="center"></el-table-column>
        <el-table-column prop="order_code_num" label="券码数量" align="center"></el-table-column>
        <el-table-column prop="consume_num" label="已核销券码数量" align="center"></el-table-column>
      </el-table>
      <el-pagination
        v-if="list.length > 0"
        @current-change="handleCurrentChange"
        :current-page.sync="page"
        :page-size="pageSize"
        layout="total, prev, pager, next"
        :total="total">
      </el-pagination>
    </el-row>
  </div>
</template>
<script>
  import { getGiftDeliveryReceiveList } from '@/service/mall/http'
  import moment from 'moment'
  export default {
    components: {},
    computed: {
      tableClass () {
        return {
          'jfk-table--no-border': this.list.length > 1
        }
      }
    },
    data () {
      const validateEndDate = (rule, value, callback) => {
        if (this.form.startTime !== '' && value !== '') {
          if (moment(this.form.startTime).valueOf() > moment(value).valueOf()) {
            callback(new Error('结束时间不小于开始时间'))
          } else {
            callback()
          }
        } else {
          callback()
        }
      }
      const validateStartDate = (rule, value, callback) => {
        if (this.form.startTime !== '' && value !== '') {
          if (moment(this.form.startTime).valueOf() > moment(this.form.endTime).valueOf()) {
            callback(new Error('开始时间不大于结束时间'))
          } else {
            callback()
          }
        } else {
          callback()
        }
      }
      return {
        rules: {
          endTime: [
            {validator: validateEndDate, trigger: 'change'}
          ],
          startTime: [
            {validator: validateStartDate, trigger: 'change'}
          ]
        },
        form: {
          startTime: '',
          endTime: ''
        },
        loading: false,
        page: 1,
        pageSize: 20,
        total: '',
        csrf: {},
        list: [],
        orderId: '', // 订单id
        name: '', // 创建人
        info: '', // 登记信息
        btnLoading: false
      }
    },
    created () {
      this.getResult()
    },
    methods: {
      // 选择开始时间
      changeStartTime (value) {
        this.form.startTime = value
      },
      // 选择结束时间
      changeEndTime (value) {
        this.form.endTime = value
      },
      exportTable () {
        const data = {
          order_id: this.orderId || '',
          startTime: this.form.startTime || '',
          endTime: this.form.endTime || '',
          recordInfo: this.info || '',
          salerName: this.name || ''
        }
        window.open(`/index.php/soma/gift_delivery/exportGiftExcel?order_id=${data.order_id}&start_time=${data.startTime}&end_time=${data.endTime}&record_info=${data.recordInfo}&saler_name=${data.salerName}`)
      },
      // 搜索
      search () {
        this.page = 1
        this.getResult()
      },
      getResult () {
        this.loading = true
        getGiftDeliveryReceiveList({
          'order_id': this.orderId || '',
          'page': this.page || '',
          'start_time': this.form.startTime || '',
          'end_time': this.form.endTime || '',
          'record_info': this.info || '',
          'saler_name': this.name || ''
        }).then((res) => {
          const content = res['web_data']
          this.list = content['items']
          this.pageSize = content['page_resource']['size']
          this.total = content['page_resource']['count']
          this.loading = false
        }).catch(() => {
          this.loading = false
        })
      },
      handleCurrentChange () {
        this.getResult()
      }
    }
  }
</script>
<style lang="postcss" scoped>
  .gift-package-list {
    &__wrap {
      background-color: #ffffff;
      padding: 30px;
    }
    &__item {
      float: left;
      margin-right: 20px;

      &.is-special {
        float: right;
        margin-right: 0;
      }
    }
    &__table {
      .el-pagination {
        margin-top: 20px;
        text-align: center;
      }
    }
  }
</style>
