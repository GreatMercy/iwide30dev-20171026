<?php 
header('Cache-Control: public');
?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes" >
<meta name="apple-touch-fullscreen" content="yes">
<meta name="format-detection" content="telephone=no,email=no">
<meta name="ML-Config" content="fullscreen=yes,preventMove=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="user-scalable=no,width=320">
<!-- 全局控制 -->
<?php echo referurl('css','global.css',2,$media_path) ?>
<?php echo referurl('css','default.css',2,$media_path) ?>
<?php echo referurl('css','skin1.css',1,$media_path) ?>
<?php echo referurl('js','jquery.js',3,$media_path) ?>
<?php echo referurl('js','ui_control.js',2,$media_path) ?>
<?php echo referurl('js','alert.js?v=0.0.1',2,$media_path) ?>
<?php echo referurl('js','lazyload.js',3,$media_path) ?>
<?php include 'wxheader.php'?>
<!-- end -->
<title><?php echo $pagetitle;?></title>
</head>
<body>
<?php $main_color=isset($overall_style['theme_color'])? $overall_style['theme_color']:'#ff9900';?>
<?php
 $fontx=isset($overall_style['fontx'])?$overall_style['fontx']:14;
 if($fontx>20) $fontx=20;
 if($fontx<10) $fontx=10;
?>
<?php //echo $theme_color;?>
<?php //echo $fontx;?>
<div class="pageloading"></div>
<script>
$(function(){
	$("img.lazy").lazyload();  //惰性加载
});
</script>
<style>
.color_main,a.color_main,.btn_void, a.btn_void,.color_minor,a.color_minor{color:<?php echo $main_color;?>;}
.bg_main,a.bg_main,.btn_main,a.btn_main,.bg_minor,a.bg_minor,.btn_minor,a.btn_minor{background:<?php echo $main_color;?>;}
.bd_main_color{border-color:<?php echo $main_color;?> !important}
body, html, input, button, textarea{font-size:<?php echo $fontx;?>px;}

/*日历*/
#ncalendar thead td:first-child, #ncalendar thead td:last-child, #ncalendar tbody td.span
{color:<?php echo $main_color;?> !important;}
#ncalendar tbody td.current, #ncalendar tbody td.begin, #ncalendar tbody td.end
{background:<?php echo $main_color;?> !important;}
</style>