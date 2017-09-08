# 房型列表页面（booking_hotel） ==> 由于页面使用单页面路由，需要在链接最后面加 & 号， 如www.baidu.com?theme = 1 & (保证url参数解析正确)

============= 路由 =============

#/main ==> 主页
#/order ==>提交订单
#/choose ==> 选择优惠券

============= 路由参数配置 =============

#  id           ==> 微信id
#  openid			  ==> 微信 openid
#  startdate 		==> 开始日期
#  enddate      ==> 结束日期
#  h  				  ==> (hotel_id)

# 附近城市页面 (nearby)

#  id           ==> 微信id
#  openid			  ==> 微信 openid
#  startdate 		==> 开始日期
#  enddate      ==> 结束日期
#  city 			  ==> 城市名
#  nearby   		==> 1 附近


# 首页 (search)

#  id           ==> 微信id
#  openid			  ==> 微信 openid

# hotel_album (酒店相册)

# h             ==> 酒店id
