<template>
  <div class="jfk-pages">
      <el-form ref="search"  label-width="120px">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-form-item label="验证时间">
              <el-col :span="11">
                <el-form-item>
                  <el-date-picker type="date" format="yyyy-MM-dd" placeholder="选择日期"  style="width: 100%;" v-model="startTime" ></el-date-picker>
                </el-form-item>
              </el-col>
              <el-col class="line" :span="2">至</el-col>
              <el-col :span="11">
                <el-form-item prop="date2">
                  <el-date-picker type="date" placeholder="选择日期"  style="width: 100%;" v-model="endTime" format="yyyy-MM-dd"></el-date-picker>
                </el-form-item>
              </el-col>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label="酒店筛选">
              <el-col :span="11">
                <el-select v-model="selectedPublic" placeholder="所有公众号" filterable @change="handleSelectPublic" >
                    <el-option
                      v-for="item in pulbic"
                      :key="item.inter_id"
                      :label="item.name"
                      :value="item.inter_id">
                    </el-option>
                </el-select>
              </el-col>
              <el-col :span="2"></el-col>
              <el-col :span="11">
                <el-select v-model="selectedHotel" placeholder="所有门店" filterable>
                    <el-option
                      v-for="item in getHotels"
                      :key="item.status"
                      :label="item.hotel_name"
                      :value="item.hotel_id">
                    </el-option>
                </el-select>
              </el-col>              

            </el-form-item>
          </el-col>       
          <el-col :span="4">
              <el-button type="primary"  @click="filterBankAccount()">查询</el-button>
          </el-col>
        </el-row>
         <el-row :gutter="20">
          <el-col :span="10">
            <el-form-item label="验证状态">
              <el-col :span="11">
                <el-select v-model="selectedState" placeholder="所有" >
                    <el-option
                      v-for="item in getStates"
                      :label="item.name"
                      :value="item.value">
                    </el-option>
                </el-select>
              </el-col>
            </el-form-item>
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
              prop="created_at"
              label="新增时间"
              width="180">
            </el-table-column>        
            <el-table-column
              prop="name"
              label="所属公众号">
            </el-table-column>
            <el-table-column
              prop="hotel_name"
              label="所属门店">
            </el-table-column>
            <el-table-column
              prop="amount"
              label="验证金额">
            </el-table-column>
            <el-table-column
              prop="add_time"
              label="验证时间">
            </el-table-column>  
            <el-table-column
              prop="status_name"
              label="验证状态">
            </el-table-column> 
            <el-table-column
              prop="remark"
              label="备注">
            </el-table-column>
            <el-table-column
              label="操作">
              <template scope="scope">
                <el-button
                  type="text"
                  size="small" v-if="tableData[scope.$index].status == 0"
                  @click="checkAccount('send', scope.$index)" :disabled="sendAjax" >
                  发起验证
                </el-button>
                <el-button
                  type="text"
                  size="small"
                  class="jfk-color--danger" v-else-if="tableData[scope.$index].status == 2" @click="checkAccount('re_send', scope.$index)" :disabled="sendAjax">
                  重新验证
                </el-button> 
                <div v-else>--</div>
                                
              </template>              
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
  // import { getPublics, getHotels, getBankCheckAccount, postCheckAccount } from '@/service/distribution/http'
  import api from '@/service/distribution/http'
  import qs from 'qs'
  const timeFormat = function (time) {
    let year = time.getFullYear()
    let month = time.getMonth() <= 8 ? '0' + (time.getMonth() + 1) : time.getMonth() + 1
    let date = time.getDate() <= 9 ? '0' + time.getDate() : time.getDate()
    return year + '-' + month + '-' + date
  }
  export default {
    data () {
      return {
        selectedHotel: '',
        selectedPublic: '',
        selectedState: '',
        startTime: '',
        endTime: '',
        tableData: [],
        pulbic: [],
        getHotels: [],
        getStates: [],
        pageInfo: {},
        formatStart: '',
        formatEnd: '',
        csrf_token: '',
        exportData: '',
        sendAjax: false
      }
    },
    created () {
      let that = this
      api.getPublics().then((publics) => {
        this.pulbic = publics.data
      })
      that.getBankCheckAccountFunc()
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
        this.getBankCheckAccountFunc(val)
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
        this.getBankCheckAccountFunc()
      },
      getBankCheckAccountFunc (offset) {
        let params = {
          inter_id: this.selectedPublic || '',
          hotel_id: this.selectedHotel || '',
          status: this.selectedState,
          start_time: this.formatStart || '',
          end_time: this.formatEnd || '',
          offset: offset,
          limit: ''
        }
        // if (process.env.NODE_ENV === 'development') {
        //   params.inter_id = ''
        // }
        api.getBankCheckAccount(params).then((res) => {
          this.getStates = res.data.account_type
          this.tableData = res.data.list
          this.pageInfo = res.data.page
          this.csrf_token = res.data.csrf_token
          this.exportData = res.data.url.ext_data
        })
      },
      checkAccount (type, idx) {
        this.sendAjax = true
        this.$confirm('确定发起验证吗？', '温馨提示', {})
        .then((res) => {
          let param = {
            'id': this.tableData[idx].id,
            'status': type,
            'csrf_token': this.csrf_token
          }
          api.postCheckAccount(qs.stringify(param), {headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).then((res) => {
            this.tableData[idx].status_name = res.data.status_name
            this.tableData[idx].status = res.data.status
            this.tableData[idx].remark = res.data.remark
            this.tableData[idx].amount = res.data.amount
            this.tableData[idx].add_time = res.data.add_time
            this.sendAjax = false
            this.$notify({
              title: '',
              message: '验证成功',
              type: 'success'
            })
          }).catch((err) => {
            if (err.status === 1012) {
              this.tableData[idx].status_name = err.data.status_name
              this.tableData[idx].status = err.data.status
              this.tableData[idx].remark = err.data.remark
              this.tableData[idx].amount = err.data.amount
              this.tableData[idx].add_time = err.data.add_time
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
  .jfk-pages{
    padding-top: 2.7%;
  }
  .el-table{
    font-size: 12px;
  } 
</style>
