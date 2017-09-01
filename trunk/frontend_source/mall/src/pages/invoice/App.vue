<template>
  <div class="jfk-pages jfk-pages__invoice">
    <div class="jfk-pages__theme"></div>

    <!--<div class="invoice-add-address jfk-pl-30 jfk-pr-30">-->
      <!--<div class="invoice-add-address__content jfk-flex is-align-middle font-size&#45;&#45;28">-->
        <!--<i class="jfk-d-ib"></i><span>新增收货地址</span>-->
      <!--</div>-->
    <!--</div>-->


    <div class="invoice-address jfk-pl-30 jfk-pr-30">
      <div class="invoice-address__content">
        <ul>
          <li class="jfk-flex font-size--24 is-align-middle">
            <div class="invoice-address__title invoice-address__word">收件人</div>
            <div class="invoice-address__item-content font-size--28">
              <i>张晓敏</i><small class="font-size--28">18767783456</small>
            </div>
          </li>

          <li class="jfk-flex font-size--24 is-align-middle">
            <div class="invoice-address__title">收件地址</div>
            <div class="invoice-address__item-content font-size--28">上海市静安区富民路83号4层</div>
          </li>
        </ul>
        <span class="jfk-font icon-user_icon_jump_normal font-size--24"></span>
        <div class="invoice-address__line"></div>
      </div>
    </div>


    <div class="invoice-info jfk-pl-30 jfk-pr-30">
      <p class="invoice-title font-size--24">发票信息</p>
      <form class="jfk-form font-size--28">
        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray">发票抬头</span>
            <div class="form-item__body">
              <input type="text" class="font-color-white" placeholder="必填">
              <div class="form-item__status is-error" v-show="false">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                    <i class="form-item__status-cont" v-text="'发票抬头'"></i>
                    <i class="form-item__status-trigger">重新输入</i>
                </span>
              </div>
            </div>
          </label>

        </div>
        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray">纳税人识别号</span>
            <div class="form-item__body">
              <input type="text" class="font-color-white" placeholder="选填">
            </div>
          </label>
        </div>
      </form>
    </div>


    <div class="invoice-order-info jfk-pl-30 jfk-pr-30">
      <p class="invoice-title font-size--24">发票信息</p>
      <ul>
        <li class="jfk-flex is-align-middle">
          <span class="invoice-order-info__title font-size--28">商品名称</span>
          <i class="invoice-order-info__content font-size--30">1208328478</i>
        </li>

        <li class="jfk-flex is-align-middle">
          <span class="invoice-order-info__title font-size--28 invoice-order-info__word">订单号</span>
          <i class="invoice-order-info__content font-size--30">100012323</i>
        </li>

        <li class="jfk-flex is-align-middle">
          <span class="invoice-order-info__title font-size--28">实付金额</span>
          <i class="invoice-order-info__content font-size--30">
            ￥300
          </i>
        </li>
      </ul>
    </div>


    <div class="invoice-btn">
      <button class="jfk-button jfk-button--primary is-plain font-size--30 jfk-button--free is-disabled">提交邮寄</button>
    </div>


  </div>
</template>
<script>
  export default {
    components: {},
    beforeCreate () {
    },
    created () {
    },
    data () {
      return {
        message: ''
      }
    },
    watch: {}
  }
</script>

<style>
</style>
