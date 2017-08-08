<!-- DataTables -->
<link rel="stylesheet"
	href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/images/laydate.css">
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/images/laydate12.css">
</head>
<style>
.weborder {
	background: #FFFFFF !important;
	display: none;
}

.morder {
	background: #FAFAFA !important;
}

.a_like {
	cursor: pointer;
	color: #72afd2;
}

.page {
	text-align: right;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 2em;
}

.page a {
	padding: 10px;
}

.current {
	color: #000000;
}
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="modal fade" id="setModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">显示设置</h4>
      </div>
      <div class="modal-body">
        <div id='cfg_items'>
        <?php echo form_open('distribute/distri_report/save_cofigs','id="setting_form"')?>
        	
        </form></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="set_btn_save">保存</button>
      </div>
    </div><!-- /.modal-content -->
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
@font-face {
  font-family: 'iconfont';
  src: url('<?php echo base_url(FD_PUBLIC);?>/newfont/iconfont.eot');
  src: url('<?php echo base_url(FD_PUBLIC);?>/newfont/iconfont.eot?#iefix') format('embedded-opentype'),
  url('<?php echo base_url(FD_PUBLIC);?>/newfont/iconfont.woff') format('woff'),
  url('<?php echo base_url(FD_PUBLIC);?>/newfont/iconfont.ttf') format('truetype'),
  url('<?php echo base_url(FD_PUBLIC);?>/newfont/iconfont.svg#iconfont') format('svg');
}
.iconfont{
  font-family:"iconfont" !important;
  font-size:16px;font-style:normal;
  -webkit-font-smoothing: antialiased;
  -webkit-text-stroke-width: 0.2px;
  -moz-osx-font-smoothing: grayscale;
}
.over_x{width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-webkit-overflow-scrolling:touch;overflow-scrolling:touch;}
.clearfix:after{content:"" ;display:block;height:0;clear:both;visibility:hidden;}
.bg_fff{background:#fff;}
.color_fff{color:#fff;}
.bg_ff0000{background:#ff0000;}
.bg_f8f9fb{background:#f8f9fb;}
.bg_ff9900{background:#ff9900;}
.bg_e8eaee{background:#e8eaee;}
.bg_fe6464{background:#fe6464;}
.color_72afd2{color:#72afd2;}
.color_ff9900{color:#ff9900;}
.color_F99E12{color:#F99E12;}
a{color:#92a0ae;}

.border_1{border:1px solid #d7e0f1;}
.f_r{float:right;}
.p_0_20{padding:0 20px;}
.w_90{width:90px;}
.w_200{width:200px;}
.p_r_30{padding-right:30px;}
.m_t_10{margin-top:10px;}
.p_0_30_0_10{padding:0 30px 0 10px;}
.b_b_1{border-bottom:1px solid #d7e0f1;}
.b_t_1{border-top:1px solid #d7e0f1;}
.p_t_10{padding-top:10px;}
.p_b_10{padding-bottom:10px;}


.contents{padding:10px 0px 85px 20px;}
.contents_list{display:table;width:100%;border:1px solid #d7e0f1;margin-bottom:10px;}
.display_table{display:table;width:100%;}
.display_table >div{display:table-cell;width:125px;}
.display_table >div:nth-of-type(1){width:298px;}
.display_table >div:nth-of-type(7){width:182px;}
.head_cont{padding:20px 0 20px 10px;}
.head_cont >div{margin-bottom:10px;cursor:pointer;}
.head_cont >div:last-child{margin-bottom:0px;}
.h_btn_list .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;}
.h_btn_list> div{display:inline-block;width:100px;border:1px solid #d7e0f1;text-align:center;padding:6px 0px;border-radius:5px;margin-right:8px;}
.h_btn_list> div:last-child{margin-right:0px;}
.j_head >div{display:inline-block;}
.j_head >div:nth-of-type(1){width:307px;}
.j_head >div:nth-of-type(2){width:526px;}
.j_head >div:nth-of-type(3){width:255px;}
.j_head >div >span:nth-of-type(1){display:inline-block;width:60px;text-align:center;}
.classification{height:30px;line-height:30px;}
.classification >div{width:70px;display:inline-block;text-align:center;height:30px;}
.classification .add_active{border-bottom:3px solid #ff9900;}
.fomr_term{height:30px;line-height:30px;}
.classification >div,.all_open_order{cursor:pointer;}
.template >div{text-align:center;}
.template >div:nth-of-type(1){-webkit-flex:3.7;flex:3.7;text-align:left;padding-left:10px;}
.template >div:nth-of-type(2){-webkit-flex:1.2;flex:1.2;}
.template >div:nth-of-type(7){-webkit-flex:1.3;flex:1.3;}
.template_img{float:left;width:50px;height:50px;overflow:hidden;vertical-align:middle;margin-right:2%;}
.template_span{display:inline-block;margin-top:2px;}
.template_btn{padding:1px 8px;border-radius:3px;}
.temp_con >div >span{line-height:1.7;}
.room{width:52px;display:inline-block;}
.con_list > div:nth-child(odd){background:#fafcfb;}
.con_list{display:none;}

.drow_list{display:none;position:absolute;width:100%;top:100%;left:0;background:#fff;border:1px solid #e4e4e4;padding:0;overflow:auto;z-index:999}
.drow_list li{height:35px;padding-left:15px;line-height:35px;list-style:none; cursor:pointer}
.drow_list li:hover{background:#f1f1f1}
.drow_list li.cur{background:#ff9900;color:#fff}
#drowdown:hover .drow_list{display:block}
.fixed_box{position:fixed;top:36%;left:48%;z-index:9999;border:1px solid #d7e0f1;border-radius:5px;padding:1% 2%;display:none;}
.tile{font-size:15px;text-align:center;margin-bottom:4%;}
.f_b_con{font-size:13px;text-align:center;margin-bottom:8%;}
.confirms,.cancel{cursor:pointer;}
.pagination{margin-top:0px;margin-bottom:0px;}
.pages {
  float: right;
  margin: 20px 0;
}
.pages #Pagination {
  float: left;
  overflow: hidden;
}
.pages #Pagination .pagination {
  height: 40px;
  text-align: right;
  font-family: \u5b8b\u4f53,Arial;
}
.pages #Pagination .pagination a,
.pages #Pagination .pagination span {
  float: left;
  display: inline;
  padding: 11px 13px;
  border: 1px solid #e6e6e6;
  border-right: none;
  background: #f6f6f6;
  color: #666666;
  font-family: \u5b8b\u4f53,Arial;
  font-size: 14px;
  cursor: pointer;
}
.pages #Pagination .pagination .current {
  background: #ffac59;
  color: #fff;
}
.pages #Pagination .pagination .prev,
.pages #Pagination .pagination .next {
  float: left;
  padding: 11px 13px;
  border: 1px solid #e6e6e6;
  background: #f6f6f6;
  color: #666666;
  cursor: pointer;
}
.pages #Pagination .pagination .prev i,
.pages #Pagination .pagination .next i {
  display: inline-block;
  width: 4px;
  height: 11px;
  margin-right: 5px;
  background: url(icon.fw.png) no-repeat;
}
.pages #Pagination .pagination .prev {
  border-right: none;
}
.pages #Pagination .pagination .prev i {
  background-position: -144px -1px;
  *background-position: -144px -4px;
}
.pages #Pagination .pagination .next i {
  background-position: -156px -1px;
  *background-position: -156px -4px;
}
.pages #Pagination .pagination .pagination-break {
  padding: 11px 5px;
  border: none;
  border-left: 1px solid #e6e6e6;
  background: none;
  cursor: default;
}

</style>
<div class="fixed_box bg_fff">
	<div class="tile">订单修改确认</div>
	<div class="f_b_con">确认要将当前订单状态修改为“入住”状态？</div>
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
	                            <input placeholder="选择或输入关键字" type="text" style="color:#92a0ae;" class="form-control w_200 moba" id="search_hotel" value="<?php if(!empty($allhotels)){
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
									<?php foreach ($pay_type as $kp => $vp) {?>
                                	<option value="<?php echo $kp;?>" <?php if($kp==$paytype) echo 'selected';?>><?php echo $vp;?></option>
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
								$('#this_form').submit();
							});
						});
						</script>
						<!-- <div>批量导出</div> -->
						<!-- <div>显示设置</div> -->
					</div>
				</div>
				</form>
				<div class="contents_list bg_fff" style="font-size:13px;">
					<div class="p_r_30 classification b_b_1">
						<span class="f_r all_open_order">展开订单</span>
						<?php foreach ($show_status as $k => $v) {?>
						<div class="<?php if($istatus==$k){echo 'add_active';}?>"><a href="<?php echo site_url('hotel_2/orders/index?s='.$k);?>"><?php echo $v['des'];?></a></div>
						<?php }?>
					</div>
					<div class="bg_f8f9fb display_table fomr_term template">
						<div>酒店&房型</div>
						<div>实付金额&房数</div>
						<div>券&积分</div>
						<div>客户信息</div>
						<div>下单时间</div>
						<div>支付状态</div>
						<div>订单状态</div>
						<div>操作</div>
					</div>
				</div>
				<?php if(!empty($lists)){ foreach($lists as $k => $list){?>
				<div class="border_1 m_t_10 bg_fff">
					<div class="bg_f8f9fb fomr_term p_0_30_0_10 b_b_1">
						<a href="<?php echo site_url('hotel_2/orders/edit?ids='.$list['id'].'&h='.$list['hotel_id']);?>" class="f_r color_F99E12">订单详情</a>
						<div>订单号：<?php echo $list['orderid'];?></div>
					</div>
					<div class="display_table temp_con template p_t_10 p_b_10">
						<div class="clearfix">
							<img class="template_img" src="<?php echo $list['order_details'][0]['r_room_img'];?>">
							<span class="template_span"><?php echo $list['hname_rname'];?></span><br>
							<span>入离：<?php echo date('Y.m.d',strtotime($list['startdate']));?>-<?php echo date('Y.m.d',strtotime($list['enddate']));?></span>
						</div>
						<div>
							<span><?php echo $list['price'];?></span><br>
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
						<div>
							<span><?php echo $list['status'];?></span><br>
							<?php if(empty($list['no_status'])){?> 							
							<?php if(!empty($list['opt_status'])){foreach ($list['opt_status'] as $k => $val) {?>
							<span class="bg_<?php echo $val['bg_color'];?> color_fff template_btn" sid="<?php echo $k;?>" oid="<?php echo $list['orderid'];?>"><?php echo $val['text'];?></span>
							<?php }}?>
							<?php }else {?><span>--&nbsp;</span><?php }?>
						</div>
						<div>
							<span class="color_72afd2"><a href="<?php echo site_url('hotel_2/orders/edit?ids='.$list['id'].'&h='.$list['hotel_id']).'&print=1';?>">打印订单</a></span><br>
							<span class="color_72afd2 open_order">展开订单</span>
						</div>
					</div>
					<div class="con_list">
					<?php if(!empty($list['order_details'])){ foreach ($list['order_details'] as $kod => $vod) {?>
						<div  class="display_table temp_con template p_t_10 p_b_10 b_t_1">
							<div class="clearfix">
								<span class="room">房间<?php echo $kod+1;?></span>
								<span><?php echo $vod['roomname'];?>-<?php echo $vod['price_code_name'];?></span>
							</div>
							<div>
								<span><?php echo $vod['iprice'];?></span>
							</div>
							<div>
								<span><?php echo $list['coupon_used'];?></span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span class=""><?php echo $vod['istatus'];?></span>
								<?php if(empty($list['no_item_status'])&&empty($vod['no_item_status'])){?>
								<?php if(!empty($vod['item_opt_status'])){foreach ($vod['item_opt_status'] as $k => $val) {?>
								<span class="bg_<?php echo $val['bg_color'];?> color_fff border_1 template_btn" sid="<?php echo $k;?>" oid="<?php echo $list['orderid'];?>" iid="<?php echo $vod['id'];?>"><?php echo $val['text'];?></span>
								<?php }}?>
							<?php }else {?><span>-</span><?php }?>
							</div>
							<div>
								<span><a href="<?php echo site_url('hotel_2/orders/item_edit_new?oid='.$list['orderid'].'&h='.$list['hotel_id'].'&item='.$vod['id']);?>" class=" color_F99E12">子订单详情</a></span>
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
	$('.template_btn').click(function(){
		if(bool){
			bool=false;
			$('.fixed_box').fadeIn();
			$('.f_b_con').html('确认要将当前订单状态修改为“'+$(this).html()+'”状态？');
			obj = $(this);
		}
	});
	$('.cancel').click(function(){
		bool=true;
		$('.fixed_box').fadeOut();
	});
	$('.confirms').click(function(){
		bool=true;
		change_status(obj);
		$('.fixed_box').fadeOut();
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
		$(this).parent().parent().next().slideToggle();
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
function show_detail(obj){
	$('#status_detail').html('');
	$('#myModalLabel').html('单号：');
	var temp='';
	orderid='';
	$.get('<?php echo site_url('hotel/orders/order_status')?>',{
		oid:$(obj).attr('oid'),
		hotel:$(obj).attr('h')
	},function(data){
		orderid=data.order.orderid;
		if(data.after!=''){
			temp+='<select id="after_status">';
			$.each(data.after,function(i,n){
				if(i!=4)
					temp+='<option value="'+i+'">'+n+'</option>';		
			});
			temp+='</select>';
		}else{
			temp+=data.order.status_des;
			orderid='';
		}
		$('#status_detail').html(temp);
		$('#myModalLabel').append(data.order.orderid);
	},'json');
}
function slidesub(id){
	chose="[name='"+'weborder'+id+"']";
	if($(chose).css("display")=='table-row'){
		$(chose).css("display",'none');
	}
	else{
		$(chose).css("display",'table-row');
	}
}
$('#grid-btn-set').click(function(){
	var str = '<input type="hidden" name="<?php echo $this->security->get_csrf_token_name ();?>" value="<?php echo $this->security->get_csrf_hash ();?>" style="display:none;">';
	$.getJSON('<?php echo site_url("hotel/orders/get_cofigs?ctyp=ORDERS_STATUS_HOTEL")?>',function(data){
		$.each(data,function(k,v){
			str += '<div class="checkbox"><label><input type="checkbox" name="' + k + '"';
			if(v.must == 1){
				str += ' disabled checked ';
			}else if(v.choose == 1){
				str += ' checked ';
			}
			str += '>' + v.name + '</label></div>';
		});
		$('#setting_form').html(str);
	});

});
$('#set_btn_save').click(function(){
	$.post('<?php echo site_url("hotel/orders/save_cofigs?ctyp=ORDERS_STATUS_HOTEL")?>',$("#setting_form").serialize(),function(data){
		if(data == 'success'){
			window.location.reload();
		}else{
			alert('保存失败');
		}
	});
});
<!--改变订单状态-->
function change_status(obj){
	var sid = $(obj).attr('sid');
	var orderid = $(obj).attr('oid');
	var item_id = '';
	if($(obj).attr('iid')){
		item_id = $(obj).attr('iid')
	}
	if(orderid){
		$.get('<?php echo site_url('hotel_2/orders/update_order_status');?>',{
			oid:orderid,
			status:sid,
			item_id:item_id
		},function(data){
			$('.fixed_box').fadeOut();
			if(data==1){
				alert('修改成功');
				location.reload();
			}else{
				alert('修改失败');
			}
		});
	}
}
</script>
</body>
</html>
