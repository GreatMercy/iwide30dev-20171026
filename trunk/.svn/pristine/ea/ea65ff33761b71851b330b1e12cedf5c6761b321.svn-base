<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Molin extends CI_Controller{
		/*
		 * 莫林风尚的接口测试
		 */
		// private $url = 'http://test.chinapms.com:9001/gateway/'; //测试环境
		// private $check_url = 'sob.sob_code=www.test.com&sob.password=111111&sob.hotelgroup_id=159';	//测试环境账号
		private $url = 'http://x.hotelwebs.cn/gateway/'; //正式环境
		private $check_url = 'sob.sob_code=www.ldmlfs.com&sob.password=20120525&sob.hotelgroup_id=376'; //正式环境账号
		public function __construct(){
			parent::__construct();
			$this->load->helper('common_helper');
		}
		
		public function index(){
			echo '莫林风尚的接口测试';
		}
		
		/*
		 * get_hotelgroup_detail	
		 */
		public function get_hotelgroup_detail(){
			$url = $this->url . 'get_hotelgroup_detail?' . $this->check_url;
			
			$res = doCurlGetRequest($url);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"hotelgroup_id":"159","name":"北京酒店连锁","phone":"400888999","fax":"010-82133391","zip":"430000","logo":"cnsccdjyzj/logo_121122155320136.jpg","brief_intro":"罗盘武汉店，座落于武汉金融商业中心的国际品牌连锁酒店，邻近新世界百货商场，交通便利。","detail_intro":" 罗盘武汉店，座落于武汉金融商业中心的国际品牌连锁酒店，邻近新世界百货商场，交通便利。饭店拥有各类客房，房内设施齐全。饭店兼备多项商务设施及服务，拥有法式餐厅、中餐厅、咖啡厅、西饼屋，能满足不同客人的口味。饭店店拥有不同规模的多功能会议厅，会议设施齐全，功能完备，是举办各类会议的理想选择。\r\n酒店开业时间2002年9月，2009年5月完成局部装修（更换客房地毯、液晶平面电视等），楼高13层，客房总数303间套。","address":"湖北省武汉市光谷广场test"}
			 */
		}

		/*
		 * search_hotel_rates	查询一段时间内可用房态及房价	
		 */
		public function search_hotel_rates(){
			$url = $this->url . 'search_hotel_rates?' . $this->check_url;
			
			$data = array(
				"condition.hotel_id" => "cnhnldmlcq",
				"condition.hotelgroup_id"=> "",
				"condition.check_in_date"=> "2016-01-01",
				"condition.check_out_date"=> "2016-01-03",
				"condition.rate_codes" =>"LIST",
				"condition.room_quantity"=> "1",
				"condition.room_type_id"=> "",
				"condition.city_name" =>"",
				"condition.city_code" =>"",
				"condition.name_or_address"=> "",
				"condition.latitude"=> "",
				"condition.longitude"=>"",
				"condition.biz_source_id"=> "",
				"condition.brand" =>"",
				"condition.rate_promotion_id"=> "",
				"condition.page"=> "0",
				"condition.page_size"=> "1"
			);
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"room_avail_records":[{"hotel_id":"cnhnldmlcq","hotel_name":"莫林风尚长青店","star":0,"logo":"cnhnldmlcq/logo_150504094424110.jpg","hotel_phone":"0738-8313333","hotel_intro":"娄底莫林风尚酒店（长青店）位于娄底市中心黄金地段——娄星商业圈。毗邻长青商业地下步行街、春园步行街、九亿步行街、老九龙购物广场等大型购物场所，是娄底饮食、购物、休闲、娱乐的圣地。交通便捷，距火车站、汽车东站仅5分钟车程。不论是商务旅行还是休闲住宿，入住莫林长青分店都将是您的最佳选择。 ","hotel_address":"娄底市娄星区长青街邮政局旁","latitude":27.732954238198335,"longitude":112.00244697494342,"traffic_guide":"距离火车站、汽车站仅3分钟车程，","review_rate":4.763333333333333,"review_count":7,"check_in_date":"2016-01-01","check_out_date":"2016-01-10","room_type_statuses":[{"room_type_id":7297,"room_type_name":"迷你时空B","room_type_desc":"房间15㎡、 1.5米单人床1张、楼层3-6层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_150504094503204.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[159.0,159.0,159.0,159.0,159.0,159.0,159.0,159.0,159.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[15,15,15,15,15,15,15,15,15],"quantity_status":2},{"room_type_id":7299,"room_type_name":"精选时空A","room_type_desc":"房间15㎡、 1.5米单人床1张、楼层3-6层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_150504094535711.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[199.0,199.0,199.0,199.0,199.0,199.0,199.0,199.0,199.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[14,14,14,14,14,14,14,14,14],"quantity_status":2},{"room_type_id":7295,"room_type_name":"精英商务D","room_type_desc":"房间25㎡、 1.8米单人床1张、楼层3-6层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_140519173359724.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[219.0,219.0,219.0,219.0,219.0,219.0,219.0,219.0,219.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[15,15,15,15,15,15,15,15,15],"quantity_status":2},{"room_type_id":7293,"room_type_name":"精英商务S","room_type_desc":"房间25㎡、 1.5米单人床2张、楼层3-6层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_140519173552191.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[219.0,219.0,219.0,219.0,219.0,219.0,219.0,219.0,219.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[20,20,20,20,20,20,20,20,20],"quantity_status":2},{"room_type_id":50123,"room_type_name":"莫尚臻品D","logo":"cnhnldmlcq/room_logo_151223125038446.jpg","nights":9,"room_quantity":1,"score":27000.0,"prices":{"LIST":[279.0,279.0,279.0,279.0,279.0,279.0,279.0,279.0,279.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[0,0,0,0,0,0,0,0,0],"quantity_status":0},{"room_type_id":50125,"room_type_name":"莫尚臻品S","logo":"cnhnldmlcq/room_logo_151223125053763.jpg","nights":9,"room_quantity":1,"score":27000.0,"prices":{"LIST":[279.0,279.0,279.0,279.0,279.0,279.0,279.0,279.0,279.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[0,0,0,0,0,0,0,0,0],"quantity_status":0},{"room_type_id":7291,"room_type_name":"娱乐空间D","room_type_desc":"房间25㎡、 1.8米单人床1张、楼层3-6层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_140519173626718.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[6,6,6,6,6,6,6,6,6],"quantity_status":2},{"room_type_id":7285,"room_type_name":"现代AD","room_type_desc":"房间25㎡、 1.8米单人床1张、楼层7层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_140519173711857.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[239.0,239.0,239.0,239.0,239.0,239.0,239.0,239.0,239.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[7,7,7,7,7,7,7,7,7],"quantity_status":2},{"room_type_id":7287,"room_type_name":"现代AS","room_type_desc":"房间25㎡、 1.5米单人床3张、楼层7层、24小时热水、免费wifi、最多入住1人","logo":"cnhnldmlcq/room_logo_140519173844823.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[239.0,239.0,239.0,239.0,239.0,239.0,239.0,239.0,239.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[7,7,7,7,7,7,7,7,7],"quantity_status":2},{"room_type_id":7273,"room_type_name":"欧韵AD","room_type_desc":"房间25㎡、 1.8米单人床3张、楼层8层、24小时热水、免费wifi、最多入住1人","logo":"cnhnldmlcq/room_logo_140519173946868.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[4,4,4,4,4,4,4,4,4],"quantity_status":2},{"room_type_id":7275,"room_type_name":"欧韵AS","room_type_desc":"房间25㎡、 1.5米单人床2张、楼层8层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_140519174104199.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[2,2,2,2,2,2,2,2,2],"quantity_status":2},{"room_type_id":7281,"room_type_name":"美式田园D","room_type_desc":"房间25㎡、 1.8米单人床1张、楼层8层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_140519174133298.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[4,4,4,4,4,4,4,4,4],"quantity_status":2},{"room_type_id":7283,"room_type_name":"美式田园S","room_type_desc":"房间25㎡、 1.5米单人床2张、楼层8层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_140519174803391.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[2,2,2,2,2,2,2,2,2],"quantity_status":2},{"room_type_id":7269,"room_type_name":"花好月圆D","room_type_desc":"房间25㎡、 1.8米单人床1张、楼层8层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_140519175548502.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0,259.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[2,2,2,2,2,2,2,2,2],"quantity_status":2},{"room_type_id":7271,"room_type_name":"欢乐满屋D","room_type_desc":"房间25㎡、 1.8米单人床1张、楼层7-8层、24小时热水、免费wifi、最多入住2人","logo":"cnhnldmlcq/room_logo_140519175611941.jpg","nights":9,"room_quantity":1,"score":0.0,"prices":{"LIST":[299.0,299.0,299.0,299.0,299.0,299.0,299.0,299.0,299.0]},"breakfasts":{"LIST":[0,0,0,0,0,0,0,0,0]},"quantities":[2,2,2,2,2,2,2,2,2],"quantity_status":2}]}]}
			 */
		}

		/*
		 * get_hotel_detail	查看酒店详细介绍
		 */
		public function get_hotel_detail(){
			$url = $this->url . 'get_hotel_detail?' . $this->check_url;

			$data = array(
				"hotel_id" => "cnhnldmlcq"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"hotel":{"hotel_id":"cnbjbjcgmz","name":"罗盘北京民族园店","email":"sales@a-h-e.com.cn","fax":"010-82859741","phone":"010-82080525","mobile":"","zip":"100029","city_code":"100000","latitude":39.9831820121889,"longitude":116.36913819154097,"address":"北京市朝阳区民族园路1号丰宝恒大厦","traffic_guide":"罗盘北京酒店（民族园店）位于奥运村内，步行即达奥运主场馆群，步行到达鸟巢，水立方仅10分钟；5分钟驱车可到达北京国际会议中心；地铁10号线奥运专线近在咫尺；首都机场25分钟可到；距离北京站12公里；国际会议中心只有2公里；紧邻地铁10号线；乘地铁至CBD仅需15分钟；去上地和中关村高科技园区仅需8分钟；距离清华、北大、颐和园、圆明园遗址只有7公里；距离北京航空航天大学仅需4公里。ssss","brief_intro":"罗盘北京酒店（民族园店）位于奥运村内，共计客房241间，酒店宽敞明亮公寓房型以30-50平米为主，房间内可纵观中华民族园公园和奥运景观大道；步行即达奥运主场馆群，步行到达鸟巢，水立方仅10分钟；5分钟驱车可到达北京国际会议中心；地铁10号线奥运专线近在咫尺；首都机场25分钟可到；距离北京站12公里；国际会议中心只有2公里；紧邻地铁10号线；乘地铁至CBD仅需15分钟；去上地和中关村高科技园区仅需8分钟；距离清华、北大、颐和园、圆明园遗址只有7公里；距离北京航空航天大学仅需4公里；是商务和休闲客人物超所值的精智之选。ss","detail_intro":"罗盘北京酒店（民族园店）位于奥运村内，共计客房247间，酒店宽敞明亮公寓房型以30-50平米为主，房间内可纵观中华民族园公园和奥运景观大道；步行即达奥运主场馆群，步行到达鸟巢，水立方仅10分钟；5分钟驱车可到达北京国际会议中心；地铁10号线奥运专线近在咫尺；首都机场25分钟可到；距离北京站12公里；国际会议中心只有2公里；紧邻地铁10号线；乘地铁至CBD仅需15分钟；去上地和中关村高科技园区仅需8分钟；距离清华、北大、颐和园、圆明园遗址只有7公里；距离北京航空航天大学仅需4公里；是商务和休闲客人物超所值的精智之选。ssss","announce":"请您务必填写有效联系电话！尤其在酒店房态紧张情况下，由于您的联系信息不准确，不能提前与您得到入住确认，因而造成在您入住时出现无房的情况，酒店将对此概不负责。D\r\n","brand":"","star":4,"priority":3000,"logo":"cnbjbjcgmz/logo_121122155030845.jpg","default_reserve_hour":24,"close_today_time":24,"allow_anonymous":true,"room_types":[{"id":1639,"name":"13","desc":"","hotel_id":"cnbjbjcgmz","list_price":0.0,"total_amount":0,"list_priority":0},{"id":1325,"name":"标大","hotel_id":"cnbjbjcgmz","list_price":268.0,"total_amount":0,"list_priority":0},{"id":1323,"name":"标准双床房","desc":"","hotel_id":"cnbjbjcgmz","list_price":268.0,"total_amount":0,"list_priority":0},{"id":1321,"name":"商务双床房","hotel_id":"cnbjbjcgmz","list_price":298.0,"total_amount":0,"list_priority":0},{"id":1593,"name":"商务双床房","hotel_id":"cnbjbjcgmz","list_price":298.0,"total_amount":0,"list_priority":0},{"id":1327,"name":"行政大","hotel_id":"cnbjbjcgmz","list_price":328.0,"total_amount":0,"list_priority":0},{"id":1591,"name":"行政双床","hotel_id":"cnbjbjcgmz","list_price":328.0,"total_amount":0,"list_priority":0},{"id":651,"name":"铂金大床房","desc":"床型：双床（120cm*200cm）/大床（180cm*200cm）房间面积：35平方米楼层：28层-30层 上网方式：宽带[免费]\r\n\r\n","hotel_id":"cnbjbjcgmz","list_price":328.0,"total_amount":0,"list_priority":0,"logo":"cnbjbjcgmz/1481223/room_logo_121122114452000.jpg"},{"id":1589,"name":"行政套","hotel_id":"cnbjbjcgmz","list_price":388.0,"total_amount":0,"list_priority":0},{"id":1451,"name":"商务套","hotel_id":"cnbjbjcgmz","list_price":568.0,"total_amount":0,"list_priority":0}]}}
			 */
		}

		/*
		 * get_room_type_list	查看房型详细信息列表
		 */
		public function get_room_type_list(){
			$url = $this->url . 'get_room_type_list?' . $this->check_url;
			
			$data = array(
				"hotel_id" => "cnbjbjcgmz"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"room_types":[{"id":1639,"name":"13","desc":"","hotel_id":"cnbjbjcgmz","list_price":0.0,"total_amount":0,"list_priority":0},{"id":1325,"name":"标大","hotel_id":"cnbjbjcgmz","list_price":268.0,"total_amount":0,"list_priority":0},{"id":1323,"name":"标准双床房","desc":"","hotel_id":"cnbjbjcgmz","list_price":268.0,"total_amount":0,"list_priority":0},{"id":1321,"name":"商务双床房","hotel_id":"cnbjbjcgmz","list_price":298.0,"total_amount":0,"list_priority":0},{"id":1593,"name":"商务双床房","hotel_id":"cnbjbjcgmz","list_price":298.0,"total_amount":0,"list_priority":0},{"id":1327,"name":"行政大","hotel_id":"cnbjbjcgmz","list_price":328.0,"total_amount":0,"list_priority":0},{"id":1591,"name":"行政双床","hotel_id":"cnbjbjcgmz","list_price":328.0,"total_amount":0,"list_priority":0},{"id":651,"name":"铂金大床房","desc":"床型：双床（120cm*200cm）/大床（180cm*200cm）房间面积：35平方米楼层：28层-30层 上网方式：宽带[免费]\r\n\r\n","hotel_id":"cnbjbjcgmz","list_price":328.0,"total_amount":0,"list_priority":0,"logo":"cnbjbjcgmz/1481223/room_logo_121122114452000.jpg"},{"id":1589,"name":"行政套","hotel_id":"cnbjbjcgmz","list_price":388.0,"total_amount":0,"list_priority":0},{"id":1451,"name":"商务套","hotel_id":"cnbjbjcgmz","list_price":568.0,"total_amount":0,"list_priority":0}]}
			 */
		}

		/*
		 * get_sub_hotel_list	查看分店详细介绍
		 */
		public function get_sub_hotel_list(){
			$url = $this->url . 'get_sub_hotel_list?' . $this->check_url;
			
			$data = array(
				"hotels" => "cnbjbjcgmz"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"hotels":[{"hotel_id":"cnsccdjyzj","name":"罗盘武汉店","email":"jack@luopan.com","fax":"010-82133391","phone":"027-48784686","mobile":"18601067400","zip":"430000","city_code":"430000","latitude":30.538307106806236,"longitude":114.32378701315986,"address":"湖北省武汉市光谷广场test","traffic_guide":"酒店位于汉口金融商业中心，可步行至新世界国贸大厦等豪华购物中心，休闲购物便利。\r\n- 至武汉新世界国贸大厦，步行约5分钟；\r\n- 距离武汉国际会展中心3公里，乘坐出租车约10分钟；\r\n- 距离汉口火车站3.5公里，乘坐出租车约10分钟；\r\n- 距离武汉火车站（高铁）19.5公里，乘坐出租车约35分钟；\r\n- 距离武汉天河机场25公里，乘坐出租车约40分钟。","brief_intro":"罗盘武汉店，座落于武汉金融商业中心的国际品牌连锁酒店，邻近新世界百货商场，交通便利。","detail_intro":" 罗盘武汉店，座落于武汉金融商业中心的国际品牌连锁酒店，邻近新世界百货商场，交通便利。饭店拥有各类客房，房内设施齐全。饭店兼备多项商务设施及服务，拥有法式餐厅、中餐厅、咖啡厅、西饼屋，能满足不同客人的口味。饭店店拥有不同规模的多功能会议厅，会议设施齐全，功能完备，是举办各类会议的理想选择。\r\n酒店开业时间2002年9月，2009年5月完成局部装修（更换客房地毯、液晶平面电视等），楼高13层，客房总数303间套。","announce":"为便于您避开建设大道交通繁忙路段，建议参考以下两种行车线路进入酒店：\r\n线路一：\r\n建设大道→万松园路（左拐）→雪松路（左拐）→劲松巷→饭店；\r\n线路二：\r\n建设大道→新华路（右拐）→新华小路→饭店","brand":"","star":2,"priority":3000,"logo":"cnsccdjyzj/logo_121122155320136.jpg","default_reserve_hour":24,"close_today_time":24,"allow_anonymous":true,"room_types":[{"id":967,"name":"商务单间","desc":"一房一卫（有厨房或无厨房），普通装修\r\n客厅连睡房：沙发、茶几、电视（24寸彩电）、电脑桌椅、台灯、分机电话、1.5米大床和床上用品,连床头柜和床头灯、衣柜、电视柜、彩电\r\n厨房：双灶燃气灶、抽油烟机、厨房设施、餐柜、壁柜和不锈钢洗涤盆\r\n卫生间：进口卫生器具、淋浴、浴霸\r\n可为长住客人提供冰箱、洗衣机、冰箱\r\n","hotel_id":"cnsccdjyzj","list_price":270.0,"total_amount":0,"list_priority":0,"logo":"cnsccdjyzj/room_logo_140826202633728.jpg"},{"id":969,"name":"商务标间","desc":"一房一卫（有厨房或无厨房），普通装修\r\n客厅连睡房：沙发、茶几、电视（24寸彩电）、电脑桌椅、台灯、分机电话、1.5米大床和床上用品,连床头柜和床头灯、衣柜、电视柜、彩电\r\n厨房：双灶燃气灶、抽油烟机、厨房设施、餐柜、壁柜和不锈钢洗涤盆、\r\n卫生间：进口卫生器具、淋浴、浴霸\r\n可为长住客人提供冰箱、洗衣机、冰箱\r\n","hotel_id":"cnsccdjyzj","list_price":888.0,"total_amount":0,"list_priority":0,"logo":"cnsccdjyzj/room_logo_140826202517830.jpg"},{"id":973,"name":"商务套房","desc":"二房一厅一厨一卫，房间豪华装修\r\n\r\n客厅：沙发、茶几、电视（42彩电）、餐桌椅、台灯、分机电话。\r\n\r\n睡房：1.5米大床和床上用品,连床头柜和床头灯、衣柜、电视柜、彩电、酒店专用遮光帘\r\n\r\n厨房：双灶燃气灶、微波炉、抽油烟机、电冰箱、厨房设施、餐柜、壁柜和不锈钢洗涤盆、洗衣机\r\n\r\n卫生间：进口卫生器具、淋浴、浴霸\r\n\r\n","hotel_id":"cnsccdjyzj","list_price":888.0,"total_amount":0,"list_priority":0,"logo":"cnsccdjyzj/room_logo_140826202616722.jpg"},{"id":1833,"name":"1","hotel_id":"cnsccdjyzj","list_price":1222.0,"total_amount":0,"list_priority":0}]},{"hotel_id":"cnbjbjcgmz","name":"罗盘北京民族园店","email":"sales@a-h-e.com.cn","fax":"010-82859741","phone":"010-82080525","mobile":"","zip":"100029","city_code":"100000","latitude":39.9831820121889,"longitude":116.36913819154097,"address":"北京市朝阳区民族园路1号丰宝恒大厦","traffic_guide":"罗盘北京酒店（民族园店）位于奥运村内，步行即达奥运主场馆群，步行到达鸟巢，水立方仅10分钟；5分钟驱车可到达北京国际会议中心；地铁10号线奥运专线近在咫尺；首都机场25分钟可到；距离北京站12公里；国际会议中心只有2公里；紧邻地铁10号线；乘地铁至CBD仅需15分钟；去上地和中关村高科技园区仅需8分钟；距离清华、北大、颐和园、圆明园遗址只有7公里；距离北京航空航天大学仅需4公里。ssss","brief_intro":"罗盘北京酒店（民族园店）位于奥运村内，共计客房241间，酒店宽敞明亮公寓房型以30-50平米为主，房间内可纵观中华民族园公园和奥运景观大道；步行即达奥运主场馆群，步行到达鸟巢，水立方仅10分钟；5分钟驱车可到达北京国际会议中心；地铁10号线奥运专线近在咫尺；首都机场25分钟可到；距离北京站12公里；国际会议中心只有2公里；紧邻地铁10号线；乘地铁至CBD仅需15分钟；去上地和中关村高科技园区仅需8分钟；距离清华、北大、颐和园、圆明园遗址只有7公里；距离北京航空航天大学仅需4公里；是商务和休闲客人物超所值的精智之选。ss","detail_intro":"罗盘北京酒店（民族园店）位于奥运村内，共计客房247间，酒店宽敞明亮公寓房型以30-50平米为主，房间内可纵观中华民族园公园和奥运景观大道；步行即达奥运主场馆群，步行到达鸟巢，水立方仅10分钟；5分钟驱车可到达北京国际会议中心；地铁10号线奥运专线近在咫尺；首都机场25分钟可到；距离北京站12公里；国际会议中心只有2公里；紧邻地铁10号线；乘地铁至CBD仅需15分钟；去上地和中关村高科技园区仅需8分钟；距离清华、北大、颐和园、圆明园遗址只有7公里；距离北京航空航天大学仅需4公里；是商务和休闲客人物超所值的精智之选。ssss","announce":"请您务必填写有效联系电话！尤其在酒店房态紧张情况下，由于您的联系信息不准确，不能提前与您得到入住确认，因而造成在您入住时出现无房的情况，酒店将对此概不负责。D\r\n","brand":"","star":4,"priority":3000,"logo":"cnbjbjcgmz/logo_121122155030845.jpg","default_reserve_hour":24,"close_today_time":24,"allow_anonymous":true,"room_types":[{"id":1639,"name":"13","desc":"","hotel_id":"cnbjbjcgmz","list_price":0.0,"total_amount":0,"list_priority":0},{"id":1325,"name":"标大","hotel_id":"cnbjbjcgmz","list_price":268.0,"total_amount":0,"list_priority":0},{"id":1323,"name":"标准双床房","desc":"","hotel_id":"cnbjbjcgmz","list_price":268.0,"total_amount":0,"list_priority":0},{"id":1321,"name":"商务双床房","hotel_id":"cnbjbjcgmz","list_price":298.0,"total_amount":0,"list_priority":0},{"id":1593,"name":"商务双床房","hotel_id":"cnbjbjcgmz","list_price":298.0,"total_amount":0,"list_priority":0},{"id":1327,"name":"行政大","hotel_id":"cnbjbjcgmz","list_price":328.0,"total_amount":0,"list_priority":0},{"id":1591,"name":"行政双床","hotel_id":"cnbjbjcgmz","list_price":328.0,"total_amount":0,"list_priority":0},{"id":651,"name":"铂金大床房","desc":"床型：双床（120cm*200cm）/大床（180cm*200cm）房间面积：35平方米楼层：28层-30层 上网方式：宽带[免费]\r\n\r\n","hotel_id":"cnbjbjcgmz","list_price":328.0,"total_amount":0,"list_priority":0,"logo":"cnbjbjcgmz/1481223/room_logo_121122114452000.jpg"},{"id":1589,"name":"行政套","hotel_id":"cnbjbjcgmz","list_price":388.0,"total_amount":0,"list_priority":0},{"id":1451,"name":"商务套","hotel_id":"cnbjbjcgmz","list_price":568.0,"total_amount":0,"list_priority":0}]},{"hotel_id":"cnbjbjlp00","name":"测试酒店","email":"shenzhi@luopan.com","fax":"010-82133362","phone":"010-82133362","mobile":"","zip":"100098","city_code":"100000","latitude":39.97566812140633,"longitude":116.33893966674805,"address":"北京市海淀区知春路甲48号盈都大厦D座108室","traffic_guide":"酒店位于东长安街，邻近皇宫紫禁城、步行即可抵达天安门广场和故宫博物院，位置优越。\r\n- 至王府井步行约5分钟；\r\n- 距离天安门广场1公里，步行约15分钟；\r\n- 距离北京站2公里，乘坐出租车约5分钟；\r\n- 距离北京首都国际机场30公里，乘坐出租车约45分钟。","brief_intro":"位于北京市中心长安街的北京罗盘总店是座历史悠久的大型豪华饭店，紧邻市中心王府井商业街。","detail_intro":" 位于北京市中心长安街的北京罗盘总店是座历史悠久的大型豪华饭店，紧邻市中心王府井商业街。饭店交融了东西方文化，曾接待过多个国家和地区的首脑。饭店房间高大宽敞，豪华典雅。饭店拥有各类中西餐厅及风味独特的谭家菜。饭店周边完善的地面及地铁交通设施为宾客的商务出行节省了宝贵的时间，同时现代化的酒店会议设施及服务可为宾客商务会谈和宴请提供更加广泛的空间。\r\n　　北京罗盘总店是2008北京奥运大家庭总部饭店，连续多年荣获了由美国优质服务科学学会颁发的“五星钻石奖”。\r\n　　酒店开业时间1900年，新近装修时间2008年，主楼19层，客房总数733间（套）。","announce":"1、您预订了N间房，请您提供不少于N位的入住客人姓名；\r\n2、按照酒店规定：12点前入住需等房，有房可入住情况下，入住时间在07：00前需要加收一天房费，入住时间在10：00前需要加收半天房费，请您配合；\r\n3、预订此酒店务必留入住客人真实姓名否则酒店不予确认请提示客人。","brand":"罗盘","star":5,"priority":1000,"logo":"cnbjbjlp00/logo_121122154941871.jpg","default_reserve_hour":24,"close_today_time":24,"allow_anonymous":true,"room_types":[{"id":1359,"name":"标间1","desc":"床型：双床（130cm*200cm）房间面积：39平方米楼层：7层-15层 上网方式：宽带无线[收费]\r\n\r\n其它：Ａ座，上网收费2元/分钟，封顶120元/天。加床415/张 ，每房限加一张。","hotel_id":"cnbjbjlp00","list_price":138.0,"total_amount":0,"list_priority":0,"logo":"cnbjbjlp00/room_logo_151206130111573.jpg"},{"id":1743,"name":"电脑房","hotel_id":"cnbjbjlp00","list_price":148.0,"total_amount":0,"list_priority":0},{"id":1745,"name":"大床房","hotel_id":"cnbjbjlp00","list_price":148.0,"total_amount":0,"list_priority":0},{"id":1355,"name":"二床","hotel_id":"cnbjbjlp00","list_price":158.0,"total_amount":0,"list_priority":0},{"id":1357,"name":"时尚","hotel_id":"cnbjbjlp00","list_price":168.0,"total_amount":0,"list_priority":0},{"id":1361,"name":"豪套","desc":"床型：大床（200cm*200cm）房间面积：70-110平方米楼层：3层-15层 上网方式：宽带无线[免费]\r\n\r\n其它：加床415/张 ，每房限加一张。","hotel_id":"cnbjbjlp00","list_price":228.0,"total_amount":0,"list_priority":0},{"id":1751,"name":"特色主题房","hotel_id":"cnbjbjlp00","list_price":258.0,"total_amount":0,"list_priority":0},{"id":1733,"name":"麻将房","hotel_id":"cnbjbjlp00","list_price":299.0,"total_amount":0,"list_priority":0},{"id":1753,"name":"个性主题房","hotel_id":"cnbjbjlp00","list_price":358.0,"total_amount":0,"list_priority":0},{"id":1447,"name":"娱套11","hotel_id":"cnbjbjlp00","list_price":388.0,"total_amount":0,"list_priority":0}]},{"hotel_id":"cncqcqsm00","name":"罗盘重庆店","email":"455344266@qq.com","fax":"023-63995176","phone":"023-63995777","mobile":"","zip":"400015","city_code":"400000","latitude":29.56222222222222,"longitude":106.55472222222222,"address":"重庆市江北区金源路9号（金源方特科幻公园旁）","traffic_guide":"酒店位于江北区观音桥商圈内，渝澳大桥和嘉华大桥横贯嘉陵江南北，交通十分便利。\r\n- 距离解放碑8.5公里，乘坐出租车约15分钟；\r\n- 距离重庆国际会展中心9公里，乘坐出租车约12分钟；\r\n- 距离重庆江北国际机场25公里，乘坐出租车约30分钟。","brief_intro":"罗盘四川店位于江北区观音桥中央商圈内，坐拥西南地区最大的金源时代购物中心、6000个免费地上停车位的广场，嘉陵江畔美景尽收眼底，北滨路美食街近在咫尺，尽享商圈都市繁华。","detail_intro":"罗盘四川店位于江北区观音桥中央商圈内，坐拥西南地区最大的金源时代购物中心、6000个免费地上停车位的广场，嘉陵江畔美景尽收眼底，北滨路美食街近在咫尺，尽享商圈都市繁华。\r\n罗盘四川店一层为大堂、豪景苑大堂酒廊、君豪自助西餐厅、商务中心、商品部、精品屋等；二层为国际会议区，拥有容纳600人的大宴会厅、具有六种语言同声传译功能的国际会议厅、首长接见厅以及各种大、中、小型会议室共11间；B1层为充满休闲渡假特色的流香轩茶艺居，拥有25间不同风格包厢的金豪源中餐厅和三层悦庭苑9间豪华中餐包厢；5到30层为客房，所有客房均提供免费上网服务；其中，28层——30层为行政楼层。\r\n饭店拥有2.2万平方米的康体娱乐设施（女子SPA、桑拿中心、夜总会、KTV、健身房、游泳池、游戏中心、网吧），6000个车位的停车场，与金源时代购物中心（居然之家、永辉超市旗舰店、苏宁电器、卢米埃影城、环球1号国际会所、华夏银行、工商银行）、方特娱乐主题公园、高级商务公寓、写字楼相互辉映，共同构成了西南地区唯一的规模宏大、设施完善、极具震憾力的集休闲、商务、会议、娱乐、购物、商住、办公于一体的时尚中心。\r\n酒店开业时间2005年11月12日，楼高26层，客房总数405间（套）。","announce":"","brand":"","star":0,"priority":1000,"logo":"cncqcqsm00/logo_121122155234840.jpg","default_reserve_hour":24,"close_today_time":24,"allow_anonymous":true,"room_types":[{"id":1661,"name":"豪华套房","hotel_id":"cncqcqsm00","list_price":200.0,"total_amount":0,"list_priority":0},{"id":737,"name":"标间","hotel_id":"cncqcqsm00","list_price":210.0,"total_amount":0,"list_priority":0},{"id":733,"name":"大床房","hotel_id":"cncqcqsm00","list_price":218.0,"total_amount":0,"list_priority":0},{"id":735,"name":"商务单间","hotel_id":"cncqcqsm00","list_price":240.0,"total_amount":0,"list_priority":0},{"id":739,"name":"豪华单间","desc":"床型：双床（120cm*200cm）/大床（180cm*200cm）房间面积：35平方米楼层：28层-30层 上网方式：宽带[免费]","hotel_id":"cncqcqsm00","list_price":240.0,"total_amount":0,"list_priority":0},{"id":741,"name":"蜜月房","hotel_id":"cncqcqsm00","list_price":250.0,"total_amount":0,"list_priority":0},{"id":743,"name":"复试套房","desc":"床型：双床（120cm*200cm）/大床（180cm*200cm）房间面积：35平方米楼层：28层-30层 上网方式：宽带[免费]","hotel_id":"cncqcqsm00","list_price":330.0,"total_amount":0,"list_priority":0},{"id":745,"name":"商务套房","hotel_id":"cncqcqsm00","list_price":330.0,"total_amount":0,"list_priority":0},{"id":1719,"name":"假日商务房","hotel_id":"cncqcqsm00","list_price":398.0,"total_amount":0,"list_priority":0},{"id":1509,"name":"豪华间","hotel_id":"cncqcqsm00","list_price":588.0,"total_amount":0,"list_priority":0}]},{"hotel_id":"cntestyn01","name":"云南测试店","email":"service@chinahotelsearch.com","fax":"010-58732204","phone":"010-58732203","mobile":"","zip":"100000","city_code":"650000","latitude":0.0,"longitude":0.0,"address":"","traffic_guide":"","brief_intro":"","detail_intro":"","announce":"","brand":"","star":0,"priority":1000,"logo":"nologo.jpg","default_reserve_hour":24,"close_today_time":24,"allow_anonymous":true,"room_types":[{"id":1816,"name":"高级大床房","hotel_id":"cntestyn01","list_price":588.0,"total_amount":0,"list_priority":0},{"id":1817,"name":"高级双床房","hotel_id":"cntestyn01","list_price":588.0,"total_amount":0,"list_priority":0},{"id":1818,"name":"豪华大床房","hotel_id":"cntestyn01","list_price":688.0,"total_amount":0,"list_priority":0},{"id":1819,"name":"豪华双床房","hotel_id":"cntestyn01","list_price":688.0,"total_amount":0,"list_priority":0},{"id":1820,"name":"行政大床房","hotel_id":"cntestyn01","list_price":858.0,"total_amount":0,"list_priority":0},{"id":1821,"name":"行政双床房","hotel_id":"cntestyn01","list_price":858.0,"total_amount":0,"list_priority":0},{"id":1822,"name":"高级套房","hotel_id":"cntestyn01","list_price":898.0,"total_amount":0,"list_priority":0},{"id":1823,"name":"商务套房","hotel_id":"cntestyn01","list_price":1188.0,"total_amount":0,"list_priority":0},{"id":1824,"name":"豪华套房","hotel_id":"cntestyn01","list_price":1288.0,"total_amount":0,"list_priority":0},{"id":1825,"name":"婚庆房","hotel_id":"cntestyn01","list_price":5988.0,"total_amount":0,"list_priority":0},{"id":1826,"name":"总统套房","hotel_id":"cntestyn01","list_price":11888.0,"total_amount":0,"list_priority":0}]},{"hotel_id":"cnbjbjcgyh","name":"罗盘广州店","email":"service@chinahotelsearch.com","fax":"010-82133391","phone":"010-82139949","mobile":"","zip":"100000","city_code":"510000","latitude":23.134166666666665,"longitude":113.27444444444444,"address":"广州市越秀区环市东路367号（广东电视台旁，临近世贸中心，友谊商店）","traffic_guide":"酒店矗立于广州市金融商务中心区，邻近世贸中心，周围高档写字楼集中、酒吧食肆林立，交通便利。\r\n- 距离广州北京路步行街4公里，乘坐出租车约10分钟；\r\n- 距离广州火车东站10公里，乘坐出租车约20分钟；\r\n- 距离广州火车站6公里，乘坐出租车约15分钟；\r\n- 距离广州新白云国际机场36公里，乘坐出租车约50分钟。 ","brief_intro":"罗盘广州店是广州市中心最知名的五星级商务酒店之一，细致、优质的服务、良好的口碑赢得了2010年中国饭店业的最高荣誉“中国饭店金星奖”。\r\n","detail_intro":"罗盘广州店是广州市中心最知名的五星级商务酒店之一，细致、优质的服务、良好的口碑赢得了2010年中国饭店业的最高荣誉“中国饭店金星奖”。\r\n宾馆矗立于广州黄金商务中心的环市东路，得天独厚的地理位置及近在咫尺的公共交通工具让您的行程更为方便、快捷。毗邻广州最奢华的国际品牌购物中心丽柏广场、友谊商店、世贸中心和缤纷精彩的知名风情酒吧街，让您在五分钟步程内领略现代化大都市的繁华与魅力。被评为“中国粤菜名店”最受客人欢迎的中餐厅－白云轩坐落于大堂左侧；位于30楼别具情调的西餐厅更是浪漫、幽雅。11间大小各异、配备先进视听设备的会议厅，更是各种商务会议和活动的首选。\r\n宾馆的楼群掩映在郁葱的“绿意”中，2000平方米的前庭花园，绿树成荫，在车水马龙的环市东路上，俨然“城中绿岛”。\r\n酒店开业时间1976年，楼高33层，客房总数588间（套）。\r\n","announce":"酒店预留房至18：00","brand":"","star":0,"priority":1000,"logo":"cnbjbjcgyh/logo_121122155116549.jpg","default_reserve_hour":24,"close_today_time":24,"allow_anonymous":true,"room_types":[{"id":1545,"name":"标单","hotel_id":"cnbjbjcgyh","list_price":278.0,"total_amount":0,"list_priority":0},{"id":1551,"name":"豪单","hotel_id":"cnbjbjcgyh","list_price":328.0,"total_amount":0,"list_priority":0},{"id":1547,"name":"豪双","hotel_id":"cnbjbjcgyh","list_price":368.0,"total_amount":0,"list_priority":0},{"id":1549,"name":"套房","hotel_id":"cnbjbjcgyh","list_price":488.0,"total_amount":0,"list_priority":0},{"id":1830,"name":"超级豪华别墅","hotel_id":"cnbjbjcgyh","list_price":888.0,"total_amount":0,"list_priority":0}]},{"hotel_id":"cnsccdjlhx","name":"罗盘海南店","email":"service@chinahotelsearch.com","fax":"010-82133391","phone":"010-82139949","mobile":"","zip":"610000","city_code":"570000","latitude":20.01527777777778,"longitude":110.34444444444443,"address":"海口市华兴上街17号","traffic_guide":"酒店位于滨海大道与玉沙路交汇处以西，与万绿园、海口体育馆隔路相望，位置优越。\r\n【前往酒店】：\r\n- 距离海口美兰国际机场24.7公里，乘坐出租车约40-45分钟；或由机场乘坐机场大巴至民航宾馆下，再换乘出租车约15分钟可达酒店；\r\n- 距离海口火车站20.1公里，乘坐出租车约35-40分钟；\r\n- 距离海口东站8.8公里，乘坐出租车约25分钟；\r\n- 距离海口新港轮渡码头3.7公里，乘坐出租车约10分钟。\r\n【酒店周边信息】：\r\n- 距离海口体育馆400米，步行约5分钟；\r\n- 距离万绿园800米，步行约10分钟；\r\n- 距离滨海公园1.7公里，乘坐出租车约5分钟；\r\n- 距离海南省人民大会堂1.6公里，乘坐出租车约5分钟；\r\n- 距离海口市人民政府2.5公里，乘坐出租车约5-10分钟。\r\n","brief_intro":"酒店位于海口市最具热带风情的滨海大道，凭海而立，面向芳草如茵的“万绿园”和壮丽的琼州海峡。","detail_intro":"海口宝华海景大酒店位于海口市最具热带风情的滨海大道，凭海而立，面向芳草如茵的“万绿园”和壮丽的琼州海峡。酒店作为海南省十佳旅游饭店和海口市首批旅游名牌饭店，是海南省唯一通过ISO9002、ISO14001双认证的四星级滨海商务酒店。\r\n酒店21米高的大堂按照中国传统风水学布局设计，独特的四棱锥玻璃穹顶明亮采光、气势恢弘。另外，风格各异的各类客（套）房任宾客选择。此外，酒店各餐饮场所为来自不同国家的宾客提供了不同风味的美食佳肴，已开发经营的有潮粤厅、咖啡厅、宫廷食府、泰餐厅、斯诺克酒吧等。为满足商务宾客的需求，酒店还提供了设施完善的多功能厅及多个专业会议室，可举办不同规模的会议、宴会及婚宴。最后，酒店还为宾客提供了齐备的康乐设施，如：KTV包厢、游泳池、桑拿按摩中心、美容美发中心、健身房、台球室等。酒店是宾馆旅游休闲、商务出差的理想之选。\r\n酒店开业时间1996年9月27日，2011年已进行全面大装修（9月已装修完成），楼高28层，客房总数418间（套）。\r\n","announce":"入住此酒店需另支付每人6元/天的政府调节基金。","brand":"","star":0,"priority":1000,"logo":"cnsccdjlhx/logo_121122155158531.jpg","default_reserve_hour":24,"close_today_time":24,"allow_anonymous":true,"room_types":[{"id":773,"name":"丽景双标","hotel_id":"cnsccdjlhx","list_price":1999.0,"total_amount":0,"list_priority":0},{"id":775,"name":"丽景大床","hotel_id":"cnsccdjlhx","list_price":1999.0,"total_amount":0,"list_priority":0},{"id":777,"name":"海景双标","hotel_id":"cnsccdjlhx","list_price":2999.0,"total_amount":0,"list_priority":0},{"id":779,"name":"海景大床","hotel_id":"cnsccdjlhx","list_price":2999.0,"total_amount":0,"list_priority":0}]}]}
			 */
		}

		/*
		 * get_rate_type_list	查看可用价格代码列表
		 */
		public function get_rate_type_list(){
			$url = $this->url . 'get_rate_type_list?' . $this->check_url;
			
			$res = doCurlGetRequest($url);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"rate_types":[{"rate_code":"159_A","name":"a","min_days":0,"advance_day":0},{"rate_code":"159_AAAA","name":"旅游节促销","min_days":0,"advance_day":0},{"rate_code":"159_ABCDE","name":"集团会员八折价","min_days":0,"advance_day":0},{"rate_code":"159_CJCXJ","name":"春节促销价","min_days":0,"advance_day":0},{"rate_code":"159_HYJ","name":"会员价","min_days":0,"advance_day":0},{"rate_code":"159_HYJG","name":"会员","min_days":0,"advance_day":0},{"rate_code":"159_JZBF","name":"铂金卡","min_days":0,"advance_day":0},{"rate_code":"159_LZT","name":"连住三天","min_days":0,"advance_day":0},{"rate_code":"159_TEST","name":"TEST","min_days":0,"advance_day":0},{"rate_code":"159_ZZK","name":"自尊卡价","min_days":0,"advance_day":0},{"rate_code":"COMPANY","name":"普通公司协议价","min_days":0,"advance_day":0},{"rate_code":"LIST","name":"门市价","min_days":0,"advance_day":0},{"rate_code":"TEAM","name":"普通团队价","min_days":0,"advance_day":0},{"rate_code":"USER","name":"网站注册会员价","min_days":0,"advance_day":0},{"rate_code":"WEB","name":"普通订房中心价","min_days":0,"advance_day":0}]}
			 */
		}

		/*
		 * get_card_type_list	查看可用会员卡类型列表
		 */
		public function get_card_type_list(){
			$url = $this->url . 'get_card_type_list?' . $this->check_url;
			
			$res = doCurlGetRequest($url);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"card_types":[{"card_type_id":"100121","name":"马瑞卡","rate_code":"WEB","is_for_register":false,"price":0.0,"rmb_per_score":1.0},{"card_type_id":"100187","name":"金卡(集团)","rate_code":"159_HYJ","is_for_register":false,"price":0.0,"rmb_per_score":0.1},{"card_type_id":"100242","name":"贵宾卡","rate_code":"WEB","is_for_register":false,"price":0.0,"rmb_per_score":0.0},{"card_type_id":"100276","name":"嘉宾卡 ","rate_code":"WEB","is_for_register":false,"price":0.0,"rmb_per_score":0.0},{"card_type_id":"100341","name":"公司卡","rate_code":"USER","is_for_register":false,"price":0.0,"rmb_per_score":1.0},{"card_type_id":"100484","name":"德加会员卡","rate_code":"USER","is_for_register":false,"price":0.0,"rmb_per_score":1.0},{"card_type_id":"100572","name":"维一卡","rate_code":"WEB","is_for_register":false,"price":0.0,"rmb_per_score":0.0},{"card_type_id":"100938","name":"金卡","rate_code":"159_HYJ","is_for_register":false,"price":0.0,"rmb_per_score":0.1},{"card_type_id":"101150","name":"商务卡","rate_code":"WEB","is_for_register":false,"price":0.0,"rmb_per_score":0.0},{"card_type_id":"101152","name":"商务卡","rate_code":"USER","is_for_register":false,"price":0.0,"rmb_per_score":0.0},{"card_type_id":"130418083540274652","name":"维信8.8折会员卡","rate_code":"LIST","is_for_register":false,"price":0.0,"rmb_per_score":2.0},{"card_type_id":"1150108151629886860","name":"星宫VIP卡","rate_code":"159_HYJ","is_for_register":false,"price":0.0,"rmb_per_score":1.0},{"card_type_id":"1150513114825997104","name":"会员卡","rate_code":"159_HYJ","is_for_register":false,"price":0.0,"rmb_per_score":0.0},{"card_type_id":"100847","name":"CRS测试卡","rate_code":"LIST","is_for_register":true,"price":10.0,"rmb_per_score":1.0},{"card_type_id":"101364","name":"好客卡","rate_code":"WEB","is_for_register":false,"price":10.0,"rmb_per_score":0.0},{"card_type_id":"101441","name":"好客卡","rate_code":"WEB","is_for_register":false,"price":10.0,"rmb_per_score":0.0},{"card_type_id":"100077","name":"网站注册卡","rate_code":"USER","is_for_register":false,"price":20.0,"rmb_per_score":0.0},{"card_type_id":"100198","name":"嘻嘻嘻","rate_code":"WEB","is_for_register":false,"price":20.0,"rmb_per_score":0.0},{"card_type_id":"100825","name":"英联酒店测试","rate_code":"COMPANY","is_for_register":false,"price":20.0,"rmb_per_score":0.0},{"card_type_id":"1480313","name":"会员卡","rate_code":"USER","is_for_register":false,"price":20.0,"rmb_per_score":0.1},{"card_type_id":"100286","name":"时尚布丁卡","rate_code":"WEB","is_for_register":false,"price":25.0,"rmb_per_score":0.0},{"card_type_id":"130402233707551779","name":"紫缇-如意卡","rate_code":"WEB","is_for_register":false,"price":29.0,"rmb_per_score":1.0},{"card_type_id":"1140620001125613013","name":"yuyu","rate_code":"WEB","is_for_register":false,"price":50.0,"rmb_per_score":1.0},{"card_type_id":"100055","name":"如家忠诚卡","rate_code":"WEB","is_for_register":false,"price":55.0,"rmb_per_score":0.03},{"card_type_id":"100165","name":"GRACE卡","rate_code":"WEB","is_for_register":false,"price":55.0,"rmb_per_score":0.0},{"card_type_id":"100253","name":"精致卡","rate_code":"WEB","is_for_register":false,"price":55.0,"rmb_per_score":0.03},{"card_type_id":"101518","name":"新疆会员卡","rate_code":"WEB","is_for_register":false,"price":100.0,"rmb_per_score":0.0},{"card_type_id":"130225042456116080","name":"茉莉花开云联卡","rate_code":"LIST","is_for_register":false,"price":188.0,"rmb_per_score":0.0},{"card_type_id":"1140613110743169406","name":"云联卡","rate_code":"WEB","is_for_register":false,"price":188.0,"rmb_per_score":0.1},{"card_type_id":"1151103111144564959","name":"宝悦钻石卡","rate_code":"159_ZZK","is_for_register":false,"price":188.0,"rmb_per_score":0.2},{"card_type_id":"100220","name":"储值卡","rate_code":"COMPANY","is_for_register":false,"price":500.0,"rmb_per_score":1.0},{"card_type_id":"1150130104103275061","name":"e额外认为","rate_code":"USER","is_for_register":true,"price":1801.0,"rmb_per_score":10.0},{"card_type_id":"100243","name":"星星卡","rate_code":"159_HYJ","is_for_register":false,"price":2000.0,"rmb_per_score":0.0},{"card_type_id":"100627","name":"金卡A","rate_code":"WEB","is_for_register":false,"price":3000.0,"rmb_per_score":0.0}]}
			 */
		}

		/*
		 * get_room_infos	查看酒店房间信息
		 */
		public function get_room_infos(){
			$url = $this->url . 'get_room_infos?' . $this->check_url;
			
			$data = array(
				"hotel_id" => "cnbjbjcgmz"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"room_infos":[{"room_id":20085,"room_no":"#101","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20083,"room_no":"#102","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20081,"room_no":"#103","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20079,"room_no":"#104","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20077,"room_no":"#105","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20075,"room_no":"#106","room_type_id":1325,"room_type_name":"标大","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20073,"room_no":"#107","room_type_id":1593,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"豪华大床房"},{"room_id":20071,"room_no":"#108","room_type_id":1593,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20069,"room_no":"#109","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20067,"room_no":"#110","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20063,"room_no":"#112","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20051,"room_no":"#119","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20087,"room_no":"#125","room_type_id":1591,"room_type_name":"行政双床","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20045,"room_no":"122","room_type_id":1451,"room_type_name":"商务套","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20043,"room_no":"123","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":18597,"room_no":"132","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20133,"room_no":"133","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":18571,"room_no":"134","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":18517,"room_no":"135","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":18985,"room_no":"136","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":19479,"room_no":"137","room_type_id":1591,"room_type_name":"行政双床","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":19923,"room_no":"138","room_type_id":1591,"room_type_name":"行政双床","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20917,"room_no":"139","room_type_id":1591,"room_type_name":"行政双床","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":18987,"room_no":"140","room_type_id":1591,"room_type_name":"行政双床","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":8319,"room_no":"141","room_type_id":1591,"room_type_name":"行政双床","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":8321,"room_no":"142","room_type_id":1591,"room_type_name":"行政双床","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":8323,"room_no":"143","room_type_id":1325,"room_type_name":"标大","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":8325,"room_no":"144","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":8327,"room_no":"145","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":8329,"room_no":"146","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":8331,"room_no":"147","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":8333,"room_no":"148","room_type_id":1325,"room_type_name":"标大","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":8335,"room_no":"149","room_type_id":1325,"room_type_name":"标大","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":21813,"room_no":"150","room_type_id":1325,"room_type_name":"标大","room_building_name":"A区","room_floor_name":"一层","room_direction_name":"- "},{"room_id":20499,"room_no":"201","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"- "},{"room_id":20411,"room_no":"202","room_type_id":1327,"room_type_name":"行政大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20413,"room_no":"203","room_type_id":1327,"room_type_name":"行政大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20415,"room_no":"204","room_type_id":1327,"room_type_name":"行政大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20417,"room_no":"205","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20419,"room_no":"206","room_type_id":1589,"room_type_name":"行政套","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20421,"room_no":"207","room_type_id":1327,"room_type_name":"行政大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20423,"room_no":"208","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20425,"room_no":"209","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20427,"room_no":"210","room_type_id":1327,"room_type_name":"行政大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20429,"room_no":"211","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20431,"room_no":"212","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"永州风"},{"room_id":20433,"room_no":"214","room_type_id":1327,"room_type_name":"行政大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20435,"room_no":"215","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20437,"room_no":"216","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20439,"room_no":"217","room_type_id":1589,"room_type_name":"行政套","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20441,"room_no":"218","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20443,"room_no":"219","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20445,"room_no":"220","room_type_id":1327,"room_type_name":"行政大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20447,"room_no":"221","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20449,"room_no":"222","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20451,"room_no":"223","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20453,"room_no":"224","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20455,"room_no":"225","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20457,"room_no":"226","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20459,"room_no":"227","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"南宁风"},{"room_id":20461,"room_no":"228","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"川蜀风"},{"room_id":20463,"room_no":"229","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"川蜀风"},{"room_id":20465,"room_no":"230","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"川蜀风"},{"room_id":20467,"room_no":"231","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"川蜀风"},{"room_id":20469,"room_no":"232","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"川蜀风"},{"room_id":20471,"room_no":"233","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"川蜀风"},{"room_id":20473,"room_no":"234","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"川蜀风"},{"room_id":20475,"room_no":"235","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"川蜀风"},{"room_id":20477,"room_no":"236","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#2层","room_direction_name":"川蜀风"},{"room_id":20479,"room_no":"237","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":20481,"room_no":"238","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":20483,"room_no":"239","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":20485,"room_no":"240","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":20487,"room_no":"241","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":20489,"room_no":"242","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":20491,"room_no":"243","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":20493,"room_no":"244","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":20495,"room_no":"245","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":20497,"room_no":"246","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":21219,"room_no":"247","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":21217,"room_no":"248","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":18513,"room_no":"249","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":18515,"room_no":"250","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":18501,"room_no":"251","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":8337,"room_no":"252","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":8339,"room_no":"253","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":8341,"room_no":"254","room_type_id":1325,"room_type_name":"标大","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":8343,"room_no":"255","room_type_id":1323,"room_type_name":"标准双床房","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":18539,"room_no":"256","room_type_id":1327,"room_type_name":"行政大","room_building_name":"B区","room_floor_name":"2#3层","room_direction_name":"三亚风"},{"room_id":22183,"room_no":"261","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22185,"room_no":"262","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22187,"room_no":"263","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22189,"room_no":"265","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22191,"room_no":"266","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22193,"room_no":"267","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22195,"room_no":"268","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22197,"room_no":"269","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22199,"room_no":"270","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22201,"room_no":"271","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22203,"room_no":"272","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22205,"room_no":"273","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22207,"room_no":"275","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22209,"room_no":"276","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22211,"room_no":"277","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22213,"room_no":"278","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22215,"room_no":"279","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22217,"room_no":"280","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"},{"room_id":22219,"room_no":"281","room_type_id":1321,"room_type_name":"商务双床房","room_building_name":"A区","room_floor_name":"1#3层","room_direction_name":"桃花缘"}]}
			 */
		}

		/*
		 * get_hotel_payment_list	获取酒店开通的付款方式
		 */
		public function get_hotel_payment_list(){
			$url = $this->url . 'get_hotel_payment_list?' . $this->check_url;
			
			$data = array(
				"hotel_id" => "cnbjbjcgmz"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"payments":[{"payment_id":0},{"payment_id":3,"payment_notice":"yyyy"},{"payment_id":7,"payment_notice":"zzzz"}]}
			 */
		}

		/*
		 * get_rate_promotion_list	获取酒店或集团可用的促销套餐列表
		 */
		public function get_rate_promotion_list(){
			$url = $this->url . 'get_rate_promotion_list?' . $this->check_url;
		
			$res = doCurlGetRequest($url);
			var_dump(json_decode($res,TRUE));
			/*
			 * 返回的信息：
			 * [{"hotelgroup_id":"159","name":"会员首次入住，入住1天送1天","room_code":"","rate_code":"LIST","first_check":true,"min_days":2,"max_days":999,"max_quantity":99,"need_member":true,"relative":false,"allotment":9999,"brand":"","exclude_room_codes":"","use_interval":20000,"use_for_order":true,"use_for_register":true,"start_clock":0,"end_clock":2400,"min_advance":0,"max_advance":999,"biz_source_ids":"#13#","rate_promotion_items":[{"rate_promotion_id":7,"day_index":1,"room_rate":0.0,"rate_ratio":100.0,"rate_bias":0.0,"should_round":false,"avoid_four":false,"id":11}],"id":7},{"hotelgroup_id":"159","name":"2222","room_code":"","first_check":true,"min_days":0,"max_days":999,"max_quantity":99,"need_member":true,"relative":false,"allotment":9999,"exclude_room_codes":"","use_interval":20000,"use_for_order":true,"use_for_register":true,"start_clock":0,"end_clock":2400,"min_advance":0,"max_advance":999,"rate_promotion_items":[{"rate_promotion_id":9,"day_index":0,"room_rate":99.0,"rate_ratio":100.0,"rate_bias":0.0,"should_round":false,"avoid_four":false,"id":13}],"id":9},{"hotelgroup_id":"159","name":"连住两晚","room_code":"","rate_code":"WEB","first_check":false,"min_days":2,"max_days":999,"max_quantity":99,"need_member":false,"relative":false,"allotment":9999,"exclude_room_codes":"","use_interval":0,"use_for_order":true,"use_for_register":true,"start_clock":0,"end_clock":2400,"min_advance":0,"max_advance":999,"rate_promotion_items":[{"rate_promotion_id":181,"day_index":1,"room_rate":0.0,"rate_ratio":100.0,"rate_bias":0.0,"should_round":false,"avoid_four":false,"id":670},{"rate_promotion_id":181,"day_index":0,"room_rate":100.0,"rate_ratio":100.0,"rate_bias":0.0,"should_round":false,"avoid_four":false,"id":297}],"id":181},{"hotelgroup_id":"159","name":"首晚入住99元","room_code":"","first_check":false,"min_days":1,"max_days":1,"max_quantity":1,"need_member":true,"relative":false,"allotment":9999,"exclude_room_codes":"","use_interval":0,"use_for_order":true,"use_for_register":true,"start_clock":0,"end_clock":2400,"min_advance":0,"max_advance":999,"disabled_payment_ids":"#3#7#","rate_promotion_items":[{"rate_promotion_id":203,"day_index":0,"room_rate":99.0,"rate_ratio":100.0,"rate_bias":0.0,"should_round":false,"avoid_four":false,"id":485}],"id":203},{"hotelgroup_id":"159","name":"erwerwerw","room_code":"","first_check":false,"min_days":0,"max_days":999,"max_quantity":99,"need_member":false,"relative":false,"allotment":9999,"exclude_room_codes":"","use_interval":0,"use_for_order":true,"use_for_register":true,"start_clock":0,"end_clock":2400,"min_advance":0,"max_advance":999,"rate_promotion_items":[],"id":327},{"hotelgroup_id":"159","name":"住三送一","room_code":"","first_check":true,"min_days":0,"max_days":999,"max_quantity":99,"need_member":true,"relative":false,"allotment":9999,"brand":"","card_type_ids":"#100187#","exclude_room_codes":"","use_interval":0,"use_for_order":true,"use_for_register":true,"start_clock":0,"end_clock":2400,"min_advance":0,"max_advance":999,"biz_source_ids":"#10#","disabled_payment_ids":"#0#","rate_promotion_items":[],"id":394}]
			 */
		}

		/*
		 * create_order	创建订单 (下单时需要带上联系方式，否则将无法取消订单)
		 */
		public function create_order(){
			$url = $this->url . 'create_order?' . $this->check_url;
			
			$data = array(
				"order.room_order_id"=>"",
				"order.hotel_id"=>"cnhnldmlcq",
				"order.currency_code"=>"",
				"order.exchange_rate"=>"1.0",
				"order.room_type_id"=>"7297",
				"order.room_quantity"=>"1",
				"order.adult_quantity"=>"2",
				"order.child_quantity"=>"0",
				"order.check_in_date"=>"2016-01-10",
				"order.check_out_date"=>"2016-01-11",
				"order.rate_code"=>"LIST",
				"order.total_order_money"=>"100.0",
				"order.total_score"=>"0.0",
				"order.contacter"=>"hong",
				"order.mobile"=>"",
				"order.email"=>"",
				"order.phone"=>"",
				"order.fax"=>"",
				"order.note"=>"",
				"order.payment_mode_id"=>"",
				"order.arrive_info"=>"",
				"order.earliest_arrive"=>"",
				"order.latest_arrive"=>"",
				"order.card_type_id"=>"103630",
				"order.card_no"=>"50005409",
				"order.voucher_type_id"=>"",
				"order.voucher_no"=>"",
				"order.voucher_count"=>"",
				"order.reserve_hour"=>"",
				"order.guarantee_score"=>"",
				"order.biz_source_id"=>"13",
				"order.rate_promotion_id"=>"",
				"order.ip"=>"",
				"order.referer_url"=>"",
				"order.custom_price"=>"2016-01-10#100"//格式：{日期}#{房价}|{日期}#{房价}，例如2008-09-08#99f|2008-09-09#528|2008-09-10#528
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"exception_code":"error.order.wrong_price","exception_description":"房价已变化"}
			   {"room_order_id":"O1601041010579040194S"}
			 */
		}

		/*
		 * 3.12 根据订单号查询订单 get_order_by_ids
		 */
		public function get_order_by_ids(){
			$url = $this->url . 'get_order_by_ids?' . $this->check_url;
			
			$data = array(
				"order_ids" => "O1601041010579040194S"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"orders":[{"room_order_id":"O1601041010579040194S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":100.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":0,"status_desc":"入住前","ip":"","biz_source_id":13,"created_at":"2016-01-04 10:10:57","total_score":0.0,"room_nos":"","voucher_count":1}]}
			 */
		}


		/*
		 * cancel_order	取消订单
		 */
		public function cancel_order(){
			$url = $this->url . 'cancel_order?' . $this->check_url;
			
			$data = array(
				"room_order_id" => "O1601041010579040194S",
				"mobile_or_email" => "18607314524",
				"cancel_reason" => "测试"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"room_order_id":"O1601041010579040194S"}
			 */
		}

		/*
		 * get_order_detail	查看订单详情
		 */
		public function get_order_detail(){
			$url = $this->url . 'get_order_detail?' . $this->check_url;
			
			$data = array(
				"room_order_id" => "O1601041010579040194S",
				"mobile_or_email" => "13466726411"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"order":{"room_order_id":"O1601041010579040194S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":100.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":0,"status_desc":"入住前","ip":"","biz_source_id":13,"created_at":"2016-01-04 10:10:57","total_score":0.0,"room_nos":"","voucher_count":1}}
			 */
		}

		/*
		 * 获取会员卡订单列表	get_card_orders
		 */
		public function get_card_orders(){
			$url = $this->url . 'get_card_orders?' . $this->check_url;
			$data = array(
				"card_no" => "50005409",
				"card_type_id" => "103630",
				"order_status" => "",
				"should_paid" => ""
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"orders":[{"room_order_id":"O1601041010579040194S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":100.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":0,"status_desc":"入住前","ip":"","biz_source_id":13,"created_at":"2016-01-04 10:10:57","total_score":0.0,"room_nos":"","voucher_count":1},{"room_order_id":"O1512291708451546707S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":100.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"原因:测试;","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":3,"status_desc":"取消","ip":"","biz_source_id":13,"created_at":"2015-12-29 17:08:45","total_score":0.0,"room_nos":"","voucher_count":1},{"room_order_id":"O1512291708046647373S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":100.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"原因:系统 测试;","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":3,"status_desc":"取消","ip":"","biz_source_id":13,"created_at":"2015-12-29 17:08:04","total_score":0.0,"room_nos":"","voucher_count":1},{"room_order_id":"O1512291705325470810S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":159.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"原因:测试;","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":3,"status_desc":"取消","ip":"","biz_source_id":13,"created_at":"2015-12-29 17:05:32","total_score":0.0,"room_nos":"","voucher_count":1},{"room_order_id":"O1512291701474627290S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":159.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"原因:测试 系统;","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":3,"status_desc":"取消","ip":"","biz_source_id":13,"created_at":"2015-12-29 17:01:47","total_score":0.0,"room_nos":"","voucher_count":1},{"room_order_id":"O1512291641216705908S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":159.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"原因:测试 ;","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":3,"status_desc":"取消","ip":"","biz_source_id":5,"created_at":"2015-12-29 16:41:21","total_score":0.0,"room_nos":"","voucher_count":1}]}
			 */
		}

		/*
		 * 3.4 通知订单付款成功 deposit_order
		 */
		public function deposit_order(){
			$url = $this->url . 'deposit_order?' . $this->check_url;			
			$data = array(
				"deposit_account.room_order_id" => "O1601041010579040194S",
				"deposit_account.money" => "100",
				"deposit_account.prepaid_source_code" => "123123123",
				"deposit_account.note" => "test",
				"deposit_account.payment_seq" => "123123123"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"room_order_id":"O1601041010579040194S"}
			 */
		}


		/*
		 * 查询待入住订单	get_order_by_date
		 */
		public function get_order_by_date(){
			$url = $this->url . 'get_order_by_date?' . $this->check_url;
			$data = array(
				"mobile_or_email" => "13466726411",
				"check_in_date" => "2016-01-10"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"orders":[]}
			 */
		}

		/*
		 * 3.6 储值卡支付订单 card_deposit_pay_order
		 */
		public function card_deposit_pay_order(){
			$url = $this->url . 'card_deposit_pay_order?' . $this->check_url;
			$data = array(
				"room_order_id" => "O1601041010579040194S",
				"deposit" => "100",
				"card_no" => "50005409",
				"card_type_id" => "103630",
				"consume_password" => "123123123",
				"reserve_hour" => "2016-01-09"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"exception_code":"error.card.not_enough_deposit","exception_description":"会员卡余额不足"}
			 */
		}

		/*
		 * 3.7 会员卡积分支付订单 card_score_pay_order
		 */
		public function card_score_pay_order(){
			$url = $this->url . 'card_score_pay_order?' . $this->check_url;
			$data = array(
				"room_order_id" => "O1601041010579040194S",
				"deposit" => "100",
				"card_no" => "50005409",
				"card_type_id" => "103630",
				"score" => "10",
				"password" => "123123",
				"reserve_hour" => "2016-01-09"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"exception_code":"error.card.not_enough_deposit","exception_description":"会员卡余额不足"}
			 */
		}

		/*
		 * 3.8 查询可用房间列表 get_avail_rooms
		 */
		public function get_avail_rooms(){
			$url = $this->url . 'get_avail_rooms?' . $this->check_url;
			$data = array(
				"room_type_id" => "7297",
				"check_in_date" => "2016-01-10",
				"check_out_date" => "2016-01-11"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"room_infos":[{"room_id":96389,"room_no":"9307","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"3","room_direction_name":"`"},{"room_id":96411,"room_no":"9319","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"3","room_direction_name":"`"},{"room_id":96413,"room_no":"9320","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"3","room_direction_name":"`"},{"room_id":96417,"room_no":"9322","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"3","room_direction_name":"`"},{"room_id":96419,"room_no":"9323","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"3","room_direction_name":"`"},{"room_id":96421,"room_no":"9325","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"3","room_direction_name":"`"},{"room_id":96437,"room_no":"9407","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"4","room_direction_name":"`"},{"room_id":96461,"room_no":"9419","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"4","room_direction_name":"`"},{"room_id":96463,"room_no":"9420","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"4","room_direction_name":"`"},{"room_id":96467,"room_no":"9422","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"4","room_direction_name":"`"},{"room_id":96469,"room_no":"9423","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"4","room_direction_name":"`"},{"room_id":96473,"room_no":"9425","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"4","room_direction_name":"`"},{"room_id":96485,"room_no":"9506","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"5","room_direction_name":"`"},{"room_id":96507,"room_no":"9518","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"5","room_direction_name":"`"},{"room_id":96509,"room_no":"9519","room_type_id":7297,"room_type_name":"迷你时空B","room_building_name":"主楼","room_floor_name":"5","room_direction_name":"`"}]}
			 */
		}

		/*
		 * 3.9 分配订单预留房房间号 assign_order_rooms
		 */
		public function assign_order_rooms(){
			$url = $this->url . 'assign_order_rooms?' . $this->check_url;
			$data = array(
				"room_order_id" => "O1601041010579040194S",
				"room_ids" => "7297"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"room_order_id":"O1601041010579040194S"}
			 */
		}

		/*
		 * 3.10 重新分配订单预留房房间号 reassign_order_rooms
		 */
		public function reassign_order_rooms(){
			$url = $this->url . 'reassign_order_rooms?' . $this->check_url;
			$data = array(
				"room_order_id" => "O1601041010579040194S",
				"room_ids" => "7297"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"room_order_id":"O1601041010579040194S"}
			 */
		}

		/*
		 * 3.11 搜索订单列表 search_orders
		 */
		public function search_orders(){
			$url = $this->url . 'search_orders?' . $this->check_url;
			$data = array(
				"condition.card_no" => "50005409",
				"condition.card_type_id" => "103630",
				"condition.order_status" => "",
				"condition.hotel_id" => "cnhnldmlcq",
				"condition.start_check_in" => "2016-01-10",
				"condition.end_check_in" => "2016-01-11",
				"condition.page" => "1",
				"condition.page_size" => "10"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"orders":[{"room_order_id":"O1601041010579040194S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":100.0,"total_order_money":100.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"test","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":24,"guarantee_score":0.0,"order_status":0,"status_desc":"入住前","ip":"","biz_source_id":13,"created_at":"2016-01-04 10:10:57","total_score":0.0,"room_nos":"","voucher_count":1},{"room_order_id":"O1512291708451546707S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":100.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"原因:测试;","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":3,"status_desc":"取消","ip":"","biz_source_id":13,"created_at":"2015-12-29 17:08:45","total_score":0.0,"room_nos":"","voucher_count":1},{"room_order_id":"O1512291708046647373S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":100.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"原因:系统 测试;","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":3,"status_desc":"取消","ip":"","biz_source_id":13,"created_at":"2015-12-29 17:08:04","total_score":0.0,"room_nos":"","voucher_count":1},{"room_order_id":"O1512291705325470810S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":159.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"原因:测试;","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":3,"status_desc":"取消","ip":"","biz_source_id":13,"created_at":"2015-12-29 17:05:32","total_score":0.0,"room_nos":"","voucher_count":1},{"room_order_id":"O1512291701474627290S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":159.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"原因:测试 系统;","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":3,"status_desc":"取消","ip":"","biz_source_id":13,"created_at":"2015-12-29 17:01:47","total_score":0.0,"room_nos":"","voucher_count":1},{"room_order_id":"O1512291641216705908S","hotel_id":"cnhnldmlcq","hotel_name":"莫林长青店","currency_code":"","exchange_rate":1.0,"room_type_id":7297,"room_type_code":"迷你时空B","room_type_name":"迷你时空B","room_quantity":1,"adult_quantity":2,"child_quantity":0,"check_in_date":"2016-01-10","check_out_date":"2016-01-11","rate_code":"LIST","discount":0.0,"prepaid":0.0,"total_order_money":159.0,"contacter":"hong","email":"","mobile":"","phone":"","fax":"","note":"原因:测试 ;","payment_mode_id":0,"arrive_info":"","card_type_id":"103630","card_no":"50005409","reserve_hour":18,"guarantee_score":0.0,"order_status":3,"status_desc":"取消","ip":"","biz_source_id":5,"created_at":"2015-12-29 16:41:21","total_score":0.0,"room_nos":"","voucher_count":1}]}
			 */
		}

		/*
		 * 3.13 电子券支付订单 voucher_pay_order
		 */
		public function voucher_pay_order(){
			$url = $this->url . 'voucher_pay_order?' . $this->check_url;
			$data = array(
				"room_order_id" => "O1601041010579040194S",
				"voucher_no" => "123123123",
				"voucher_type_id" => "123",
				"voucher_count" => "1",
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"exception_code":"error.voucher.wrong_voucher_type_id","exception_description":"非法电子券类型"}
			 */
		}
/********************************************************************************************************************************/
		/*
		 * 注册会员卡	register_card
		 */
		public function register_card(){
			$url = $this->url . 'register_card?' . $this->check_url;
			$data = array(
				// "card.card_type_id"=>"",
				"card.card_no"=>"",
				"card.password"=>"123123",
				"card.consume_password"=>"123123123",
				"card.user_name"=>"hong",
				"card.gender"=>"男",
				"card.id_card_type_id"=>"11",
				"card.id_card_no"=>"520520520520520",
				"card.email"=>"",
				"card.mobile"=>"",
				"card.phone"=>"",
				"card.fax"=>"",
				"card.address"=>"",
				"card.zip"=>"",
				"card.company"=>"",
				"card.company_address"=>"",
				"card.birth_date"=>"",
				"card.marry_day"=>"",
				"card.note"=>"",
				"card.is_actived"=>"false",
				"card.binding_qq"=>"",
				"card.binding_weixin"=>"",
				"card.binding_sina_weibo"=>""
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"card_id":123499054,"card_type_id":"100847","card_no":"1266","rate_code":"LIST","deposit":0.0,"card_score":0.0}
			 * 
			 */
		}

		/*
		 * 卡激活	active_card
		 */
		public function active_card(){
			$url = $this->url . 'active_card?' . $this->check_url;
			
			$data = array(
				"card_type_id" => "100847",
				"card_no" => "1266"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"card_id":123499054,"card_type_id":"100847","card_no":"1266","rate_code":"LIST","deposit":0.0,"card_score":0.0}
			 * {"exception_code":"error.card.has_actived","exception_description":"会员卡已激活"}
			 */
		}

		/*
		 * 会员卡登录	card_login
		 */
		public function card_login(){
			$url = $this->url . 'card_login?' . $this->check_url;
			
			$data = array(
				"card_no" => "1266",
				"password" => "123123"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"login_result":0,"card":{"hotelgroup_id":"159","owner_name":"北京酒店连锁","card_type_id":"100847","card_type_name":"CRS测试卡","card_no":"1266","rate_code":"LIST","rate_type_name":"门市价","password":"4297f44b13955235245b2497399d7a93","consume_password":"123123123","deposit":0.0,"card_score":0.0,"user_name":"hong","id_card_type_id":11,"id_card_no":"520520520520520","email":"","mobile":"","phone":"","fax":"","address":"","zip":"","company":"","company_address":"","birth_date":"1952-05-20","is_actived":true,"active_time":"2015-12-17 11:33:54","last_modify_time":"2015-12-17 11:33:54","note":"","total_checks":0,"total_room_nights":0,"total_review_count":0,"binding_qq":"","binding_weixin":"","binding_sina_weibo":"","locale":"zh_CN","disabled":false,"flag":0}}
			 */
		}	

		/*
		 * 修改会员卡信息	modify_card_profile
		 */
		public function modify_card_profile(){
			$url = $this->url . 'modify_card_profile?' . $this->check_url;
			
			$data = array(
				"card.card_type_id"=>"100847",
				"card.card_no"=>"1266",
				"card.user_name"=>"hong",
				"card.gender"=>"",
				"card.id_card_type_id"=>"11",
				"card.id_card_no"=>"520520520520520",
				"card.email"=>"",
				"card.mobile"=>"13580506405",
				"card.phone"=>"",
				"card.fax"=>"",
				"card.address"=>"",
				"card.zip"=>"",
				"card.company"=>"",
				"card.company_address"=>"",
				"card.birth_date"=>"",
				"card.marry_day"=>""
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"card_id":123499054,"card_type_id":"100847","card_no":"1266","rate_code":"LIST","deposit":0.0,"card_score":0.0}
			 */
		}	

		/*
		 * 查看会员卡详情	get_card_detail
		 */
		public function get_card_detail(){
			$url = $this->url . 'get_card_detail?' . $this->check_url;
			
			$data = array(
				"card_type_id"=>"100847",
				"card_no"=>"1266"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"card":{"hotelgroup_id":"159","owner_name":"北京酒店连锁","card_type_id":"100847","card_type_name":"CRS测试卡","card_no":"1266","rate_code":"LIST","rate_type_name":"门市价","password":"4297f44b13955235245b2497399d7a93","consume_password":"123123123","deposit":0.0,"card_score":0.0,"user_name":"hong","id_card_type_id":11,"id_card_no":"520520520520520","email":"","mobile":"13580506405","phone":"","fax":"","address":"","zip":"","company":"","company_address":"","birth_date":"1952-05-20","is_actived":true,"active_time":"2015-12-17 11:33:54","last_modify_time":"2015-12-17 11:47:43","note":"","total_checks":0,"total_room_nights":0,"total_review_count":0,"binding_qq":"","binding_weixin":"","binding_sina_weibo":"","locale":"zh_CN","disabled":false,"flag":0}}
			 */
		}	

		/*
		 * 查看会员卡客史	list_card_check_records
		 */
		public function list_card_check_records(){
			$url = $this->url . 'list_card_check_records?' . $this->check_url;
			
			$data = array(
				"condition.card_type_id"=>"100847",
				"condition.card_no"=>"1266",
				"condition.room_order_id"=>"",
				"condition.hotel_id"=>"",
				"condition.start_date"=>"",
				"condition.end_date"=>"",
				"condition.order_type"=>"",
				"condition.page"=>"",
				"condition.page_size"=>""
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"histories":[]}
			 */
		}	

		/*
		 * 修改会员卡密码	modify_card_password
		 */
		public function modify_card_password(){
			$url = $this->url . 'modify_card_password?' . $this->check_url;
			
			$data = array(
				"card_type_id"=>"100847",
				"card_no"=>"1266",
				"password"=>"123123",
				"new_password"=>"123"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"card_id":123499054,"card_type_id":"100847","card_no":"1266","rate_code":"LIST","deposit":0.0,"card_score":0.0}
			 */
		}

		/*
		 * 修改储值卡消费密码	modify_card_consume_password
		 */
		public function modify_card_consume_password(){
			$url = $this->url . 'modify_card_consume_password?' . $this->check_url;
			
			$data = array(
				"card_type_id"=>"100847",
				"card_no"=>"1266",
				"password"=>"123",
				"new_consume_password"=>"123"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"card_id":123499054,"card_type_id":"100847","card_no":"1266","rate_code":"LIST","deposit":0.0,"card_score":0.0}
			 */
		}	

		/*
		 * 查看会员卡积分操作日志	list_card_score_logs
		 */
		public function list_card_score_logs(){
			$url = $this->url . 'list_card_score_logs?' . $this->check_url;
			
			$data = array(
				"condition.card_type_id"=>"100847",
				"condition.card_no"=>"1266",
				"condition.start_date"=>"2015-12-15",
				"condition.end_date"=>"2015-12-16",
				"condition.page"=>"0",
				"condition.page_size"=>"3"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"logs":[]}
			 */
		}	

		/*
		 * 查看储值卡消费日志	list_card_deposit_logs
		 */
		public function list_card_deposit_logs(){
			$url = $this->url . 'list_card_deposit_logs?' . $this->check_url;
			
			$data = array(
				"condition.card_type_id"=>"100847",
				"condition.card_no"=>"1266",
				"condition.start_date"=>"2015-12-15",
				"condition.end_date"=>"2015-12-16",
				"condition.page"=>"0",
				"condition.page_size"=>"3"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"logs":[]}
			 */
		}

		/*
		 * 修改会员卡积分	modify_card_score
		 */
		public function modify_card_score(){
			$url = $this->url . 'modify_card_score?' . $this->check_url;
			
			$data = array(
				"card_type_id"=>"100847",
				"card_no"=>"1266",
				"score"=>"19000",
				"note"=>""
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"card_id":123499054,"card_type_id":"100847","card_no":"1266","rate_code":"LIST","deposit":1.0,"card_score":22000.0}
			 */
		}

		/*
		 * 查询会员卡	query_cards
		 */
		public function query_cards(){
			$url = $this->url . 'query_cards?' . $this->check_url;
			
			$data = array(
				"condition.user_name"=>"hong",
				"condition.mobile"=>"",
				"condition.birthday"=>"",
				"condition.phone"=>"",
				"condition.card_no"=>"1266"
			);
			
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"cards":[{"hotelgroup_id":"159","owner_name":"北京酒店连锁","card_type_id":"100847","card_type_name":"CRS测试卡","card_no":"1266","rate_code":"LIST","rate_type_name":"门市价","password":"202cb962ac59075b964b07152d234b70","consume_password":"123","deposit":0.0,"card_score":100.0,"user_name":"hong","id_card_type_id":11,"id_card_no":"520520520520520","email":"","mobile":"13580506405","phone":"","fax":"","address":"","zip":"","company":"","company_address":"","birth_date":"1952-05-20","is_actived":true,"active_time":"2015-12-17 11:33:54","last_modify_time":"2015-12-17 12:59:15","note":"","total_checks":0,"total_room_nights":0,"total_review_count":0,"binding_qq":"","binding_weixin":"","binding_sina_weibo":"","locale":"zh_CN","disabled":false,"flag":0},{"hotelgroup_id":"159","owner_name":"北京酒店连锁","card_type_id":"100847","card_type_name":"CRS测试卡","card_no":"1267","rate_code":"LIST","rate_type_name":"门市价","password":"4297f44b13955235245b2497399d7a93","consume_password":"123123123","deposit":0.0,"card_score":0.0,"user_name":"hong","id_card_type_id":11,"id_card_no":"520520520520520","email":"","mobile":"","phone":"","fax":"","address":"","zip":"","company":"","company_address":"","birth_date":"1952-05-20","is_actived":false,"last_modify_time":"2015-12-17 11:39:55","note":"","total_checks":0,"total_room_nights":0,"total_review_count":0,"binding_qq":"","binding_weixin":"","binding_sina_weibo":"","locale":"zh_CN","disabled":false,"flag":0},{"hotelgroup_id":"159","owner_name":"北京酒店连锁","card_type_id":"100847","card_type_name":"CRS测试卡","card_no":"1268","rate_code":"LIST","rate_type_name":"门市价","password":"4297f44b13955235245b2497399d7a93","consume_password":"123123123","deposit":0.0,"card_score":0.0,"user_name":"hong","id_card_type_id":11,"id_card_no":"520520520520520","email":"","mobile":"","phone":"","fax":"","address":"","zip":"","company":"","company_address":"","birth_date":"1952-05-20","is_actived":false,"last_modify_time":"2015-12-17 11:40:21","note":"","total_checks":0,"total_room_nights":0,"total_review_count":0,"binding_qq":"","binding_weixin":"","binding_sina_weibo":"","locale":"zh_CN","disabled":false,"flag":0}]}
			 */
		}

		/*
		 * 重置会员卡密码	reset_card_password
		 */
		public function reset_card_password(){
			$url = $this->url . 'reset_card_password?' . $this->check_url;
			$data = array(
				"card_no"=>"1266",
				"id_card_no"=>"520520520520520",
				"mobile"=>"13580506405"
			);
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * Oops, an error occured:This exception has been logged with id 6oena2cj9.
			 */
		}

		/*
		 * 获取会员电子劵列表 get_card_vouchers
		 */
		public function get_card_vouchers(){
			$url = $this->url . 'get_card_vouchers?' . $this->check_url;
			$data = array(
				"card_type_id"=>"100847",
				"card_no"=>"1266"
			);
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"vouchers":[]}
			 */
		}

		/*
		 * 删除帐号绑定	delete_card_binding
		 */
		public function delete_card_binding(){
			$url = $this->url . 'delete_card_binding?' . $this->check_url;
			$data = array(
				"card_type_id"=>"100847",
				"card_no"=>"1266",
				"binding_type"=>"645030813"
			);
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {}
			 */
		}

		/*
		 * 会员卡储值	deposit_card
		 */
		public function deposit_card(){
			$url = $this->url . 'deposit_card?' . $this->check_url;
			$data = array(
				"card_type_id"=>"100847",
				"card_no"=>"1266",
				"payment.money"=>"-10",
				"payment.prepaid_source_code"=>"001",
				"payment.payment_seq"=>"1231231231",
				"payment.note"=>"",
			);
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"card_id":123499054,"card_type_id":"100847","card_no":"1266","rate_code":"LIST","deposit":1.0,"card_score":100.0}
			 */
		}


		/*
		 * 获取有效奖品列表	list_gifts
		 */
		public function list_gifts(){
			$url = $this->url . 'list_gifts?' . $this->check_url;
			
			$res = doCurlGetRequest($url);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"gifts":[{"id":1498511,"score":300.0,"logo":"_gifts/1498511.jpg","name":"心形煎蛋器","no_delivery":false},{"id":1498513,"score":300.0,"logo":"_gifts/1498513.jpg","name":"碗具","no_delivery":false},{"id":1498515,"score":100.0,"logo":"_gifts/1498515.jpg","name":"钥匙扣一对","no_delivery":false},{"id":1498517,"score":100.0,"logo":"_gifts/1498517.jpg","name":"折叠杯","no_delivery":false},{"id":1498519,"score":200.0,"logo":"_gifts/1498519.jpg","name":"精美卡包","no_delivery":false},{"id":1498521,"score":100.0,"logo":"_gifts/1498521.jpg","name":"可爱纸巾盒","no_delivery":false},{"id":1498523,"score":350.0,"logo":"_gifts/1498523.jpg","name":"美甲套装","no_delivery":false},{"id":1498525,"score":350.0,"logo":"_gifts/1498525.jpg","name":"太阳能计算器","no_delivery":false},{"id":1498527,"score":1000.0,"logo":"_gifts/1498527.jpg","name":"办公室U形枕专业护颈","no_delivery":false},{"id":1498529,"score":1000.0,"logo":"_gifts/1498529.jpg","name":"电热水壶","no_delivery":false},{"id":1498531,"score":1000.0,"logo":"_gifts/1498531.jpg","name":"U盘","no_delivery":false},{"id":1498533,"score":1200.0,"logo":"_gifts/1498533.jpg","name":"家和富贵 碗具8件套","no_delivery":false},{"id":1498535,"score":1000.0,"logo":"_gifts/1498535.jpg","name":"抱枕被","no_delivery":false},{"id":1498537,"score":1000.0,"logo":"_gifts/1498537.jpg","name":"不锈钢保温饭盒","no_delivery":false},{"id":1498539,"score":1000.0,"logo":"_gifts/1498539.png","name":"可折叠收纳凳","no_delivery":false},{"id":1498541,"score":1000.0,"logo":"_gifts/1498541.png","name":"超强HUB接口，USB拓展接口","no_delivery":false},{"id":1498543,"score":1200.0,"logo":"_gifts/1498543.jpg","name":"双层煮蛋器","no_delivery":false},{"id":1498545,"score":1000.0,"logo":"_gifts/1498545.png","name":"6寸精美相框","no_delivery":false},{"id":1498547,"score":1200.0,"logo":"_gifts/1498547.jpg","name":"可爱护腰靠垫","no_delivery":false},{"id":1498549,"score":2000.0,"logo":"_gifts/1498549.jpg","name":"超薄超容量充电宝","no_delivery":false},{"id":1498551,"score":2000.0,"logo":"_gifts/1498551.png","name":"水晶地球仪摆件","no_delivery":false},{"id":1498553,"score":1500.0,"logo":"_gifts/1498553.png","name":"保温保冷杯500ML","no_delivery":false},{"id":1498555,"score":1500.0,"logo":"_gifts/1498555.jpg","name":"LED迷你便携小台灯","no_delivery":false},{"id":1498557,"score":2000.0,"logo":"_gifts/1498557.png","name":"保温保冷壶1L","no_delivery":false},{"id":1498559,"score":2000.0,"logo":"_gifts/1498559.png","name":"小浣熊电煮锅","no_delivery":false},{"id":1498561,"score":2500.0,"logo":"_gifts/1498561.png","name":"4L苹果 家用静音香薰台式加湿","no_delivery":false},{"id":1498563,"score":2500.0,"logo":"_gifts/1498563.jpg","name":"陶瓷紫砂禅意茶道摆件两用熏香炉","no_delivery":false},{"id":1498565,"score":2500.0,"logo":"_gifts/1498565.png","name":"家用早餐机 蛋卷机","no_delivery":false},{"id":1498567,"score":2000.0,"logo":"_gifts/1498567.png","name":"可爱抱枕空调被","no_delivery":false},{"id":1498569,"score":1500.0,"logo":"_gifts/1498569.png","name":"超大号木质桌面化妆品收纳盒带镜子","no_delivery":false},{"id":1498571,"score":3500.0,"logo":"_gifts/1498571.png","name":"迷你电饭煲","no_delivery":false},{"id":1498573,"score":3500.0,"logo":"_gifts/1498573.png","name":"小熊电炖锅","no_delivery":false},{"id":1498575,"score":3500.0,"logo":"_gifts/1498575.png","name":"多功能电炒锅/火锅","no_delivery":false},{"id":1498577,"score":3500.0,"logo":"_gifts/1498577.png","name":"家用电动多功能果汁搅拌机","no_delivery":false},{"id":1498579,"score":3000.0,"logo":"_gifts/1498579.png","name":"电饼铛早餐煎烤饼机","no_delivery":false},{"id":1498581,"score":4000.0,"logo":"_gifts/1498581.png","name":"多功能煮花茶养生壶","no_delivery":false},{"id":1498583,"score":3000.0,"logo":"_gifts/1498583.png","name":"小熊酸奶机","no_delivery":false},{"id":1498585,"score":3500.0,"logo":"_gifts/1498585.png","name":"创意摆件","no_delivery":false},{"id":1498587,"score":9000.0,"logo":"_gifts/1498587.png","name":"超高清行车记录仪后视镜一体机","no_delivery":false},{"id":1498589,"score":12000.0,"logo":"_gifts/1498589.jpg","name":"PC铝框拉杆箱20寸","no_delivery":false},{"id":1498591,"score":9000.0,"logo":"_gifts/1498591.png","name":"家用相框组合","no_delivery":false},{"id":1498593,"score":9000.0,"logo":"_gifts/1498593.jpg","name":"全棉卡通活性印花4件套床上用品","no_delivery":false},{"id":1498595,"score":6000.0,"logo":"_gifts/1498595.png","name":"景德镇16头骨瓷餐具高档金边陶瓷","no_delivery":false},{"id":1498597,"score":5000.0,"logo":"_gifts/1498597.png","name":"简约纯白陶瓷茶具茶壶茶杯竹托盘六件套","no_delivery":false},{"id":1498599,"score":6000.0,"logo":"_gifts/1498599.png","name":"不锈钢落地折叠翼型晾衣架","no_delivery":false},{"id":1498601,"score":7000.0,"logo":"_gifts/1498601.jpg","name":"韩国30CM加深型炒锅不粘无油烟","no_delivery":false},{"id":1498603,"score":6000.0,"logo":"_gifts/1498603.jpg","name":"儿童衣柜卡通宝宝组合收纳多层","no_delivery":false},{"id":1498605,"score":12000.0,"logo":"_gifts/1498605.jpg","name":"炊大皇 厨房套装刀具厨具10件套","no_delivery":false},{"id":1498607,"score":10000.0,"logo":"_gifts/1498607.jpg","name":"德国进口肖特SCHOTT水晶大号红酒杯套装","no_delivery":false},{"id":1498609,"score":10000.0,"logo":"_gifts/1498609.jpg","name":"双肩登山包男女户外旅行背包40L50L","no_delivery":false},{"id":1498611,"score":8000.0,"logo":"_gifts/1498611.png","name":"索维尔仰卧板 仰卧起坐健身器材 ","no_delivery":false},{"id":1498613,"score":18000.0,"logo":"_gifts/1498613.png","name":"Midea/美的 云智能超极WIFI电饭煲4L家用","no_delivery":false},{"id":1498615,"score":35000.0,"logo":"_gifts/1498615.png","name":"Midea/美的5.5kg全自动波轮小型单缸洗衣机","no_delivery":false},{"id":1498617,"score":20000.0,"logo":"_gifts/1498617.png","name":"超静音折叠迷你AD跑步机918家用款","no_delivery":false}]}
			 */
		}

		/*
		 * 申请兑换奖品	apply_gift
		 */
		public function apply_gift(){
			$url = $this->url . 'apply_gift?' . $this->check_url;
			$data = array(
				"apply.gift_id"=>"1498511",
				"apply.gift_quantity"=>"1",
				"apply.exchange_hotel_id"=>"",
				"apply.card_type_id"=>"103630",
				"apply.card_no"=>"50005409",
				"apply.contacter"=>"",
				"apply.mobile"=>"",
				"apply.email"=>"",
				"apply.address"=>"",
				"apply.zip"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"exception_code":"error.card.not_enough_score","exception_description":"会员卡积分不足"}
			 *
			 * 该奖品需要300积分，当积分为300时，返回的信息为：
			 * {}
			 */
		}

		/*
		 * 取消奖品申请	cancel_gift_application
		 */
		public function cancel_gift_application(){
			$url = $this->url . 'cancel_gift_application?' . $this->check_url;
			$data = array(
				"gift_application_id"=>"1285338",
				"cancel_reason"=>"",
				"card_type_id"=>"103630",
				"card_no"=>"50005409",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"exception_code":"error.gift_apply.wrong_application_id","exception_description":"奖品申请ID不正确"}
			 */
		}

		/*
		 * 奖品申请列表	list_gift_applications
		 */
		public function list_gift_applications(){
			$url = $this->url . 'list_gift_applications?' . $this->check_url;
			$data = array(
				"apply.gift_id"=>"1285338",
				"apply.gift_quantity"=>"1",
				"apply.exchange_hotel_id"=>"",
				"apply.card_type_id"=>"103630",
				"apply.card_no"=>"50005409",
				"apply.contacter"=>"",
				"apply.mobile"=>"",
				"apply.email"=>"",
				"apply.address"=>"",
				"apply.zip"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"exception_code":"error.card.not_exist","exception_description":"卡号卡类型不正确"}
			 */
		}

		/*
		 * 获取某一个酒店点评综合情况	get_hotel_review_stats
		 */
		public function get_hotel_review_stats(){
			$url = $this->url . 'get_hotel_review_stats?' . $this->check_url;
			$data = array(
				"hotel_id"=>"cnbjbjcgmz" //cnhnldmlcq
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"stats":[{"hotel_id":"cnbjbjcgmz","review_type_id":1,"review_count":9,"average_rate":4.1},{"hotel_id":"cnbjbjcgmz","review_type_id":2,"review_count":9,"average_rate":4.33},{"hotel_id":"cnbjbjcgmz","review_type_id":3,"review_count":9,"average_rate":4.79},{"hotel_id":"cnbjbjcgmz","review_type_id":4,"review_count":9,"average_rate":4.78},{"hotel_id":"cnbjbjcgmz","review_type_id":5,"review_count":7,"average_rate":4.57},{"hotel_id":"cnbjbjcgmz","review_type_id":6,"review_count":7,"average_rate":5.0}]}
			 */
		}

		/*
		 * 获取某条点评各项评分详情	get_review_detail
		 */
		public function get_review_detail(){
			$url = $this->url . 'get_review_detail?' . $this->check_url;
			$data = array(
				"review_id"=>"243"
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"review":{"id":243,"hotelgroup_id":"159","card_id":123495217,"card_no":"0783","user_name":"她说","review_hotel_id":"cnbjbjcgmz","check_in_date":"2014-12-15","check_out_date":"2014-12-15","locale":"zh_CN","content":"非常爽。。哈哈","score":10.0,"average_rate":5.0,"created_at":"2014-12-19 12:53:30","reply":"","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5},{"review_type_id":5,"rate":5},{"review_type_id":6,"rate":5}]}}
			 */
		}

		/*
		 * 增加点评	add_review
		 */
		public function add_review(){
			$url = $this->url . 'add_review?' . $this->check_url;
			$data = array(
				"history_id"=>"243",
				"card_no"=>"1266",
				"card_type_id"=>"100847",
				"content"=>"点评",
				"review_rates"=>""
			);
			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"exception_code":"error.member_history.not_exist","exception_description":"客史不存在"}
			 */
		}

		/*
		 * 获取某会员点评列表	get_card_reviews
		 */
		public function get_card_reviews(){
			$url = $this->url . 'get_card_reviews?' . $this->check_url;
			$data = array(
				"card_type_id"=>"100847",
				"card_no"=>"1266",
				"page"=>"",
				"per_page"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"reviews":[],"total_entries":0}
			 */
		}

		/*
		 * 获取某酒店点评列表	get_hotel_reviews
		 */
		public function get_hotel_reviews(){
			$url = $this->url . 'get_hotel_reviews?' . $this->check_url;
			$data = array(
				"hotel_id"=>"cnbjbjcgmz",
				"page"=>"",
				"per_page"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"reviews":[{"id":243,"hotelgroup_id":"159","card_id":123495217,"card_no":"0783","user_name":"她说","review_hotel_id":"cnbjbjcgmz","check_in_date":"2014-12-15","check_out_date":"2014-12-15","locale":"zh_CN","content":"非常爽。。哈哈","score":10.0,"average_rate":5.0,"created_at":"2014-12-19 12:53:30","reply":"","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5},{"review_type_id":5,"rate":5},{"review_type_id":6,"rate":5}]},{"id":235,"hotelgroup_id":"159","card_id":123470159,"card_no":"88961","user_name":"chenqiang","review_hotel_id":"cnbjbjcgmz","check_in_date":"2013-10-11","check_out_date":"2013-10-11","locale":"zh_CN","content":"sss","score":10.0,"average_rate":5.0,"created_at":"2013-11-25 11:11:27","reply":"","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5},{"review_type_id":5,"rate":5},{"review_type_id":6,"rate":5}]},{"id":201,"hotelgroup_id":"3","card_id":123469972,"card_no":"88930","user_name":"test1","review_hotel_id":"cnbjbjcgmz","check_in_date":"2009-09-27","check_out_date":"2009-10-02","locale":"zh_CN","content":"一般","score":10.0,"average_rate":3.17,"created_at":"2012-12-20 23:29:14","reply":"","mms_review_rates":[{"review_type_id":1,"rate":1},{"review_type_id":2,"rate":2},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":4},{"review_type_id":5,"rate":2},{"review_type_id":6,"rate":5}]},{"id":191,"hotelgroup_id":"3","card_id":1635639,"card_no":"01000","user_name":"周明红","review_hotel_id":"cnbjbjcgmz","check_in_date":"2012-05-30","check_out_date":"2012-05-30","locale":"zh_CN","content":"333","score":10.0,"average_rate":5.0,"created_at":"2012-09-06 11:55:22","reply":"","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5},{"review_type_id":5,"rate":5},{"review_type_id":6,"rate":5}]},{"id":189,"hotelgroup_id":"3","card_id":1635639,"card_no":"01000","user_name":"周明红","review_hotel_id":"cnbjbjcgmz","check_in_date":"2012-08-21","check_out_date":"2012-08-21","locale":"zh_CN","content":"ttt","score":10.0,"average_rate":5.0,"created_at":"2012-09-06 11:54:35","reply":"","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5},{"review_type_id":5,"rate":5},{"review_type_id":6,"rate":5}]},{"id":25,"hotelgroup_id":"159","card_id":1633513,"card_no":"200019","user_name":"jack","review_hotel_id":"cnbjbjcgmz","check_in_date":"2010-11-18","check_out_date":"2010-11-18","locale":"zh-cn","content":"酒店很不错！干净卫生，服务周道。安静，设施齐全，很赞酒店的高清电视和饭菜味道","score":10.0,"average_rate":5.0,"created_at":"2012-02-25 21:33:53","reply":"xexer","reply_user_id":"luopanshiyong","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5}]},{"id":23,"hotelgroup_id":"159","card_id":1633513,"card_no":"200019","user_name":"jack","review_hotel_id":"cnbjbjcgmz","check_in_date":"2010-11-19","check_out_date":"2010-11-19","locale":"zh-cn","content":"酒店装修很漂亮，房间也还不错，比较宽敞，设施齐全，价格比较实惠，总体来说很OK","score":10.0,"average_rate":5.0,"created_at":"2012-02-25 21:33:51","reply":"感谢您的支持","reply_user_id":"ceshi1","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5}]}],"total_entries":7}
			 */
		}

		/*
		 * 获取某批酒店点评列表	get_multi_hotel_review_stats
		 */
		public function get_multi_hotel_review_stats(){
			$url = $this->url . 'get_multi_hotel_review_stats?' . $this->check_url;
			$data = array(
				"hotel_ids"=>"cnbjbjcgmz,cnbjbjbfjy",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"stats":[{"hotel_id":"cnbjbjbfjy","review_type_id":1,"review_count":16,"average_rate":4.01},{"hotel_id":"cnbjbjbfjy","review_type_id":2,"review_count":16,"average_rate":4.26},{"hotel_id":"cnbjbjbfjy","review_type_id":3,"review_count":16,"average_rate":4.26},{"hotel_id":"cnbjbjbfjy","review_type_id":4,"review_count":16,"average_rate":4.49},{"hotel_id":"cnbjbjbfjy","review_type_id":5,"review_count":16,"average_rate":4.06},{"hotel_id":"cnbjbjbfjy","review_type_id":6,"review_count":16,"average_rate":4.38},{"hotel_id":"cnbjbjcgmz","review_type_id":1,"review_count":9,"average_rate":4.1},{"hotel_id":"cnbjbjcgmz","review_type_id":2,"review_count":9,"average_rate":4.33},{"hotel_id":"cnbjbjcgmz","review_type_id":3,"review_count":9,"average_rate":4.79},{"hotel_id":"cnbjbjcgmz","review_type_id":4,"review_count":9,"average_rate":4.78},{"hotel_id":"cnbjbjcgmz","review_type_id":5,"review_count":7,"average_rate":4.57},{"hotel_id":"cnbjbjcgmz","review_type_id":6,"review_count":7,"average_rate":5.0}]}
			 */
		}

		/*
		 * 搜索点评列表	search_reviews
		 */
		public function search_reviews(){
			$url = $this->url . 'search_reviews?' . $this->check_url;
			$data = array(
				"condition.hotel_id"=>"cnbjbjcgmz",
				"condition.hotelgroup_id"=>"159",
				"condition.hotel_ids"=>"cnbjbjcgmz,cnbjbjbfjy",
				"condition.exclude_empty"=>"false",
				"condition.page"=>"",
				"condition.page_size"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"reviews":[{"id":243,"hotelgroup_id":"159","card_id":123495217,"card_no":"0783","user_name":"她说","review_hotel_id":"cnbjbjcgmz","check_in_date":"2014-12-15","check_out_date":"2014-12-15","locale":"zh_CN","content":"非常爽。。哈哈","score":10.0,"average_rate":5.0,"created_at":"2014-12-19 12:53:30","reply":"","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5},{"review_type_id":5,"rate":5},{"review_type_id":6,"rate":5}]},{"id":235,"hotelgroup_id":"159","card_id":123470159,"card_no":"88961","user_name":"chenqiang","review_hotel_id":"cnbjbjcgmz","check_in_date":"2013-10-11","check_out_date":"2013-10-11","locale":"zh_CN","content":"sss","score":10.0,"average_rate":5.0,"created_at":"2013-11-25 11:11:27","reply":"","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5},{"review_type_id":5,"rate":5},{"review_type_id":6,"rate":5}]},{"id":201,"hotelgroup_id":"3","card_id":123469972,"card_no":"88930","user_name":"test1","review_hotel_id":"cnbjbjcgmz","check_in_date":"2009-09-27","check_out_date":"2009-10-02","locale":"zh_CN","content":"一般","score":10.0,"average_rate":3.17,"created_at":"2012-12-20 23:29:14","reply":"","mms_review_rates":[{"review_type_id":1,"rate":1},{"review_type_id":2,"rate":2},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":4},{"review_type_id":5,"rate":2},{"review_type_id":6,"rate":5}]},{"id":191,"hotelgroup_id":"3","card_id":1635639,"card_no":"01000","user_name":"周明红","review_hotel_id":"cnbjbjcgmz","check_in_date":"2012-05-30","check_out_date":"2012-05-30","locale":"zh_CN","content":"333","score":10.0,"average_rate":5.0,"created_at":"2012-09-06 11:55:22","reply":"","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5},{"review_type_id":5,"rate":5},{"review_type_id":6,"rate":5}]},{"id":189,"hotelgroup_id":"3","card_id":1635639,"card_no":"01000","user_name":"周明红","review_hotel_id":"cnbjbjcgmz","check_in_date":"2012-08-21","check_out_date":"2012-08-21","locale":"zh_CN","content":"ttt","score":10.0,"average_rate":5.0,"created_at":"2012-09-06 11:54:35","reply":"","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5},{"review_type_id":5,"rate":5},{"review_type_id":6,"rate":5}]},{"id":25,"hotelgroup_id":"159","card_id":1633513,"card_no":"200019","user_name":"jack","review_hotel_id":"cnbjbjcgmz","check_in_date":"2010-11-18","check_out_date":"2010-11-18","locale":"zh-cn","content":"酒店很不错！干净卫生，服务周道。安静，设施齐全，很赞酒店的高清电视和饭菜味道","score":10.0,"average_rate":5.0,"created_at":"2012-02-25 21:33:53","reply":"xexer","reply_user_id":"luopanshiyong","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5}]},{"id":23,"hotelgroup_id":"159","card_id":1633513,"card_no":"200019","user_name":"jack","review_hotel_id":"cnbjbjcgmz","check_in_date":"2010-11-19","check_out_date":"2010-11-19","locale":"zh-cn","content":"酒店装修很漂亮，房间也还不错，比较宽敞，设施齐全，价格比较实惠，总体来说很OK","score":10.0,"average_rate":5.0,"created_at":"2012-02-25 21:33:51","reply":"感谢您的支持","reply_user_id":"ceshi1","mms_review_rates":[{"review_type_id":1,"rate":5},{"review_type_id":2,"rate":5},{"review_type_id":3,"rate":5},{"review_type_id":4,"rate":5}]}],"total_entries":7}
			 */
		}

		/*
		 * 获取酒店图片列表	list_hotel_photos
		 */
		public function list_hotel_photos(){
			$url = $this->url . 'list_hotel_photos?' . $this->check_url;
			$data = array(
				"hotel_id"=>"cnbjbjcgmz",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"photos":[{"id":145,"hotel_id":"cnbjbjcgmz","album_id":25,"path":"cnbjbjcgmz/P130602155006868928S.jpg","name":"yyy1","priority":0},{"id":199,"hotel_id":"cnbjbjcgmz","room_type_id":1591,"path":"cnbjbjcgmz/P140403100442966742S.jpg","name":"酒店1","priority":0},{"id":189,"hotel_id":"cnbjbjcgmz","room_type_id":649,"path":"cnbjbjcgmz/P140326134343155343S.jpg","name":"普通大床房","priority":0},{"id":187,"hotel_id":"cnbjbjcgmz","room_type_id":651,"path":"cnbjbjcgmz/P140326134231230025S.jpg","name":"图片1","priority":0},{"id":173,"hotel_id":"cnbjbjcgmz","room_type_id":651,"path":"cnbjbjcgmz/P121122163027886642S.jpg","name":"大床间","priority":0},{"id":171,"hotel_id":"cnbjbjcgmz","room_type_id":651,"path":"cnbjbjcgmz/P121122163120527971S.jpg","name":"","priority":0},{"id":169,"hotel_id":"cnbjbjcgmz","room_type_id":649,"path":"cnbjbjcgmz/P121122163212241912S.jpg","name":"","priority":0},{"id":167,"hotel_id":"cnbjbjcgmz","path":"cnbjbjcgmz/P121122163237701133S.jpg","name":"","priority":0},{"id":153,"hotel_id":"cnbjbjcgmz","album_id":27,"path":"cnbjbjcgmz/P130602155054263910S.jpg","name":"yyyd","priority":0},{"id":151,"hotel_id":"cnbjbjcgmz","album_id":27,"path":"cnbjbjcgmz/P130602155053847207S.jpg","name":"yyyd","priority":0},{"id":149,"hotel_id":"cnbjbjcgmz","album_id":25,"path":"cnbjbjcgmz/P130602155019820347S.jpg","name":"yyy2","priority":0},{"id":147,"hotel_id":"cnbjbjcgmz","album_id":25,"path":"cnbjbjcgmz/P130602155019517005S.jpg","name":"yyy2","priority":0},{"id":201,"hotel_id":"cnbjbjcgmz","room_type_id":651,"path":"cnbjbjcgmz/P140403100513728677S.jpg","name":"双人床","priority":0}]}
			 */
		}

		/*
		 * 获取房型图片列表	list_room_type_photos
		 */
		public function list_room_type_photos(){
			$url = $this->url . 'list_room_type_photos?' . $this->check_url;
			$data = array(
				"room_type_id"=>"1591",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"photos":[{"id":199,"hotel_id":"cnbjbjcgmz","room_type_id":1591,"path":"cnbjbjcgmz/P140403100442966742S.jpg","name":"酒店1","priority":0}]}
			 */
		}
		
		/*
		 * 获取酒店相册列表	list_hotel_albums
		 */
		public function list_hotel_albums(){
			$url = $this->url . 'list_hotel_albums?' . $this->check_url;
			$data = array(
				"hotel_id"=>"cnbjbjcgmz",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"albums":[{"id":25,"hotel_id":"cnbjbjcgmz","name":"xxx1","priority":0,"cover_photo_id":145},{"id":27,"hotel_id":"cnbjbjcgmz","name":"yyy4","priority":0,"cover_photo_id":151},{"id":31,"hotel_id":"cnbjbjcgmz","name":"fggg","priority":0}]}
			 */
		}

		/*
		 * 获取相册图片列表	list_album_photos
		 */
		public function list_album_photos(){
			$url = $this->url . 'list_album_photos?' . $this->check_url;
			$data = array(
				"album_id"=>"25",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"photos":[{"id":145,"hotel_id":"cnbjbjcgmz","album_id":25,"path":"cnbjbjcgmz/P130602155006868928S.jpg","name":"yyy1","priority":0},{"id":147,"hotel_id":"cnbjbjcgmz","album_id":25,"path":"cnbjbjcgmz/P130602155019517005S.jpg","name":"yyy2","priority":0},{"id":149,"hotel_id":"cnbjbjcgmz","album_id":25,"path":"cnbjbjcgmz/P130602155019820347S.jpg","name":"yyy2","priority":0}]}
			 */
		}

		/*
		 * 获取新闻列表	list_news
		 */
		public function list_news(){
			$url = $this->url . 'list_news?' . $this->check_url;
			$data = array(
				"news_type_name"=>"",
				"only_mobile"=>"",
				"no_content"=>"false",
				"page"=>"",
				"page_size"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"news_list":[{"id":7281,"hotel_id":"cnsccdjyzj","title":"热列祝贺罗盘武汉店开业","content":"\u003cspan style\u003d\"white-space:nowrap;\"\u003e热列祝贺罗盘武汉店开业！\u003cimg src\u003d\"/app/crs_images.php?path\u003d_news/N151109170409746.jpg\" alt\u003d\"\" /\u003e\u003c/span\u003e","locale":"zh_CN","news_type_name":"","priority":0,"publisher":"","meta_keywords":"","meta_desc":"","created_at":"2015-11-09 17:04:15"}],"total_entries":1}
			 */
		}

		/*
		 * 获取新闻详情	get_news_detail
		 */
		public function get_news_detail(){
			$url = $this->url . 'get_news_detail?' . $this->check_url;
			$data = array(
				"news_id"=>"7281"
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"id":7281,"hotel_id":"cnsccdjyzj","title":"热列祝贺罗盘武汉店开业","content":"\u003cspan style\u003d\"white-space:nowrap;\"\u003e热列祝贺罗盘武汉店开业！\u003cimg src\u003d\"/app/crs_images.php?path\u003d_news/N151109170409746.jpg\" alt\u003d\"\" /\u003e\u003c/span\u003e","locale":"zh_CN","news_type_name":"","priority":0,"publisher":"","meta_keywords":"","meta_desc":"","created_at":"2015-11-09 17:04:15"}
			 */
		}

		/*
		 * 获取留言列表	search_questions
		 */
		public function search_questions(){
			$url = $this->url . 'search_questions?' . $this->check_url;
			$data = array(
				"condition.page"=>"",
				"condition.page_size"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"questions":[{"id":235,"hotelgroup_id":"159","asker_name":"tnizSMHkxpuysuJaab","asker_mobile":"qubEYirqvBIfhYjiUvv","asker_email":"dyeuuf@rvrrir.com","content":"DUfASH \u003ca href\u003d\"http://jrqvfxwaykno.com/\"\u003ejrqvfxwaykno\u003c/a\u003e, [url\u003dhttp://qzhcuyzhiqtd.com/]qzhcuyzhiqtd[/url], [link\u003dhttp://yktyjikietdy.com/]yktyjikietdy[/link], http://favalnhyaejk.com/","reply":"十一一","reply_user_id":"chengguo","ip":"162.244.13.18","created_at":"2014-06-30 16:59:53","reply_at":"2014-11-07 17:32:51"},{"id":221,"hotelgroup_id":"159","asker_name":"dd","asker_mobile":"111","asker_email":"bbb","content":"ccc","reply":"kkkkkkkk","reply_user_id":"luopancrs","ip":"219.143.129.14","created_at":"2013-09-10 16:39:12","reply_at":"2014-09-23 11:22:58"},{"id":31,"hotelgroup_id":"159","asker_name":"陈强","asker_mobile":"13272665023","asker_email":"chenqiang@luopan.com","content":"xxxxx","reply":"test","reply_user_id":"159","ip":"127.0.0.1","created_at":"2012-04-21 07:40:34","reply_at":"2012-05-10 17:27:21"}],"total_entries":3}
			 */
		}

		/*
		 * 添加用户留言	add_question
		 */
		public function add_question(){
			$url = $this->url . 'add_question?' . $this->check_url;
			$data = array(
				"question.asker_name"=>"hong",
				"question.asker_mobile"=>"",
				"question.asker_email"=>"",
				"question.content"=>"这是我的留言",
				"question.ip"=>"123123",
				"question.is_private"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {}
			 */
		}

		/*
		 * 网站管理员回复用户留言	reply_question
		 */
		public function reply_question(){
			$url = $this->url . 'reply_question?' . $this->check_url;
			$data = array(
				"question_id"=>"00001",
				"reply_content"=>"这是回复hong",
				"reply_user_id"=>"123123",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {}
			 */
		}

		/*
		 * 网站管理员回复会员点评	reply_review
		 */
		public function reply_review(){
			$url = $this->url . 'reply_review?' . $this->check_url;
			$data = array(
				"review_id"=>"235",
				"reply_content"=>"这是回复hong",
				"reply_user_id"=>"chengguo",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {}
			 */
		}

		/*
		 * 获取酒店或集团可用的电子优惠券类型列表	 get_voucher_type_list
		 */
		public function get_voucher_type_list(){
			$url = $this->url . 'get_voucher_type_list?' . $this->check_url;
			$data = array(
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"voucher_types":[{"id":"091027111619562196L","name":"微信劵","expire_days":0,"start_expire_days":0,"discount_ratio":100,"discount_bias":-10.0,"only_today_fee":false,"discount_room_rate":false,"amount_per_order":0,"amount_per_night":0,"wechat_id":"pdLTFjrlVqiNM_JB7F0f_7JcJ2q4"},{"id":"091106143139016425L","name":"优惠券","expire_days":0,"start_expire_days":0,"effective_date":"2013-07-03","discount_ratio":100,"discount_bias":-50.0,"only_today_fee":false,"discount_room_rate":false,"amount_per_order":5,"amount_per_night":2},{"id":"100613115613546446L","name":"测试","expire_days":0,"start_expire_days":0,"effective_date":"2008-10-01","discount_ratio":100,"discount_bias":-20.0,"only_today_fee":false,"discount_room_rate":false,"amount_per_order":0,"amount_per_night":0},{"id":"101126230120774155L","name":"集团统一免费卷","expire_days":0,"start_expire_days":0,"discount_ratio":100,"discount_bias":0.0,"only_today_fee":false,"discount_room_rate":false,"amount_per_order":0,"amount_per_night":0},{"id":"1405131534385665258G159","name":"10元优惠券","expire_days":0,"start_expire_days":0,"discount_ratio":100,"discount_bias":-10.0,"only_today_fee":false,"discount_room_rate":false,"amount_per_order":0,"amount_per_night":0},{"id":"1406201059476581960G159","name":"新店开张168","expire_days":0,"start_expire_days":0,"discount_ratio":100,"discount_bias":-5.0,"only_today_fee":false,"discount_room_rate":false,"amount_per_order":0,"amount_per_night":0,"wechat_id":"pdLTFjiW5BregKA30Ipmu_aAjE54"},{"id":"1501081520571194494G159","name":"10元电子券","expire_days":0,"start_expire_days":0,"discount_ratio":100,"discount_bias":-10.0,"only_today_fee":false,"discount_room_rate":false,"amount_per_order":0,"amount_per_night":0,"wechat_id":"pdLTFjj6RL-4WJ7k6-BFtHtXZrqM"},{"id":"1506121058244203715G159","name":"免房券","expire_days":0,"start_expire_days":0,"discount_ratio":0,"discount_bias":0.0,"only_today_fee":false,"discount_room_rate":true,"amount_per_order":0,"amount_per_night":1},{"id":"1509221653487818203G159","name":"一折券（jin）","expire_days":0,"start_expire_days":0,"discount_ratio":90,"discount_bias":0.0,"only_today_fee":true,"discount_room_rate":false,"amount_per_order":0,"amount_per_night":0}]}
			 */
		}

		/*
		 * 销售电子优惠券	sell_voucher
		 */
		public function sell_voucher(){
			$url = $this->url . 'sell_voucher?' . $this->check_url;
			$data = array(
				"voucher.voucher_type_id"=>"091027111619562196L",
				"voucher.voucher_no"=>"123123",
				"voucher.card_type_id"=>"100847",
				"voucher.card_no"=>"1266",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"voucher":{"voucher_type_name":"微信劵","voucher_type_id":"091027111619562196L","voucher_no":"123123","sell_time":"2015-12-17","left_times":1,"card_no":"1266","card_type_id":""}}
			 */
		}

		/*
		 * 获取会员卡当前在住房间	get_card_checking_registers
		 */
		public function get_card_checking_registers(){
			$url = $this->url . 'get_card_checking_registers?' . $this->check_url;
			$data = array(
				"card_type_id"=>"100847",
				"card_no"=>"1266",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"registers":[]}
			 */
		}

		/*
		 * 通知登记单付款成功	deposit_register
		 */
		public function deposit_register(){
			$url = $this->url . 'deposit_register?' . $this->check_url;
			$data = array(
				"deposit_account.register_id"=>"111111",
				"deposit_account.money"=>"100.00",
				"deposit_account.prepaid_source_code"=>"",
				"deposit_account.note"=>"",
				"deposit_account.payment_seq"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"exception_code":"error.register.wrong_id","exception_description":"非法登记单号"}
			 */
		}

		/*
		 * 获取微信access_token get_wechat_token
		 */
		public function get_wechat_token(){
			$url = $this->url . 'get_wechat_token?' . $this->check_url;
			$data = array();

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {"exception_code":"error.register.wrong_id","exception_description":"非法登记单号"}
			 */
		}

		/*
		 * 返回第三方帐号关联的会员卡信息	get_binding_card
		 */
		public function get_binding_card(){
			$url = $this->url . 'get_binding_card?' . $this->check_url;
			$data = array(
				"qq"=>"",
				"weixin"=>"pdLTFjrlVqiNM_JB7F0f_7JcJ2q2",
				"sina_weibo"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {}
			 */
		}

		/*
		 * 绑定第三方帐号	binding_exist_card
		 */
		public function binding_exist_card(){
			$url = $this->url . 'binding_exist_card?' . $this->check_url;
			$data = array(
				"card_no"=>"1266",
				"card_type_id"=>"100847",
				"qq"=>"",
				"weixin"=>"pdLTFjrlVqiNM_JB7F0f_7JcJ2q2",
				"sina_weibo"=>"",
			);

			$res = doCurlGetRequest($url,$data);
			print_r($res);
			/*
			 * 返回的信息：
			 * {}
			 */
		}
	}




