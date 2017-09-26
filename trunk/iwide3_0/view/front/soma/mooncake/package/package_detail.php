<body>
<script src="<?php echo get_cdn_url('public/soma/scripts/imgscroll.js');?>"></script>
<script src="<?php echo get_cdn_url('public/soma/scripts/jquery.touchwipe.min.js');?>"></script>
<link href="<?php echo get_cdn_url('public/soma/v1/v1.css'). config_item('css_debug');?>" rel="stylesheet">
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $wx_config["appId"]?>',
        timestamp: <?php echo $wx_config["timestamp"]?>,
        nonceStr: '<?php echo $wx_config["nonceStr"]?>',
        signature: '<?php echo $wx_config["signature"]?>',
        jsApiList: [<?php echo $js_api_list; ?>,'getLocation','openLocation']
    });
    wx.ready(function(){
        <?php if( $js_menu_hide ): ?>wx.hideMenuItems({ menuList: [<?php echo $js_menu_hide; ?>] });<?php endif; ?>
        <?php if( $js_menu_show ): ?>wx.showMenuItems({ menuList: [<?php echo $js_menu_show; ?>] });<?php endif; ?>

        <?php if( $js_share_config ): ?>
        wx.onMenuShareTimeline({
            title: '<?php echo $js_share_config["title"]?>',
            link: '<?php echo $js_share_config["link"]?>',
            imgUrl: '<?php echo $js_share_config["imgUrl"]?>',
            success: function () {},
            cancel: function () {}
        });
        wx.onMenuShareAppMessage({
            title: '<?php echo $js_share_config["title"]?>',
            desc: '<?php echo $js_share_config["desc"]?>',
            link: '<?php echo $js_share_config["link"]?>',
            imgUrl: '<?php echo $js_share_config["imgUrl"]?>',
            //type: '', //music|video|link(default)
            //dataUrl: '', //use in music|video
            success: function () {},
            cancel: function () {}
        });

        <?php endif; ?>
        <?php if($inter_id != 'a455510007'){ //速8需要隐藏 ?>
        document.querySelector('#openLocation').onclick = function () {
            wx.openLocation({
                latitude:<?php echo $package['latitude'];?>,
                longitude:<?php echo $package['longitude'];?>,
                name: '<?php echo $package['hotel_name'];?>',
                address: '<?php echo $package['hotel_address'];?>',
                scale: 14,
                infoUrl: 'http://weixin.qq.com'
            });
        };
        <?php } ?>
    });
</script>
<div class="pageloading"><p class="isload">正在加载</p></div>

<!-- 显示分销号start -->
    <div class="distribute_btn" style="display:none">
        <span><img src="<?php echo get_cdn_url('public/soma/images/distributeimg.jpg');?>" /></span>
    </div>
    <div class="ui_pull distribute" style="display:none" >
        <div class="pullbox center bg_fff">
            <div class="pullclose bg_999" onClick="toclose()">&times;</div>
            <div class="pullimg"><div class="squareimg"><img src="<?php echo get_cdn_url('public/soma/images/distributeimg.jpg');?>" /></div></div>
            <div>分销号:<span id="distribute_id"></span></div>
            <div>姓　名:<span id="distribute_name"></span></div>
            <div class="bg_999 pullbtn h26" onClick="toclose()">取消</div>
            <a class="bg_main pullbtn h26" id="distribute_url" href="">进入分销</a>
        </div>
    </div>
    <script>
        $('.distribute_btn').click(function(){toshow($('.distribute'));});

        //异步查询分销员号
        function get_saler(){
            var saler = "<?php echo $this->input->get('saler');?>";
            var url = "<?php echo Soma_const_url::inst()->get_url('*/package/get_saler_id_by_ajax',array( 'id'=> $this->inter_id) );?>";
            $.ajax({
                url: url,
                type: 'post',
                data: {saler:saler},
                dataType: 'json',
                success:function( json ){
                    if( json.status == 1 ){
                        if(json.jump_url== 1){
                        	window.location="<?php 
                            	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' 
                            	    || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                            	echo "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        	?>&saler="+ json.sid;
                        }
                        if(json.show_button== 1){
                        	//alert( json.sid + json.name );
                            $("#distribute_id").html(json.sid);
                            $("#distribute_name").html(json.name);
                            $("#distribute_url").attr('href',json.url);
                            $(".distribute_btn").show();
                        }
                    }
                }
            });
        }
        get_saler();
    </script>
<!-- 显示分销号end -->
<header class="headers">
    <div class="headerslide">
        <?php if( $gallery ): ?>
            <?php foreach($gallery as $k=>$v){?>
                <a class="slideson">
                    <img src="<?php echo $v['gry_url'];?>" />
                </a>
            <?php }?>
        <?php else: ?>
            <a class="slideson">
                <img src="<?php echo get_cdn_url('public/soma/images/default2.jpg'); ?>" />
            </a>
        <?php endif; ?>
    </div>
<!--	<img src="images/img/bann.jpg" />-->
</header>
<div class="whiteblock" style="margin-top:0">
	<div><?php echo $package['name'];?></div>
</div>
<div class="whiteblock bd_bottom support_list">

    <?php if($package['can_refund'] == $packageModel::CAN_T){ ?>
        <span tips="购买后，您可以在订单中心直接申请退款，并原路退回"><em class="iconfont color_main">&#xe61e;</em><tt>微信退款</tt></span>
    <?php } ?>

    <?php if($package['can_gift'] == $packageModel::CAN_T){ ?>
        <span tips="该商品购买成功后，可微信转赠给好友，好友可继续使用"><em class="iconfont color_main">&#xe61e;</em><tt>赠送朋友</tt></span>
    <?php } ?>

    <?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
        <span tips="这件商品，是可以邮寄的商品哟"><em class="iconfont color_main">&#xe61e;</em><tt>邮寄到家</tt></span>
    <?php } ?>

    <?php if($package['can_pickup'] == $packageModel::CAN_T){ ?>
        <span tips="此商品支持您到店使用／自提"><em class="iconfont color_main">&#xe61e;</em><tt>到店自提</tt></span>
    <?php } ?>
    <?php if($package['can_invoice'] == $packageModel::CAN_T){ ?>
        <span tips="此商品购买成功后，您可以提交发票信息开票"><em class="iconfont color_main">&#xe61e;</em><tt>开具发票</tt></span>
    <?php } ?>
        <!--span tips="此商品购买成功后，您可以提交发票信息开票"><em class="iconfont color_main">&#xe61e;</em><tt>开具发票</tt></span-->
</div>
<div class="whiteblock">
	<div><em class="iconfont color_main">&#xe620;</em>此商品由<?php echo $public['name'];?>提供</div>
</div>
<?php /**有秒杀**/ if( !empty($killsec) && isset($killsec['is_stock']) && $killsec['is_stock']==Soma_base::STATUS_TRUE ): ?>
<div class="whiteblock" id="ks_stock_div" style="display: none;">
	<div class="justify webkitbox">
    	<div class="progress"><span class="bg_main fill1" style="width:0<?php //echo $ks_percent; ?>%">&nbsp;<img src="<?php echo get_cdn_url('public/soma/images/ruler.png'); ?>"></span></div>
        <div><span class="color_main">剩余名额：</span><span class="color_888 fill2">0<?php //echo $ks_stock; ?>/1<?php //echo $ks_count; ?></span></div>
    </div>
</div>
<script>
function fill_progress(){
	$.post('<?php echo Soma_const_url::inst()->get_url('*/killsec/find_killsec_stock_ajax', array('id'=>$inter_id )); ?>',
			{act_id:'<?php echo $killsec['act_id']; ?>'}, function(json)
	{
	    if( json.status == 1 ){
	    	$('.fill1').animate({width:json.percent+ '%'});	
			$('.fill2').html(json.stock + '/' + json.total);
			$('#ks_stock_div').show();	
	    } else {

	    }
	},'json');
}
fill_progress();
window.setInterval(fill_progress,<?php echo $stock_reflesh_rate; ?>);
</script>
<?php endif; ?>
<div class="bg_fff block martop h24">
	<p class="bd_bottom">
    	<span class="color_555">订购需知</span>
    	<span class="h22">
        <?php /**有秒杀**/ if(!empty($killsec)){ ?>
                <?php if( isset($finish_killsec) && $finish_killsec ){ ?>
                	<span class="bg_main bdradius pad2">本轮秒杀已经结束</span>
                <?php } elseif($killsec['killsec_time'] >= date('Y-m-d H:i:s',time())){ ?>
                    <span class="bg_main bdradius pad2" id="timeCalc">
                        <span class="j_dat"></span>
                        <span class="j_tmie"></span>
                    </span>
                    <script>
                        var oTime = '<?php echo date('Y/m/d H:i:s',strtotime($killsec['killsec_time']));?>';
                        var startFlag = true;
                        /*秒杀倒计时*/
                        function countdownTime(Time){
                            var endTime=new Date(Time);
                            var nowTime=new Date();
                            var s_time=endTime-nowTime;
                            var end_date=parseInt((s_time/1000)/86400);
                            var end_hour=parseInt((s_time/1000)%86400/3600);
                            var end_minute=parseInt((s_time/1000)%3600/60);
                            var end_second=parseInt((s_time/1000)%60);
                            return {
                                j_date : end_date,
                                j_hour : end_hour,
                                j_minute : end_minute,
                                j_second : end_second,
                                j_rest  : s_time
                            }
                        }
                        calcStrObj = countdownTime(oTime);

                        if(parseInt(calcStrObj.j_date) <=0){
                            $('#timeCalc').find('.j_dat').html('秒杀开始倒计时：');
                        }else{
                            $('#timeCalc').find('.j_dat').html('秒杀开始倒计时：'+ calcStrObj.j_date+'天');
                        }

                        if(parseInt(calcStrObj.j_date) <=0 && parseInt(calcStrObj.j_hour) <=0){
                            $('#timeCalc').find('.j_tmie').html(calcStrObj.j_minute+'分'+calcStrObj.j_second + '秒');
                        }else{
                            $('#timeCalc').find('.j_tmie').html(calcStrObj.j_hour+'小时'+ calcStrObj.j_minute+'分'+calcStrObj.j_second + '秒');
                        }
                        $('#timeCalc').time=setInterval(function(){
                            if(parseInt(countdownTime(oTime).j_rest) <= 0 ){
                                startFlag = true;
                                $('#timeCalc').html('秒杀进行中');
                                clearInterval($('#timeCalc').time);
                            }else{
                                startFlag = false;
                            }
                            calcStrObj = countdownTime(oTime);

                            if(parseInt(calcStrObj.j_date) <=0){
                                $('#timeCalc').find('.j_dat').html('秒杀开始倒计时：');
                            }else{
                                $('#timeCalc').find('.j_dat').html('秒杀开始倒计时：'+ calcStrObj.j_date+'天');
                            }
                            if(parseInt(calcStrObj.j_date) <=0 && parseInt(calcStrObj.j_hour) <=0){
                                $('#timeCalc').find('.j_tmie').html(calcStrObj.j_minute+'分'+calcStrObj.j_second + '秒');
                            }else{
                                $('#timeCalc').find('.j_tmie').html(calcStrObj.j_hour+'小时'+ calcStrObj.j_minute+'分'+calcStrObj.j_second + '秒');
                            }
                        },1000)
                    </script>
                <?php }else{ ?>
                    <span class="bg_main bdradius pad2">秒杀进行中</span>
                    <script>
                        var startFlag = true;
                    </script>
                <?php }/** end有秒杀*/?>
                <?php /**有拼团**/ 
} elseif (!empty($groupons)){ //foreach($groupons as $k=>$v){ ?>
                <span class="bg_main bdradius pad2"><!--支付后并邀请 <?php echo $v['group_count']-1;?> 位好友参团，-->拼团购买超时，人数不足自动退款</span>
            <?php /**有活动**/ 
} elseif ( !empty($auto_rule)){ foreach($auto_rule as $k=>$v){ ?>
                <span class="bg_main bdradius pad2"><?php echo $v['name']; ?></span>
            <?php 
} } /** end**/?>

    	</span>
    </p>
    <?php if(isset($package['order_notice'])  && !empty($package['order_notice']) ){?>
    <p  class="color_999">
        <?php echo $package['order_notice']; ?>
    </p>
    <?php } ?>
</div>

<?php
$content = unserialize($package['compose']);
if(!empty($content)){ ?>

<div class="bg_fff martop block h24 color_555">
	<p class="bd_bottom">商品内容</p>
    <ul class="block_list color_888">
        <li class="color_888 bd_bottom h24"><span>名称</span><span>数量</span></li>
        <?php  if(is_array($content)){ foreach($content as $k=>$v){if(empty($v['content'])) continue; ?>
        <li class="bd_bottom h24 color_555"><span><?php echo $v['content'];?></span><span><?php echo $v['num'];?></span></li>
            <?php }}?>
    </ul>
</div>

<?php } ?>

<div class="bg_fff bd martop block h24 color_555" id="showdetail">
	<p class="bd_bottom">图文详情</p>
    <div class="fillcontent"><?php echo $package['img_detail'];?></div>
</div>
<div class="bg_fff bd martop block" id="openLocation">
	<em class="iconfont color_888" style="float:right;">&#xe607;</em>
    <p class="txtclip" style="width:82%;">地址：<?php echo $package['hotel_address'];?></p>
</div>

<script>
<?php /**有秒杀**/ if( isset($killsec) &&  !empty($killsec)){ ?>
var subscribe_lock= false;
function get_in_line(){
	if(!startFlag){
		var tmptime= new Date('<?php echo date('Y/m/d H:i:s',strtotime($killsec['killsec_time']));?>');
		var tmpnow = new Date();
		if ( tmptime.getTime()-tmpnow.getTime() < 15*60*1000 ){ // 小于30分钟
			$.MsgBox.Alert( '秒杀尚未开始,敬请等待' );
			
		} else {

<?php if( isset($killsec['is_subscribe']) && $killsec['is_subscribe']==Soma_base::STATUS_TRUE ): ?>
            if( subscribe_lock== true){
            	$.MsgBox.Alert( '您已成功订阅！' );
            
            } else {
            	$.MsgBox.Confirm('活动尚未开始，你可以订阅提醒，活动开始前10分钟将提醒您', function(){
            		//window.location.href='';//rightEvent;
            		pageloading('数据发送中，请稍后', 0.2);
            		$.ajax({
            		url:'<?php echo Soma_const_url::inst()->get_url('*/killsec/subscribe_killsec_notice_ajax', array('id'=>$inter_id )); ?>',
            			type: 'POST',
            			dataType:'JSON',
            			data:{
            			act_id :'<?php echo $killsec['act_id']; ?>',
            			},
            			success:function(json){
            				$('.pageloading').remove();
            				subscribe_lock= true;
            				if( json.status == 1 ){
            					$.MsgBox.Alert( json.message );								
            				} else if( json.status == 2 ){
            					$.MsgBox.Alert( json.message );
            				}
            			}
            		});
            	},function(){
            		//window.location.href='';//leftEvent;					
            	},'立即订阅', '稍候再说');
            }
<?php else: ?>
            $.MsgBox.Alert( '秒杀尚未开始,敬请等待' );
<?php endif; ?>
		}
		return false;
	}

	pageloading('排队中，请稍后',0.2);
	$.ajax({
		url:'<?php echo Soma_const_url::inst()->get_url('*/killsec/get_killsec_token_ajax', array('id'=>$inter_id )); ?>',
		type: 'POST',
		dataType:'JSON',
		data:{
			act_id :'<?php echo $killsec['act_id']; ?>',
		},
		success:function(json){
			$('.pageloading').remove();
			if( json.status == 1 ){
				var token= json.data.token;
				var instance_id= json.data.instance_id;
				//$.MsgBox.Alert('', json.message,function(){
				location.href='<?php echo Soma_const_url::inst()->get_url('*/killsec/package_pay',
					array('id'=>$inter_id, 'pid'=>$_GET['pid'], 'act_id'=>$killsec['act_id'], )); ?>&instance_id='+ instance_id+ '&token='+ token;
				//} );
			} else if( json.status == 2 ){
				$.MsgBox.Alert( json.message );
			}
		}
	})
}
<?php } ?>
</script>
<div class="foot_fixed">
    <div class="bg_fff webkitbox">
    <?php if( !$killsec && !$groupons && empty($auto_rule) ): ?>
		<a class="h24 btn_void bdradius" href="<?php echo Soma_const_url::inst()->get_package_pay(). "&pid={$package['product_id']}&bType=mail";?>">送自己</a>
		<a class="h24 btn_void bdradius" href="<?php echo Soma_const_url::inst()->get_package_pay(). "&pid={$package['product_id']}&bType=gift";?>">送朋友</a>
		<a class="h24 btn_void bdradius" href="<?php echo Soma_const_url::inst()->get_package_pay(). "&pid={$package['product_id']}&bType=gift";?>">送群友</a>
    <?php else: ?>
        <a href="<?php echo Soma_const_url::inst()->get_pacakge_home_page(array('id'=>$inter_id)); ?>" class="img_link"><img src="<?php echo get_cdn_url('public/soma/v1/images'); ?>/ico9.png"/></a>
        <a href="<?php echo Soma_const_url::inst()->get_soma_ucenter(array('id'=>$inter_id)); ?>" class="img_link"><img src="<?php echo get_cdn_url('public/soma/v1/images'); ?>/ico10.png"/></a>
	<?php endif; ?>
	
   		<?php if( isset($finish_killsec) && $finish_killsec ): ?>
    	<div class="h24 bg_C3C3C3 bdradius" style="border: 1px solid transparent"><?php echo $killsec['killsec_price'];?>已售馨</div>
        <?php /**有秒杀**/elseif( isset($killsec) && !empty($killsec)): ?>
       <a class="h24 bg_main bdradius" style="border: 1px solid transparent" onclick='get_in_line();'>¥<?php echo $killsec['killsec_price'];?>秒杀购买</a>
    <?php /**有拼团**/
    elseif( !empty($groupons) && !$is_expire ): ?>
        <?php foreach($groupons as $k=>$v): ?>
            <a href="<?php echo Soma_const_url::inst ()->get_groupon_first_pay(array('act_id'=>$v['act_id'],'id'=>$inter_id));?>" class="h24 bg_main bdradius" style="border: 1px solid transparent" >¥<?php echo $v['group_price'];?> | <?php echo $v['group_count'];?>人团</a>
        <?php break; endforeach; ?>
    <?php 
    elseif(!empty($auto_rule)): ?>
        <a class="h24 bg_main bdradius" style="border: 1px solid transparent" href="<?php echo Soma_const_url::inst()->get_package_pay(array(
            'pid'=>$_GET['pid'], 'id'=>$inter_id, 'rid'=>$auto_rule[0]['rule_id'] )); ?>">团购特惠
        </a>
    <?php endif; ?>
    
            <?php if( $is_expire ): ?>
        <div class="h24 bdradius bg_C3C3C3" style="border: 1px solid transparent">已过期</div>
            <?php else: ?>
        <a class="h24 bdradius btn_void txtclip" href="<?php echo Soma_const_url::inst ()->get_package_pay(array('pid'=>$_GET['pid'],'id'=>$inter_id));?>">
                ¥<?php echo $package['price_package'];?>立即购买
        </a>
            <?php endif; ?>
    </div>
</div>
<div style="padding-top:18%"></div>
<div class="ui_pull share_pull" style="display:none" onClick="toclose()"></div>
</body>
<script>

$.fn.imgscroll({
	imgrate : 640/640,
	circlesize: '8px'
})

$('#how_sent').click(function(){
	toshow($('.how_sent_pull'));
});
$('#toshare').click(function(){
	toshow($('.share_pull'));
});
$('.how_sent_pull').click(toclose);
$('#showdetail').click(function(){
	toshow($('.showdetail_pull'));
});
$('.showdetail_pull').click(toclose);

$('.support_list span').click(function(){
	$.MsgBox.Alert($(this).attr('tips'));
	$('#left_btn').parent().remove();
})
</script>
</html>
