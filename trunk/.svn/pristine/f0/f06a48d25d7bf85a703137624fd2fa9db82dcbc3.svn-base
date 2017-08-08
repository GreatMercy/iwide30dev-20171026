<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<style>
@font-face {
  font-family: 'iconfont';
  src: url('<?php echo base_url(FD_PUBLIC) ?>/newfont/iconfont.eot');
  src: url('<?php echo base_url(FD_PUBLIC) ?>/newfont/iconfont.eot?#iefix') format('embedded-opentype'),
  url('<?php echo base_url(FD_PUBLIC) ?>/newfont/iconfont.woff') format('woff'),
  url('<?php echo base_url(FD_PUBLIC) ?>/newfont/iconfont.ttf') format('truetype'),
  url('<?php echo base_url(FD_PUBLIC) ?>/newfont/iconfont.svg#iconfont') format('svg');
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
.input_radio >div{margin-right:28px;}
.input_radio >div >input{display:none;}
.input_radio >div >input+label{font-weight:normal;text-indent:25px;background:url(<?php echo base_url(FD_PUBLIC) ?>/js/img/radio1.png) no-repeat center left;background-size:16%;width:130px;height:30px;line-height:30px;}
.input_radio >div >input:checked+label{background:url(<?php echo base_url(FD_PUBLIC) ?>/js/img/radio2.png) no-repeat center left;background-size:16%;}
.block{display:inline-block;height:18px;width:4px;vertical-align: middle;margin-right:5px;}
.introduce{width:450px;height:150px;margin-left:4px;resize:vertical;}
.add_img{width:77px;height:77px;background:url(<?php echo base_url(FD_PUBLIC) ?>/js/img/214598012363739107.png) no-repeat;background-size:100%;margin-right:20px;float:left;}

.input_checkbox >div >input{display:none;}
.input_checkbox >div >input+label{font-weight:normal;text-indent:25px;background:url(<?php echo base_url(FD_PUBLIC) ?>/js/img/bg.png) no-repeat center left;background-size:15%;width:110px;height:30px;line-height:30px;}
.input_checkbox >div >input:checked+label{background:url(<?php echo base_url(FD_PUBLIC) ?>/js/img/bg2.png) no-repeat center left;background-size:15%;}

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

<?php
	// 生成csrf表单数据
	$token_name = $this->security->get_csrf_token_name();
	$token = $this->security->get_csrf_hash();
	$pk= $model->table_primary_key();
?>

<div class="over_x">
	<div class="content-wrapper" style="min-width:1050px;">
		<div class="banner bg_fff p_0_20">编辑分类or新增分类</div>
		<div class="contents">
			<form action="<?php echo Soma_const_url::inst()->get_url('*/*/edit_post');?>" method="post">
				<input type="hidden" name="<?php echo $pk; ?>" value="<?php echo $model->m_get($pk); ?>" style="display:none;">
				<input type="hidden" name="<?php echo $token_name; ?>" value="<?php echo $token; ?>" style="display:none;">
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_3f51b5"></span>基本信息</div>
					<div class="con_right">
						<div class="hottel_name ">
							<div class="">分类名称</div>
							<div class="input_txt"><input type="text" name="cat_name" value="<?php echo $model->m_get('cat_name'); ?>"/></div>
						</div>
						<div class="address">
							<div class="">分类描述</div>
							<div class="input_txt"><input type="text" name="cat_desc" value="<?php echo $model->m_get('cat_desc'); ?>"/></div>
						</div>
						<div class="jingwei">
							<div class="">父分类</div>
							<div class="input_txt">
								<select id="parent_ids" style="width:450px;" name="parent_id">
									<?php foreach($fields_config['parent_id']['select'] as $k => $v): ?>
										<option value="<?php echo $k; ?>" <?php if($k == $model->m_get('parent_id')):?> selected="selected" <?php endif; ?> ><?php echo $v; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_ff503f"></span>图标</div>
					<div class="con_right">
						<div class="hotel_star">
							<div class="">分类图标</div>
							
							<?php 
								$default = true;
								if($model->m_get('cat_img') 
									&& ! preg_match('/.*common.*/i', $model->m_get('cat_img')) ) {
									$default = false;
								}
							?>

							<div class="input_txt input_radio">
								<div>
									<input type="radio" id="star_5" name="cat_img_" value="/public/mall/common/cat_img/all.png" <?php if($default): ?> checked <?php endif; ?>/>
									<label for="star_5">系统图标（默认)</label>									
								</div>
								<div>
									<input class="star_4" type="radio" id="star_4" name="cat_img_" value="<?php if(!$default){ echo $model->m_get('cat_img'); } else { echo 'non-img'; } ?>" <?php if(!$default): ?> checked <?php endif; ?>/>
									<label for="star_4">自定义图标</label>
								</div>
							</div>
						</div>

						<div class="jingwei clearfix img_upload" style="display:none;">
							<div class="float_left">图标上传</div>
							<div class="clearfix">
								<div class="input_txt file_img_list " style="padding-left:4px;">
									<div id="file" class="add_img" <?php if(!$default): ?> style="display: none;" <?php endif; ?>><input class="display_none file_img" type="file" name="cat_img" /></div>

									<?php if(!$default): ?>
										<div><div class="add_img_box" style="float:left;width:77px;height:77px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:77px;height:77px;overflow:hidden;" src="<?php echo $model->m_get('cat_img')?>"><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont"></i></div></div><div class="add_img_box" style="float:left;width:77px;height:77px;position:relative;margin-right:20px;"><div style="border-radius:50%;overflow:hidden;"><img style="width:77px;height:77px;overflow:hidden;" src="<?php echo $model->m_get('cat_img')?>"></div></div></div>
									<?php endif; ?>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="contents_list bg_fff">
					<div class="con_left"><span class="block bg_4caf50"></span>其他</div>
					<div class="con_right">
						<div class="jingwei">
							<div class="">公众号</div>
							<div class="input_txt">
								<select id="inter_ids" style="width:450px;" name="inter_id">
									<?php foreach($fields_config['inter_id']['select'] as $k => $v): ?>
										<option value="<?php echo $k; ?>" <?php if($k == $model->m_get('inter_id')):?> selected="selected" <?php endif; ?> ><?php echo $v; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="jingwei">
							<div class="">所属门店</div>
							<div class="input_txt">
								<select id="hotel_ids" style="width:450px;" name="hotel_id" >
									<?php foreach($fields_config['hotel_id']['select'] as $k => $v): ?>
										<option value="<?php echo $k; ?>" <?php if($k == $model->m_get('hotel_id')):?> selected="selected" <?php endif; ?> ><?php echo $v; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="jingwei">
							<div class="">关键字</div>
							<div class="input_txt">
								<input type="text" name="cat_keyword" value="<?php echo $model->m_get('cat_keyword');?>"/>
							</div>
						</div>
						<div class="hottel_name ">
							<div class="">分类排序</div>
							<div class="input_txt"><input type="number" name="cat_sort" value="<?php echo $model->m_get('cat_sort');?>"/></div>
						</div>
					</div>
				</div>
				<div class="bg_fff" style="padding:15px;">
					<button class="fom_btn">保存分类</button>
				</div>
			</form>
		</div>
	</div>
</div>

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
<script src="<?php echo base_url(FD_PUBLIC) ?>/uploadify/jquery.uploadify.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/areaData.js"></script>
<script type="text/javascript">
	<?php $timestamp = time();?>
	$(function() {

		// $('#parent_ids').selectpicker({
  //           'selectedText': 'cat'
  //       });
  //       var parent_id = "<?php echo $model->m_get('parent_id'); ?>";
  //       if(parent_id!=""){
  //           $('#parent_ids').selectpicker('val', parent_id);
  //       }
		// $('#inter_ids').selectpicker({
  //           'selectedText': 'cat'
  //       });
  //       var inter_id = "<?php echo $model->m_get('inter_id'); ?>";
  //       if(inter_id!=""){
  //           $('#inter_ids').selectpicker('val', inter_id);
  //       }
  //       $('#hotel_ids').selectpicker({
  //           'selectedText': 'cat'
  //       });
  //       var hotel_id = "<?php echo $model->m_get('hotel_id'); ?>";
  //       if(hotel_id!=""){
  //           $('#hotel_ids').selectpicker('val', hotel_id);
  //       }

		// // $('#el_intro_img').parent().append('<input type="file" value="上传图片" id="upfiles">');

		$('#file').uploadify({
			'formData'     : {
				'<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>',
				'timestamp' : '<?php echo $timestamp;?>',
				'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
			},
			'swf'      : '<?php echo base_url(FD_PUBLIC) ?>/uploadify/uploadify.swf',
			//'uploader' : '<?php echo site_url("basic/upload/hotel_upload") ?>',
			'uploader' : '<?php echo site_url('basic/uploadftp/do_upload') ?>',
			'file_post_name': 'imgFile',
			'buttonImage':"<?php echo base_url(FD_PUBLIC) ?>/js/img/upload.png",
			'height':80,
			'width':80,
		    'onUploadSuccess' : function(file, data, response) {
			    var res = $.parseJSON(data);
        		$('#star_4').val(res.url);
        		$('.add_img_box').remove();
        		$(".file_img_list").append($('<div"><div class="add_img_box" style="float:left;width:77px;height:77px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:77px;height:77px;overflow:hidden;" src="'+res.url+'"/><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont">&#xe635;</i></div></div><div class="add_img_box" style="float:left;width:77px;height:77px;position:relative;margin-right:20px;"><div style="border-radius:50%;overflow:hidden;"><img style="width:77px;height:77px;overflow:hidden;" src="'+res.url+'"/></div></div></div>'));
        		$('#file').fadeOut();
				$('.add_img_box').delegate('.img_close','click',function(){
					$(this).parent().parent().remove();
					$('#file').show();
					$("#file >input").val('');
				});
        	},
		});

		$('.input_radio').change(function() {
			if($('.star_4:checked').val()){
				$('.img_upload').show();
			}else{
				$('.img_upload').hide();
			}
		});
		<?php if(!$default): ?>
			$('#file').hide();
			$('.img_upload').show();
		<?php endif; ?>
		//图片上传排版start
		//  $("#file >input").change(function(e){
  //            var file = this.files[0];
  //            var imageType = /image.*/;
  //            if(file.type.match(imageType)){
  //                var reader = new FileReader();
  //                reader.onload=function(){
  //                   $(".file_img_list").append($('<div"><div class="add_img_box" style="float:left;width:77px;height:77px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:77px;height:77px;overflow:hidden;" src="'+reader.result+'"/><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont">&#xe635;</i></div></div><div class="add_img_box" style="float:left;width:77px;height:77px;position:relative;margin-right:20px;"><div style="border-radius:50%;overflow:hidden;"><img style="width:77px;height:77px;overflow:hidden;" src="'+reader.result+'"/></div></div></div>'));
  //                   $('#file').hide();
		// 	        $('.add_img_box').delegate('.img_close','click',function(){
		// 				$(this).parent().parent().remove();
  //                   	// $('#file').show();
		// 				$("#file >input").val('');
		// 			})
  //                }
  //               reader.readAsDataURL(file);
  //           }
  //       });

		 $('.add_img_box').delegate('.img_close','click',function(){
			$(this).parent().parent().remove();
			$('#file').show();
			$("#file >input").val('');
		})
		//图片上传排版end
	});
</script>