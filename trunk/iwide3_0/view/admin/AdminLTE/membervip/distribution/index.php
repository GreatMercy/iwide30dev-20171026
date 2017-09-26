<!-- DataTables -->
<link rel="stylesheet"
      href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link href="<?php echo base_url(FD_PUBLIC) ?>/js/art_Dialog/skins/default.css" rel="stylesheet" />
<link rel='stylesheet' href='<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/date-timepicker/jquery.datetimepicker.css'>
<script type="text/javascript" src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/date-timepicker/jquery.datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/datepicker/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/new/huang.css">
<script type="text/javascript">
    //全局变量
    var GV = {
        DIMAUB: "<?php echo base_url();?>",
        JS_ROOT: "<?php echo FD_PUBLIC;?>/js/",
        JS__ROOT:"<?php echo base_url(FD_PUBLIC);?>/js/"
    };
</script>
<script src="<?php echo base_url(FD_PUBLIC);?>/js/wind.js"></script>
<style type="text/css">
    .table-striped>tbody>tr:nth-of-type(odd) {  background-color: #ffffff;  }
    .color_F99E12 {  margin: 0 5px;  }
    #data-grid_wrapper >.row:first-child{background:#fff;padding:10px;}
    .h_btn_list{display: inline-block}
    #expot{ display: none;}
    .expot{width: 100%;margin-bottom: 10px;}
    .expot span{display: inline-block;}
    .expot input{width:30%;display: inline-block;}
    #selects_membeb{display:inline-block;width:auto;vertical-align:middle;margin-right:25px;}
    .table-striped>tbody>tr:nth-of-type(odd) {  background-color: #ffffff;  }
    .color_F99E12 {  margin: 0 5px;  }
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

    <div style="color:#92a0ae;">
        <div class="over_x">
            <div class="content-wrapper" style="min-width:1230px;" >
                <div class="contents">
                    <?=$this->session->show_put_msg()?>
                    <div class="box-body" style="margin-top: 18px;">
                        <table id="data-grid" class="table-bordered table-striped table-condensed dataTable no-footer" style="width:100%;">
                            <thead class="bg_f8f9fb form_thead">
                            <tr class="bg_f8f9fb form_title">
                                <?php foreach ($fields_config as $k=> $v):?>
                                    <th <?php if(isset($v['grid_width'])) echo 'width="'. $v['grid_width']. '"'; ?> >
                                        <?php echo $v['label'];?>
                                    </th>
                                <?php endforeach;?>
                            </tr>
                            </thead>
                            <tfoot class="bg_f8f9fb form_thead">
                            <tr class="bg_f8f9fb form_title">
                                <?php foreach ($fields_config as $k=> $v):?>
                                    <th <?php if(isset($v['grid_width'])) echo 'width="'. $v['grid_width']. '"'; ?> >
                                        <?php echo $v['label'];?>
                                    </th>
                                <?php endforeach;?>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/* Footer Block @see footer.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'footer.php';
?>

<?php
/* Right Block @see right.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'right.php';
?>

<?php
/* Right Block @see right.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'commonjs.php';
?>
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/layDate.js"></script>
<!--日历调用结束-->
<script type="text/javascript">
    ;!function(){
        laydate({
            elem: '#datepicker'
        })
        laydate({
            elem: '#datepicker2'
        })
    }();
</script>
<script type="text/javascript">
    <?php
    $sort_index= $module->field_index_in_grid($default_sort['field'],13);
    $sort_direct = $default_sort['sort'];
    $num= (config_item('grid_static_num'))? config_item('grid_static_num'): 500;
    $buttions='<div class="deposit-export actives" id="subbtn" data-action="'.EA_const_url::inst()->get_url('*/memberexport/export').'">导出</div>';
    $get_param = !empty($_GET)?$_GET:array();
    ?>
    var grid_sort= [[ <?php echo $sort_index ?>, "<?php echo $sort_direct ?>" ]];
    var dataSet= <?php echo json_encode($result['data']); ?>;
    var columnSet= <?php echo json_encode( $model->get_column_config($fields_config) ); ?>;
    var buttons = $('<div class="h_btn_list"><?php echo $buttions; ?></div>');
    var url_add= '<?php echo EA_const_url::inst()->get_url("*/*/add"); ?>';			//跟button对应
    var url_edit= '<?php echo EA_const_url::inst()->get_url("*/*/edit"); ?>';		//跟button对应
    var url_delete= '<?php echo EA_const_url::inst()->get_url("*/*/delete"); ?>';	//跟button对应
    var url_ajax= '<?php echo EA_const_url::inst()->get_url("*/*/index",$get_param); ?>';
    var url_extra= [];
</script>
<?php if($result['total']<$num):?>
    <script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<?php else:?>
    <script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/jquery.dataTables.member.min.js"></script>
<?php endif;?>
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- page script -->
<?php
if( floatval($result['total'])<$num)
    require_once VIEWPATH. $tpl .DS .'membervip'. DS. 'distribution'. DS .'indexjs.php';
else
    require_once VIEWPATH. $tpl .DS .'membervip'. DS. 'distribution'. DS. 'indexjs_ajax.php';
?>
<script type="text/javascript">
    $(function () {
        Wind.use("artDialog",function (){
            $(document).on('click','.deposit-export',function () {
//                var div1=$("<div/>",{id:'expot'}),div2=$("<div/>",{class:'expot'}).appendTo(div1),space='&nbsp;';
            });
        });
    });
</script>
</body>
</html>
