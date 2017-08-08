
<?php echo referurl('css','receipt.css',2,$media_path) ?>
<form action="">
<div class="list_style martop bd_bottom add_new_list">
	<div class="input_item webkitbox arrow" >
    	<div>发票类型</div>
        <div><select id="receipt">
        	<option value="1">普通发票</option>
        	<option value="2">增值税发票</option>
        </select></div>
    </div>
    <div class="input_item webkitbox is_need" style="display:none">
    	<div>发票抬头</div>
        <div><input type="text"  placeholder="请输入发票抬头" tips="输入发票抬头" ></div>
    </div>
</div>
<div class="martop"  style="display:none" id="type2">
    <div class="list_style bd_bottom add_new_list">
        <div class="input_item webkitbox">
            <div>纳税人识别号</div>
            <div><input type="text" placeholder="请输入纳税人识别号" tips="输入纳税人识别号" ></div>
        </div>
        <div class="input_item webkitbox">
            <div>注册地址</div>
            <div><input type="text" placeholder="请输入注册地址" tips="输入注册地址" ></div>
        </div>
        <div class="input_item webkitbox">
            <div>公司电话</div>
            <div><input type="tel" placeholder="请输入公司电话" tips="输入公司电话" ></div>
        </div>
        <div class="input_item webkitbox">
            <div>开户银行</div>
            <div><input type="text" placeholder="请输入开户银行" tips="输入开户银行" ></div>
        </div>
        <div class="input_item webkitbox">
            <div>银行账号</div>
            <div><input type="tel" placeholder="请输入银行账号" tips="输入银行账号" ></div>
        </div>
        <div class="input_item webkitbox">
            <div>开票金额</div>
            <div><input type="tel" placeholder="请输入开票金额" tips="输入开票金额" ></div>
        </div>
    </div>
</div>
<div class="pad3" style="margin-top:10px">
	<button class="btn_main h32 submitbtn color_fff" type="button" id="_submit">保存信息</button>
</div>
</form>

<script>
function testval(isalert){
	var _this = $('input','form');
	for ( var i=0;i<_this.length;i++){
		if ( _this.eq(i).val()=='' && !_this.eq(i).is(':hidden')){
			if(isalert)$.MsgBox.Alert( '你还没有'+_this.eq(i).attr('tips'));
			$('#_submit').addClass('disable');
			return;
		}
	}
	$('#_submit').removeClass('disable');
}
function showneed(){
	if($('#isneed').val()!=0){
		$('.is_need').show();
		if($('#receipt').val()==2) $('#type2').show();
		else $('#type2').hide();
	}else{
		$('.is_need').hide();
		$('#type2').hide();
	}
	testval(false);
}
$('#_submit').click(function(){
	if($('#receipt').val()!=0){
		testval(true);
		if($(this).hasClass('disable'))	return;
	}
	$('form').submit();
});
$('#receipt').change(showneed);
$('#isneed').change(showneed);
 showneed();
</script>
</body>
</html>
