<template>
    <div class="orderCoupon__detail">
        <h3 class="coupon__detail__title font-size--24">包含券码</h3>
        <div class="coupon__inn">
            <div class="coupon__detail__list">
                <div class="item jfk-flex">
                    <div class="item__left">
                        <span class="title font-size--28">券码</span>
                        <span class="number fot-size--32">283 743 3454</span>
                    </div>
                    <div class="item__right">
                        <i class="jfk-font icon-mall_icon_pay_focus qrcode"></i>
                        <i class="jfk-font icon-user_icon_jump_normal arrow"></i>
                    </div>
                </div>
                <div class="item jfk-flex item__invalid">
                    <div class="item__left">
                        <span class="title font-size--28">券码</span>
                        <span class="number fot-size--32">283 743 3454</span>
                    </div>
                    <div class="item__right">
                        <span class="coupon__state font-size--24">已使用</span>
                        <i class="jfk-font icon-user_icon_jump_normal arrow"></i>
                    </div>                
                </div>
                <div class="item jfk-flex item__post">
                    <div class="item__left">
                        <span class="title font-size--28">券码</span>
                        <span class="number fot-size--32 ">283 743 3454</span>
                    </div>
                    <div class="item__right">
                        <span class="coupon__state font-size--24">已邮寄</span>
                        <i class="jfk-font icon-user_icon_jump_normal arrow"></i>
                    </div>                
                </div> 
                <div class="item jfk-flex item__send">
                    <div class="item__left">
                        <span class="title font-size--28">券码</span>
                        <span class="number fot-size--32 number-invalid">283 743 3454</span>
                    </div>
                    <div class="item__right">
                        <span class="coupon__state font-size--24">已赠送</span>
                        <i class="jfk-font icon-user_icon_jump_normal arrow"></i>
                    </div>                
                </div>  
            </div>
            <div class="coupon__showhide jfk-ta-c font-size--24 hideCoupon">
                查看其他10张券<i class="jfk-font icon-home_icon_Jump_norma"></i>
            </div>
        </div>
    </div>
</template>
<script>
export default{
  name: 'couponDetail',
  props: ['couponDetail']
}
</script>

