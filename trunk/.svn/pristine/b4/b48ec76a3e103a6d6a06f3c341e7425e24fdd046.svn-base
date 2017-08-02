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
        <div class="topCondition">
            <div class="ulist">
                <ul>
                    <li class="active">待处理订单(1)</li>
                    <li>今日订单(1)</li>
                    <li>今日入住(1)</li>
                    <li>全部订单(1)</li>
                </ul>
            </div>
         
            <div class="tablist">
                <div class="dleft">
                    <div>
                        <span>日期选择:</span>
                        <select>
                            <option>全部</option>
                        </select>
                        <input type="date" />至<input type="date" />
                        <span>查找关键词:</span>
                        <input type="text"/>
                        <input type="button" value="查询" /><b>重置</b>
                    </div>
                    <div  class="dstop">
                        <span>酒店名称:</span>
                        <select>
                            <option>全部酒店</option>
                        </select>
                        <span class="col">酒店房型:</span>
                    <select>
                        <option>全部房型</option>
                    </select>
                        <span class="col">预定类型:</span>
                        <select>
                            <option>全部</option>
                        </select>

                    </div>
                    <div class="dstop">
                        <span>支付方式:</span>
                        <select>
                            <option>全部</option>
                        </select>
                        <span class="col">支付状态:</span>
                    <select>
                        <option>全部</option>
                    </select>
                        <span class="col">订单状态:</span>
                        <select>
                            <option>全部</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="controlCondition">
                <span onclick="javascript: jQuery('.dstop').hide();jQuery(this).html('点击展开');jQuery('.topCondition').css('height', '200px'); ">点击收起</span><img src="http://test008.iwide.cn/public/img/images/stop.jpg" />
            </div>
        </div>
        
        <div class="orderinfo">
            <div class="orderlist">
                <table class="t1">
                    <thead>
                        <th>订单号</th>
                        <th>酒店-房型-价格代码</th>
                        <th>入离时间</th>
                        <th>实付金额&房数</th>
                        <th>支付状态</th>
                        <th>客户信息</th>
                        <th>状态</th>
                        <th>操作</th>
                    </thead>
                    <tr >
                        <td>
                            <span>djwe1223723123456</span>
                            <span>/237237</span>
                            <span class="low-key">（套餐）</span>
                        </td>
                        <td>
                            <span>jinfangka大酒店</span>
                            <span>高级大床房</span>
                            <span>微信专享价</span>

                        </td>
                        <td> 
                            <span>20170101~20170102</span>
                            <span>共1晚</span>

                        </td>
                        <td> 
                            <span>￥4738</span>
                            <span>1间</span>

                        </td>
                        <td> 
                            <span>微信支付</span>
                            <span>已支付</span>
                        </td>
                        <td>
                            
                            <span>懒人</span>
                            <span>13800138000</span>
                        </td>
                        <td>
                            
                            <span>待确认</span>
                            <input type="button"value="确认" />
                            <div class="operation"><span>取消</span><span>未到</span></div>
                        </td>
                        <td> 
                            <input type="button" class="botmore" value="订单详情"  onclick="javascript: jQuery('#order_details').show();"/>
                        </td>
                    </tr>
                    <tr >
                        <td>
                            <span>djwe1223723123456</span>
                            <span>/237237</span>
                        </td>
                        <td>
                            <span>jinfangka大酒店</span>
                            <span>高级大床房</span>
                            <span>微信专享价</span>

                        </td>
                        <td> 
                            <span>20170101~20170102</span>
                            <span>共1晚</span>

                        </td>
                        <td> 
                            <span>￥4738</span>
                            <span>1间</span>

                        </td>
                        <td> 
                            <span>微信支付</span>
                            <span>已支付</span>
                        </td>
                        <td>
                            
                            <span>懒人</span>
                            <span>13800138000</span>
                        </td>
                        <td>
                            <span>已确认</span>
                            <input type="button"value="入住" />
                            <div class="operation"><span>取消</span><span>未到</span></div>
                        </td>
                        <td> 
                            <input type="button" class="botmore" value="订单详情" />
                        </td>
                    </tr>
                    <tr >
                        <td>
                            <span>djwe1223723123456</span>
                            <span>/237237</span>
                            <span class="low-key">（协议价）</span>
                        </td>
                        <td>
                            <span>jinfangka大酒店</span>
                            <span>高级大床房</span>
                            <span>微信专享价</span>

                        </td>
                        <td> 
                            <span>20170101~20170102</span>
                            <span>共1晚</span>

                        </td>
                        <td> 
                            <span>￥4738</span>
                            <span>1间</span>

                        </td>
                        <td> 
                            <span>微信支付</span>
                            <span>已支付</span>
                        </td>
                        <td>
                            
                            <span>懒人</span>
                            <span>13800138000</span>
                        </td>
                        <td>
                            <span>已入住</span>
                            <input type="button"value="离店" />


                        </td>
                        <td> 
                            <input type="button" class="botmore" value="订单详情" />
                        </td>
                    </tr>
                    <tr >
                        <td>
                            <span>djwe1223723123456</span>
                            <span>/237237</span>
                            <span class="low-key">（套餐）</span>
                        </td>
                        <td>
                            <span>jinfangka大酒店</span>
                            <span>高级大床房</span>
                            <span>微信专享价</span>

                        </td>
                        <td> 
                            <span>20170101~20170102</span>
                            <span>共1晚</span>

                        </td>
                        <td> 
                            <span>￥4738</span>
                            <span>1间</span>

                        </td>
                        <td> 
                            <span>微信支付</span>
                            <span>已支付</span>
                        </td>
                        <td>
                            
                            <span>懒人</span>
                            <span>13800138000</span>
                        </td>
                        <td>
                            
                            <span>已离店</span>
                        </td>
                        <td> 
                            <input type="button" class="botmore" value="订单详情" />
                        </td>
                    </tr>
                    <tr >
                        <td>
                            <span>djwe1223723123456</span>
                            <span>/237237</span>
                            <span class="low-key">（套餐）</span>
                        </td>
                        <td>
                            <span>jinfangka大酒店</span>
                            <span>高级大床房</span>
                            <span>微信专享价</span>

                        </td>
                        <td> 
                            <span>20170101~20170102</span>
                            <span>共1晚</span>

                        </td>
                        <td> 
                            <span>￥4738</span>
                            <span>1间</span>

                        </td>
                        <td> 
                            <span>微信支付</span>
                            <span>已支付</span>
                        </td>
                        <td>
                            
                            <span>懒人</span>
                            <span>13800138000</span>
                        </td>
                        <td>
                            
                            <span>用户取消</span>
                        </td>
                        <td> 
                            <input type="button" class="botmore" value="订单详情" />
                        </td>
                    </tr>
                    <tr >
                        <td>
                            <span>djwe1223723123456</span>
                            <span>/237237</span>
                            <span class="low-key">（套餐）</span>
                        </td>
                        <td>
                            <span>jinfangka大酒店</span>
                            <span>高级大床房</span>
                            <span>微信专享价</span>

                        </td>
                        <td> 
                            <span>20170101~20170102</span>
                            <span>共1晚</span>

                        </td>
                        <td> 
                            <span>￥4738</span>
                            <span>1间</span>

                        </td>
                        <td> 
                            <span>微信支付</span>
                            <span>已支付</span>
                        </td>
                        <td>
                            
                            <span>懒人</span>
                            <span>13800138000</span>
                        </td>
                        <td>
                            
                            <span>酒店取消</span>
                        </td>
                        <td> 
                            <input type="button" class="botmore" value="订单详情" />
                        </td>
                    </tr>
                </table>
            </div>
            
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

    
     <div class="open_orderlayer" id="order_details">
        <div>
            <div class="tit">
                <h4><span class="close_orderlayer" onclick="javascript:jQuery('#order_details').hide()">×</span></h4>
                <span>订单详情</span>
            </div>
                <span class="lab">订 单 明 细</span>
                <div class="it it_one">
                    <div class="clear">
                        <table class="it_one_table">
                            <tr>
                                <td>
                                    <span class="titspan">客人姓名</span>
                                    <span>懒人</span>
                                </td>
                                <td>
                                    <span class="titspan">订单号</span>
                                    <span>dji128347</span>

                                </td>
                                <td >
                                    <span class="titspan">入住日期</span>
                                    <span>2017-03-02</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="titspan">预定日期</span>
                                    <span>2017-02-02</span>
                                </td>
                                <td>
                                    <span class="titspan">预定电话</span>
                                    <span>13800118000</span>

                                </td>
                                <td >
                                    <span class="titspan">预定状态</span>
                                    <span>已确认</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="titspan">预定房型</span>
                                    <span>高级房-标准价</span>
                                </td>
                                <td>
                                    <span class="titspan">实付金额</span>
                                    <span>500</span>

                                </td>
                                <td >
                                    <span class="titspan">离店日期</span>
                                    <span>2017-03-05</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="titspan">预定间数</span>
                                    <span>2</span>
                                </td>
                                <td>
                                    <span class="titspan">预定间数</span>
                                    <span>2</span>

                                </td>
                                <td >
                                    <span class="titspan">优惠券抵扣</span>
                                    <span>-</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="titspan">积分抵扣</span>
                                    <span>500积分抵扣5元</span>
                                </td>
                                <td>
                                    <span class="titspan">是否含早</span>
                                    <span>无早</span>

                                </td>
                                <td >
                                    <span class="titspan">支付方式</span>
                                    <span>微信支付-已支付</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="titspan">会员卡号</span>
                                    <span>237342</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <span class="titspan">pms预定号</span>
                                    <input type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <td  style="margin:0;padding:0;height:80px;">
                                    <span class="titspan">备注</span>
                                </td>
                                <td colspan="2">
                                    <div class="wordCount" id="wordCount" data-str="30/30" maxdata="30">
                                        <textarea placeholder="30字以内"></textarea>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            
                <span class="lab">套 餐 明 细</span>
                <div class="it it_two">
                    <div class="clear">
                        <table class="it_one_table">
                            <tr>
                                <td style="width:400px;">
                                    <span >温泉套票x1</span>
                                </td>
                                <td style="width:600px;">
                                    <span >当前状态：未使用</span>

                                </td>
                                <td >
                                    <span style="color:#B69B69;">去核销 ></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span >温泉套票x1</span>
                                </td>
                                <td>
                                    <span>当前状态：未使用</span>

                                </td>
                                <td >
                                    <span style="color:#B69B69;">去核销 ></span>
                                </td>
                            </tr>
                            </table>
                    </div>
                </div>
            
                <span class="lab">价格 明 细</span>
                <div class="it it_three">
                    <span>2017年1月</span>
                    <ul>
                        <li class="fistday disable">元旦节</li>
                        <li class="disable">2</li>
                        <li>3<span>$100</span></li>
                        <li>4<span>$100</span></li>
                        <li>5<span>$100</span></li>
                        <li>6<span>$100</span></li>
                        <li>7<span>$100</span></li>
                        <li>8<span>$100</span></li>
                        <li>9<span>$100</span></li>
                        <li>10<span>$100</span></li>
                        <li>11<span>$100</span></li>
                        <li>12<span>$100</span></li>
                        <li>13<span>$100</span></li>
                    </ul>
                </div>
                <div class="it_four">
                    <input type="button" value="打 印" />
                    <input type="button" value="保 存"/>
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
    $(function () {
        //先选出 textarea 和 统计字数 dom 节点
        var wordCount = $("#wordCount"),
                textArea = wordCount.find("textarea"),
                //word = wordCount.find(".word");
                word = wordCount.attr("maxdata");
        //调用
        statInputNum(textArea, word);

    });

    //剩余字数统计
    //注意 最大字数只需要在放数字的节点哪里直接写好即可 如：<var class="word">150</var>
    function statInputNum(textArea, numItem) {
        //var max = numItem.text(),
        var max = numItem,
                curLength;
        textArea[0].setAttribute("maxlength", max);
        curLength = textArea.val().length;
        $("#wordCount").attr("data-str", max - curLength + "/" + numItem);
        //numItem.text(max - curLength);
        textArea.on('input propertychange', function () {
            var _value = $(this).val().replace(/\n/gi, "");
            $("#wordCount").attr("data-str", max - _value.length + "/" + numItem);
            //numItem.text(max - _value.length);
        });
    }

</script>
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/css/bookingpublic.css">
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/css/orderlist.css">
</body>
</html>
