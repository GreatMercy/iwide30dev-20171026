<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/datepicker/css/bootstrap-datepicker.min.css">
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/js/bootstrap-datepicker.min.js"></script>
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

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><?php echo isset($breadcrumb_array['action'])? $breadcrumb_array['action']: ''; ?>
            <small></small>
          </h1>
          <ol class="breadcrumb"><?php echo $breadcrumb_html; ?></ol>
        </section>
        <!-- Main content -->
        <section class="content">

<?php echo $this->session->show_put_msg(); ?>
<!-- Horizontal Form -->
<div class="box box-info">

    <div class="tabbable "> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-list-alt"></i> 基本信息 </a></li>
        </ul>

<!-- form start -->

        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
			<?php echo form_open( site_url('hotel/prices/edit_code_post'), array('id'=>'code_form','class'=>'form-horizontal','enctype'=>'multipart/form-data' ), array('price_code'=>$list['price_code']) ); ?>
                <div class="box-body">
                    <div class="form-group  has-feedback">
						<label class="col-sm-2 control-label">价格代码</label>
						<div class="col-sm-8">
							<input type="text" class="form-control " name="price_name" id="price_name" placeholder="价格代码名称" value="<?php echo $list['price_name']?>">
						</div>
					</div>
                    <div class="form-group  has-feedback">
						<label class="col-sm-2 control-label">描述</label>
						<div class="col-sm-8">
							<input type="text" class="form-control " name="des" id="des" placeholder="价格代码描述" value="<?php echo $list['des']?>">
						</div>
					</div>
					 <div class="form-group  has-feedback">
						<label class="col-sm-2 control-label">价格类型</label>
						<div class="col-sm-8">
							<select name='type' id='type' >
							<?php if(!empty($enum_des['HOTEL_PRICE_CODE_TYPE'])){ foreach($enum_des['HOTEL_PRICE_CODE_TYPE'] as $code=>$des) {?>
							<option value="<?php echo $code;?>"
								<?php if($list['type']==$code) echo 'selected';?>><?php echo $des;}?></option>
							<?php }?>
							</select>
						</div>
					</div>
					 <div class="form-group  has-feedback" id='protrol_div' div_type='price_type'>
						<label class="col-sm-2 control-label">协议代码<br />(价格类型为协议价时必填)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control " name="unlock_code" id="unlock_code" placeholder="协议代码" value="<?php echo $list['unlock_code'];?>">
						</div>
					</div>
					 <div class="form-group  has-feedback">
						<label class="col-sm-2 control-label">状态</label>
						<div class="col-sm-8">
							<select name='status' id='status' >
							<?php if(!empty($enum_des['HOTEL_PRICE_CODE_STATUS'])){ foreach($enum_des['HOTEL_PRICE_CODE_STATUS'] as $code=>$des) {?>
							<option value="<?php echo $code;?>"
								<?php if($list['status']==$code) echo 'selected';?>><?php echo $des;}?></option>
							<?php }?>
							</select>
						</div>
					</div>
					 <div class="form-group  has-feedback">
						<label class="col-sm-2 control-label">排序</label>
						<div class="col-sm-8">
							<input type="text" class="form-control " name="sort" id="sort" placeholder="排序，越大越前" value="<?php echo $list['sort']?>">
						</div>
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label" style="color:#7B7B7B">价格配置</label>
					<hr />
					</div>
					 <div class="form-group  has-feedback">
						<label class="col-sm-2 control-label">价格代码关联</label>
						<div class="col-sm-8">
							<select name='related_code' id='related_code' >
							<option value=''>--不关联--</option>
							<?php if(!empty($price_codes)){ foreach($price_codes as $pcs) {?>
							<?php if($pcs['price_code']!=$list['price_code']){ ?>
							<option value="<?php echo $pcs['price_code'];?>"
								<?php if($list['related_code']==$pcs['price_code']) echo 'selected';?>><?php echo $pcs['price_name'];}?></option>
							<?php }}?>
							</select>
						</div>
					</div>
					<div id='related_cal_div' <?php if($list['type']=='member'){?>style="display:none;"<?php }?>>
					 <div class="form-group  has-feedback" >
						<label class="col-sm-2 control-label">关联价格计算方式</label>
						<div class="col-sm-8">
							<select class="form-control " name="related_cal_way" id="related_cal_way">
								<option value=''>--请选择--</option>
								<?php if(!empty($enum_des['HOTEL_PRICE_CODE_RELATED_CAL_WAY'])) foreach($enum_des['HOTEL_PRICE_CODE_RELATED_CAL_WAY'] as $code=>$des){?>
								<option value='<?php echo $code;?>' <?php if($code==$list['related_cal_way']){?>selected<?php }?>><?php echo $des;?></option>
								<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group  has-feedback">
						<label class="col-sm-2 control-label">计算值</label>
						<div class="col-sm-8">
							<input type="text" class="form-control " name="related_cal_value" id="related_cal_value" placeholder="计算值" value="<?php echo $list['related_cal_value']; ?>">
						</div>
					</div>
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label" style="color:#7B7B7B">使用条件</label>
					</div>
					<div id='use_condition' >
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">预付标记</label>
					<div class="col-sm-8">
							<input type='radio' name='pre_pay' value='0' <?php if(empty($list['use_condition']['pre_pay'])){?>checked='checked'<?php }?> />不显示
							<input type='radio' name='pre_pay' value='1' <?php if(!empty($list['use_condition']['pre_pay'])){?>checked='checked'<?php }?> />显示
						</div>
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">不使用</label>
					<?php foreach($pay_ways as $pw){?>
					<input type='checkbox' name='no_pay_way[]' value='<?php echo $pw->pay_type;?>' 
					<?php if(!empty($list['use_condition']['no_pay_way'])&&in_array($pw->pay_type, $list['use_condition']['no_pay_way'])){?>checked='checked'<?php }?>
					 /><?php echo $pw->pay_name;?>
					<?php }?>
					</div>
					<?php if(!empty($levels)) {?>
					<div class="form-group  has-feedback">
						<label class="col-sm-2 control-label">关联会员等级</label>
						<?php foreach($levels as $k=>$lv){?>
							<input type="checkbox" name='member_levels[]' value='<?php echo $k; ?>' 
							<?php if((isset($list['use_condition']['member_levels'])&&in_array($k,$list['use_condition']['member_levels']))||(isset($list['use_condition']['member_level'])&&$list['use_condition']['member_level']==$k)){?>checked="checked"<?php }?> /><?php echo $lv;?>
						<?php }?>
					</div>
					<?php }?>
					<div class="form-group  has-feedback" style='display: none;'>
					<label class="col-sm-2 control-label">可预订时间段<br />(格式:小时分钟,24小时制,如0820,1830)</label>
						开始：<input type="text" name="book_time_s" id="book_time_s" placeholder="开始时间" value="<?php if(!empty($list['use_condition']['book_time']['s']))echo $list['use_condition']['book_time']['s']; ?>">
						<br/>结束：<input type="text" name="book_time_e" id="book_time_e" placeholder="结束时间" value="<?php if(!empty($list['use_condition']['book_time']['e']))echo $list['use_condition']['book_time']['e']; ?>">
					</div>
					<div class="form-group  has-feedback" style='display: none;'>
					<label class="col-sm-2 control-label">最低入住时间(分钟)</label>
						<input type="text" name="min_min" id="min_min" placeholder="最低入住时间" value="<?php if(!empty($list['use_condition']['min_min']))echo $list['use_condition']['min_min']; ?>">
					</div>
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">需提前预订天数</label>
						<input type="text" name="pre_day" id="pre_day" placeholder="提前预订天数" value="<?php if(isset($list['use_condition']['pre_d']))echo $list['use_condition']['pre_d']; ?>" /> (仅当天可预订请填0，不限制请留空)
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">入住日期大于等于</label>
						<input type="text" name="s_date_s" id="s_date_s" data-date-format="yyyymmdd" class=" datepicker" value="<?php if(isset($list['use_condition']['s_date_s']))echo $list['use_condition']['s_date_s']; ?>" />方可预订
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">入住日期小于等于</label>
						<input type="text" name="s_date_e" id="s_date_e" data-date-format="yyyymmdd" class=" datepicker" value="<?php if(isset($list['use_condition']['s_date_e']))echo $list['use_condition']['s_date_e']; ?>" />方可预订
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">离店日期大于等于</label>
						<input type="text" name="e_date_s" id="e_date_s" data-date-format="yyyymmdd" class=" datepicker" value="<?php if(isset($list['use_condition']['e_date_s']))echo $list['use_condition']['e_date_s']; ?>" />方可预订
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">离店日期小于等于</label>
						<input type="text" name="e_date_e" id="e_date_e" data-date-format="yyyymmdd" class=" datepicker" value="<?php if(isset($list['use_condition']['e_date_e']))echo $list['use_condition']['e_date_e']; ?>" />方可预订
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">单次最大预订间数</label>
						<input type="text" name="max_num" id="max_num" value="<?php if(isset($list['use_condition']['mxn']))echo $list['use_condition']['mxn']; ?>" />
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">最多可订天数</label>
						<input type="text" name="max_day" id="max_day" value="<?php if(isset($list['use_condition']['mxd']))echo $list['use_condition']['mxd']; ?>" />
					</div>
                    <div class="form-group  has-feedback">
                        <label class="col-sm-2 control-label">最少可订天数</label>
                        <input type="text" name="min_day" id="min_day" value="<?php if(isset($list['use_condition']['min_day']))echo $list['use_condition']['min_day']; ?>" />
                    </div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label" style="color:#7B7B7B">优惠券使用 </label>
					</div>
					<div id='coupon_condition'>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">可否用券</label>
					<div class="col-sm-8">
							<input type='radio' name='no_coupon' value='0' <?php if(empty($list['coupon_condition']['no_coupon'])){?>checked='checked'<?php }?> />可用
							<input type='radio' name='no_coupon' value='1' <?php if(!empty($list['coupon_condition']['no_coupon'])){?>checked='checked'<?php }?> />不可用 (此配置优先于会员模块配置)
						</div>
					</div>
					<div class="form-group  has-feedback">
						<label class="col-sm-2 control-label">用券数量</label>
						<div class="col-sm-8">
							<select name='coupon_num_type'>
							<option value='order' <?php if(!empty($list['coupon_condition']['num_type'])&&$list['coupon_condition']['num_type']=='order'){?>selected<?php }?>>每个订单可用</option>
							<option value='roomnight' <?php if(!empty($list['coupon_condition']['num_type'])&&$list['coupon_condition']['num_type']=='roomnight'){?>selected<?php }?>>每个间夜可用</option>
							</select>
							<input type='text' name='coupon_num' value='<?php if(!empty($list['coupon_condition']['coupon_num'])){echo $list['coupon_condition']['coupon_num'];  }?>' /> 张
						</div>
					</div>
					<?php if (!empty($coupon_types)){?>
					<div class="form-group  has-feedback">
						<label class="col-sm-2 control-label">券关联</label>
						<div class="col-sm-8">
							<select name='related_coupon'>
							<option value=''>不关联</option>
							<?php foreach ($coupon_types as $card_id=>$c){?>
							<option value='<?php echo $card_id;?>' <?php if(!empty($list['coupon_condition']['couprel'])&&$list['coupon_condition']['couprel']==$card_id){?>selected<?php }?>><?php echo $c['title'];?></option>
							<?php }?>
							</select>
						</div>
					</div>
					<?php }?>
					</div>
					
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label" style="color:#7B7B7B">积分使用 </label>
					</div>
					<div id='coupon_condition'>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">可否用积分兑换</label>
						<div class="col-sm-8">
							<input type='radio' name='no_part_bonus' value='0' <?php if(empty($list['bonus_condition']['no_part_bonus'])){?>checked='checked'<?php }?> />可用
							<input type='radio' name='no_part_bonus' value='1' <?php if(!empty($list['bonus_condition']['no_part_bonus'])){?>checked='checked'<?php }?> />不可用 (此配置优先于会员模块配置)
						</div>
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">积分与券同用</label>
						<div class="col-sm-8">
							<input type='radio' name='poc' value='0' <?php if(empty($list['bonus_condition']['poc'])){?>checked='checked'<?php }?> />可同用
							<input type='radio' name='poc' value='1' <?php if(!empty($list['bonus_condition']['poc'])){?>checked='checked'<?php }?> />不可同用
						</div>
					</div>
					</div>
					
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label" style="color:#7B7B7B">营销功能</label>
					<hr />
					</div>
					<div id='must_date' >
						<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label" >设置某时段内显示</label>
					<div class="col-sm-8">
					<input type='radio' name='must_date' value='3' <?php if($list['must_date']==3){?>checked='checked'<?php }?>/>不限制<br />
					<input type='radio' name='must_date' value='1' <?php if($list['must_date']==1){?>checked='checked'<?php }?>/>全指向（前台搜索时指定日期必须全匹配）<br />
					<input type='radio' name='must_date' value='2' <?php if($list['must_date']==2){?>checked='checked'<?php }?>/>半指向（前台搜索时只需包含指定日期）<br />
					<?php if(!empty($price_code)){?>
					<a href="<?php echo site_url('hotel/room_status/index')."?price_code=$price_code";?>"><span>指定日期设置</span></a>
					<?php }?>
					</div>
					</div>
					</div>
					<?php if(!empty($service)&&0){?>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">可加服务</label>
							<?php  foreach ($service as $s){?>
						<div class="col-sm-8" key='key'>
								<input type='checkbox' name='add_service' value='<?php echo $s['service_id'];?>' <?php if(!empty($service_keys)&&in_array($s['service_id'], $service_keys)){?>checked='checked'<?php }?>
								 /><?php echo $s['service_name'];?>
								 可加<input type="text" style='width:5em' name="max_num" id="max_num" placeholder="可加数量" value="<?php if(isset($list['add_service_set'][$s['service_id']]['max_num']))echo $list['add_service_set'][$s['service_id']]['max_num']; ?>">份,
								 单价<input type="text" style='width:5em' name="service_price" id=""service_price"" placeholder="服务单价" value="<?php if(isset($list['add_service_set'][$s['service_id']]['service_price']))echo $list['add_service_set'][$s['service_id']]['service_price']; ?>">元
						</div>
								 <?php }?>
					</div>
					<?php }?>
					<?php if (!empty($is_pms)){?>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label" style="color:#7B7B7B">Pms配置</label>
					<hr />
					</div>
					<div class="form-group  has-feedback">
					<label class="col-sm-2 control-label">对应PMS价格代码</label>
						<input type="text" name="external_code" id="external_code" placeholder="对应PMS价格代码" value="<?php if(isset($list['external_code'])&&$list['external_code']!=='')echo $list['external_code']; ?>" /><br />(修改此项会马上影响到线上价格，若不确定请咨询相关工作人员)
					</div>
					<?php }?>
					</div>
                    <div class="box-footer ">
                        <div class="col-sm-4 col-sm-offset-4">
                            <button type="button" onclick='sub_code();' class="btn btn-info pull-right">保存</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <input id='service_data' name='service_data' type='hidden' value='' />
				<?php echo form_close() ?>
                <!-- /.box-body -->

            </div><!-- /#tab1-->
            
        </div><!-- /.tab-content -->

</div>
<!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

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
	$(".wysihtml5").wysihtml5();
	$('.date-pick').datepicker({
		dateFormat: "yymmdd"
	});
	$('.datepicker').datepicker();
});
</script>
</body>
</html>
