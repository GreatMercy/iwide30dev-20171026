<template>
  <div class="jfk-pages">
      <el-form ref="search"  label-width="120px">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-form-item label="筛选时间">
              <el-col :span="11">
                <el-form-item>
                  <el-date-picker type="date" placeholder="选择日期"  style="width: 100%;" v-model="startTime"></el-date-picker>
                </el-form-item>
              </el-col>
              <el-col class="line" :span="2">至</el-col>
              <el-col :span="11">
                <el-form-item prop="date2">
                  <el-date-picker type="date" placeholder="选择日期"  style="width: 100%;" v-model="endTime"></el-date-picker>
                </el-form-item>
              </el-col>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label="酒店筛选">
              <el-col :span="11">
                <el-select v-model="selectedPublic"  placeholder="所有公众号" filterable  @change="handleSelectPublic">
                    <el-option
                      v-for="(item, idx) in pulbic"
                      :key="item.inter_id"
                      :label="item.name"
                      :value="item.inter_id">
                    </el-option>
                </el-select>
              </el-col>
              <el-col :span="2"></el-col>
              <el-col :span="11">
                <el-select v-model="selectedHotel"  placeholder="所有酒店" filterable>
                    <el-option
                      v-for="(item, idx) in getHotels"
                      :key="item.status"
                      :label="item.hotel_name"
                      :value="item.hotel_id">
                    </el-option>
                </el-select>
              </el-col>              

            </el-form-item>
          </el-col>       
          <el-col :span="4">
              <el-button type="primary" @click="filterBankAccount()">查询</el-button>
          </el-col>
        </el-row>
      </el-form>
      
      <el-row :gutter="20" class="pricetag" type="flex" justify="space-around">
        <el-col :span="3">
          <span>监管账户余额</span>
          <p>{{capitalOverview.total_amount}}</p>
        </el-col>
        <el-col :span="3">
          <span>用户支付金额</span>
          <p>{{capitalOverview.pay_amount}}</p>
        </el-col>
        <el-col :span="3">
          <span>退款金额</span>
          <p>{{capitalOverview.refund_amount}}</p>
        </el-col>
        <el-col :span="3">
          <span>提现金额</span>
          <p>{{capitalOverview.withdraw_amount}}</p>
        </el-col>
        <el-col :span="3">
          <span>金房卡佣金</span>
          <p>{{capitalOverview.commission}}</p>
        </el-col>
        <el-col :span="3">
          <span>分销佣金</span>
          <p>{{capitalOverview.distribution}}</p>
        </el-col>
        <el-col :span="3">
          <span>欠款金额</span>
          <p>{{capitalOverview.arrears_amount}}</p>
        </el-col>                  
      </el-row>
      <el-row :gutter="20" style="text-align: right;margin-top: 50px;">
        <a :href="exportData"> 
        <el-button >导出数据</el-button>
        </a>
        
      </el-row>      
      <el-table
        :data="tableData"
        stripe
        style="width: 100%;margin-top: 40px" >
            <el-table-column
              prop="name"
              label="所属公众号">
            </el-table-column>
            <el-table-column
              prop="hotel_name"
              label="所属门店">
            </el-table-column>
            <el-table-column
              prop="total_amount"
              label="监管账户余额"
              width="130">
            </el-table-column>
            <el-table-column
              prop="pay_amount"
              label="用户支付金额"
              width="130">
            </el-table-column>  
            <el-table-column
              prop="refund_amount"
              label="退款金额"
              width="100">
            </el-table-column> 
            <el-table-column
              prop="withdraw_amount"
              label="提现金额"
              width="100">
            </el-table-column>
            <el-table-column
              prop="commission"
              label="金房卡佣金"
              width="100">
            </el-table-column>  
            <el-table-column
              prop="distribution"
              label="分销佣金"
              width="100">
            </el-table-column> 
            <el-table-column
              prop="arrears_amount"
              label="欠款金额"
              width="100">
            </el-table-column>                                                                           
      </el-table>
      <div class="block" style="text-align: right;margin-top: 30px;">
        <el-pagination
          @current-change="handleCurrentChange"
          :current-page="pageInfo.current"
          :page-size="pageInfo.page_size"
          layout="total, prev, pager, next, jumper"
          :total="pageInfo.total">
        </el-pagination>
        </div>
  </div>
</template>

<script>
  // import { getPublics, getHotels, getCapitalOverview, getCapitalList } from '@/service/distribution/http'
  import api from '@/service/distribution/http'
  const timeFormat = function (time) {
    let year = time.getFullYear()
    let month = time.getMonth() <= 8 ? '0' + (time.getMonth() + 1) : time.getMonth() + 1
    let date = time.getDate() <= 9 ? '0' + time.getDate() : time.getDate()
    return year + '-' + month + '-' + date
  }
  export default {
    data () {
      return {
        startTime: new Date(),
        endTime: new Date(),
        tableData: [],
        capitalOverview: {},
        pageInfo: {},
        getHotels: [],
        pulbic: [],
        selectedHotel: '',
        selectedPublic: '',
        formatStart: '',
        formatEnd: '',
        exportData: ''
      }
    },
    created () {
      let that = this
      api.getPublics().then((publics) => {
        this.pulbic = publics.data
      })
      that.filterBankAccount()
    },
    methods: {
      handleSelectPublic () {
        api.getHotels({
          'inter_id': this.selectedPublic
        }).then((hotels) => {
          this.getHotels = hotels.data
        })
      },
      handleSizeChange (val) {
        console.log(`每页 ${val} 条`)
      },
      handleCurrentChange (val) {
        console.log(`当前页: ${val}`)
        this.getCapitalListFunc(val)
      },
      getCapitalOverviewFunc () {
        let params = {
          inter_id: this.selectedPublic || '',
          hotel_id: this.selectedHotel || '',
          start_time: this.formatStart || '',
          end_time: this.formatEnd || ''
        }
        api.getCapitalOverview(params).then((res) => {
          this.capitalOverview = res.data
        })
      },
      getCapitalListFunc (offset) {
        let params = {
          inter_id: this.selectedPublic || '',
          hotel_id: this.selectedHotel || '',
          limit: '',
          offset: offset,
          start_time: this.formatStart || '',
          end_time: this.formatEnd || ''
        }
        api.getCapitalList(params).then((res) => {
          this.tableData = res.data.list
          this.pageInfo = res.data.page
          this.exportData = res.data.ext_data
        })
      },
      filterBankAccount () {
        this.formatStart = ''
        this.formatEnd = ''
        if (this.startTime) {
          this.formatStart = timeFormat(this.startTime)
        }
        if (this.endTime) {
          this.formatEnd = timeFormat(this.endTime)
        }
        if (this.startTime && this.endTime) {
          let days = Math.floor(Math.abs(this.endTime.getTime() - this.startTime.getTime()) / (24 * 60 * 60 * 1000))
          if (days > 31) {
            this.$confirm('时间跨度不可超过31天', '温馨提示', {})
            .then((res) => {
            }).catch(() => {
            })
            return
          }
        }
        this.getCapitalOverviewFunc()
        this.getCapitalListFunc()
      }
    }
  }
</script>
<style lang="postcss" scoped>
  .pricetag{
    text-align: center;
    margin-top: 20px;
  }
  .pricetag span{
    font-size: 15px;
    color: #AC9456;
    
  }
  .pricetag p{
    font-size: 15px;
    margin-top: 10px;
    color: #333;
  }
  .jfk-pages{
    padding-top: 2.7%;
  }
  .el-table{
    font-size: 12px;
  }


</style>
