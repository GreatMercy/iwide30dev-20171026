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

<?php //var_dump($this->session); exit; ?>

<?php echo $this->session->show_put_msg(); ?>

<!-- Horizontal Form -->
<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">编辑信息</h3>
	</div>
<?php if($error_msg != null): ?>
	<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<h4><i class="icon fa fa-check"></i> <?php echo $error_msg; ?></h4>
<?php else : ?>
	<!-- /.box-header -->
<!-- form start -->
<?php $pk= $model->table_primary_key(); ?>
	<?php 
	echo form_open( EA_const_url::inst()->get_url('*/*/edit_post'), array('class'=>'form-horizontal','enctype'=>'multipart/form-data'), array($pk=>$model->m_get($pk) ) ); ?>
		<div class="box-body">
            <?php foreach ($fields_config as $k=>$v): ?>
            	<?php if($k == 'page_content'): ?>
            		<!--<div class="form-group  has-feedback">
						<label for="el_page_content" class="col-sm-2 control-label">页面文字内容</label>
						<div class="col-sm-8"><input type="text" class="form-control " maxlength="20" name="page_content" id="el_page_content" placeholder="输入文字不得超过20个" value="<?php /*echo $model->m_get('page_content'); */?>"></div>
					</div>-->
				<?php elseif($k == 'redeem_content'): ?>
					<div class="form-group  has-feedback">
						<label for="el_page_content" class="col-sm-2 control-label">兑换说明</label>
						<div class="col-sm-8"><input type="text" class="form-control " maxlength="140" name="redeem_content" id="el_page_content" placeholder="输入文字不得超过140个" value="<?php echo $model->m_get('redeem_content'); ?>"></div>
					</div>
				<?php elseif($k == 'recommended_links'): ?>
						<div class="form-group  has-feedback">
							<label for="el_page_content" class="col-sm-2 control-label">更多推荐</label>
							<div class="col-sm-8"><input type="text" class="form-control " maxlength="256" name="recommended_links" id="el_page_content" placeholder="默认为商城首页" value="<?php echo $model->m_get('recommended_links'); ?>"></div>
						</div>
            	<?php else: ?>
					<?php 
	                if($check_data==FALSE) echo EA_block_admin::inst()->render_from_element($k, $v, $model); 
	                else echo EA_block_admin::inst()->render_from_element($k, $v, $model, FALSE); 
	                ?>
	            <?php endif;?>
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
		</div>
		<!-- /.box-body -->
		<div class="box-footer ">
            <div class="col-sm-4 col-sm-offset-4">
                <button type="reset" class="btn btn-default">清除</button>
                <button type="submit" class="btn btn-info pull-right">保存</button>
            </div>
		</div>
		<!-- /.box-footer -->
	<?php echo form_close() ?>
<?php endif; ?>
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
</body>
</html>
