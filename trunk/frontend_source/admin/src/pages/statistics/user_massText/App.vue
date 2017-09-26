<template>
  <div>
    <div class="jfk-pages jfk-pages__price">
      <div class="jfk-fieldset__hd">
        <div class="jfk-fieldset__title">群发图文统计</div>
      </div>
      <template>
        <div id="conpon-wrapper">
            <el-row class="coupon-list-header gray-bg">
              <div>
                <span>图文发放时间 : </span>
                <el-date-picker
                  type="daterange"
                  v-model="time"
                  style="width:250px;"
                  @change="setTime"
                  range-separator=" 至 "
                  :picker-options="pickerOptions"
                  placeholder="选择日期范围">
                </el-date-picker>
              </div>
              <el-radio-group>
                <el-radio-button label="过去7天" @click.native.prevent="handleDate(7)">过去7天</el-radio-button>
              </el-radio-group>
              <div style="float: right;">
                <el-button type="primary" @click="search" class="jfk-button--small coupon-search-button" size="large">查询</el-button>
              </div>
            </el-row>
            <el-col :span="20">
              <i class="el-icon-message"></i>
              <div class="mass-wrapper">
                <p class="mass-title">按照图文发放时间查询该时间段内所有发送的图文数据，最多可查询七天的数据。</p>
                <p class="mass-word">图文统计数据为从发送日开始至查询结束时间的累计数据</p>
              </div>
            </el-col>
            <el-table
              v-loading="loading"
              style="width: 100%;"
              :data="data"
              stripe>
                <el-table-column
                  prop="title"
                  label="文章标题">
                </el-table-column>
                <el-table-column
                  prop="send_date"
                  label="发送时间">
                </el-table-column>
                <el-table-column
                  prop="target_user"
                  label="送达人数">
                </el-table-column>
                <el-table-column
                  prop="int_page_read_user"
                  label="图文页的阅读人数">
                </el-table-column>
                <el-table-column
                  prop="ori_page_read_user"
                  label="原文页的阅读人数">
                </el-table-column>
                <el-table-column
                  prop="share_user"
                  label="分享的人数">
                </el-table-column>
                <el-table-column
                  prop="int_page_from_feed_read_user"
                  label="朋友圈阅读人数">
                </el-table-column>
                <el-table-column
                  prop="int_page_from_friends_read_user"
                  label="好友转发阅读人数">
                </el-table-column>
            </el-table>
        </div>
    </template>
    </div>
  </div>
</template>
<script>
  import { getArticleTotal } from '@/service/user/http'
  export default {
    data () {
      return {
        data: [],
        csrf_token: '',
        csrf_value: '',
        value: '',
        time: '',
        getTime: ['', ''],
        loading: true,
        pickerOptions: {
          disabledDate (time) {
            return time.getTime() > Date.now() - 8.64e7
          }
        }
      }
    },
    created () {
      this.handleDate(7)
    },
    methods: {
      search () {
        let setData = {
          startdate: this.getTime[0],
          enddate: this.getTime[1]
        }
        this.getData(setData)
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
      handleDate (num) {
        let today = new Date()
        today.setDate(today.getDate() - 1)
        let oldday = new Date()
        oldday.setDate(today.getDate() - num + 1)
        this.time = [oldday, today]
        this.getTime[0] = this.changeDate(oldday)
        this.getTime[1] = this.changeDate(today)
        this.search()
      },
      getData (data) {
        this.loading = true
        getArticleTotal(data).then((res) => {
          this.loading = false
          if (res.web_data) {
            let json = res.web_data
            this.csrf_token = json.csrf_token
            this.csrf_value = json.csrf_value
            this.data = json.return_info
          } else {
            this.data = []
          }
        })
      },
      setTime (value) {
        if (value !== '') {
          let timeOne = this.time[0].getTime()
          let timeTwo = this.time[1].getTime()
          let day = (timeTwo - timeOne) / 1000
          day = parseInt(day / (24 * 60 * 60)) + 1
          if (day > 7) {
            this.time = ''
            this.$alert('所选日期跨度最大不能超过7天', '提示', {
              confirmButtonText: '确定'
            })
          } else {
            this.getTime = value.split(' 至 ')
          }
        }
      }
    }
  }
</script>
<style  lang="postcss">
  @import '../../../styles/postcss/user.postcss';
  .el-icon-message{
    float: left;
    font-size: 20px;
    color: #AC9456;
    padding: 4px 0;
    margin:15px 0
  }
  .mass-wrapper{
    float:left;
    margin-left:15px;
    margin-top:15px;
  }
  .mass-title{
    font-size: 16px;
    margin-bottom: 10px;
  }
  .mass-word{
        font-size: 14px;
    color: #808080;
  }
</style>
