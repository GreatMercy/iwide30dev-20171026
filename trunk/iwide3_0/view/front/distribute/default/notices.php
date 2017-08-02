
<link href="<?php echo base_url('public/distribute/default/styles/incom.css')?>" rel="stylesheet">
<link href="<?php echo base_url('public/distribute/default/styles/deposit.css')?>" rel="stylesheet">
<title>提现记录</title>
</head>
<body>
<div class="headr">
	<div><a href="<?php echo site_url('distribute/distribute/incomes')?>?id=<?php echo $inter_id?>">收益记录</a></div>
	<div><a class="col" href="">提现记录</a></div>
</div>

<div class="content">
	<div class="c_lis" style="padding:3%">
    	<font class="price">¥</font>
    	<p class="promp">异常</p>
    	<p class="balance">余额 ¥</p>
    	<p class="tmie"></p>
    </div>
</div>

<div class="content" style="display:none">
</div>
<div class="floot" style="padding-top:14%;display:none;">
	<div class="fix">
    </div>
</div>
<?php var_dump($msgs);?>
</body>
</html>