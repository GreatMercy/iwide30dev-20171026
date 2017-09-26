<template>
  <div>
    <div class="jfk-pages jfk-pages__price">
      <div class="jfk-fieldset__hd">
        <div class="jfk-fieldset__title">注册分销报表</div>
      </div>
      <template>
        <div id="conpon-wrapper">
            <el-row class="coupon-list-header gray-bg">
              <div>
                  <span>所属酒店 : </span>
                  <el-select v-model="hotelId" placeholder="请选择">
                    <el-option
                      v-for="item in hotelList"
                      :key="item.hotel_id"
                      :label="item.name"
                      :value="item.hotel_id">
                    </el-option>
                  </el-select>
              </div>
              <div>
                  <span>分销员号 : </span>
                  <el-input v-model="salesId"  placeholder="请输入分销员号" style="width:150px;"></el-input>
              </div>  
              <div>
                <span class="">
                  <el-select v-model="timeType" placeholder="请选择"  style="width:140px;">
                  <el-option
                    v-for="item in option"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                  </el-option>
                  </el-select> : 
                </span>
                <el-date-picker
                  type="daterange"
                  v-model="time"
                  style="width:250px;"
                  @change="setTime"
                  range-separator=" 至 "
                  placeholder="选择日期范围">
                </el-date-picker>
              </div>
              <div style="float: right;">
                <el-button type="primary" @click="search" class="jfk-button--small coupon-search-button" size="large">查询</el-button>
                <a :href="exportLink"><el-button type="" class="jfk-button--small establish-task-button" size="large">导出</el-button></a>
              </div>
            </el-row>
            <el-table
              v-loading="loading"
              style="width: 100%;"
              :data="data"
              stripe>
                <el-table-column
                  prop="member_info_id"
                  label="会员ID">
                </el-table-column>
                <el-table-column
                  prop="membership_number"
                  label="会员号">
                </el-table-column>
                <el-table-column
                  prop="name"
                  label="会员名称">
                </el-table-column>
                <el-table-column
                  prop="telephone"
                  label="手机号码">
                </el-table-column>
                <el-table-column
                  prop="sales_id"
                  label="分销号">
                </el-table-column>
                <el-table-column
                  prop="sales_name"
                  label="分销员">
                </el-table-column>
                <el-table-column
                  prop="reward"
                  label="绩效金额">
                </el-table-column>
                <el-table-column
                  width="116"
                  prop="last_update_time"
                  label="核定时间">
                </el-table-column>
                <el-table-column
                  width="121"
                  prop="send_time"
                  label="绩效发放时间">
                </el-table-column>
            </el-table>
            <div class="block" style="margin-top:30px;">
             <el-pagination
                @current-change="current"
                :page-size="perPage"
                layout="total, prev, pager, next, jumper"
                :total="total">
              </el-pagination> 
            </div>
        </div>
    </template>
    </div>
  </div>
</template>
<script>
  import { getRegStatements, getHotelList } from '@/service/user/http'
  export default {
    data () {
      return {
        data: [],
        csrf_token: '',
        csrf_value: '',
        value: '',
        time: '',
        getTime: ['', ''],
        keyword: '',
        loading: true,
        hotelList: [],
        hotelId: '',
        salesId: '',
        timeType: 'update_time',
        exportLink: '',
        perPage: 0,
        total: 0,
        page: 1,
        option: [{
          value: 'update_time',
          label: '核定时间'
        },
        {
          value: 'send_time',
          label: '绩效发放时间'
        }]
      }
    },
    created () {
      getHotelList().then((res) => {
        this.hotelList = res.web_data.data
        this.hotelList.unshift({
          hotel_id: '',
          name: '全部酒店'
        })
      })
      this.search()
    },
    methods: {
      search () {
        let setData = {
          sales_id: this.salesId,
          hotel_id: this.hotelId,
          time_type: this.timeType,
          start_time: this.getTime[0],
          end_time: this.getTime[1],
          page: this.page
        }
        this.getData(setData)
      },
      current (e) {
        this.page = e
        this.search()
      },
      getData (data) {
        this.loading = true
        getRegStatements(data).then((res) => {
          this.loading = false
          if (res.web_data) {
            let json = res.web_data
            this.csrf_token = json.csrf_token
            this.csrf_value = json.csrf_value
            this.data = json.data.data
            this.total = json.data.total
            this.perPage = json.data.per_page
            this.exportLink = json.data.export_link + '?sales_id=' + this.salesId + '&hotel_id=' + this.hotelId + '&time_type=' + this.timeType + '&start_time=' + this.getTime[0] + '&end_time' + this.getTime[1]
          } else {
            this.data = []
          }
        })
      },
      setTime (value) {
        this.getTime = value.split(' 至 ')
      }
    }
  }
</script>
<style lang="postcss">
  @import '../../../styles/postcss/user.postcss';
</style>
