<template>
  <div id="mall-post-dialog">
    <el-dialog
      title="发货"
      :visible.sync="express_dialog_visible"
      :before-close="close"
      :top="'50%'"
      :size="'tiny'">
      <el-form :model="form" :rules="rules" ref="form">

        <el-form-item label="快递单号" :label-width="formLabelWidth" prop="orderNumber">
          <el-row>
            <el-col :span="24">
              <el-input v-model="form.orderNumber" auto-complete="off" :placeholder="'请输入快递单号'"></el-input>
            </el-col>
          </el-row>
        </el-form-item>

        <el-form-item label="快递服务商" :label-width="formLabelWidth" prop="orderProvider">
          <el-row>
            <el-col :span="24">
              <el-select v-model="form.orderProvider"
                         :disabled="disabled"
                         ref="select"
                         filterable
                         remote
                         :placeholder="'请输入快递服务商'">
                <el-option v-for="(item, index) in express_providers" :key="index" :label="item.dist_label"
                           :value="item.dist_name">
                </el-option>

              </el-select>

            </el-col>
          </el-row>
        </el-form-item>

      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="send" :loading="loading">确定发货</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
  import { mapMutations, mapGetters, mapActions } from 'vuex'
  import { postExpressDelivery } from '@/service/mall/http'
  export default {
    computed: {
      ...mapGetters(['express_dialog_visible',
        'express_providers',
        'express_shipping_id',
        'express_current_tabs',
        'express_tabs'])
    },
    watch: {
      express_dialog_visible (val) {
        if (val === true) {
          if (this.express_providers.length === 0) {
            this.disabled = true
            this.GET_EXPRESS_PROVIDERS().then(() => {
              this.disabled = false
            }).catch(() => {
              this.disabled = false
            })
          }
        }
      }
    },
    methods: {
      ...mapMutations([
        'UPDATE_EXPRESS_DIALOG',
        'UPDATE_TABLE_LOADING'
      ]),
      ...mapActions([
        'GET_EXPRESS_ORDER_LIST',
        'GET_EXPRESS_PROVIDERS'
      ]),
      close () {
        this.$refs['form'].resetFields()
        this.form['orderNumber'] = ''
        this.form['orderProvider'] = ''
        this.UPDATE_EXPRESS_DIALOG(false)
      },
      send () {
        this.$refs['form'].validate((valid) => {
          if (valid) {
            this.loading = true
            const csrf = this.express_tabs[this.express_current_tabs]['csrf']
            const data = {
              'shipping_id': this['express_shipping_id'],
              'distributor': this.form['orderProvider'],
              'tracking_no': this.form['orderNumber']
            }
            data[csrf['csrf_token']] = csrf['csrf_value']
            postExpressDelivery(data, {}).then((res) => {
              if (res.status === 1000) {
                this.close()
                this.loading = false
                this.UPDATE_TABLE_LOADING(true)
                this.GET_EXPRESS_ORDER_LIST(true)
              }
            }).catch(() => {
              this.loading = false
            })
          } else {
            return false
          }
        })
      }
    },
    data () {
      return {
        providers: [],
        loading: false,
        disabled: false,
        rules: {
          orderNumber: [
            {required: true, message: '请输入快递单号', trigger: 'blur'}
          ],
          orderProvider: [
            {required: true, message: '请输入快递服务商', trigger: 'blur'}
          ]
        },
        form: {
          orderNumber: '',
          orderProvider: ''
        },
        formLabelWidth: '100px'
      }
    }
  }
</script>
<style lang="postcss">

  #mall-post-dialog {
    .el-autocomplete {
      width: 100%;
    }

    .el-select {
      width: 100%;
    }

    .el-dialog {
      transform: translate(-50%, -50%);
    }
  }


</style>
