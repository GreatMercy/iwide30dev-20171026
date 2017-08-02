<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<link href="<?php echo base_url(FD_PUBLIC) ?>/js/art_Dialog/skins/default.css" rel="stylesheet" />
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel='stylesheet' href='<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/date-timepicker/jquery.datetimepicker.css'>
<script type="text/javascript" src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/date-timepicker/jquery.datetimepicker.min.js"></script>
<script type="text/javascript">
    //全局变量
    var GV = {
        DIMAUB: "<?php echo base_url();?>",
        JS_ROOT: "<?php echo FD_PUBLIC ?>/js/",
    };
</script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/validate.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/wind.js"></script>
<style type="text/css">
    .isopenok{color:#18BF0E;}
    .isopenfail{color:red;}
	td{position:relative}
	.layer{ position:absolute; display:none; background:#fff; border:1px dashed #1A4400; width:500px; min-height:90px; max-height:300px; overflow-y:scroll;top:100%; right:0; z-index:999999;}
	.layer>*{ padding:10px;}
	.layer [title]{ background:#BEFF93}
	td[showdetail]:hover .layer{display:block}
</style>
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
	<div class="box-header with-border">
		<h3 class="box-title">活动统计</h3>
	</div>
        <div style="padding:10px; background:#BEFF93">推荐会员总数：5　当面邀约：4	　分享邀约：1</div>
		<div class="box-body">
           <table id="table" class="table table-bordered table-striped">
            <thead>
            	<tr>
                    <th>名次</th>
                    <th>会员名称</th>
                    <th>昵称</th>
                    <th>会员卡号</th>
                    <th>推荐数</th>
                    <th>获得积分</th>
                    <th>操作</th>
            	</tr>
            </thead>
            <tbody>
            	<tr>
                	<td>5</td>
                	<td>小雪</td>
                	<td>vv-wing</td>
                	<td>JFK54896316574321</td>
                	<td>5</td>
                	<td>500</td>
                	<td showdetail>
                      <span class="btn btn-info btn-xs" title="查看明细"><i class="fa fa-file-o"></i> 查看明细</span> 
                      <div class="layer detail">
                            <div title>累计积分：500　使用活动积分：400　可用活动积分：100</div>
                            <table class="table table-bordered table-striped">
                                <tr><td>使用时间</td><td>使用积分</td><td>获得活动奖励</td></tr>
                                <tr><td>2016-11-1 8:30</td><td>200</td><td>50元邀金抵扣券券</td></tr>            	
                            </table>
                       </div>

                    </td>
                </tr>
            </tbody>
            </table>
            <section class="box-footer">
                <button class="btn btn-primary">保存</button>
                <button class="btn btn-success" style="margin-left:50px">导出</button>
            </section>
		</div>
		<!-- /.box-footer -->
</div>
<!-- /.box -->
<!-- Horizontal Form -->

<!-- <div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">微信菜单配置</h3>
	</div>
	<?php echo form_open(EA_const_url::inst()->get_url('*/*/edit_post'), array('class'=>'form-inline')); ?>
		<div class="box-body">
            
		</div>
		<div class="box-footer ">
            <button type="submit" class="btn btn-primary">保存</button>
		</div>
		<!-- /.box-footer -->
	<?php echo form_close() ?>
</div> -->
<!-- Horizontal Form -->

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
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $(function () {
    $('#table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
	  "oLanguage":{
		  "oPaginate":{ "sFirst": "页首","sPrevious": "上一页","sNext": "下一页","sLast": "页尾"},
		  "sLengthMenu": "每页显示 _MENU_ 条数据",
	  	  "sEmptyTable": "暂无相关数据"
	  }
    });
  });
</script>
</html>
