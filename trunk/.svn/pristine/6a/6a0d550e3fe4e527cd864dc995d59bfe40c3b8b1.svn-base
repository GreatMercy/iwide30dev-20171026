<!-- DataTables -->
<link rel="stylesheet"
	href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/images/laydate.css">
<link rel="stylesheet" href="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/images/laydate12.css">

<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/datepicker/css/bootstrap-datepicker.min.css">
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="http://test008.iwide.cn/public/AdminLTE/plugins/new/huang.css">
</head>
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
</style>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;" >
            <div class="banner bg_fff p_0_20"> 酒店订房/房型管理</div>
            <div class="contents">
				<div class="head_cont contents_list bg_fff">
					<div class="j_head">
						<div>
							<span>酒店名称</span>
							<span class="input-group w_200" style="position:relative;display:inline-flex;" id="drowdown">
	                            <input placeholder="选择或输入关键字" type="text" style="color:#92a0ae;" class="form-control w_200 moba" id="search_hotel" >
	                            <ul class="drow_list">
                                    <li value="">碧桂园凤凰大酒店</li>
                                    <li value="">北京金茂万丽酒店</li>
                                    <li value="">上海街町酒店</li>
                                    <li value="">深圳威尼斯酒店</li>
                                    <li value="">街町酒店广州测试店</li>
                                    <li value="">广州金房卡大酒店</li>
	                            </ul>
                            </span>
						</div>
						<div>
							<span>时间筛选</span>
							<select class="w_90">
								<option value="1">下单时间</option>
                            	<option value="2">入住时间</option>
                            	<option value="3">离店时间</option>
							</select>
							<span class="t_time"><input name="start_t" type="text" id="datepicker" class="moba" value=""></span>
                            <font>至</font>
                            <span class="t_time"><input name="end_t" type="text" id="datepicker2" class="moba" value=""></span>
						</div>
						<div>
							<span>关键字</span>
							<span><input type="text" placeholder="输入关键字搜索"/></span>
						</div>
					</div>
					<div  class="h_btn_list" style="">
						<div class="actives">筛选</div>
						<div>批量导出</div>
					</div>
				</div>
				<div class="contents_list" style="font-size:13px;">
					<a class="f_r all_open_order color_72afd2" href="http://test008.iwide.cn/index.php/hotel/hotels/add">新增酒店</a>
					<div class="classification display_flex bg_fff">
						<div class="add_active">在线房</div>
						<div>下线房</div>
						<div>所有房</div>
					</div>
				</div>
				<div class="box-body">
					<table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;">
						<thead class="bg_f8f9fb form_thead">
							<tr class="bg_f8f9fb form_title">
								<th>酒店ID</th>
								<th>房型名称</th>
								<th>房量</th>
								<th>床数</th>
								<th>面积</th>
								<th>所属酒店</th>
								<th>创建时间</th>
								<th>排序</th>
								<th>状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
							<tr class=" form_con">
								<td>2368</td>
								<td>行政大床房</td>
								<td>12</td>
								<td>2</td>
								<td>30</td>
								<td>金房卡大酒店广州岗顶店</td>
								<td>2016.10.10   16:00:00</td>
								<td>15</td>
								<td>在线</td>
								<td><a class="color_72afd2" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a></td>
							</tr>
							<tr class=" form_con">
								<td>2368</td>
								<td>行政大床房</td>
								<td>12</td>
								<td>2</td>
								<td>30</td>
								<td>金房卡大酒店广州岗顶店</td>
								<td>2016.10.10   16:00:00</td>
								<td>15</td>
								<td>在线</td>
								<td><a class="color_72afd2" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a></td>
							</tr>
							<tr class=" form_con">
								<td>2368</td>
								<td>行政大床房</td>
								<td>12</td>
								<td>2</td>
								<td>30</td>
								<td>金房卡大酒店广州岗顶店</td>
								<td>2016.10.10   16:00:00</td>
								<td>15</td>
								<td>在线</td>
								<td><a class="color_72afd2" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a></td>
							</tr>
							<tr class=" form_con">
								<td>2368</td>
								<td>行政大床房</td>
								<td>12</td>
								<td>2</td>
								<td>30</td>
								<td>金房卡大酒店广州岗顶店</td>
								<td>2016.10.10   16:00:00</td>
								<td>15</td>
								<td>在线</td>
								<td><a class="color_72afd2" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a></td>
							</tr>
							<tr class=" form_con">
								<td>2368</td>
								<td>行政大床房</td>
								<td>12</td>
								<td>2</td>
								<td>30</td>
								<td>金房卡大酒店广州岗顶店</td>
								<td>2016.10.10   16:00:00</td>
								<td>15</td>
								<td>在线</td>
								<td><a class="color_72afd2" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a></td>
							</tr>
							<tr class=" form_con">
								<td>2368</td>
								<td>行政大床房</td>
								<td>12</td>
								<td>2</td>
								<td>30</td>
								<td>金房卡大酒店广州岗顶店</td>
								<td>2016.10.10   16:00:00</td>
								<td>15</td>
								<td>在线</td>
								<td><a class="color_72afd2" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a></td>
							</tr>
							<tr class="form_con">
								<td>2368</td>
								<td>行政大床房</td>
								<td>12</td>
								<td>2</td>
								<td>30</td>
								<td>金房卡大酒店广州岗顶店</td>
								<td>2016.10.10   16:00:00</td>
								<td>15</td>
								<td>在线</td>
								<td><a class="color_72afd2" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a></td>
							</tr>
						</tbody>
					</table>
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
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/layDate.js"></script>
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
	
	$('.drow_list li').click(function(){
        $('#search_hotel').val($(this).text());
        $(this).addClass('cur').siblings().removeClass('cur');
    });
	$('#coupons_table').DataTable({
		    "aLengthMenu": [8,50,100,200],
			"iDisplayLength": 8,
			"bProcessing": true,
			"paging": true,
			"lengthChange": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"searching": false,
			"language": {
				"sSearch": "搜索",
				"lengthMenu": "每页显示 _MENU_ 条记录",
				"zeroRecords": "找不到任何记录. ",
				"info": "",
				//"info": "当前显示第_PAGE_ / _PAGES_页，记录从 _START_ 到 _END_ ，共 _TOTAL_ 条",
				"infoEmpty": "",
				"infoFiltered": "(从 _MAX_ 条记录中过滤)",
				"paginate": {
					"sNext": "下一页",
					"sPrevious": "上一页",
				}
			}
	});
	$('.classification >div').click(function(){
		$(this).addClass('add_active').siblings().removeClass('add_active');
	})
	$('.news').click(function(){
    	$('.j_toshow').animate({"right":"0px"},800);
	});
	$('.close_btn').click(function(){
	    $('.j_toshow').animate({"right":"-330px"},800);
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
</script>
</body>
</html>
