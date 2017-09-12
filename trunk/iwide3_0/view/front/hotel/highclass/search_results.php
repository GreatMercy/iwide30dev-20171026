
<?php include 'header.php' ?>
<div id="app"></div>
<div id="scriptArea" data-page-id="nearby"></div>

</body>

<?php include 'footer.php' ?>
</script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
	if (wx) {
        wx.config({
            debug: false,
            appId: '<?php echo $signPackage["appId"];?>',
            timestamp: <?php echo $signPackage["timestamp"];?>,
            nonceStr: '<?php echo $signPackage["nonceStr"];?>',
            signature: '<?php echo $signPackage["signature"];?>',
            jsApiList: ['getLocation']
          });
wx.ready(function(){
wx.getLocation({
    type: 'wgs84',
    // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
    success: (res) => {
      // 纬度
      let latitude = res.latitude
      // 经度
      let longitude = res.longitude
      window.localStorage.setItem('latitude',latitude)
      window.localStorage.setItem('longitude',longitude)
    }
  })
});
    }

</script>
</head>
</html>