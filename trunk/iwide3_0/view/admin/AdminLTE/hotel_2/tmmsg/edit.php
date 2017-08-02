<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
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
.over_x{width:100%;overflow-x:auto;}
.border_1{border:1px solid #d7e0f1;}
.relative{position:relative;}
.absolute{position:absolute;}
.bg_fff{background:#fff;}
.bg_3f51b5{background:#3f51b5;}
.bg_ff503f{background:#ff503f;}
.bg_4caf50{background:#4caf50;}
.w_450{width:450px;}
.clearfix:after{content: "" ;display:block;height:0;clear:both;visibility:hidden;}
.display_none{display:none !important;}
.d_n{display:none;}
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
.con_right >div >div:nth-of-type(1){width:115px;height:30px;line-height:30px;text-align:right;margin-right:10px;}
.input_txt{height:30px;line-height:30px;}
.input_txt >input{height:30px;line-height:30px;border:1px solid #d7e0f1;width:450px;text-indent:3px;}
.input_txt >select{height:30px;line-height:30px;display:inline-block;border:1px solid #d7e0f1;background:#fff;margin-right:20px;padding:0 8px;}
.input_radio >div{margin-right:10px;}
.input_radio >div >input{display:none;}
.input_radio >div >input+label{font-weight:normal;text-indent:25px;background:url(http://test008.iwide.cn/public/js/img/radio1.png) no-repeat center left;background-size:17%;width:118px;height:30px;line-height:30px;}
.input_radio >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/radio2.png) no-repeat center left;background-size:17%;}
.block{display:inline-block;height:18px;width:4px;vertical-align: middle;margin-right:5px;}
.introduce{width:450px;height:150px;margin-left:4px;resize:vertical;}
.add_img{width:77px;height:77px;background:url(http://test008.iwide.cn/public/js/img/214598012363739107.png) no-repeat;background-size:100%;}
.page_url{display:none;}
.deletes{color:#689525;left:680px;cursor:pointer;}
.fixed1_title{padding-bottom:10px;}
.d_table{display:table;width:100%;padding:3px 0;}
.d_table>div{display:table-cell;width:20%;color:#3c8dbc;}
.fixed1{padding:20px 10px;margin-top:30px;}
.fixed1 >div:last-child >div:nth-of-type(3){width:30%;}
.fixed1 >div:last-child >div:nth-of-type(4){width:30%;}


.input_checkbox >div >input{display:none;}
.input_checkbox >div >input+label{font-weight:normal;text-indent:25px;background:url(http://test008.iwide.cn/public/js/img/bg.png) no-repeat center left;background-size:15%;width:110px;height:30px;line-height:30px;}
.input_checkbox >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/bg2.png) no-repeat center left;background-size:15%;}

.fom_btn{background:#ff9900;color:#fff;outline:none;border:0px;padding:6px 25px;border-radius:3px;margin:auto;display:inline-block;margin-right:6%;}
.fom_btn:last-child{margin-right:0%;}
.actives{color:#000;background:#fff;border:1px solid #d7e0f1;}
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
		<div class="banner bg_fff p_0_20">模版消息／新建模版</div>
		<div class="contents">
			<from>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_3f51b5"></span>基本信息</div>
					<div class="con_right">
						<div class="address">
							<div class="">模版名称</div>
							<div class="input_txt">
								<select class="w_450">
									<option>模版名称1</option>
									<option>模版名称2</option>
									<option>模版名称3</option>
									<option>模版名称4</option>
								</select>
							</div>
							<a class="" href="">使用默认设置</a>
						</div>
						<div class="jingwei">
							<div class="">模版ID</div>
							<div class="input_txt"><input type="text" placeholder="微信模版消息ID" /></div>
						</div>
						<div class="hotel_star">
							<div class="">引流页面</div>
							<div class="input_txt input_radio">
								<div>
									<input type="radio" id="star_5" name="1" value="我的订单页"/>
									<label for="star_5">我的订单页</label>
								</div>
								<div>
									<input type="radio" id="star_4" name="1" value="订单详情页"/>
									<label for="star_4">订单详情页</label>
								</div>
								<div>
									<input type="radio" id="star_3" name="1" value="订单评论页"/>
									<label for="star_3">订单评论页</label>
								</div>
								<div>
									<input type="radio" id="economics" name="1" value="会员中心页"/>
									<label for="economics">会员中心页</label>
								</div>
								<div>
									<input type="radio" id="economics1" name="1" value="自定义页面"/>
									<label for="economics1">自定义页面</label>
								</div>
							</div>
						</div>

						<div class="jingwei page_url">
							<div class="">页面url</div>
							<div class="input_txt"><input type="text" placeholder="输入引流页面的链接" /></div>
						</div>
						<div class="jingwei">
							<div class="">文字颜色</div>
							<div class="input_txt"><input type="text" placeholder="html颜色代码，如#000000" /></div>
						</div>
						<div class="jingwei">
							<div class="">状态</div>
							<div class="input_txt" >
								<select style="width:450px;">
									<option>有效</option>
									<option>无效</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_3f51b5"></span>模版字段1</div>
					<div class="con_right relative">
						<span class="deletes absolute">删除</span>
						<div class="jingwei">
							<div class="">字段名称</div>
							<div class="input_txt"><input type="text" placeholder="模版消息详情内容里的参数字段名" /></div>
						</div>
						<div class="jingwei">
							<div class="">文本颜色</div>
							<div class="input_txt"><input type="text" placeholder="html颜色代码，如#000000,可不填" /></div>
						</div>
						<div class="hotel_star clearfix">
							<div class="float_left">字段内容</div>
							<div class="input_txt input_checkbox" style="padding-left:4px;">
								<div>
									<input type="checkbox" id="wf" name="" value="Wi-Fi">
									<label for="wf">默认</label>
								</div>
								<div>
									<input type="checkbox" id="con_room" name="" value="会议室">
									<label for="con_room">未支付</label>
								</div>
								<div>
									<input type="checkbox" id="shuttle" name="" value="专车接送">
									<label for="shuttle">已支付</label>
								</div>
							</div>
						</div>
						<div class="jingwei d_n jingwei1">
							<div class="">默认内容</div>
							<div class="input_txt"><input type="text" placeholder="默认情况下发送给用户的内容" /></div>
						</div>
						<div class="jingwei d_n jingwei2">
							<div class="">未支付内容</div>
							<div class="input_txt"><input type="text" placeholder="未支付情况下以送给用户的内容" /></div>
						</div>
						<div class="jingwei d_n jingwei3">
							<div class="">已支付内容</div>
							<div class="input_txt"><input type="text" placeholder="已支付情况下以送给用户的内容" /></div>
						</div>
					</div>
				</div> -->
			</from>
			<div class="bg_fff border_1 btns_list" style="padding:15px;text-align:center;">
				<button class="fom_btn">保存模版</button>
				<button class="fom_btn actives news_add">新增字段</button>
			</div>
			<div class="fixed1 bg_fff border_1">
				<div class="fixed1_title">订单代码：点击将代码填入字段内容中，模板消息中就会显示相应的内容</div>
				<div class="d_table">
					<div>{ORDERID}-订单号</div>
					<div>{NAME}-预订人姓名</div>
					<div>{HOTEL}-酒店名</div>
					<div>{STARTDATE}-入住日期</div>
					<div>{ENDDATE}-离店日期</div>
				</div>
				<div class="d_table">
					<div>{PRICE}-订单总价</div>
					<div>{ROOMNUMS}-预订房间数</div>
					<div>{ROOM}-房型</div>
					<div>{ORDERTIME}-下单时间</div>
					<div>{STATUS}-订单状态</div>
				</div>
				<div class="d_table">
					<div>{OPERTIME}-发送时间</div>
					<div>{TEL}-联系电话</div>
					<div>{STARTDATE_ENG}-入住日期年-月-日格式</div>
					<div>{ENDDATE_ENG}-离店日期年-月-日格式</div>
				</div>
			</div>
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
<script type="text/javascript">
	<?php $timestamp = time();?>
	$(function(){
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
		$('.input_txt input').change(function(){
			if($('#economics1:checked').val()){
				$('.page_url').show();
			}else{
				$('.page_url').hide();
			}
		})
		var number=1;
		$('.news_add').click(function(){
			var context=$('<div class="contents_list bg_fff"><div class="con_left"><span class="block bg_3f51b5"></span>模版字段'+number+'</div><div class="con_right relative"><span class="deletes absolute">删除</span><div class="jingwei"><div class="">字段名称</div><div class="input_txt"><input type="text" placeholder="模版消息详情内容里的参数字段名" /></div></div><div class="jingwei"><div class="">文本颜色</div><div class="input_txt"><input type="text" placeholder="html颜色代码，如#000000,可不填" /></div></div><div class="hotel_star clearfix"><div class="float_left">字段内容</div><div class="input_txt input_checkbox" style="padding-left:4px;"><div><input class="wf" type="checkbox" id="wf'+number+'" name="" value="Wi-Fi"><label for="wf'+number+'">默认</label></div><div><input class="con_room" type="checkbox" id="con_room'+number+'" name="" value="会议室"><label for="con_room'+number+'">未支付</label></div><div><input class="shuttle" type="checkbox" id="shuttle'+number+'" name="" value="专车接送"><label for="shuttle'+number+'">已支付</label></div></div></div><div class="jingwei d_n jingwei1"><div class="">默认内容</div><div class="input_txt"><input type="text" placeholder="默认情况下发送给用户的内容" /></div></div><div class="jingwei d_n jingwei2"><div class="">未支付内容</div><div class="input_txt"><input type="text" placeholder="未支付情况下以送给用户的内容" /></div></div><div class="jingwei d_n jingwei3"><div class="">已支付内容</div><div class="input_txt"><input type="text" placeholder="已支付情况下以送给用户的内容" /></div></div></div></div>')
				$('.contents from').append(context);
				number++;
		})

		$('from').delegate('.deletes','click',function(){
			$(this).parents(".contents_list").remove();
		})
		
		j_toChange('.wf','.jingwei1')
		j_toChange('.con_room','.jingwei2')
		j_toChange('.shuttle','.jingwei3')
		function j_toChange(obj,obj2){
			$('from').delegate(obj,'change',function(){
				var _this=$(this);
				if(_this.parents('.contents_list').find(''+obj+':checked').val()){
					_this.parents('.contents_list').find(obj2).show();
				}else{
					_this.parents('.contents_list').find(obj2).hide();
				}
			});
		}
		// $('from').delegate('.wf','change',function(){
		// 	var _this=$(this);
		// 	console.log(_this.parents('.contents_list').find('.wf:checked').val());
		// 	if(_this.parents('.contents_list').find('.wf:checked').val()){
		// 		_this.parents('.contents_list').find('.jingwei1').show();
		// 	}else{
		// 		_this.parents('.contents_list').find('.jingwei1').hide();
		// 	}
		// });
		// $('from').delegate('.con_room','change',function(){
		// 	var _this=$(this);
		// 	if(_this.parents('.contents_list').find('.con_room:checked').val()){
		// 		_this.parents('.contents_list').find('.jingwei2').show();
		// 	}else{
		// 		_this.parents('.contents_list').find('.jingwei2').hide();
		// 	}
		// });
		// $('from').delegate('.shuttle','change',function(){
		// 	var _this=$(this);
		// 	if(_this.parents('.contents_list').find('.shuttle:checked').val()){
		// 		_this.parents('.contents_list').find('.jingwei3').show();
		// 	}else{
		// 		_this.parents('.contents_list').find('.jingwei3').hide();
		// 	}
		// });


			
		//图片上传排版start
		 $("#file >input").change(function(e){
             var file = this.files[0];
             var imageType = /image.*/;
             if(file.type.match(imageType)){
                 var reader = new FileReader();
                 reader.onload=function(){
                    $(".file_img_list").prepend($('<div class="add_img_box" style="float:left;width:77px;height:77px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:77px;height:77px;overflow:hidden;" src="'+reader.result+'"/><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont">&#xe635;</i></div></div>'));
			        $('.add_img_box').delegate('.img_close','click',function(){
						$(this).parent().remove();
						$("#file >input").val('');
					})
                 }
                reader.readAsDataURL(file);
            }
        });

		//图片上传排版end
	});
</script>