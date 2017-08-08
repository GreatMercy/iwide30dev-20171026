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
<style>

#upfiles-button{ text-align:center; margin-top:15px; background:#F90; color:#fff;}
.radio{display:inline-block; margin-right:50px;}
 table.table-bordered tbody td{cursor:default; text-align:center; vertical-align:middle}
#menu .fa{font-size:30px}
</style>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>首页配置
            <small></small>
          </h1>
          <ol class="breadcrumb"></ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <?php echo $this->session->show_put_msg(); ?>
                <div class="box-body">
                   <?php echo form_open('hotel/home_setting/edit_post',array('method'=>'post'));?>
            <input type="hidden" name="id" value="<?php if(isset($id)) echo $id;?>">
					<div class="form-group col-xs-8">
						<label>首页Logo</label>
						<input type="text" class="form-control" name="img" id="img" placeholder="建议尺寸：500*200" value="<?php if(isset($config['img'])) echo $config['img'];?>">
					</div>
                  	<div class="col-xs-2" id="sight">
                    	<img src="<?php if(isset($config['img'])) echo $config['img'];?>">
                    </div>
                    <div class="form-group  col-xs-8" style="clear:both">
                        <label>首页菜单</label>
                        <table class="table table-bordered" id="showmenu">
                        	<tr><td><label><input type="radio" name="open" value="1" <?php if(isset($config['open']) && $config['open'] ==1) echo 'checked';?>> 隐藏</label></td>
                        	<td><label><input shomenu type="radio" name="open" value="2" <?php if(isset($config['open']) && $config['open'] ==2) echo 'checked';?>> 显示</label></td></tr>
                        </table>
                        <table class="table table-bordered" id="menu" <?php if(isset($config['open']) && $config['open'] ==1) echo 'style="display:none"';?>>
                        	<tr>
                                <td>菜单1</td>
                                <td><select class="form-control" name="menu[1][code]" >
                                        <?php foreach ($select as $key => $value) {?>
                                          <option value="<?php echo $key;?>" <?php if(isset($config['menu'][1]['code']) && $config['menu'][1]['code'] ==$key) echo 'selected';?>><?php echo $value;?></option>
                                        <?php } ?>
                                      </select>
                                 </td>
                                 <td>
                                 	<i class="fa fa-apple"></i>
                                 </td>
                                 <td><input type="text" class="form-control" name="menu[1][desc]" placeholder="添加描述，不超过8个字" value="<?php if(isset($config['menu'][1]['desc'])) echo $config['menu'][1]['desc'];?>"></td>
                            </tr>
                        	<tr>
                                <td>菜单2</td>
                                <td><select class="form-control" name="menu[2][code]" >
                                        <?php foreach ($select as $key => $value) {?>
                                          <option value="<?php echo $key;?>" <?php if(isset($config['menu'][2]['code']) && $config['menu'][2]['code'] ==$key) echo 'selected';?>><?php echo $value;?></option>
                                        <?php } ?>
                                      </select>
                                 </td>
                                 <td>
                                 	<i class="fa fa-apple"></i>
                                 </td>
                                 <td><input type="text" class="form-control" name="menu[2][desc]" placeholder="添加描述，不超过8个字" value="<?php if(isset($config['menu'][2]['desc'])) echo $config['menu'][2]['desc'];?>"></td>
                            </tr>
                        	<tr>
                                <td>菜单3</td>
                                <td><select class="form-control" name="menu[3][code]">
                                        <?php foreach ($select as $key => $value) {?>
                                          <option value="<?php echo $key;?>" <?php if(isset($config['menu'][3]['code']) && $config['menu'][3]['code'] ==$key) echo 'selected';?>><?php echo $value;?></option>
                                        <?php } ?>
                                      </select>
                                 </td>
                                 <td>
                                 	<i class="fa fa-apple"></i>
                                 </td>
                                 <td><input type="text" class="form-control" name="menu[3][desc]" placeholder="添加描述，不超过8个字" value="<?php if(isset($config['menu'][3]['desc'])) echo $config['menu'][3]['desc'];?>"></td>
                            </tr>
                        </table>
                    </div>
                    <div>
                    	
                    </div>
                    <div class="col-xs-12" style="margin-top:20px">
                        <button type="submit" class="btn btn-info">保存</button>
                    </div>
                  <?php echo form_close();?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
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
<script src="<?php echo base_url(FD_PUBLIC) ?>/uploadify/jquery.uploadify.min.js"></script>
<script>
$(function () {
	$('#showmenu').click(function(){
		if($('input[shomenu]').get(0).checked)$('#menu').show();
		else $('#menu').hide();
	})
	$('#img').parent().append('<input type="file" value="上传图片" id="upfiles">');
	$('#upfiles').uploadify({
		'formData'     : {
			'<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>',
			'timestamp' : '',
			'token'     : ''
		},
		'swf'      : '<?php echo base_url(FD_PUBLIC) ?>/uploadify/uploadify.swf',
		'uploader' : '<?php echo site_url('basic/uploadftp/do_upload') ?>',
		'file_post_name': 'imgFile',
		'onUploadSuccess' : function(file, data, response) {
			var res = $.parseJSON(data);
			$('#img').val(res.url);
			$('#sight').html('<img  src="'+res.url+'" />');
		}
	});
	$('.uploadify-button-text').html('选择图片')

});
</script>
</body>
</html>
