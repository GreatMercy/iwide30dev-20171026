<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<link href="<?php echo base_url(FD_PUBLIC) ?>/js/art_Dialog/skins/default.css" rel="stylesheet" />
<!--[if lt IE 9]>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<!--<link rel='stylesheet' href='--><?php //echo base_url(FD_PUBLIC) ?><!--/AdminLTE/plugins/datepicker/datepicker3.css'>-->
<link rel='stylesheet' href='<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/date-timepicker/jquery.datetimepicker.css'>
<link rel='stylesheet' href='<?php echo base_url(FD_PUBLIC) ?>/js/artDialog/css/ui-dialog.css'>
<script type="text/javascript" src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/date-timepicker/jquery.datetimepicker.min.js"></script>
<script type="text/javascript">
    //全局变量
    var GV = {
        DIMAUB: "<?php echo base_url();?>",
        JS_ROOT: "<?php echo FD_PUBLIC ?>/js/",
    };
</script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/wind.js"></script>
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
                    <h3 class="box-title">添加卡券</h3>
                </div>
                <?php echo form_open(EA_const_url::inst()->get_url('*/*/edit_post'), array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
                <input type="hidden" name="card_id" value="<?php if ( isset($cardinfo['card_id']) && $cardinfo['card_id'] ){ echo $cardinfo['card_id']; } ?>" />
                <div class="box-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="20%">卡券类型</th>
                            <th>
                                <select class="form-control card_type_c" name="card_type" >
                                    <option value=""  >--请选择卡券类型--</option>
                                    <option value="1" <?php if(isset($cardinfo['card_type']) && $cardinfo['card_type']=='1' ){ echo 'selected'; } ?> >抵用券</option>
                                    <option value="2" <?php if(isset($cardinfo['card_type']) && $cardinfo['card_type']=='2' ){ echo 'selected'; } ?> >折扣券</option>
                                    <option value="3" <?php if(isset($cardinfo['card_type']) && $cardinfo['card_type']=='3' ){ echo 'selected'; } ?> >兑换券</option>
                                    <option value="4" <?php if(isset($cardinfo['card_type']) && $cardinfo['card_type']=='4' ){ echo 'selected'; } ?> >储值券</option>
                                </select>
                            </th>
                        </tr>
                        <?php if($inter_id == 'ALL_PRIVILEGES'){ ?>
                            <tr>
                                <th>适用酒店</th>
                                <th>
                                    <select class="form-control card_type_c" name="apply_inter[]" multiple="multiple" >
                                        <option value=""  >--请选择适用酒店--</option>
                                        <?php foreach ($publics as $k=>$v){ ?>
                                            <option value="<?php echo $v->inter_id; ?>" <?php if( isset($cardinfo['inter_id']) && strstr( $cardinfo['apply_inter'] , $v->inter_id )  ){ echo "selected"; } ?>  ><?php echo $v->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </th>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>渠道类型</th>
                            <th>
                                <select class="form-control" name="module[]" multiple >
                                    <option value=""  >--请选择渠道类型--</option>
                                    <option value="vip" <?php if(isset($cardinfo['module']) && in_array('vip',$cardinfo['module']) ){ echo 'selected'; } ?> >会员</option>
                                    <option value="shop" <?php if(isset($cardinfo['module']) && in_array('shop',$cardinfo['module']) ){ echo 'selected'; } ?> >商城</option>
                                    <option value="hotel" <?php if(isset($cardinfo['module']) && in_array('hotel',$cardinfo['module']) ){ echo 'selected'; } ?> >订房</option>
                                    <!-- <option value="package" <?php if(isset($cardinfo['module']) && in_array('package',$cardinfo['module']) ){ echo 'selected'; } ?> >套票</option> -->
                                    <option value="soma" <?php if(isset($cardinfo['module']) && in_array('soma',$cardinfo['module']) ){ echo 'selected'; } ?> >套票</option>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th>卡券说明</th>
                            <th><input class="form-control" name="card_note" value="<?php if(isset($cardinfo['card_note']) && $cardinfo['card_note'] ){ echo $cardinfo['card_note']; }?>"  placeholder="请填写卡券说明"/></th>
                        </tr>
                        <tr>
                            <th>卡券LOGO</th>
                            <th>
                                <div class="tv-thumb" style="float: left;width: 130px;text-align: center;">
                                    <input type="hidden" name="logo_url" id="logo_url" value="">
                                    <a class="thumb-row" href="javascript:void(0);" onclick="flashupload('thumb_images', 'LOGO上传','logo_url',thumb_images,'front,depositcard,1,1024,jpg|gif|png');return false;">
                                        <?php if(isset($cardinfo['logo_url']) && $cardinfo['logo_url']):?>
                                            <img src="<?php echo $cardinfo['logo_url'];?>" id="logo_url_preview" style="width: 100%; cursor: hand;border: 2px solid #c0c0c0;"/>
                                        <?php else:?>
                                            <img src="<?php echo base_url(FD_PUBLIC);?>/images/default-thumb.png" id="logo_url_preview" style="width: 100%; cursor: hand;border: 2px solid #c0c0c0;"/>
                                        <?php endif;?>
                                    </a>
                                    <input type="button" style="margin-top: 10px;color: #fff;font-weight: bold;" class="btn btn-small" onclick="$('#logo_url_preview').attr('src','<?php echo base_url(FD_PUBLIC);?>/images/default-thumb.png');$('#logo_url').val('');return false;" value="取消图片">
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>商户名称</th>
                            <th><input class="form-control" name="brand_name" value="<?php if(isset($cardinfo['brand_name']) && $cardinfo['brand_name'] ){ echo $cardinfo['brand_name']; }?>"  placeholder="请填写商户名称"/></th>
                        </tr>
                        <tr>
                            <th>卡券名称</th>
                            <th><input class="form-control" name="title" value="<?php if(isset($cardinfo['title']) && $cardinfo['title'] ){ echo $cardinfo['title']; }?>" placeholder="请填写卡券名称" /></th>
                        </tr>
                        <tr>
                            <th>卡券副名</th>
                            <th><input class="form-control" name="sub_title" value="<?php if(isset($cardinfo['sub_title']) && $cardinfo['sub_title'] ){ echo $cardinfo['sub_title']; }?>" placeholder="请填写卡券副标题" /></th>
                        </tr>
                        <tr>
                            <th>使用提醒</th>
                            <th><input class="form-control" name="notice" value="<?php if(isset($cardinfo['notice']) && $cardinfo['notice'] ){ echo $cardinfo['notice']; }?>" placeholder="请填写使用提醒" /></th>
                        </tr>
                        <tr>
                            <th>使用说明</th>
                            <th>
                                <textarea name="description"  class="form-control" placeholder="请填写使用说明" ><?php if(isset($cardinfo['description']) && $cardinfo['description'] ){ echo $cardinfo['description']; }?></textarea>
                            </th>
                        </tr>
                        <tr>
                            <th>卡券库存</th>
                            <th><input class="form-control"  name="card_stock" value="<?php if(isset($cardinfo['card_stock']) && $cardinfo['card_stock'] ){ echo $cardinfo['card_stock']; }?>" placeholder="请填写卡券库存" ></th>
                        </tr>
                        <tr>
                            <th>是否F码</th>
                            <th>
                                <select class="form-control" name="is_f" >
                                    <option value="f" <?php if(isset($cardinfo['is_f']) && $cardinfo['is_f']=='f' ){ echo 'selected'; }  ?> >--否--</option>
                                    <option value="t" <?php if(isset($cardinfo['is_f']) && $cardinfo['is_f']=='t' ){ echo 'selected'; }  ?> >--是--</option>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th>运营范围</th>
                            <th>
                                <select class="form-control" name="is_online" >
                                    <option value="1" <?php if(isset($cardinfo['is_online']) && $cardinfo['is_online']=='1' ){ echo 'selected'; } ?> >--线上--</option>
                                    <option value="2" <?php if(isset($cardinfo['is_online']) && $cardinfo['is_online']=='2' ){ echo 'selected'; } ?> >--线下--</option>
                                    <option value="3" <?php if(isset($cardinfo['is_online']) && $cardinfo['is_online']=='3' ){ echo 'selected'; } ?> >--全部--</option>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th>消费密码</th>
                            <th>
                                <input class="form-control" name="passwd" value="<?php if(isset($cardinfo['passwd']) && $cardinfo['passwd'] ){ echo $cardinfo['passwd']; } ?>" placeholder="请填消费密码" />
                            </th>
                        </tr>
                        <tr>
                            <th>卡券页面属性</th>
                            <th>
                                <input class="form-control" name="page_config" value="<?php if(isset($cardinfo['page_config']) && $cardinfo['page_config'] ){ echo $cardinfo['page_config']; } ?>" placeholder="请填写页面属性" />
                            </th>
                        </tr>
                        <tr>
                            <th>通用使用链接</th>
                            <th>
                                <input class="form-control" name="header_url" value="<?php if(isset($cardinfo['header_url']) && $cardinfo['header_url'] ){ echo $cardinfo['header_url']; } ?>" placeholder="请填使用地址" />
                            </th>
                        </tr>
                        <tr>
                            <th>订房使用链接</th>
                            <th>
                                <input class="form-control" name="hotel_header_url" value="<?php if(isset($cardinfo['hotel_header_url']) && $cardinfo['hotel_header_url'] ){ echo $cardinfo['hotel_header_url']; } ?>" placeholder="请填使用地址" />
                            </th>
                        </tr>
                        <tr>
                            <th>商城使用链接</th>
                            <th>
                                <input class="form-control" name="shop_header_url" value="<?php if(isset($cardinfo['shop_header_url']) && $cardinfo['shop_header_url'] ){ echo $cardinfo['shop_header_url']; } ?>" placeholder="请填使用地址" />
                            </th>
                        </tr>
                        <tr>
                            <th>套票使用链接</th>
                            <th>
                                <input class="form-control" name="soma_header_url" value="<?php if(isset($cardinfo['soma_header_url']) && $cardinfo['soma_header_url'] ){ echo $cardinfo['soma_header_url']; } ?>" placeholder="请填使用地址" />
                            </th>
                        </tr>
                        <tr>
                            <th>是否可转赠</th>
                            <th>
                                <select class="form-control" name="can_give_friend" >
                                    <option value="f" <?php if(isset($cardinfo['can_give_friend']) && $cardinfo['can_give_friend']=='f' ){ echo 'selected'; } ?>>否</option>
                                    <option value="t" <?php if(isset($cardinfo['can_give_friend']) && $cardinfo['can_give_friend']=='t' ){ echo 'selected'; } ?>>是</option>
                                </select>
                            </th>
                        </tr>
                        <tr class="least_cost" <?php if( isset($cardinfo['card_type']) && $cardinfo['card_type']!=1 ){ echo "style='display:none;'"; } ?> >
                            <th>抵用券起用金额</th>
                            <th>
                                <input type="number" class="form-control" name="least_cost" value="<?php if(isset($cardinfo['least_cost']) && $cardinfo['least_cost'] ){ echo $cardinfo['least_cost']; } ?>" placeholder="请填写抵用券起用金额" />
                            </th>
                        </tr>
                        <tr class="over_limit" <?php if( isset($cardinfo['card_type']) && $cardinfo['card_type']!=1){ echo "style='display:none;'"; } ?> >
                            <th>优惠劵抵用上限金额</th>
                            <th>
                                <input type="number" class="form-control" name="over_limit" value="<?php if(isset($cardinfo['over_limit']) && $cardinfo['over_limit'] ){ echo $cardinfo['over_limit']; } ?>" placeholder="优惠劵抵用上限金额" />
                            </th>
                        </tr>
                        <tr class="reduce_cost" <?php if( isset($cardinfo['card_type']) && $cardinfo['card_type']!=1 ){ echo "style='display:none;'"; } ?> >
                            <th>抵用券减免金额</th>
                            <th>
                                <input class="form-control" name="reduce_cost" value="<?php if(isset($cardinfo['reduce_cost']) && $cardinfo['reduce_cost'] ){ echo $cardinfo['reduce_cost']; } ?>" placeholder="请填写抵用券减免金额" />
                            </th>
                        </tr>
                        <tr class="discount" <?php if( isset($cardinfo['card_type']) && $cardinfo['card_type']!=2 ){ echo "style='display:none;'"; } ?> >
                            <th>折扣劵打折额度</th>
                            <th>
                                <input class="form-control" name="discount" value="<?php if(isset($cardinfo['discount']) && $cardinfo['discount'] ){ echo $cardinfo['discount']; } ?>" placeholder="请填写折扣劵打折额度" />
                            </th>
                        </tr>
                        <tr class="exchange" <?php if( isset($cardinfo['card_type']) && $cardinfo['card_type']!=3 ){ echo "style='display:none;'"; } ?> >
                            <th>兑换券说明</th>
                            <th>
                                <textarea class="form-control" name="exchange" placeholder="请填写兑换券说明"><?php if(isset($cardinfo['exchange']) && $cardinfo['exchange'] ){ echo $cardinfo['exchange']; } ?></textarea>
                            </th>
                        </tr>
                        <tr class="money" <?php if( isset($cardinfo['card_type']) && $cardinfo['card_type']!=4 ){ echo "style='display:none;'"; } ?> >
                            <th>储值券金额</th>
                            <th>
                                <input class="form-control" name="money" value="<?php if(isset($cardinfo['money']) && $cardinfo['money'] ){ echo $cardinfo['money']; } ?>" placeholder="请填写储值券金额"/>
                            </th>
                        </tr>
                        <tr>
                            <th>备注</th>
                            <th>
                                <textarea class="form-control" name="remark" placeholder="请填写备注"><?php if(isset($cardinfo['remark']) && $cardinfo['remark'] ){ echo $cardinfo['remark']; } ?> </textarea>
                            </th>
                        </tr>
                        <tr>
                            <th>领取起始时间</th>
                            <th>
                                <div class="bdtime" style="">
                                    <input class="form-control" type="text" autocomplete="off" name="time_start" placeholder="<?php echo date('Y-m-d');?>" value="<?php if(isset($cardinfo['time_start']) && $cardinfo['time_start'] ){ echo date('Y-m-d',$cardinfo['time_start']); }?>">
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>领取结束时间</th>
                            <th>
                                <div class="bdtime" style="">
                                    <input class="form-control" type="text" autocomplete="off" name="time_end" placeholder="<?php echo date('Y-m-d');?>" value="<?php if(isset($cardinfo['time_end']) && $cardinfo['time_end'] ){ echo date('Y-m-d',$cardinfo['time_end']); }?>">
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>使用开始时间</th>
                            <th>
                                <div class="use_time_start" style="">
                                    <input class="form-control" type="text" autocomplete="off" name="use_time_start" placeholder="<?php echo date('Y-m-d');?>" value="<?php if(isset($cardinfo['use_time_start']) && $cardinfo['use_time_start'] ){ echo date('Y-m-d',$cardinfo['use_time_start']); }?>">
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>使用失效时间模式</th>
                            <th>
                                <select class="form-control end_model" name="use_time_end_model" >
                                    <option value="g" <?php if(isset($cardinfo['use_time_end_model']) && $cardinfo['use_time_end_model']=='g' ){ echo 'selected'; } ?>>固定失效时间</option>
                                    <option value="y" <?php if(isset($cardinfo['use_time_end_model']) && $cardinfo['use_time_end_model']=='y' ){ echo 'selected'; } ?>>领取后存活时间</option>
                                </select>
                            </th>
                        </tr>
                        <tr class="use_time_end_c" <?php if(isset($cardinfo['use_time_end_model']) &&  $cardinfo['use_time_end_model']=='y'){ echo "style='display:none;'"; } ?> >
                            <th>使用失效时间</th>
                            <th>
                                <div class="bdtime" style="">
                                    <input class="form-control" type="text" autocomplete="off" name="use_time_end" placeholder="<?php echo date('Y-m-d');?>" value="<?php if(isset($cardinfo['use_time_end']) && $cardinfo['use_time_end'] ){ echo date('Y-m-d',$cardinfo['use_time_end']); }?>">
                                </div>
                            </th>
                        </tr>
                        <tr class="use_time_end_d" <?php if(isset($cardinfo['use_time_end_model']) &&  $cardinfo['use_time_end_model']=='g'){ echo "style='display:none;'"; } ?>  >
                            <th>使用失效天数</th>
                            <th>
                                <div class="bdtime" style="">
                                    <input class="form-control" type="text" name="use_time_end_day" value="<?php if(isset($cardinfo['use_time_end_day']) && $cardinfo['use_time_end_day'] ){ echo $cardinfo['use_time_end_day']; }else{ echo '0'; } ?>">
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>是否有效</th>
                            <th>
                                <select class="form-control" name="is_active" >
                                    <option value="f" <?php if(isset($cardinfo['is_active']) && $cardinfo['is_active']=='f' ){ echo 'selected'; } ?>>否</option>
                                    <option value="t" <?php if(isset($cardinfo['is_active']) && $cardinfo['is_active']=='t' ){ echo 'selected'; } ?>>是</option>
                                </select>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="box-footer ">
                    <button type="submit" class="btn btn-primary dosave">保存</button>
                </div>
                <?php echo form_close() ?>
                <!-- /.box-footer -->
            </div>
    </div>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/content_addtop.js"></script>
    <script type="text/javascript">
        $(function(){
            var ok_url="<?php echo EA_const_url::inst()->get_url('*/*');?>";
            $('.end_model').change(function(){
                var val = $(this).val();
                if(val=='g'){
                    $('.use_time_end_d').hide();
                    $('.use_time_end_d').find('input').prop('disabled', true);
                    $('.use_time_end_c').show();
                    $('.use_time_end_c').find('input').prop('disabled', false);
                }
                if(val=='y'){
                    $('.use_time_end_d').show();
                    $('.use_time_end_d').find('input').prop('disabled', false);
                    $('.use_time_end_c').hide();
                    $('.use_time_end_c').find('input').prop('disabled', true);
                }
            });

            $('.card_type_c').change(function(){
                var val = $(this).val();
                if(val=='1'){
                    $('.least_cost').show();
                    $('.least_cost').find('input').prop('disabled', false);
                    $('.reduce_cost').show();
                    $('.reduce_cost').find('input').prop('disabled', false);
                    $('.over_limit').show();
                    $('.over_limit').find('input').prop('disabled', false);
                    $('.discount').hide();
                    $('.discount').find('input').prop('disabled', true);
                    $('.exchange').hide();
                    $('.exchange').find('textarea').prop('disabled', true);
                    $('.money').hide();
                    $('.money').find('input').prop('disabled', true);
                }
                if(val=='2'){
                    $('.least_cost').hide();
                    $('.least_cost').find('input').prop('disabled', true);
                    $('.over_limit').hide();
                    $('.over_limit').find('input').prop('disabled', true);
                    $('.reduce_cost').hide();
                    $('.reduce_cost').find('input').prop('disabled', true);
                    $('.discount').show();
                    $('.discount').find('input').prop('disabled', false);
                    $('.exchange').hide();
                    $('.exchange').find('textarea').prop('disabled', true);
                    $('.money').hide();
                    $('.money').find('input').prop('disabled', true);
                }
                if(val=='3'){
                    $('.least_cost').hide();
                    $('.least_cost').find('input').prop('disabled', true);
                    $('.over_limit').hide();
                    $('.over_limit').find('input').prop('disabled', true);
                    $('.reduce_cost').hide();
                    $('.reduce_cost').find('input').prop('disabled', true);
                    $('.discount').hide();
                    $('.discount').find('input').prop('disabled', true);
                    $('.exchange').show();
                    $('.exchange').find('textarea').prop('disabled', false);
                    $('.money').hide();
                    $('.money').find('input').prop('disabled', true);
                }
                if(val=='4'){
                    $('.least_cost').hide();
                    $('.least_cost').find('input').prop('disabled', true);
                    $('.over_limit').hide();
                    $('.over_limit').find('input').prop('disabled', true);
                    $('.reduce_cost').hide();
                    $('.reduce_cost').find('input').prop('disabled', true);
                    $('.discount').hide();
                    $('.discount').find('input').prop('disabled', true);
                    $('.exchange').hide();
                    $('.exchange').find('textarea').prop('disabled', true);
                    $('.money').show();
                    $('.money').find('input').prop('disabled', false);
                }
            });

            Wind.use("ajaxForm","artDialog", function () {
                $(document).on('click', '.dosave', function (e) {
                    e.preventDefault();
                    var _this = this, ok_url = "<?php echo EA_const_url::inst()->get_url('*/*/');?>", btn = $(this);
                    var form = $('.form-horizontal'), form_url = form.attr("action");
                    //ie处理placeholder提交问题
                    if ($.support.msie) {
                        form.find('[placeholder]').each(function () {
                            var input = $(this);
                            if (input.val() == input.attr('placeholder')) {
                                input.val('');
                            }
                        });
                    }

                    form.ajaxSubmit({
                        url: form_url,
                        dataType: 'json',
                        beforeSubmit: function (arr, $form, options) {
                            /*验证提交数据*/
                            var _null = false, _msg = '', inputos = document.getElementsByTagName('input'), selectos = document.getElementsByTagName('select'), _inputo = null;
                            for (i in inputos) {
                                var name = inputos[i].name, value = $.trim(inputos[i].value);
                                _inputo = inputos[i];
                                switch (name) {
                                    case 'brand_name':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请填写商户名称';
                                        }
                                        break;
                                    case 'title':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请填写卡券名称';
                                        }
                                        break;
                                    case 'time_start':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请选择领取起始时间';
                                        }
                                        break;
                                    case 'time_end':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请选择领取结束时间';
                                        }
                                        break;
                                    case 'use_time_start':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请选择使用开始时间';
                                        }
                                        break;
                                    case 'use_time_end':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请选择使用失效时间';
                                        }
                                        break;
                                    case 'card_stock':
                                        if ((!value || value <= 0) && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请填写数字大于0的卡券库存';
                                        }
                                        break;
                                    case 'least_cost':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '抵用券起用金额';
                                        }
                                        break;
                                    case 'over_limit':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请填写优惠劵抵用上限金额';
                                        }
                                        break;
                                    case 'reduce_cost':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请填写抵用券减免金额';
                                        }
                                        break;
                                    case 'discount':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请填写折扣劵打折额度';
                                        }
                                        break;
                                    case 'money':
                                        if (!value && inputos[i].disabled === false) {
                                            _null = true;
                                            _msg = '请填写储值券金额';
                                        }
                                        break;
                                }
                                if (_null === true) break;
                            }

                            if (_null === false) {
                                for (i in selectos) {
                                    var name = selectos[i].name, value = $.trim(selectos[i].value);
                                    _inputo = selectos[i];
                                    switch (name) {
                                        case 'card_type':
                                            if (!value && selectos[i].disabled === false) {
                                                _null = true;
                                                _msg = '请选择卡券类型';
                                            }
                                            break;
                                        case 'module[]':
                                            if (!value && selectos[i].disabled === false) {
                                                _null = true;
                                                _msg = '请选择渠道类型';
                                            }
                                            break;
                                    }
                                    if (_null === true) break;
                                }
                            }

                            if (_null === true) {
                                $(_inputo).focus();
                                return false;
                            }
                            /*end*/

                            var text = btn.text();
                            btn.prop('disabled', true).addClass('disabled').text(text + '中...');
                        },
                        success: function (data) {
                            if (data.status == 1) {
                                var btnval = data.data.isadd === false ? '编辑' : '添加';
                                art.dialog({
                                    title: '提示',
                                    fixed: true,
                                    icon: 'succeed',
                                    content: data.message,
                                    okVal: "返回列表页",
                                    cancelVal: '继续' + btnval,
                                    ok: function () {
                                        window.location.href = ok_url;
                                    },
                                    cancel: true,
                                    close: function () {
                                        $(_this).focus(); //关闭时让触发弹窗的元素获取焦点
                                        return true;
                                    },
                                });
                            } else {
                                btn.parent().append("<span style='color: #ff0040;'>" + data.message + "</span>");
                                setTimeout(function () {
                                    btn.parent().find('span').fadeOut('normal', function () {
                                        btn.parent().find('span').remove();
                                    });
                                }, 3000);
                            }
                        },
                        complete: function () {
                            var text = btn.text();
                            btn.prop('disabled', false).removeClass('disabled').text(text.replace('中...', ''));
                        },
                        error: function () {
                            btn.parent().append("<span style='color: #ff0040;'>请求异常,请刷新页面试试!</span>");
                            setTimeout(function () {
                                btn.parent().find('span').fadeOut('normal', function () {
                                    btn.parent().find('span').remove();
                                });
                            }, 3000);
                        }
                    });
                });
            });
        });


        $(':input[name=time_start]').datetimepicker({
            format:'Y-m-d',
            lang:'ch',
            timepicker:false,
            scrollInput:false
        });
        $(':input[name=time_end]').datetimepicker({
            format:'Y-m-d',
            lang:'ch',
            timepicker:false,
            scrollInput:false
        });
        $(':input[name=use_time_end]').datetimepicker({
            format:'Y-m-d',
            lang:'ch',
            timepicker:false,
            scrollInput:false
        });
        $(':input[name=use_time_start]').datetimepicker({
            format:'Y-m-d',
            lang:'ch',
            timepicker:false,
            scrollInput:false
        });
    </script>

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
