<template>
  <div>
    <div class="jfk-pages jfk-pages__price">
      <div class="jfk-fieldset__hd">
        <div class="jfk-fieldset__title">储值数据分析报表</div>
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
                      :label="item.hotel_name"
                      :value="item.hotel_id">
                    </el-option>
                  </el-select>
              </div>
              <div>
                <el-date-picker
                  type="daterange"
                  v-model="time"
                  style="width:250px;"
                  @change="setTime"
                  range-separator=" 至 "
                  placeholder="选择日期范围">
                </el-date-picker>
              </div>
              <el-radio-group v-model="chooseDate">
                <el-radio-button label="过去7天" @click.native.prevent="handleDate(7)">过去7天</el-radio-button>
                <el-radio-button label="过去30天" @click.native.prevent="handleDate(30)">过去30天</el-radio-button>
              </el-radio-group>
              <div style="float: right;">
                <a><el-button type="" @click="search" class="jfk-button--small establish-task-button" size="large">查询</el-button></a>
              </div>
            </el-row>
            <el-row :gutter="10" class="fansreport-wrap">
              <el-col :span="8" class="center">
                <el-col :span="24">
                  <p>{{data.total.total}}</p>
                  <p>累计粉丝</p>
                </el-col>
              </el-col>
              <div class="jfk-ta-c el-col el-col-1"><div class="choice-line"></div></div>
              <el-col :span="14" class="center">
                <el-col :span="6">
                  <p>{{data.self_total}}</p>
                  <p>自主关注</p>
                </el-col>
                <el-col :span="6">
                  <p>{{data.scan_total}}</p>
                  <p>扫码关注</p>
                </el-col>
                <el-col :span="6">
                  <p>{{data.dis_total}}</p>
                  <p>分销关注</p>
                </el-col>
              </el-col>
            </el-row>
            <el-row :gutter="10" class="fansreport-wrap">
              <el-col :span="8" class="center">
                <el-col :span="24">
                  <p>{{data.total.total}}</p>
                  <p>累计粉丝</p>
                </el-col>
              </el-col>
              <div class="jfk-ta-c el-col el-col-1"><div class="choice-line"></div></div>
              <el-col :span="14" class="center">
                <el-col :span="6">
                  <p>{{data.self_total}}</p>
                  <p>自主关注</p>
                </el-col>
                <el-col :span="6">
                  <p>{{data.scan_total}}</p>
                  <p>扫码关注</p>
                </el-col>
                <el-col :span="6">
                  <p>{{data.dis_total}}</p>
                  <p>分销关注</p>
                </el-col>
              </el-col>
            </el-row>
            <el-row class="center">
              <el-radio-group v-model="chartType" class="jfk-mb-20">
                <el-radio-button name="new" label="new">储值增加</el-radio-button>
                <el-radio-button name="self" label="self">储值使用</el-radio-button>
              </el-radio-group>
            </el-row>
            <div class="charts">
              <IEcharts :option="chartOption" :loading="loading" @ready="chartReady"></IEcharts>
            </div>
            <div class="jfk-fieldset__hd">
              <div class="jfk-fieldset__title">每日粉丝明细</div>
            </div>
            <el-row class="coupon-list-header">
              <div style="float: right;">
                <a :href="dataLink"><el-button type="" class="jfk-button--small establish-task-button" size="large">导出</el-button></a>
              </div>
            </el-row>
            <el-table
              v-loading="loading"
              style="width: 100%;margin-top:0px;"
              :data="dayList"
              stripe>
                <el-table-column
                  prop="date"
                  label="时间">
                </el-table-column>
                <el-table-column
                  prop="new"
                  label="新增粉丝">
                </el-table-column>
                <el-table-column
                  prop="self"
                  label="自主关注">
                </el-table-column>
                <el-table-column
                  prop="scan"
                  label="扫码关注">
                </el-table-column>
                <el-table-column
                  prop="dis"
                  label="分销关注">
                </el-table-column>
                <el-table-column
                  prop="cancel"
                  label="取消关注">
                </el-table-column>
            </el-table>
            <div class="jfk-fieldset__hd">
              <div class="jfk-fieldset__title">酒店发展粉丝统计</div>
            </div>
            <el-row class="coupon-list-header">
              <div style="float: right;">
                <a :href="hotelLink"><el-button type="" class="jfk-button--small establish-task-button" size="large">导出</el-button></a>
              </div>
            </el-row>
            <el-table
              v-loading="loading"
              style="width: 100%;margin-top:0px;"
              :data="hotelData"
              stripe>
                <el-table-column
                  prop="hotel_name"
                  label="所属酒店">
                </el-table-column>
                <el-table-column
                  prop="new"
                  label="新增粉丝">
                </el-table-column>
                <el-table-column
                  prop="self"
                  label="自主关注">
                </el-table-column>
                <el-table-column
                  prop="scan"
                  label="扫码关注">
                </el-table-column>
                <el-table-column
                  prop="dis"
                  label="分销关注">
                </el-table-column>
                <el-table-column
                  prop="cancel"
                  label="取消关注">
                </el-table-column>
            </el-table>
        </div>
      </template>
    </div>
  </div>
</template>
<script>
  import { getBalanceAnalysis } from '@/service/user/http'
  import IEcharts from 'vue-echarts-v3/src/lite'
  import 'echarts/lib/chart/line'
  import 'echarts/lib/component/tooltip'
  import 'echarts/lib/component/legend'
  import 'echarts/lib/component/title'
  export default {
    name: 'fansreport',
    components: {
      IEcharts
    },
    data () {
      return {
        data: [],
        dayList: [],
        csrf_token: '',
        csrf_value: '',
        chooseDate: '',
        getTime: ['', ''],
        time: '',
        dialog: false,
        loading: true,
        hotelList: [],
        hotelData: [],
        hotelId: '',
        chartsData: [],
        chartsTime: [],
        chartType: 'new',
        chartInst: null
      }
    },
    created () {
      this.handleDate(15)
    },
    methods: {
      search () {
        let setData = {
          hotel_id: this.hotelId,
          start_date: this.getTime[0],
          end_date: this.getTime[1]
        }
        this.getData(setData)
      },
      getData (data) {
        this.loading = true
        getBalanceAnalysis(data).then((res) => {
          this.loading = false
          this.clearData()
          if (res.web_data) {
            this.loading = false
            this.csrf_token = this.data.csrf_token
            this.csrf_value = this.data.csrf_value
            for (let item in this.data.hotel_data) {
              if (item !== '-1') {
                this.hotelList.push(this.data.hotel_data[item])
              }
              this.hotelData.push(this.data.hotel_data[item])
            }
            this.hotelList.unshift({
              hotel_id: '',
              hotel_name: '全部酒店'
            })
          } else {
            this.data = {}
          }
        })
      },
      setTime (value) {
        this.getTime = value.split(' 至 ')
      },
      handleDate (num) {
        let today = new Date()
        let oldday = new Date()
        oldday.setDate(today.getDate() - num + 1)
        this.time = [oldday, today]
        this.getTime[0] = this.changeDate(oldday)
        this.getTime[1] = this.changeDate(today)
        this.search()
      },
      changeDate (date) {
        let time = date
        let seperator = '-'
        let month = time.getMonth() + 1
        let strDate = time.getDate()
        if (month >= 1 && month <= 9) {
          month = '0' + month
        }
        if (strDate >= 0 && strDate <= 9) {
          strDate = '0' + strDate
        }
        let currentdate = time.getFullYear() + seperator + month + seperator + strDate
        return currentdate
      },
      chartReady (inst) {
        this.chartInst = inst
      }
    },
    computed: {
      chartOption () {
        if (this.chartType === 'new') {
          this.chartsData = this.newData
        } else if (this.chartType === 'self') {
          this.chartsData = this.selfData
        } else if (this.chartType === 'dis') {
          this.chartsData = this.disData
        } else if (this.chartType === 'scan') {
          this.chartsData = this.scanData
        } else if (this.chartType === 'cancel') {
          this.chartsData = this.cancelData
        }
        let result = {
          title: {
            text: '趋势图'
          },
          tooltip: {
            trigger: 'axis'
          },
          xAxis: {
            type: 'category',
            data: this.chartsTime
          },
          yAxis: {
            type: 'value'
          },
          series: [{
            name: '新增粉丝',
            type: 'line',
            data: this.chartsData
          }]
        }
        return result
      }
    }
  }
</script>
<style lang="postcss">
  @import '../../../styles/postcss/user.postcss';
  .charts {
    width: 100%;
    height: 500px;
  }
  .fansreport-wrap{
    margin-left: 0px!important;
    margin-right: 0px!important;
    border: 1px solid #f6f6f6;
    line-height: 25px;
    margin-top: 15px;
    margin-bottom: 20px;
  }
  .choice-line{
    margin-top: 6px;
  }
</style>
