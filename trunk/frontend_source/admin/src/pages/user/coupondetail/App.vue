<template>
  <div v-loading="couponItems.loading">
    <div class="jfk-pages jfk-pages__price">
      <template>
        <div id="content-list-wrapper">
          <el-row>
              <p class="content-header" style="display:block;">{{couponItems.content.send_value}}</p>
              <el-col :span="10">
                <p><span class="content-title">发送时间 :</span><span class="content-word">{{couponItems.content.send_time}}</span></p>
                <p><span class="content-title">优惠券/礼包ID :</span><span class="content-word">{{couponItems.content.send_type_id}}</span></p>
                <p><span class="content-title">发送人数 :</span><span class="content-word">{{couponItems.content.send_num}}</span></p>
              </el-col>
              <el-col :span="7">
                <p><span class="content-title">发送内容 :</span><span class="content-word">{{couponItems.content.send_type}}</span></p>
                <p><span class="content-title">优惠券/礼包名称 :</span><span class="content-word">{{couponItems.content.send_value}}</span></p>
                <p><span class="content-title">成功发送人数 :</span><span class="content-word">{{couponItems.content.send_success_num}}</span></p>
              </el-col> 
              <el-col :span="7">
                <p><span class="content-title">是否可重复领取 :</span>
                  <span v-if="couponItems.content.receive_repeat === '1'" class="content-word">是</span>
                  <span v-if="couponItems.content.receive_repeat === '2'" class="content-word">否</span>
                </p>
                <p><span class="content-title">发送数量 :</span><span class="content-word">{{couponItems.content.send_count}}</span></p>
                <p><span class="content-title">失败发送人数 :</span><span class="content-word">{{couponItems.content.send_fail_num}}</span></p>
              </el-col>
              <p><span class="content-title">发送目标用户 :</span><span class="content-word">{{couponItems.content.send_target}}</span></p>
            </el-row>
          <el-row :gutter="24" class="coupon-list-header gray-bg"> 
              <el-col :span="7">
                      <el-input icon="search" v-model="keyword" placeholder="输入会员卡号或手机号查询"></el-input>
                </el-col>
            <el-col :span="7" style="text-align: left;">
              <el-button type="primary" @click="search"  class="jfk-button--small coupon-search-button" size="large">查询</el-button>
              <a :href="couponItems.page_resource.links.export"><el-button type=""  class="jfk-button--small establish-task-button" size="large">导出</el-button></a>
            </el-col>
          </el-row>
          <el-table
            v-loading="couponItems.tableloading"
            widte="100%"
            :data="couponItems.data"
            stripe>
              <el-table-column
                prop="0"
                label="会员ID">
              </el-table-column>
              <el-table-column
                prop="1"
                label="会员卡号">
              </el-table-column>
              <el-table-column
                prop="2"
                label="会员名称">
              </el-table-column>
              <el-table-column
                prop="3"
                label="手机号码">
              </el-table-column>
              <el-table-column
                v-if="couponItems.openbol"
                prop ="4"
                label="OPEN ID">
              </el-table-column>
              <el-table-column
                prop="5"
                label="发送结果">
              </el-table-column>
              <el-table-column
                prop="6"
                label="失败原因">
              </el-table-column>
              <el-table-column
                prop="7"
                label="发送时间">
              </el-table-column>
          </el-table>
          <div class="block" style="margin-top:50px;">
             <el-pagination
                @current-change="current"
                :page-size="couponItems.page_resource.size"
                layout="total, prev, pager, next, jumper"
                :total="couponItems.page_resource.count">
              </el-pagination> 
          </div>
          <el-row type="flex" justify="center" style="margin-top:25px;">
            <a :href="couponItems.page_resource.links.list"><el-button type="primary" size="large" class="jfk-button--middle" style="width:200px;">返回</el-button></a>
          </el-row>
        </div>
      </template>
    </div>
  </div>
</template>
<script>
  import store from './store/main'
  import { formatUrlParams } from '@/utils/utils'
  let Id = ''
  export default {
    data () {
      return {
        Id: Id,
        couponItems: store.state,
        keyword: ''
      }
    },
    beforeCreate () {
      let params = formatUrlParams(location.search)
      Id = params.Id
    },
    methods: {
      search () {
        let getData = {
          id: Id,
          keywords: this.keyword,
          p: this.couponItems.page_resource.page
        }
        store.getDetail(getData)
      },
      current (e) {
        this.couponItems.page_resource.page = e
        this.search()
      }
    },
    mounted () {
      let getData = {
        id: Id
      }
      store.getDetail(getData)
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
    .coupon-search-button{
      width: 85px;
      padding: 8px 20px;
    }
    .establish-task-button{
      color: #AC9456;
      width: 135px;
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
#content-list-wrapper{
  .content-header{
    margin-bottom: 20px;
  }
  .content-title{
    width: 120px;
    display: inline-block;
    text-align: right;
    color: #808080;
    font-size: 15px;
    margin-bottom: 10px;
  }
  .content-word{
    margin-left: 10px;
  }
  .coupon-list-header{
    margin: 0px!important;
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
