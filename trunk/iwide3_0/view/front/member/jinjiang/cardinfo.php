<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>卡券详细</title>
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/weui/dist/style/card.css");?>"/>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="<?php echo base_url("public/member/version4.0/weui/dist/example/zepto.min.js");?>"></script>
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/weui/dist/style/weui.css");?>"/>
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/weui/dist/style/weui.min.css");?>"/>
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/weui/dist/example/example.css");?>"/>
    <script src="<?php echo base_url("public/member/version4.0/weui/dist/example/example.js");?>"></script>
    <script src="<?php echo base_url("public/member/version4.0/js/login.js");?>"></script>
    <script>
    wx.config({
        debug:false,
        appId:'<?php echo $signpackage["appId"];?>',
        timestamp:<?php echo $signpackage["timestamp"];?>,
        nonceStr:'<?php echo $signpackage["nonceStr"];?>',
        signature:'<?php echo $signpackage["signature"];?>',
        jsApiList: [
            'hideOptionMenu',
         ]
       });
        wx.ready(function (){
            wx.hideOptionMenu();
        });
    </script>
</head>
<style>

</style>
<body>
<div class="ticket">
	<div class="t_head"></div>
	<h1><?php echo $public['name'];?></h1>
    <?php if($card_info){ ?>
	<div class="t_img"><img src="<?php echo $card_info['logo_url'] ?>"/></div>
	<div class="con_list">
		<div class="c_868">卡券名称</div>
		<div class="c_l_c ellipsis"><?php echo $card_info['title'] ?></div>
	</div>
	<div class="con_list">
		<div class="c_868">卡券内容</div>
		<div class="c_l_c ellipsis"><?php echo $card_info['notice'] ?></div>
	</div>
	<div class="con_list">
		<div class="c_868">有效期</div>
		<div class="c_l_c ellipsis"><?php echo date('Y-m-d',$card_info['createtime']) ?>至<?php echo date('Y-m-d',$card_info['expire_time']) ?></div>
	</div>
    <?php if($card_info['is_online'] ==2){ ?>
        <div class="bd spacing">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cells">
                    <label for='' class="weui_label">使用方法：</label>
                </div>
                <div class="weui_cell_bd">
                    <span style="font-size:14px;">1.请出示二维码,扫码核销即使用完成</span>
                </div>
                <div class="weui_cell account">
                    <img src="
                    <?php echo str_replace('vapi/', '', PMS_PATH_URL).'tool/qr/get?str='.$card_info['consume_code'] ?>
                     "/>
                </div>
                <div class="weui_cell_bd">
                    <span style="font-size:14px;">2.输入消费码,点击使用即可</span>
                </div>
                <div class="weui_cell account">
                    <div class="weui_cell_hd"><label for='' class="weui_label">消费码</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="text" id='passwd' name="passwd" placeholder="输入消费码使用" />
                    </div>
                </div>
            </div>
            <div class="weui_cells_title"></div>
            <div class="bd spacing">
                <a href="javascript:;" id='useone' class="weui_btn weui_btn_primary">使用</a>
            </div>
        </div>
    <?php }elseif($card_info['is_online'] ==1){ ?>
        <div class="bd spacing">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell account">
                    <div class="weui_cell_bd weui_cell_primary">
                        <a href="javascript:;" class="weui_btn weui_btn_primary" id="showActionSheet">直接使用</a>
                    </div>
                </div>
            </div>
        </div>
    <?php }else{ ?>
        <div class="bd spacing">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cells">
                    <label for='' class="weui_label">使用方法：</label>
                </div>
                <div class="weui_cell_bd">
                    <span style="font-size:14px;">1.请出示二维码,扫码核销即使用完成</span>
                </div>
                <div class="weui_cell account">
                    <img src="
                    <?php echo str_replace('vapi/', '', PMS_PATH_URL).'tool/qr/get?str='.$card_info['consume_code'] ?>
                     "/>
                </div>
                <div class="weui_cell_bd">
                    <span style="font-size:14px;">2.输入消费码,点击使用即可</span>
                </div>
                <div class="weui_cell account">
                    <div class="weui_cell_hd"><label for='' class="weui_label">消费码</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="text" id='passwd' name="passwd" placeholder="输入消费码使用" />
                    </div>

                </div>
                <div class="weui_cell account">
                    <div class="weui_cell_bd weui_cell_primary">
                        <a href="javascript:;" id='useone' class="weui_btn weui_btn_primary">使用</a>
                    </div>
                </div>
                <div class="weui_cell_bd">
                    <span style="font-size:14px;">3.直接使用</span>
                </div>
                <div class="weui_cell account">
                    <div class="weui_cell_bd weui_cell_primary">
                        <a href="javascript:;" class="weui_btn weui_btn_primary" id="showActionSheet">去使用</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php }else{ ?>
    <div class="btn_lst">
        <div class="c_l_c ellipsis">卡券信息不存在或已经赠送</div>
        <a class="m_r_4" href="javascript:history.go(-1);location.reload();"><span>返回</span></a>
    </div>
    <?php } ?>
</div>
<div class="fixed"></div>
<!--BEGIN actionSheet-->
<div id="actionSheet_wrap" style="display:none;" >
    <div class="weui_mask_transition weui_fade_toggle" id="mask" style="display: block;"></div>
    <div class="weui_actionsheet weui_actionsheet_toggle" id="weui_actionsheet">
        <div class="weui_actionsheet_menu">
            <?php if($card_info['header_url']){ ?>
                    <div class="weui_actionsheet_cell"><a href="<?php echo $card_info['header_url']; ?>">立即使用</a></div>
            <?php } ?>
            <?php if($card_info['hotel_header_url']){ ?>
                     <div class="weui_actionsheet_cell"><a href="<?php echo $card_info['hotel_header_url']; ?>">去订房</a></div>
            <?php } ?>
            <?php if($card_info['shop_header_url']){ ?>
                     <div class="weui_actionsheet_cell"><a href="<?php echo $card_info['shop_header_url']; ?>">去商城</a></div>
            <?php } ?>
            <?php if($card_info['soma_header_url']){ ?>
                     <div class="weui_actionsheet_cell"><a href="<?php echo $card_info['soma_header_url']; ?>">去团购</a></div>
            <?php } ?>
        </div>
        <div class="weui_actionsheet_action">
            <div class="weui_actionsheet_cell" id="actionsheet_cancel">取消</div>
        </div>
    </div>
</div>
<!--END actionSheet-->
<!--dialog start -->
    <div class="weui_dialog_alert" id="dialog2" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">操作提示</strong></div>
            <div class="weui_dialog_bd">当前账号或密码错误</div>
            <div class="weui_dialog_ft">
                <a href="javascript:;" class="weui_btn_dialog primary priurl">确定</a>
            </div>
        </div>
    </div>
    <!--dialog end -->
<script>
$(function(){
    $('.fen_s').click(function(){
            $('.fixed').show();
        })
    $('.fixed').click(function(){
        $('.fixed').hide();
    })
    //点击领取
    <?php if($card_info){ ?>
        $('#useone').click(function(){
            var post_url = "<?php echo base_url('index.php/membervip/card/passwduseoff'); ?>";
            var member_card_id = <?php echo $card_info['member_card_id']; ?>;
            var passwd = $('#passwd').val();
            $.post(post_url, {
                'member_card_id': member_card_id,
                'passwd':passwd,
            },
                function(data){
                   if(data.err==0){
                        $('.priurl').attr('href',"<?php echo base_url('index.php/membervip/card'); ?>");
                        $('.weui_dialog_bd').html( '使用成功' );
                        $('#dialog2').attr('style','');
                   }else{
                        $('.weui_dialog_bd').html( data['msg'] );
                        $('#dialog2').attr('style','');
                   }
                }, "json");
        });
    <?php } ?>

    $('#showActionSheet').click(function(){
        $('#actionSheet_wrap').attr('style','');
    });
    $('#actionsheet_cancel').click(function(){
        $('#actionSheet_wrap').attr('style','display:none;');
    });

});
</script>
</body>
</html>
