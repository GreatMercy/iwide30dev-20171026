<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<!-- Morris chart -->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/morris/morris.css">
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/raphael-min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/morris/morris.min.js"></script>

<link rel='stylesheet' href='<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datepicker/datepicker3.css' >
<script src='<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datepicker/bootstrap-datepicker.js'></script>
<script src='<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.js'></script>

<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/soma_n/echarts.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/soma_n/bootstrap-table.js"></script>
<link rel='stylesheet' href='<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/soma_n/bootstrap-table.css'>
</head>
<body class="hold-transition skin-blue sidebar-mini">

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
	
	// 时间初值赋值
	$e_date = date('Y-m-d', strtotime($end));
	$days -= 1;
	$s_date = date('Y-m-d', strtotime("-$days days", strtotime($e_date)));
?>
    <style>
    .main{
        font-weight: 100;
        font-family: "微软雅黑";
        color: #7e8e9f;
        margin-top: 10px;
        margin-left: 20px;
    }
    th{
        font-weight: 100;
    }
	.relative{
		position:relative;
	}
	.w100{
		width:100%;
	}
	.left{
		float:left;
	}
	.ib{
		display:inline-block;
	}
	.absolute{
		position:absolute;
	}
	th{
		text-align: center;
		min-width: 200px;
		margin: 20px 0px;
	}
	th,td{
		padding:5px;
	}
	table{
		text-align:center;
		background-color:white;
	}
	h2{
		background-color:white;
		margin: 0px;
    display: inline-block;
    min-width: 120px;
    text-align: center;
    font-size: 1em;
    line-height: 30px;
        width: 98px;
        text-align: center;
	}
	.canvasbody{
		background-color:white;
		text-align:center;
	}
	.m2,.m3,.m4{
		margin-top:10px;
	}
	.table_scroll{
		overflow:auto;
	}
	.fixed-table-body{
		overflow:auto;
	}
	.tsearch *{
		     margin: 0px 5px;
	}
	.table_search{
		text-align:center;
		margin-top: 10px;
	}
	.tsearch{
		text-align: center;
    width: 100%;
    display: inline-block;
    padding:10px 0px;
    background-color:white;
	}
	.border{
		border:1px solid #d7e0f1;
	}
	#line2d{
		overflow-x:auto;
	}
	.lb{
		border: 1px solid;
    width: 15px;
    height: 15px;
    position: relative;
    padding: 5px;
    margin: 0px 5px;
    display: inline-block;
	}
	.linebtns{
		font-size:14px;
		line-height:20px;
text-align:center;
	}
        .none{
            display: none;
        }
	.lbtn{
		margin:10px;
		cursor:pointer;
	}
    [type="checkbox"]:not(:checked),
[type="checkbox"]:checked {
  position: absolute;
  left: -9999px;
}
[type="checkbox"]:not(:checked) + label,
[type="checkbox"]:checked + label {
  position: relative;
  padding-left: 25px;
  cursor: pointer;
}

/* checkbox aspect */
[type="checkbox"]:not(:checked) + label:before,
[type="checkbox"]:checked + label:before {
  content: '';
  position: absolute;
  left:0; top: 2px;
  width: 17px; height: 17px;
  border: 1px solid #aaa;
  background: #f8f8f8;
  border-radius: 3px;
  box-shadow: inset 0 1px 3px rgba(0,0,0,.3)
}
/* checked mark aspect */
[type="checkbox"]:not(:checked) + label:after,
[type="checkbox"]:checked + label:after {
  content: '✔';
  position: absolute;
  top: 3px; left: 4px;
  font-size: 18px;
  line-height: 0.8;
  color: #09ad7e;
  transition: all .2s;
}
/* checked mark aspect changes */
[type="checkbox"]:not(:checked) + label:after {
  opacity: 0;
  transform: scale(0);
}
[type="checkbox"]:checked + label:after {
  opacity: 1;
  transform: scale(1);
}
/* disabled checkbox */
[type="checkbox"]:disabled:not(:checked) + label:before,
[type="checkbox"]:disabled:checked + label:before {
  box-shadow: none;
  border-color: #bbb;
  background-color: #ddd;
}
[type="checkbox"]:disabled:checked + label:after {
  color: #999;
}
[type="checkbox"]:disabled + label {
  color: #aaa;
}
/* accessibility */
[type="checkbox"]:checked:focus + label:before,
[type="checkbox"]:not(:checked):focus + label:before {
  border: 1px dotted blue;
}

/* hover style just for information */
label:hover:before {
  border: 1px solid #4778d9!important;
}
        .content-wrapper{
            background-color: white;
        }
    .theli{
        display: inline-block;
        outline: none;
        list-style: none;
        padding: 5px;
    }
    .theul{
        text-align: center;
        margin: 0px;
        padding: 0px;
        margin-top: 20px;
    }
    .refresh{
            float: right;
    padding: 5px;
    color: #0080ff;
    cursor: pointer;
    }
    .up{
        color: #f93040;
        margin-left: 5px;
            font-weight: 100;
    }
    .down{
        color: #20bdaa;
        margin-left: 5px;
            font-weight: 100;
    }
        .table1 tr{
            color:#d4d4d4;
        }
        .table1 tr td:first-child{
        color: #7e8e9f;
    }
    .table1 tr:first-child td{
        color: #fe8f00;
        font-weight: bold;
    }
    .table1 tr:first-child td:first-child{
        color: #7e8e9f;
        font-weight: 100;
    }
    .table1 td{
        font-size: 24px;
    }
    .table1 td:first-child{
        font-size: 16px;
    }
    .table1 td span{
        font-size: 16px;
    }
        .table1 th{
            color: #7e8e9f;
        }
        #line2d div:first-child{
            margin: auto;
        }
        .tb4 th{
                height: 40px;
    line-height: 40px;
        }
        .table_btn:nth-child(2){
                border-left: 0px;
    border-right: 0px;
        }
        .table_btn{
            border-bottom: 0px;
        }
        .canvasbody th{
            background-color: #f8f9fb;
        }
        .canvasbody tr:nth-child(2n){
            background-color: #fafcfb;
        }
        .fixed-table-container tbody td {
    border-left: 0px solid #dddddd !important; 
}
        .fixed-table-container thead th {
    border-left: 0px solid #dddddd !important;
        }
        .fixed-table-pagination{
            background-color: #f8f9fb;
        }
        .bottom_select{
            background-color: #f0f3f6;
        }
        .nonebottom{
            border-bottom: 0px;
        }
.render2{
    width:1200px;
    height:400px;
}
.render2kuang{
    overflow:auto;
}
body{
    overflow-x:hidden;
    overflow-y:auto;
}
.pagination{
    margin-right:10px;
}
</style>
	<div class="content-wrapper">
        <div class="banner bg_fff p_0_20">
                <a href="http://test008.iwide.cn/index.php/hotel"><i class="fa fa-home"></i> 商城套票</a>／<a href="http://test008.iwide.cn/index.php/hotel/orders">数据分析</a>／订单数据            </div>
        <!-- Main content -->
        <section class="main">
        	<div class="m1">
				<?php
					$sales_today = $sales_week = array();

					// 组织今日数据
					foreach ($compare_data['line1'] as $key => $value) {
						$sales_today[] = array('value' => $value, 'percent' => '0%', 'up_down' => true);
					}
					foreach ($compare_data['line4'] as $key => $value) {
						$percent = ($value < 0) ? (0 - $value) : $value;
						$up_down = ($value < 0) ? false : true;
						if($up_down){
							$sales_today[$key]['percent'] = number_format(($percent * 100), 2) . '%↑';
							$sales_today[$key]['up_down'] = $up_down;
						} else {
							$sales_today[$key]['percent'] = number_format(($percent * 100), 2) . '%↓';
							$sales_today[$key]['up_down'] = $up_down;
						}
					}

					// 组织今日数据
					foreach ($compare_data['line3'] as $key => $value) {
						$sales_week[] = array('value' => $value, 'percent' => '0%↑', 'up_down' => true);
					}
					foreach ($compare_data['line5'] as $key => $value) {
						$percent = ($value < 0) ? (0 - $value) : $value;
						$up_down = ($value < 0) ? false : true;
						if($up_down){
							$sales_week[$key]['percent'] = number_format(($percent * 100), 2) . '%↑';
							$sales_week[$key]['up_down'] = $up_down;
						} else {
							$sales_week[$key]['percent'] = number_format(($percent * 100), 2) . '%↓';
							$sales_week[$key]['up_down'] = $up_down;
						}
					}

				?>
        		<h2 class="border nonebottom">交易快报</h2>
                <div class="refresh">刷新快报</div>
        		<div class="table1 table_scroll w100">
	        		<table class="w100 border">
	        			<thead>
	        				<th>分析项目</th>
	        				<th>交易总额</th>
	        				<th>订单总数</th>
	        				<th>商品总份数</th>
	        				<th>核销总数</th>
	        			</thead>
	        			<tr>
	        				<td>今日</td>
	        				<?php foreach ($sales_today as $key => $value_arr): ?>
	        					<?php if($value_arr['up_down']): ?>
	        						<?php echo '<td class="orenge">' . $value_arr['value'] . '<span class="up">' . $value_arr['percent'] . '</span></td>'; ?>
	        					<?php else: ?>
	        						<?php echo '<td class="orenge">' . $value_arr['value'] . '<span class="down">' . $value_arr['percent'] . '</span></td>'; ?>
	        					<?php endif; ?>
	        				<?php endforeach; ?>
                            <!-- <td class="orenge">666123123123123123<span class="up">16%↑</span></td>
	        				<td class="orenge">123123123123131<span class="up">16%↑</span></td>
	        				<td class="orenge">256<span class="up">16%↑</span></td>
	        				<td>123<span class="down">16%↓</span></td> -->
	        			</tr>
	        			<tr>
	        				<td>上周</td>
	        				<?php foreach ($sales_week as $key => $value_arr): ?>
	        					<?php if($value_arr['up_down']): ?>
	        						<?php echo '<td>' . $value_arr['value'] . '<span class="up">' . $value_arr['percent'] . '</span></td>'; ?>
	        					<?php else: ?>
	        						<?php echo '<td>' . $value_arr['value'] . '<span class="down">' . $value_arr['percent'] . '</span></td>'; ?>
	        					<?php endif; ?>
	        				<?php endforeach; ?>
	        			</tr>
	        		</table>
        		</div>
        		<div class="table_search w100 relative border">
        			<div class="tsearch relative">
        				<div class="ib">条件时间</div>
        				<input type="date" class="dfv ib" value="<?php echo $s_date; ?>"/>
        				<div class="ib">至</div>
        				<input type="date" class="dfv ib" value="<?php echo $e_date; ?>"/>
        				<input type="button" class="btn btn-warning" value="搜索">
        			</div>
        		</div>
        		<div class="m2 w100">
	        		<h2 class="border nonebottom">渠道分析</h2>
	        		<div class="canvasbody render1 border">
	        			
	        		</div>
	        	</div>
	        	<div class="m3 w100">
	        		<h2 class="border nonebottom">数据曲线</h2>
	        		<div class="canvasbody border relative">
	        			<div class="linebtns relative">
	        				<ul class="theul">
                                <li class="theli">
                                    <input class="radio" type="checkbox" id="test1" checked="checked" data-whichone="js554行" />
                                    <label for="test1">交易总额</label>
                                </li>
                                <li class="theli">
                                    <input class="radio" type="checkbox" id="test2" checked="checked" data-whichone="js554行" />
                                    <label for="test2">订单总数</label>
                                </li>
                                <li class="theli">
                                    <input class="radio" type="checkbox" id="test3" checked="checked" data-whichone="js554行" />
                                    <label for="test3">商品总数</label>
                                </li>
                                <li class="theli">
                                    <input class="radio" type="checkbox" id="test4" checked="checked" data-whichone="js554行" />
                                    <label for="test4">核销总数</label>
                                </li>
                            </ul>
	        			</div>
                        <div class="render2kuang">
	        			    <div id="line2d" class="w100 render2"></div>
                        </div>
	        		</div>
	        	</div>

	        	<div class="m4 w100">
                    <div class="left w100">
	        		<h2 class="border ib left table_btn bottom_select" style="cursor:pointer;" data-type="1">每日明细</h2>
	        		<h2 class="border ib left table_btn" style="cursor:pointer;" data-type="2">销售额排行</h2>
	        		<h2 class="border ib left table_btn" style="cursor:pointer;" data-type="3">客单价排行</h2>
                    </div>
	        		<div class="canvasbody tbody1">
	        			<table class="w100 tb4" id="tb_departments1" data-pagination="true" data-toggle="table">
	        			<thead>
	        				<th>日期</th>
	        				<th>交易总额</th>
	        				<th>订单总数</th>
	        				<th>商品总数</th>
	        				<th>核销总数</th>
	        			</thead>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        		</table>
	        		</div>
                    <div class="canvasbody tbody2 none">
	        			<table class="w100 tb4" id="tb_departments2" data-pagination="true" data-toggle="table">
	        			<thead>
	        				<th>日期</th>
	        				<th>交易总额</th>
	        				<th>订单总数</th>
	        				<th>商品总数</th>
	        				<th>核销总数</th>
	        			</thead>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        		</table>
	        		</div>
                    <div class="canvasbody tbody3 none">
	        			<table class="w100 tb4" id="tb_departments3" data-pagination="true" data-toggle="table">
	        			<thead>
	        				<th>日期</th>
	        				<th>交易总额</th>
	        				<th>订单总数</th>
	        				<th>商品总数</th>
	        				<th>核销总数</th>
	        			</thead>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        			<tr>
	        				<td>11.23</td>
	        				<td>行政大床房</td>
	        				<td>12</td>
	        				<td>2</td>
	        				<td>30</td>
	        			</tr>
	        		</table>
	        		</div>
	        	</div>
        	</div>
        </section>
</div><!-- ./wrapper -->
<script>
    function getnowtime(){
        var date = new Date();
        var datex = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
        $(".dfv").attr("value",datex);
    }
    // getnowtime();
    $(".btn-warning").on("click",function(){
        var starttime = (new Date($(".dfv")[0].value)).getTime(); 
        var endtime = (new Date($(".dfv")[1].value)).getTime(); 
        var days = parseInt((endtime-starttime)/(1000*3600*24)) + 1;
        var startdays = $(".dfv")[1].value;
        //alert("开始日期"+startdays+",相差:"+days+"天,代码位置610");
        var theurl = window.location;
        StandardPost(theurl,{date:startdays,days:days,<?php echo $token_name; ?>:'<?php echo $token; ?>'})
    });
    function StandardPost (url,args) 
    {
        var form = $("<form method='post'></form>");
        form.attr({"action":url});
        for (arg in args)
        {
            var input = $("<input type='hidden'>");
            input.attr({"name":arg});
            input.val(args[arg]);
            form.append(input);
        }
        form.submit();
    }
	function setChart(info){
		var dom = document.createElement("div");
        dom.style.width = "350px";
        dom.style.height = "200px";
        dom.style.display = "inline-block";
        dom.style.margin = "20px";
        var render1 = document.querySelector(".render1");
        render1.appendChild(dom);
        var mychart = echarts.init(dom);
        var legend_data = [];
        var series_data = [];
        for(var i = 0 ; i < info.data.length;i++){
            legend_data.push(info.data[i].name);
            series_data.push({
                value:info.data[i].value,
                name :info.data[i].name
            });
        }
        option = {
            legend: {
                orient: 'vertical',
                x: 'left',
                data:legend_data
            },
            title : {
                show : true,
                text : info.header,
                textAlign: "center",
                bottom: 0,
                left:"50%",
                textStyle: {
                    color: '#333',
                    fontSize: 12,
                },
            },
            series: [
                {
                    name:info.header,
                    type:'pie',
                    radius: ['50%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '15',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    data:series_data
                }
            ]
        }
        mychart.setOption(option);
    }

		<?php
            // 重构饼状图数据格式，兼容旧页面
            $color = array("#33adbc", "#f66954", "#04475a", "#00a65a");
            $new_total = array();
            foreach ($total_pie as $key => $item) {
                $_tmp['name']  = $item['label'];
                $_tmp['value'] = $item['value'];
                $_tmp['color'] = $color[ $key%4 ];
                $new_total[] = $_tmp;
            }

            $new_count = array();
            foreach ($count_pie as $key => $item) {
                $_tmp['name']  = $item['label'];
                $_tmp['value'] = $item['value'];
                $_tmp['color'] = $color[ $key%4 ];
                $new_count[] = $_tmp;
            }

            $new_qty = array();
            foreach ($qty_pie as $key => $item) {
                $_tmp['name']  = $item['label'];
                $_tmp['value'] = $item['value'];
                $_tmp['color'] = $color[ $key%4 ];
                $new_qty[] = $_tmp;
            }
        ?>

		setChart({
			header : "订单总额",
			data : <?php echo json_encode($new_total, JSON_UNESCAPED_UNICODE); ?>
		});
		setChart({
			header : "订单数量",
			data : <?php echo json_encode($new_count, JSON_UNESCAPED_UNICODE); ?>
		});
		setChart({
			header : "购买数量",
			data : <?php echo json_encode($new_qty, JSON_UNESCAPED_UNICODE); ?>
		});
		var rd2 = document.querySelector(".render2kuang").clientWidth;
        $(".render2").css({width:rd2,height:rd2/3});
		function drawline(info){
            var dom = document.querySelector(".render2");
            var mychart = echarts.init(dom);
            var xAxis_data = info.labels;
			option = {
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data:xAxis_data
                },
                yAxis: {
                    type: 'value'
                },
                series: info.data
            };
            mychart.setOption(option);
		}

		<?php
            // 重构折线图数据格式，兼容旧页面
            $sales_data = $order_data = $product_data = $consumer_data = array();
            $sales_labels = $order_labels = $product_labels = $consumer_labels = array();

            // 交易总额
            $_tmp = array();
            foreach ($data_1 as $key => $item) {
            	if(true || $key%3 == 0) {
                	$sales_labels[] = $item['date'];
                }
                $_tmp[] = $item['amount'];
            }
            $sales_data = array( "name" => '交易总额', "data" => $_tmp, "type" => "line");

            // 订单总数
            $_tmp = array();
            foreach ($data_2 as $key => $item) {
                $order_labels[] = $item['date'];
                $_tmp[] = $item['amount'];
            }
            $order_data = array( "name" => '订单总数', "data" => $_tmp, "type" => "line");

            // 商品总数
            $_tmp = array();
            foreach ($data_3 as $key => $item) {
                $product_labels[] = $item['date'];
                $_tmp[] = $item['amount'];
            }
            $product_data = array( "name" => '商品总数', "data" => $_tmp, "type" => "line");

            // 核销总数
            $_tmp = array();
            foreach ($data_3 as $key => $item) {
                $consumer_labels[] = $item['date'];
                $_tmp[] = $item['amount'];
            }
            $consumer_data = array( "name" => '核销总数', "data" => $_tmp, "type" => "line");

            $drawline_labels = $sales_labels;
        
            $drawline_data = array($sales_data, $order_data, $product_data, $consumer_data);
        ?>
        var drawline_data = <?php echo json_encode($drawline_data, JSON_UNESCAPED_UNICODE); ?>;
        var thelabels = <?php echo json_encode($drawline_labels, JSON_UNESCAPED_UNICODE); ?>;
		drawline({
			labels : thelabels,
			data :drawline_data,		
                 });
    //数据曲线配置接口，labels为数组配置X轴标签名，data为数组可以配置多根曲线，数组中每个对象.name为曲线名称.value用来配置X轴每个焦点上的值.color配置曲线颜色.line-width配置2点之间横向距离
		
		// 每日明细数据
		var detail_head = <?php echo json_encode($table_head, JSON_UNESCAPED_UNICODE); ?>;
		var detail_data = <?php echo json_encode($table_data, JSON_UNESCAPED_UNICODE); ?>;

		// 销售额排行
		var sales_total_head = <?php echo json_encode($total_head, JSON_UNESCAPED_UNICODE); ?>;
		var sales_total_data = <?php echo json_encode($total_data, JSON_UNESCAPED_UNICODE); ?>;

		// 客单价排行
		var sales_avg_head = <?php echo json_encode($avg_head, JSON_UNESCAPED_UNICODE); ?>;
		var sales_avg_data = <?php echo json_encode($avg_data, JSON_UNESCAPED_UNICODE); ?>;

 
 
 function getTable(a,b,c){
     var thehtml = "<thead>";
     var thebody = "";
     var arr = [];
     for(var i = 0; i < a.length ; i++){
         thehtml = thehtml + '<th>'+a[i]+'</th>';
         arr.push({field:"x",title:a[i]});
     }
     thehtml = thehtml + "</thead>";
     for(var j = 0; j < b.length ; j++){
         thebody = thebody + "<tr>";
         for(var i = 0; i < b[j].length ; i++){
             thebody = thebody + '<td>'+b[j][i]+'</td>';
         }
         thebody = thebody + "</tr>";
     }
     var total = thehtml + thebody;
     $(""+c).html(total);
 }
getTable(detail_head,detail_data,"#tb_departments1");
    getTable(sales_total_head,sales_total_data,"#tb_departments2");
    getTable(sales_avg_head,sales_avg_data,"#tb_departments3");
    $(".radio").on("change",function(){
        var arr = [];
        for(var i = 0; i < $(".radio").length;i++){
            arr.push($(".radio")[i].checked);
        }
        Radio(arr);
    });
    $(".table_btn").on("click",function(){
        var types = this.dataset.type;
        switch(types){
            case "1":
                $(".tbody1").removeClass("none");
                $(".tbody2").addClass("none");
                $(".tbody3").addClass("none");
                $(".table_btn").removeClass("bottom_select");
                $(this).addClass("bottom_select");
                break;
            case "2":
                $(".tbody2").removeClass("none");
                $(".tbody1").addClass("none");
                $(".tbody3").addClass("none");
                $(".table_btn").removeClass("bottom_select");
                $(this).addClass("bottom_select");
                break;
            case "3":
                $(".tbody3").removeClass("none");
                $(".tbody2").addClass("none");
                $(".tbody1").addClass("none");
                $(".table_btn").removeClass("bottom_select");
                $(this).addClass("bottom_select");
                break;
        }
    });
    function Radio(arr){
        var okit = [];
        for(var i = 0 ; i < arr.length; i++){
            if(arr[i]){
                okit.push(drawline_data[i]);
            }
        }
        drawline({
			labels : thelabels,
			data :okit,		
                 });
    }
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
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
</body>