<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1, shrink-to-fit=no">
<meta name="format-detection" content="telephone=no">
<title><?php echo $credit_name?>兑换<?php echo $balance_name?></title>
<style>
html {
	font-size: 12px;
	font-family: PingFang SC Light, 微软雅黑;
}

.w100 {
	width: 100%
}

.absolute {
	position: absolute;
}

body {
	width: 100%;
	height: 100%;
	position: absolute;
	margin: 0;
	font-size: 1rem;
	overflow: hidden;
}

.right {
	float: right
}

.full {
	width: 100%;
	height: 100%
}

.fixed {
	position: fixed
}

.none {
	display: none
}

.relative {
	position: relative
}

ib {
	display: inline-block;
	vertical-align: middle;
	word-break: break-all;
}

flex {
	display: flex;
	align-items: center;
	flex-wrap: wrap;
}

.center {
	text-align: center;
}

[around] {
	justify-content: space-around;
}

[between] {
	justify-content: space-between;
}

[nowrap] {
	flex-wrap: nowrap;
}

.main {
	margin: 0px 1.25rem;
}

.fen {
	color: #ff9900;
	font-size: 1.33rem;
	margin-left: 0.83rem;
}

.score {
	margin-top: 2.92rem;
	border-top: 1px solid #f0f0f0;
	border-bottom: 1px solid #f0f0f0;
	padding: 1.5rem 2.25rem;
}

.parts {
	width: 50%;
	text-align: center;
	display: inline-flex;
	align-items: center;
	flex-wrap: wrap;
	justify-content: center;
	height: 9.2rem;
	color: #808080;
}

.parts input {
	font-size: 1.75rem;
	background-color: transparent;
	border: 0px;
	margin: 0px;
	padding: 0px;
	outline: none;
	text-align: center;
}

:-moz-placeholder {
	font-size: 0.92rem;
}

::-moz-placeholder {
	font-size: 0.92rem;
}

input:-ms-input-placeholder {
	font-size: 0.92rem;
}

input::-webkit-input-placeholder {
	font-size: 0.92rem;
}

.parts>div>div:nth-child(1) {
	height: 3rem;
	position: relative;
	display: inline-flex;
	align-items: flex-end;
	justify-content: center;
	margin-bottom: 0.82rem;
	width: 100%;
}

.parts>div>div:nth-child(2) {
	height: 3rem;
	position: relative;
	display: inline-flex;
	align-items: flex-start;
	justify-content: center;
}

.chuzhi {
	color: #808080;
}

.change:before {
	content: "";
	position: absolute;
	height: 100%;
	width: 1px;
	background-color: #f0f0f0;
	left: 50%;
}

.duihuan>ib {
	width: 2.5rem;
	height: 2.5rem;
	border-radius: 100%;
	border: 1px solid #eee;
	color: #eee;
	font-size: 1.33rem;
	text-align: center;
	line-height: 2.5rem;
	margin-top: 0.125rem;
}

.duihuan {
	position: absolute;
	width: 3rem;
	height: 3rem;
	left: 50%;
	line-height: 3rem;
	margin-left: -1.5rem;
	background-color: white;
	text-align: center;
}

.change {
	border-bottom: #f0f0f0 1px solid;
}

.shuoming {
	padding: 0.92rem 0px;
	color: #808080;
}

.btn {
	color: white;
	background-color: #ff9900;
	margin-top: 5rem;
	height: 3.75rem;
	line-height: 3.75rem;
	width: 100%;
	border-radius: 5px;
	text-align: center;
	font-size: 1.33rem;
}

.space-num {
	font-size: 1.75rem;
}

.space-num:after {
	content: attr(data-xiaoshu);
	font-size: 1.33rem;
}

.tc {
	position: absolute;
	width: 100%;
	height: 100%;
	background-color: RGBA(0, 0, 0, 0.8);
	top: 0px;
	left: 0px;
}

.tc_body {
	width: 81.25%;
	text-align: center;
	margin: auto;
	background-color: white;
	border-radius: 5px;
}

.tc_body>div {
	padding: 1.25rem 1.75rem;
}

.tc_body>div>div:nth-child(1) {
	font-size: 1.25rem;
}

.tc_body>div>div:nth-child(2) {
	margin-top: 1.08rem;
}

.tc_body>div>div:nth-child(3) {
	margin-top: 0.5rem;
}

.tc_body>div>flex {
	margin-top: 1rem;
}

.tc_body>div>flex>ib {
	width: 8.5rem;
	height: 2.91rem;
	text-align: center;
	line-height: 2.91rem;
	border-radius: 2px;
}

.tc_body>div>flex>ib:nth-child(1) {
	border: 1px #b5b5b5 solid;
	color: #b5b5b5;
	background-color: white;
}

.tc_body>div>flex>ib:nth-child(2) {
	border: 1px transparent solid;
	color: white;
	background-color: #ff9900;
}

@
-webkit-keyframes fadeIn {from { opacity:0;
	
}

to {
	opacity: 1;
}

}
@
keyframes fadeIn {from { opacity:0;
	
}

to {
	opacity: 1;
}

}
.fadeIn {
	-webkit-animation: fadeIn .5S forwards;
	animation: fadeIn .5S forwards;
}

@
-webkit-keyframes fadeOut {from { opacity:1;
	
}

to {
	opacity: 0;
}

}
@
keyframes fadeOut {from { opacity:1;
	
}

to {
	opacity: 0;
}

}
.fadeOut {
	-webkit-animation: fadeOut .5s forwards;
	animation: fadeOut .5s forwards;
}

@media screen and (min-width:375px) {
	html {
		font-size: 14px;
	}
}

@media screen and (min-width:414px) {
	html {
		font-size: 15px;
	}
}
</style>
</head>
<body>
	<div class="w100 relative" style="margin-top: 1.67rem;">
		<img class="w100"
			src="<?php echo base_url("public/member/phase2/images/head.png");?>">
	</div>
	<div class="main">
		<flex between class="score"> <ib> <ib>我的<?php echo $credit_name?></ib> <ib class="fen"><?php echo $member_info['credit']?></ib></ib>
		<ib> <ib class="chuzhi">我的<?php echo $balance_name?></ib> <ib class="fen"><?php echo $member_info['balance']?></ib></ib>
		</flex>
		<flex between class="relative change"> <ib class="parts">
		<div>
			<div class="w100">
				<input type="number" data-max="<?php echo $member_info['credit']?>"
					id='exchange_credit' class="w100" placeholder="请输入兑换<?php echo $credit_name?>">
			</div>
			<div><?php echo $credit_name?></div>
		</div>
		</ib> <ib class="parts">
		<div>
			<div>
				<ib class="space-num" data-xiaoshu=".00">0</ib>
			</div>
			<div><?php echo $balance_name?></div>
		</div>
		</ib> <ib class="duihuan"> <ib>兑</ib></ib> </flex>
		<div class="shuoming">
			<ib>1<?php echo $credit_name?>=<?php echo $ratio?><?php echo $balance_name?></ib>
		</div>
		<div class="btn">确认兑换</div>
	</div>
	<flex class="tc fadeIn none">
	<div class="tc_body">
		<div>
			<div>提示</div>
			<div><?php echo $credit_name?>兑换<?php echo $balance_name?>操作完成后，不可撤销。</div>
			<div>请确认是否兑换？</div>
			<flex between> <ib class="back">再想想</ib> <ib class="ok">确认兑换</ib> </flex>
		</div>
	</div>
	</flex>
	<script
		src="<?php echo base_url("public/member/phase2/scripts/jquery.js");?>"></script>
	<script>
        $(".change input").on("input",function(){
            var jifen = this.value;
            var jf_max = parseInt(this.dataset.max);
            jifen = jifen > jf_max ? jf_max : jifen;
            this.value = jifen;
            var chuzhi = <?php echo $ratio?>*jifen;
            var zhengshu = parseInt(chuzhi);
            var yushu = (chuzhi - zhengshu).toFixed(2).toString().substr(1,3);
            $(".space-num").html(zhengshu).attr("data-xiaoshu",yushu);
        });
        $(".btn").on("click",function(){
        	var credit=$('#exchange_credit').val();
           	if(credit<1){
    				alert('兑换<?php echo $credit_name?>数额不能小于1');
    				return false;
               	}
            $(".tc").removeClass("none"); 
        });
        $(".back").on("click",function(){
            $(".tc").removeClass("fadeIn").addClass("fadeOut none"); 
        });
        $(".ok").on("click",function(){
       	var credit=$('#exchange_credit').val();
       	if(credit<0){
				alert('兑换<?php echo $credit_name?>数额不能小于1');
				return false;
           	}
       	var data = {credit:credit};
       	$.ajax({
         	url:'<?php echo base_url("index.php/membervip/exchange/credit_exchange");?>',
         	type:'POST',
          data:data, 
          dataType:'json',
          success:function(res){
              if(res.status==0){
					location.reload(true);   
                  }else{
                  	alert(res.message);
                      }
              
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
			}
      });
            });
        $(document).on("animationEnd webkitAnimationEnd",".fadeOut",function(){
            $(this).addClass("fadeIn none").removeClass("fadeOut"); 
        });
    </script>
</body>

</html>
