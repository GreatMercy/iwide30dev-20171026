// 选择日期的默认配置
var dateDefaultConfig = {
    skinCell: "jedateblue", // 日期风格样式，默认蓝色
    format: "YYYY-MM-DD hh:mm:ss", // 日期格式
    minDate: "1900-01-01 00:00:00", // 最小日期
    maxDate: "2099-12-31 23:59:59", // 最大日期
    language: { // 多语言设置
        name: "cn",
        month: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
        weeks: ["日", "一", "二", "三", "四", "五", "六"],
        times: ["小时", "分钟", "秒数"],
        clear: "清空",
        today: "今天",
        yes: "确定",
        close: "关闭"
    },
    choosefun: function() {
        return false;
    }
};


// 选择的状态值
var killState = {
    weekValue: [], // 星期的value
    durationLimit: 72, // 持续时间的限制
    activeTimeId: '1', // 活动的时间
    limitWayId: '1' // 选择的限制方式
};


/**
 * 选择展示日期
 */
function showTime() {
    $("#showTime").jeDate(dateDefaultConfig);
}

/**
 * 启动时间
 */
function startUpTime() {
    var value = $('#startTimeValue');
    $('#startUpTime').jeDate({
        skinCell: 'jedateblue', // 日期风格样式，默认蓝色
        format: 'hh:mm:ss', // 日期格式
        language: dateDefaultConfig.language,
        okfun: function(elem, val, date) {
            value.val(val);
        },
        clearfun: function(elem, val) {
            value.val('');
        },
        choosefun: function(elem, val, date) {
            value.val(val);
        }
    })

    $('#fixedStartUpTime').jeDate({
        skinCell: 'jedateblue', // 日期风格样式，默认蓝色
        format: 'YYYY-MM-DD hh:mm:ss', // 日期格式
        language: dateDefaultConfig.language,
        okfun: function(elem, val, date) {
            value.val(val);
        },
        clearfun: function(elem, val) {
            console.log('clear');
            value.val('');
        },
        choosefun: function(elem, val, date) {
            value.val(val);
        }
    })
}

/**
 *
 * */

/**
 * 检测当前活动时间选择的状态，修改当前的选项
 * @param {string} name 活动时间的radio的name值
 */
function checkActiveStatus(name) {
    killState.activeTimeId = $('input[name=' + name + ']:checked').val(); // 选中的id
    var week = $('#week'),
        selectTime = $('#selectTime');
    var startUpTime = $('#startUpTime'),
        fixedStartUpTime = $('#fixedStartUpTime')

    // 选中了固定的时间
    if (killState.activeTimeId === '1') {
        week.hide();
        selectTime.hide();
        startUpTime.hide();
        fixedStartUpTime.show();
        $('#startTimeValue').val(fixedStartUpTime.val());
    }

    // 选中了按周期循环
    if (killState.activeTimeId === '2') {
        week.show();
        selectTime.show();
        selectStartTime();
        startUpTime.show();
        fixedStartUpTime.hide();
        $('#startTimeValue').val(startUpTime.val());
    }

    setPlaceholder();
}


/**
 * 选择按周循环
 */
function duration() {
    var checkbox = $('.week-checkbox');

    checkbox.on('click', function() {
        killState.weekValue = [];
        var checked = $('.week-checkbox:checked');

        checked.each(function(i) {
            killState.weekValue.push(checked.eq(i).val());
        });

        setPlaceholder();

    });
}

/**
 * 选择按周循环
 */
function checkDuration() {
    killState.weekValue = [];
    var checked = $('.week-checkbox:checked');
    if (checked)
        checked.each(function(i) {
            killState.weekValue.push(checked.eq(i).val());
        });
}

/**
 * 设置持续时间的placeholder
 * */
function setPlaceholder() {
    var duration = $('#duration');

    // 判断当前选择的是固定时间还是持续时间
    if (killState.activeTimeId === '1') {
        killState.durationLimit = 72;

    } else if (killState.activeTimeId === '2') {

        if (killState.weekValue.length >= 2) {
            killState.durationLimit = 23;
        } else {
            killState.durationLimit = 72;
        }

    }

    duration.attr('placeholder', '1-' + killState.durationLimit + '小时之内');
}

/**
 * 按周期循环 选择开始时间 和 选择结束时间
 */
function selectStartTime() {

    var startTime = $('#startTime'),
        endTime = $('#endTime');


    var start = {
        format: 'YYYY-MM-DD',
        minDate: $.nowDate({ DD: 0 }),
        //		minDate: dateDefaultConfig.minDate, //设定最小日期为当前日期
        isinitVal: false,
        ishmsVal: false,
        maxDate: dateDefaultConfig.maxDate, //最大日期
        //		maxDate: $.nowDate({DD: 0}), //最大日期
        language: dateDefaultConfig.language,
        choosefun: function(elem, val, date) {
            end.minDate = date; //开始日选好后，重置结束日的最小日期
            endDates();
        }
    };


    var end = {
        format: 'YYYY-MM-DD',
        minDate: $.nowDate({ DD: 0 }), //设定最小日期为当前日期
        maxDate: dateDefaultConfig.maxDate, //最大日期
        language: dateDefaultConfig.language,
        choosefun: function(elem, val, date) {
            start.maxDate = date; //将结束日的初始值设定为开始日的最大日期
        }
    };


    // 这里是日期联动的关键
    function endDates() {
        endTime.jeDate(end);
    }

    startTime.jeDate(start);
    endTime.jeDate(end);
}


/**
 * 选择活动时间
 * @param  {string} name 活动时间的radio的name值
 */
function selectActiveTime(name) {
    $('input[name=' + name + ']').on('click', function() {
        checkActiveStatus(name);
    });
}

/**
 * 检测限制方式
 * */
function checkLimitWay(name) {
    killState.limitWayId = $('input[name=' + name + ']:checked').val();

    var limitStore = $('#limitStore'),
        storeTips = $('#storeTips'),
        limitPeopleNumber = $('#limitPeopleNumber'),
        peopleNumberTips = $('#peopleNumberTips');

    if (killState.limitWayId === '1') {
        limitStore.show();
        storeTips.show();
        limitPeopleNumber.hide();
        peopleNumberTips.hide();
    }

    if (killState.limitWayId === '2') {
        limitPeopleNumber.show();
        peopleNumberTips.show();
        limitStore.hide();
        storeTips.hide();
    }

}

/**
 * 选择限制的方式
 * @param {string} name 限制方式的radio的name值
 */
function selectLimitWay(name) {
    $('input[name=' + name + ']').on('click', function() {
        checkLimitWay(name);
    });
}

/**
 * 检测选择的状态
 */
var goodsListData = [];

function checkGoodsSelect() {
    var goodsList = $('#goodsList');
    var goodsInfo = $('#goodsInfo');
    var storeTypeTips = $('#storeTypeTips');
    var goodsTableList = $('#goodsTableList');
    var value = goodsList.val();
    if (value === '' || value === null) {
        goodsInfo.hide();
        storeTypeTips.hide();
    } else {
        var act_id = $('input[name="act_id"]').val();
        var csrf_token = $('input[name="csrf_token"]').val();
        $.ajax({
            type: 'post',
            url: '/index.php/soma/activity_flashsale/get_product_specification',
            data: {
                act_id: act_id,
                product_id: value,
                csrf_token: csrf_token
            },
            dataType: 'json',
            success: function(data){
                var tableData = data.data;

                goodsListData = tableData

                var dom = '<tr>' +
                    '<th>分类</th>' +
                    '<th>商品名称</th>' +
                    '<th>商品规格</th>' +
                    '<th>微信价</th>' +
                    '<th>库存</th>' +
                    '<th>抢购价</th>' +
                    '<th>抢购库存</th>' +
                    '</tr>';

                for (var i = 0; i < tableData.length; i++) {
                    var str = '<tr>' +
                        '<td>' + tableData[i].cat_name + '</td>' +
                        '<td>' + tableData[i].product_name + '</td>' +
                        '<td>' + tableData[i].spec_name + '</td>' +
                        '<td>' + tableData[i].spec_price + '</td>' +
                        '<td>' + tableData[i].spec_stock + '</td>' +
                        '<td><input type="text" value="' + tableData[i].killsec_price + '" class="killsec_price"></td>' +
                        '<td><input type="text" value="' + tableData[i].killsec_count + '" class="killsec_count"></td>'
                    '</tr>';
                    dom += str
                }

                goodsTableList.html(dom);
                goodsInfo.show();
                storeTypeTips.show();
                 checkSpec(data.is_specification, 1);
            }
        });
    }
}

/**
  * 修改多规格的显示
  * @param {string} defaultValue 默认选中的值
  * @param {string} isSpec 属于哪种规格
  */
function checkSpec (isSpec,defaultValue) {
    var LimitShare = $('#LimitShare'); // 限购份数
    var homebuyingType = $('#homebuyingType');
    homebuyingType.html('');
    console.log(parseInt(isSpec));
    if (parseInt(isSpec) === 1) {
        //  单规格
        homebuyingType.html('<option value="1" checked>每个商品限购</option>');

    } else if (parseInt(isSpec) === 2) {
        // 多规格
        homebuyingType.html('<option value="1">每个商品限购</option><option value="2">每个规格限购</option>');
        homebuyingType.val(defaultValue);
    }


     LimitShare.val('');
}

/**
 * 选择商品
 */
function selectGoods() {
    var currentStore = $('#currentStore'),
        weChatPrice = $('#weChatPrice'),
        killPrice = $('#killPrice'),
        goodsList = $('#goodsList');

    goodsList.on('change', function() {
        checkGoodsSelect();
    });
}

/**
 * 显示错误提示
 * @param {string} msg 需要显示的错误信息
 * @param {boolean} bol 是否显示错误信息框
 */
function showErrorMessage(msg, bol) {
    var errorMsg = $('#errorMsg'),
        errorBox = $('#errorBox');
    errorMsg.html(msg);
    errorBox.show();

    $('#errorClose').off().on('click', function() {
        errorBox.hide();
    });

    if (bol) {
        errorBox.hide();
    }
}

function goBackAndCancel() {
    $('#cancelSave').on('click', function() {
        window.history.back(-1);
    });
}

/**
 * 保存秒杀
 */
function saveSeckill() {

    $('#killSave').on('click', function() {

        var activeName = $('#activeName'), // 活动时间
            keyWord = $('#keyWord'), // 关键字
            showTime = $('#showTime'), // 展示时间
            startUpTime = $('#startUpTime'), // 启动时间
            duration = $('#duration'), // 持续时间
            startTime = $('#startTime'), // 开始时间
            endTime = $('#endTime'), // 结束时间
            storeTotal = $('#storeTotal'), // 总库存
            homebuying = $('#homebuying'), // 每份的限制
            peopleNumber = $('#peopleNumber'), // 多少人限购1份
            limitNumber = $('#limitNumber'), // 限购多少份
            killPrice = $('#killPrice'), // 秒杀价
            goodsList = $('#goodsList'), // 用户选择的商品
            fixedStartUpTime = $('#fixedStartUpTime'), // 固定时间
            LimitShare = $('#LimitShare'); // 限购分数


        // 判断活动名称是否为空
        if ($.trim(activeName.val()).length === 0) {
            showErrorMessage('请输入活动名称!', false);
            return false;
        }

        // 判断关键字描述是否为空
        if ($.trim(showTime.val()).length === 0) {
            showErrorMessage('请选择展示时间!', false);
            return false;
        }

        // 判断活动时间

        var durationValue = $.trim(duration.val());

        // 选中了固定的时间
        if (killState.activeTimeId === '1') {


            // 判断启动时间是否为空
            if ($.trim(fixedStartUpTime.val()).length === 0) {
                showErrorMessage('请选择启动时间!', false);
                return false;
            }

            // 判断持续时间是否为空
            if (durationValue.length === 0) {
                showErrorMessage('请输入持续时间!', false);
                return false;
            }

            // 判断持续时间是否符合要求
            if (parseFloat(durationValue) < 1 || parseFloat(durationValue) > 72) {
                showErrorMessage('持续时间请输入1-72小时内!', false);
                return false;
            }

            if (moment(fixedStartUpTime.val()).valueOf() - moment(showTime.val()).valueOf() < 60000) {
                showErrorMessage('展示时间要比启动时间早10分钟以上!', false);
                return false
            }

            var currentTime = moment(fixedStartUpTime.val()).valueOf() - moment().valueOf();

            if (currentTime < 60000) {
                showErrorMessage('启动时间要比当前时间预留10分钟!', false);
                return false
            }

        }

        // 选中了按周期循环
        if (killState.activeTimeId === '2') {

            // 判断开始时间是否为空
            if ($.trim(startTime.val()).length === 0) {
                showErrorMessage('请选择开始时间!', false);
                return false;
            }

            // 判断结束时间是否为空
            if ($.trim(endTime.val()).length === 0) {
                showErrorMessage('请选择结束时间!', false);
                return false;
            }

            // 判断是否选择了时间段
            if (killState.weekValue.length === 0) {
                showErrorMessage('请选择时间段!', false);
                return false;
            }

            // 判断是否选择启动时间
            if ($.trim(startUpTime.val()).length === 0) {
                showErrorMessage('请选择启动时间!', false);
                return false;
            }

            // 判断持续时间是否为空
            if (durationValue.length === 0) {
                showErrorMessage('请输入持续时间!', false);
                return false;
            }

            // 根据规则判断持续是否输入正确
            if (parseFloat(durationValue) < 1 || parseFloat(durationValue) > killState.durationLimit) {
                showErrorMessage('请输入1-' + killState.durationLimit + '小时内!', false);
                return false;
            }

            if (moment(startTime.val()).valueOf() > moment(endTime.val()).valueOf()) {
                showErrorMessage('结束时间必须小于开始时间!', false);
                return false
            }

            var prefix = moment(startTime.val()).format('YYYY-MM-DD')
            var startUpValue = prefix + ' ' + startUpTime.val();
            if (moment(startUpValue).valueOf() - moment(showTime.val()).valueOf() < 60000) {
                showErrorMessage('展示时间要比启动时间早10分钟以上!', false);
                return false
            }
        }


        // 判断限制方式
        if (killState.limitWayId === '2') {

            if ($.trim(LimitShare.val()).length === 0) {
                showErrorMessage('请输入限购份数!', false);
                return false;
            }

            if (parseInt($.trim(LimitShare.val())) === 0) {
                showErrorMessage('请输入限购份数!', false);
                return false;
            }

            if (/^[0-9]+$/.test($.trim(LimitShare.val())) === false) {
                showErrorMessage('请输入正确的限购份数!', false);
                return false;
            }
        }


        // 判断是否选择了其他
        var otherValue = [];
        var otherChecked = $('.kill-other:checked');
        otherChecked.each(function(i) {
            otherValue.push(otherChecked.eq(i).val());
        });

        if (otherValue.length === 0) {
            showErrorMessage('请选择其他中的一项!', false);
            return false;
        }

        // 判断用户是否选择了商品
        if (goodsList.val() === null || $.trim(goodsList.val()).length === 0 || goodsList.val() === '') {
            showErrorMessage('请选择商品!', false);
            return false;
        }

        // 判断用户是否输入了秒杀价
        // if ($.trim(killPrice.val()).length === 0) {
        //     showErrorMessage('请输入秒杀价!', false);
        //     return false;
        // }
        var goodsTableList = $('#goodsTableList');
        if (goodsListData.length === 0) {
            showErrorMessage('请选择商品!', false);
            return false
        } else {

            // 获取数据
            for (var i = 0; i < goodsTableList.find('tr').length; i++) {
                var killsec_price = goodsTableList.find('tr').eq(i).find('.killsec_price').val();
                var killsec_count = goodsTableList.find('tr').eq(i).find('.killsec_count').val();
                if (killsec_price && goodsListData[i - 1]) {
                    goodsListData[i - 1]['killsec_price'] = killsec_price;
                }
                if (killsec_count && goodsListData[i - 1]) {
                    goodsListData[i - 1]['killsec_count'] = killsec_count;
                }
            }

            function setError(index, ele, bol) {
            	if (!bol) {
            		goodsTableList.find('tr').eq(index + 1).find(ele).removeClass('is--error').addClass('is--error');
            	} else {
            		goodsTableList.find('tr').eq(index + 1).find(ele).removeClass('is--error');
            	}
            }

            var passed = true;

            for (var i = 0; i < goodsListData.length; i++) {
                // 判断微信价
                var price = parseFloat(goodsListData[i]['killsec_price']);
                var count = parseFloat(goodsListData[i]['killsec_count']);
                if (price) {
                	console.log(price <= parseFloat(goodsListData[i]['spec_price']));
                	if (price > 0 && price <= parseFloat(goodsListData[i]['spec_price'])) {
                	  setError(i, '.killsec_price', true);
                	} else {
                	  setError(i, '.killsec_price');
                	  passed = false;
                	}
                } else {
                	setError(i, '.killsec_price');
                	passed = false;
                }

                // 判断库存
                if (count) {
                    if (count <= parseFloat(goodsListData[i]['spec_price']) && count >=0) {
                    	 setError(i, '.killsec_count', true);
                    } else {
                    	setError(i, '.killsec_count');
                    	passed = false;
                    }
                } else {
                	setError(i, '.killsec_count');
                	passed = false;
                }
            }

            if (passed === false) {
            	showErrorMessage('请输入正确的抢购价和抢购库存!', false);
            	return false;
            }

        }


        showErrorMessage('', true);

        var layer = $('#saveLayer');
        layer.show();

        layer.find('.btn').off().on('click', function() {
            $('#killSave').closest("form").submit();
            layer.hide();
        });

        layer.find('.close').off().on('click', function() {
            layer.hide();
        });
    });
}

function choiceActivityType () {
    $('.homebuying-activity_name').on('click', function() {
        if ($(this).hasClass('is--disabled')) {
            return false;
        } else {
             window.location.href = $(this).attr('href');
        }
    });
}

$(function() {
    choiceActivityType();
    checkGoodsSelect();
    startUpTime();
    showTime();
    duration();
    checkActiveStatus('schedule_type');
    selectActiveTime('schedule_type');
    checkLimitWay('is_astrict_buy');
    selectLimitWay('is_astrict_buy');
    selectGoods();
    saveSeckill();
    // goBackAndCancel();
    checkDuration();
});