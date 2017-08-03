<!DOCTYPE html>
<html lang="en">
<head>
<head>
  <meta charset="UTF-8">
  <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
  <meta name="apple-mobile-web-app-title" content="">
  <meta name="keywords" content="">
  <meta name="apple-touch-fullscreen" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="format-detection" content="telephone=no">
  <meta name="x5-fullscreen" content="true">
  <meta name="full-screen" content="yes">
  <meta name="description" content="">
  <meta name="applicable-device" content="mobile">
  <?php echo referurl('css', 'index.css', 1, $media_path) ?>
</head>
  <title>爱一起跑-金陵连锁酒店</title>
</head>
<body>
  <div class="page layer page-success">
  <div class="box bg">
    <div class="logo bg bgcontain"></div>
    <div class="run bg bgcontain"></div>
    <div class="people bg bgcontain"></div>
  </div>
    <div class="page-box">
      <div class="tip">
        <span class="icon"></span>
        <p>报名成功</p>
      </div>
      <div class="info">
        <p class="title">个人报名信息</p>
        <ul>
          <li>场次：<?php echo $order_info['city'];?></li>
          <li>姓名：<?php echo $order_info['username'];?></li>
          <li>性别：<?php echo $order_info['gender'];?></li>
          <li>年龄：<?php echo $order_info['age'];?></li>
          <li>电话：<?php echo $order_info['phone'];?></li>
          <li>身份证号：<?php echo $order_info['idcard'];?></li>
          <li>邮箱：<?php echo $order_info['email'];?></li>
          <li>紧急联系人姓名：<?php echo $order_info['urgent_username'];?></li>
          <li>紧急联系人电话：<?php echo $order_info['urgent_phone'];?></li>
        </ul>
      </div>
      <div class="page-control">
        <!--<a href="javascript:;" class="btn btn-index">返回首页</a>-->
        <!--<a href="javascript:;" class="btn btn-wechat">关注微信查看记录</a>-->
      </div>
    </div>
  </div>
  <div class="page layer page-wechat Ldn">
  <div class="box bg">
    <div class="logo bg bgcontain"></div>
    <div class="run bg bgcontain"></div>
    <div class="people bg bgcontain"></div>
  </div>
    <div class="page-box">
      <div class="wechat">
        <div class="cont">
        <img src="<?php echo base_url('public/activity/rainbowRun/img/wechat.png')?>"/>
        <p class="tip">优惠套餐，预定餐厅，预定客房，会员专属权益<br/>更多精彩尽在金陵连锁酒店微信公众号</p>
        </div>
      </div>
      <div class="page-control">
        <a href="javascript:;" class="btn btn-index">返回首页</a>
      </div>
    </div>
  </div>
  <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
  <script>
    var pageIndex = '<?php echo $index_url;?>'
  </script>
  <?php echo referurl('js', 'zepto.js', 1, $media_path) ?>
  <?php echo referurl('js', 'index.js', 1, $media_path) ?>
</body>
</html>