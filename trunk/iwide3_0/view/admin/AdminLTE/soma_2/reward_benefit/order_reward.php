<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel='stylesheet' href='<?php echo base_url(FD_PUBLIC);?>/AdminLTE/plugins/bootstrap-select/bootstrap-select.min.css'>
<script src='<?php echo base_url(FD_PUBLIC);?>/AdminLTE/plugins/bootstrap-select/bootstrap-select.min.js'></script>
<script src='<?php echo base_url(FD_PUBLIC);?>/AdminLTE/plugins/bootstrap-select/i18n/defaults-zh_CN.min.js'></script>
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
<?php //$pk= $model->table_primary_key(); ?>
<!-- Horizontal Form -->
<div class="box box-info"><!--
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo ( $this->input->post($pk) ) ? '编辑': '新增'; ?>信息</h3>
	</div>
	 /.box-header -->

<div class="box-body">
    <div>
        <form action="<?php echo Soma_const_url::inst()->get_url('*/*/*' ); ?>" class="form_inline" method="get" accept-charset="utf-8">
            <div class="form-group">
                <div class="input-group col-md-3" style="margin-bottom: 5px;">
                    <div class="input-group-addon">订单号</div>
                    <input type="text" class="form-control" name="oid" value="<?php echo $order_id; ?>" id="oid" placeholder="请输入订单号">
                </div>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-sm bg-green"><i class="fa"></i> 业绩查询</button>
                <button id="rebuild" type="button" class="btn btn-sm bg-green"><i class="fa"></i> 业绩重建</button>
                <button id="resend" type="button" class="btn btn-sm bg-green"><i class="fa"></i> 业绩推送</button>
            </div>
        </form>
    </div>
    <hr />
    <?php if(count($reward_info) > 0): ?>
    <div>
        <div></div>
        <table class="table table-bordered">
            <thead><tr>
                <?php foreach ($header as $title): ?>
                    <th><?php echo $title;?></th>
                <?php endforeach; ?>
            </tr></thead>
            <tbody>
                <?php foreach($reward_info as $row): ?>
                    <tr>
                        <?php foreach($row as $column): ?>
                            <td><?php echo $column; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
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
<script src="http://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script>

var slt_dist= $('#el_distributor').val();
$('#el_distributor').change(function(){
	$.cookie('soma_default_distributor', slt_dist, { expires: 7 });
});
var old_dist= $.cookie('soma_default_distributor');
if( slt_dist=='' && old_dist!=null) {
	$('#el_distributor').val(old_dist);
}

$("#rebuild").click(function(){
    // ajax提交数据
    alert('业绩重建');
});

$("#resend").click(function(){
    // ajax提交数据
    alert('业绩推送');
});

</script>
</body>
</html>
