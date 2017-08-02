<!-- DataTables -->
<link rel="stylesheet"
	href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<style>
<!--
@font-face {
	font-family: 'iconfont';
	/*src: url('iconfont.eot');  IE9*/
	/*src: url('iconfont.eot?#iefix') format('embedded-opentype'),  IE6-IE8 */
	src: url('<?php echo base_url('public/fonts/iconfont.woff ')?>') format('woff'), /* chrome、firefox */
    url('<?php echo base_url('public/fonts/iconfont.ttf ')?>') format('truetype') /* chrome、firefox、opera、Safari, Android, iOS 4.2+*/
		 /*url('iconfont.svg#svgFontName') format('svg');  iOS 4.1- */
}

.iconfont {
	font-family: "iconfont";
	font-style: normal;
	font-size: 1.8em;
	vertical-align: middle;
	display: inline-block;
}
-->
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
				<h1>
					数据导入 <small></small>
				</h1>
				<ol class="breadcrumb"><?php echo $breadcrumb_html; ?></ol>
			</section>
			<!-- Main content -->
			<section class="content">

				<form role="form" method='post' id='form1' action=''>
					<input type='hidden' name='<?php echo $csrf_token;?>' value='<?php echo $csrf_value;?>' />
					<!-- Main content -->
					<section class="content">
						<div class="row">
							<!-- right column -->
							<div class="col-xs-12">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">导入说明(请对照模板阅读)</h3>
									</div>
									<div class="box-body" class="col-sm-2 control-label">
									<label></label>
									<ul class="col-sm-10">
						            <li><p>若需自动生成酒店介绍图，请将图片按此规则命名："公众号inter_id"-hi-编号(A列).jpg，如某公众号编号为1的酒店数据图片名为：a429262688-hi-1.jpg，图片格式须为jpg，酒店介绍图( I 列)留空，并勾选“自动生成图片路径”。然后将图片发给金房卡相关工作人员批量上传。</p></li>
						            <li><p>如果已经有图片路径，酒店介绍图( I 列)就直接填图片路径，如：http://file.iwide.cn/public/uploads/201603/qf281123285930.jpg，当酒店介绍图不为空时，勾选“自动生成图片路径”就不会生成该酒店图片，而是使用该路径。</p></li>
						            <li><p>服务图标（ T 列）请选择下面的"服务图标"来填写，图标在页面上显示顺序与填写顺序一致，填写规则为：图标id1,图标id2，如 132,135</p></li>
						            <li><p>酒店提供服务（ J 列）为酒店服务的文字说明，若不填写且勾选“自动生成服务说明”则会根据所选服务图片填入，如服务图标填写132,135，则会生成“热水 Wifi”</p></li>
						            </ul>
						            </div>
									<div class="box-body">
									<label>服务图标：</label>
						            <?php foreach ($services as $service){?>
											<label class="checkbox-inline"> 
											<?php echo $service['id'].':'.$service['info'];?>
											<em class="iconfont" title="<?php echo $service['info']?>"><?php echo $service['image_url']?></em>
											</label>
									<?php }?>
						            </div>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="box box-info">
									<div class="box-header with-border">
										<h3 class="box-title">导入配置</h3>
									</div>
									<div class="box-body">
										<div class="form-group  has-feedback">
											<label class="col-sm-4 control-label">自动生成图片路径</label>
											<div class="col-sm-4">
												<input type='radio' name='auto_img' value='1' checked />是 
												<input type='radio' name='auto_img' value='0' />否
											</div>
										</div><br />
										<div class="form-group  has-feedback">
											<label class="col-sm-4 control-label">自动生成服务说明</label>
											<div class="col-sm-4">
												<input type='radio' name='auto_ser' value='1' checked />是 
												<input type='radio' name='auto_ser' value='0' />否
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xs-12" style='display:none' id='iresult'>
								<div class="box box-info">
									<div class="box-header with-border">
										<h3 class="box-title">导入结果</h3>
									</div>
									<div class="box-body">
										<div>
											<div class="form-group  has-feedback">
												<p id='itips'></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-xs-12">
								<div class="box box-info">
									<div class="box-header with-border">
										<h3 class="box-title">上传</h3>
									</div>
									<div class="box-body">
										<div class="row">
											<div class="col-sm-5">
												<a href='<?php echo base_url('public/samples/酒店批量导入标准文档.xlsx')?>'>下载模板</a>
												<div class="dataTables_info" id="data-grid_info" role="status" aria-live="polite">
													<input type="file" name="file" id="file" value="批量导入" />
													<p>
														<a href="javascript:$('#file').uploadify('upload','*')">确定</a>|
														<a href="javascript:$('#file').uploadify('cancel')">取消上传</a>
													</p>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xs-12 ">
								<button type="button" id='sub' onclick='sub()' class="btn btn-primary " style='margin-left: 40%'>提交</button>
							</div>
						</div>
						<!-- /.row -->
					</section>
				</form>
			</section>
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

<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- page script -->
<script src="<?php echo base_url('public/uploadify/jquery.uploadify.min.js')?>"></script>
<script>
<?php $timestamp=time()?>
$(function() {
	$('#file').uploadify({
		'formData'     : {'timestamp' : '<?php echo $timestamp;?>','token':'<?php echo md5('unique_salt'.$timestamp)?>','<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>'},
		'button_width':50,
        'auto':false,
		'button_height':23,
        'fileTypeExts':'*.xls;*.xlsx',
        'multi':false,
        'fileTypeDesc':'xls,xlsx',
		'buttonText':'批量导入',
		'fileSizeLimit':'1MB',
		'swf'      : '<?php echo base_url('public/uploadify/uploadify.swf')?>',
		'uploader' : '<?php echo site_url('assist/import/xls_upload')?>',
        'onUploadSuccess' : function(file, data, response) {
        	data = JSON.parse(data);
        	$('#iresult').show();
        	$('#itips').html(data.message);
        	if(data.status == 1){
        		$('#sub').hide();
        	}
        }
	});

});
$(document).ready(function() {

});
</script>
</body>
</html>
