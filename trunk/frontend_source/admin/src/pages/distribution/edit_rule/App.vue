<template>
  <div class="jfk-pages">
    <el-form :rules="rules" ref="form" :model="storeState.form" label-width="120px">
      <el-row>
        <el-col :span="12">
          <el-form-item label="所属公众号">
            <el-input v-model="storeState.inter_name" :disabled="true"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="酒店名称">
            <el-select v-model="storeState.hotel_id" :disabled="true" filterable placeholder="请选择酒店">
              <el-option v-for="item in storeState.hotel" :key="item.hotel_id" :label="item.hotel_name"
                         :value="item.hotel_id" :disabled="item.status !== '1'"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row type="flex" justify="between">
        <el-col class="zhong" :span="20">以下内容为分账结算规则配置，为避免出现分账结算金额等错误，请仔细填写及核对！新规则将在次月1日00:00起生效</el-col>
        <el-col :span="4" style="text-align:right;">
          <el-button type="text" v-if="storeState.rule_id === null">增加规则</el-button>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="12">
          <el-form-item label="规则模块">
            <el-select v-model="storeState.form.module" filterable :disabled="storeState.rule_id !== null">
              <el-option v-for="item in storeState.module" :key="item.value" :label="item.name" :value="item.value" :disabled="item.status !== '1'" @change="handleModuleSelect(item.value)"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="12" v-if="storeState.form.module !== 'base_pay'">
          <el-form-item prop="regular_jfk_cost" label="金房卡手续费">
            <el-input icon="search" v-model="storeState.form.regular_jfk_cost" type="number">
              <el-select v-model="storeState.select.regular_jfk_cost" slot="prepend" placeholder="请选择">
                <el-option label="百分比" value="1"></el-option>
                <el-option label="固定金额" value="2"></el-option>
              </el-select>
              <template slot="append">{{storeState.select.regular_jfk_cost === '1' ? '%' : '元'}}</template>
            </el-input>
          </el-form-item>
        </el-col>
        <!-- 基础月费 -->
        <el-col :span="12" v-if="storeState.form.module === 'base_pay'">
          <el-form-item  label="基础月费">
            <el-input icon="search"  type="number" v-model="storeState.form.regular_base" @change="handleRegularBase()" >
              <template slot="prepend">固定金额</template>
              <template slot="append">元</template>
            </el-input>
            <div class="el-form-item__error">{{baseregularErr}}</div>
          </el-form-item>
        </el-col>        
      </el-row>
      <el-row v-if="storeState.form.module !== 'base_pay'">
        <el-col :span="12">
          <el-form-item prop="regular_jfk" label="金房卡分成">
            <el-input v-model="storeState.form.regular_jfk" ref="jfk" type="number">
              <el-select v-model="storeState.select.regular_jfk" slot="prepend" placeholder="请选择">
                <el-option label="百分比" value="1"></el-option>
                <el-option label="固定金额" value="2"></el-option>
              </el-select>
              <template slot="append">{{storeState.select.regular_jfk === '1' ? '%' : '元'}}</template>
            </el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item prop="regular_group" label="集团分成">
            <el-input v-model="storeState.select.regular_group === '3' ? '' : storeState.form.regular_group" ref="group"
                      :disabled="storeState.select.regular_group === '3'" type="number">
              <el-select v-model="storeState.select.regular_group" slot="prepend" placeholder="请选择">
                <el-option label="百分比" value="1"></el-option>
                <el-option label="固定金额" value="2"></el-option>
                <el-option label="剩余金额" value="3"></el-option>
              </el-select>
              <template slot="append" v-if="storeState.select.regular_group !== '3'">
                {{storeState.select.regular_group === '1' ? '%' : '元'}}

              </template>
            </el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row v-if="storeState.form.module !== 'base_pay'">
        <el-col :span="12">
          <el-form-item prop="regular_hotel" label="门店分成">
            <el-input v-model="storeState.select.regular_hotel === '3' ? '' : storeState.form.regular_hotel" ref="hotel"
                      :disabled="storeState.select.regular_hotel === '3'" type="number">
              <el-select v-model="storeState.select.regular_hotel" slot="prepend" placeholder="请选择">
                <el-option label="百分比" value="1"></el-option>
                <el-option label="固定金额" value="2"></el-option>
                <el-option label="剩余金额" value="3"></el-option>
              </el-select>
              <template slot="append" v-if="storeState.select.regular_hotel !== '3'">
                {{storeState.select.regular_hotel === '1' ? '%' : '元'}}
              </template>
            </el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="分销员分成">
            <el-input :disable="true" v-model="storeState.form.regular_dist" type="number" :disabled="true">
              <el-select v-model="storeState.select.regular_dist" slot="prepend" placeholder="请选择">
                <el-option label="根据分销规则" value="4"></el-option>
              </el-select>
              <template slot="append">元/笔</template>
            </el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-form-item>
        <el-row type="flex" justify="center">
          <el-button type="primary" @click="submitForm('form')">保  存</el-button>
        </el-row>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
  import store from './store/main'
  export default {
    data () {
      let regularGroup = function (rule, value, callback) {
        if (value === '' && this.storeState.select.regular_group !== '3') {
          callback(new Error('请填写集团分成'))
        } else if (parseInt(value) > 100 && this.storeState.select.regular_group === '1') {
          callback(new Error('请输入0-100内的数字'))
        } else if (parseInt(value) < 0) {
          callback(new Error('请输入大于0的数字'))
        } else {
          callback()
        }
      }.bind(this)
      let regularHotel = function (rule, value, callback) {
        if (this.storeState.form.module === 'vip') {
          callback()
        } else {
          if (value === '' && this.storeState.select.regular_hotel !== '3') {
            callback(new Error('请填写门店分成'))
          } else if (parseInt(value) > 100 && this.storeState.select.regular_hotel === '1') {
            callback(new Error('请输入0-100内的数字'))
          } else if (parseInt(value) < 0) {
            callback(new Error('请输入大于0的数字'))
          } else {
            callback()
          }
        }
      }.bind(this)
      let regularCost = function (rule, value, callback) {
        if (value === '' && this.storeState.select.regular_jfk_cost !== '3') {
          callback(new Error('请填些金房卡手续费'))
        } else if (parseInt(value) > 100 && this.storeState.select.regular_jfk_cost === '1') {
          callback(new Error('请输入0-100内的数字'))
        } else if (parseInt(value) < 0) {
          callback(new Error('请输入大于0的数字'))
        } else {
          callback()
        }
      }.bind(this)
      let regularRule = function (rule, value, callback) {
        if (value === '' && this.storeState.select.regular_jfk !== '3') {
          callback(new Error('请填写金房卡分成'))
        } else if (parseInt(value) > 100 && this.storeState.select.regular_jfk === '1') {
          callback(new Error('请输入0-100内的数字'))
        } else if (parseInt(value) < 0) {
          callback(new Error('请输入大于0的数字'))
        } else {
          callback()
        }
      }.bind(this)
      return {
        status: false,
        storeState: store.state,
        rules: {
          hotel_id: [
            {required: true, message: '请选择门店', trigger: 'change'}
          ],
          regular_jfk_cost: [
            {required: true, validator: regularCost, trigger: 'change'}
          ],
          regular_jfk: [
            {required: true, validator: regularRule, trigger: 'change'}
          ],
          regular_group: [
            {required: true, validator: regularGroup, trigger: 'change'}
          ],
          regular_hotel: [
            {required: true, validator: regularHotel, trigger: 'change'}
          ]
        },
        baseregularErr: ''
      }
    },
    methods: {
      handleRegularBase () {
        if (this.storeState.form.regular_base && parseInt(this.storeState.form.regular_base) >= 0) {
          this.baseregularErr = ''
        }
      },
      input (a) {
        console.log(this.$refs[a])
      },
      handleModuleSelect (val) {
        this.storeState.form.module = val
      },
      submitForm (a) {
        this.$refs[a].validate(function (valid) {
          console.log(this.storeState.select.regular_hotel, this.storeState.form.regular_hotel)
          let regularJfkCost = this.storeState.select.regular_jfk_cost === '2' ? this.storeState.form.regular_jfk_cost : (this.storeState.form.regular_jfk_cost + '%')
          let regularJfk = this.storeState.select.regular_jfk === '2' ? this.storeState.form.regular_jfk : this.storeState.form.regular_jfk + '%'
          let regularJfkGroup = this.storeState.select.regular_group === '2' ? this.storeState.form.regular_group : this.storeState.select.regular_group === '3' ? '-1' : this.storeState.form.regular_group + '%'
          let regularJfkHotel = this.storeState.select.regular_hotel === '2' ? this.storeState.form.regular_hotel : this.storeState.select.regular_hotel === '3' ? '-1' : this.storeState.form.regular_hotel + '%'
          console.log(regularJfkCost, regularJfk, regularJfkGroup, regularJfkHotel)
          if (valid) {
            if (this.storeState.form.module === 'base_pay') {
              console.log(this.storeState.form.regular_base)
              if (!this.storeState.form.regular_base || parseInt(this.storeState.form.regular_base) < 0) {
                this.baseregularErr = '请输入正确的基础月费'
                return
              }
            } else if (this.storeState.select.regular_group !== '3' && this.storeState.select.regular_hotel !== '3') {
              this.$notify({
                title: '失败',
                message: '门店分成和集团分成必须有一个设置剩余金额类型',
                type: 'error'
              })
              return
            }
            let send = {
              'inter_id': this.storeState.inter_id,
              'hotel_id': this.storeState.hotel_id,
              'inter_name': this.storeState.inter_name,
              'rule_id': this.storeState.rule_id,
              'rule_info': {
                'module': this.storeState.form.module,
                'regular_jfk_cost': regularJfkCost,
                'regular_jfk': regularJfk,
                'regular_group': regularJfkGroup,
                'regular_hotel': regularJfkHotel
              },
              'regular_base': this.storeState.form.regular_base || ''
            }
            store.putSaveRule(send, function (e) {
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
            console.log('error submit!!')
            return false
          }
        }.bind(this))
      },
      getQueryString (name) {
        let reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i')
        let r = window.location.search.substr(1).match(reg)
        if (r != null) {
          return unescape(r[2])
        }
        return null
      }
    },
    mounted: function () {
      this.storeState.rule_id = this.getQueryString('rule_id')
      let params = {
        rule_id: this.storeState.rule_id
      }
      if (process.env.NODE_ENV === 'development') {
        params.inter_id = null
      }
      store.getSplitRule(params)
    }
  }
</script>
<style>
  .line {
    text-align: center;
  }

  .el-select {
    width: 100%;
  }

  .el-row {
    margin: 10px 0px;
  }

  .zhong {
    color: #c2cbd9;
    font-size: 14px;
    align-self: center;
  }

  .el-select .el-input {
    min-width: 110px;
  }

  .jfk-pages {
    padding-top: 2.7%;
  }

  .el-table--border th, .el-table--border td {
    border-right: 0px !important;
  }
</style>
