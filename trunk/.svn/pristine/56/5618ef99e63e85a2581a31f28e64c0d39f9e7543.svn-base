<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
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



  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        用券规则
        <small>Useing Rules</small>
      </h1>
      <ol class="breadcrumb">
      </ol>
    </section>

<form role="form" method='post' id='form1' action='<?php echo site_url('hotel/coupons/save_userule');?>'>
<input type='hidden' name='<?php echo $csrf_token;?>' value='<?php echo $csrf_value;?>' />
<input type='hidden' name='rule_id' value='<?php echo $list['rule_id'];?>' />
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">查看规则</h3>
            </div>
            <div class="box-body">
                <div class="form-group col-xs-6"><!--  has-error错误  has-success正确 -->
                  <label>规则名称</label>
                  <p><?php echo $list['rule_name'];?></p>
                </div>
                <div class="form-group col-xs-6">
                  <label>卡券类型</label>
                    <p> <?php if ($list['rule_type']=='voucher') echo '代金券';
                    else if ($list['rule_type']=='discount') echo '折扣券';
                    else if ($list['rule_type']=='exchange') echo '礼品券';?></p>
                </div>
                 <div class="form-group col-xs-6">
                  <label>使用门店</label> <?php if (empty($list['hotel_rooms'])){?>
                  <div class="radio"><label>全部门店和房型</label></div>
                  <?php }else{?>
                  <div class="radio part_show_radio"><label>指定门店和房型</label></div>
                  <div class="btn btn-default btn-xs part_show add_hotel_btn"><i class="fa fa-plus"></i> 查看适用门店</div>
                  <?php }?>
                </div>
                <div class="form-group col-xs-6">
                  <label>卡券列表</label>
                   <?php if (!empty($coupon_types)){foreach ($coupon_types as $c){?>
                  <div class="checkbox">
                  	<p><?php if (!empty($list['coupon_ids'])&&in_array($c['card_id'], $list['coupon_ids'])){ echo $c['title']; }?></p>
                  </div>
                   <?php }}?>
                </div>
            </div>
          </div>
        </div>       
        
         
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">其他规则</h3>
            </div>
            <div class="box-body">
                <div class="form-group col-xs-6">
                  <label>会员等级(非必选)</label>
                  <?php if (empty($list['extra_rule']['level'])){?>
                  <div class="radio"><label>全部会员等级</label></div>
                  <?php }else{?>
                  <div class="radio part_show_radio"><label>指定会员等级</label></div>
                  <div class="checkbox part_show" >
                      <table class="table table-bordered">
                      <?php if (!empty($member_levels)){?>
                        <tr>
                        <?php foreach ($member_levels as $level=>$name){?>
                      		<?php if (!empty($list['extra_rule']['level'])&&in_array($level, $list['extra_rule']['level'])){?>
                      		<td><label><?php echo $name;?></label></td>
                      		<?php }?>
                      		<?php }?>
                        </tr>
                      <?php }?>
                      </table>
                  </div>
                  <?php }?>
                </div>
                <div class="form-group col-xs-6">
                  <label>支付方式(非必选)</label>
                  <?php if (empty($list['extra_rule']['paytype'])){?>
                  <div class="radio"><label>全部支付方式</label></div>
                  <?php }else{?>
                  <div class="radio part_show_radio"><label>指定支付方式</label></div>
                  <div class="checkbox part_show">
                      <table class="table table-bordered">
                          <?php if (!empty($pay_ways)){?>
                          <tr>
                          <?php foreach ($pay_ways as $k=>$p){?>
                          <?php if (!empty($list['extra_rule']['paytype'])&&in_array($p->pay_type, $list['extra_rule']['paytype'])){?>
                          <td><label><?php echo $p->pay_name;?></label></td>
                          <?php }?>
                          <?php }?>
                          </tr>
                          <?php }?>
                      </table>
                  </div>
                  <?php }?>
                </div>
            </div>
          </div>
        </div>      
        
        
        <div class="col-xs-12">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">
	              <?php if (empty($list['rule_dates'])||$list['rule_dates']['r']==1){?>选中日期不可用<?php }else{?>选中日期可用<?php }?>
              </h3>
            </div>
            <div class="box-body">
                <div class="form-group col-xs-12">
                  <label>星期</label>
                  <div class="checkbox">
                  		<?php if (!empty($list['rule_dates']['d']['r']['week'])){?>
                      <table class="table table-bordered"><tr>
                      	<?php if (in_array(1, $list['rule_dates']['d']['r']['week'])){?><td><label><?php echo ' 周一';?></label></td><?php }?>
                      	<?php if (in_array(2, $list['rule_dates']['d']['r']['week'])){?><td><label><?php echo ' 周二';?></label></td><?php }?>
                      	<?php if (in_array(3, $list['rule_dates']['d']['r']['week'])){?><td><label><?php echo ' 周三';?></label></td><?php }?>
                      	<?php if (in_array(4, $list['rule_dates']['d']['r']['week'])){?><td><label><?php echo ' 周四';?></label></td><?php }?>
                      	<?php if (in_array(5, $list['rule_dates']['d']['r']['week'])){?><td><label><?php echo ' 周五';?></label></td><?php }?>
                      	<?php if (in_array(6, $list['rule_dates']['d']['r']['week'])){?><td><label><?php echo ' 周六';?></label></td><?php }?>
                      	<?php if (in_array(0, $list['rule_dates']['d']['r']['week'])){?><td><label><?php echo ' 周日';?></label></td><?php }?>
                       </tr>
                      </table>
                      <?php }else{?>
                      <p>无</p>
                      <?php }?>
                  </div>
                </div>
                <div class="form-group col-xs-8">
                	<label>日期</label>
                    
                    <table class="table table-bordered range_pick">
                    <?php if (!empty($list['rule_dates']['d']['d'])){foreach ($list['rule_dates']['d']['d'] as $d){$tmp=explode('-', $d);?>
                      <tr>
                        <td><p><?php echo $tmp[0];?></p></td>
                        <td><p><?php if (!empty($tmp[1])) echo $tmp[1];?></p></td>
                      </tr>
                      <?php }}?>
                    </table>
                </div>
                <div class="form-group col-xs-12" style="margin-top:25px; margin-bottom:0">
                  <label>是否激活</label>
                  <?php if ($list['status']==1){?>
                  <div class="radio"><p>确定激活</p></div>
                  <?php }else{?>
                  <div class="radio"><p>取消激活</p></div>
                  <?php }?>
                </div>
            </div>
          </div>
        </div>  
        <div class="col-xs-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-pencil-square-o"></i>
              <h3 class="box-title">操作记录</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ol type="1">
                  <li class="text-red">192.168.1.20添加了卡券规则</li>
                  <li class="text-red">192.168.1.42修改了卡券规则</li>
              </ol>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div> 
      </div>
      <!-- /.row -->
    </section>
    
    
    <style>
	.layer{position:fixed; top:0; left:0;overflow:hidden; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; display:none}
	.add_hotel_content{background:#f8f8f8; padding:15px; height:100%; float:right}
	</style>
    <div class="layer add_hotel">
        <div class="col-xs-6 add_hotel_content">
        
          <div class="box box-primary">
            <div class="box-body"><div class="checkbox allhotelcheck"><label><input type="checkbox"> 所有酒店</label></div></div>
          </div>
          
          <div class="box box-primary">
            <div class="box-body">
              <div class="form-group">
                  <div class="checkbox allcheck"><label><input type="checkbox"> 所有价格代码</label></div>
                  <div class="checkbox singlecheck"><label><input type="checkbox"> 基础价</label></div>
                  <div class="checkbox singlecheck"><label><input type="checkbox"> 会员价</label></div>
                  <div class="checkbox singlecheck"><label><input type="checkbox"> 秒杀价</label></div>
              </div>
            </div>
          </div>
          
          <div class="box">
            <div class="box-body">            
              <table id="coupons_table" class="table table-bordered table-striped">
              	<thead><tr><th>酒店</th><th>房型</th></tr></thead>
                <tr>
                  <td><div class="checkbox hotelcheck"><label><input type="checkbox"> 金房卡大酒店</label></div></td>
                  <td>
                      <div class="checkbox"><label><input type="checkbox"> 标准房</label></div>
                      <div class="checkbox"><label><input type="checkbox"> 大床房</label></div>
                      <div class="checkbox"><label><input type="checkbox"> 套房</label></div>
                  </td>
                </tr>
                <tr>
                  <td><div class="checkbox hotelcheck"><label><input type="checkbox"> 信息驿站大酒店</label></div></td>
                  <td>
                      <div class="checkbox"><label><input type="checkbox"> 双人房</label></div>
                      <div class="checkbox"><label><input type="checkbox"> 大床房</label></div>
                      <div class="checkbox"><label><input type="checkbox"> 套房</label></div>
                  </td>
                </tr>
              </table>
            </div>
         </div>
         
         <div class="btn btn-primary pull-right layer_success">完成</div>
      </div>
    </div>
</form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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
<script src="/public/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/public/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
$(function(){
	
    $('#coupons_table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
	  "oLanguage":{
		  "oPaginate":{ "sFirst": "页首","sPrevious": "上一页","sNext": "下一页","sLast": "页尾"},
		  "sLengthMenu": "每页显示 _MENU_ 条数据",
	  	  "sEmptyTable": "暂无相关数据",
	  },
    });
	$('.radio').each(function(index, element) {
        $(this).get(0).addEventListener('click',function(){
			if($(this).hasClass('part_show_radio'))
				$(this).siblings('.part_show').show();
			else
				$(this).siblings('.part_show').hide();
		});
    });
	//$('.part_show_radio').each(function(index, element) {
    //   	var bool = $(this).find('input').get(0).checked;
	//	if(bool) $(this).siblings('.part_show').show();
   // });
	$('.add_hotel_btn').click(function(){
		$('.add_hotel').stop().fadeIn();
		$('body').css('overflow','hidden');
	})
	$('.add_hotel').click(function(){
		$('.add_hotel').stop().fadeOut();
		$('body').removeAttr('style');
	})
	$('.add_hotel_content').click(function(e){
		e.stopPropagation();
	})
	$('.layer_success').click(function(){
		$('.add_hotel').stop().fadeOut();
		$('body').removeAttr('style');
	})
	$('input[type="checkbox"]','.allcheck').click(function(){
		var bool =$(this).get(0).checked;
		var tmp = $(this).parents('.allcheck').siblings('.singlecheck');
		tmp.each(function(index, element) {
         	$(this).find('input').get(0).checked=bool;
        });
	})
	$('input[type="checkbox"]','.singlecheck').click(function(){
		var bool   =$(this).get(0).checked;
		var parent =$(this).parents('.singlecheck');
		var tmp    =parent.siblings('.allcheck');
		parent.siblings('.singlecheck').each(function(index, element) {
			if( !$(this).find('input').get(0).checked ) 
				bool=$(this).find('input').get(0).checked;
		});
		tmp.find('input').get(0).checked=bool;
	})
	$('input[type="checkbox"]','.allhotelcheck').click(function(){
		var bool   =$(this).get(0).checked;
		$('.hotelcheck').each(function(index, element) {
         	$(this).find('input').get(0).checked=bool;            
        });
	})
	$('input[type="checkbox"]','.hotelcheck').click(function(){
		var bool   =$(this).get(0).checked;
		$('.hotelcheck').each(function(index, element) {
			if( !$(this).find('input').get(0).checked ) 
				bool=$(this).find('input').get(0).checked;
		});
		$('input[type="checkbox"]','.allhotelcheck').get(0).checked=bool;
	})
	//$('input').change(function(){console.log($(this).val());})
})
</script>
</body>
</html>
