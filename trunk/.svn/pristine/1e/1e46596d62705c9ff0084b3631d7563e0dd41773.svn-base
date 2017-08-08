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
<title>用户注册</title>
<link rel="stylesheet" href="<?php echo base_url("public/member/styles/global.css");?>"/>
<link rel="stylesheet" href="<?php echo base_url("public/member/junting/styles/junting.css");?>"/>

<script src="<?php echo base_url("public/member/scripts/jquery.js");?>"></script>
<script src="<?php echo base_url("public/member/scripts/ui_control.js");?>"></script>
<script src="<?php echo base_url("public/member/scripts/$.MsgBox.Alert.js");?>"></script>
</head>
<body>
<script>
wx.config({
    debug:false,
    appId:'<?php echo $signpackage["appId"];?>',
    timestamp:<?php echo $signpackage["timestamp"];?>,
    nonceStr:'<?php echo $signpackage["nonceStr"];?>',
    signature:'<?php echo $signpackage["signature"];?>',
    jsApiList: [
        'hideOptionMenu'
     ]
   });
   wx.ready(function () {
	   wx.hideOptionMenu();
   });
</script>
<?php if($this->uri->segment(3) != 'owners'):?>
<form id="pinfo" action="<?php echo site_url("member/account/registersave");?>" method="post">
<?php else:?>
<form id="pinfo" action="<?php echo site_url("member/account/registerowner");?>" method="post">
<?php endif;?>

<div class="list_style_1 bd_bottom">
    <?php if(isset($fields['name']) && ($fields['name']['must']==1)) {?>
	<div class="input_item">
    	<div><?php echo $fields['name']['name'];?></div>
    	<div><input name="name" type="text" placeholder="请输入<?php echo $fields['name']['name'];?>" value="<?php if(isset($member)) echo $member->name;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['sex']) && ($fields['sex']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['sex']['name'];?></div>
    	<select name="sex"　style="width:100%;border: 1px solid #fd4;">
    	    <option value="1" <?php if(isset($member) && ($member->sex==1)) echo "selected";?>>男</option>
    	    <option value="2" <?php if(isset($member) && ($member->sex==2)) echo "selected";?>>女</option>
    	</select>
    </div>
    <?php } ?>
    <?php if(isset($fields['identity_card']) && ($fields['identity_card']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['identity_card']['name'];?></div>
    	<div><input name="identity_card" type="text" placeholder="请输入<?php echo $fields['identity_card']['name'];?>" value="<?php if(isset($member)) echo $member->identity_card;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['dob']) && ($fields['dob']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['dob']['name'];?></div>
    	<div><input name="dob" type="text" placeholder="请输入<?php echo $fields['dob']['name'];?>" value="<?php if(isset($member) && !empty($member->dob)) echo $member->dob;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['qq']) && ($fields['qq']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['qq']['name'];?></div>
    	<div><input name="qq" type="text" placeholder="请输入<?php echo $fields['qq']['name'];?>" value="<?php if(isset($member)) echo $member->qq;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['email']) && ($fields['email']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['email']['name'];?></div>
    	<div><input name="email" type="text" placeholder="请输入<?php echo $fields['email']['name'];?>" value="<?php if(isset($member)) echo $member->email;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['address']) && ($fields['address']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['address']['name'];?></div>
    	<div><input name="address" type="text" placeholder="请输入<?php echo $fields['address']['name'];?>" value="<?php if(isset($member)) echo $member->address;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['password']) && ($fields['password']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['password']['name'];?></div>
    	<div><input name="password" type="text" placeholder="请输入<?php if($inter_id=='a421641095'){echo '6位数字密码';}else{ echo $fields['password']['name'];}?>" value="<?php if(isset($member)) echo $member->password;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['custom1']) && ($fields['custom1']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['custom1']['name'];?></div>
    	<div><input name="custom1" type="text" placeholder="请输入<?php echo $fields['custom1']['name'];?>" value="<?php if(isset($member)) echo $member->custom1;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['custom2']) && ($fields['custom2']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['custom2']['name'];?></div>
    	<div><input name="custom2" type="text" placeholder="请输入<?php echo $fields['custom2']['name'];?>" value="<?php if(isset($member)) echo $member->custom2;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['custom3']) && ($fields['custom3']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['custom3']['name'];?></div>
    	<div><input name="custom3" type="text" placeholder="请输入<?php echo $fields['custom3']['name'];?>" value="<?php if(isset($member)) echo $member->custom3;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['custom3']) && ($fields['custom3']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['custom3']['name'];?></div>
    	<div><input name="custom3" type="text" placeholder="请输入<?php echo $fields['custom3']['name'];?>" value="<?php if(isset($member)) echo $member->custom3;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['custom4']) && ($fields['custom4']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['custom4']['name'];?></div>
    	<div><input name="custom4" type="text" placeholder="请输入<?php echo $fields['custom4']['name'];?>" value="<?php if(isset($member)) echo $member->custom4;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['custom5']) && ($fields['custom5']['must']==1)) {?>
    <div class="input_item">
    	<div><?php echo $fields['custom5']['name'];?></div>
    	<div><input name="custom5" type="text" placeholder="请输入<?php echo $fields['custom5']['name'];?>" value="<?php if(isset($member)) echo $member->custom5;?>"></div>
    </div>
    <?php } ?>
    <?php if(isset($fields['telephone']) && ($fields['telephone']['must']==1)) {?>
    <div class="input_item">
        <div><?php echo $fields['telephone']['name'];?></div>
        <div><input name="telephone" type="tel" placeholder="请输入<?php echo $fields['telephone']['name'];?>" value="<?php if(isset($member) && !empty($member->telephone)) echo $member->telephone;?>"></div>
    </div>
	<div class="input_item justify">
    	<div>验证码</div>
        <div><input placeholder="请输入验证码" type="tel" name="sms"></div>
        <div><span class="btn_main xs bdradius h22" id="sms">获取验证码</span></div>
    </div>
    <?php } ?>
</div>

<div class="pad3" style="margin-top:25px">
	<button id="sub" type="button" class="bg_main pad12 bdradius" style="width:100%">注册</button>
</div>
</form>
<script>
var inter_id = '<?php echo $inter_id;?>';
$(document).ready(function(){
	$("#sms").click(function() {
        if($("input[name='telephone']").val().length==0) {
            $.MsgBox.Alert("请输入手机号码!");
            return false;
        }
        if($("input[name='telephone']").val().length!=11) {
           $.MsgBox.Alert("手机号码必须为11位!");
           return false;
       }
      var _obj=this;
       <?php if($inter_id=='a421641095'){ ?>
        var smspic = $("input[name='smspic']").val();
        if(smspic.length==0) {
           $.MsgBox.Alert("请输入图片验证码!");
           return false;
        }
       $.get("<?php echo site_url("member/center/smspicvalid");?>", {smspic:smspic},
           function(data) {
              data   = parseInt(data);
              if(!data) {
                $.MsgBox.Alert("验证码不正确!");
                return false;
              }else{
                <?php } ?>
                var getstr= "";
                <?php if(isset($fields['name']) && ($fields['name']['must']==1)) {?>
                  getstr += 'name=';
                  getstr += $("input[name='name']").val();
                  getstr +='&';
                <?php } ?>
                <?php if(isset($fields['telephone']) && ($fields['telephone']['must']==1)) {?>
                  getstr += 'telephone=';
                getstr += $("input[name='telephone']").val();
                getstr +='&';
              <?php } ?>
              <?php if(isset($fields['sms']) && ($fields['sms']['must']==1)) {?>
              getstr += 'sms=';
              getstr += $("input[name='sms']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['identity_card']) && ($fields['identity_card']['must']==1)) {?>
              getstr += 'identity_card=';
              getstr += $("input[name='identity_card']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['sex']) && ($fields['sex']['must']==1)) {?>
              getstr += 'sex=';
              getstr += $("select[name='sex']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['dob']) && ($fields['dob']['must']==1)) {?>
              getstr += 'dob=';
              getstr += $("input[name='dob']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['qq']) && ($fields['qq']['must']==1)) {?>
              getstr += 'qq=';
              getstr += $("input[name='qq']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['email']) && ($fields['email']['must']==1)) {?>
              getstr += 'email=';
              getstr += $("input[name='email']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['address']) && ($fields['address']['must']==1)) {?>
              getstr += 'address=';
              getstr += $("input[name='address']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['password']) && ($fields['password']['must']==1)) {?>
              getstr += 'password=';
              getstr += $("input[name='password']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['custom1']) && ($fields['custom1']['must']==1)) {?>
              getstr += 'custom1=';
              getstr += $("input[name='custom1']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['custom2']) && ($fields['custom2']['must']==1)) {?>
              getstr += 'custom2=';
              getstr += $("input[name='custom2']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['custom3']) && ($fields['custom3']['must']==1)) {?>
              getstr += 'custom3=';
              getstr += $("input[name='custom3']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['custom4']) && ($fields['custom4']['must']==1)) {?>
              getstr += 'custom4=';
              getstr += $("input[name='custom4']").val();
              getstr +='&';
              <?php } ?>
              <?php if(isset($fields['custom5']) && ($fields['custom5']['must']==1)) {?>
              getstr += 'custom5=';
              getstr += $("input[name='custom5']").val();
              <?php } ?>

                var site_url="<?php echo site_url('member/center/sendsmsother');?>";
                if(inter_id=='a421641095') site_url="<?php echo site_url('member/center/sendbgysms');?>";
              $.ajax({
                   type: "GET",
                   url: site_url,
                   data: getstr,
                   success: function(data){
                       time_down(_obj); //提交发送,进入倒计时
                       var dataObj = eval("(" + data + ")"); //转换为JSON对象
                       if(dataObj.data=='ok'){
                           $.MsgBox.Alert('发送成功')
                           $(this).attr('disabled',"true");
                           $(this).addClass("ui_disable_btn");
                       }else{
                           $.MsgBox.Alert('发送失败')
                       }
                   }
                });
              }
       });
		return false;
	});

   $("#sub").click(function(){
	   <?php if(isset($fields['name']) && ($fields['name']['must']==1)) {?>
       if($("input[name='name']").val().length==0) {
           $.MsgBox.Alert("请填写姓名!");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['telephone']) && ($fields['telephone']['must']==1)) {?>
       if($("input[name='telephone']").val().length==0) {
           $.MsgBox.Alert("请输入手机号码!");
           return false;
       }

       if($("input[name='telephone']").val().length!=11) {
           $.MsgBox.Alert("手机号码必须为11位!");
           return false;
       }
       <?php if($inter_id=='a421641095'){ ?>
        if($("input[name='smspic']").val().length==0) {
           $.MsgBox.Alert("请输入图片验证码!");
           return false;
       }
       <?php } ?>
       if($("input[name='sms']").val().length==0) {
           $.MsgBox.Alert("请输入短信验证码!");
           return false;
       }


       <?php } ?>
       <?php if(isset($fields['identity_card']) && ($fields['identity_card']['must']==1)) {?>
       if($("input[name='identity_card']").val().length==0) {
           $.MsgBox.Alert("请输入身份证号!");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['dob']) && ($fields['dob']['must']==1)) {?>
       if($("input[name='dob']").val().length==0) {
           $.MsgBox.Alert("请输入<?php echo $fields['dob']['name'];?>");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['qq']) && ($fields['qq']['must']==1)) {?>
       if($("input[name='qq']").val().length==0) {
           $.MsgBox.Alert("请输入<?php echo $fields['qq']['name'];?>");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['email']) && ($fields['email']['must']==1)) {?>
       if($("input[name='email']").val().length==0) {
           $.MsgBox.Alert("请输入<?php echo $fields['email']['name'];?>");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['address']) && ($fields['address']['must']==1)) {?>
       if($("input[name='address']").val().length==0) {
           $.MsgBox.Alert("请输入<?php echo $fields['address']['name'];?>");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['password']) && ($fields['password']['must']==1)) {?>
       if($("input[name='password']").val().length==0) {
           $.MsgBox.Alert("请输入<?php echo $fields['password']['name'];?>");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['password']) && ($fields['password']['must']==1 && $inter_id=='a421641095')) {?>
       if($("input[name='password']").val().length != 6) {
           $.MsgBox.Alert("请输入6位密码");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['custom1']) && ($fields['custom1']['must']==1)) {?>
       if($("input[name='custom1']").val().length==0) {
           $.MsgBox.Alert("请输入<?php echo $fields['custom1']['name'];?>");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['custom2']) && ($fields['custom2']['must']==1)) {?>
       if($("input[name='custom2']").val().length==0) {
           $.MsgBox.Alert("请输入<?php echo $fields['custom2']['name'];?>");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['custom3']) && ($fields['custom3']['must']==1)) {?>
       if($("input[name='custom3']").val().length==0) {
           $.MsgBox.Alert("请输入<?php echo $fields['custom3']['name'];?>");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['custom4']) && ($fields['custom4']['must']==1)) {?>
       if($("input[name='custom4']").val().length==0) {
           $.MsgBox.Alert("请输入<?php echo $fields['custom4']['name'];?>");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['custom5']) && ($fields['custom5']['must']==1)) {?>
       if($("input[name='custom5']").val().length==0) {
           $.MsgBox.Alert("请输入<?php echo $fields['custom5']['name'];?>");
           return false;
       }
       <?php } ?>
       <?php if(isset($fields['telephone']) && ($fields['telephone']['must']==1)) {?>

       var sms = $("input[name='sms']").val();
       $.get("<?php echo site_url("member/center/smsvalid");?>", {sms:sms},
           function(data) {
              data   = parseInt(data);
              if(data) {
                  $("#pinfo").submit();
              } else {
                  $.MsgBox.Alert("验证码不正确!");
              }
       });

       <?php } else { ?>
       $("#pinfo").submit();
       <?php } ?>
   });

    $("#member").click(function() {
        $("#ccname").html("所属公司");
        $("#pnum").html("员工号");
    })

    $("#owners").click(function() {
        $("#ccname").html("物业中心");
        $("#pnum").html("物业证号");
    })
});

var wait=60;
function time_down(o) {
    if (wait == 0) {
        o.removeAttribute("disabled");
        $(o).find('span').html("发送验证码");
        wait = 60;
    } else {
        o.setAttribute("disabled", true);
        $(o).find('span').html("重新发送(" + wait + ")");
        wait--;
        setTimeout(function() {
            time_down(o);
        },1000);
    }
}
</script>
<div id="show_message" style="display:none"><?php if(isset($message)) echo $message;?></div>
<script>
$(document).ready(function(){
	if($("#show_message").html().length) {
		$.MsgBox.Alert($("#show_message").html());
	}
})
</script>
</body>
</html>
