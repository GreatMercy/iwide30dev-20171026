<template>
  <div class="jfk-pages">
      <el-form ref="search"  label-width="120px">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-form-item label="验证时间">
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
            <el-form-item label="验证状态">
              <el-col :span="11">
                <el-select v-model="selectedState" placeholder="所有状态" >
                    <el-option
                      v-for="item in getStates"
                      :key="item.value"
                      :label="item.name"
                      :value="item.value">
                    </el-option>
                </el-select>
              </el-col>
            </el-form-item>
          </el-col>       
          <el-col :span="4">
              <el-button type="primary" @click="filterList()">查询</el-button>
          </el-col>
        </el-row>
         <el-row :gutter="20" style="text-align: right;">
           <a :href="exportData"> 
            <el-button >导出数据</el-button>
           </a>
           
         </el-row>
      </el-form>

      <el-table
        :data="tableData"
        stripe
        style="width: 100%;margin-top: 40px" >
            <el-table-column
              prop="add_time"
              label="生成账单时间"
              width="180">
            </el-table-column>        
            <el-table-column
              prop="bank_user_name"
              label="账户名">
            </el-table-column>
            <el-table-column
              prop="bank_card_no"
              label="账号">
            </el-table-column>
            <el-table-column
              prop="amount"
              label="待转账金额"
              width="100">
            </el-table-column>
            <el-table-column
              prop="update_time"
              label="返回状态时间">
            </el-table-column>  
            <el-table-column
              prop="status_name"
              label="转账状态">
            </el-table-column> 
            <el-table-column
              prop="remark"
              label="备注">
            </el-table-column>
            <el-table-column
              label="操作" >
              <template scope="scope">
                <el-row >
                  <el-button
                    type="text"
                    size="small" v-if="tableData[scope.$index].status == '0'" 
                    @click="getSingleSendFunc('send', scope.$index)" :disabled="sendAjax">
                    发起转账
                  </el-button>
                  <el-button
                    type="text"
                    size="small"
                    class="jfk-color--danger" v-if="tableData[scope.$index].status == '2'" 
                    @click="getSingleSendFunc('re_send ', scope.$index)" :disabled="sendAjax">
                    重新转账
                  </el-button>
                  <a :href="tableData[scope.$index].ext_url" >
                    <el-button
                      type="text"
                      size="small" class="duizhang">
                      对账单
                    </el-button>                     
                  </a>
                </el-row>
              </template>              
            </el-table-column>  
      </el-table>
      <div class="block" style="text-align: right;margin-top: 30px;">
        <el-pagination
          @current-change="handleCurrentChange"
          :current-page="currentPage"
          :page-size="pageInfo.page_size"
          layout="total, prev, pager, next, jumper"
          :total="pageInfo.total">
        </el-pagination>
        </div>
  </div>
</template>

<script>
  import { getTransferAccounts, getSingleSend } from '@/service/subAccount/http'
  const timeFormat = function (time) {
    let year = time.getFullYear()
    let month = time.getMonth() <= 8 ? '0' + (time.getMonth() + 1) : time.getMonth() + 1
    let date = time.getDate() <= 9 ? '0' + time.getDate() : time.getDate()
    return year + '-' + month + '-' + date
  }
  export default {
    data () {
      return {
        value: '',
        startTime: '',
        endTime: '',
        tableData: [],
        currentPage: 1,
        pageInfo: {},
        formatStart: '',
        formatEnd: '',
        getStates: [],
        selectedState: '',
        exportData: '',
        sendAjax: false
      }
    },
    created () {
      let that = this
      that.getTransferAccountsFunc()
    },
    methods: {
      handleSizeChange (val) {
        console.log(`每页 ${val} 条`)
      },
      handleCurrentChange (val) {
        console.log(`当前页: ${val}`)
        this.getTransferAccountsFunc(val)
      },
      filterList () {
        this.formatStart = ''
        this.formatEnd = ''
        if (this.startTime) {
          this.formatStart = timeFormat(this.startTime)
        }
        if (this.endTime) {
          this.formatEnd = timeFormat(this.endTime)
        }
        this.getTransferAccountsFunc()
      },
      getTransferAccountsFunc (offset) {
        let params = {
          status: this.selectedState,
          start_time: this.formatStart || '',
          end_time: this.formatEnd || '',
          offset: offset,
          limit: ''
        }
        if (process.env.NODE_ENV === 'development') {
          params.inter_id = ''
          params.status = '-1'
        }
        getTransferAccounts(params).then((res) => {
          this.tableData = res.data.list
          this.pageInfo = res.data.page
          this.getStates = res.data.status
          this.exportData = res.data.url.ext_data
        })
      },
      getSingleSendFunc (type, idx) {
        this.sendAjax = true
        this.$confirm('确定发起转账吗？', '温馨提示', {})
        .then((res) => {
          let param = {
            'status': type,
            'id': this.tableData[idx].id
          }
          if (process.env.NODE_ENV === 'development') {
            param.inter_id = null
          }
          getSingleSend(param).then((res) => {
            this.tableData[idx].status_name = res.data.status_name
            this.tableData[idx].status = res.data.status
            this.tableData[idx].update_time = res.data.update_time
            this.tableData[idx].remark = res.data.remark
            this.sendAjax = false
            this.$notify({
              title: '',
              message: '转账成功',
              type: 'success'
            })
          }).catch((err) => {
            if (err.status === '1012') {
              this.tableData[idx].remark = err.data.remark
              this.tableData[idx].status_name = err.data.status_name
              this.tableData[idx].update_time = err.data.update_time
              this.tableData[idx].status = err.data.status
            }
            this.sendAjax = false
          })
        }).catch(() => {
          this.sendAjax = false
        })
      }
    }
  }
</script>
<style lang="postcss" scoped>

.duizhang{
    float: right;
}
.el-table{
  font-size: 12px;
}
  .jfk-pages{
    padding-top: 2.7%;
  }
</style>
