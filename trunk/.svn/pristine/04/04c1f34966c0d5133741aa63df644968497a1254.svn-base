<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>充值</title>
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/weui/dist/style/weui.css");?>"/>
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/weui/dist/style/weui.min.css");?>"/>
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/weui/dist/example/example.css");?>"/>
    <script src="<?php echo base_url("public/member/version4.0/weui/dist/example/zepto.min.js");?>"></script>
    <script src="<?php echo base_url("public/member/version4.0/weui/dist/example/example.js");?>"></script>
    <script src="<?php echo base_url("public/member/version4.0/js/login.js");?>"></script>
    <style>
		.weui_grid:before,.weui_grid:after,.weui_grids:after{border:0}
		.weui_grid{border:1px solid #fe9402; border-radius:10px; color:#fe9402; margin:15px; text-align:center; padding:10px 5px; width:27%;}
		.weui_grid.cur{background:#fe9402;color:#fff;}
		.weui_btn_primary{position: fixed;width: 100%;left: 0;bottom: 0; border-radius: 0;}
	</style>
</head>
<body ontouchstart>
    <div class="vip_content" style="display:none;">
        <!--FROM DATA START-->
            <div class="bd spacing">
                <!--div class="hd">
                    <h1 class="page_title">充值优惠</h1>
                </div-->
                <div class="bd">
                    <div class="weui_grids">
                        <?php foreach ($deposit_list as $key => $value) { ?>
                        <div class="weui_grid js_grid depositData" depositState='f' data-id="button" depositId= "<?php echo $value['deposit_card_id'] ?>" depositMoney = "<?php echo $value['money'] ?>" >
                            <p><?php echo $value['money']; ?></p>
                            <p><?php echo $value['title'] ?></p>
                        </div>
                        <?php } ?>
                        <div class="weui_grid js_grid diy_money" data-id="button">
                            <p style="padding:13px 0">自定义</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weui_cells weui_cells_form diy_input" style="display:none">
                <div class="weui_cell account">
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" id="UserMoney" type="text" name="money"  placeholder="请输入充值金额" />
                    </div>
                    <div class="weui_cell_ft">
                        <i class="weui_icon_warn"></i>
                    </div>
                </div>
            </div>
            <div class="weui_cells_title"></div>
            <div class="bd spacing">
                <a href="javascript:;" class="weui_btn weui_btn_primary">充值</a>
            </div>
        </div>
        <!-- <div class="weui_actionsheet_cell">
            <br/><span >还没有账号？<a href="#">立即注册</a></span>
            <br/><span >忘记密码？请点击<a href="#">找回密码</a></span>
        </div> -->
        <!--FROM DATA END-->
    </div>
    <!--BEGIN START-->
    <div id="toast" style="display:none;">
        <div class="weui_mask_transparent"></div>
        <div class="weui_toast">
            <i class="weui_icon_toast"></i>
            <p class="weui_toast_content">已完成</p>
        </div>
    </div>
    <!--end END-->
    <!--Loading START-->
    <div id="loadingToast" class="weui_loading_toast" style="">
        <div class="weui_mask_transparent"></div>
        <div class="weui_toast">
            <div class="weui_loading">
                <div class="weui_loading_leaf weui_loading_leaf_0"></div>
                <div class="weui_loading_leaf weui_loading_leaf_1"></div>
                <div class="weui_loading_leaf weui_loading_leaf_2"></div>
                <div class="weui_loading_leaf weui_loading_leaf_3"></div>
                <div class="weui_loading_leaf weui_loading_leaf_4"></div>
                <div class="weui_loading_leaf weui_loading_leaf_5"></div>
                <div class="weui_loading_leaf weui_loading_leaf_6"></div>
                <div class="weui_loading_leaf weui_loading_leaf_7"></div>
                <div class="weui_loading_leaf weui_loading_leaf_8"></div>
                <div class="weui_loading_leaf weui_loading_leaf_9"></div>
                <div class="weui_loading_leaf weui_loading_leaf_10"></div>
                <div class="weui_loading_leaf weui_loading_leaf_11"></div>
            </div>
            <p class="weui_toast_content">努力加载中</p>
        </div>
    </div>
    <!--Loading END-->
    <!--dialog start -->
    <div class="weui_dialog_alert" id="dialog2" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">操作提示</strong></div>
            <div class="weui_dialog_bd">当前账号或密码错误</div>
            <div class="weui_dialog_ft">
                <a href="javascript:;" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
    <!--dialog end -->
    <script type="text/javascript">
        //通用JS
		var tmpval='';
        $(function(){
            /* 等待加载 START */
            $('.vip_content').attr('style',"");
            $("#loadingToast").attr('style',"display:none;");
            /* 等待加载 END */
            var depositId;
            var depositMoney;
            $('.depositData').click(function(){
                depositId = $(this).attr('depositId');
                depositMoney = $(this).attr('depositMoney');
                var DepositState = $(this).attr('depositState');
                $(this).addClass('cur').siblings().removeClass('cur');
                $(this).attr('depositState','t');
				$('.diy_input').hide();
				$('#UserMoney').val('');
            });
			$('.diy_money').click(function(){
				depositId = 0;
				depositMoney = 0;
                $(this).addClass('cur').siblings().removeClass('cur');
				$('.diy_input').show();
				$('#UserMoney').val(tmpval);
				$('.depositData').each(function(index, element) {
                    $(this).attr('depositState','f');
                });
			})
			$('#UserMoney').blur(function(){
				tmpval=$('#UserMoney').val();
			})
            $('.weui_btn_primary').click(function(){
                var PostUrl = "<?php echo base_url('index.php/membervip/depositcard/save_deposit_order');?>";
                var Money = $('#UserMoney').val();
                $.post(PostUrl, {
                    "depositId": depositId,
                    'depositMoney':depositMoney,
                    'money':Money,
                },
               function(result){
                    if(typeof(result['err'])=='undefined'){
                        //支付
                        window.location.href="<?php echo base_url('index.php/wxpay/vip_pay?orderId=');?>"+result['data'];
                    }else{
                        $('.weui_dialog_bd').html(result['msg']);
                        $('#dialog2').attr('style','');
                    }
               }, "json");
            });
        });
    </script>
</body>
</html>
