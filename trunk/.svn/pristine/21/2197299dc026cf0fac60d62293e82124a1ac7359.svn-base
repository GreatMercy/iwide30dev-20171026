<template>
  <div class="jfk-pages__modules jfk-pages__modules-policy">
    <el-form ref="policyForm" :rules="policyRules" :model="form" label-width="150px">
      <div class="jfk-fieldset">
        <div class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">
            预定政策
          </div>
        </div>
        <el-row>
          <el-col :lg="12" :md="24">
            <el-row type="flex" align="middle">
              <div class="policy-time-label">保留时间</div>
              <div class="policy-time-content">
                <el-form-item
                  v-for="item in form.payWays"
                  :label="confPayWays[item].pay_name + ' 入住日期'"
                  label-width="250px"
                  :key="item">
                  <el-time-select
                    v-model="form.retainTime[item]"
                    :editable="false"
                    :picker-options="{
                      start: '00:00',
                      end: '23:00',
                      step: '01:00'
                    }"
                    placeholder="入住时间">
                  </el-time-select>
                </el-form-item>
              </div>
            </el-row>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-row type="flex" align="middle">
              <div class="policy-time-label">退房时间</div>
              <div class="policy-time-content">
                <el-form-item
                  v-for="item in form.payWays"
                  :label="confPayWays[item].pay_name + ' 离店日期'"
                  label-width="250px"
                  :key="item">
                  <el-time-select
                    v-model="form.delayTime[item]"
                    :editable="false"
                    :picker-options="{
                      start: '00:00',
                      end: '23:00',
                      step: '01:00'
                    }"
                    placeholder="退房时间">
                  </el-time-select>
                </el-form-item>
              </div>
            </el-row>
          </el-col>
        </el-row>
      </div>
      <div class="jfk-fieldset">
        <div class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">
            高级预订政策
          </div>
        </div>
        <el-row>
          <el-col :lg="12" :md="24">
            <el-form-item label="提前预定天数" prop="preD">
                <el-input v-model.trim="form.preD" class="jfk-input__fixed-width--110">
                  <template slot="append">天</template>
                </el-input>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="单次最大间数" prop="mxn">
              <el-input v-model.trim="form.mxn" class="jfk-input__fixed-width--110">
                <template slot="append">间</template>
              </el-input>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="可定天数">
              <el-col :span="11">
                <el-form-item prop="minDay">
                  <el-input v-model="form.minDay" placeholder="最小可定天数" class="jfk-input__diy-icon">
                    <template slot="prepend">
                      <i class="jfkfont icon-ipt_icon_gte_default"></i>
                    </template>
                  </el-input>
                </el-form-item>
              </el-col>
              <el-col :span="11" :offset="1">
                <el-form-item prop="mxd">
                  <el-input v-model="form.mxd" placeholder="最大可定天数"  class="jfk-input__diy-icon">
                    <template slot="prepend">
                      <i class="jfkfont icon-ipt_icon_lte_default"></i>
                    </template>
                  </el-input>
                </el-form-item>
              </el-col>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24" v-show="form.type === 'athour'">
            <el-form-item label="到店时间段" required>
              <el-form-item prop="bookTimeStart" class="jfk-d-ib">
                <el-time-select
                  placeholder="起始时间"
                  v-model="form.bookTimeStart"
                  :picker-options="{
                    start: '00:00',
                    step: '01:00',
                    end: '23:00'
                  }">
                </el-time-select>
              </el-form-item>
              <span>-</span>
              <el-form-item  prop="bookTimeEnd" class="jfk-d-ib">
                <el-time-select
                  placeholder="结束时间"
                  v-model="form.bookTimeEnd"
                  :picker-options="{
                    start: '00:00',
                    step: '01:00',
                    end: '23:00',
                    minTime: form.bookTimeStart
                  }">
                </el-time-select>
              </el-form-item>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24" v-show="form.type === 'athour'">
            <el-form-item label="时间间隔" prop="bookTimeMod" required>
              <el-select v-model="form.bookTimeMod">
                <el-option
                  v-for="(val, key) in confBookTimeMod"
                  :key="key"
                  :label="val"
                  :value="key">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <div class="jfk-fieldset">
        <div class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">
            营销规则
          </div>
        </div>
        <el-row>
          <el-col :lg="12" :md="24" v-show="hasWxPayInPayways">
            <el-form-item label="微信支付立减" prop="wxPayFavour">
              <el-input v-model.number="form.wxPayFavour" class="jfk-input__fixed-width--110">
                <template slot="append">元</template>
              </el-input>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="用券规则">
              <el-radio v-model="form.couponNoUse" :label="1">不可用</el-radio>
              <el-radio v-model="form.couponNoUse" :label="0">可用</el-radio>
              <el-form-item class="jfk-d-ib policy-coupon-num-type-box" prop="couponNum" v-show="form.couponNoUse === 0">
                <el-input placeholder="请输入使用张数" v-model="form.couponNum">
                  <el-select class="policy-coupon-num-type" v-model.number="form.couponNumType" slot="prepend" placeholder="请选择">
                    <el-option
                      v-for="(zh, key) in confCouponNumType"
                      :key="key"
                      :label="'按' + zh + '使用张数'"
                      :value="key">
                    </el-option>
                  </el-select>
                </el-input>
              </el-form-item>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24"  v-if="Object.keys(confCouponTypes).length">
            <el-form-item label="券关联">
              <el-select v-model="form.couprel" value-key="card_id">
                <el-option
                  v-for="(val, key) in confCouponTypes"
                  :key="key"
                  :label="val.title"
                  :value="key">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col  :lg="12" :md="24">
            <el-form-item label="积分兑换">
              <el-radio v-model="form.bonusNoPart" :label="1">不可用</el-radio>
              <el-radio v-model="form.bonusNoPart" :label="0">可用</el-radio>
            </el-form-item>
          </el-col>
          <el-col  :lg="12" :md="24">
            <el-form-item label="积分与券">
              <el-radio v-model="form.bonusPoc" :label="1">不可同用</el-radio>
              <el-radio v-model="form.bonusPoc" :label="0">可同用</el-radio>
            </el-form-item>
          </el-col>
          <el-col  :lg="12" :md="24"  v-if="form.isPms !== 0">
            <el-form-item label="使用pms券" >
              <el-radio v-model="form.couponIsPms" :label="0">不使用</el-radio>
              <el-radio v-model="form.couponIsPms" :label="1">使用</el-radio>
            </el-form-item>
          </el-col>
          <el-col  :lg="12" :md="24"  v-if="form.isPms !== 0">
            <el-form-item label="pms代码">
              <el-col :span="8">
              <el-input v-model="form.externalCode"></el-input>
              </el-col>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24" v-if="form.isPackages === '0'">
            <el-form-item label="仅用于套票预订">
              <el-radio v-model="form.packageOnly" :label="0">否</el-radio>
              <el-radio v-model="form.packageOnly" :label="1">是</el-radio>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <div class="jfk-fieldset">
        <div class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">
            其他
          </div>
        </div>
        <el-row>
          <el-col :lg="12" :md="24">
            <el-form-item label="排序" prop="sort">
              <el-input v-model="form.sort" class="jfk-input__fixed-width--110"></el-input>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="状态" prop="status">
              <el-radio-group v-model="form.status">
                <el-radio
                  v-for="(zh, key) in confCodeStatus"
                  :key="key"
                  :label="key">
                  {{zh}}
                </el-radio>
              </el-radio-group>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <el-row type="flex" justify="center">
        <el-button @click.native.prevent="handlePrevStep" size="large" class="jfk-button--middle">上一步</el-button>
        <el-button type="primary" @click.native.prevent="handleNextStep" size="large" class="jfk-button--middle">下一步</el-button>
      </el-row>
    </el-form>
  </div>
</template>
<script>
  import { mapState, mapMutations, mapGetters } from 'vuex'
  import { CODE_INFO, UPDATE_PRICE_STEP } from '@/service/booking/types'
  import routerConfig from '../router/config'
  import { stringIsValidMoney } from '@/utils/utils'
  const positiveIntegerReg = /^[1-9]\d*$/
  const nonNegativeIntegerReg = /^\d+$/
  export default {
    data () {
      const checkBookTimeMod = (rule, value, callback) => {
        if (this.form.type === 'athour' && !this.form.bookTimeMod) {
          return callback(new Error(rule.message))
        }
        return callback()
      }
      const checkBookTimeStart = (rule, value, callback) => {
        if (this.form.type === 'athour') {
          if (!this.form.bookTimeStart) {
            return callback(new Error('请输入最早到店时间'))
          }
          if (this.form.bookTimeEnd && this.form.bookTimeStart >= this.form.bookTimeEnd) {
            return callback(new Error('最早到店时间应该小于最迟到店时间'))
          }
        }
        return callback()
      }
      const checkBookTimeEnd = (rule, value, callback) => {
        if (this.form.type === 'athour') {
          if (!this.form.bookTimeEnd) {
            return callback(new Error('请输入最迟到店时间'))
          }
          if (this.form.bookTimeStart && this.form.bookTimeStart >= this.form.bookTimeEnd) {
            return callback(new Error('最迟到店时间应该大于最早到店时间'))
          }
        }
        return callback()
      }
      const checkPositiveInteger = (rule, value, callback) => {
        if (value !== '' && !positiveIntegerReg.test(value)) {
          return callback(new Error(rule.message))
        }
        return callback()
      }
      const checkNonNegativeInteger = (rule, value, callback) => {
        if (value !== '' && !nonNegativeIntegerReg.test(value)) {
          return callback(new Error(rule.message))
        }
        return callback()
      }
      const checkMinDay = (rule, value, callback) => {
        if (value && this.form.mxd) {
          this.$refs.policyForm.validateField('mxd')
        }
        return callback()
      }
      const checkMxd = (rule, value, callback) => {
        if (value && +this.form.minDay > +value) {
          return callback(new Error(rule.message))
        }
        return callback()
      }
      const checkCouponNum = (rule, value, callback) => {
        if (this.form.couponNoUse === 0) {
          if (value === '') {
            return callback(new Error('请输入用券的使用张数'))
          }
          if (!positiveIntegerReg.test(value)) {
            return callback(new Error('用券的使用张数必须为正整数'))
          }
        }
        return callback()
      }
      const checkWxPayFavour = (rule, value, callback) => {
        if (this.hasWxPayInPayways && value && !stringIsValidMoney(value)) {
          return callback(new Error(rule.message))
        }
        return callback()
      }
      return {
        policyRules: {
          bookTimeMod: [
            { validator: checkBookTimeMod, message: '时租价必须选择时间间隔', trigger: 'change' }
          ],
          bookTimeStart: [
            { validator: checkBookTimeStart, trigger: 'blur' }
          ],
          bookTimeEnd: [
            { validator: checkBookTimeEnd, trigger: 'blur' }
          ],
          preD: [
            { trigger: 'blur', message: '提前预定天数为非负整数', validator: checkNonNegativeInteger }
          ],
          mxn: [
            { trigger: 'blur', message: '单次最大间数为正整数', validator: checkPositiveInteger }
          ],
          minDay: [
            { trigger: 'blur', message: '最小可定天数为正整数', validator: checkPositiveInteger },
            { trigger: 'blur', validator: checkMinDay }
          ],
          mxd: [
            { trigger: 'blur', message: '最大可定天数为正整数', validator: checkPositiveInteger },
            { trigger: 'blur', message: '最大可定天数必须不小于最小可定天数', validator: checkMxd }
          ],
          couponNum: [
            { trigger: 'blur', validator: checkCouponNum }
          ],
          wxPayFavour: [
            { trigger: 'blur', message: '微信支付立减必须为最多两位小数的正数', validator: checkWxPayFavour }
          ],
          sort: [
            { trigger: 'blur', message: '排序必须为正整数', validator: checkPositiveInteger }
          ],
          status: [
            { trigger: 'change', message: '必须选择一个状态', required: true }
          ]
        }
      }
    },
    methods: {
      ...mapMutations('form', [
        CODE_INFO
      ]),
      ...mapMutations([
        UPDATE_PRICE_STEP
      ]),
      handlePrevStep () {
        this[UPDATE_PRICE_STEP]({
          increment: false
        })
      },
      handleNextStep () {
        console.log(this.$store.state)
        this.$refs.policyForm.validate((valid) => {
          if (valid) {
            this[UPDATE_PRICE_STEP]({
              increment: true
            })
          }
        })
      }
    },
    computed: {
      ...mapState('config', [
        'confPayWays',
        'confBookTimeMod',
        'confCouponNumType',
        'confCodeStatus',
        'confCouponTypes'
      ]),
      ...mapState(['form']),
      ...mapGetters('form', [
        'hasWxPayInPayways'
      ])
    },
    beforeRouteEnter (to, from, next) {
      // 这里根据前面选择的支付方式来初始化delay_time retain_time
      if (!from.name) {
        return next({
          path: routerConfig[0].path
        })
      }
      next(vm => {
        let delayTime = {}
        let retainTime = {}
        vm.form.payWays.forEach(function (payway) {
          delayTime[payway] = vm.form.delayTime[payway] || (vm.form.delay_time && vm.form.delay_time[payway] || '12') + ':00'
          retainTime[payway] = vm.form.retainTime[payway] || (vm.form.retain_time && vm.form.retain_time[payway] || '18') + ':00'
        })
        vm[CODE_INFO]({
          delayTime: delayTime,
          retainTime: retainTime
        })
      })
    }
  }
</script>
<style lang="postcss" scoped>
  .policy-coupon-num-type {
    width: 145px
  }
  .policy-coupon-num-type-box{
    max-width: 210px;
    margin-left: 15px;
  }
</style>
