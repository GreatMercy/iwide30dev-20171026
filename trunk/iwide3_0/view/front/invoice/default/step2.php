<?php require_once('header.php');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/hotel/public/styles/receipt.css');?>">
<div class="statustep webkitbox center">
	<div>
    	<span class="bg_main h24">1</span>
        <p class="h22 color_main">填写信息</span>
    </div>
    <div>
    	<span class="bg_main active h24">2</span><hr>
        <p class="h22 color_main">开具发票</span>
    </div>
    <div>
    	<span class="bg_999 h24">3</span><hr>
        <p class="h22">预约完成</p>
    </div>
</div>
<form action="submit_status.html">
<input name="status" type="hidden"  placeholder="" tips="" id="status" value='0'>
<div class="bg_E4E4E4 h20" style="padding:4px 8px">发票</div>
<div class="list_style bd_bottom add_new_list">
	<div class="input_item webkitbox arrow">
    	<div>是否需要发票</div>
<!--        <div><select class="h28"  id="isneed">-->
<!--            --><?php //if(isset($hotel['invoice']) && $hotel['invoice']==1){ ?>
<!--                <option value="0">不需要</option>-->
<!--            --><?php //}else{ if(isset($invoice['invoice_content'])){ ?>
<!--                <option value="1">需要</option>-->
<!--            --><?php //}else{ ?><!--}-->
<!--                <option value="1">需要</option>-->
<!--                <option value="0">不需要</option>-->
<!--            --><?php //}} ?>
<!--            </select>-->
<!--        </div>-->
        <div><select class="h28"  id="isneed">
                    <option value="1">需要</option>
                    <option value="0">不需要</option>
            </select>
        </div>
    </div>
	<div class="input_item webkitbox arrow is_need" style="display:none">
    	<div>发票类型</div>
<!--        <div>-->
<!--        --><?php //if(isset($invoice['invoice_content']->type)){ ?>
<!--            <select class="h28" id="receipt" >-->
<!--                --><?php //if($invoice['invoice_content']->type==1){ ?>
<!--        	        <option value="1">普通发票</option>-->
<!--                --><?php //}else{ ?>
<!--        	        <option value="2">增值税发票</option>-->
<!--                --><?php //}?>
<!--            </select>-->
<!--        --><?php //}else{  ?>
<!--            <select class="h28" id="receipt" >-->
<!--                <option value="1">普通发票</option>-->
<!--                <option value="2">增值税发票</option>-->
<!--            </select>-->
<!--        --><?php //}  ?>
<!--        </div>-->
        <div>
                <select class="h28" id="receipt" >
                    <?php if($this->inter_id !='a492669988'){ ?>
                        <option value="1">普通发票</option>
                    <?php }?>
                    <option value="2">增值税发票</option>
                </select>
        </div>
    </div>
    <div class="input_item webkitbox is_need" style="display:none">
    	<div>发票抬头</div>
        <div><input id="title" type="text"  tips="输入发票抬头" <?php if(isset($invoice['invoice_content']->title)){echo ' '.'value='."{$invoice['invoice_content']->title}";}else{ echo 'placeholder="请输入发票抬头"';}?> ></div>
    </div>
    <?php if(isset($order)){ ?>
        <div class="input_item webkitbox is_need">
            <div>发票金额</div>
                <div><input style="width:25%;" id="amount" type="tel"  value="<?php echo $order['price'];?>" disabled ><span style="font-size:8px;width:75%;margin-left:5%;color: #C0C0C0">具体以实际开票金额为准</span></div>
        </div>
    <?php }else{ ?>
        <input id="amount" type="hidden"  value="0" tips="输入开票金额" >
    <?php } ?>
    <div class="input_item webkitbox is_need" >
        <div>纳税人识别号</div>
        <div><input id="code" maxlength="20" onkeyup="checkcode()" oninput="value=value.replace(/[^\w\.\/]/ig,'')" type="text" <?php if(isset($invoice['invoice_content']->code)){echo ' '.'value='."{$invoice['invoice_content']->code}";}else{ echo 'placeholder="请输入纳税人识别号"';}?> tips="输入纳税人识别号" ></div>
    </div>
    <div class="input_item webkitbox is_need" >
        <div>备注</div>
        <div><textarea id="remark" oninput="value=value.replace(/[/]/i,'')" type="text"  tips="输入备注信息"  value=""></textarea></div>
    </div>
</div>
<div class="martop"  style="display:none" id="type2">
    <div class="bg_E4E4E4 h20" style="padding:4px 8px">发票信息</div>
    <div class="list_style bd_bottom add_new_list">
<!--        <div class="input_item webkitbox">-->
<!--            <div>纳税人识别号</div>-->
<!--            <div><input id="code" type="text" --><?php //if(isset($invoice['invoice_content']->code)){echo ' '.'value='."{$invoice['invoice_content']->code}";}else{ echo 'placeholder="请输入纳税人识别号"';}?><!-- tips="输入纳税人识别号" ></div>-->
<!--        </div>-->
        <div class="input_item webkitbox">
            <div>注册地址</div>
            <div><input id="address" type="text" <?php if(isset($invoice['invoice_content']->address)){echo ' '.'value='."{$invoice['invoice_content']->address}";}else{ echo 'placeholder="请输入注册地址"';}?> tips="输入注册地址" ></div>
        </div>
        <div class="input_item webkitbox">
            <div>公司电话</div>
            <div><input id="phonecall" type="tel" <?php if(isset($invoice['invoice_content']->phonecall)){echo ' '.'value='."{$invoice['invoice_content']->phonecall}";}else{ echo 'placeholder="请输入公司电话"';}?> tips="输入公司电话" ></div>
        </div>
        <div class="input_item webkitbox">
            <div>开户银行</div>
            <div><input id="bank" type="text" <?php if(isset($invoice['invoice_content']->bank)){echo ' '.'value='."{$invoice['invoice_content']->bank}";}else{ echo 'placeholder="请输入开户银行"';}?> tips="输入开户银行" ></div>
        </div>
        <div class="input_item webkitbox">
            <div>银行账号</div>
            <div><input id="account" type="tel"  <?php if(isset($invoice['invoice_content']->account)){echo ' '.'value='."{$invoice['invoice_content']->account}";}else{ echo 'placeholder="请输入银行账号"';}?> tips="输入银行账号" ></div>
        </div>
    </div>
</div>
<div class="pad3" style="margin-top:10px">
	<button class="btn_main h32 submitbtn color_fff" type="button" id="_submit">提交预约</button>
</div>
</form>

<script>

function checkcode(){
    var code_text = $("#code").val();
    if(code_text.length > 20){
        code_text=code_text.slice(0,20);
    }
    $("#code").val(code_text);
}

function testval(isalert){
        var _this = $('input','form');
		if(isalert==undefined)isalert=false;
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

    pageloading();

    if( $('#status').val()==0){

        if($('#receipt').val()!=0){
            testval(true);
            if($(this).hasClass('disable')){
                removeload();
                return;
            }
        }

        $('#status').val(1);

        var postUrl = "<?php echo site_url('hotel/invoice/checkout_post');?>";

        $.ajax({

            type: 'POST',
            dataType : 'json',
            url: postUrl,

            data: {
                isneed:$('#isneed').val(),
                receipt:$('#receipt').val(),
                title:$('#title').val(),
                code:$('#code').val(),
                bank:$('#bank').val(),
                account:$('#account').val(),
                amount:$('#amount').val(),
                phonecall:$('#phonecall').val(),
                address:$('#address').val(),
                remark:$('#remark').val(),
                room_nums:'<?php echo $room_nums;?>',
                oid:<?php echo $oid;?>,
                hid:<?php echo $hid;?>,
                checkout_time:'<?php echo $checkout_time;?>',
                name:'<?php echo $name;?>',
                tel:'<?php echo $tel;?>',
                invoice_list_id:'<?php if(isset($invoice['invoice_list_id'])){echo$invoice['invoice_list_id'];}else{ echo 0;} ?>',
                '<?php echo $csrf_token; ?>':'<?php echo $csrf_value; ?>'
            },

            success: function(data){
                if(data.code==1){
                    $('#status').val(0);
                }else if(data.code==2){
                    removeload();
                    if(data.need==0){
                        location.href='<?php echo site_url('hotel/invoice/submit_result?type=1');?>';
                    }else{
                        location.href='<?php echo site_url('hotel/invoice/submit_result');?>';
                    }
                }
            }
        })

    }else if( $('#status').val()==1){
        alert('已经提交过了');
    }

//	$('form').submit();
});
$('#receipt').change(showneed);
$('#isneed').change(showneed);
$('input').change(function(){testval(false)});
 showneed();
</script>
</body>
</html>