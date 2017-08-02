<template>
  <div class="jfk-pages__modules jfk-pages__modules-preview">
    <dl class="jfk-fieldset jfk-fieldset__preview">
      <dt class="jfk-fieldset__hd">
        <div class="jfk-fieldset__title">基础信息</div>
      </dt>
      <dd class="jfk-fieldset__content">
        <el-row class="preview-group-baseinfo">
          <el-col :lg="12" :md="24" class="preview-items">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">价格类型</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">
              {{confCodeType[form.type]}}{{form.type === 'protrol' ? ';协议代码：' + form.unlockCode : ''}}
            </el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">价格名称</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.priceName}}</el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">价格描述</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.des}}</el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items" v-if="form.sDateS || form.sDateE">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">入住日期</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{sDateText}}</el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items" v-if="form.eDateS || form.eDateE">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">离店日期</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{eDateText}}</el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">可用星期</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{limitWeeksText}}</el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">早餐</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{confBfFields[form.breakfastNums]}}</el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">价格策略</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{confPriceCodes[form.relatedCode] && confPriceCodes[form.relatedCode].price_name || ''}}</el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items">
            <el-row>
              <el-col :lg="{span: 4}" :span="3" class="preview-label">适用范围</el-col>
              <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content" v-if="form.allRooms === '1'">全部门店和房型</el-col>
              <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content"  v-else>
                <p class="limit-room-tip">共<span>{{limitRoomCheckedCount}}</span>家酒店</p>
                <ul class="list-no-style">
                  <li
                    v-for="(val, key) in form.limitRoomChecked"
                    :key="'hotel_' + key">
                    <span class="hotel-name">{{hotelRoomItems[key].name}}：</span>
                    {{hotelRoomNameLists(val.rooms, hotelRoomItems[key].room_ids)}}
                  </li>
                </ul>
              </el-col>
            </el-row>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items" v-if="hasConfMemberLevel || hasConfPayWays || form.prePay !== ''">
            <el-row>
              <el-col :lg="{span: 4}" :span="3" class="preview-label">适用条件</el-col>
              <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">
                <el-col v-if="hasConfMemberLevel">会员等级：{{confMemberLevels[form.memberLevel]}}</el-col>
                <el-col v-if="hasConfPayWays">支付方式：{{payWaysText}}</el-col>
                <el-col v-if="form.prePay !== ''">预付标记：{{form.prePay ? '显示' : '不显示'}}</el-col>
              </el-col>
            </el-row>
          </el-col>
          <template v-if="form.isPackages === '1'">
            <el-col :lg="12" :md="24" class="preview-items">
              <el-row type="flex">
                <el-col :lg="{span: 4}" :span="3" class="preview-label">套餐设置</el-col>
                <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">
                  <el-col>销售方式：{{goodInfoSaleWayText}}</el-col>
                  <template v-if="form.goodInfoSaleWay === 1">
                    <el-col>计价方式：{{form.goodInfoCountWay === 1 ? '按房晚' : '按订单'}}</el-col>
                    <el-col><span class="jfk-f-l">订购须知：</span> <pre class="jfk-f-l">{{form.goodInfoSaleNotice}}</pre></el-col>
                  </template>
                </el-col>
              </el-row>
            </el-col>
          </template>
        </el-row>
      </dd>
      <template v-if="form.isPackages === '1'">
        <dt class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">关联商品</div>
        </dt>
        <dd class="jfk-fieldset__content">
          <el-table
            :class="{'jfk-table--no-border': previewGoodInfo.length > 1}"
            :show-header="false"
            :data="previewGoodInfo">
            <el-table-column>
              <template scope="scope">
                {{scope.row.name || goodItems[scope.row.gs_id].name}}
              </template>
            </el-table-column>
            <el-table-column>
              <template scope="scope">
                {{goodInfoSaleWayText}}
              </template>
            </el-table-column>
            <el-table-column>
              <template scope="scope">
                {{scope.row.num}}{{scope.row.unit || goodItems[scope.row.gs_id].unit}}
              </template>
            </el-table-column>
            <el-table-column v-if="form.goodInfoSaleWay === 1">
              <template scope="scope">
              {{form.goodInfoCountWay === 1 ? '按房晚' : '按订单'}}
              </template>
            </el-table-column>
          </el-table>
        </dd>
      </template>
      <dt class="jfk-fieldset__hd">
        <div class="jfk-fieldset__title">预定政策</div>
      </dt>
      <dd class="jfk-fieldset__content">
        <el-row class="preview-group-policy">
          <template v-if="hasConfPayWays">
            <el-col :lg="12" :md="24" class="preview-items">
              <el-row type="flex" align="middle">
                <el-col :lg="{span: 4}" :span="3" class="preview-label">保留时间</el-col>
                <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">
                  <el-col
                    v-for="(time, payway) in form.retainTime"
                    :key="'retainTime_' + payway">
                    {{confPayWays[payway].pay_name}}：入住日期{{time}}
                  </el-col>
                </el-col>
              </el-row>
            </el-col>
            <el-col :lg="12" :md="24" class="preview-items">
              <el-row type="flex" align="middle">
                <el-col :lg="{span: 4}" :span="3" class="preview-label">退房时间</el-col>
                <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">
                  <el-col
                    v-for="(time, payway) in form.delayTime"
                    :key="'delayTime_' + payway">
                    {{confPayWays[payway].pay_name}}：离店日期{{time}}
                  </el-col>
                </el-col>
              </el-row>
            </el-col>
          </template>
        </el-row>
      </dd>
      <template v-if="form.preD !== '' || form.mxn || form.minDay || form.mxd || form.type === 'athour'">
        <dt class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">高级预定政策</div>
        </dt>
        <dd class="jfk-fieldset__content">
          <el-row>
            <el-col :lg="12" :md="24" class="preview-items" v-if="form.preD !== ''">
              <el-col :lg="{span: 4}" :span="3" class="preview-label">提前预定天数</el-col>
              <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.preD}}天</el-col>
            </el-col>
            <el-col :lg="12" :md="24" class="preview-items" v-if="form.mxn">
              <el-col :lg="{span: 4}" :span="3" class="preview-label">单次最大单数</el-col>
              <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.mxn}}间</el-col>
            </el-col>
            <el-col :lg="12" :md="24" class="preview-items" v-if="form.minDay || form.mxd">
              <el-col :lg="{span: 4}" :span="3" class="preview-label">可定天数</el-col>
              <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">
                <template v-if="form.minDay">
                  最少须定{{form.minDay}}天，
                </template>
                <template v-if="form.mxd">
                  最多能定{{form.mxd}}天
                </template>
              </el-col>
            </el-col>
            <template v-if="form.type === 'athour'">
              <el-col :lg="12" :md="24" class="preview-items">
                <el-col :lg="{span: 4}" :span="3" class="preview-label">到店时间段</el-col>
                <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">
                在{{form.bookTimeStart}}至{{form.bookTimeEnd}}之间</el-col>
              </el-col>
              <el-col :lg="12" :md="24" class="preview-items">
                <el-col :lg="{span: 4}" :span="3" class="preview-label">时间间隔</el-col>
                <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{confBookTimeMod[form.bookTimeMod]}}</el-col>
              </el-col>
            </template>
          </el-row>
        </dd>
      </template>
      <dt class="jfk-fieldset__hd">
        <div class="jfk-fieldset__title">营销规则</div>
      </dt>
      <dd class="jfk-fieldset__content">
        <el-row>
          <el-col :lg="12" :md="24" class="preview-items" v-if="hasWxPayInPayways && form.wxPayFavour">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">微信支付立减</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.wxPayFavour}}元</el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">用券规则</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{couponText}}</el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items" v-if="Object.keys(confCouponTypes).length">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">券关联</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">
              {{confCouponTypes[form.couprel].title}}
            </el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">积分兑换</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.bonusNoPart === 1 ? '不可用' : '可用'}}</el-col>
          </el-col>
          <el-col :lg="12" :md="24" class="preview-items">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">积分与券</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.bonusPoc === 1 ? '不可同用' : '可同用'}}</el-col>
          </el-col>
          <template v-if="form.isPms !== 0">
            <el-col :lg="12" :md="24" class="preview-items">
              <el-col :lg="{span: 4}" :span="3" class="preview-label">使用PMS券</el-col>
              <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.couponIsPms === 1 ? '使用' : '不使用'}}</el-col>
            </el-col>
            <el-col :lg="12" :md="24" class="preview-items">
              <el-col :lg="{span: 4}" :span="3" class="preview-label">PMS代码</el-col>
              <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.externalCode || '无'}}</el-col>
            </el-col>
          </template>
          <el-col :lg="12" :md="24" class="preview-items" v-if="form.isPackages === '0'">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">仅用于套票预订</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.packageOnly === 1 ? '是' : '否'}}</el-col>
          </el-col>
        </el-row>
      </dd>
      <dt class="jfk-fieldset__hd">
        <div class="jfk-fieldset__title">其他</div>
      </dt>
      <dd class="jfk-fieldset__content">
        <el-row>
          <el-col v-if="form.sort" :lg="12" :md="24">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">排序</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{form.sort}}</el-col>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-col :lg="{span: 4}" :span="3" class="preview-label">状态</el-col>
            <el-col :lg="{span: 19}" :span="20" :offset="1" class="preview-content">{{confCodeStatus[form.status]}}</el-col>
          </el-col>
        </el-row>
      </dd>
    </dl>
    
    <el-row type="flex" justify="center">
      <el-button @click.native.prevent="handlePrevStep" :disabled="posting" size="large" class="jfk-button--middle">上一步</el-button>
      <el-button @click.native.prevent="handleNextStep" type="primary" :loading="posting" size="large" class="jfk-button--middle">{{postText}}</el-button>
    </el-row>
  </div>
</template>
<script>
  import { mapState, mapMutations, mapGetters } from 'vuex'
  import { UPDATE_PRICE_STEP } from '@/service/booking/types'
  import routerConfig from '../router/config'
  import { omitKeys } from '@/utils/utils'
  import { postHotelPricesCode } from '@/service/booking/http'
  export default {
    data () {
      return {
        posting: false
      }
    },
    methods: {
      ...mapMutations([
        UPDATE_PRICE_STEP
      ]),
      handlePrevStep () {
        if (this.posting) {
          return
        }
        this[UPDATE_PRICE_STEP]({
          increment: false
        })
      },
      handleNextStep () {
        if (this.posting) { // 防止浏览器对pointer-events不支持
          return
        }
        var data = this.getPriceData()
        this.posting = true
        let that = this
        postHotelPricesCode(data).then(function (res) {
          if (res.status === 1000) {
            that.posting = false
            const next = res.web_data.page_resource.links.next
            if (process.env.NODE_ENV !== 'development') {
              location.href = next
            } else {
              let pcode = that.form.priceCode
              that.$msgbox({
                'title': '保存成功',
                'message': pcode ? `编辑价格代码{pcode: ${pcode}}成功` : `添加价格成功，pcode为${res.web_data.pcode}`,
                type: 'success'
              })
            }
          }
        }).catch(function (err) {
          console.log(err)
          that.posting = false
        })
      },
      hotelRoomNameLists (roomIds, rooms) {
        let roomNames = []
        for (let id in roomIds) {
          roomNames.push(rooms[id].name)
        }
        return roomNames.join('、')
      },
      getPriceData () {
        const result = {
          [this.form.csrfToken]: this.form.csrfValue,
          price_code: this.form.priceCode,
          inter_id: this.form.interId,
          price_name: this.form.priceName,
          status: this.form.status,
          use_condition: {
            no_pay_way: this.getNoPayWay,
            member_level: this.form.memberLevel,
            pre_d: this.form.preD,
            s_date_s: (this.form.sDateS1 || '').replace(/-/g, ''),
            s_date_e: (this.form.sDateE1 || '').replace(/-/g, ''),
            e_date_s: (this.form.eDateS1 || '').replace(/-/g, ''),
            e_date_e: (this.form.eDateE1 || '').replace(/-/g, ''),
            mxn: this.form.mxn,
            mxd: this.form.mxd,
            min_day: this.form.minDay
          },
          des: this.form.des,
          sort: this.form.sort,
          type: this.form.type,
          related_code: this.form.relatedCode,
          coupon_condition: {
            no_coupon: this.form.couponNoUse
          },
          bonus_condition: {
            no_part_bonus: this.form.bonusNoPart,
            poc: this.form.bonusPoc
          },
          time_condition: {
            limit_weeks: this.form.limitWeeks
          },
          bookpolicy_condition: {
            breakfast_nums: this.form.breakfastNums
          },
          is_packages: this.form.isPackages,
          all_rooms: this.form.allRooms
        }
        if (this.form.prePay !== '') {
          result.use_condition.pre_pay = this.form.prePay
        }
        if (this.form.type === 'athour') { // 时租价
          result.time_condition.book_time = {
            s: this.form.bookTimeStart.replace(':', ''),
            e: this.form.bookTimeEnd.replace(':', ''),
            mod: this.form.bookTimeMod
          }
        }
        if (this.form.type === 'protrol') { // 协议价码
          result.unlock_code = this.form.unlockCode
        }
        if (this.form.type !== 'member' || this.form.relatedCode !== '-1') { // 非会员价
          result.related_cal_way = this.form.relatedCalWay // 计算方式
          result.related_cal_value = this.form.relatedCalValue // 计算值
        }
        if (this.form.isPms !== 0) {
          result.external_code = this.form.externalCode
          result.coupon_condition.is_pms = this.form.couponIsPms
        }
        // 用券规则
        if (this.form.couponNoUse === 0) {
          result.coupon_condition.coupon_num = this.form.couponNum
          result.coupon_condition.num_type = this.form.couponNumType
        }
        if (Object.keys(this.confCouponTypes).length) {
          result.coupon_condition.couprel = this.form.couprel
        }
        if (this.form.payWays.length) {
          result.bookpolicy_condition.retain_time = {}
          result.bookpolicy_condition.delay_time = {}
          // 支付保留退房时间时间
          for (let pay in this.form.delayTime) {
            result.bookpolicy_condition.delay_time[pay] = this.form.delayTime[pay].replace(':00', '')
          }
          for (let pay in this.form.retainTime) {
            result.bookpolicy_condition.retain_time[pay] = this.form.retainTime[pay].replace(':00', '')
          }
          if (this.hasWxPayInPayways && this.form.wxPayFavour) {
            result.bookpolicy_condition.wxpay_favour = this.form.wxPayFavour
          }
        }
        if (this.form.isPackages === '1') {
          result.goods_info = {
            sale_way: this.form.goodInfoSaleWay
          }
          if (this.form.goodInfoSaleWay === 1) {
            result.goods_info.count_way = this.form.goodInfoCountWay
            result.goods_info.sale_notice = this.form.goodInfoSaleNotice
          }
          result.goods_info.items = this.form.goodInfoItems.items
        } else {
          result.use_condition.package_only = this.form.packageOnly
        }
        if (this.form.allRooms === '0') {
          let rooms = {}
          for (let hotelId in this.form.limitRoomChecked) {
            rooms[hotelId] = Object.keys(this.form.limitRoomChecked[hotelId].rooms)
          }
          result.h_roomids = rooms
        }
        return result
      }
    },
    computed: {
      ...mapState(['form']),
      ...mapState('config', [
        'confCodeType',
        'confWeeks',
        'confBfFields',
        'confPriceCodes',
        'confMemberLevels',
        'confPayWays',
        'confBookTimeMod',
        'confCouponNumType',
        'confCodeStatus',
        'confCouponTypes'
      ]),
      ...mapState('rooms', [
        'hotelRoomItems'
      ]),
      ...mapState('goods', [
        'goodItems'
      ]),
      ...mapGetters('config', [
        'hasConfMemberLevel',
        'hasConfPayWays'
      ]),
      ...mapGetters('form', [
        'limitRoomCheckedCount',
        'hasWxPayInPayways'
      ]),
      limitWeeksText () {
        let texts = []
        let that = this
        that.form.limitWeeks.forEach(function (week) {
          texts.push(that.confWeeks[week])
        })
        return texts.join('，')
      },
      sDateText () {
        if (this.form.sDateS1 && this.form.sDateE1) {
          return `必须在${this.form.sDateS1}和${this.form.sDateE1}之间入住`
        }
        if (this.form.sDateS1) {
          return `必须在${this.form.sDateS1}之后入住`
        }
        if (this.form.sDateE1) {
          return `必须在${this.form.sDateE1}之前入住`
        }
      },
      eDateText () {
        if (this.form.eDateS1 && this.form.eDateE1) {
          return `必须在${this.form.eDateS1}和${this.form.eDateE1}之间离店`
        }
        if (this.form.eDateS1) {
          return `必须在${this.form.eDateS1}之后离店`
        }
        if (this.form.eDateE1) {
          return `必须在${this.form.eDateE1}之前离店`
        }
      },
      couponText () {
        if (this.form.couponNoUse === 1) {
          return '不可用'
        }
        return `可用，每个${this.confCouponNumType[this.form.couponNumType]}可用${this.form.couponNum}张`
      },
      payWaysText () {
        let texts = []
        let that = this
        that.form.payWays.forEach(function (payway) {
          texts.push(that.confPayWays[payway].pay_name)
        })
        return texts.join('，')
      },
      postText () {
        return `保存${this.posting ? '中' : ''}`
      },
      goodInfoSaleWayText () {
        return this.form.goodInfoSaleWay === 1 ? '包价' : '自由组合'
      },
      getNoPayWay () {
        let allPayWays = Object.keys(this.confPayWays)
        if (!allPayWays.length || allPayWays.length === this.form.payWays.length) {
          return []
        } else {
          return omitKeys(this.form.payWays, this.confPayWays)
        }
      },
      previewGoodInfo () {
        let goodInfo = this.form.goodInfoItems.items
        let items = []
        for (let good in goodInfo) {
          items.push(goodInfo[good])
        }
        console.log(this.goodItems)
        return items
      }
    },
    beforeRouteEnter (to, from, next) {
      next(vm => {
        if ((!vm.pcode && !from.name) || !vm.form.type || !vm.form.priceName || !vm.form.des || !vm.form.limitWeeks.length) {
          return next({
            path: routerConfig[0].path
          })
        }
        return true
      })
    }
  }
</script>
<style lang="postcss" scoped="scoped">
  .jfk-fieldset__preview{
    font-size: 12px;
    line-height: 2;
  }
  .el-table{
    font-size: 12px;
  }
  .preview-label{
    color: #808080;
    font-size: 12px;
    text-align: right;
  }
  .preview-content{
    color: #333
  }
  .limit-room-tip{
    color: #bfbfbf
  }
  .limit-room-tip span{
    color: #333
  }
  .list-no-style{
    color: #bfbfbf;
  }
  .hotel-name{
    color: #333;
  }
  pre{
    border: 0 none;
    padding: 0;
    font-size: 12px;
    margin: 0;
    background-color: transparent
  }
</style>
