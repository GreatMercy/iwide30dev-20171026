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
        <div class="stepflow">
            <div class="flow">
                <div class="flow_one active"><span>1</span></div>
                <div class="line"></div>
                <div class="flow_two"><span>2</span></div>
                <div class="line"></div>
                <div class="flow_three"><span>3</span></div>
                <div class="line"></div>
                <div class="flow_four"><span>4</span></div>
            </div>
            <div class="flowinfo">
                <span class="active">基础信息</span>
                <span>关联商品</span>
                <span>预定政策</span>
                <span>确认完成</span>
            </div>
        </div>

        <div class="info">
            
            <!-- 步骤一 基础信息 -->
            <div class="step_one">
                <div class="lab">基 础 设 置</div>
                <div class="item">
                    <div class="pos">
                        <div class="leftdiv">
                            <table>
                                <tr>
                                    <td>
                                        <b>价格类型</b></td>
                                    <td>
                                        <span class="y">
                                            <input name="type" type="radio" />选中</span>
                                        <span class="y">
                                            <input name="type" type="radio" />略过</span>
                                        <span>
                                            <input name="type" type="radio" />未选中</span>
                                        <span class="g">
                                            <input name="type" type="radio" />不可选</span>
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>有效时间</b></td>
                                    <td>
                                        <input type="date" value="  2014-12-14"/>&nbsp;&nbsp;&nbsp;至&nbsp;&nbsp;&nbsp;<input type="date" value="  2014-12-15"/></td>

                                </tr>
                                <tr>
                                    <td><b>价格代码描述</b></td>
                                    <td>
                                        <input type="text" name="des" /></td>

                                </tr>
                            </table>
                        </div>


                        <div class="rightdiv">
                            <table>
                                <tr>
                                    <td>
                                        <b>价格代码名称</b></td>
                                    <td>
                                        <input type="text" name="price_name" placeholder="  名称字数限8个字内"/></td>

                                </tr>
                                <tr>
                                    <td><b>可用日期</b></td>
                                    <td>
                                        <input type="checkbox" id="checkbox_a1" class="chk_1" /><label for="checkbox_a1"></label>
                                        <b class="y">全部</b>
                                        <input type="checkbox" id="checkbox1" class="chk_1" /><label for="checkbox1"></label>
                                        <b>周一</b>
                                        <input type="checkbox" id="checkbox2" class="chk_1" /><label for="checkbox2"></label>
                                        <b>周二</b>
                                        <input type="checkbox" id="checkbox3" class="chk_1" /><label for="checkbox3"></label>
                                        <b>周三</b>
                                        <input type="checkbox" id="checkbox4" class="chk_1" /><label for="checkbox4"></label>
                                        <b>周四</b>
                                        <input type="checkbox" id="checkbox5" class="chk_1" /><label for="checkbox5"></label>
                                        <b>周五</b>
                                        <input type="checkbox" id="checkbox6" class="chk_1" /><label for="checkbox6"></label>
                                        <b>周六</b>
                                        <input type="checkbox" id="checkbox7" class="chk_1" /><label for="checkbox7"></label>
                                        <b>周日</b>

                                    </td>

                                </tr>
                                <tr>
                                    <td><b>早餐</b></td>
                                    <td>
                                        <select name="breakfast_nums">
                                            <option>无早</option>
                                        </select>

                                    </td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="lab">价 格 策 略</div>
                <div class="item itemheight">
                    <div class="pos">
                        <div class="leftdiv">
                            <table>
                                <tr>
                                    <td>
                                        <b>关联价格代码</b></td>
                                    <td>
                                        <select name="related_code">
                                            <option>不关联</option>
                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>计算值</b></td>
                                    <td>
                                        <input type="text" name="related_cal_value" style="width: 130px;"/></td>

                                </tr>
                            </table>
                        </div>


                        <div class="rightdiv">
                            <table>
                                <tr>
                                    <td><b>计算公式</b></td>
                                    <td>
                                        
                                    <span class="y"><input name="related_cal_way" type="radio"/>加</span>
                                    <span><input name="related_cal_way" type="radio" />减</span>
                                    <span><input name="related_cal_way" type="radio" />乘</span>
                                    <span><input name="related_cal_way" type="radio" />除</span>
                                        

                                    </td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="lab">适 用 设 置</div>
                <div class="item itemheight">
                    <div class="pos">
                        <div class="leftdiv">
                            <table>
                                <tr>
                                    <td>
                                        <b>酒店房型范围</b></td>
                                    <td>
                                    <input class="add" type="button" value="+添加"  onclick="javascript: jQuery('#addlayer').show()"/>
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>不使用</b></td>
                                    <td>
                                    <input name="no_pay_way[]" class="bgeq" type="button" value="微信支付" />
                                    <input name="no_pay_way[]" class="bgeq" type="button" value="微信支付" />
                                    <input name="no_pay_way[]" class="bgeq" type="button" value="微信支付" />
                                    <input name="no_pay_way[]" class="bgeq" type="button" value="微信支付" />
                                    </td>

                                </tr>
                            </table>
                        </div>


                        <div class="rightdiv">
                            <table>
                                <tr>
                                    <td><b>会员等级条件</b></td>
                                    <td>
                                    <input name="member_level" class="mgr10 bgeq" type="button" value="微信粉丝" />
                                    <input name="member_level" class="mgr10 bgeq" type="button" value="金卡会员" />
                                    <input name="member_level" class="bgeq" type="button" value="银卡会员" /></td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="lab">套 餐 设 置</div>
                <div class="item">
                    <div class="pos poslast">
                        <div class="leftdiv">
                            <table>
                                <tr>
                                    <td>
                                        <b>销售方式</b></td>
                                    <td>
                                    <span class="y"><input type="radio"/>固定赠送</span>
                                    <span><input type="radio" />任选</span>
                                    </td>

                                </tr>
                                <tr>
                                    <td valign="top" style="padding-top: 30px;">
                                        <b>图文描述</b></td>
                                    <td>
                                    <div class="imgdepict">
                                        <textarea placeholder="  字数限150字内" maxlength="150"></textarea>
                                        <input type="button" onclick="$('input[id=lefile]').click();" /><input id="lefile" type="file" style="display: none" />
                                    </div>

                                    </td>

                                </tr>
                            </table>
                        </div>


                        <div class="rightdiv">
                            <table>
                                <tr>
                                    <td>
                                        <b>计价方式</b></td>
                                    <td>
                                    <span class="y"><input type="radio"/>按房晚计算</span>
                                    <span><input type="radio" />单件计算</span>
                                    </td>
                                </tr>
                                <tr>
                                <td colspan="2">
                                    <div class="wordCount" id="wordCount" data-str="150/150" maxdata="150">
                                        <textarea placeholder="  订购须知 字数限150字数内"></textarea>
                                    </div>
                                </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="step">
                    <input type="button" value="下 一 步"  onclick="javascript: jQuery('.step_two').show(); jQuery('.step_one').hide(); jQuery('.flow div').removeClass('active'); jQuery('.flow div:eq(2)').addClass('active'); jQuery('.flowinfo span').removeClass('active'); jQuery('.flowinfo span:eq(1)').addClass('active'); jQuery('.info').css('padding-bottom', '0'); jQuery('.info').css('height', '100%');" />
                </div>
            </div>

            <!-- 步骤二 关联商品 -->
            <div class="step_two">
                <table class="t1">
                    <thead>
                        <th>选择</th>
                        <th>商品ID</th>
                        <th>商品名称</th>
                        <th>原价</th>
                        <th>现价</th>
                        <th>销售方式</th>
                        <th>数量</th>
                        <th>单次最大可售</th>
                        <th>计价方式</th>
                    </thead>
                    <tr class="tr">
                        <td>
                            <input type="checkbox" id="checkbox_1" class="chk_1" /><label for="checkbox_1"></label></td>
                        <td>001</td>
                        <td>双人自助午餐</td>
                        <td>￥299</td>
                        <td>￥99</td>
                        <td>固定赠送</td>
                        <td onmouseover="ShowSelect(this);" onmouseout="HideSelect(this)">
                            <span>1</span>
                            <select onchange="javascript: jQuery(this).parent().find('span').html(jQuery(this).val());">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>-</td>
                        <td>按每晚计算</td>
                    </tr>
                    <tr class="tr">
                        <td>
                            <input type="checkbox" id="checkbox_a2" class="chk_1" /><label for="checkbox_a2"></label></td>
                        <td>002</td>
                        <td>双人自助晚餐</td>
                        <td>￥299</td>
                        <td>￥99</td>
                        <td>固定赠送</td>
                        <td onmouseover="ShowSelect(this);" onmouseout="HideSelect(this)">
                            <span>1</span>
                            <select onchange="javascript: jQuery(this).parent().find('span').html(jQuery(this).val());">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>-</td>
                        <td>按每晚计算</td>
                    </tr>
                    <tr class="tr">
                        <td>
                            <input type="checkbox" id="checkbox_a3" class="chk_1" /><label for="checkbox_a3"></label></td>
                        <td>003</td>
                        <td>九寨沟特产</td>
                        <td>￥299</td>
                        <td>￥99</td>
                        <td>任选</td>
                        <td>-</td>
                        <td onmouseover="ShowSelect(this);" onmouseout="HideSelect(this)">
                            <span>1</span>
                            <select onchange="javascript: jQuery(this).parent().find('span').html(jQuery(this).val());">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>按每晚计算</td>
                    </tr>
                    <tr class="tr">
                        <td>
                            <input type="checkbox" id="checkbox_a4" class="chk_1" /><label for="checkbox_a4"></label></td>
                        <td>004</td>
                        <td>广州特产</td>
                        <td>￥299</td>
                        <td>￥99</td>
                        <td>任选</td>
                        <td>-</td>
                        <td onmouseover="ShowSelect(this);" onmouseout="HideSelect(this)">
                            <span>1</span>
                            <select onchange="javascript: jQuery(this).parent().find('span').html(jQuery(this).val());">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>按每晚计算</td>
                    </tr>
                    <tr class="tr">
                        <td>
                            <input type="checkbox" id="checkbox_a5" class="chk_1" /><label for="checkbox_a5"></label></td>
                        <td>005</td>
                        <td>双人自助午餐</td>
                        <td>￥299</td>
                        <td>￥99</td>
                        <td>固定赠送</td>
                        <td onmouseover="ShowSelect(this);" onmouseout="HideSelect(this)">
                            <span>1</span>
                            <select onchange="javascript: jQuery(this).parent().find('span').html(jQuery(this).val());">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>-</td>
                        <td>按每晚计算</td>
                    </tr>
                    <tr class="tr">
                        <td>
                            <input type="checkbox" id="checkbox_a6" class="chk_1" /><label for="checkbox_a6"></label></td>
                        <td>006</td>
                        <td>双人自助晚餐</td>
                        <td>￥299</td>
                        <td>￥99</td>
                        <td>任选</td>
                        <td>-</td>
                        <td onmouseover="ShowSelect(this);" onmouseout="HideSelect(this)">
                            <span>1</span>
                            <select onchange="javascript: jQuery(this).parent().find('span').html(jQuery(this).val());">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>按每晚计算</td>
                    </tr>
                    <tr class="tr">
                        <td>
                            <input type="checkbox" id="checkbox_a7" class="chk_1" /><label for="checkbox_a7"></label></td>
                        <td>007</td>
                        <td>双人自助午餐</td>
                        <td>￥299</td>
                        <td>￥99</td>
                        <td>固定赠送</td>
                        <td onmouseover="ShowSelect(this);" onmouseout="HideSelect(this)">
                            <span>1</span>
                            <select onchange="javascript: jQuery(this).parent().find('span').html(jQuery(this).val());">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>-</td>
                        <td>按每晚计算</td>
                    </tr>
                    <tr class="tr">
                        <td>
                            <input type="checkbox" id="checkbox_a8" class="chk_1" /><label for="checkbox_a8"></label></td>
                        <td>008</td>
                        <td>双人自助晚餐</td>
                        <td>￥299</td>
                        <td>￥99</td>
                        <td>任选</td>
                        <td>-</td>
                        <td onmouseover="ShowSelect(this);" onmouseout="HideSelect(this)">
                            <span>1</span>
                            <select onchange="javascript: jQuery(this).parent().find('span').html(jQuery(this).val());">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>按每晚计算</td>
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

                        <li><span>&nbsp;第&nbsp;</span></li>
                        <li>
                            <input type="text" value="2" /></li>
                        <li><span>&nbsp;页&nbsp;</span></li>
                        <li>
                            <input type="button" value="GO" /></li>
                    </ul>
                </div>
                <div class="step">
                    <input type="button" value="上 一 步" onclick="javascript: jQuery('.step_one').show(); jQuery('.step_two').hide(); jQuery('.flow div').removeClass('active'); jQuery('.flow div:eq(0)').addClass('active'); jQuery('.flowinfo span').removeClass('active'); jQuery('.flowinfo span:eq(0)').addClass('active'); setheight(); jQuery('.info').css('height', '100%');" />
                    <input type="button" value="下 一 步" onclick="javascript: jQuery('.step_three').show(); jQuery('.step_two').hide(); jQuery('.flow div').removeClass('active'); jQuery('.flow div:eq(4)').addClass('active'); jQuery('.flowinfo span').removeClass('active'); jQuery('.flowinfo span:eq(2)').addClass('active'); setheight(); jQuery('.info').css('height', '100%');" />
                </div>
            </div>

            
            <!-- 步骤三 预定政策 -->
            <div class="step_three">
                <div class="lab">预 定 政 策</div>
                <div class="item">
                    <div class="pos poss">
                        <div class="leftdiv">
                            <table>
                                <tr>
                                    <td rowspan="2" class="imgandb">
                                        <img src="http://test008.iwide.cn/public/img/images/savetime.jpg"/>
                                        <b>保留时间</b>
                                    </td>
                                    <td>
                                        <span>到店支付</span>
                                        <span>入住时间</span>
                                         <select>
                                        <option>1:00</option>
                                        <option>2:00</option>
                                        <option>3:00</option>
                                        <option>4:00</option>
                                        <option>5:00</option>
                                        <option>6:00</option>
                                        <option>7:00</option>
                                        <option>8:00</option>
                                        <option>9:00</option>
                                        <option>10:00</option>
                                        <option>11:00</option>
                                        <option>12:00</option>
                                        <option>13:00</option>
                                        <option>14:00</option>
                                        <option>15:00</option>
                                        <option>16:00</option>
                                        <option>17:00</option>
                                        <option>18:00</option>
                                        <option>19:00</option>
                                        <option>20:00</option>
                                        <option>21:00</option>
                                        <option>22:00</option>
                                        <option>23:00</option>
                                        <option>00:00</option>
                                    </select>

                                    </td>

                                </tr>
                                
                                <tr>
                                    <td>
                                        <span>微信支付</span>
                                        <span>入住时间</span>
                                         <select>
                                        <option>1:00</option>
                                        <option>2:00</option>
                                        <option>3:00</option>
                                        <option>4:00</option>
                                        <option>5:00</option>
                                        <option>6:00</option>
                                        <option>7:00</option>
                                        <option>8:00</option>
                                        <option>9:00</option>
                                        <option>10:00</option>
                                        <option>11:00</option>
                                        <option>12:00</option>
                                        <option>13:00</option>
                                        <option>14:00</option>
                                        <option>15:00</option>
                                        <option>16:00</option>
                                        <option>17:00</option>
                                        <option>18:00</option>
                                        <option>19:00</option>
                                        <option>20:00</option>
                                        <option>21:00</option>
                                        <option>22:00</option>
                                        <option>23:00</option>
                                        <option>00:00</option>
                                    </select>

                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="rightdiv">
                            <table>
                                <tr>
                                    <td rowspan="2" class="imgandb">
                                        <img  src="http://test008.iwide.cn/public/img/images/checkouttime.jpg"/>
                                        <b>退房时间</b>
                                    </td>
                                    <td>
                                        <span>到店支付</span>
                                        <span>离店时间</span>
                                         <select>
                                        <option>1:00</option>
                                        <option>2:00</option>
                                        <option>3:00</option>
                                        <option>4:00</option>
                                        <option>5:00</option>
                                        <option>6:00</option>
                                        <option>7:00</option>
                                        <option>8:00</option>
                                        <option>9:00</option>
                                        <option>10:00</option>
                                        <option>11:00</option>
                                        <option>12:00</option>
                                        <option>13:00</option>
                                        <option>14:00</option>
                                        <option>15:00</option>
                                        <option>16:00</option>
                                        <option>17:00</option>
                                        <option>18:00</option>
                                        <option>19:00</option>
                                        <option>20:00</option>
                                        <option>21:00</option>
                                        <option>22:00</option>
                                        <option>23:00</option>
                                        <option>00:00</option>
                                    </select>

                                    </td>

                                </tr>
                                
                                <tr>
                                    <td>
                                        <span>微信支付</span>
                                        <span>离店时间</span>
                                         <select>
                                        <option>1:00</option>
                                        <option>2:00</option>
                                        <option>3:00</option>
                                        <option>4:00</option>
                                        <option>5:00</option>
                                        <option>6:00</option>
                                        <option>7:00</option>
                                        <option>8:00</option>
                                        <option>9:00</option>
                                        <option>10:00</option>
                                        <option>11:00</option>
                                        <option>12:00</option>
                                        <option>13:00</option>
                                        <option>14:00</option>
                                        <option>15:00</option>
                                        <option>16:00</option>
                                        <option>17:00</option>
                                        <option>18:00</option>
                                        <option>19:00</option>
                                        <option>20:00</option>
                                        <option>21:00</option>
                                        <option>22:00</option>
                                        <option>23:00</option>
                                        <option>00:00</option>
                                    </select>

                                    </td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="lab  labpos">取 消 政 策（仅限微信取消）</div>
                <div class="item">
                    <div class="pos">
                            <table>
                                <tr>
                                <td><input type="radio"/>允许到店前取消</td>
                            </tr>
                            <tr>
                                <td><input type="radio"/>允许在入住日当天 
                                    <select>
                                        <option>1:00</option>
                                        <option>2:00</option>
                                        <option>3:00</option>
                                        <option>4:00</option>
                                        <option>5:00</option>
                                        <option>6:00</option>
                                        <option>7:00</option>
                                        <option>8:00</option>
                                        <option>9:00</option>
                                        <option>10:00</option>
                                        <option>11:00</option>
                                        <option>12:00</option>
                                        <option>13:00</option>
                                        <option>14:00</option>
                                        <option>15:00</option>
                                        <option>16:00</option>
                                        <option>17:00</option>
                                        <option>18:00</option>
                                        <option>19:00</option>
                                        <option>20:00</option>
                                        <option>21:00</option>
                                        <option>22:00</option>
                                        <option>23:00</option>
                                        <option>00:00</option>
                                    </select>
                                    前取消，无需手续费
                                </td>
                            </tr>
                            <tr>
                                <td><input type="radio"/>允许在入住日当天 <select>
                                        <option>1:00</option>
                                        <option>2:00</option>
                                        <option>3:00</option>
                                        <option>4:00</option>
                                        <option>5:00</option>
                                        <option>6:00</option>
                                        <option>7:00</option>
                                        <option>8:00</option>
                                        <option>9:00</option>
                                        <option>10:00</option>
                                        <option>11:00</option>
                                        <option>12:00</option>
                                        <option>13:00</option>
                                        <option>14:00</option>
                                        <option>15:00</option>
                                        <option>16:00</option>
                                        <option>17:00</option>
                                        <option>18:00</option>
                                        <option>19:00</option>
                                        <option>20:00</option>
                                        <option>21:00</option>
                                        <option>22:00</option>
                                        <option>23:00</option>
                                        <option>00:00</option>
                                    </select>
                                    前取消，将收取已支付金额的&nbsp;&nbsp;<input type="text"/>%作为赔偿
                                </td>
                            </tr>
                            <tr>
                                <td><input type="radio"/>预定一经确认，恕不接受任何取消</td>
                            </tr>
                            </table>
                    </div>
                </div>

                <div class="lab labpos">退 款 政 策（仅限微信取消）</div>
                <div class="item">
                    <div class="pos">
                            <table>
                                 <tr>
                                <td><input type="radio"/>取消订单并自动退款</td>
                                <td class="prompt">退款需要添加支付证书哦，去添加？</td>
                                <td class="prompt"><input type="button" value="+添加"/></td>
                            </tr>
                            <tr>
                                <td><input type="radio"/>取消订单，手动退款</td>
                                <td class="prompt">退款需要添加支付证书哦，去添加？</td>
                                <td class="prompt"><input type="button" value="+添加"/></td>
                            </tr>
                            </table>
                    </div>
                </div>
               
                <div class="lab labpos">高 级 预 定 条 件</div>
                <div class="item">
                    <div class="pos poss">
                        <div class="leftdiv righttable">
                            <table >
                                <tr>
                                <td>1.提前预定要求</td>
                                <td class="cen">
                                   <span><input type="radio" />否</span> 
                                   <span><input type="radio" />是</span>
                                   <span><input type="text"/>天</span>
                                </td>
                            </tr>
                            <tr>
                                <td>3.最多预定要求</td>
                                <td class="cen">
                                   <span><input type="radio" />否</span> 
                                   <span><input type="radio" />是</span>
                                </td>
                            </tr>
                            <tr>
                                <td>5.入住日期大于等于&nbsp;</td>
                                <td><input type="date" value="2017-01-01"/>&nbsp;&nbsp;方可预定</td>
                            </tr>
                            <tr>
                                <td>7.离店日期大于等于&nbsp;</td>
                                <td colspan="2"><input type="date" value="2017-01-01"/>&nbsp;&nbsp;方可预定</td>
                            </tr>
                            </table>
                        </div>
                        <div class="rightdiv">
                            <table>
                                <tr>
                                <td>2.最少预定要求</td>
                                <td class="cen">
                                   <span><input type="radio" />否</span> 
                                   <span><input type="radio" />是</span>
                                </td>
                            </tr>
                            <tr>
                                <td>4.入住日期小于等于&nbsp;</td>
                                <td><input type="date" value="2017-01-01"/>&nbsp;&nbsp;方可预定</td>
                            </tr>
                            <tr>
                                <td>6.离店日期小于等于&nbsp;</td>
                                <td><input type="date" value="2017-01-01"/>&nbsp;&nbsp;方可预定</td>
                            </tr>
                            </table>
                        </div>

                            
                    </div>
                </div>
                
                <div class="lab labpos">营 销 规 则</div>
                <div class="item">
                    <div class="pos poss">
                        <div class="leftdiv righttable">
                            <table >
                                <tr>
                                <td>1.用券规则</td>
                                <td class="cen">
                                   <span><input type="radio" />不可用</span> 
                                   <span><input type="radio" />可用</span>
                                   <span>
                                        <select class="j_inupt" name="coupon_num_type" style="width:125px;">
                                            <option value='order' <?php if(!empty($list['coupon_condition']['num_type'])&&$list['coupon_condition']['num_type']=='order'){?>selected<?php }?>>每个订单可用</option>
                                            <option value='roomnight' <?php if(!empty($list['coupon_condition']['num_type'])&&$list['coupon_condition']['num_type']=='roomnight'){?>selected<?php }?>>每个间夜可用</option>
                                        </select>
                                    </span>
                                   <span><input type="text"/>张</span>
                                </td>
                            </tr>
                            <tr>
                                <td>3.积分兑换</td>
                                <td class="cen">
                                   <span><input type="radio" />不可用</span> 
                                   <span><input type="radio" />可用</span>
                                </td>
                            </tr>
                            <?php if (!empty($is_pms)){?>
                            <tr>
                                <td>5.使用pms券</td>
                                <td class="cen">
                                   <span><input name="coupon_is_pms" value="0" type="radio" />不可用</span> 
                                   <span><input name="coupon_is_pms" value="1" type="radio" />可用</span>
                                </td>
                            </tr>
                            <?php }?>
                            </table>
                        </div>
                        <div class="rightdiv">
                            <table>
                                <tr>
                                <td>2.券关联</td>
                                <td class="cen">
                                   <span>
                                       <select name='related_coupon' id='related_coupon' >
                                            <option value=''>--不关联--</option>
                                            <?php foreach ($coupon_types as $card_id=>$c){?>
                                            <option value='<?php echo $card_id;?>' <?php if(!empty($list['coupon_condition']['couprel'])&&$list['coupon_condition']['couprel']==$card_id){?>selected<?php }?>><?php echo $c['title'];?></option>
                                            <?php }?>
                                        </select>
                                    </span> 
                                </td>
                            </tr>
                            <tr>
                                <td>4.积分与券&nbsp;</td>
                                <td class="cen">
                                    <span><input type="radio" />不可同时使用</span> 
                                    <span><input type="radio" />可同时使用</span>
                                </td>
                            </tr>
                            <?php if (!empty($is_pms)){?>
                            <tr>
                                <td>6.对应PMS价格代码&nbsp;</td>
                                <td class="cen">
                                    <span><input type="text" placeholder="对应PMS价格代码"/></span> (修改此项会马上影响到线上价格，若不确定请咨询相关工作人员)
                                </td>
                            </tr>
                            <?php }?>
                            </table>
                        </div>

                            
                    </div>
                </div>
                <div class="step">
                    <input type="button" value="上 一 步" onclick="javascript: jQuery('.step_two').show(); jQuery('.step_three').hide(); jQuery('.flow div').removeClass('active'); jQuery('.flow div:eq(2)').addClass('active'); jQuery('.flowinfo span').removeClass('active'); jQuery('.flowinfo span:eq(1)').addClass('active'); jQuery('.info').css('padding-bottom', '0'); jQuery('.info').css('height', '100%');" />
                    <input type="button" value="下 一 步" onclick="javascript: jQuery('.step_four').show(); jQuery('.step_three').hide(); jQuery('.flow div').removeClass('active'); jQuery('.flow div:eq(6)').addClass('active'); jQuery('.flowinfo span').removeClass('active'); jQuery('.flowinfo span:eq(3)').addClass('active'); jQuery('.info').css('padding-bottom', '0'); jQuery('.info').css('height', '100%');"  />
                  </div>
            </div>
            
            <!-- 步骤四 确认完成 -->
            <div class="step_four">
                <div class="lab">基 础 信 息</div>
                <div class="item">
                    <div class="pos">
                        <div class="leftdiv">
                        <table>
                            <tr>
                                <td class="list">价格类型</td>
                                <td class="rlist">套餐</td>
                            </tr>
                            <tr>
                                <td>价格描述</td>
                                <td>描述改写什么好？</td>
                            </tr>
                            <tr>
                                <td>可用星期</td>
                                <td>周一，周二，周三，周四，周五，周六，周日</td>
                            </tr>
                            <tr>
                                <td>价格策略</td>
                                <td>不关联</td>
                            </tr>
                            <tr>
                                <td>适用范围</td>
                                <td>
                                    <p>共10家酒店</p>
                                    <p>1.金房卡大酒店：高级大床房，行政房，套房</p>
                                    <p>2.金大酒店：高级大床房，行政房，套房</p>
                                    <p>3.石牌桥大酒店：高级大床房，行政房，套房</p>
                                    <p>...</p>
                                    <p>10.哈哈哈大酒店：高级房</p>

                                </td>
                            </tr>
                        </table>
                        </div>
                        <div class="rightdiv">
                        <table>
                            <tr>
                                <td class="list">价格名称</td>
                                <td>高级双床+双早+自助餐</td>
                            </tr>
                            <tr>
                                <td>有效时间</td>
                                <td>2017-01-01到2017-12-31</td>
                            </tr>
                            <tr>
                                <td>早餐</td>
                                <td>无早</td>
                            </tr>
                            <tr>
                                <td>适用条件</td>
                                <td>
                                    <p>会员等级：全部会员等级</p>
                                    <p>支付方式：微信支付</p>
                                </td>
                            </tr>
                            <tr>
                                <td>套餐设置</td>
                                <td>
                                    <p>销售方式：固定赠送</p>
                                    <p>计价方式：按房晚</p></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>

                <div class="lab">关 联 商 品</div>
                <div class="item">
                    <div class="pos poss">
                        <div class="leftdiv righttable">
                        <table>
                            <tr>
                                <td>001</td>
                                <td>
                                    <span>温泉门票</span>
                                    <span>固定赠送</span>
                                    <span>按每晚</span>
                                    <span>1份</span>

                                </td>
                            </tr>
                            <tr>
                                <td>003</td>
                                <td>
                                    <span>温泉门票</span>
                                    <span>固定赠送</span>
                                    <span>按每晚</span>
                                    <span>1份</span>

                                </td>
                            </tr>
                        </table>
                        </div>
                        <div class="rightdiv">
                        <table>
                            <tr>
                                <td>002</td>
                                <td>
                                    <span>温泉门票</span>
                                    <span>固定赠送</span>
                                    <span>按每晚</span>
                                    <span>1份</span>

                                </td>
                            </tr>
                            <tr>
                                <td>004</td>
                                <td>
                                    <span>温泉门票</span>
                                    <span>固定赠送</span>
                                    <span>按每晚</span>
                                    <span>1份</span>

                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>

                <div class="lab">预 定 政 策</div>
                <div class="item">
                    <div class="pos posss">
                        <div class="leftdiv">
                        <table>
                            <tr>
                                <td colspan="2">预定政策</td>
                                <td>
                                    <b>保留时间：入住时间 18:00</b>
                                    <b>退房时间：离店时间 18:00</b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">高级预定条件</td>
                                <td>无</td>
                            </tr>
                        </table>
                        </div>
                        <div class="rightdiv">
                        <table>
                            <tr>
                                <td>取消政策</td>
                                <td>
                                    <span> 一但支付不可取消</span>

                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
                
                <div class="step">
                    <input type="button" value="上 一 步" onclick="javascript: jQuery('.step_three').show(); jQuery('.step_four').hide(); jQuery('.flow div').removeClass('active'); jQuery('.flow div:eq(4)').addClass('active'); jQuery('.flowinfo span').removeClass('active'); jQuery('.flowinfo span:eq(2)').addClass('active'); setheight(); jQuery('.info').css('height', '100%');" />
					<input type="button" value="下 一 步" />
                </div>
            </div>
        </div>


    <div class="open_addlayer" id="addlayer">
        <div>
            <div class="tit">
                <div class="close_addlayer" onclick="javascript:jQuery('#addlayer').hide()">×</div>
                <div>添加酒店和房型</div>
            </div>
            <div class="laycenter">
                <div class="query">
                    <span>选择门店</span>
                    <input type="text" class="search" placeholder=" 请输入门店名称"/>
                    <input type="button" value="查询"/>
                </div>
                <table class="t1">
                    <thead>
                        <th><input type="checkbox" id="checkbox_all1" class="chk_1 chk_all" /><label for="checkbox_all1"></label> 全部门店</th>
                        <th><input type="checkbox" id="checkbox_all2" class="chk_1 chk_allgoods" /><label for="checkbox_all2"></label> 全部房型</th>
                    </thead>
                    <tr>
                        <td><input type="checkbox" id="jinfangka" class="chk_1 chk_allitem" /><label for="jinfangka"></label> 金房卡大酒店</td>
                        <td><input type="checkbox" id="haohua" class="chk_1 chk_allgoodsitem" /><label for="haohua"></label> 豪华套房</td>
                        <td><input type="checkbox" id="xingzheng" class="chk_1 chk_allgoodsitem" /><label for="xingzheng"></label> 行政套房</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="xinx" class="chk_1 chk_allitem" /><label for="xinx"></label> 信息驿站大酒店</td>
                        <td>
                            <span><input type="checkbox" id="gaoj" class="chk_1 chk_allgoodsitem" /><label for="gaoj"></label> 高级大床房</span>
                            <span><input type="checkbox" id="xingz" class="chk_1 chk_allgoodsitem" /><label for="xingz"></label> 行政大床房</span>
                        </td>
                        <td>
                            <span><input type="checkbox" id="haoh" class="chk_1 chk_allgoodsitem" /><label for="haoh"></label> 豪华套房</span>
                            <span><input type="checkbox" id="zhengzt" class="chk_1 chk_allgoodsitem" /><label for="zhengzt"></label> 行政套房</span>

                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="jinfangka1" class="chk_1 chk_allitem" /><label for="jinfangka1"></label> 金房卡大酒店</td>
                        <td><input type="checkbox" id="haohua1" class="chk_1 chk_allgoodsitem" /><label for="haohua1"></label> 豪华套房</td>
                        <td><input type="checkbox" id="xingzheng1" class="chk_1 chk_allgoodsitem" /><label for="xingzheng1"></label> 行政套房</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="Checkbox8" class="chk_1 chk_allitem" /><label for="xinx"></label> 信息驿站大酒店</td>
                        <td>
                            <span><input type="checkbox" id="Checkbox9" class="chk_1 chk_allgoodsitem" /><label for="gaoj"></label> 高级大床房</span>
                        <span><input type="checkbox" id="Checkbox10" class="chk_1 chk_allgoodsitem" /><label for="xingz"></label> 行政大床房</span>
                        </td>
                        <td>
                            <span><input type="checkbox" id="Checkbox11" class="chk_1 chk_allgoodsitem" /><label for="haoh"></label> 豪华套房</span>
                            <span><input type="checkbox" id="Checkbox12" class="chk_1 chk_allgoodsitem" /><label for="zhengzt"></label> 行政套房</span>

                        </td>
                    </tr>
                </table>
            </div>
            <div class="paging">
                <span id="paging-left">当前共筛选到<b>12</b>条/共<b>100</b>条数据</span>
                <ul id="paging-right">
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
            
                <div class="finish">
                    <input type="button" value="完 成" />
                </div>
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
var hasPriceData = <?php if(isset($list)){ echo json_encode($list); }else{ echo 'null';}?>;

console.log(hasPriceData);
    $(document).ready(function () {
        setheight();
    })
    function setheight() {
        //初始化高度  
        if ($(window).height() <= 664) {
            $(".info").css('padding-bottom', '10%');
        }
        else {
            $(".info").css('padding-bottom', '5%');
        }
        $(window).resize(function () {
            if ($(window).height() <= 664) {
                $(".info").css('padding-bottom', '10%');
            }
            else {
                $(".info").css('padding-bottom', '5%');
            }
        })
    }

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

    //可用日期checkbox选中
    $(".chk_1").bind("click", function () {
        if ($(this).prop('checked')) {
            $(this).addClass("checked");
        }
        else {
            $(this).removeClass("checked");
        }
    })

    //会员等级条件 按钮选中
    $(".bgeq").bind("click", function () {
        $(this).parent().find("input").removeClass("active");
        $(this).addClass("active");
    })

    //步骤2 表格鼠标移入移除select事件
    function selectcount(obj) {
        debugger;
        $(this).find("span").hide();
        $(this).find("select").show();

    }
    function ShowSelect(obj) {
        $(obj).find('select').show(); $(obj).find('span').hide();
    }
    function HideSelect(obj) {
        $(obj).find('select').hide();
        $(obj).find('span').val($(obj).find('select').val());
        $(obj).find('span').show();
    }

    //全部选择事件
    $(".chk_all").bind("click", function () {
        if ($(this).prop('checked')) {
            $(".chk_allitem").addClass("checked");
        }
        else {
            $(".chk_allitem").removeClass("checked");
        }
    })

    $(".chk_allgoods").bind("click", function () {
        if ($(this).prop('checked')) {
            $(".chk_allgoodsitem").addClass("checked");
        }
        else {
            $(".chk_allgoodsitem").removeClass("checked");
        }
    })

</script>
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/css/pricecode.css">
</body>
</html>
