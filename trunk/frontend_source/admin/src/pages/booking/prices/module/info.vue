<template>
  <div class="jfk-pages__modules jfk-pages__modules-baseinfo jfk-tofle">
    <el-form ref="infoForm" :rules="rules" :model="form" label-width="120px">
      <div class="jfk-fieldset">
        <div class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">基础设置</div>
        </div>
        <el-row>
          <el-col :lg="12" :md="24">
            <el-form-item label="价格类型" prop="type">
              <template v-if="Object.keys(confCodeType).length < 6">
                <el-radio-group v-model="form.type">
                  <el-radio
                    v-for="(desc, val) in confCodeType"
                    :key="val"
                    :label="val">
                    {{desc}}
                  </el-radio>
                </el-radio-group>
              </template>
              <template v-else>
                <el-select v-model="form.type" placeholder="请选择价格类型">
                  <el-option
                    v-for="(val, key) in confCodeType"
                    :key="key"
                    :value="key"
                    :label="val">
                  </el-option>
                </el-select>
              </template>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24" v-show="showUnlockCodeArea">
            <el-form-item required label="协议代码" prop="unlockCode">
              <el-input v-model="form.unlockCode"></el-input>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="价格代码名称" prop="priceName">
              <el-input
                v-model.trim="form.priceName"
                :maxlength=8
                :minlength=2
                placeholder="2至8个文字">
              </el-input>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="价格代码描述" prop="des">
              <el-input
                v-model.trim="form.des"
                :maxlength=50
                :minlength=2
                placeholder="50以内个文字">
              </el-input>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="可用日期" prop="limitWeeks">
              <el-checkbox
                class="checkbox-indeterminate"
                :indeterminate="limitWeeksIndeterminate"
                v-model="limitWeeksCheckAll"
                @change="handleLimitWeeksCheckAll">
                全选
              </el-checkbox>
              <el-checkbox-group
                class="jfk-d-ib"
                @change="handleLimitWeeksChange"
                v-model="form.limitWeeks">
                <el-checkbox
                  v-for="(zh, key) in confWeeks"
                  :min="1"
                  :label="key"
                  :key="key">
                  {{zh}}
                </el-checkbox>
              </el-checkbox-group>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="入住日期">
              <el-col :span="11">
                <el-form-item prop="sDateS">
                  <div class="el-input el-input-group el-input-group--prepend jfk-input__diy-icon">
                    <div class="el-input-group__prepend">
                      <i class="jfkfont icon-ipt_icon_gte_default"></i>
                    </div>
                    <el-date-picker
                      class="jfk-datepicker--width-auto"
                      v-model="form.sDateS"
                      type="date"
                      :editable="false"
                      @change="sDateSChange"
                      placeholder="最早入住日期">
                    </el-date-picker>
                  </div>
                </el-form-item>
              </el-col>
              <el-col :span="11" :offset="1">
                <el-form-item prop="sDateE">
                  <div class="el-input el-input-group el-input-group--prepend jfk-input__diy-icon">
                    <div class="el-input-group__prepend">
                      <i class="jfkfont icon-ipt_icon_lte_default"></i>
                    </div>
                    <el-date-picker
                      class="jfk-datepicker--width-auto"
                      v-model="form.sDateE"
                      type="date"
                      :editable="false"
                      @change="sDateEChange"
                      placeholder="最迟入住日期">
                    </el-date-picker>
                  </div>
                </el-form-item>
              </el-col>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="离店日期">
              <el-col :span="11">
                <el-form-item prop="eDateS">
                  <div class="el-input el-input-group el-input-group--prepend jfk-input__diy-icon">
                    <div class="el-input-group__prepend">
                      <i class="jfkfont icon-ipt_icon_gte_default"></i>
                    </div>
                    <el-date-picker
                      class="jfk-datepicker--width-auto"
                      v-model="form.eDateS"
                      type="date"
                      :editable="false"
                      @change="eDateSChange"
                      placeholder="最早离店日期">
                    </el-date-picker>
                  </div>
                </el-form-item>
              </el-col>
              <el-col :span="11" :offset="1">
                <el-form-item prop="eDateE">
                  <div class="el-input el-input-group el-input-group--prepend jfk-input__diy-icon">
                    <div class="el-input-group__prepend">
                      <i class="jfkfont icon-ipt_icon_lte_default"></i>
                    </div>
                    <el-date-picker
                      class="jfk-datepicker--width-auto"
                      v-model="form.eDateE"
                      type="date"
                      :editable="false"
                      @change="eDateEChange"
                      placeholder="最迟离店日期">
                    </el-date-picker>
                  </div>
                </el-form-item>
              </el-col>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="早餐">
              <el-select v-model="form.breakfastNums">
                <el-option
                  v-for="(val, key) in confBfFields"
                  :key="key"
                  :value="key"
                  :label="val">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <div class="jfk-fieldset">
        <div class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">价格策略</div>
        </div>
        <el-row>
          <el-col :lg="12" :md="24">
            <el-form-item label="关联价格代码">
              <el-select filterable v-model="form.relatedCode" value-key="price_code">
                <el-option
                  v-for="(val, key) in confPriceCodes"
                  :key="key"
                  :value="key"
                  :label="val.price_name">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <!-- 会员价不显示计算公式及计算值 -->
          <el-col :lg="12" :md="24" v-show="showRelatedCalArea">
            <el-form-item label="计算公式">
              <el-radio-group v-model="form.relatedCalWay">
                <el-radio
                  v-for="(val, key) in confCodeCalWay"
                  :label="key"
                  :key="key">
                  {{val}}
                </el-radio>
              </el-radio-group>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24" v-show="showRelatedCalArea">
            <el-form-item label="计算值" prop="relatedCalValue">
              <el-input v-model.number="form.relatedCalValue" class="jfk-input__fixed-width--110"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <div class="jfk-fieldset">
        <div class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">适用范围</div>
        </div>
        <el-row>
          <el-col :lg="24" :md="24">
            <el-form-item label="酒店房型" prop="allRooms">
              <el-radio-group v-model="form.allRooms" @change.native="handleChangeAllRooms">
                <el-radio label="1">全部门店和房型</el-radio>
                <el-radio label="0">部分门店和房型</el-radio>
              </el-radio-group>
              <el-button type="primary" :disabled="form.allRooms === '1' " :style="{padding: '4px 12px', 'margin-left': '5px'}" size="mini" @click="handleAddLimitRoom">{{limitRoomCheckedCount > 0 ? '修改' : '添加'}}</el-button>
            </el-form-item>
            <div style="margin-left: 42px">
              <template v-if="form.allRooms === '0' && limitRoomCheckedCount > 0">
                <el-table
                  class="jfk-table--no-border"
                  :data="hotelsChecked"
                  style="width: 100%"
                  max-height="350">
                  <el-table-column
                    label="酒店">
                    <template scope="scope">
                      <el-tag
                        :key="'hotel_' + scope.row.hotelId"
                        closable
                        @close="handleRomoveLimitHotel(scope.row.hotelId)"
                        type="primary">
                        {{hotelRoomItems[scope.row.hotelId].name}}
                      </el-tag>
                    </template>
                  </el-table-column>
                  <el-table-column
                    label="房型">
                    <template scope="scope">
                      <el-tag
                        v-for="(val, key) in scope.row.rooms"
                        :key="key"
                        closable
                        type="primary"
                        @close="handleRemoveLimitRoom(val, key)">
                        {{hotelRoomItems[val].room_ids[key].name}}
                      </el-tag>
                    </template>
                  </el-table-column>
                </el-table>
              </template>
            </div>
          </el-col>
        </el-row>
      </div>
      <div class="jfk-fieldset" v-if="hasConfMemberLevel || hasConfPayWays">
        <div class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">适用条件</div>
        </div>
        <el-row>
          <el-col :lg="12" :md="24"  v-if="hasConfMemberLevel">
            <el-form-item label="会员等级" prop="memberLevel">
              <el-radio-group v-model="form.memberLevel">
                <el-radio
                  v-for="(val, key) in confMemberLevels"
                  :key="key"
                  :label="key">
                  {{val}}
                </el-radio>
              </el-radio-group>
            </el-form-item>
          </el-col>
          </el-col>
          <el-col :lg="12" :md="24">
            <el-form-item label="预付标记" prop="prePay">
              <el-radio-group v-model="form.prePay">
                <el-radio :label="1">显示</el-radio>
                <el-radio :label="0">不显示</el-radio>
              </el-radio-group>
            </el-form-item>
          </el-col>
          <el-col :lg="12" :md="24" v-if="hasConfPayWays">
            <el-form-item label="支付方式" prop="payWays">
              <el-checkbox
                class="checkbox-indeterminate"
                :indeterminate="payWayIndeterminate"
                v-model="payWayCheckAll"
                @change="handlePayWaysCheckAll">
                全选
              </el-checkbox>
              <el-checkbox-group
                class="jfk-d-ib"
                v-model="form.payWays"
                @change="handlePayWayChange">
                <el-checkbox
                  v-for="(zh, key) in confPayWays"
                  :min="1"
                  :label="key"
                  :key="key">
                  {{zh.pay_name}}
                </el-checkbox>
              </el-checkbox-group>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <div class="jfk-fieldset">
        <div class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">套餐属性</div>
        </div>
        <el-row>
          <el-col>
            <el-form-item label="开启套餐属性">
              <el-switch
                :disabled="isPackageDisable"
                v-model="form.isPackages"
                on-text="开启"
                off-text="关闭"
                on-value="1"
                off-value="0">
              </el-switch>
              <span class="jfk-color--warning" v-show="isPackageDisable">支付方式包含{{packagePaymentSupportText}}才能开启套餐属性</span>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col>
            <el-form-item required label="销售方式" v-show="form.isPackages === '1'" prop="goodInfoSaleWay">
              <el-radio @input="handlegoodInfoSaleWayChange" class="goodInfo_sale_way" v-model="form.goodInfoSaleWay" :label="1">包价</el-radio>
              <div class="jfk-d-ib" v-show="form.goodInfoSaleWay === 1">
                <el-radio v-model="form.goodInfoCountWay" @input="handlegoodInfoSaleWayChange" :label="1">按房晚赠送</el-radio>
                <el-radio v-model="form.goodInfoCountWay" @input="handlegoodInfoSaleWayChange" :label="2">按订单赠送</el-radio>
              </div>
              <div>
                <el-radio @input="handlegoodInfoSaleWayChange" class="goodInfo_sale_way" v-model="form.goodInfoSaleWay" :label="2">自由组合</el-radio>
              </div>
            </el-form-item>
            <el-form-item required label="订购须知" class="saleNotice-item" prop="goodInfoSaleNotice" v-show="form.isPackages === '1' && form.goodInfoSaleWay === 1">
              <el-input type="textarea" @paste.native="handleGoodNoticePaste" :autosize="{minRows:2, maxRows: 6}" v-model="form.goodInfoSaleNotice"></el-input>
              <span class="notice-tip jfk-color--base-gray">{{noticeNumber}}个字，最多{{noticeMaxNumber}}个字</span>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <el-row type="flex" justify="center">
        <el-button type="primary" @click.native.prevent="handleNextStep"  class="jfk-button--large" size="large">下一步</el-button>
      </el-row>
    </el-form>
    <el-dialog
      title="添加酒店和房型"
      :visible.sync="limitRoom.dialog"
      lock-scroll
      size="small"
      class="jfk-dialog__title--center jfk-dialog__hotelRooms"
      @close="handleCloseLimitRoomDialog"
      @open="handleOpenLimitRoomDialog">
      <el-row class="hotelRoom_control">
        <el-col :span="12" class="checkall-input-box">
          <el-checkbox v-model="limitRoom.currentPageHasAllChecked" @change="handleCheckAllLimitRoomByPage">全选当前页</el-checkbox>
        </el-col>
        <el-col :span="12">
          <el-input
            size="small"
            ref="limitRoomKeywordInput"
            placeholder="请输入门店名称">
            <el-button slot="append" icon="search" @click="handleSearchLimitRoom"></el-button>
          </el-input>
        </el-col>
      </el-row>
      <div class="hotelRoom-box" v-loading="roomLoading">
        <el-tree
          :data="hotels"
          show-checkbox
          node-key="nid"
          ref="limitRoomTree"
          hightlight-current
          :default-checked-keys="limitRoom.defaultChecked"
          @check-change="handleLimitRoomCheckChange"
          :props="limitRoom.roomsProps">
        </el-tree>
        <div class="jfk-ta-r">
          <el-pagination
            class="jfk-d-ib jfk-mt-20"
            v-show="limitRoom.count > limitRoom.size"
            @current-change="handleLimitRoomCurrentChange"
            :current-page.sync="limitRoom.page"
            :page-size="limitRoom.size"
            layout="prev, pager, next, jumper"
            :total="limitRoom.count">
          </el-pagination>
        </div>
      </div>
      <el-row slot="footer" class="hotelRoom__footer">
        <el-col :span="12" class="jfk-ta-l jfk-fz-12 jfk-color--base-gray">已选<span class="jfk-color--base-silver"> {{limitRoomCheckedCount}} </span>家,共{{hotelRoomIds.__default__.count}}家</el-col>
        <el-col :span="12">
          <el-button type="primary" @click="handleCloseLimitRoomDialog">完成</el-button>
        </el-col>
      </el-row>
    </el-dialog>
    </div>
  </div>
</template>
<script>
  import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'
  import { INIT_HOTEL_ROOMS_ACTION, UPDATE_PRICE_STEP, UPDATE_HOTEL_ROOMS_ACTION, GET_HOTEL_ROOM_BY_CODE_ACTION } from '@/service/booking/types'
  const updateLimitRoomCheckedList = function (ctx, hotelId, roomId, isDelete) {
    let checkedHotel = ctx.form.limitRoomChecked[hotelId]
    if (isDelete) {
      if (checkedHotel) {
        if (!roomId) {
          ctx.$delete(ctx.form.limitRoomChecked, hotelId)
        } else {
          ctx.$delete(ctx.form.limitRoomChecked[hotelId].rooms, roomId)
          if (Object.keys(checkedHotel.rooms).length === 0) {
            // https://cn.vuejs.org/v2/api/#vm-delete
            ctx.$delete(ctx.form.limitRoomChecked, hotelId)
          }
        }
      }
    } else {
      let _hotel = checkedHotel ? {
        hotelId,
        rooms: {
          ...checkedHotel.rooms,
          [roomId]: hotelId
        }
      } : {
        hotelId,
        rooms: {
          [roomId]: hotelId
        }

      }
      ctx.form.limitRoomChecked = Object.assign({}, ctx.form.limitRoomChecked, {
        [hotelId]: _hotel
      })
    }
  }
  export default {
    name: 'price-info',
    data () {
      const checkMemberLevel = (rule, value, callback) => {
        if (rule.required && (!value || value === '-1')) {
          callback(new Error(rule.message))
        } else {
          callback()
        }
      }
      const checkLimitRoom = (rule, value, callback) => {
        if (value === '0' && this.limitRoom.shouldCheckAllRooms && this.limitRoomCheckedCount === 0) {
          return callback(new Error(rule.message))
        }
        return callback()
      }
      const checkgoodInfoSaleWay = (rule, value, callback) => {
        if (this.form.isPackages === '1') {
          if (value === 0) {
            return callback(new Error('请选择一种销售方式'))
          } else if (value === 1 && !this.form.goodInfoCountWay) { // 包价且未选择包价方式
            return callback(new Error('请选择一种包价方式'))
          }
        }
        return callback()
      }
      const checkgoodInfoSaleNotice = (rule, value, callback) => {
        if (this.form.isPackages === '1' && this.form.goodInfoSaleWay === 1) {
          if (!value) {
            return callback(new Error('请输入订购须知'))
          } else if (this.noticeNumber > this.noticeMaxNumber) {
            return callback(new Error(`订购须知最多${this.noticeMaxNumber}字`))
          }
        }
        return callback()
      }
      const checkSDateS = (rule, value, callback) => {
        if (value && this.form.sDateE) {
          this.$refs.infoForm.validateField('sDateE')
        }
        return callback()
      }
      const checkSDateE = (rule, value, callback) => {
        if (value && this.form.sDateS > value) {
          return callback(new Error(rule.message))
        }
        return callback()
      }
      const checkEDateS = (rule, value, callback) => {
        if (value && this.form.eDateE) {
          this.$refs.infoForm.validateField('eDateE')
        }
        return callback()
      }
      const checkEDateE = (rule, value, callback) => {
        if (value && this.form.eDateS > value) {
          return callback(new Error(rule.message))
        }
        return callback()
      }
      return {
        limitRoomKeyword: '',
        showUnlockCodeArea: false,
        noticeNumber: 0,
        noticeMaxNumber: 200,
        limitRoom: {
          dialog: false,
          keyword: '',
          page: 1,
          size: 10,
          count: 0,
          loading: true,
          first: true,
          currentPageHasAllChecked: false,
          roomsProps: {
            children: 'rooms',
            label: 'name'
          },
          // 当前页面上hotelIds
          currentPageHotelIds: [],
          refreshCheckedRoomTable: true,
          defaultChecked: [],
          shouldCheckAllRooms: false
        },
        payWayIndeterminate: false,
        payWayCheckAll: false,
        limitWeeksIndeterminate: false,
        limitWeeksCheckAll: false,
        isPackageDisable: false,
        rules: {
          type: [
            { required: true, message: '请选择价格类型', trigger: 'blur' }
          ],
          unlockCode: [
            { required: false, message: '请输入协议价', trigger: 'blur' }
          ],
          priceName: [
            { required: true, message: '请输入价格代码名称', trigger: 'blur' },
            { message: '价格代码必须为2-8个字符', trigger: 'blur', min: 2, max: 8, length: true }
          ],
          des: [
            { required: true, message: '请输入价格代码描述', trigger: 'blur' }
          ],
          limitWeeks: [
            { required: true, message: '请选择可用日期', trigger: 'change', type: 'array' }
          ],
          relatedCalValue: [
            { message: '请输入数值', trigger: 'blur', type: 'number' }
          ],
          allRooms: [
            { required: true, message: '请选择适用范围', trigger: 'change' },
            { validator: checkLimitRoom, message: '请添加部分门店与房型', trigger: 'change' }
          ],
          memberLevel: [
            { required: false, validator: checkMemberLevel, message: '价格类型为会员时，会员等级必填', trigger: 'change' }
          ],
          payWays: [
            { required: true, message: '至少选择一种支付方式', trigger: 'change', type: 'array' }
          ],
          goodInfoSaleWay: [
            { validator: checkgoodInfoSaleWay, trigger: 'change' }
          ],
          goodInfoSaleNotice: [
            { validator: checkgoodInfoSaleNotice, trigger: 'change' }
          ],
          sDateS: [
            { trigger: 'change', validator: checkSDateS }
          ],
          sDateE: [
            { trigger: 'change', message: '最迟入住日期必须不小于最早入住日期', validator: checkSDateE }
          ],
          eDateS: [
            { trigger: 'change', validator: checkEDateS }
          ],
          eDateE: [
            { trigger: 'change', message: '最迟离店日期必须不小于最早离店日期', validator: checkEDateE }
          ]
        }
      }
    },
    methods: {
      ...mapMutations([
        UPDATE_PRICE_STEP
      ]),
      ...mapActions('rooms', [
        INIT_HOTEL_ROOMS_ACTION,
        UPDATE_HOTEL_ROOMS_ACTION
      ]),
      ...mapActions('form', [
        GET_HOTEL_ROOM_BY_CODE_ACTION
      ]),
      handleLimitWeeksCheckAll (event) {
        this.form.limitWeeks = event.target.checked ? Object.keys(this.confWeeks) : []
        this.limitWeeksIndeterminate = false
      },
      handleLimitWeeksChange (value) {
        let checkedCount = value.length
        let total = Object.keys(this.confWeeks).length
        this.limitWeeksCheckAll = checkedCount === total
        this.limitWeeksIndeterminate = checkedCount > 0 && checkedCount < total
      },
      handlePayWaysCheckAll (event) {
        this.form.payWays = event.target.checked ? Object.keys(this.confPayWays) : []
        this.payWayIndeterminate = false
      },
      handlePayWayChange (value) {
        let checkedCount = value.length
        let total = Object.keys(this.confPayWays).length
        this.payWayCheckAll = checkedCount === total
        this.payWayIndeterminate = checkedCount > 0 && checkedCount < total
      },
      handleAddLimitRoom () {
        this.limitRoom.dialog = true
      },
      handleSearchLimitRoom () {
        // 在点击button时，更改this.limitRoom.keyword的值，防止实时触发hotels的计算
        this.limitRoom.keyword = this.$refs.limitRoomKeywordInput.currentValue
        // 判断是否有缓存
        let hasCacheData = this.hotelRoomIds[this.limitRoom.keyword || '__default__']
        // 检测这个keywords是否已经缓存
        if (!hasCacheData) {
          this[UPDATE_HOTEL_ROOMS_ACTION]({
            page: 1,
            size: this.limitRoom.size,
            keyword: this.limitRoom.keyword || ''
          })
        }
      },
      handleLimitRoomCurrentChange (page) {
        let start = this.limitRoom.size * (page - 1)
        let cacheData = this.hotelRoomIds[this.limitRoom.keyword || '__default__']
        if (!cacheData || !cacheData.hotelIds[start]) {
          this[UPDATE_HOTEL_ROOMS_ACTION]({
            page: page,
            size: this.limitRoom.size,
            keyword: this.limitRoom.keyword || ''
          })
        }
        this.limitRoom.currentPageHasAllChecked = false
        this.limitRoom.page = page
      },
      handleRomoveLimitHotel (hotelId) {
        updateLimitRoomCheckedList(this, hotelId, undefined, true)
      },
      handleRemoveLimitRoom (hotelId, roomId) {
        updateLimitRoomCheckedList(this, hotelId, roomId, true)
      },
      handleOpenLimitRoomDialog () {
        if (this.limitRoom.first) {
          this[INIT_HOTEL_ROOMS_ACTION]({
            page: 1,
            size: this.limitRoom.size
          })
          this.limitRoom.first = false
        }
        this.limitRoom.refreshCheckedRoomTable = false
        // 打开时变更limitRoom.defaultChecked
        let defaultChecked = []
        for (let hotel in this.form.limitRoomChecked) {
          let rooms = Object.keys(this.form.limitRoomChecked[hotel].rooms)
          defaultChecked = defaultChecked.concat(rooms)
        }
        this.limitRoom.defaultChecked = defaultChecked
      },
      handleCloseLimitRoomDialog () {
        this.limitRoom.dialog = false
        this.limitRoom.refreshCheckedRoomTable = true
        this.$refs.infoForm.validateField('allRooms')
      },
      handleNextStep () {
        this.$refs.infoForm.validate((valid) => {
          if (valid) {
            return this[UPDATE_PRICE_STEP]({
              increment: true
            })
          } else {
            console.log(arguments)
          }
        })
      },
      handleCheckAllLimitRoomByPage () {
        this.$refs.limitRoomTree.setCheckedKeys(this.limitRoom.currentPageHasAllChecked ? this.limitRoom.currentPageHotelIds : [])
      },
      handleLimitRoomCheckChange (hotelOrRoom, isChecked) {
        // 如果hotelOrRoom为room 来判断是否更新
        if (hotelOrRoom.room_id) {
          return updateLimitRoomCheckedList(this, hotelOrRoom.hotel_id, hotelOrRoom.room_id, !isChecked)
        }
      },
      handlegoodInfoSaleWayChange () {
        this.$refs.infoForm.validateField('goodInfoSaleWay')
      },
      handleChangeAllRooms () {
        this.limitRoom.shouldCheckAllRooms = true
      },
      handleGoodNoticePaste () {
        let that = this
        setTimeout(function () {
          that.$refs.infoForm.validateField('goodInfoSaleNotice')
        }, 0)
      },
      sDateSChange (value) {
        this.form.sDateS1 = value
      },
      sDateEChange (value) {
        this.form.sDateE1 = value
      },
      eDateSChange (value) {
        this.form.eDateS1 = value
      },
      eDateEChange (value) {
        this.form.eDateE1 = value
      }
    },
    computed: {
      showRelatedCalArea () {
        return this.codeType !== 'member' && this.form.relatedCode !== '0'
      },
      ...mapGetters('form', [
        'limitWeeksHasAllChecked',
        'limitRoomCheckedCount'
      ]),
      ...mapGetters('config', [
        'hasConfMemberLevel',
        'hasConfPayWays'
      ]),
      ...mapState(['form']),
      ...mapState('form', {
        codeType: 'type',
        limitRoomType: 'allRooms',
        goodInfoSaleNotice: 'goodInfoSaleNotice',
        payWays: 'payWays'
      }),
      ...mapState('config', [
        'confCodeType',
        'confCodeCalWay',
        'confBfFields',
        'confPriceCodes',
        'confCodeStatus',
        'confMemberLevels',
        'confPayWays',
        'confWeeks',
        'confPackagePaymentSupport'
      ]),
      ...mapState('rooms', {
        hotelRoomItems: 'hotelRoomItems',
        hotelRoomIds: 'hotelRoomIds',
        roomLoading: 'loading'
      }),
      hotels () {
        let hotelDatas = []
        this.limitRoom.currentPageHotelIds = []
        let data = this.hotelRoomIds[this.limitRoom.keyword || '__default__']
        if (data && data.hotelIds.length) {
          this.limitRoom.count = data.count
          let start = (this.limitRoom.page - 1) * this.limitRoom.size
          let end = this.limitRoom.page * this.limitRoom.size
          while (start < end) {
            let hotelId = data.hotelIds[start]
            if (hotelId) {
              let hotelInfo = this.hotelRoomItems[hotelId]
              this.limitRoom.currentPageHotelIds.push(hotelInfo.nid)
              hotelDatas.push(hotelInfo)
            }
            start++
          }
        }
        return hotelDatas
      },
      hotelsChecked () {
        if (!this.limitRoom.refreshCheckedRoomTable) {
          return
        }
        let hotelsCheckedDatas = []
        let hotelsCheckedList = this.form.limitRoomChecked
        for (let hotelId in hotelsCheckedList) {
          hotelsCheckedDatas.push(hotelsCheckedList[hotelId])
        }
        return hotelsCheckedDatas
      },
      packagePaymentSupportText () {
        let text = []
        for (let payway in this.confPackagePaymentSupport) {
          text.push(this.confPackagePaymentSupport[payway])
        }
        return text.join('、')
      }
    },
    watch: {
      'codeType': function (type) {
        // 协议价必须填协议价 会员价必须选会员等级
        let isProtrol = type === 'protrol'
        let isMember = type === 'member'
        this.showUnlockCodeArea = isProtrol
        this.rules.unlockCode[0].required = isProtrol
        this.rules.memberLevel[0].required = isMember
      },
      'limitRoomType': function (val) {
        if (this.form.priceCode && !this.limitRoom.getCheckedRooms && val === '0') {
          this.limitRoom.getCheckedRooms = true
          this[GET_HOTEL_ROOM_BY_CODE_ACTION]({
            pcode: this.form.priceCode
          })
        }
      },
      'goodInfoSaleNotice': function (val) {
        let _val = val.replace(/\s*\r\n|\s*\n/mg, '')
        this.noticeNumber = _val.length
      },
      'payWays': function (val) {
        let that = this
        let supportPackage = val.some(function (payway) {
          return that.confPackagePaymentSupport[payway]
        })
        if (!supportPackage) {
          that.form.isPackages = '0'
        }
        that.isPackageDisable = !supportPackage
      }
    }
  }
</script>
<style lang="postcss" scoped>
  .goodInfo_sale_way {
    width: 90px
  }
  .checkbox-indeterminate + .el-checkbox-group.jfk-d-ib {
    margin-left: 0px
  }
  .checkall-input-box {
    margin-top: 5px;
    margin-bottom: 15px;
  }
  .el-tag{
    margin: 5px 0
  }
  .el-tag + .el-tag{
    margin-left: 10px
  }
  .el-checkbox + .el-checkbox{
    margin-left: 0;
  }
  .el-checkbox {
    margin-right: 15px;
  }
  .saleNotice-item{
    position: relative;
  }
  .notice-tip{
    position: absolute;
    bottom: -16px;
    right: 5px;
    font-size: 12px;
    line-height: 1;
  }
</style>
<style lang="postcss">
  .jfk-dialog__hotelRooms .el-dialog__body{
    padding-bottom: 10px;
  }
</style>

