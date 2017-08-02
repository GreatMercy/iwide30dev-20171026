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
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
		

    <div class="centre">

        <div class="info" style="margin-top:20px;">
            <input class="add" type="button" value="+添加商品" onclick="javascript: jQuery('#edit_status').show();"/>
            <table class="t1">
                <thead>
                    <th>编号</th>
                    <th>商品名称</th>
                    <th>原价</th>
                    <th>现价</th>
                    <th>单位</th>
                    <th>顺序</th>
                    <th>状态</th>
                    <th>操作</th>
                </thead>
                <tr >
                    <td>83313</td>
                    <td>双人自助午餐</td>
                    <td>￥299</td>
                    <td>￥99</td>
                    <td>份</td>
                    <td>1</td>
                    <td>有效</td>
                    <td><input type="button" class="edit" value="编辑" onclick="javascript: jQuery('#edit_status').show();"/><input type="button" class="delete"/></td>
                </tr>
                <tr>
                    <td>83313</td>
                    <td>双人自助午餐</td>
                    <td>￥299</td>
                    <td>￥99</td>
                    <td>份</td>
                    <td>1</td>
                    <td>有效</td>
                    <td><input type="button" class="edit" value="编辑" onclick="javascript: jQuery('#edit_status').show();"/><input type="button" class="delete"/></td>
                </tr>
                <tr>
                    <td>83313</td>
                    <td>双人自助午餐</td>
                    <td>￥299</td>
                    <td>￥99</td>
                    <td>份</td>
                    <td>1</td>
                    <td>有效</td>
                    <td><input type="button" class="edit" value="编辑" onclick="javascript: jQuery('#edit_status').show();"/><input type="button" class="delete"/></td>
                </tr>
                <tr>
                    <td>83313</td>
                    <td>双人自助午餐</td>
                    <td>￥299</td>
                    <td>￥99</td>
                    <td>份</td>
                    <td>1</td>
                    <td>有效</td>
                    <td><input type="button" class="edit" value="编辑" onclick="javascript: jQuery('#edit_status').show();"/><input type="button" class="delete"/></td>
                </tr>
                <tr>
                    <td>83313</td>
                    <td>双人自助午餐</td>
                    <td>￥299</td>
                    <td>￥99</td>
                    <td>份</td>
                    <td>1</td>
                    <td>有效</td>
                    <td><input type="button" class="edit" value="编辑" onclick="javascript: jQuery('#edit_status').show();"/><input type="button" class="delete"/></td>
                </tr>
                <tr>
                    <td>83313</td>
                    <td>双人自助午餐</td>
                    <td>￥299</td>
                    <td>￥99</td>
                    <td>份</td>
                    <td>1</td>
                    <td>有效</td>
                    <td><input type="button" class="edit" value="编辑" onclick="javascript: jQuery('#edit_status').show();"/><input type="button" class="delete"/></td>
                </tr>
                <tr>
                    <td>83313</td>
                    <td>双人自助午餐</td>
                    <td>￥299</td>
                    <td>￥99</td>
                    <td>份</td>
                    <td>1</td>
                    <td>有效</td>
                    <td><input type="button" class="edit" value="编辑" onclick="javascript: jQuery('#edit_status').show();"/><input type="button" class="delete"/></td>
                </tr>
                <tr>
                    <td>83313</td>
                    <td>双人自助午餐</td>
                    <td>￥299</td>
                    <td>￥99</td>
                    <td>份</td>
                    <td>1</td>
                    <td>有效</td>
                    <td><input type="button" class="edit" value="编辑" onclick="javascript: jQuery('#edit_status').show();"/><input type="button" class="delete"/></td>
                </tr>
            </table>
                <div class="pagination">
                    <span id="pagination-left">当前共筛选到<b>12</b>条/共<b>100</b>条数据</span>
                    <ul id="pagination-right">
                        <li><a href="#"><</a></li>
                        <li class="active">1</li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li class="next"><a href="#">></a></li>

                        <li><span>第</span></li>
                        <li>
                            <input type="text" value="2" /></li>
                        <li><span>页</span></li>
                        <li>
                            <input type="button" value="GO" /></li>
                    </ul>
                </div>
        </div>

    </div>

     <div class="open_layer" id="edit_status">
        <div>
            <div class="tit">
                <h4><span class="close_layer" onclick="javascript:jQuery('#edit_status').hide()">×</span></h4>
                <span>新增/编辑商品</span>
            </div>
            <div>
                <table>
                    <tr>
                        <td>商品编号</td>
                        <td class="tdw"><input type="text" value="83319" disabled="disabled"/></td>
                        <td>商品名称</td>
                        <td><input type="text" value="双人自助午餐"/></td>

                    </tr>
                    <tr>
                        <td>原价</td>
                        <td class="tdw"><input type="text" value="190"/></td>
                        <td>现价</td>
                        <td><input type="text" value="88"/></td>

                    </tr>
                    <tr>
                        <td>单位</td>
                        <td class="tdw"><input type="text" value="份"/></td>
                        <td>顺序</td>
                        <td><input type="text" value="1"/></td>

                    </tr>
                    <tr>
                        <td>销售方式</td>
                        <td class="tdw"><input type="radio"/><span style="margin-right:45px;color:#B69A6A;">支持</span> <input type="radio"/><span>不支持</span></td>
                        <td>下架时间</td>
                        <td><input type="text" value="2017-01-01"/></td>
                    </tr>
                    <tr>
                        <td>失效模式</td>
                        <td  colspan="3" class="eqw"><select><option>固定时间失效</option></select></td>

                    </tr>
                    <tr>
                        <td>简短描述</td>
                        <td colspan="3" class="eqw"><input type="text"  placeholder="仅显示在自由组合购买时，20字内" maxlength="20" style="width:100%"/></td>

                    </tr>
                    <tr>
                        <td>图文描述</td>
                        <td colspan="3" class="eqw">
                            
                            <div class="imgdepict">
                            <textarea  placeholder="  字数限150字内" maxlength="150"></textarea>
                             <input type="button" onclick="$('input[id=lefile]').click();"/><input id="lefile" type="file" style="display:none"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="editsave"><input type="button" value="保  存"/></td>
                    </tr>
                </table>
            </div>
        </div>
     </div>


        <!-- /.content -->
    </div>

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

<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
</script>
</body>
</html>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet"
	href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/images/laydate.css">
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/images/laydate12.css">
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/css/bookingpublic.css">
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/css/goodlist.css">
</head>
<script type="text/javascript">
    function ApplyStyle(s) {
        document.getElementById("mytab").className = s.innerText;
    }
</script>
