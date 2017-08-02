<!-- DataTables -->
<link rel="stylesheet"
	href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
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

      <!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
            <style>
            .actives{border-bottom:3px solid #ff9900 !important;}
			.nav{font-size:2rem;border-bottom:0px;}
			.nav >li{margin-right:20px;cursor:pointer;position:relative;}
			.nav >li font{font-size:1rem;color:#ff0000;}
			.t_time{width:130px;}
			.list_o{line-height:1.5;margin-top:16px;}
			.list_o span{display:inline-block;font-size:1.5rem;}
			.list_o span >input{height:24px;}
			.list_o >span:first-child{width:100px;}
			.btn_o{margin-left:100px;background:#f3f3f3;border:1px solid #999;padding:2px 30px;margin-right:20px;}
			.number{width:220px;}
			.c_time,.n_i_number{width:100%;}
			.di_in_block{display:inline-block;margin-left:50px;}
			.prompt_txt{font-size:12px;color:#999;position:absolute;top:-17px;left:96%;white-space:nowrap;padding:1px 3px;background:#f7f7f7;box-sizing:border-box;-webkit-box-sizing:border-box;visibility:hidden;opacity:0;transition:0.5s;-webkit-transition:0.5s 0;}
			.nav>li.actives>a:hover, .nav>li.actives>a:active, .nav>li.actives>a:focus{color:#444;background:#f7f7f7;}
			.nav>li>a:hover>span.prompt_txt, .nav>li>a:active>span.prompt_txt, .nav>li>a:focus>span.prompt_txt,.nav>li.actives>a:hover>span.prompt_txt, .nav>li.actives>a:active>span.prompt_txt, .nav>li.actives>a:focus>span.prompt_txt{visibility:visible;opacity:1;}
            </style>
			<section class="content-header">
			<div>
			</div>
			</section>
			<div class="tabbable"> <!-- Only required for left/right tabs -->
            	<div class="content-header">
                    <ul class="nav nav-tabs nav_radio">
                        <?php foreach($show_status as $k=>$show) {?>
                        <li<?php if($istatus==$k){ ?> class="actives"<?php }?>>
                        	<a href="<?php echo site_url('hotel/orders/index').'?s='.$k; ?>" ><?php echo $show['des']; ?>
                            	<font>(<?php echo $show['count'];?>)</font>
                                <span class="prompt_txt"><?php echo $show['rmk'];?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <form class="form" method='get' action='<?php echo $search_url;?>'>
                    <input type="hidden" name="s" value="<?php echo $istatus;?>" />
                    	<div class="box-body">
                        	<div class="list_o">
                            	<span>酒店:</span>
                                <span>
                                	<select name="hotel">
                                    	<option value="-1">全部酒店</option>
                                    	<?php foreach ($allhotels as $kh => $vh) {?>
                                    	<option value="<?php echo $vh['hotel_id'];?>" <?php if($vh['hotel_id']==$hotel) echo 'selected';?>><?php echo $vh['name'];?></option>
                                    	<?php }?>
                                    </select>
                                </span>
                                <span><input name="hotel_name" type="text" placeholder="请输入酒店名称" value="<?php echo $hotel_name;?>" /></span>
                            </div>
                        	<div class="list_o">
                            	<span>日期:</span>
                                <span>
                                	<select name="timetype">
                                	<?php foreach ($time_type as $kt => $vt) {?>
                                    	<option value="<?php echo $kt;?>" <?php if($kt==$timetype) echo 'selected';?>><?php echo $vt;?></option>
                                   	<?php }?>
                                    </select>
                                </span>
                                <span class="t_time"><input name="start_t" type="text" data-date-format="yyyy-mm-dd" class="c_time datepicker" value="<?php echo $start_t;?>"></span>
                                <font>至</font>
                                <span class="t_time"><input name="end_t" type="text" data-date-format="yyyy-mm-dd" class="c_time datepicker" value="<?php echo $end_t;?>"></span>
                            </div>
                        	<div class="list_o">
                            	<span>关键词:</span>
                                <span class="number"><input name="number" class="n_i_number" type="text" placeholder="入住人姓名/手机号/订单号/备注" value="<?php echo $number;?>" /></span>
                            </div>
                        	<div class="list_o di_in_block" style="margin-left:0px;">
                            	<span>支付方式:</span>
                                <span>
                                	<select name="paytype">
                                    	<option value="-1">全部</option>
                                    <?php foreach ($pay_type as $kp => $vp) {?>
                                    	<option value="<?php echo $kp;?>" <?php if($kp==$paytype) echo 'selected';?>><?php echo $vp;?></option>
                                    <?php }?>
                                    </select>
                                </span>
                            </div>
                            <div class="list_o di_in_block">
                            	<span>支付状态:</span>
                                <span>
                                	<select name="paystatus">
                                    	<option value="-1">全部</option>
                                    <?php foreach ($pay_status as $ks => $vs) {?>
                                    	<option value="<?php echo $ks;?>" <?php if($ks==$paystatus) echo 'selected';?>><?php echo $vs;?></option>
                                    <?php }?>
                                    </select>
                                </span>
                            </div>
                        	<div class="list_o di_in_block">
                            	<span>订单状态:</span>
                                <span>
                                	<select name="orderstatus">
                                    	<option value="-1">全部</option>
                                    	<?php foreach ($order_status as $ko => $vo) {?>
                                    	<option value="<?php echo $ko;?>" <?php if($ko==$orderstatus) echo 'selected';?>><?php echo $vo;?></option>
                                    	<?php }?>
                                    </select>
                                </span>
                            </div>
                            <div class="list_o"><input class="btn_o" name="searchbtn" type="submit" value="搜索" /><font id="tips" style="color:red;"></font>
                            </div>
                            <div class="list_o">
                            <input class="btn_o" name="setbtn" type="button" value="显示设置" id="grid-btn-set" data-toggle="modal" data-target="#setModal"/>
                            </div>
                        </div>
                    </form>
                </div>
			<!-- Main content -->
			<section class="content">
				<a href="javascript:void(0);" onclick='$(".weborder").show();'>展开</a>
				<a href="javascript:void(0);" onclick='$(".weborder").hide();'>收起</a>
				<div class="row" style="box-sizing:border-box;-webkit-box-sizing:border-box;">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-body">
								<table id="data-grid"
									class="table table-bordered table-striped table-condensed dataTable">
									<thead>
										<tr>
             <?php foreach ($fields_config as $k=> $v):?>
             <th <?php if(isset($v['grid_width'])) echo 'width="'. $v['grid_width']. '"'; ?>>
             <?php echo $v['label'];?></th>
             <?php endforeach; ?><th colspan=2>操作</th>
										</tr>
									</thead>
                    <?php if(!empty($list)){ foreach($list as $lt){ ?>
                    <tr onclick="slidesub('<?php echo $lt['id'];?>')"
										class="morder">
                    <?php foreach ($fields_config as $k=> $v):?>
             <td><?php echo $lt[$k];?></td>
             <?php endforeach; ?><td>
            <?php if(empty($lt['no_status'])){?>  
            <span class='a_like' data-toggle="modal" data-target="#orderModal" onclick="show_detail(this)" oid='<?php echo $lt['orderid'];?>' h='<?php echo $lt['hotel_id'];?>'>状态</span>
             <?php }else {?><span>----&nbsp;</span><?php }?>
             <a href="<?php echo site_url('hotel/orders/edit').'?ids='.$lt['id'].'&h='.$lt['hotel_id'];?>">修改</a>
             <a href="<?php echo site_url('hotel/orders/edit').'?ids='.$lt['id'].'&h='.$lt['hotel_id'].'&print=1';?>">打印</a>
             </td>
             </tr>
             <?php if(!empty($lt['order_details'])){ foreach($lt['order_details'] as $od){?>
             <tr name="weborder<?php echo $lt['id'];?>" class="weborder">
	             <?php foreach($item_fields_config as $ik=>$i){?>
	             <td><?php echo isset($od[$ik])?$od[$ik]:'';?></td>
	             <?php }?>
	              <td>
	              <?php if(empty($lt['no_item_status'])&&empty($od['no_item_status'])){?>
	              <a href="<?php echo site_url('hotel/orders/item_edit').'?oid='.$lt['orderid'].'&h='.$lt['hotel_id'].'&item='.$od['id'];?>">状态</a>
	              <a href="<?php echo site_url('hotel/orders/item_edite').'?oid='.$lt['orderid'].'&h='.$lt['hotel_id'].'&item='.$od['id'];?>">修改</a>
	             <?php }else {?><span>-</span><?php }?>
	             </td>
			 </tr>
             	<?php }}?>
             <?php }}?>
                  </table>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</section>
			<!-- /.content -->
			<div class="box-footer ">
				<div class="page"><?php echo $pagination;?></div>
			</div>
		</div>
		<!-- /.content-wrapper -->
		<!-- Modal -->
		<div class="modal fade" id="orderModal" tabindex="-1" role="dialog"
			aria-labelledby="orderModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
							aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">订单状态</h4>
					</div>
					<div class="modal-body" id='status_detail'></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button type="button" class="btn btn-primary"
							onclick='change_status();'>保存</button>
					</div>
				</div>
			</div>
		</div>
		</div>
	<!-- ./wrapper -->
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
<script src="http://30.iwide.cn/public/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="http://30.iwide.cn/public/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="http://30.iwide.cn/public/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!--日历调用结束-->
<script>
<!--杰 2016/8/30-->
$(function(){
	<!--日历调用-->
	$('.datepicker').datepicker({
		dateFormat: "yymmdd"
	});
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
<!--杰 2016/8/30-->
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
function change_status(){
	if(orderid){
		$.get('<?php echo site_url('hotel/orders/update_order_status');?>',{
			oid:orderid,
			status:$('#after_status').val()
		},function(data){
			if(data==1){
				alert('修改成功');
				location.reload();
			}else{
				alert('修改失败');
			}
		});
	}
	$('#myModal').modal('hide');
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
<!--yu 2016/09/19-->
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
</script>
</body>
</html>
