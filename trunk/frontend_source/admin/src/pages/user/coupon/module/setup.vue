<template>
	<div id="coupon-setup">
		<div class="jfk-fieldset__hd">
	      <div class="jfk-fieldset__title">新建优惠券发放任务</div>
	    </div>
	    <div>
	    	<el-row>
			  <el-col :span="11">
			  	<el-col :span="4" class="choice-step-num">
			  	 	01
			  	</el-col>
			  	<el-col :span="20">
			  		<p class="choice-step-title">选择优惠券发放内容和目标用户</p>
			  		<p class="choice-step-word">选择发送的优惠券或礼包，并选择需要发送的用户群体</p>
			  	</el-col>
			  </el-col>
			  <el-col :span="2" class="jfk-ta-c">
			  	<div class="choice-line"></div>
			  </el-col>	
			  <el-col :span="11">
			  <el-col :span="4" class="choice-step-num choice-step-active">
			  	 	02
			  	</el-col>
			  	<el-col :span="20">
			  		<p class="choice-step-title">设置模版消息</p>
			  		<p class="choice-step-word">设置一个模版消息，给收到优惠的用户发送一个模版消息</p>
			  	</el-col></el-col>
			</el-row>
	    </div>
	    <el-form :model="ruleForm" ref="ruleForm" :rules="rules">
	    	<div class="jfk-fieldset__hd">
		      <div class="jfk-fieldset__title">选择发送内容</div>
		    </div>
		    <div>
		    	<el-form-item label="是否发送模版消息?" prop="is_send_temp">
				    <el-radio-group v-model="ruleForm.is_send_temp">
				      <el-radio @click.native.prevent="calTemp()"  label="1" value="1">是</el-radio>
				      <el-radio label="2" value="2">否</el-radio>
				    </el-radio-group>
				</el-form-item>
        <div v-show="ruleForm.is_send_temp === '1' ">
  				<el-form-item :label="input_tag.temp_title.name" >
  				    <p>{{input_tag.temp_title.value}}</p>
  				</el-form-item>
  				<el-form-item :label="input_tag.temp_id.name" prop="temp_id">
  				    <el-input v-model="ruleForm.temp_id" placeholder="" style="width: 250px;"></el-input>
  				</el-form-item>
  				<div class="el-form--inline">	
  						<el-form-item label="" prop="jump_type">
  							<el-form-item label="" style="margin-left: 70px;">
  							    <el-radio v-model="ruleForm.jump_type" label="1">跳转链接</el-radio>
  							</el-form-item>
  							<el-form-item label=""  prop="jump_url">
  							    <el-select v-model="ruleForm.jump_url" style="width: 120px;">
  							    <el-option
  							      v-for="(value,key) in enum_des.jump_url"
  							      :label="value"
  							      :key="key"
  							      :value="key">
  							  	  </el-option>
  							    </el-select>
  							</el-form-item>
  							<el-form-item label="" style="margin-left:20px;">
  							      <el-radio v-model="ruleForm.jump_type" label="2">自定义链接</el-radio>
  							</el-form-item>
  							<el-form-item label="" prop="auto_jump_url">
  							    <el-input v-model="ruleForm.auto_jump_url" placeholder="" style="width: 250px;"></el-input>
  							</el-form-item>
  							<el-form-item label="" style="margin-left:20px;">
  							      <el-radio v-model="ruleForm.jump_type" label="3">无链接</el-radio>
  							</el-form-item>
  						</el-form-item>
  				</div>
        </div>
			</div>
      <div v-show="ruleForm.is_send_temp === '1' ">
  			<div class="jfk-fieldset__hd">
  		      <div class="jfk-fieldset__title">消息内容</div>
  		    </div>
  		    <el-form-item label="first" class="steup-auto-width">
  			    <el-input v-model="ruleForm.first" placeholder=""></el-input>
  			</el-form-item>
  			<el-form-item label="keyword1" class="steup-auto-width">
  			    <el-input v-model="ruleForm.keyword1" placeholder=""></el-input>
  			</el-form-item>
  			<el-form-item label="keyword2" class="steup-auto-width">
  			    <el-input v-model="ruleForm.keyword2" placeholder=""></el-input>
  			</el-form-item>
  			<el-form-item label="keyword3" class="steup-auto-width">
  			    <el-input v-model="ruleForm.keyword3" placeholder=""></el-input>
  			</el-form-item>
  			<el-form-item label="keyword4" class="steup-auto-width">
  			    <el-input v-model="ruleForm.keyword4" placeholder=""></el-input>
  			</el-form-item>
  			<el-form-item label="remark" class="steup-auto-width">
  			    <el-input v-model="ruleForm.remark" placeholder=""></el-input>
  			</el-form-item>
      </div>
			<el-row class="gray-bg">
				<el-col :span="8" style="padding-right:35px;">
					<p class="steup-msg-title">模版消息提示</p>
					<p v-for="(value,key) in page_hint.temp_hint" :key="key" class="steup-msg-word">{{value}}</p>
				</el-col>
 				<el-col :span="8">
					<p class="steup-msg-title">模版详细内容</p>
					<p v-for="(value,key) in page_hint.temp_contet_hint" :key="key" class="steup-msg-word">{{value}}</p>
 				</el-col>
 			    <el-col :span="6">
					<p class="steup-msg-title">模版可用字段</p>
					<p v-for="(value,key) in page_hint.temp_field_hint" :key="key" class="steup-msg-word">{{value}}</p>
 				</el-col>
			</el-row>
			<el-row type="flex" justify="center" style="margin-top:25px;">
				<el-button type="primary" :loading="posting" @click.native.prevent="submitData('ruleForm')" size="large" class="jfk-button--middle">{{postText}}</el-button>
		        <el-button size="large" @click.native.prevent="cancelData()" class="jfk-button--middle">取消发送</el-button>
		    </el-row>
	    </el-form>
    </div>
</template>
<script type="text/javascript">
import { mapState, mapMutations } from 'vuex'
import { getRequestInfo } from '@/service/user/http'
import { formatUrlParams } from '@/utils/utils'
import { UPDATE_COUPON_STEP } from '@/service/user/types'
const urlReg = /(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-.,@?^=%&:/~#]*[\w\-?^=%&/~#])?/
export default {
  name: 'coupon-setup',
  data () {
    const checkTemp = (rule, value, callback) => {
      if (this.ruleForm.is_send_temp === '1') {
        if (value === '') {
          this.errorScroll()
          return callback(new Error('请输入时间'))
        }
      }
      return callback()
    }
    const checkJumpType = (rule, value, callback) => {
      if (this.ruleForm.is_send_temp === '1') {
        if (value.length === 0) {
          this.errorScroll()
          return callback(new Error(rule.message))
        }
      }
      return callback()
    }
    const checkJumpUrl = (rule, value, callback) => {
      if (this.ruleForm.jump_type === '1' && this.ruleForm.is_send_temp === '1') {
        if (value.length === 0) {
          this.errorScroll()
          return callback(new Error(rule.message))
        }
      }
      return callback()
    }
    const checkJumpAuto = (rule, value, callback) => {
      if (this.ruleForm.jump_type === '2' && this.ruleForm.is_send_temp === '1') {
        if (value === '') {
          this.errorScroll()
          return callback(new Error('请填写自定义链接'))
        }
        if (!urlReg.test(value)) {
          this.errorScroll()
          return callback(new Error('请填写正确链接'))
        }
      }
      return callback()
    }
    const checkSendTemp = (rule, value, callback) => {
      if (value === '') {
        this.errorScroll()
        return callback(new Error(rule.message))
      }
      return callback()
    }
    return {
      ruleForm: {
        is_send_temp: '2',
        temp_id: '',
        jump_url: '',
        jump_type: '1',
        auto_jump_url: '',
        first: '',
        keyword1: '',
        keyword2: '',
        keyword3: '',
        keyword4: '',
        remark: ''
      },
      posting: false,
      rules: {
        is_send_temp: [
          { validator: checkSendTemp, message: '请选择是否发送模版消息', trigger: 'change' }
        ],
        temp_id: [
          { validator: checkTemp, message: '请填写模版ID', trigger: 'blur' }
        ],
        jump_type: [
          { validator: checkJumpType, message: '请选择方式', trigger: 'change' }
        ],
        jump_url: [
          { validator: checkJumpUrl, message: '请选择跳转链接', trigger: 'change' }
        ],
        auto_jump_url: [
          { validator: checkJumpAuto, trigger: 'change' }
        ]
      }
    }
  },
  methods: {
    ...mapMutations([
      UPDATE_COUPON_STEP
    ]),
    submitData (formName) {
      let that = this
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.$confirm('请确认是否发送, 确认操作后不可以撤销。请确认发送内容无误', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(() => {
            if (this.posting) { // 防止浏览器对pointer-events不支持
              return
            }
            let data = this.sedData()
            this.posting = true
            getRequestInfo(data, {REJECTERRORCONFIG: {serveError: true}}).then(function (res) {
              window.location.href = that.page_resource.links.list
            }).catch(function (err) {
              that.$alert(err.msg, '保存失败', {
                confirmButtonText: '确定',
                callback: action => {
                  window.location.href = that.page_resource.links.edit + '?id=' + data.id
                }
              })
            })
          }).catch(() => {
            that.$message({
              type: 'info',
              message: '已取消发送'
            })
          })
        } else {
          console.log(this.ruleForm.is_send_temp)
        }
      })
    },
    calTemp () {
      let that = this
      const h = this.$createElement
      this.$msgbox({
        title: '风险提示',
        message: h('p', null, [
          h('p', { style: 'font-size: 16px' }, '根据微信公众平台规定：'),
          h('p', { style: 'margin-top: 15px' }, '模板消息的定位是用户触发后的通知消息，不允许在用户没做任何操作或未经用户同意接收的前提下，主动下发消息给用户。允许发的模板消息必须是用户接受过帐号主体提供过服务的，严禁用户未接受服务而向其推送模板消息。发送模板消息的前提是内容不•涉及广告营销骚扰用户，一经发现内容涉及营销骚扰将严厉处罚。违规行为包括：'),
          h('p', { style: 'margin-top: 5px' }, '1、模板消息内容不能做营销、推广、诱导分享及诱导下载APP'),
          h('p', { style: 'margin-top: 5px' }, '2、模板内容与模板标题或关键词无关联'),
          h('p', { style: 'margin: 5px 0 10px 0' }, '3、模板内容是营销性质的群发活动公告通知'),
          h('span', null, '请详情查阅'),
          h('a', { domProps: { href: 'https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433751288', target: '_blank' }, style: { color: 'blue', cursor: 'pointer', 'text-decoration': 'none' } }, '模版消息运营规范'),
          h('div', { style: 'margin-bottom: 15px' }, null),
          h('input', { domProps: { type: 'checkbox', id: 'agreeCheckbox' }, style: 'float:left' }, null),
          h('span', null, '我已了解，确认继续发送模板消息')
        ]),
        showCancelButton: true,
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
        beforeClose: (action, instance, done) => {
          if (action === 'confirm') {
            if (document.getElementById('agreeCheckbox').checked) {
              that.ruleForm.is_send_temp = '1'
              done()
            } else {
              that.$message({
                message: '请先了解模版公众平台规定',
                type: 'warning'
              })
            }
          } else {
            done()
            this.ruleForm.is_send_temp = '2'
          }
        }
      })
    },
    sedData () {
      let params = formatUrlParams(location.search)
      let id = ''
      if (params.id) {
        id = params.id
      }
      const result = {
        [this.csrf_token]: this.csrf_value,
        task_name: this.sumbit_data.task_name,
        send_type: this.sumbit_data.send_type,
        send_value: this.sumbit_data.send_value,
        send_time_mode: this.sumbit_data.send_time_mode,
        send_time: this.sumbit_data.send_time,
        send_count: this.sumbit_data.send_count,
        send_target: this.sumbit_data.send_target,
        receive_repeat: this.sumbit_data.receive_repeat,
        send_member_lvl: this.sumbit_data.send_member_lvl,
        send_target_field: this.sumbit_data.send_target_field,
        send_target_type: this.sumbit_data.send_target_type,
        send_target_file: this.sumbit_data.send_target_file,
        send_target_value: this.sumbit_data.send_target_value,
        source: this.sumbit_data.source,
        rfm: this.sumbit_data.rfm,
        r_level: this.sumbit_data.r_level,
        f_level: this.sumbit_data.f_level,
        m_level: this.sumbit_data.m_level,
        is_send_temp: this.ruleForm.is_send_temp,
        temp_id: this.ruleForm.temp_id,
        jump_type: this.ruleForm.jump_type,
        jump_url: this.ruleForm.jump_url,
        auto_jump_url: this.ruleForm.auto_jump_url,
        first: this.ruleForm.first,
        keyword1: this.ruleForm.keyword1,
        keyword2: this.ruleForm.keyword2,
        keyword3: this.ruleForm.keyword3,
        keyword4: this.ruleForm.keyword4,
        remark: this.ruleForm.remark,
        id: id
      }
      return result
    },
    errorScroll () {
      window.scroll(0, 250)
    },
    cancelData () {
      let that = this
      that.$confirm('是否取消发送，确认后不可撤销，请慎重选择', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        window.location.href = that.page_resource.links.list
      }).catch(() => {
      })
    }
  },
  created () {
    let params = formatUrlParams(location.search)
    if (params.id) {
      this.ruleForm.is_send_temp = this.enum_des_selected.is_send_temp
    }
    this.ruleForm.jump_type = this.enum_des_selected.jump_type
    this.ruleForm.auto_jump_url = this.input_tag.auto_jump_url.value
    this.ruleForm.jump_url = this.enum_des_selected.jump_url
    this.ruleForm.temp_id = this.input_tag.temp_id.value
    this.ruleForm.first = this.temp_input_group[0].value
    this.ruleForm.keyword1 = this.temp_input_group[1].value
    this.ruleForm.keyword2 = this.temp_input_group[2].value
    this.ruleForm.keyword3 = this.temp_input_group[3].value
    this.ruleForm.keyword4 = this.temp_input_group[4].value
    this.ruleForm.remark = this.temp_input_group[5].value
  },
  computed: {
    ...mapState([
      'csrf_token',
      'csrf_value',
      'enum_des',
      'enum_des_selected',
      'input_tag',
      'page_field',
      'page_hint',
      'page_resource',
      'temp_input_group',
      'sumbit_data'
    ]),
    postText () {
      return `确认发送优惠${this.posting ? '中' : ''}`
    }
  }
}
</script>
<style lang="postcss">
#coupon-setup{
	.el-form-item__label{
	  width: 150px;
	  margin-right: 15px;
	}
	.steup-auto-width .el-form-item__content{
		margin-left: 165px;
	}
	.steup-msg-title{
		margin-bottom: 10px;
	}
	.steup-msg-word{
		font-size: 15px;
		color: #808080;
	}
}
.el-message-box__status{
  top: 40px!important;
}
</style>
