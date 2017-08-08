<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link href="<?php echo base_url(FD_PUBLIC) ?>/uploadify/uploadify.css" type="text/css" />
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
					<!--

    <div class="tabbable "> <!-- Only required for left/right tabs -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab1" data-toggle="tab"><i
								class="fa fa-list-alt"></i>参数配置 </a></li>
					</ul>

					<!-- form start -->

					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
			<?php echo form_open( site_url('pay/jfpay/edit_post'), array('class'=>'form-horizontal','enctype'=>'multipart/form-data' )); ?>
						<div class="form-group  has-feedback">
              			  <label class="col-sm-2 control-label">酒店订房：</label>
              			  </div><hr />
              			    <div class="box-body">
								<div class="form-group  has-feedback">
									<label class="col-sm-2 control-label">积分兑换比例</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="hotel_rate"
											id="hotel_rate" placeholder="积分兑换比例"
											value="<?php if(!empty($list['hotel_rate'])){ echo $list['hotel_rate']; }?>" />
									</div>(多少积分抵一元钱，如填100表示100积分可抵1元)
								</div>
							</div>
							 <div class="box-footer ">
		                        <div class="col-sm-8 col-sm-offset-1 pull-right">
		                            <button type="submit" class="btn btn-info">保存</button>&nbsp;
		                            <a href='<?php echo site_url('pay/pay/ways');?>' class="btn btn-info">返回</a>
		                        </div>
		                    </div>
							<!-- /.box-footer -->
			<?php echo form_close()?>
						</div>
                <!-- /.box-body -->

					</div>
					<!-- /#tab1-->

				</div>
				<!-- /.tab-content -->

			</section>
			<!-- /.content -->
		</div>
		<!-- /.box -->

	</div>
	<!-- /.content-wrapper -->

<?php
/* Footer Block @see footer.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'footer.php';
?>
<?php

/* Right Block @see right.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'right.php';
?>
</div>
	<!-- ./wrapper -->
<?php
/* Right Block @see right.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'commonjs.php';
?>
<!--
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/ckeditor/ckeditor.js"></script>
-->
	<link rel="stylesheet"
		href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<script
		src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script>
$(function () {
	//CKEDITOR.replace('el_gs_detail');
	$(".wysihtml5").wysihtml5();
});
</script>
</body>
</html>
<script type="text/javascript">
	
</script>