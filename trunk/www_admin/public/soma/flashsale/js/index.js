/**
 * 失败提示弹窗
 * @param {string} msg 错误的提示
 * */
function errorLayer (msg) {
	var errorLayer = $('#errorLayer'), errorLayerMessage = $('#errorLayerMessage');
	errorLayerMessage.html(msg);
	errorLayer.show();
	errorLayer.find('.btn').off().on('click', function () {
		errorLayer.hide();
	})
}

/**
 * 使失效
 * */
function invalid () {
	$('.edit-invalid').off().on('click', function () {
		var id = $(this).attr('itemId');
		var status = $(this).attr('status');
		var layer = $('#invalidLayer');
		var actId = $(this).attr('actid');
		var tokenName = $("#token").attr('name');
		var tokenValue = $("#token").val();

		if (status === 'run') {
			layer = $('#runInvalidLayer');
		}

		layer.show();

		layer.off().on('click', '.btn', function () {
			var ajaxData = {act_id: actId}
			ajaxData[tokenName] = tokenValue;
			$.ajax({
				url: '/index.php/soma/activity_killsec/disable_status',
				method: 'post',
				data: ajaxData,
				dataType: 'json',
				success: function (s) {
					if (s.status === 1) {
						location.reload();
						return false;
					}
					if (s.status === 2) {
						layer.hide();
						errorLayer('服务器异常，请稍后重试!');
						return false;
					}
				},
				fail: function () {
					layer.hide();
					errorLayer('服务器异常，请稍后重试!');
				}
			})

		});

	});
}

/**
 * 修改库存
 * @param actId      活动ID
 * @param addStockNum    增加多少库存
 */
function modifyStock (actId, addStockNum) {

}

/**
 * 检查redis情况
 */
function checkRedis(){
    $('.check-redis').off().on('click', function () {
        var actId = $(this).attr('actId');
        var tokenName = $("#token").attr('name');
        var tokenValue = $("#token").val();
        var ajaxData = {act_id: actId};
        ajaxData[tokenName] = tokenValue;
        var layer =  $('#checkLayer');
        var tips = null; // 改变前的提示
        layer.show();
        $.ajax({
            url: '/index.php/soma/activity_killsec/check_instance_status',
            method: 'post',
            data: ajaxData,
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (s) {
                tips = layer.find('.show-tips');
                if(s.status == 1){
                    tips.html("状态正常<br/>"+s.msg);
                }else{
                    layer.hide();
                    tips.html("loading...");
                    errorLayer("状态异常<br/>"+s.msg);
                }
            },
            fail: function () {
                layer.hide();
                tips.html("loading...");
                errorLayer('服务器异常，请稍后重试!');
            },
            error: function () {
                layer.hide();
                tips.html("loading...");
                errorLayer('服务器异常，请稍后重试!');
            },
            complete: function () {

            }
        })
    });

    $('.check-close').off().on('click', function () {
        var layer =  $('#checkLayer');
        var tips = layer.find('.show-tips');
        tips.html("loading...");
        layer.hide();
    })
}

/**
 * 增加库存
 **/
function store () {
	$('.edit-store').off().on('click', function () {
		var id = $(this).attr('itemId');
		var status = $(this).attr('status');
		var numberLayer = $('#numberLayer');
		var storeLayer = $('#storeLayer');
		var actId = $(this).attr('actid');
		var count = $(this).attr('count');
		var permax = $(this).attr('permax');
		var layer = null;
		var layerInput = null; // 输入框
		var tips = null; // 改变前的提示
		var numberTips = null; // 改后数量后的提示

		if (status === 'store') {
			layer = storeLayer;
			tips = layer.find('.show-tips');
			layerInput = layer.find('input');
			numberTips = layer.find('.number-tips');
			tips.html('限制库存' + count + '份，每人限购' + permax + '份');

			// numberTips.html(count + '份,每人限购' + permax + '份');
			// 提示改变后的提示
			layerInput.off().on('keyup', function () {
				if ($.trim($(this).val()).length > 0 && !!parseFloat($(this).val()) !== false) {
					var number = (parseFloat($(this).val()) + parseFloat(count));
					numberTips.html(number + '份,每人限购' + permax + '份');
				} else {
					numberTips.html('')
				}
			});


		} else if (status === 'people') {
			layer = numberLayer;
			tips = layer.find('.show-tips');
			layerInput = layer.find('input');
			numberTips = layer.find('.number-tips');
			numberTips.html(count + '份,每人限购' + permax + '份');

			// 提示总数
			tips.html('限制库存' + count + '人，每人限购' + permax + '份');

			// 提示改变后的提示
			layerInput.off().on('keyup', function () {
				if ($.trim($(this).val()).length > 0 && !!parseFloat($(this).val()) !== false) {
//					var number = (parseFloat($(this).val()) + parseFloat(count)) * parseFloat(permax);
                    var number = (parseFloat($(this).val()) + parseFloat(count));
					numberTips.html(number + '份,每人限购' + permax + '份');
				} else {
					numberTips.html('')
				}
			});

		}

		layer.show();

		layer.off().on('click', '.btn', function () {

			var value = $.trim(layer.find('.number').val());
			if (value.length === 0) {
				layer.find('.number').focus();
			} else if (!/^\d+$/.test(value)) {
				layer.find('.number').focus();
			} else {

				var tokenName = $("#token").attr('name');
				var tokenValue = $("#token").val();
				var ajaxData = {act_id: actId, add_stock_num: value};
				ajaxData[tokenName] = tokenValue;
				var _this = $(this);
				if (_this.html() === '确 定') {
					$.ajax({
						url: '/index.php/soma/activity_killsec/modify_stock',
						method: 'post',
						data: ajaxData,
						dataType: 'json',
						beforeSend: function () {
							_this.html('提交中');
						},
						success: function (s) {
							if (s.status === 1) {
								location.reload();
								return false;
							}
							if (s.status === 2) {
								layer.hide();
								errorLayer(s.msg);
								return false;
							}
						},
						fail: function () {
							layer.hide();
							errorLayer('服务器异常，请稍后重试!');
						},
						error: function () {
							layer.hide();
							errorLayer('服务器异常，请稍后重试!');
						},
						complete: function () {
							_this.html('确 定');
						}
					})
				}


			}
		});

	});
}

/**
 * 切换分页数目
 * */
function switchPageNumber () {
	$('#switchPageNumber').on('change', function () {
		$('#killIndexForm').submit();
	})
}

/**
 * 输入分页
 */
function inputPageNumber () {
	var page = $('#go')
	var pageValue = $('#page');
	page.on('click', function (ev) {
		ev.preventDefault();
		var val = pageValue.val();
		if (!!val === false) {
			val = 1
		}
		window.location.href = page.attr('href') + val

	})
}

/**
 * 使所有的弹窗关闭
 **/
function closeLayer () {
	var layer = $('.kill-layer');
	layer.find('.close').on('click', function () {
		layer.find('.number').blur().val('');
		layer.hide();
	});
}

/**
 * 抢购模式弹窗口
 * @param number  标题的数量
 * @param data  表格的数据
 **/
 function homebuyingLayer (data, number) {
 	var homebuying = $('#homebuying'); // 弹层
 	var homebuyingTable = $('#homebuyingTable'); // 表格
 	var btn = homebuying.find('.btn').eq(0); // 按钮
 	var title = $('#homebuyingTitle'); // 标题
 	if (number) {
 		title.html('抢购模式：每人限购'+ number +'份')
 	}

 	homebuyingTable.find('.homebuying-tr .homebuying-number').removeClass('is--error');
 	var content = data;
 	var str = '<tr>' + 
                  '<th>商品名称</th>' +
                  '<th>商品规格</th>' +
                  '<th>抢购库存</th>' +
                  '<th>库存</th>' +
                  '<th>增加库存</th>' +
               '</tr>';

    for (var i = 0; i < data.length; i++) {
    	str+= '<tr class="homebuying-tr">' +
    			'<td>'+ data[i]['product_name'] +'</td>' +
    			'<td>'+ data[i]['spec_name'] +'</td>' +
    			'<td>'+ data[i]['killsec_count'] +'</td>' +
    			'<td>'+ data[i]['spec_stock'] +'</td>' +
    			'<td><input type="number" class="homebuying-number"></td>' +
    		  '</tr>';	
    }

    homebuyingTable.html(str);
 	homebuying.show();

 	btn.off().on('click', function(event) {
 		event.preventDefault();
 		// 获取数据
 		for (var i = 0; i < homebuyingTable.find('.homebuying-tr').length; i++) {
 			var stock = parseFloat(homebuyingTable.find('.homebuying-tr').eq(i).find('.homebuying-number').val()) || 0;
 			if (data[i]) {
 				 data[i].add_stock = stock;
 			}
 		}

 		// 判断是否所有的数据都是 0
 		var checkZero = [];
 		var result = [];
 		for (var i = 0; i < data.length; i++) {
 			if (data[i]['add_stock'] === 0) {
 				checkZero.push(0);
 			}
 			result.push({
				'setting_id': data[i]['setting_id'] ,
				'add_stock:': data[i]['add_stock'] 
 			})
 		}
 		if (checkZero.length === data.length) {
 			console.log(checkZero.length, data.length);
 			homebuying.hide();
 			return false;
 		}

 		var passed = true;
 		for (var i = 0; i < data.length; i++) {
 			var addStock = parseFloat(data[i]['add_stock']); // 添加的库存
 			var killsecCount = parseFloat(data[i]['killsec_count']); // 抢购库存
 			var specStock = parseFloat(data[i]['spec_stock']); // 总库存
 			if (addStock + killsecCount > specStock) {
 				homebuyingTable.find('.homebuying-tr').eq(i).find('.homebuying-number').addClass('is--error');
 				passed = false;
 			} else {
 				homebuyingTable.find('.homebuying-tr').eq(i).find('.homebuying-number').removeClass('is--error');
 			}
 		}

 		// 通过验证
 		if (passed) {
 			console.log(result);
 			// ajax
 			homebuying.hide();
 		}
 	});

 }

$(function () {
	//homebuyingLayer([{
	//	'cat_name': '优惠',
	//	'product_id': '123',
	//	'product_name': '金房卡月饼',
	//	'setting_id':  '12222',
	//	'spec_name': '精装版',
	//	'spec_price': 20000,
	//	'spec_stock': 300,
	//	'killsec_price': 1,
	//	'killsec_count': 100
	//}, {
	//	'cat_name': '优惠',
	//	'product_id': '123',
	//	'product_name': '金房卡月饼',
	//	'setting_id':  '2222',
	//	'spec_name': '精装版',
	//	'spec_price': 20000,
	//	'spec_stock': 300,
	//	'killsec_price': 1,
	//	'killsec_count': 100
	//}], 29);
	invalid();
	store();
	closeLayer();
	switchPageNumber();
	inputPageNumber();
    checkRedis();
});