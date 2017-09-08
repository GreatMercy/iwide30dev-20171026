<template>
  <div class="jfk-pages">
      <el-row :gutter="20">
        <el-col :span="20">
          <el-form  ref="search" label-width="80px">
            <el-col :span="10">
              <el-form-item label="订单号">
                <el-input  placeholder="请输入订单号" v-model="orderId"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="2">
              <el-button type="primary" @click="searchRefundOrder()">查  询</el-button>
            </el-col>
          </el-form>
        </el-col>
      </el-row>
      <el-table
        :data="tableData"
        style="width: 100%" v-if="showRefundOrder">
        <el-table-column
          prop="add_time"
          label="交易时间"
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
          prop="order_no"
          label="订单号">
        </el-table-column>
        <el-table-column
          prop="module"
          label="退款模块">
        </el-table-column>
        <el-table-column
          prop="trans_amt"
          label="交易金额"
          width="100">
        </el-table-column> 
        <el-table-column
          prop="refund_amount"
          label="可退金额"
          width="100">
        </el-table-column> 
        <el-table-column
          label="操作"
          prop="btn_status"
          width="100">
          <template scope="scope">
            <el-button
              @click.native.prevent="applyRefund(scope.$index)"
              type="text"
              size="small"
              :disabled="tableData[scope.$index].btn_status =='0' || sendAjax">
              退款
            </el-button>
            </template>
        </el-table-column>                                   
      </el-table>   
      <div tabindex="-1" class="el-message-box__wrapper refundPopup" style="z-index: 2003;" v-if="showRefundPopup">
          <div class="el-message-box">
              <div class="el-message-box__header">
                  <div class="el-message-box__title">申请退款</div>
                  <button type="button" aria-label="Close" class="el-message-box__headerbtn" @click="handlePop()"><i class="el-message-box__close el-icon-close"></i></button>
              </div>
              <div class="el-message-box__content">
                  <div class="el-message-box__message" style="margin-left: 0px;">
                  <el-row>
                    <el-col :span="5">交易时间：</el-col>
                    <el-col :span="19">{{popItem.add_time}}</el-col>
                  </el-row>
                  <el-row>
                    <el-col :span="5">订单号：</el-col>
                    <el-col :span="19">{{popItem.order_no}}</el-col>
                  </el-row>
                  <el-row>
                    <el-col :span="5">交易金额：</el-col>
                    <el-col :span="19">{{popItem.trans_amt}}</el-col>
                  </el-row>
                  <el-row>
                    <el-col :span="5">可退金额：</el-col>
                    <el-col :span="19">{{popItem.refund_amount}}</el-col>
                  </el-row>    
                  <el-row class="refundMoney">
                    <el-col :span="5">退款金额：</el-col>
                    <el-col :span="19">
                      <el-input  placeholder="请输入退款金额" type="text" @change="handleRefundIpt(trimRefundVal, popItem.refund_amount)" v-model="refundVal"></el-input>
                    </el-col>
                  </el-row>  
                  <el-row class="tips" >
                    <el-col :span="24" >{{refundWarning}}</el-col>
                  </el-row>                       
                  </div>
              </div>
              <div class="el-message-box__btns">
                <el-button type="primary" size="large" :disabled="refundBtn" @click="refundReconfirmed(trimRefundVal)">立即退款</el-button>
              </div>
          </div>
      </div>    
  </div>
</template>

<script>
  import { postrefund, getRefundOrder } from '@/service/subAccount/http'
  import qs from 'qs'
  const reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/
  const refundTip = {
    canRefund: '退款金额提交后不能撤回，请仔细核对',
    overdrawn: '超过可退金额',
    inputWrong: '输入的格式不正确'
  }
  export default {
    data () {
      return {
        tableData: [],
        showRefundPopup: false,
        popItem: {},
        refundBtn: true,
        refundVal: '',
        refundWarning: '',
        showRefundOrder: false,
        orderId: '',
        csrf_token: '',
        sendAjax: false,
        listIndex: 0
      }
    },
    methods: {
      applyRefund (idx) {
        this.listIndex = idx
        this.popItem = this.tableData[idx]
        this.showRefundPopup = true
        this.sendAjax = true
      },
      handlePop () {
        this.showRefundPopup = false
        this.refundVal = ''
        this.refundWarning = ''
        this.sendAjax = false
      },
      handleRefundIpt (val, refundAmount) {
        if (!reg.test(val)) {
          this.refundWarning = refundTip.inputWrong
          this.refundBtn = true
        } else if (val - refundAmount > 0) {
          this.refundWarning = refundTip.overdrawn
          this.refundBtn = true
        } else if (val) {
          this.refundWarning = refundTip.canRefund
          this.refundBtn = false
        }
      },
      refundReconfirmed (trimRefundVal) {
        this.showRefundPopup = false
        this.refundVal = ''
        this.refundWarning = ''
        let param = {
          'order_no': this.popItem.order_no,
          'id': this.popItem.id,
          'amount': trimRefundVal,
          'csrf_token': this.csrf_token,
          'inter_id': null
        }
        this.$confirm('确认退款后，系统将自动完成退款且无法撤回', '温馨提示', {})
        .then((res) => {
          postrefund(qs.stringify(param), {headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).then((res) => {
            if (res.data.amount > 0) {
              this.tableData[this.listIndex].refund_amount = res.data.amount
              this.sendAjax = false
            } else {
              this.tableData[this.listIndex].refund_amount = 0
              this.sendAjax = true
            }
            this.$notify({
              title: '',
              message: '退款成功',
              type: 'success'
            })
          }).catch((err) => {
            if (err.status === 1012) {
              this.tableData[this.listIndex].refund_amount = err.data.amount
            }
            this.sendAjax = false
          })
        }).catch(() => {
          this.sendAjax = false
        })
      },
      searchRefundOrder () {
        this.showRefundOrder = true
        getRefundOrder({
          'order_no': this.orderId
        }).then((res) => {
          this.tableData = res.data.list
          this.csrf_token = res.data.csrf_token
        }).catch(() => {})
      }
    },
    computed: {
      trimRefundVal: function () {
        return this.refundVal.replace(/(^\s*)|(\s*$)/g, '')
      }
    }
  }
</script>
<style lang="postcss" scoped>
  .jfk-pages{
    padding-top: 2.7%;
  }
  .refundPopup{
    background-color: rgba(0,0,0,0.5);
  }
  .refundPopup .el-message-box__btns{
    text-align: center;
  }
  .refundPopup .el-row{
    line-height: 30px;
  }
  .refundPopup .refundMoney{
    margin-top: 10px;
  }
  .refundPopup .tips{
    color: #ff4949;
    font-size: 12px;
    padding-left: 21%;
  }
  .el-table{
    font-size: 12px;
  }
</style>
