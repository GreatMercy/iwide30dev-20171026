<template>
  <div class="jfk-pages">
    <el-form ref="form" :rules="rules" :model="storeState.data.bank" label-width="120px" v-loading.fullscreen="loading">
      <el-row type="flex" justify="space-between">
        <el-col :span="11">
          <el-form-item label="账户用途" prop="type">
            <el-select filterable v-model="storeState.data.bank.type" :disabled="id !== null">
              <el-option v-for="item in storeState.data.type" :key="item.value" :label="item.name" :value="item.value"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="11" v-if="storeState.data.bank.type != 'jfk'">
          <el-form-item label="账户别名" prop="account_aliases">
            <el-input v-model="storeState.data.bank.account_aliases" :disabled="id !== null"></el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row type="flex" justify="space-between">
        <el-col :span="11" v-if="storeState.data.bank.type != 'jfk'">
          <el-form-item label="所属公众号" prop="inter_id">
            <el-select filterable v-model="storeState.data.bank.inter_id" @change="selectInter" :disabled="id !== null" >
              <el-option v-for="item in storeState.data.publics" :key="item.inter_id" :label="item.name" :value="item.inter_id"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="11" v-if="storeState.data.bank.type === 'hotel'">
          <el-form-item label="所属门店" prop="hotel_id" >
            <el-select filterable v-model="storeState.data.bank.hotel_id" :disabled="id !== null">
              <el-option v-for="item in storeState.data.hotels" :key="item.hotel_id" :label="item.hotel_name" :value="item.hotel_id"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <el-col class="zhong">以下内容为银行账户相关信息，为避免出现转账失败等错误，请仔细填写及核对</el-col>
      </el-row>
      <el-row type="flex" justify="space-between">
        <el-col :span="11">
          <el-form-item label="基本开户银行" prop="branch_id">
            <el-select
              v-model="storeState.data.bank.branch_id"
              filterable
              remote
              :remote-method="searchBank"
              placeholder="可输入关键词搜索"
              :loading="bankloading">
              <el-option
                v-for="item in storeState.data.banks"
                :key="item.branch_id"
                :label="item.branch"
                :value="item.branch_id">
              </el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="11">
          <el-form-item label="银行所在市/县" prop="bank_city">
            <el-select filterable v-model="storeState.data.bank.bank_city">
              <el-option v-for="item in storeState.data.citys" :key="item.areaName" :label="item.areaName" :value="item.areaName"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row type="flex" justify="space-between">
        <el-col :span="11">
          <el-form-item label="基本账户名" prop="bank_user_name">
            <el-input v-model="storeState.data.bank.bank_user_name"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="11">
          <el-form-item label="基本银行账户" prop="bank_card_no">
            <el-input v-model="storeState.data.bank.bank_card_no"></el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row type="flex" justify="space-between">
        <el-col :span="11">
          <el-form-item label="基本账户类型" prop="is_company">
            <el-select filterable v-model="storeState.data.bank.is_company">
              <el-option v-for="item in storeState.data.bank_type" :key="item.value" :label="item.name" :value="item.value"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row type="flex" justify="center">
        <el-button @click="onSubmit()" type="primary">确  认</el-button>
      </el-row>
    </el-form>
  </div>
</template>

<script>
  import store from './store/main'
  import qs from 'qs'
  export default {
    data () {
      return {
        loading: false,
        bankloading: false,
        id: '',
        storeState: store.state,
        rules: {
          type: [
            {required: true, message: '请选择账户用途', trigger: 'change'}
          ],
          account_aliases: [
            {required: true, message: '请输入账户别名', trigger: 'change'}
          ],
          inter_id: [
            {required: true, message: '请选择所属公众号', trigger: 'change'}
          ],
          hotel_id: [
            {required: true, message: '请选择所属门店', trigger: 'change'}
          ],
          branch_id: [
            {required: true, message: '请选择开户银行', trigger: 'change'}
          ],
          bank_city: [
            {required: true, message: '请选择开户银行所在县市', trigger: 'change'}
          ],
          bank_user_name: [
            {required: true, message: '请输入银行账户名', trigger: 'change'}
          ],
          bank_card_no: [
            {required: true, message: '请输入银行账号', trigger: 'change'}
          ],
          is_company: [
            {required: true, message: '请选择账户类型', trigger: 'change'}
          ]
        }
      }
    },
    methods: {
      onSubmit () {
        this.$refs['form'].validate((valid) => {
          if (valid) {
            let par = this.storeState.data.bank
            let theqs = qs.stringify(par)
            if (this.id === '' || this.id === null) {
              store.addBankAccountInfo(theqs, function (e) {
                this.$notify({
                  title: '成功',
                  message: e.msg,
                  type: 'success',
                  onClose: function () {
                    window.location = document.referrer
                  }
                })
              }.bind(this))
            } else {
              store.editBankAccountInfo(par, function (e) {
                this.$notify({
                  title: '成功',
                  message: e.msg,
                  type: 'success',
                  onClose: function () {
                    window.location = document.referrer
                  }
                })
              }.bind(this))
            }
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      getQueryString (name) {
        let reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i')
        let r = window.location.search.substr(1).match(reg)
        if (r != null) {
          return unescape(r[2])
        }
        return null
      },
      selectInter () {
        this.loading = true
        let interid = this.storeState.data.bank.inter_id
        store.getHotels({inter_id: interid}, function () {
          this.loading = false
        }.bind(this), function () {
          this.loading = false
        }.bind(this))
      },
      searchBank (str) {
        if (str !== '' || this.storeState.data.banks.length === 0) {
          this.bankloading = true
          store.getBranch({keyword: str}, function () {
            this.bankloading = false
          }.bind(this), function () {
            this.bankloading = false
          }.bind(this))
        }
      }
    },
    mounted: function () {
      this.id = this.getQueryString('id')
      this.loading = true
      store.getBankAccountInfo({id: this.id}, function () {
        this.loading = false
      }.bind(this), function () {
        this.loading = false
      }.bind(this))
    }
  }
</script>
<style>
  .el-select{
    width: 100%;
  }
  .zhong{
    color: #c2cbd9;
    font-size: 14px;
    margin-bottom: 22px;
  }
  .jfk-pages{
  padding-top: 2.7%;
}
.el-table--border th, .el-table--border td {
    border-right: 0px !important;
}
</style>
