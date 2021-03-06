<!-- DataTables -->
<link rel="stylesheet"
	href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/new/new.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="modal fade" id="setModal">
  <div class="modal-dialog">
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="wrapper">

<?php
/* 顶部导航 */
echo $block_top;
?>

<?php
/* 左栏菜单 */
echo $block_left;
?>
<style>
.w_350{width:350px !important;}
.w_180{width:180px !important;}
.template >div:first-child{text-align:left;padding-left:5px;}
.classification{height:30px;line-height:30px;width: 100%;}
.classification >div{display:inline-block;text-align:center;height:30px;border-right:none;padding:0 10px;}
.classification .add_active{border-bottom:3px solid #ff9900;}
.classification >div,.all_open_order{cursor:pointer;}
.display_table{display:table;width:100%;}
.display_table >div{display:table-cell;width:120px;}
.temp_con >div >span{line-height:1.7;}
.room{width:52px;display:inline-block;}
#setting_form div input{height:auto;}
.packagetips {font-size: 10px;text-align: center;margin-bottom: 8%;width: 260px;color:red;}
.pad_l15{padding-left: 15px;}
</style>
<div class="fixed_box bg_fff">
	<div class="tile">订单处理</div>
	<div class="f_b_con">当前订单状态修改为：已入住</div>
	<div class="packagetips">套餐的商品需要去订单详情核销哦</div>
	<div id="mt_orderid_div" style="font-size: 13px;text-align: center;margin-bottom: 8%;width: 260px;">pms单号：<input type="text" value="" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" id="mt_orderid" /></div>
	<div class="h_btn_list clearfix" style="">
		<div class="actives confirms">确认</div>
		<div class="cancel f_r">取消</div>
	</div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;">
            <div class="banner bg_fff p_0_20">
                <?php echo $breadcrumb_html; ?>
            </div>
            <div class="contents">
				<form class="form" method='get' id="this_form" action='<?php echo $search_url;?>'>
				<div class="head_cont contents_list bg_fff">
					<div class="j_head">
						<div>
							<span>酒店名称</span>
							<span class="input-group w_200" style="position:relative;display:inline-flex;" id="drowdown">
	                            <input placeholder="选择或输入关键字" name="hotel_name" type="text" style="color:#92a0ae;" class="w_200 moba" id="search_hotel" value="<?php if(!empty($allhotels)){
	                            		$hotels = array();
	                            		foreach ($allhotels as $va) {
	                            			$hotels[$va['hotel_id']] = $va['name'];
	                            		}
	                            		if(!empty($hotels[$hotel])) echo $hotels[$hotel];
	                            	}?>">
	                            <input name="hotel" type="hidden" id="search_hotel_h" value="<?php echo $hotel;?>">
	                            <ul class="drow_list">
                            		<?php foreach ($allhotels as $kh => $vh) {?>
                                	<li value="<?php echo $vh['hotel_id'];?>"><?php echo $vh['name'];?></li>
                                	<?php }?>
	                            </ul>
                            </span>
						</div>
						<div>
							<span>时间筛选</span>
							<select class="w_90" name="timetype">
								<?php foreach ($time_type as $kt => $vt) {?>
                            	<option value="<?php echo $kt;?>" <?php if($kt==$timetype) echo 'selected';?>><?php echo $vt;?></option>
                               	<?php }?>
							</select>
							<span class="t_time"><input name="start_t" type="text" id="datepicker" class="datepicker moba" value="<?php echo $start_t;?>"></span>
                            <font>至</font>
                            <span class="t_time"><input name="end_t" type="text" id="datepicker2" class="datepicker moba" value="<?php echo $end_t;?>"></span>
						</div>
						<div>
							<span>关键字</span>
							<span><input style="width: 170px;" type="text" name="number" value="<?php echo $number;?>" placeholder="客户姓名/手机号/订单号"/></span>
						</div>
					</div>
					<div class="j_head">
						<div>
							<span>支付方式</span>
							<span>
								<select  class="w_90" name="paytype">
                                	<option value="-1">全部</option>
									<?php foreach ($pay_ways as $kp => $vp) {?>
                                	<option value="<?php echo $kp;?>" <?php if($kp==$paytype) echo 'selected';?>><?php echo $vp->pay_name;?></option>
                                    <?php }?>
                                </select>
							</span>
						</div>
						<div>
							<span>支付状态</span>
							<span>
								<select class="w_90" name="paystatus">
                                	<option value="-1">全部</option>
                                	<?php foreach ($pay_status as $ks => $vs) {?>
                                	<option value="<?php echo $ks;?>" <?php if($ks==$paystatus) echo 'selected';?>><?php echo $vs;?></option>
                                    <?php }?>
                                </select>
							</span>
						</div>
						<div>
							<span>订单状态</span>
							<span>
								<select name="orderstatus">
                                	<option value="-1">全部</option>
                                	<?php foreach ($order_status as $ko => $vo) {?>
                                	<option value="<?php echo $ko;?>" <?php if($ko==$orderstatus) echo 'selected';?>><?php echo $vo;?></option>
                                	<?php }?>
                                </select>
							</span>
						</div>
					</div>
					<div  class="h_btn_list" style="">
						<div class="actives" id='subbtn'>筛选</div>
						<script type="text/javascript">
						$(function(){
							$('#subbtn').click(function(){
								if($('#search_hotel').val()==''){
							        $('#search_hotel_h').val('');
								}
								$('#this_form').submit();
							});
						});
						</script>
					</div>
				</div>
				</form>
				<div class="contents_list bg_fff" style="font-size:13px;">
					<div class="p_r_30 classification b_b_1">
						<span class="f_r all_open_order">展开订单</span>
						<?php foreach ($show_status as $k => $v) {?>
						<div class="<?php if($istatus==$k){echo 'add_active';}?>"><a href="<?php echo site_url('hotel/orders/index?s='.$k);?>"><?php echo $v['des'];?><font>(<?php echo $v['count'];?>)</font></a></div>
						<?php }?>
					</div>
					<div class="bg_f8f9fb display_table fomr_term template">
						<div class="w_350">酒店&房型</div>
						<div>实付金额&房数</div>
						<div>券&积分</div>
						<div>客户信息</div>
						<div>下单时间</div>
						<div>支付状态</div>
						<div class="w_180">订单状态/修改</div>
						<div>操作</div>
					</div>
				</div>
				<?php if(!empty($lists)){ foreach($lists as $k => $list){?>
				<div class="border_1 m_t_10 bg_fff" is_package="<?php echo $list['is_package']; ?>">
					<div class="bg_f8f9fb fomr_term p_0_30_0_10 b_b_1 pad_l15">
						<!-- <a href="<?php echo site_url('hotel/orders/edit?ids='.$list['id'].'&h='.$list['hotel_id']);?>" class="f_r color_F99E12">订单详情</a> -->
						<div>订单号：<?php echo $list['show_orderid'];?><?php if($list['is_package']){?><font color="red">(套餐)</font><?php }?></div>
					</div>
					<div class="display_table temp_con template p_t_10 p_b_10">
						<div class="clearfix w_350">
							<span class="template_span p_0_30_0_10"><?php echo $list['hname_rname'];?></span><br>
							<span class="p_0_30_0_10">入离：<?php echo date('Y.m.d',strtotime($list['startdate']));?>-<?php echo date('Y.m.d',strtotime($list['enddate']));?></span>
						</div>
						<div>
							<span><?php echo $list['real_price'];?></span><br>
							<span><?php echo $list['roomnums'];?>间房</span>
						</div>
						<div>
							<span><?php echo $list['coupon_favour'];?></span><br>
							<span><?php echo $list['point_favour'];?></span>
						</div>
						<div>
							<span><?php echo $list['name'];?></span><br>
							<span><?php echo $list['tel'];?></span>
						</div>
						<div>
							<span><?php echo date('Y.m.d',$list['order_time']);?></span><br>
							<span><?php echo date('H:i:s',$list['order_time']);?></span>
						</div>
						<div>
							<span><?php echo $list['paytype'];?></span><br>
							<span class="color_ff9900"><?php echo $list['is_paid'];?></span>
						</div>
						<div class="w_180">
							当前状态：<span><?php echo $list['status'];?></span><br>
							<?php if(empty($list['no_status'])){?>
							<?php if(!empty($list['opt_status'])){foreach ($list['opt_status'] as $k => $val) {?>
							<button class="bg_<?php echo $val['bg_color'];?> color_fff template_btn" sid="<?php echo $k;?>" oid="<?php echo $list['orderid'];?>" <?php if (!empty($val['oper_mt_orderid'])){?>oper_mt_orderid="1"<?php }?>><?php echo $val['text'];?></button>
							<?php }}?>
							<?php }else {?><span>--&nbsp;</span><?php }?>
						</div>
						<div>
							<span class="color_72afd2"><a href="<?php echo site_url('hotel/orders/edit?ids='.$list['id'].'&h='.$list['hotel_id']).'&print=1';?>">订单详情</a></span><br>
							<span class="color_72afd2 open_order pointer">展开订单</span>
						</div>
					</div>
					<?php if(!empty($list['customer_remark'])) echo '<div class="pad_l15">用户备注：'.$list['customer_remark'].'</div>';?>
					<div class="con_list" is_package="<?php echo $list['is_package']; ?>">
					<?php if(!empty($list['order_details'])){ foreach ($list['order_details'] as $kod => $vod) {?>
						<div  class="display_table temp_con template p_t_10 p_b_10 b_t_1">
							<div class="clearfix w_350">
								<span class="room">房间<?php echo $kod+1;?></span>
								<span><?php echo $vod['roomname'];?>-<?php echo $vod['price_code_name'];?></span>
							</div>
							<div>
								<span><?php echo $vod['iprice'];?></span>
							</div>
							<div>
								<span></span>
							</div>
							<div>
								<span><?php if(isset($vod['customer']))echo $vod['customer']; ?></span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div  class="w_180">
								当前状态：<span class=""><?php echo $vod['istatus'];?></span><br>
								<?php if(empty($list['no_item_status'])&&empty($vod['no_item_status'])){?>
								<?php if(!empty($vod['item_opt_status'])){foreach ($vod['item_opt_status'] as $k => $val) {?>
								<button class="bg_<?php echo $val['bg_color'];?> color_fff template_btn" sid="<?php echo $k;?>" oid="<?php echo $list['orderid'];?>" iid="<?php echo $vod['id'];?>"><?php echo $val['text'];?></button>
								<?php }}?>
							<?php }else {?><span>-</span><?php }?>
							</div>
							<div>
							<?php if($vod ['istatus'] != '待确认'){?>
								<span><a href="<?php echo site_url('hotel/orders/item_edit_new?oid='.$list['orderid'].'&h='.$list['hotel_id'].'&item='.$vod['id']);?>" class=" color_F99E12">子订单详情</a></span>
							<?php }?>
							</div>
						</div>
						<?php }}?>
					</div>
				</div>
				<?php }}?>
			<div class="pages">
			<div id="Pagination">
				<div class="pagination">
				<?php echo $pagination;?>
				</div>
			</div>
			</div>
			</div>
        </div>
    </div>
</div>
<?php
/* Footer Block @see footer.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'footer.php';
?>

<?php
/* Right Block @see right.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'right.php';
?>



<?php
/* Right Block @see right.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'commonjs.php';
?>
<!--日历调用开始-->
<!-- <script src="<?php echo base_url(FD_PUBLIC);?>/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC).'/'.$tpl;?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC).'/'.$tpl;?>/plugins/datatables/dataTables.bootstrap.min.js"></script> -->
<script src="<?php echo base_url(FD_PUBLIC).'/'.$tpl;?>/plugins/datatables/layDate.js"></script>
<!--日历调用结束-->
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
<script>
$(function(){
	var bool=true;
	var obj=null;
	var dbool = true;
	$('.template_btn').click(function(){
		if(bool){
			bool=false;
			$('.fixed_box').fadeIn();
			$('.f_b_con').html('当前订单状态修改为：<b>'+$(this).html().replace('操作','')+'</b>');
			obj = $(this);
			if((obj.parent().parent().parent('.border_1').attr('is_package') == 1 || obj.parent().parent().parent('.con_list').attr('is_package') == 1) && $(this).html().replace('操作','')=='入住'){
				$('.packagetips').show();
			}else{
				$('.packagetips').hide();
			}
			$('#mt_orderid').val('');
			if(!obj.attr('oper_mt_orderid')){
				$('#mt_orderid_div').hide();
			}else{
				$('#mt_orderid_div').show();
			}
		}
	});
	$('.cancel').click(function(){
		bool=true;
		$('.fixed_box').fadeOut();
	});
	$('.confirms').click(function(){
		if(dbool){
			dbool = false;
			if(obj.attr('iid')){
				change_item_status(obj);
			}else{
				change_status(obj);
			}
		}
	});
    $('.drow_list li').click(function(){
        $('#search_hotel').val($(this).text());
        $('#search_hotel_h').val($(this).val());
        $(this).addClass('cur').siblings().removeClass('cur');
    });
	$('.classification >div').click(function(){
		$(this).addClass('add_active').siblings().removeClass('add_active');
	})
	$('.open_order').click(function(){
		$(this).parent().parent().parent().find('.con_list').slideToggle();
	})
	$('.all_open_order').click(function(){
		$('.con_list').slideToggle();
	})
	<!--日历调用-->
	// $('.datepicker').datepicker({
	// 	dateFormat: "yymmdd"
	// });
	var tips=$('#tips');
	$('.btn_o').click(function(){
		//console.log( decodeURIComponent($(".form").serialize(),true));
		start=$('.t_time').find('input[name="start_t"]').val().replace(/-/g,'');
		end=$('.t_time').find('input[name="end_t"]').val().replace(/-/g,'');
		if(start!=''&&start!=undefined){
			if(isNaN(start)){
				tips.html('开始日期错误');
				setout(tips);
				return false;
			}
			if(end!=''&&end!=undefined){
				if(isNaN(end)||end<start){
					tips.html('结束日期错误或大于开始日期');
					setout(tips);
					return false;
				}
			}
		}
	})
})
function setout(obj){
	setTimeout(function(){
		obj.fadeOut();
	},2000)
}
var orderid='';

<!--改变主订单状态-->
function change_status(obj){
	var sid = $(obj).attr('sid');
	var orderid = $(obj).attr('oid');
	if(orderid){
		var mt_orderid='';
		if(obj.attr('oper_mt_orderid')){
			mt_orderid=$('#mt_orderid').val();
			mt_orderid=mt_orderid.replace(/[^\w\.\/]/ig,'');
		}
		$.get('<?php echo site_url('hotel/orders/update_order_status');?>',{
			oid:orderid,
			status:sid,
			mt_orderid:mt_orderid
		},function(data){
			if(data==1){
				alert('修改成功');
				location.reload();
			}else{
				alert('修改失败');
			}
			dbool=true;
			$('.fixed_box').fadeOut();
		});
	}
}
<!--改变子订单状态-->
function change_item_status(obj){
	var sid = $(obj).attr('sid');
	var orderid = $(obj).attr('oid');
	var	item_id = $(obj).attr('iid');
	var csrf_token = '<?php echo $this->security->get_csrf_hash ();?>';
	if(orderid&&item_id){
		$.post('<?php echo site_url('hotel/orders/item_edit_post');?>',{
			orderid:orderid,
			istatus:sid,
			item_id:item_id,
			ajax:1,
			<?php echo $this->security->get_csrf_token_name ();?>:csrf_token,
		},function(data){
			if(data=='success'){
				alert('修改成功');
				location.reload();
			}else{
				alert('修改失败');
			}
			dbool=true;
			$('.fixed_box').fadeOut();
		});
	}
}
</script>
</body>
</html>