<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/images/laydate.css">
<link rel="stylesheet" href="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/images/laydate12.css">
<style>
@font-face {
  font-family: 'iconfont';
  src: url('http://test008.iwide.cn/public/newfont/iconfont.eot');
  src: url('http://test008.iwide.cn/public/newfont/iconfont.eot?#iefix') format('embedded-opentype'),
  url('http://test008.iwide.cn/public/newfont/iconfont.woff') format('woff'),
  url('http://test008.iwide.cn/public/newfont/iconfont.ttf') format('truetype'),
  url('http://test008.iwide.cn/public/newfont/iconfont.svg#iconfont') format('svg');
}
.iconfont{
  font-family:"iconfont" !important;
  font-size:16px;font-style:normal;
  -webkit-font-smoothing: antialiased;
  -webkit-text-stroke-width: 0.2px;
  -moz-osx-font-smoothing: grayscale;
}
.p_l_4{padding-left:4px;}
.moba{height:30px;line-height:30px;border:1px solid #d7e0f1;text-indent:3px;}
.w_450{width:450px;}
.w_600{width:600px;}
.over_x{width:100%;overflow-x:auto;}
.border_1{border:1px solid #d7e0f1 !important;}
.bg_fff{background:#fff;}
.bg_3f51b5{background:#3f51b5;}
.bg_ff503f{background:#ff503f;}
.bg_4caf50{background:#4caf50;}
.clearfix:after{content: "" ;display:block;height:0;clear:both;visibility:hidden;}
.display_none{display:none !important;}
.m_b_20{margin-bottom:20px;}
.float_left{float:left;}
.content-wrapper{color:#7e8e9f;}
.p_0_20{padding:0 20px;}
textarea{border:1px solid #d7e0f1;}
.banner{height:50px;width:100%;line-height:50px;border-bottom:1px solid #d7e0f1;}
.contents{padding:10px 20px 20px 20px;}
.contents_list{display:table;width:100%;border:1px solid #d7e0f1;margin-bottom:10px;}
.hotel_star >div:nth-of-type(2) >div,.con_right >div >div{display:inline-block;}
.con_left{width:150px;text-align:center;border-right:1px solid #d7e0f1;display:table-cell;vertical-align:middle;}
.con_right{padding:20px 0 20px 0px;}
.con_right>div{margin-bottom:12px;}
.con_right >div >div:nth-of-type(1){width:115px;height:30px;line-height:30px;text-align:center;}
.input_txt{height:30px;line-height:30px;}
.input_txt >input{height:30px;line-height:30px;border:1px solid #d7e0f1;width:450px;text-indent:3px;}
.input_txt >select{height:30px;line-height:30px;display:inline-block;border:1px solid #d7e0f1;background:#fff;margin-right:20px;padding:0 8px;}
.input_radio >div{margin-right:10px;}
.input_radio >div >input{display:none;}
.input_radio >div >input+label{font-weight:normal;text-indent:25px;background:url(http://test008.iwide.cn/public/js/img/radio1.png) no-repeat center left;background-size:22%;width:90px;height:30px;line-height:30px;}
.input_radio >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/radio2.png) no-repeat center left;background-size:20%;}
.block{display:inline-block;height:18px;width:4px;vertical-align: middle;margin-right:5px;}
.introduce{width:450px;height:150px;margin-left:4px;resize:vertical;}
.add_img{width:77px;height:77px;background:url(http://test008.iwide.cn/public/js/img/214598012363739107.png) no-repeat;background-size:100%;}

.input_checkbox >div >input{display:none;}
.input_checkbox >div >input+label{font-weight:normal;text-indent:20px;background:url(http://test008.iwide.cn/public/js/img/bg.png) no-repeat center left;background-size:13%;width:128px;height:30px;line-height:30px;}
.input_checkbox >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/bg2.png) no-repeat center left;background-size:13%;}

.fom_btn{background:#ff9900;color:#fff;outline:none;border:0px;padding:6px 25px;border-radius:3px;margin:auto;display:inline-block;margin-right:25px;border:1px solid #ff9900;}
.fom_btn:last-child{margin-right:0px;}
.add_img_box:hover > .img_close{display:block !important;cursor:pointer;}
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php 
/* 顶部导航 */
echo $block_top;
?>

<?php 
/* 左栏菜单 */
echo $block_left;
?>
<div class="over_x">
	<div class="content-wrapper" style="min-width:1050px;">
		<div class="banner bg_fff p_0_20">价格日历／一键关房</div>
		<div class="contents">
			<from>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_ff503f"></span>关房配置</div>
					<div class="con_right">
						<div class="hottel_name ">
							<div class="">酒店名称</div>
							<div class="input_txt">
								<select class="w_450">
									<option>酒店名称1</option>
									<option>酒店名称2</option>
									<option>酒店名称3</option>
									<option>酒店名称4</option>
								</select>
							</div>
						</div>
						<div class="hotel_star clearfix">
							<div class="float_left">房型名称</div>
							<div class="input_txt input_checkbox p_l_4 w_600">
								<div>
									<input type="checkbox" id="wf" name="" value="Wi-Fi"/>
									<label for="wf">豪华大床房</label>
								</div>
								<div>
									<input type="checkbox" id="con_room" name="" value="会议室"/>
									<label for="con_room">行政双人房</label>
								</div>
								<div>
									<input type="checkbox" id="shuttle" name="" value="专车接送"/>
									<label for="shuttle">行政房</label>
								</div>
								<div>
									<input type="checkbox" id="luggage" name="" value="行李寄存"/>
									<label for="luggage">测试换房</label>
								</div>
								<div>
									<input type="checkbox" id="stop" name="" value="停车场"/>
									<label for="stop">时租房</label>
								</div>
								<div>
									<input type="checkbox" id="swimming" name="" value="游泳池"/>
									<label for="swimming">测试房</label>
								</div>
							</div>
						</div>
						<div class="address">
							<div class="">条件时间</div>
							<div class="input_txt">
								<span><input id="datepicker" class="moba" type="text" /></span>
								<font>至</font>
								<span><input id="datepicker2" class="moba" type="text" /></span>
							</div>
						</div>
					</div>
				</div>
				<div class="bg_fff" style="padding:15px;text-align:center;">
					<button class="fom_btn">一键关房</button>
					<button class="fom_btn border_1" style="color:#000;background:#fff;">取消关房</button>
				</div>
			</from>
		</div>
	</div>
</div>

<?php 
/* Footer Block @see footer.php */
require_once VIEWPATH. $tpl .DS .'privilege'. DS. 'footer.php';
?>
<?php 
/* Right Block @see right.php */
require_once VIEWPATH. $tpl .DS .'privilege'. DS. 'right.php';
?>
</div><!-- ./wrapper -->
<?php 
/* Right Block @see right.php */
require_once VIEWPATH. $tpl .DS .'privilege'. DS. 'commonjs.php';
?>
</body>
</html>
<script src="<?php echo base_url(FD_PUBLIC) ?>/uploadify/jquery.uploadify.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/areaData.js"></script>
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/layDate.js"></script>
<script>
;!function(){
  laydate({
     elem: '#datepicker'
  })
  laydate({
     elem: '#datepicker2'
  })
}();
</script>
<script type="text/javascript">
	<?php $timestamp = time();?>
	$(function() {
		$('#el_intro_img').parent().append('<input type="file" value="上传图片" id="upfiles">');
		$('#upfiles').uploadify({
			'formData'     : {
				'<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>',
				'timestamp' : '<?php echo $timestamp;?>',
				'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
			},
			'swf'      : '<?php echo base_url(FD_PUBLIC) ?>/uploadify/uploadify.swf',
			//'uploader' : '<?php echo site_url("basic/upload/hotel_upload") ?>',
			'uploader' : '<?php echo site_url('basic/uploadftp/do_upload') ?>',
			'file_post_name': 'imgFile',
		    'onUploadSuccess' : function(file, data, response) {
			    var res = $.parseJSON(data);
        		$('#el_intro_img').val(res.url);
        	}
		});
	});
</script>