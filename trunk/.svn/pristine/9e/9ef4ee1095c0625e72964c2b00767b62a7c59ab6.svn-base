<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<style>
@font-face {
  font-family: 'iconfont';
  src: url('http://test008.iwide.cn/public/newfont/iconfont.eot');
  src: url('http://test008.iwide.cn/public/newfont/iconfont.eot?#iefix') format('embedded-opentype'),
  url('http://test008.iwide.cn/public/newfont/iconfont.woff') format('woff'),
  url('http://test008.iwide.cn/public/newfont/iconfont.ttf') format('truetype'),
  url('http://test008.iwide.cn/public/newfont/iconfont.svg#iconfont') format('svg');
}
.iconfont{
  font-family:"iconfont" !important;
  font-size:16px;font-style:normal;
  -webkit-font-smoothing: antialiased;
  -webkit-text-stroke-width: 0.2px;
  -moz-osx-font-smoothing: grayscale;
}
.over_x{width:100%;overflow-x:auto;}
.bg_fff{background:#fff;}
.bg_3f51b5{background:#3f51b5;}
.bg_ff503f{background:#ff503f;}
.bg_4caf50{background:#4caf50;}
.clearfix:after{content: "" ;display:block;height:0;clear:both;visibility:hidden;}
.display_none{display:none !important;}
.m_b_20{margin-bottom:20px;}
.float_left{float:left;}
.content-wrapper{color:#7e8e9f;}
.p_0_20{padding:0 20px;}
textarea{border:1px solid #d7e0f1;}
.banner{height:50px;width:100%;line-height:50px;border-bottom:1px solid #d7e0f1;}
.contents{padding:10px 20px 20px 20px;}
.contents_list{display:table;width:100%;border:1px solid #d7e0f1;margin-bottom:10px;}
.hotel_star >div:nth-of-type(2) >div,.con_right >div >div{display:inline-block;}
.con_left{width:150px;text-align:center;border-right:1px solid #d7e0f1;display:table-cell;vertical-align:middle;}
.con_right{padding:20px 0 20px 0px;}
.con_right>div{margin-bottom:12px;}
.con_right >div >div:nth-of-type(1){width:115px;height:30px;line-height:30px;text-align:center;}
.input_txt{height:30px;line-height:30px;}
.input_txt >input{height:30px;line-height:30px;border:1px solid #d7e0f1;width:450px;text-indent:3px;}
.input_txt >select{height:30px;line-height:30px;display:inline-block;border:1px solid #d7e0f1;background:#fff;margin-right:20px;padding:0 8px;}
.input_radio >div{margin-right:10px;}
.input_radio >div >input{display:none;}
.input_radio >div >input+label{font-weight:normal;text-indent:25px;background:url(http://test008.iwide.cn/public/js/img/radio1.png) no-repeat center left;background-size:22%;width:90px;height:30px;line-height:30px;}
.input_radio >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/radio2.png) no-repeat center left;background-size:20%;}
.block{display:inline-block;height:18px;width:4px;vertical-align: middle;margin-right:5px;}
.introduce{width:450px;height:150px;margin-left:4px;resize:vertical;}
.add_img{width:77px;height:77px;background:url(http://test008.iwide.cn/public/js/img/214598012363739107.png) no-repeat;background-size:100%;}

.input_checkbox >div >input{display:none;}
.input_checkbox >div >input+label{font-weight:normal;text-indent:25px;background:url(http://test008.iwide.cn/public/js/img/bg.png) no-repeat center left;background-size:15%;width:110px;height:30px;line-height:30px;}
.input_checkbox >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/bg2.png) no-repeat center left;background-size:15%;}


.fom_btn{background:#ff9900;color:#fff;outline:none;border:0px;padding:6px 25px;border-radius:3px;margin:auto;display:block;}
.add_img_box:hover > .img_close{display:block !important;cursor:pointer;}
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
<div class="over_x">
	<div class="content-wrapper" style="min-width:1050px;">
		<div class="banner bg_fff p_0_20">编辑房型／新增房型</div>
		<div class="contents">
			<from>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_3f51b5"></span>基本信息</div>
					<div class="con_right">
						<div class="hottel_name ">
							<div class="">房型名称</div>
							<div class="input_txt"><input type="text" /></div>
						</div>
						<div class="address">
							<div class="">面积</div>
							<div class="input_txt"><input type="text" /></div>
						</div>
						<div class="jingwei">
							<div class="">床数</div>
							<div class="input_txt"><input type="text" /></div>
						</div>
					</div>
				</div>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_ff503f"></span>房型介绍</div>
					<div class="con_right">
						<div class="hottel_name clearfix">
							<div class="float_left">房型简介</div>
							<div class="input_txt">
								<textarea class="introduce"></textarea>
							</div>
						</div>
						<div class="jingwei clearfix">
							<div class="float_left">介绍图片</div>
							<div class="input_txt file_img_list" style="padding-left:4px;">
								<label id="file" class="add_img"><input class="display_none file_img" type="file" /></label>
							</div>
						</div>
						<div class="hotel_star clearfix">
							<div class="float_left">房型服务</div>
							<div class="input_txt input_checkbox">
								<div>
									<input type="checkbox" id="wf" name="" value="Wi-Fi"/>
									<label for="wf">Wi-Fi</label>
								</div>
								<div>
									<input type="checkbox" id="con_room" name="" value="会议室"/>
									<label for="con_room">淋浴</label>
								</div>
								<div>
									<input type="checkbox" id="shuttle" name="" value="专车接送"/>
									<label for="shuttle">吹风机</label>
								</div>
								<div>
									<input type="checkbox" id="luggage" name="" value="行李寄存"/>
									<label for="luggage">有线网</label>
								</div>
								<div>
									<input type="checkbox" id="stop" name="" value="停车场"/>
									<label for="stop">有线电视</label>
								</div>
								<br>
								<div>
									<input type="checkbox" id="swimming" name="" value="游泳池"/>
									<label for="swimming">叫醒服务</label>
								</div>
								<div>
									<input type="checkbox" id="spa" name="" value="足浴/SPA"/>
									<label for="spa">早餐</label>
								</div>
								<!-- <div>
									<input type="checkbox" id="chess" name="" value="棋牌室"/>
									<label for="chess">棋牌室</label>
								</div>
								<div>
									<input type="checkbox" id="bodybuilding" name="" value="健身房"/>
									<label for="bodybuilding">健身房</label>
								</div>
								<div>
									<input type="checkbox" id="ktv" name="" value="KTV"/>
									<label for="ktv">KTV</label>
								</div> -->
							</div>
						</div>
					</div>
				</div>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_4caf50"></span>价格&排序</div>
					<div class="con_right">
						<div class="hottel_name ">
							<div class="">房量</div>
							<div class="input_txt"><input type="text" /></div>
						</div>
						<div class="hottel_name ">
							<div class="">房型排序</div>
							<div class="input_txt"><input type="text" /></div>
						</div>
						<div class="jingwei">
							<div class="">房型状态</div>
							<div class="input_txt" >
								<select style="width:450px;">
									<option>有效</option>
									<option>无效</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="bg_fff" style="padding:15px;">
					<button class="fom_btn">保存房型</button>
				</div>
			</from>
		</div>
	</div>
</div>
      <!-- Content Wrapper. Contains page content -->
      <!-- <div class="content-wrapper"> -->
        <!-- Content Header (Page header) -->
    <!--     <section class="content-header">
          <h1><?php echo isset($breadcrumb_array['action'])? $breadcrumb_array['action']: ''; ?>
            <small></small>
          </h1>
          <ol class="breadcrumb"><?php echo $breadcrumb_html; ?></ol>
        </section> -->
        <!-- Main content -->
       <!--  <section class="content"> -->

<!-- <?php echo $this->session->show_put_msg(); ?>
<?php $pk= $model->table_primary_key(); ?> -->
<!-- Horizontal Form -->
<!-- <div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo ( $this->input->post($pk) ) ? '编辑': '新增'; ?>信息</h3>
	</div> -->
	<!-- /.box-header -->
<!-- form start -->
<!--	<?php 
	echo form_open( EA_const_url::inst()->get_url('*/*/edit_post'), array('class'=>'form-horizontal'), array($pk=>$model->m_get($pk) ) ); ?>
		<div class="box-body">
            <?php foreach ($fields_config as $k=>$v): ?>
				<?php 
                if($check_data==FALSE) echo EA_block_admin::inst()->render_from_element($k, $v, $model); 
                else echo EA_block_admin::inst()->render_from_element($k, $v, $model, FALSE); 
                ?>
			<?php endforeach; ?>
			<div class="form-group" style="padding-left:20px;">
			
			<?php foreach ($services as $service):?>
			<label class="checkbox-inline">
				<input type="checkbox" name="ser[]" value="<?php echo htmlspecialchars ($service->image_url)?>" <?php if(in_array($service->image_url,$hotel_ser)): echo ' checked';endif; ?>><em class="iconfont" title="<?php echo $service->info?>"><?php echo $service->image_url?></em>
			</label>
			<?php endforeach;?>
			</div>
 
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox" /> 选项
						</label>
					</div>
				</div>
			</div>
 
		</div>-->
		<!-- /.box-body --><!-- 
		<div class="box-footer ">
            <div class="col-sm-4 col-sm-offset-4">
                <button type="submit" class="btn btn-info pull-right">保存</button>
            </div>
		</div> -->
		<!-- /.box-footer -->
<!-- 	<?php echo form_close() ?>
</div> -->
<!-- /.box -->

        <!-- </section> -->
        <!-- /.content -->
     <!--  </div> -->
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
</body>
</html>
<script src="<?php echo base_url(FD_PUBLIC) ?>/uploadify/jquery.uploadify.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/areaData.js"></script>
<script type="text/javascript">
	<?php $timestamp = time();?>
	$(function() {
		$('#el_intro_img').parent().append('<input type="file" value="上传图片" id="upfiles">');
		$('#upfiles').uploadify({
			'formData'     : {
				'<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>',
				'timestamp' : '<?php echo $timestamp;?>',
				'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
			},
			'swf'      : '<?php echo base_url(FD_PUBLIC) ?>/uploadify/uploadify.swf',
			//'uploader' : '<?php echo site_url("basic/upload/hotel_upload") ?>',
			'uploader' : '<?php echo site_url('basic/uploadftp/do_upload') ?>',
			'file_post_name': 'imgFile',
		    'onUploadSuccess' : function(file, data, response) {
			    var res = $.parseJSON(data);
        		$('#el_intro_img').val(res.url);
        	}
		});
		//图片上传排版start
		 $("#file >input").change(function(e){
             var file = this.files[0];
             var imageType = /image.*/;
             if(file.type.match(imageType)){
                 var reader = new FileReader();
                 reader.onload=function(){
                    $(".file_img_list").prepend($('<div class="add_img_box" style="float:left;width:77px;height:77px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:77px;height:77px;overflow:hidden;" src="'+reader.result+'"/><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont">&#xe635;</i></div></div>'));
			        $('.add_img_box').delegate('.img_close','click',function(){
						$(this).parent().remove();
						$("#file >input").val('');
					})
                 }
                reader.readAsDataURL(file);
            }
        });

		//图片上传排版end
		//地区调用start
		var sheng = areaData.sheng;
		var $sheng = $('#sheng');
		var $shi = $('#shi');
		var $xian = $('#xian');
		var shiIndex = 0;
			for ( var i=0;i<sheng.length;i++ ){
				var $option = $('<option value='+ (i+1) +'>'+ sheng[i] +'</option>');
				$sheng.append( $option );
			}
			$sheng.change(function(){
				shiIndex = this.selectedIndex - 1;
				if ( shiIndex < 0 ){

				}else{
					var shi = areaData.shi['a_'+shiIndex];
					$shi.html('<option value="0">地市选择</option>');
					$xian.html('<option value="0">区县选择</option>');
					for (var i=0;i<shi.length;i++ ){
						var $option = $('<option value='+ (i+1) +'>'+ shi[i] +'</option>');
						$shi.append( $option );
					}
				}
			});
			$shi.change(function(){
				var index = this.selectedIndex - 1;
				if ( index < 0 ){

				}else{
					var xian = areaData.xian['a_'+shiIndex+'_'+index];
					$xian.html('<option value="0">区县选择</option>');
					for (var i=0;i<xian.length;i++ ){
						var $option = $('<option value='+ (i+1) +'>'+ xian[i] +'</option>');
						$xian.append( $option );
					}
				}
			});
		//地区调用end
	});
</script>