<template>
  <div>
    <div class="jfk-pages jfk-pages__price">
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
                  <el-input v-model="salesId"  placeholder="请输入内容" style="width:250px;"></el-input>
              </div>  
              <div>
                <span class="">
                  <el-select v-model="timeType" placeholder="请选择"  style="width:110px;">
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
                <a><el-button type="" class="jfk-button--small establish-task-button" size="large">导出</el-button></a>
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
                  prop="record_title"
                  label="会员名称">
                </el-table-column>
                <el-table-column
                  prop="telephone"
                  label="手机号码">
                </el-table-column>
                <el-table-column
                  prop="type"
                  label="分销分类">
                </el-table-column>
                <el-table-column
                  prop="sales_id"
                  label="分销号">
                </el-table-column>
                <el-table-column
                  prop="sales_name"
                  label="分销员姓名">
                </el-table-column>
                <el-table-column
                  prop="reward"
                  label="绩效金额">
                </el-table-column>
                <el-table-column
                  prop="createtime"
                  label="核定时间">
                </el-table-column>
                <el-table-column
                  prop="last_update_time"
                  label="绩效发放时间">
                </el-table-column>
            </el-table>
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
        timeType: '',
        option: [{
          value: '',
          label: '所有时间'
        },
        {
          value: 'createtime',
          label: '发送时间'
        },
        {
          value: 'update_time',
          label: '核定时间'
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
      this.getData()
    },
    methods: {
      search () {
        let setData = {
          sales_id: this.salesId,
          hotel_id: this.hotelId,
          time_type: this.timeType,
          start_time: this.getTime[0],
          end_time: this.getTime[1]
        }
        this.getData(setData)
      },
      getData (data) {
        this.loading = true
        getRegStatements(data).then((res) => {
          this.loading = false
          if (res.web_data) {
            let json = res.web_data
            this.csrf_token = json.csrf_token
            this.csrf_value = json.csrf_value
            this.data = json.data
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
<style lang="postcss" scoped>
  .jfk-pages__price{
    margin-top: 0;
    padding-top: 25px
  }
</style>
<style  lang="postcss">
  .jfk-pages__price{
    .el-table{
      width: 100%;
      margin-top:40px;
      border: 0px;
      text-align: center;
    }
    .el-table::before , .el-table::after{
      display: none;
    }
    .el-table__header-wrapper thead div{
      background: transparent;
    }
    .el-table__row--striped{
      background-color: #F9FAFC;
    }
    .el-table th{
      text-align: center;
      background: transparent;
    }
    .el-table td{
      padding: 10px 0;
      border-bottom: 0px;
    }
    .el-pagination{
      text-align: center;
    }
    .gray-bg{
      background-color: #f6f6f6;
      padding: 10px 0;
    }
    .el-row{
      padding:10px 0;
    }
    .choice-rows{
      margin-left: 25px;
    }
    .choice-line{
      border-right: 1px solid #CCCCCC;
      width: 1px;
      height: 50px;
      display: inline-block;
    }
    .choice-step-title{
      font-size: 18px;
      margin-bottom: 10px;
    }
    .choice-step-word{
      font-size: 17px;
      color: #808080;
    }
    .choice-step-num{
      font-style: italic;
      font-size: 42px;
      color: rgb(151, 168, 190);
    }
    .choice-step-active{
      color: #AC9456;
    }
    .jfk-fieldset__hd{
      padding:10px 0;
    }
    .gray-bg{
      padding-left: 10px;
    }
    .gray-bg .el-form-item{
      margin-bottom: 0px;
    }
    .choice-tips {
      margin-top: 15px;
    }
    .choice-tips > div{
      float: left;
      color: #808080;
    }
    .choice-radio-right .el-radio{
      margin-right: 35px;
    }
    .choice-checkbox-right .el-checkbox{
      margin-right: 35px;
    }
    .coupon-list-header{
      margin: 0px!important;
    }
    .coupon-list-header > div{
      margin-right:15px;
      display: inline-block;
    }
    .coupon-search-button{
      width: 85px;
      padding: 8px 20px;
    }
    .establish-task-button{
      color: #AC9456;
      width: 85px;
      padding: 8px 20px;
    }
    .el-date-editor.el-input{
      width: 130px;
    }
    .coupon-list-detail{
      border: 1px solid #AC9456;
      color: #AC9456;
      border-radius: 2px;
    }
  }
</style>
