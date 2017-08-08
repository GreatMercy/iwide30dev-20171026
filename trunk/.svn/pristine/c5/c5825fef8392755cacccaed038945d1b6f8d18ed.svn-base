<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/images/laydate.css">
<link rel="stylesheet" href="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/images/laydate12.css">
<!-- <link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/datepicker/css/bootstrap-datepicker.min.css">
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/js/bootstrap-datepicker.min.js"></script> -->
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
.fom_btn{background:#ff9900;color:#fff;outline:none;border:0px;padding:6px 25px;border-radius:3px;margin:auto;display:block;}
.j_inupt{height:30px;line-height:30px;border:1px solid #d7e0f1;text-indent:3px;border-radius:0px;}
.agreement:checked+label+input{display:inline-block;}
.m_r_2{margin-right:2%;}
.w_550{width:550px;}
.label_parent_w>div>input+label{width:110px;background-size:19%;}
.symbol{vertical-align:middle;font-size:20px;}
.rule_display{display:none;}
.rule_select .rule_input:checked+label+div{display:inline-block;}
.rule_select .rule_input:checked+label{width:55px;background-size:42%;display:inline-block;}
input::-webkit-input-placeholder{color:#7e8e9f;}
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
	<div class="content-wrapper" style="min-width:900px;">
		<div class="banner bg_fff p_0_20">编辑价格代码／新增价格代码</div>
		<div class="contents">
			<from>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_3f51b5"></span>基本信息</div>
					<div class="con_right">
						<div class="hottel_name ">
							<div class="">代码名称</div>
							<div class="input_txt"><input type="text" /></div>
						</div>
						<div class="address">
							<div class="">代码描述</div>
							<div class="input_txt"><input type="text" /></div>
						</div>
						<div class="hotel_star">
							<div class="">价格类型</div>
							<div class="input_txt input_radio">
								<div>
									<input type="radio" id="star_5" name="1" value=""/>
									<label for="star_5">普通</label>
								</div>
								<div>
									<input type="radio" id="star_4" name="1" value=""/>
									<label for="star_4">会员价</label>
								</div>
								<div>
									<input class="agreement" type="radio" id="star_3" name="1" value=""/>
									<label for="star_3">协议价</label><input class="j_inupt" type="text" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_3f51b5"></span>价格配置</div>
					<div class="con_right">
						<div class="hotel_star">
							<div class="">关联代码</div>
							<div class="input_txt input_radio">
								<div>
									<input type="radio" id="code_5" name="2" value=""/>
									<label for="code_5">无效</label>
								</div>
								<div>
									<input type="radio" id="code_4" name="2" value=""/>
									<label for="code_4">限时秒杀</label>
								</div>
								<div>
									<input type="radio" id="code_3" name="2" value=""/>
									<label for="code_3">协议价A</label>
								</div>
								<div>
									<input type="radio" id="code_2" name="2" value=""/>
									<label for="code_2">到店现付</label>
								</div>
								<div>
									<input type="radio" id="code_1" name="2" value=""/>
									<label for="code_1">微信预付</label>
								</div>
							</div>
						</div>
						<div class="hotel_star">
							<div class="">计算公式</div>
							<div class="input_txt input_radio">
								<div>
									<input type="radio" id="algorithm_1" name="3" value=""/>
									<label for="algorithm_1">除</label>
								</div>
								<div>
									<input type="radio" id="algorithm_2" name="3" value=""/>
									<label for="algorithm_2">乘</label>
								</div>
								<div>
									<input type="radio" id="algorithm_3" name="3" value=""/>
									<label for="algorithm_3">加</label>
								</div>
								<div>
									<input type="radio" id="algorithm_4" name="3" value=""/>
									<label for="algorithm_4">减</label>
								</div>
							</div>
						</div>
						<div class="hottel_name ">
							<div class="">计算值</div>
							<div class="input_txt"><input type="text" /></div>
						</div>
					</div>
				</div>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_ff503f"></span>使用条件</div>
					<div class="con_right">
						<div class="hotel_star">
							<div class="">预付标记</div>
							<div class="input_txt input_radio">
								<div>
									<input type="radio" id="display_1" name="4" value=""/>
									<label for="display_1">不显示</label>
								</div>
								<div>
									<input type="radio" id="display_2" name="4" value=""/>
									<label for="display_2">显示</label>
								</div>
							</div>
						</div>
						<div class="hotel_star clearfix">
							<div class="">不使用</div>
							<div class="input_txt input_radio">
								<div>
									<input type="checkbox" id="wf" name="" value="Wi-Fi"/>
									<label for="wf">储值支付</label>
								</div>
								<div>
									<input type="checkbox" id="con_room" name="" value="会议室"/>
									<label for="con_room">到店支付</label>
								</div>
								<div>
									<input type="checkbox" id="wenxi_pay" name="" value="专车接送"/>
									<label for="wenxi_pay">微信支付</label>
								</div>
							</div>
						</div>
						<div class="hotel_star">
							<div class="">会员等级</div>
							<div class="input_txt input_radio">
								<div>
									<input type="radio" id="geade_1" name="5" value=""/>
									<label for="geade_1">不关联</label>
								</div>
								<div>
									<input type="radio" id="geade_2" name="5" value=""/>
									<label for="geade_2">微信会员</label>
								</div>
								<div>
									<input type="radio" id="geade_3" name="5" value=""/>
									<label for="geade_3">银卡会员</label>
								</div>
								<div>
									<input type="radio" id="geade_4" name="5" value=""/>
									<label for="geade_4">金卡会员</label>
								</div>
								<div>
									<input type="radio" id="geade_5" name="5" value=""/>
									<label for="geade_5">钻石会员</label>
								</div>
							</div>
						</div>
						<div class="hotel_star">
							<div class="">入住日期</div>
							<div class="w_550"><i class="iconfont symbol">&#xe672;</i><input id="datepicker" class="datepicker j_inupt" type="text" />，<i class="iconfont symbol">&#xe612;</i><input id="datepicker2" class="datepicker j_inupt m_r_2" type="text" />方可预定</div>
						</div>
						<div class="address">
							<div class="">离店日期</div>
							<div class="w_550"><i class="iconfont symbol">&#xe672;</i><input  id="datepicker3" class="datepicker j_inupt" type="text" />，<i class="iconfont symbol">&#xe612;</i><input  id="datepicker4" class="datepicker j_inupt m_r_2"  type="text" />方可预定</div>
						</div>
						<div class="address">
							<div class="">提前天数</div>
							<div class="input_txt"><input type="text" placeholder="提前预订天数" /></div>
						</div>
						<div class="address">
							<div class="">最大间数</div>
							<div class="input_txt"><input type="text" placeholder="单次最多可预订多少间房" /></div>
						</div>
						<div class="address">
							<div class="">最大天数</div>
							<div class=""><i class="iconfont symbol">&#xe672;</i><input class="j_inupt" type="text" />，<i class="iconfont symbol">&#xe612;</i><input class="j_inupt" type="text" /></div>
						</div>
					</div>
				</div>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_ff503f"></span>营销规则<br>(会员配置规则优先)</div>
					<div class="con_right">
						<div class="hotel_star">
							<div class="">用券规则</div>
							<div class="input_txt input_radio label_parent_w rule_select">
								<div>
									<input class="rule_input" type="radio" id="rule_1" name="6" value=""/>
									<label for="rule_1" style="">可用</label><div class="rule_display" style="">
										<select class="j_inupt" style="width:125px;">
											<option>每个订单可用</option>
											<option>每个间夜可用</option>
										</select>
										<input class="j_inupt number_input" type="tel" placeholder="">&nbsp;张</div>
								</div>
								<div>
									<input type="radio" id="rule_2" name="6" value=""/>
									<label for="rule_2">不可用</label>
								</div>
							</div>
						</div>
						<div class="hotel_star">
							<div class="">积分兑换</div>
							<div class="input_txt input_radio label_parent_w">
								<div>
									<input type="radio" id="exchange_1" name="7" value=""/>
									<label for="exchange_1">可用</label>
								</div>
								<div>
									<input type="radio" id="exchange_2" name="7" value=""/>
									<label for="exchange_2">不可用</label>
								</div>
							</div>
						</div>
						<div class="hotel_star">
							<div class="">积分与券</div>
							<div class="input_txt input_radio label_parent_w">
								<div>
									<input type="radio" id="rule_exchange_1" name="8" value=""/>
									<label for="rule_exchange_1">可同时使用</label>
								</div>
								<div>
									<input type="radio" id="rule_exchange_2" name="8" value=""/>
									<label for="rule_exchange_2">不可同时使用</label>
								</div>
							</div>
						</div>
						<div class="hotel_star">
							<div class="">时段限制</div>
							<div class="input_txt input_radio label_parent_w">
								<div>
									<input type="radio" id="interval_1" name="9" value=""/>
									<label for="interval_1">不限制</label>
								</div>
								<div>
									<input type="radio" id="interval_2" name="9" value=""/>
									<label for="interval_2" style="width:220px;background-size:9.6%;">全指向(前端日期必须全匹配)</label>
								</div>
								<div>
									<input type="radio" id="interval_3" name="9" value=""/>
									<label for="interval_3" style="width:220px;background-size:9.6%;">全指向(前端日期只需包含)</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_4caf50"></span>其他</div>
					<div class="con_right">
						<div class="hottel_name ">
							<div class="">代码排序</div>
							<div class="input_txt"><input type="text" /></div>
						</div>
						<div class="jingwei">
							<div class="">酒店状态</div>
							<div class="input_txt" >
								<select style="width:450px;">
									<option>有效</option>
									<option>无效</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="bg_fff" style="padding:15px;">
					<button class="fom_btn">保存酒店</button>
				</div>
			</from>
		</div>
	</div>
</div>

      <!-- Content Wrapper. Contains page content -->
  
<?php echo $this->session->show_put_msg(); ?>


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
<!--
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/ckeditor/ckeditor.js"></script>
-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/layDate.js"></script><script>
;!function(){
	laydate({
	   elem: '#datepicker'
	})
	laydate({
	   elem: '#datepicker2'
	})
	laydate({
	   elem: '#datepicker3'
	})
	laydate({
	   elem: '#datepicker4'
	})
}();
</script>
<script>
var data={};
function sub_code(){
	if($('#type').val()=='member'&&($('#member_level').val()==-1||$('#related_code').val()=='')){
		alert('会员类型价格必须设置关联价格代码和关联等级');
		return;
	}
	else if($('#type').val()=='protrol'&&$('#unlock_code').val()==''){
		alert('协议价格必须设置协议代码');
		return;
	}

	ranges=$("[key='key']");
	$.each(ranges,function(i,n){
		service=$(n).find('input[name="add_service"]');
		if(service.is(":checked")==true){
			data[service.val()]={};
			data[service.val()]['max_num']=$(n).find("[name='max_num']").val();
			data[service.val()]['service_price']=$(n).find("[name='service_price']").val();
		}
	});
	json=JSON.stringify(data);
	$('#service_data').val(json);
	$('#code_form').submit();
}
$(function () {
	//CKEDITOR.replace('el_gs_detail');
	// $(".wysihtml5").wysihtml5();
	// $('.date-pick').datepicker({
	// 	dateFormat: "yymmdd"
	// });
	// $('.datepicker').datepicker();
});
</script>
</body>
</html>
