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
<?php $pk= $model->table_primary_key(); ?>
<!-- Horizontal Form -->
<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo ( $this->input->post($pk) ) ? '编辑': '新增'; ?>信息</h3>
	</div>
	<!-- /.box-header -->
<!-- form start -->
	<?php 
	echo form_open( EA_const_url::inst()->get_url('*/*/edit_post'), array('class'=>'form-horizontal'), array($pk=>$model->m_get($pk) ) ); ?>
		<div class="box-body">
            <?php foreach ($fields_config as $k=>$v): ?>
				<?php 
                if($check_data==FALSE) echo EA_block_admin::inst()->render_from_element($k, $v, $model); 
                else echo EA_block_admin::inst()->render_from_element($k, $v, $model, FALSE); 
                ?>
			<?php endforeach; ?>
			
<!-- 
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox" /> 选项
						</label>
					</div>
				</div>
			</div>
 -->
 			<div class="form-group  has-feedback">
 			<label for="el_price_rule" class="col-sm-2 control-label">价格规则</label>
 			<div class="col-sm-8">
 			<?php if(!empty($price_rule)){ foreach ($price_rule as $rk=>$pr){?>
 				<div key='key'><?php echo $rule_tips['r']?>：<select name='r'>
 				<option value='dis' <?php if($pr['r']=='dis'){?>selected<?php }?>>折扣</option>
 				<option value='money' <?php if($pr['r']=='money'){?>selected<?php }?>>金额</option>
 				</select></div>
 				<div><?php echo $rule_tips['b']?>：<input name='b' value='<?php echo $pr['b'];?>' /></div>
 				<div><?php echo $rule_tips['e']?>：<input name='e' value='<?php echo $pr['e'];?>' /></div>
 				<div><?php echo $rule_tips['v']?>：<input name='v' value='<?php echo $pr['v'];?>' /></div>
 			<?php }}else{?>
 				<div key='key'><?php echo $rule_tips['r']?>：<select name='r'>
 				<option value='money'>金额</option>
 				<option value='dis'>折扣</option>
 				</select></div>
 				<div><?php echo $rule_tips['b']?>：<input name='b' value='' /></div>
 				<div><?php echo $rule_tips['e']?>：<input name='e' value='' /></div>
 				<div><?php echo $rule_tips['v']?>：<input name='v' value='' /></div>
 			<?php }?>
 			</div>
 			</div>
 		<div>
 		</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer ">
            <div class="col-sm-4 col-sm-offset-4">
                <button type="reset" class="btn btn-default">清除</button>
                <button type="submit" onclick='sub_content()' class="btn btn-info pull-right">保存</button>
            </div>
		</div>
		<!-- /.box-footer -->
	<?php echo form_close() ?>
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
<script type="text/javascript">
function sub_content(){
	ranges=$("[key='key']");
	var key_word='';
	var p_o='';
	$.each(ranges,function(i,n){
		key_word=$(n).find('input[name="key_value"]').val();
		if(key_word!=''){
			color=$(n).find('input[name="color"]').val();
			data[key_word]={};
			data[key_word]['color']=color;
			p_o=$(n).find("[flag='content']");
			check_key='';
			$.each(p_o,function(pi,pn){
				content_key=$(pn).find("[name='type']");
				if(content_key.is(":checked")==true)
					data[key_word][content_key.val()]=$(pn).find("[name='value']").val();
			});
		}
	});
	json=JSON.stringify(data);
	$('#content_data').val(json);
	$('#submitform').submit();
}
</script>
</body>
</html>
