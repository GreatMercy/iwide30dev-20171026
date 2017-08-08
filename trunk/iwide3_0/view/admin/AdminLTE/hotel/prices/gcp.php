<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
</head>
<?php
$buttions= '';	//button之间不能有字符空格，用php组装输出
$buttions.= '<button type="button" class="btn btn-sm bg-green" id="grid-btn-add"><i class="fa fa-plus"></i>&nbsp;新增</button>';
$buttions.= '<button type="button" class="btn btn-sm disabled" id="grid-btn-edit"><i class="fa fa-edit"></i>&nbsp;编辑</button>';
if(isset($js_filter_btn)) $buttions.= $js_filter_btn;
?>


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
            <h1><?php echo $breadcrumb_array['action']; ?>
                <small></small>
            </h1>
            <ol class="breadcrumb"><?php echo $breadcrumb_html; ?></ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <?php echo $this->session->show_put_msg(); ?>
                        <!--
                          <div class="box-header">
                            <h3 class="box-title">Data Table With Full Features</h3>
                          </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="data-grid" class="table table-bordered table-striped table-condensed">
                                <thead><tr><?php
                                    //print_r($fields_config);die;
                                    foreach ($fields_config as $k=> $v):
                                        ?><th <?php if(isset($v['grid_width'])) echo 'width="'. $v['grid_width']. '"'; ?> ><?php echo $v['label'];?></th><?php
                                    endforeach; ?></tr></thead>

                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
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
                        <!--
                          <div class="box-header">
                            <h3 class="box-title">Data Table With Full Features</h3>
                          </div><!-- /.box-header -->
                        <div class="box-body">
                            <?php echo form_open('hotel/prices/index',array('method'=>'get'));?>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group">

                                        <?php if(count($hotels)>10){?>
                                            <div style='margin-top: 5px;'>
                                                <input type="text" name="qhs" id="qhs" placeholder="快捷查询">
                                                <input type="button" onclick='quick_search()' value='查询' />
                                                <input type="button" onclick='go_hotel("next")' value='下一个' />
                                                <input type="button" onclick='go_hotel("prev")' value='上一个' />
                                                <span id='search_tip' style='color:red'></span>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>

                            </div>

                            <?php echo form_close();?>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">

                            <table id="data-grid" class="table table-bordered table-striped table-condensed dataTable">
                                <thead><tr>
                                    <?php foreach ($fields_config as $k=> $v):?>
                                        <th <?php if(isset($v['grid_width'])) echo 'width="'. $v['grid_width']. '"'; ?> >
                                            <?php echo $v['label'];?></th>
                                    <?php endforeach; ?>
                                </tr></thead>
                                <?php if(!empty($list)){ foreach($list as $lt){ ?>
                                    <tr>
                                        <?php foreach ($fields_config as $k=> $v):?>
                                            <td><?php if(!empty($v['enable'])){ ?>
                                                    <input name='<?php echo $k?>' value='<?php echo $lt[$k]; ?>' />
                                                <?php }else if(!empty($v['select'])){ ?>
                                                    <select  name='<?php echo $k; ?>'>
                                                        <?php foreach($v['select'] as $vk=>$vs) { ?>
                                                            <option value='<?php echo $vk; ?>' <?php if($vk==$lt[$k]){ echo 'selected';} ?>><?php echo $vs; ?></option>
                                                        <?php }?>
                                                    </select>
                                                <?php } else { echo $lt[$k];}?></td>
                                        <?php endforeach; ?>
                                        <td><a target='top' href="<?php echo site_url('hotel/prices/edit').'?r='.$lt['rid'].'&h='.$lt['hid'].'&code='.$lt['price_code'];?>">修改</a></td>
                                        <td><a href="javascript:void(0);" onclick="quick_save(this,'<?php echo $lt['hid'];?>','<?php echo $lt['rid'];?>','<?php echo $lt['price_code'];?>');">快捷保存</a></td>
                                    </tr>
                                <?php }}?>
                            </table>
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
<script>
    var room_id=0;
    <?php if(!empty($room_id)){?>
    room_id=<?php echo $room_id;?>;
    <?php }?>

    <?php if(!empty($hotel_id)){?>
    fill_rooms('<?php echo $hotel_id;?>');
    <?php }?>
    var search_index=0;
    function quick_search() {
        var hk=$('#qhs').val();
        if(hk){
            $('#search_tip').html('');
            options=$('#hotel option');
            search_index=0;
            $.each(options,function(i,n){
                $(n).css('color','#555');
                $(n).removeAttr('be_search');
                if(n.innerHTML.indexOf(hk)>-1){
                    search_index++;
                    $(n).css('color','red');
                    $(n).attr('be_search',search_index);
                    if(search_index==1){
                        n.selected=true;
                        fill_rooms(n.value);
                    }
                }
            });
            if(search_index==0){
                $('#search_tip').html('无结果');
            }
        }
    };
    function go_hotel(direction){
        selected_option=$('#hotel').find('option:selected');
        selected_option=selected_option[0];
        now_index=$(selected_option).attr('be_search');
        if(now_index){
            search_index=now_index;
        }
        if(search_index){
            if(direction=='next'){
                search_index++;
            }else{
                search_index--;
            }
        }
        if(search_index){
            option=$('#hotel>option[be_search="'+search_index+'"]');
            if(option[0]!=undefined){
                option=option[0];
                option.selected=true;
                fill_rooms(option.value);
            }
        }
    }
    function get_rooms(obj){
        var hotel_id = $(obj).val();
        fill_rooms(hotel_id);
    }
    function fill_rooms(hotel_id){
        var _html = '<option value="0">--全部房型--</option>';
        $('#room_id').html(_html);
        $.getJSON('<?php echo site_url('hotel/prices/room_types')?>',{'hid':hotel_id},function(datas){
            $.each(datas,function(k,v){
                _html += '<option value="' + v.room_id +'" ';
                if(v.room_id==room_id)
                    _html+=' selected';
                _html+= '>' + v.name+ '</option>';
            });
            $('#room_id').html(_html);
        },'json');
    }
    function quick_save(obj,hotel,room,code){
        $(obj).html('快捷保存');
        var _parent=$(obj).parent().parent();
        var price=_parent.find("input[name='sprice']").val();
        var num=_parent.find("input[name='snums']").val();
        var status=_parent.find("select[name='set_status']").val();
        $.getJSON('<?php echo site_url('hotel/prices/quick_save_set')?>',{
            'hid':hotel,
            'room':room,
            'code':code,
            'price':price,
            'num':num,
            'status':status
        },function(data){
            if(data==1)
                $(obj).html('快捷保存'+'<span style="color:red">修改成功</span>');
            else
                $(obj).html('快捷保存'+'<span style="color:red">修改失败</span>');
        },'text');
    }
</script>
</body>
</html>
