
<?php echo referurl('css','receipt.css',2,$media_path) ?>
<div class="statustep webkitbox center">
	<div>
    	<span class="bg_main active h24">1</span>
        <p class="h22 color_main">填写信息</span>
    </div>
    <div>
    	<span class="bg_999 h24">2</span><hr>
        <p class="h22">开具发票</span>
    </div>
    <div>
    	<span class="bg_999 h24">3</span><hr>
        <p class="h22">预约完成</p>
    </div>
</div>
<form action="step2.html">
<div class="bg_E4E4E4 h20" style="padding:4px 8px">填写退房信息</div>
<div class="list_style bd_bottom add_new_list">
	<div class="input_item webkitbox">
    	<div>所住房号</div>
        <div><input type="text" required placeholder="请输入入住房间号" tips="输入入住房间号" ></div>
    </div>
	<div class="input_item webkitbox arrow">
    	<div>退房时间</div>
        <div><select>
        	<option>2016.12.11  14:00:00</option>
        	<option>2016.12.11  15:00:00</option>
        </select></div>
    </div>
</div>
<div class="pad3" style="margin-top:10px">
	<button class="btn_main h32 submitbtn color_fff disable" type="button" id="_submit">下一步</button>
</div>
</form>

<script>
function testval(){
	$('form input').each(function(index, element) {
        if($(this).val()==''){
			$.MsgBox.Alert( '你还没有'+$(this).attr('tips'));
			$('#_submit').removeClass('disable').addClass('disable');
		}
    });
}
function button_change(){
	for ( var i=0;i<$('input','form').length;i++){
		if ( $('input','form').eq(i).val()=='')return;
	}
	$('#_submit').removeClass('disable');
}
$('#_submit').click(function(){
	testval();
	if($(this).hasClass('disable')){
		testval();
		return;
	}
	$('form').submit();
});
$('input').change(button_change);

</script>
</body>
</html>
