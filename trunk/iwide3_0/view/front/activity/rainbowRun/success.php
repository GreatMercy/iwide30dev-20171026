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
        <p>报名并支付成功</p>
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
        <a href="javascript:;" class="btn btn-index">返回首页</a>
        <a href="javascript:;" class="btn btn-wechat">关注微信查看记录</a>
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
        <p class="tip">爱心传递，诚邀您的小伙伴一起加入我们！</p>
        </div>
      </div>
      <div class="page-control">
        <!-- <a href="javascript:;" class="btn btn-index">返回首页</a> -->
          <a href="javascript:;" class="btn">立即分享</a>
          <a href="javascript:;" class="btn btn-intro">活动介绍</a>        
      </div>
    </div>
  </div>
  <div class="page layer page-amity Ldn">
    <div class="box bg">
      <div class="logo bg bgcontain"></div>
      <div class="run bg bgcontain"></div>
      <div class="people bg bgcontain"></div>
    </div>
    <div class="page-box">
    <div class="page-wrap onepx onepx-horizontal onepx-vertical">
      <div class="page-cont onepx onepx-horizontal onepx-vertical">
        <div class="title onepx onepx-vertical onepx-horizontal">活动<br/>介绍</div>
        <p class="pt8">爱德基金会（英文名称：The Amity Foundation）成立于一九八五年四月，旨在促进我国的教育、社会福利、医疗卫生、社区发展与环境保护、灾害管理等各项社会公益事业，迄今为止，项目区域累计覆盖全国31个省、市、自治区，逾千万人受益。</p>
        <p>爱德基金会本部设立在南京，作为民间团体，爱德享有独立的决策权的同时积极寻求与所有致力于促进中国社会发展、提高人民生活水平的部门或团体的合作，包括政府组织、地方政府、专业机构、大专院校、教会及其他宗教团体等。与信仰互相尊重的原则下共同献策出力，开展同海内外的友好交往，发展我国的社会公益事业，促进社会发展，服务社会、造福人群，维护世界和平。</p>
      </div>
    </div>
    <div class="page-control">
      <a href="javascript:;" class="btn btn-run">下一步</a>
    </div>
    </div>
  </div>
  <div class="page layer page-run Ldn">
    <div class="box bg">
      <div class="logo bg bgcontain"></div>
      <div class="run bg bgcontain"></div>
      <div class="people bg bgcontain"></div>
    </div>
    <div class="page-box">
    <div class="page-wrap onepx onepx-vertical onepx-horizontal">
      <div class="page-cont onepx onepx-horizontal onepx-vertical">
        <div class="title onepx-vertical onepx onepx-horizontal">活动<br/>介绍</div>
        <p class="pt8">由金陵连锁酒店与爱德基金会联合发起“爱·一起跑“活动，旨在聚合美好社会正能量，凝聚所有人的力量，用爱让更多的人的生活充满绚烂色彩。<br/>活动分为三个阶段，”爱·一起跑“金陵连锁酒店慈善系列活动，在跑步形式淡化了竞争与对抗，更在跑步过程中增加了互动游戏，增进家人、朋友、工作团队间的感情，凸显激情与活力，让更多人感受到运动带来的快乐、健康。</p>
        <div class="people bgcontain"></div>
      </div>
    </div>
    <div class="page-control">
      <a href="javascript:;" class="btn btn-index">返回</a>
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