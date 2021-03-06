<!-- DataTables -->
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
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
.classification >div{min-width:100px;display:inline-block;text-align:center;height:30px;}
.classification .add_active{border-bottom:3px solid #ff9900;}
.fomr_term{height:30px;line-height:30px;}
.classification >div,.all_open_order{cursor:pointer;}
.template >div{text-align:center;}
.template >div:nth-of-type(1){text-align:left;padding-left:10px;}
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
table{text-align:center;width:100%;font-size:12px;color:#92a0ae;border:1px solid #d7e0f1}
table td{padding:5px 0; position:relative}
td[colspan]{text-align:left}
tr:nth-child(odd){ background:#f8f9fb}
input{outline:none}
.detail{ position:absolute; width:auto; padding:10px; background:#fff;border:1px solid #d7e0f1; right:0; top:90%; display:none; text-align:left; font-size:11px; z-index:999; white-space:nowrap;}
table td:hover .detail{ display:block;animation: fadein 0.2s;-moz-animation: fadein 0.2s;	/* Firefox */-webkit-animation: fadein 0.2s;	/* Safari 和 Chrome */-o-animation: fadein 0.2s;	/* Opera */}
table td i{ font-size:10px; vertical-align:top}
@keyframes fadein{from{ opacity:0.2}to{ opacity:1}}
@-moz-keyframes fadein /* Firefox */{from{ opacity:0.2}to{ opacity:1}}
@-webkit-keyframes fadein /* Safari 和 Chrome */{from{ opacity:0.2}to{ opacity:1}}
@-o-keyframes fadein /* Opera */{from{ opacity:0.2}to{ opacity:1}}
</style>
<div class="fixed_box bg_fff">
	<div class="tile">修改确认</div>
	<div id="real_price"><div style="margin:8px 0">实际开票金额：</div><input type="" name="real_price" style="margin-bottom:8px; width:100%"></div>
	<div><div style="margin:8px 0">备注：</div><input type="" name="remark" style="margin-bottom:8px; width:100%"></div>
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
				<form class="form" method='get' id="this_form" action=''>
				<div class="head_cont contents_list bg_fff">
                    <div>
                        <label>请选择酒店</label>
					    <select id="hotel" onchange="get_rooms(this)" name="hotel">
					    <option value="0"<?php if($hotel_id == 0):?> selected<?php endif;?>>全部酒店</option>
					    <?php foreach ($hotels as $hotel):?><option value="<?=$hotel['hotel_id']?>"<?php if($hotel_id == $hotel['hotel_id']):?> selected<?php endif;?>><?=$hotel['name']?></option><?php endforeach;?>
					    </select>
					    <?php if(count($hotels)>10){?>
					     <div style='margin-top: 5px;'>
					    	<input type="text" name="qhs" id="qhs" placeholder="快捷查询">
					 	  	<input type="button" onclick='quick_search()' value='查询' />
					 	  	<input type="button" onclick='go_hotel("next")' value='下一个' />
					 	  	<input type="button" onclick='go_hotel("prev")' value='上一个' />
					 	  	<span id='search_tip' style='color:red'></span>
					    </div>
					    <?php }?>
                    </div>
                    <div>
                        <span>关键字&nbsp;&nbsp;&nbsp;</span>
                        <span><input style="width: 200px;" type="text" name="keywords" value="<?php if(isset($keywords)) echo $keywords; ?>" placeholder="客户姓名/手机号/订单号"/></span>
                    </div>
					<div  class="h_btn_list" style="margin-top:30px;">
						<div class="actives" id='subbtn'>筛选</div>
					</div>
				</div>
				</form>
				<div class="contents_list bg_fff" style="font-size:13px;">
					<div class="p_r_30 classification">
						<!--span class="f_r all_open_order">展开订单</span-->
						<div val="wait" <?php if($status=='wait') echo 'class="add_active"'; ?>> 待处理（<?php echo $div['wait']?>）</div>
						<div val="wechat" <?php if($status=='wechat') echo 'class="add_active"'; ?>>微信订单退房（<?php echo $div['wechat']?>） </div>
						<div val="scan" <?php if($status=='scan') echo 'class="add_active"'; ?>>扫码退房（<?php echo $div['scan']?>） </div>
						<div  val="" <?php if($status=='') echo 'class="add_active"'; ?>>全部（<?php echo $div['all']?>） </div>
					</div>
				</div>
				<table class="m_t_10 bg_fff">
					<tr>
						<td>渠道&amp;订单号</td>
						<td>酒店&amp;入离</td>
						<td>房型&amp;房号</td>
						<td>客户信息</td>
						<td>金额&amp;价格代码</td>
						<td>支付状态</td>
						<td>预约退房</td>
						<td>预约提交</td>
						<td>处理完成</td>
                        <td>发票</td>
                        <td>实际金额</td>
                        <td>备注</td>
						<td>操作状态</td>
					</tr>
                    <?php if(!empty($list)){ foreach($list as $lt){ ?>
						<tr>
							<td>
								<span><?php echo $channel[$lt['channel']]?></span><br>
	                            <span><?php if(isset($lt['orderid'])) echo $lt['orderid']?></span>
							</td>
							<td>
								<span class="template_span"><?php if(isset($lt['hotel_name'])) echo $lt['hotel_name']?></span><br>
								<span><?php if(isset($lt['startdate']) && isset($lt['enddate'])) echo substr($lt['startdate'],4,4).'-'.substr($lt['enddate'],4,4);?></span>
							</td>
							<td>
								<span><?php if(isset($lt['room_name'])) echo $lt['room_name']?></span><br>
								<span><?php echo $lt['room_num']?></span>
							</td>
							<td>
								<span><?php echo $lt['oname']?></span><br>
								<span><?php echo $lt['tel']?></span>
							</td>
							<td>
								<span class="color_ff9900"><?php if(isset($lt['oprice'])) echo '￥'.$lt['oprice']?></span><br>
								<span><?php if(isset($lt['price_name'])) echo $lt['price_name']?></span>
							</td>
							<td>
								<span><?php if(isset($lt['paytype'])) echo $lt['paytype']?></span><br>
								<span class="color_ff9900"><?php if(isset($lt['is_paid'])) echo $lt['is_paid']?></span>
							</td>
							<td>
								<span><?php echo substr($lt['check_out_time'],0,10)?></span><br>
								<span><?php echo substr($lt['check_out_time'],11,5)?></span>
							</td>
							<td>
								<span><?php echo substr($lt['create_time'],0,10)?></span><br>
								<span><?php echo substr($lt['create_time'],11,5)?></span>
							</td>
							<td>
								<span><?php if($lt['done_time']!='0000-00-00 00:00:00') echo substr($lt['done_time'],0,10)?></span><br>
								<span><?php if($lt['done_time']!='0000-00-00 00:00:00') echo substr($lt['done_time'],11,5)?></span>
							</td>
							<td style="cursor:help;width: 200px;">
                            	<?php if($lt['invoice_list_id']>0){?>
								<span><?php echo $lt['itype'].' - ￥'.$lt['amount']?></span><br>
								<span style="display:block;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;width: 200px;"><?php if(isset($lt['title'])) echo $lt['title'].' <i class="fa fa-question-circle"></i>'?> </span>
                                <div class="detail">
                                	<p>类型：<?php echo $lt['itype']?></p>
                                    <p>抬头：<?php echo $lt['invoice_content']['title']?></p>
                                    <p>纳税人识别号：<?php if(isset($lt['invoice_content']['code'])) echo $lt['invoice_content']['code']?></p>
                                	<?php if($lt['type'] == 2){?>
                                    <p>注册地址：<?php if(isset($lt['invoice_content']['address'])) echo $lt['invoice_content']['address']?></p>
                                    <p>公司电话：<?php if(isset($lt['invoice_content']['phonecall'])) echo $lt['invoice_content']['phonecall']?></p>
                                    <p>银行：<?php if(isset($lt['invoice_content']['bank'])) echo $lt['invoice_content']['bank']?></p>
                                    <p>银行账号：<?php if(isset($lt['invoice_content']['account'])) echo $lt['invoice_content']['account']?></p>
                               	 	<?php }?>
                                    <p>备注：<?php if(isset($lt['invoice_content']['remark'])) echo $lt['invoice_content']['remark']?></p>
                                 </div>
                                 <?php }else{?>不需要发票<?php }?>
							</td>
							<td><?php echo $lt['realprice']?></td>
							<td><?php echo $lt['remark']?></td>
							<td>
							<?php if($lt['status']==1){?>
								已完成
							<?php }else{?>
								<a href="javascript:;" class="color_72afd2" sid="<?php echo $lt['check_out_id'];?>" price="<?php echo $lt['amount'];?>" invoice_list_id="<?php echo $lt['invoice_list_id'];?>">操作</a>
							<?php }?>
							</td>
						</tr>
                    <?php }}else{?>
                    	<tr><td style="text-align:center" colspan="100">暂无数据</td></tr>
                    <?php }?>
				</table>
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

<script>
$(function(){
	var bool=true;
	var obj=null;
	var dbool = true;
	$('.color_72afd2').click(function(){
		if(bool){
			bool=false;
			obj = $(this);
			$("[name='real_price']").val(obj.attr('price'));
			var invoice_list_id = parseInt(obj.attr('invoice_list_id'));
			if(invoice_list_id<1){
				$("#real_price").hide();
			}else{
				$("#real_price").show();
			}
			$('.fixed_box').fadeIn();
		}
	});
	$('.cancel').click(function(){
		bool=true;
		$('.fixed_box').fadeOut();
	});
	$('.confirms').click(function(){
		if(dbool){
			dbool = false;
			change_status(obj);
		}
	});
    $('.drow_list li').click(function(){
        $('#search_hotel').val($(this).text());
        $('#search_hotel_h').val($(this).val());
        $(this).addClass('cur').siblings().removeClass('cur');
    });
	$('.classification >div').click(function(){
		$(this).addClass('add_active').siblings().removeClass('add_active');
		search();
	})

	
	$("#subbtn").click(function(){
		search();
	});
})


function slidesub(id){
	chose="[name='"+'weborder'+id+"']";
	if($(chose).css("display")=='table-row'){
		$(chose).css("display",'none');
	}
	else{
		$(chose).css("display",'table-row');
	}
}

$('#set_btn_save').click(function(){
	$.post('<?php echo site_url("hotel/orders/save_cofigs?ctyp=ORDERS_STATUS_HOTEL")?>',$("#setting_form").serialize(),function(data){
		if(data == 'success'){
			window.location.reload();
		}else{
			alert('保存失败');
		}
	});
});
<!--改变子订单状态-->
function change_status(obj){
	var cid = obj.attr('sid');
	var real_price = $("[name='real_price']").val();
	var	remark = $("[name='remark']").val();
	var csrf_token = '<?php echo $this->security->get_csrf_hash ();?>';
	if(cid){
		$.post('<?php echo site_url('hotel/checkout/edit_post');?>',{
			cid:cid,
			real_price:real_price,
			remark:remark,
			<?php echo $this->security->get_csrf_token_name ();?>:csrf_token,
		},function(data){
			if(data=='success'){
				location.reload();
				// $('.fixed_box').fadeOut();
				// obj.parent().prev().html(remark);
				// obj.parent().html('已完成');
			}else{
				alert('修改失败');
			}
			dbool=true;
		});
	}
}
var search_index=0;
function quick_search() {
	var hk=$('#qhs').val();
	if(hk){
		$('#search_tip').html('');
		options=$('#hotel option');
		search_index=0;
		$.each(options,function(i,n){
			$(n).css('color','#555');
			$(n).removeAttr('be_search');
			if(n.innerHTML.indexOf(hk)>-1){
				search_index++;
				$(n).css('color','red');
				$(n).attr('be_search',search_index);
				if(search_index==1){
					n.selected=true;
				}
			}
		});
		if(search_index==0){
			$('#search_tip').html('无结果');
		}
	}
}; 
function go_hotel(direction){
	selected_option=$('#hotel').find('option:selected');
	selected_option=selected_option[0];
	now_index=$(selected_option).attr('be_search');
	if(now_index){
		search_index=now_index;
	}
	if(search_index){
		if(direction=='next'){
			search_index++;
		}else{
			search_index--;
		}
	}
	if(search_index){
		option=$('#hotel>option[be_search="'+search_index+'"]');
		if(option[0]!=undefined){
			option=option[0];
			option.selected=true;
		}
	}
}
function search(){
	var hotel_id = $('#hotel').val();
	var keywords = $("[name='keywords']").val();
	if(keywords == undefined){
		keywords = '';
	}
	var status = $('.add_active').attr('val');
	window.location.href = "<?php echo site_url('hotel/checkout/index');?>"+'?h='+hotel_id+'&k='+keywords+'&s='+status;
	return false;
}
</script>
</body>
</html>
