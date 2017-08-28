<?php include 'header.php' ?>
<body>
  <div id="app">
  </div>
  <div id="scriptArea" data-page-id="cardinfo"></div>
</body>
<script type=text/javascript src="<?php echo refer_res('manifest.js','public/user') ?>"></script>
<script type=text/javascript src="<?php echo refer_res('app.js','public/user') ?>"></script>
<script>
<?php if(isset($wx_config) && !empty($wx_config)):?>
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
	<?php if( $js_share_config && $card_info['is_given_by_friend']=='t' && $card_info['is_giving']=='f'): ?>
	wx.onMenuShareTimeline({
		title: '<?php echo !empty($js_share_config["title"])?$js_share_config["title"]:'分享到朋友圈';?>',
		link: '<?php echo $js_share_config["link"];?>',
		imgUrl: '<?php echo $js_share_config["imgUrl"];?>',
		success: function () {
		},
		cancel: function () {
		}
	});
	wx.onMenuShareAppMessage({
		title: '<?php echo !empty($js_share_config["title"])?$js_share_config["title"]:'发送给好友'?>',
		desc: '<?php echo $js_share_config["desc"];?>',
		link: '<?php echo $js_share_config["link"];?>',
		imgUrl: '<?php echo $js_share_config["imgUrl"];?>',
		success: function () {
		},
		cancel: function () {
		}
	});
	<?php endif; ?>
});

function handle_share() {
	var curl = "<?php echo site_url('membervip/card/gift_card?id='.$inter_id);?>";
	var mcid = "<?php echo isset($card_info['member_card_id'])?$card_info['member_card_id']:0;?>";
	var module = "<?php echo $card_info['receive_module'];?>";
	var card_code = "<?php echo $card_info['coupon_code'];?>";

}
<?php endif; ?>
</script>
</html>
