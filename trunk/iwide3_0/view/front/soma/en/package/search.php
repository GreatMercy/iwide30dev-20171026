<body>
<link href="<?php echo get_cdn_url('public/soma/v1/v1.css'). config_item('css_debug');?>" rel="stylesheet">
<div class="pageloading"><p class="isload">正在加载</p></div>
<script>
wx.config({
    debug: false,
    appId: '<?php echo $wx_config["appId"]?>',
    timestamp: <?php echo $wx_config["timestamp"]?>,
    nonceStr: '<?php echo $wx_config["nonceStr"]?>',
    signature: '<?php echo $wx_config["signature"]?>',
    jsApiList: [<?php echo $js_api_list; ?>,'getLocation']
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
});
</script>


    <div class="tp_list" id="tp_list">
        <?php foreach($products as $k=>$v){?>
    	<a href="<?php echo Soma_const_url::inst()->get_package_detail(array('pid'=>$v['product_id'],'id'=>$inter_id) );?>" class="item bg_fff">
            <div class="img">
                <img s="<?php echo get_cdn_url('public/soma/images/default2.jpg'); ?>" src="<?php echo $v['face_img'];?>" />

                <?php if(isset($v['killsec'])){ //有秒杀 ?>
                    <div class="j_label color_main f_s_12">秒杀</div>
                <?php } elseif(isset($v['groupon'])){ //有拼团 ?>
                    <div class="j_label color_main f_s_12">拼团</div>
                <?php } elseif(isset($v['auto_rule'])){ //有活动 ?>
                    <div class="j_label color_main f_s_12">满减</div>
                <?php } ?>

                <?php if($v['type'] == $packageModel::PRODUCT_TYPE_BALANCE): ?> 
                    <div class="j_label color_main f_s_12">会员</div>
                <?php endif; ?>
                <?php if($v['type'] == $packageModel::PRODUCT_TYPE_POINT): ?> 
                    <div class="j_label color_main f_s_12">积分</div>
                <?php endif; ?>

            </div>
            <p class="h28"><?php echo $v['name'];?></p>

            <?php if(isset($v['killsec'])){ //有秒杀 ?>
                <p class="item_foot h24 color_888">秒杀价 <span class="color_main y h28"><?php echo $v['killsec']['killsec_price'];?></span></p>
            <?php } elseif(isset($v['groupon'])){ //有拼团 ?>
                <p class="item_foot h24 color_888"><?php echo $v['groupon']['group_count'];?>人团 <span class="color_main y h28"><?php echo $v['groupon']['group_price'];?></span></p>
            <?php } else{ ?>
                
			<?php if($v['type'] == $packageModel::PRODUCT_TYPE_BALANCE): ?>
                <p class="item_foot h24 color_888"><?php if( $this->inter_id == 'a472731996' ) echo '雅币'; else echo '储值';  ?>价 <span class="color_main y h28"><?php echo $v['price_package']?></span></p>
            <?php elseif($v['type'] == $packageModel::PRODUCT_TYPE_POINT): ?>
                <p class="item_foot h24 color_888">积分价 <span class="color_main y h28"><?php echo $v['price_package']?></span></p>
            <?php else: ?>
                <p class="item_foot h24 color_888">惊喜价 <span class="color_main y h28"><?php echo $v['price_package']?></span></p>
            <?php endif; ?>

            <?php } ?>
                
        </a>
        <?php } ?>
    </div>

<?php
        if(empty($packages)){
?>

<div class="ui_none" onClick="history.back(-1)"><div>此分类暂未添加<span style="color:blue;">(返回上一级)</span></div></div>


<?php
        }
?>


<script>
    window.onload=function(){
        $('.img').each(function(index, element) {
            $(this).height($(this).width());
        });
    }
</script>
</body>
</html>