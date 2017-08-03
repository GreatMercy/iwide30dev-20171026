<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="format-detection" content="telephone=no,email=no">
    <meta name="ML-Config" content="fullscreen=yes,preventMove=no">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=320,initial-scale=1,user-scalable=0">
    <link href="<?php echo base_url("public/member/phase2/styles/global.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("public/member/phase2/styles/mycss.css"); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/weui/dist/style/weui.css");?>"/>
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/weui/dist/style/weui.min.css");?>"/>
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/weui/dist/example/example.css");?>"/>
    <link rel="stylesheet" href="<?php echo base_url("public/member/version4.0/css/alert.css");?>"/>
    <script src="<?php echo base_url("public/member/phase2/scripts/jquery.js"); ?>"></script>
    <script src="<?php echo base_url("public/member/phase2/scripts/ui_control.js"); ?>"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="<?php echo base_url("public/member/version4.0/js/login.js");?>"></script>
    <script type="text/javascript" src="<?php echo base_url("public/member/version4.0/js/alert.js");?>"></script>
    <script src="<?php echo base_url(FD_PUBLIC)?>/js/ajaxForm.js"></script>
    <script src="<?php echo base_url("public/member/version4.0/weui/dist/example/zepto.min.js");?>"></script>
    <script src="<?php echo base_url("public/member/version4.0/weui/dist/example/example.js");?>"></script>
    <title>绑定登录</title>
</head>
<body>
<form id="loginSave" action="<?php echo base_url("index.php/membervip/login/savelogin"); ?>" method="post">
    <input type="hidden" name="smstype" value="2"/>
    <div class="list_style bd_bottom">
        <?php if ($login_config['account']['show']) { ?>
            <div class="input_item account">
                <div><label for='' class="weui_label"><?php echo $login_config['account']['name']; ?></label></div>
                <div>
                    <input type="<?php echo $login_config['account']['type']; ?>" name="account"
                           pattern="<?php echo $login_config['account']['regular']; ?>"
                           placeholder="<?php echo $login_config['account']['note']; ?>"/>
                </div>
            </div>
        <?php } ?>
        <?php if ($login_config['phone']['show']) { ?>
            <div class="input_item phone">
                <div><?php echo $login_config['phone']['name']; ?></label></div>
                <div>
                    <input type="<?php echo $login_config['phone']['type']; ?>" name="phone"
                           pattern="<?php echo $login_config['phone']['regular']; ?>"
                           placeholder="<?php echo $login_config['phone']['note']; ?>"/>
                </div>
            </div>
        <?php } ?>
        <?php if ($login_config['password']['show']) { ?>
            <div class="input_item password">
                <div><label for='' class="weui_label"><?php echo $login_config['password']['name']; ?></label></div>
                <div>
                    <input type="<?php echo $login_config['password']['type']; ?>"
                           pattern="<?php echo $login_config['password']['regular']; ?>"
                           placeholder="<?php echo $login_config['password']['note']; ?>" name="password"/>
                </div>
            </div>
        <?php } ?>
        <?php if ($login_config['phonesms']['show']) { ?>
            <div class="input_item phonesms">
                <div><label class="weui_label">验证码</label></div>
                <div>
                    <input type="<?php echo $login_config['phonesms']['type']; ?>"
                           pattern="<?php echo $login_config['phonesms']['regular']; ?>"
                           placeholder="<?php echo $login_config['phonesms']['note']; ?>" name="phonesms"/>
                </div>
                <div>
                    <a href="javascript:;" data-val='0' style="width:auto;" class="h20 smsSend">获取验证码</a>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="sign_btn bg_main">登录</div>
    </div>
</form>
<script type="text/javascript">
    //通用JS
    $(function () {
        /* 等待加载 START */
        $('.vip_content').attr('style', "");
        $("#loadingToast").attr('style', "display:none;");
        /* 等待加载 END */
        var postUrl;
        /*60S等待发送短信 START*/
        //发送短息
        var countdown = 60;
        $('.smsSend').click(function () {
            var timestr = $('.smsSend').attr('data-val');
            if (timestr == 0) {
                var tel = $("input[name='phone']").val(), phonesms = $("input[name='phonesms']").val(), smstype = $("input[name='smstype']").val();
                var regular = new RegExp($("input[name='phone']").attr('pattern'));
                if (!tel || tel == '') {
                    new AlertBox({content: '请输入手机号码', type: 'tip', site: 'bottom'}).show();
                    return false;
                } else if (!regular.test(tel)) {
                    new AlertBox({content: '请输入正确的手机号码', type: 'tip', site: 'bottom'}).show();
                    return false;
                }
                //请求发送验证码
                var postUrl = "<?php echo base_url("index.php/membervip/sendsms");?>";
                var datas = {phone: tel, phonesms: phonesms, smstype: smstype};
                $.ajax({
                    url: postUrl,
                    type: 'POST',
                    data: datas,
                    dataType: 'json',
                    timeout: 6000,
                    success: function (result) {
                        if (result.err == '0') {
                            new AlertBox({content: '短信已发送,请注意查收!', type: 'tip', site: 'bottom'}).show();
                        }
                    },
                    error: function () {
                        new AlertBox({content: '发送失败,请刷新重试或联系管理员!', type: 'tip', site: 'bottom'}).show();
                        return false;
                    }
                });
                Timeing();
            } else {
                new AlertBox({content: '请在' + countdown + '秒后点击获取', type: 'tip', site: 'mid'}).show();
            }
            $('.smsSend').attr('data-val', 1);
        });
        function Timeing() {
            if (countdown == 0) {
                $('.smsSend').html('获取验证码');
                countdown = 60;
                $('.smsSend').attr('data-val', 0);
            } else {
                $('.smsSend').html("重新获取" + countdown + "S");
                countdown--;
                setTimeout(function () {
                    Timeing();
                }, 1000)
            }
        }

        /*60S等待发送短信 END*/

        /* 检测用户输入的是否合法 START */
        $("input").keyup(function () {
            var regular = new RegExp($(this).attr('pattern'));
            var inputValue = $(this).val();
            var inputName = $(this).attr('name');
            if (!regular.test(inputValue)) {
                $("." + inputName + "").addClass('input_item_warn');
                $(".sign_btn").addClass('weui_btn_disabled');
            } else {
                $("." + inputName + "").removeClass('input_item_warn');
                $(".sign_btn").removeClass('weui_btn_disabled');
            }
        });

        //失去焦点判断
        $("input").focusout(function () {
            var regular = new RegExp($(this).attr('pattern'));
            var inputValue = $(this).val();
            var inputName = $(this).attr('name');
            if (!regular.test(inputValue)) {
                $("." + inputName + "").addClass('input_item_warn');
                $(".sign_btn").addClass('weui_btn_disabled');
            } else {
                $("." + inputName + "").removeClass('input_item_warn');
                $(".sign_btn").removeClass('weui_btn_disabled');
            }
        });
        /* 检测用户输入的是否合法 END */
        //提交JS
        /* 提交信息 START */
        $('.sign_btn').click(function () {
            var form = $("#loginSave"), form_url = form.attr("action"), btn = $(this), loadtip = null;
            postUrl = form.attr("action");
            form.ajaxSubmit({
                url: form_url,
                dataType: 'json',
                timeout: 20000,
//                    clearForm:true,
//                    resetForm:true,
                beforeSubmit: function (arr, $form, options) {
                    /*验证提交数据*/
                    var _null = false, _msg = '', inputobj = false;
                    for (i in arr) {
                        var name = arr[i].name, value = $.trim(arr[i].value);
                        if (name == 'account' && !value) {
                            _null = true;
                            _msg = '请输入登录帐号或邮箱!';
                            inputobj = $("input[name='" + name + "']");
                            break;
                        }

                        if (name == 'phone' && !value) {
                            _null = true;
                            _msg = '请输入手机号码!';
                            inputobj = $("input[name='" + name + "']");
                            break;
                        }

                        if (name == 'password' && !value) {
                            _null = true;
                            _msg = '请输入密码!';
                            inputobj = $("input[name='" + name + "']");
                            break;
                        }

                        if (name == 'phonesms' && !value) {
                            _null = true;
                            _msg = '请输入手机验证码!';
                            inputobj = $("input[name='" + name + "']");
                            break;
                        }
                    }

                    if (_null === true) {
                        new AlertBox({content: _msg, type: 'tip', site: 'bottom', time: 2000}).show();
                        $(inputobj).focus();
                        return false;
                    }
                    /*end*/

                    var text = btn.text();
                    btn.prop('disabled', true).addClass('weui_btn_disabled').text(text + '中...');
                    loadtip = new AlertBox({content: '登录中', type: 'loading', site: 'topmid'}).show();
                },
                success: function (result) {
                    if (loadtip) loadtip.closedLoading();
                    var text = btn.text();
                    btn.prop('disabled', false).removeClass('weui_btn_disabled').text(text.replace('中...', ''));
                    if (result.err > 1) {
                        new AlertBox({content: result.msg, type: 'info', site: 'topmid'}).show();
                    } else if (result.err == '0') {
                        <?php if(isset($_GET['redir']) && !empty($_GET['redir'])){ ?>
                        var locat_url = "<?php echo urldecode($_GET['redir']);?>";
                        <?php }else{?>
                        var locat_url = "<?php echo base_url('index.php/membervip/center');?>";
                        <?php } ?>
                        new AlertBox({
                            content: result.msg,
                            type: 'tip',
                            site: 'bottom',
                            dourl: locat_url,
                            time: 100
                        }).show();
                    }
                },
                error: function () {
                    if (loadtip) loadtip.closedLoading();
                    var text = btn.text();
                    btn.prop('disabled', false).removeClass('weui_btn_disabled').text(text.replace('中...', ''));
                    new AlertBox({content: '网络异常,请求失败,请刷新重试或联系管理员!', type: 'tip', site: 'bottom'}).show();
                    return false;
                }
            });
        });
        /* 提交信息 END */
    });

</script>
</body>
</html>