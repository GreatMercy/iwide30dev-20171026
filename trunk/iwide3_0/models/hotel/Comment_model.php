<?php
class Comment_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	const TAB_HCT = 'hotel_comments';
	const TAB_FANS = 'fans';
    const TAB_KEYWORD = 'hotel_comment_keyword';
    const TAB_LOG = 'hotel_admin_log';
    const TAB_H_CONFIG = 'hotel_config';
    const TAB_C_CONFIG = 'hotel_comment_config';
	function get_order_comment($inter_id, $orderid, $openid = '', $field = 'orderid') {
		$this->db->where ( 'inter_id', $inter_id );
		$this->db->where ( $field, $orderid );
		if ($openid)
			$this->db->where ( 'openid', $openid );
		$comment = $this->db->get ( self::TAB_HCT )->row_array ();
		empty ( $comment ) ?  : $comment ['order_info'] = json_decode ( $comment ['order_info'], TRUE );
		return $comment;
	}
	function get_comment_by_id($inter_id, $comment_id, $hotel_id = null) {
		$this->db->where ( 'inter_id', $inter_id );
		$this->db->where ( 'comment_id', $comment_id );
		if (! is_null ( $hotel_id ))
			$this->db->where ( 'hotel_id', $hotel_id );
		$comment = $this->db->get ( self::TAB_HCT )->row_array ();
		empty ( $comment ) ?  : $comment ['order_info'] = json_decode ( $comment ['order_info'], TRUE );
		return $comment;
	}
	function change_comment_status($inter_id, $comment_id, $status, $hotel_id = null) {
		$this->db->where ( 'inter_id', $inter_id );
		$this->db->where ( 'comment_id', $comment_id );
		if (! is_null ( $hotel_id ))
			$this->db->where ( 'hotel_id', $hotel_id );
		return $this->db->update ( self::TAB_HCT, array (
				'status' => $status 
		) );
	}
	function add_comment($data) {
		$this->load->model ( 'hotel/Hotel_check_model' );
		$adapter = $this->Hotel_check_model->get_hotel_adapter ( $data['inter_id'], $data['hotel_id'], TRUE );
		$result=$adapter->add_comment ( $data);

		if ($result['s']==1){
			if (!empty($result['web_comment_id'])){
				$data ['web_comment_id']=$result['web_comment_id'];
			}
			if (isset($data['extra_info'])&& $data['extra_info']==NULL){
				unset($data['extra_info']);
			}
			$data ['comment_time'] = time ();
			$data ['status'] = 1;
			$data ['order_info'] = json_encode ( $data ['order_info'], JSON_UNESCAPED_UNICODE );

            if(!isset($data['service_score']))$data['service_score']=$data['score'];
            if(!isset($data['net_score']))$data['net_score']=$data['score'];
            if(!isset($data['facilities_score']))$data['facilities_score']=$data['score'];
            if(!isset($data['clean_score']))$data['clean_score']=$data['score'];

            $comment_config = $this->get_comment_show_type($data['inter_id']);

            if(isset($comment_config) && $comment_config->auth=='true'){
                $data ['status'] = 2;
            }

			$this->db->insert ( self::TAB_HCT, $data );
            $result['comment_id'] = $this->db->insert_id();
            $result['status'] = $data ['status'];
			return $result;
		}else {
			return $result;
		}
	}
	function get_hotel_comment_counts($inter_id, $hotel_id = null, $status = null,$openid=''){

        $new_comment = $this->get_comment_show_type($inter_id);
        $this->load->model ( 'hotel/Hotel_cache_model' );

        if(!$new_comment){   //旧的评论机制

            $comment_data = $this->Hotel_cache_model->get_cache ( $inter_id, 'comment_data', array (
                'hotel_ids' => array($hotel_id)
            ) );
            $tmp = explode ( ':', $comment_data [$hotel_id] ['value'] );
            return array (
                'comment_count' => $tmp [0],
                'comment_score' => $tmp [1],
                'score_count' => $tmp [2],
                'good_rate' => $tmp [3]
            );

        }else{   //新的评论机制

            $comment_data = $this->get_hotel_score_from_redis($inter_id,array($hotel_id),$openid);
            $comment_data = json_decode($comment_data[$hotel_id]);
//            $comment_count = $this->count_all_comment($inter_id,array($hotel_id));
//            foreach($comment_count as $arr){
//                $comment_counts[$arr['hotel_id']] = $arr;
//            }
//            if(!empty($comment_counts))$comment_count = $comment_counts;
            $keyword = $this->get_keyword($inter_id);
            if($keyword){
                foreach($keyword as $key=>$arr){
                    if($arr['count']){
                        $keyword_count = json_decode($arr['count']);
                        if(isset($keyword_count->$hotel_id)){
                            $keyword[$key]['count']=$keyword_count->$hotel_id;
                        }else{
                            $keyword[$key]['count']=0;
                        }
                    }
                }
            }

            if(!isset($comment_data->count)){
                $comment_data->count = 0;
            }

            if(!isset($comment_data->good_rate)){
                $comment_data->good_rate = 100;
            }

            $res = array (
                'comment_score' => round($comment_data->score,1),
                'service_score' => round($comment_data->service_score,1),
                'net_score' => round($comment_data->net_score,1),
                'facilities_score' => round($comment_data->facilities_score,1),
                'clean_score' => round($comment_data->clean_score,1),
                'good_rate'=>round($comment_data->good_rate,1),
                'keyword'=>$keyword,
                'image_count'=>$comment_data->images_count,
                'comment_count'=>$comment_data->score_count
            );

            return $res;

        }
	}
	function get_hotel_comment_count($inter_id, $hotel_id = null, $status = null,$params=array()) {
		$this->load->model ( 'hotel/Hotel_check_model' );
		$adapter = $this->Hotel_check_model->get_hotel_adapter ( $inter_id, $hotel_id, TRUE );
		return $adapter->get_hotel_comment_count ( $inter_id, $hotel_id , $status,$params);
	}
	function get_hotel_comment_count_local($inter_id, $hotel_id = null, $status = null) {
		$select = " count( case when content!='' then 1 else NULL end) c_n, count( case when score!=0 then 1 else NULL end) c_s, sum(score) t_s,count(case when score>3 then 1 else NULL end) g_s";
		$this->db->select ( $select );
		empty ( $hotel_id ) ? : $this->db->where ( 'hotel_id', $hotel_id );
		is_null ( $status ) ?  : $this->db->where ( 'status', $status );
		$this->db->where ( array (
				'inter_id' => $inter_id 
		) );
		// empty ( $hotel_id ) ? $this->db->group_by ( 'inter_id' ) : $this->db->group_by ( 'hotel_id' );
		$data = $this->db->get ( self::TAB_HCT )->row_array ();
		$comment_count = empty ( $data ['c_n'] ) ? 0 : $data ['c_n']; // 评论人数
		$score_count = empty ( $data ['c_s'] ) ? 0 : $data ['c_s']; // 评分人数
		$comment_score = empty ( $data ['c_s'] ) ? 0 : number_format ( $data ['t_s'] / $data ['c_s'], 1, '.', '' ); // 总评分/评分人数
		$good_rate = empty ( $data ['c_s'] ) ? -1 : number_format ( $data ['g_s'] / $data ['c_s'], 1, '.', '' ) * 100; // 好评率
		return array (
				'comment_count' => $comment_count,
				'comment_score' => $comment_score,
				'score_count' => $score_count,
				'good_rate' => $good_rate 
		);
	}
	function get_hotels_comment_count($inter_id, $hotel_ids = null, $status = null) {
		$select = "hotel_id,count( case when content!='' then 1 else NULL end) c_n, count( case when score!=0 then 1 else NULL end) c_s, sum(score) t_s,count(case when score>3 then 1 else NULL end) g_s";
		$this->db->select ( $select );
		if (empty ( $hotel_ids )) {
			$this->db->group_by ( 'inter_id' );
		} else {
			$this->db->where_in ( 'hotel_id', $hotel_ids );
			$this->db->group_by ( 'hotel_id' );
		}
		is_null ( $status ) ?  : $this->db->where ( 'status', $status );
		$this->db->where ( array (
				'inter_id' => $inter_id 
		) );
		$datas = $this->db->get ( self::TAB_HCT )->result_array ();
		$result = array ();
		foreach ( $datas as $data ) {
			$tmp = array ();
			$tmp ['comment_count'] = empty ( $data ['c_n'] ) ? 0 : $data ['c_n']; // 评论人数
			$tmp ['score_count'] = empty ( $data ['c_s'] ) ? 0 : $data ['c_s']; // 评分人数
			$tmp ['comment_score'] = empty ( $data ['c_s'] ) ? 0 : number_format ( $data ['t_s'] / $data ['c_s'], 1, '.', '' ); // 总评分/评分人数
			$tmp ['good_rate'] = empty ( $data ['c_s'] ) ? -1 : number_format ( $data ['g_s'] / $data ['c_s'], 1, '.', '' ) * 100; // 好评率
			$result [$data ['hotel_id']] = $tmp;
		}
		return $result;
	}
	function get_hotel_comments($inter_id, $hotel_id = null, $status = null, $order_by = '', $nums = null, $offset = null,$params=array()) {
        $new_comment = $this->get_comment_show_type($inter_id);
        if(!$new_comment){                     //旧的评论

            $this->load->model ( 'hotel/Hotel_check_model' );
            $adapter = $this->Hotel_check_model->get_hotel_adapter ( $inter_id, $hotel_id, TRUE );
            return $adapter->get_hotel_comments ( $inter_id, $hotel_id ,$status, $order_by, $nums, $offset,$params);

        }else{                                  //新的评论

            $comments = $this->get_hotel_comments_local($inter_id,$hotel_id);
            $feedback = $this->get_hotel_feedback($inter_id);
            if($feedback){                             //酒店回复
                foreach($feedback as $f_arr){
                    $feedback_hash[$f_arr['feedback_comment_id']] = $f_arr['content'];
                }
            }
            $res = array();
            if($comments){
                foreach ($comments as $key=>$arr){
                    if($arr['type']=='user'){
                        if($arr['images']){
                            $images = explode(',',$arr['images']);
                            $arr['images']=$images;
                        }
                        if(isset($feedback_hash[$arr['comment_id']])){
                            $arr['feedback_content']=$feedback_hash[$arr['comment_id']];
                        }
                        $res[]=$arr;
                    }
                }
            }
//$this->db->insert('weixin_text',array('content'=>'comment_feedback+'.json_encode($feedback),'edit_date'=>date('Y-m-d H:i:s')));
            return $res;
        }
	}
	function get_hotel_comments_local($inter_id, $hotel_id = null, $status = null, $order_by = '', $nums = null, $offset = null) {
		$c_wsql = " WHERE `inter_id` = '$inter_id'";
		empty ( $hotel_id ) ?  : $c_wsql .= " AND `hotel_id` = $hotel_id ";
		if (empty ( $order_by ))
			$order_by = ' sort desc,comment_id desc ';
		is_null ( $status ) ?  : $c_wsql .= " AND `status` = $status ";
		$comment_sql = " SELECT * FROM `" . $this->db->dbprefix ( self::TAB_HCT ) . "` $c_wsql  order by $order_by ";
		// $sub_sql = " SELECT openid FROM `" . $this->db->dbprefix ( self::TAB_HCT ) . "` $c_wsql ";
		// $fans_sql = " SELECT * FROM `" . $this->db->dbprefix ( self::TAB_FANS ) . "` WHERE `inter_id` = '$inter_id' and openid in ($sub_sql) ";
		// $comment_sql = "SELECT c.*,f.nickname,f.headimgurl from ($sql) c left join ($fans_sql) f on c.openid = f.openid";
		if (! is_null ( $nums )) {
			$comment_sql .= " limit $offset,$nums";
		}
		$data = $this->db->query ( $comment_sql )->result_array ();
		foreach ( $data as $k => $d ) {
			$fans = $this->db->get_where ( self::TAB_FANS, array (
					'openid' => $d ['openid'],
					'inter_id' => $inter_id 
			) )->row_array ();
			if (! empty ( $fans )) {
				$data [$k] ['nickname'] = $fans ['nickname'];
				$data [$k] ['headimgurl'] = $fans ['headimgurl'];
				if (strlen ( $data [$k] ['nickname'] ) > 3)
					$data [$k] ['nickname'] = mb_strcut ( $data [$k] ['nickname'], 0, intval ( strlen ( $data [$k] ['nickname'] ) * 0.7 ), 'UTF-8' ) . '*';
			} else {
				$data [$k] ['nickname'] = '微信用户';
				$data [$k] ['headimgurl'] = '';
			}
			$data [$k] ['order_info'] = json_decode ( $d ['order_info'], TRUE );
		}
		return $data;
	}
	/**
	 * 后台管理的表格中要显示哪些字段
	 */
	public function grid_fields() {
		return array (
				'nickname' => array (
						'label' => '昵称' 
				),
				'content' => array (
						'label' => '评论内容' 
				),
				'score' => array (
						'label' => '评分' 
				),
				'hotel_name' => array (
						'label' => '入住酒店' 
				),
				'room_name' => array (
						'label' => '入住房型' 
				),
				'orderid' => array (
						'label' => '订单号' 
				),
				'comment_time' => array (
						'label' => '评论时间' 
				) 
		);
	}


    public function get_keyword($inter_id,$status=1){   //获取酒店对应关键词

        $keyword = $this->db->get_where ( self::TAB_KEYWORD, array (
            'inter_id' => $inter_id,
            'status'=>$status
        ) )->result_array ();

        return $keyword;

    }

    public function new_keyword($inter_id,$keyword,$count){   //添加对应的关键词


        $check = $this->check_keyword($inter_id,$keyword);

        if($check){

            if($check['status']==1){         //已经存在在用关键词

                return false;

            }else{          //存在无效的关键词，改变状态

                $this->update_keyword($inter_id,$check['keyword_id'],1);

                return $check['keyword_id'];

            }

        }else{

            $time=date('Y-m-d H:i:s',time());

            if(is_array($count)){
                $count = json_encode($count);
            }

            $data=array(
                'keyword'=>$keyword,
                'inter_id'=>$inter_id,
                'create_time'=>$time,
                'count'=>$count
            );

            $this->db->insert ( self::TAB_KEYWORD, $data);

            return $this->db->insert_id();

        }

    }


    public function update_keyword($inter_id,$keyword_id,$status=0){   //改变关键词状态

        $this->db->where ( 'inter_id', $inter_id );
        $this->db->where ( 'keyword_id', $keyword_id );

        return $this->db->update ( self::TAB_KEYWORD, array (
            'status' => $status
        ) );

    }


    public function get_comments($inter_id, $idents = array(),$condits = array()){   //获取对应的评论

        $condition='';

        $base_sql = "SELECT
                                t1.*,t3.room_id,t4.nickname,t4.headimgurl
                          FROM
                              `iwide_hotel_comments` as t1,
                              `iwide_hotel_orders` as t2,
                              `iwide_hotel_order_items` as t3,
                              `iwide_fans` as t4
                          WHERE
                               t1.type = 'user'
                          AND
                               t1.inter_id = '{$inter_id}'
                          AND
                               t2.inter_id = '{$inter_id}'
                          AND
                               t3.inter_id = '{$inter_id}'
                          AND
                               t4.inter_id = '{$inter_id}'
                          AND
                               t1.orderid = t2.orderid
                          AND
                              t1.orderid = t3.orderid
                          AND
                              t1.openid = t4.openid
                          AND
                              t1.feedback_comment_id = 0
                     ";


        //获取对应酒店的评分

        if(isset($idents['hotel_id']) && $idents['hotel_id']!=0){
            $condition .= " AND t2.hotel_id = {$idents['hotel_id']}";
        }elseif(isset($idents['entity_id']) && !empty($idents['entity_id'])){
             $condition .= " AND t2.hotel_id in ({$idents['entity_id']})";
        }

        if(isset($idents['room_id']) && $idents['room_id']!=0){
            $condition .= " AND t3.room_id = {$idents['room_id']}";
        }

        if(isset($idents['orderid'])){
            $idents['orderid'] = htmlspecialchars($idents['orderid']);
            $condition .= " AND t1.orderid = '{$idents['orderid']}'";
        }

        if(isset($idents['keyword'])){
//            $idents['keyword'] = htmlspecialchars($idents['keyword']);
            $condition .= " AND t1.content like '%{$idents['keyword']}%'";
        }

        if(isset($idents['starttime'])){
            $b_time = strtotime($idents['starttime']);
            $condition .= " AND t1.comment_time > '{$b_time}'";
        }

        if(isset($idents['endtime'])){
            $e_time = strtotime($idents['endtime']);
            $e_time = $e_time + 86400;
            $condition .= " AND t1.comment_time < '{$e_time}'";
        }

        if(isset($idents['score']) && $idents['score']!=0){
            $score=explode('~',$idents['score']);
            if(isset($score[1])){
                $condition .= " AND t1.score >= $score[0] AND t1.score <= $score[1]";
            }else{
                $condition .= " AND t1.score = $score[0]";
            }
        }

        if(isset($idents['service_score']) && $idents['service_score']!=0){
            $condition .= " AND t1.service_score = {$idents['service_score']}";
        }

        if(isset($idents['net_score']) && $idents['net_score']!=0){
            $condition .= " AND t1.net_score = {$idents['net_score']}";
        }

        if(isset($idents['facilities_score']) && $idents['facilities_score']!=0){
            $condition .= " AND t1.facilities_score = {$idents['facilities_score']}";
        }

        if(isset($idents['clean_score']) && $idents['clean_score']!=0){
            $condition .= " AND t1.clean_score = {$idents['clean_score']}";
        }

        $base_sql=$base_sql.$condition;

        $base_count_sql="SELECT
                        count(*) as total
                      FROM
                      (
                        {$base_sql} GROUP BY t1.comment_id
                      )
                      AS
                          count_tab

            ";


        $count_all_sql = $base_count_sql;
        $count_total=$this->db->query($count_all_sql)->row_array();


        $base_count_sql="SELECT
                        count(*) as total
                      FROM
                      (
                        {$base_sql} AND t1.feedback =1 GROUP BY t1.comment_id
                      )
                      AS
                          count_tab

            ";
        $count_feedback_sql = $base_count_sql;
        $count_feedback=$this->db->query($count_feedback_sql)->row_array();
        $count_other = $count_total['total']-$count_feedback['total'];


//        $limit = " LIMIT ".($condits['page_nums']*($condits['page']-1)).','.$condits['page_nums'];
//        $sql="SELECT c1.*,c2.content as feedback_content FROM(".$base_sql." GROUP BY t1.comment_id) as c1 LEFT JOIN iwide_hotel_comments as c2 on c1.comment_id = c2.feedback_comment_id order by c1.comment_time DESC";

        $base_sql = $base_sql.' GROUP BY t1.comment_id ORDER BY t1.comment_time DESC';
        $result['list'] = $this->db->query($base_sql)->result_array();

        $result['count']=array(
            'all'=>$count_total['total'],
            'feedback'=>$count_feedback['total'],
            'nfeedback'=>$count_other
        );

//        $result['all_page']=ceil($count_total['total']/$condits['page_nums']);

        return $result;


    }


    public function new_feedback($inter_id,$post){    //添加新的酒店回复


        $info=$this->get_comment_by_id($inter_id,$post['comment_id']);

        if($info){

            $data = array(
                'inter_id'=>$inter_id,
                'hotel_id'=>$info['hotel_id'],
                'type'=>'hotel',
                'feedback_comment_id'=>$post['comment_id'],
                'orderid'=>$info['orderid'],
                'comment_time'=>time(),
                'content'=>$post['content']

            );

            return $this->db->insert ( self::TAB_HCT, $data );

        }

        return false;


    }


    public function ajax_hotel_rooms($inter_id,$hotel_id,$status=1){   //获取酒店的房型

        $this->db->select('room_id');
        $this->db->select('name');

        $rooms = $this->db->get_where ( 'iwide_hotel_rooms', array (
            'inter_id' => $inter_id,
            'hotel_id' => $hotel_id,
            'status'=>$status
        ) )->result_array ();

        return $rooms;
    }



    function get_comment_show_type($inter_id){    //酒店评分机制，0为五分制，1为百分制

        $this->load->model ( 'hotel/Hotel_config_model' );

        $config_data = $this->Hotel_config_model->get_hotel_config ( $inter_id, 'HOTEL', 0, 'NEW_COMMENT');


        $data = array(
            'auth' => 'false',
            'service_score'=>'服务',
            'net_score'=>'网络',
            'facilities_score'=>'设施',
            'clean_score'=>'卫生',
            'sign'=>''
        );


        if (!isset($config_data['NEW_COMMENT'])){

            $this->set_comment_config($inter_id,$data);

        }else{
            $config = json_decode($config_data['NEW_COMMENT']);
            if(!isset($config->auth)){
                $this->update_comment_config($inter_id,$data);
            }
        }

        $config_data = $this->Hotel_config_model->get_hotel_config ( $inter_id, 'HOTEL', 0, 'NEW_COMMENT');

        return json_decode($config_data['NEW_COMMENT']);

    }


    function change_comment_feedback($inter_id, $comment_id, $status, $hotel_id = null) {    //改变评论回复的状态
        $this->db->where ( 'inter_id', $inter_id );
        $this->db->where ( 'comment_id', $comment_id );
        if (! is_null ( $hotel_id ))
            $this->db->where ( 'hotel_id', $hotel_id );
        return $this->db->update ( self::TAB_HCT, array (
            'feedback' => $status
        ) );
    }


    function match_keyword($keyword,$content){ //匹配评论关键词

        $type = mb_detect_encoding($keyword, array('UTF-8', 'GBK'));

        if($type=='GBK'){
            $keyword=iconv("GBK","UTF-8//IGNORE",$keyword) ;
        }

        $length = (strlen($keyword))/3;

        $count = array();

        foreach($content as $key=>$arr){

            $match = strpos($arr['content'],$keyword);

            if($match !==false){

                if(!isset($count[$arr['hotel_id']])){
                    $count[$arr['hotel_id']]=1;
                }else{
                    $count[$arr['hotel_id']]=$count[$arr['hotel_id']]+1;
                }

            }else{

                for($i=0;$i<$length;$i++){

                    $find = substr($keyword,($i*3),3);

                    $num[$i] = stripos($arr['content'],$find);

                    if(empty($num[$i])){
                        unset($num[$i]);
                        continue;
                    }

                    if($i>0){
                        $k = $i-1;
                        if(isset($num[$i]) && isset($num[$k]) && $num[$i]<$num[$k]){
                            unset($num[$i]);
                            continue;
                        }
                    }

                }

                if(count($num)!=$length){
                    continue;
                }

                if(!isset($count[$arr['hotel_id']])){
                    $count[$arr['hotel_id']]=1;
                }else{
                    $count[$arr['hotel_id']]=$count[$arr['hotel_id']]+1;
                }

            }

        }

        return $count;

    }


    public function update_keyword_count($keyword_id,$count){
        $this->db->where ( 'keyword_id', $keyword_id );
        return $this->db->update ( self::TAB_KEYWORD, array (
            'count' => $count
        ) );
    }


    public function check_keyword($inter_id,$keyword){   //检测关键词是否已经存在

        $keyword = $this->db->get_where ( self::TAB_KEYWORD, array (
            'inter_id' => $inter_id,
            'keyword'=>$keyword
        ) )->row_array ();

        return $keyword;

    }


    public function get_comment_content($inter_id,$status=1){    //获取公众号下所有评论内容

        $this->db->select('content');
        $this->db->select('hotel_id');
        $comment = $this->db->get_where ( self::TAB_HCT, array (
            'inter_id' => $inter_id,
            'status'=>$status
        ) )->result_array ();

        return $comment;

    }


    public function get_hotel_score_from_redis($inter_id,$hotel_ids,$openid=''){    //从redis获取酒店评分


        $ci =& get_instance();
        $ci->load->helper('common');
        $ci->load->library('Cache/Redis_proxy',array(
            'not_init'=>FALSE,
            'module'=>'common',
            'refresh'=>FALSE,
            'environment'=>ENVIRONMENT
        ),'redis_proxy');

        $redis=$ci->redis_proxy;

        $key = $inter_id.'_hotel_comments';

        $hotel_score = $redis->hGetAll($key);

        foreach($hotel_ids as $hotel_id){
            if(!isset($hotel_score[$hotel_id])){
                $new_hotels[] = $hotel_id;
            }
        }


        if(empty($new_hotels)){

            if(!empty($openid)){
                $own_comments = $this->own_comments($inter_id,$openid,2);
                if(!empty($own_comments)){
                    foreach($own_comments as $arr){
                        $own_comment[$arr['hotel_id']] = $arr;
                    }
                }
            }

            foreach($hotel_score as $key=>$arr){
                if(isset($own_comment[$key])){
                    $h_score = json_decode($hotel_score[$key]);
                    $total_count = $h_score->score_count + $own_comment[$key]['score_count'];
                    $new_score['score'] = round(($h_score->score *$h_score->score_count  + $own_comment[$key]['score']) / $total_count,1);
                    $new_score['service_score'] = round(($h_score->service_score * $h_score->score_count  + $own_comment[$key]['service_score']) / $total_count,1);
                    $new_score['net_score'] = round(($h_score->net_score * $h_score->score_count  + $own_comment[$key]['net_score']) / $total_count,1);
                    $new_score['facilities_score'] = round(($h_score->facilities_score * $h_score->score_count  + $own_comment[$key]['facilities_score']) / $total_count,1);
                    $new_score['clean_score'] = round(($h_score->clean_score * $h_score->score_count  + $own_comment[$key]['clean_score']) / $total_count,1);
                    $new_score['score_count'] = $total_count;
                    if(!isset($h_score->good_rate))$h_score->good_rate=100;
                    $new_score['good_rate'] = $h_score->good_rate;
                    $new_score['images_count'] = $h_score->images_count;
                    $hotel_score[$key] = json_encode($new_score);
                }
            }


            return $hotel_score;

        }else{

            $this->set_hotel_score_from_redis($inter_id,$new_hotels);

            $this->get_hotel_score_from_redis($inter_id,$hotel_ids,$openid);

        }


    }


    public function set_hotel_score_from_redis($inter_id,$hotel_ids,$data=array(),$update_id=''){   //设置酒店的评论

        $ci =& get_instance();
        $ci->load->helper('common');
        $ci->load->library('Cache/Redis_proxy',array(
            'not_init'=>FALSE,
            'module'=>'common',
            'refresh'=>FALSE,
            'environment'=>ENVIRONMENT
        ),'redis_proxy');

        $redis=$ci->redis_proxy;

        $key = $inter_id.'_hotel_comments';

        $datas = $this->count_good_rate($inter_id,$hotel_ids,1);

        foreach($datas as $arr){
            $count_datas[$arr['hotel_id']]=$arr;
        }

        $count_res = $this->count_all_score($inter_id,$hotel_ids);  //评分总数
        if(!empty($count_res)){
            foreach($count_res as $arr){
                $count_res_new[$arr['hotel_id']] = $arr;
            }
            $count_res = $count_res_new;
        }

        $have_images = $this->check_images($inter_id,$hotel_ids);
        if(!empty($have_images)){
            foreach($have_images as $arr){
                $have_images_new[$arr['hotel_id']] = $arr;
            }
            $have_images = $have_images_new;
        }

        if(empty($data)){

            foreach($hotel_ids as $hotel_id){
                $data=array();
                $data['good_rate'] = empty ( $count_datas[$hotel_id]['c_s'] ) ? 0 : number_format ( $count_datas[$hotel_id] ['g_s'] / $count_datas[$hotel_id] ['c_s'], 1, '.', '' ) * 100; // 好评率

                if(!empty($count_res[$hotel_id]['score_count'])){
                    $data['score_count']=$count_res[$hotel_id]['score_count'];
                }else{
                    $data['score_count']=0;
                }

                if(!empty($have_images[$hotel_id]['images_count'])){
                    $data['images_count']=$have_images[$hotel_id]['images_count'];
                }else{
                    $data['images_count']=0;
                }

                if(!empty($count_res[$hotel_id]['score'])){
                    $data['score']=($count_res[$hotel_id]['score']/$count_res[$hotel_id]['score_count']);
                }else{
                    $data['score']=0;
                }

                if(!empty($count_res[$hotel_id]['net_score'])){
                    $data['net_score']=($count_res[$hotel_id]['net_score']/$count_res[$hotel_id]['score_count']);
                }else{
                    $data['net_score']=0;
                }

                if(!empty($count_res[$hotel_id]['facilities_score'])){
                    $data['facilities_score']=($count_res[$hotel_id]['facilities_score']/$count_res[$hotel_id]['score_count']);
                }else{
                    $data['facilities_score']=0;
                }

                if(!empty($count_res[$hotel_id]['clean_score'])){
                    $data['clean_score']=($count_res[$hotel_id]['clean_score']/$count_res[$hotel_id]['score_count']);
                }else{
                    $data['clean_score']=0;
                }

                if(!empty($count_res[$hotel_id]['service_score'])){
                    $data['service_score']=($count_res[$hotel_id]['service_score']/$count_res[$hotel_id]['score_count']);
                }else{
                    $data['service_score']=0;
                }


                $data = json_encode($data);

                $res = $redis->hSet($key, $hotel_id, $data);

            }

        }elseif(!empty($update_id)){

            $data = json_encode($data);

            $res = $redis->hSet($key, $update_id, $data);

        }


        if($res==0 || $res==1){

           return  $redis->hGetAll($key);

        }

        return false;

    }


    public function update_hotel_score_from_redis($inter_id,$hotel_id,$data=array(),$action='add'){

//         $scores = $this->get_hotel_score_from_redis($inter_id,array($hotel_id),$openid);

        $ci =& get_instance();
        $ci->load->helper('common');
        $ci->load->library('Cache/Redis_proxy',array(
            'not_init'=>FALSE,
            'module'=>'common',
            'refresh'=>FALSE,
            'environment'=>ENVIRONMENT
        ),'redis_proxy');
        $redis=$ci->redis_proxy;

        $key = $inter_id.'_hotel_comments';

        $scores = $redis->hGetAll($key);

        if($scores){

            $score = json_decode($scores[$hotel_id]);

            if($action=='add'){

                if(!isset($score->score_count)){
                    $score->score_count = 0;
                }

                if(!isset($score->good_rate)){
                    $score->good_rate = 100;
                }


                $post_data=array();
                $post_data['score_count'] = $score->score_count + 1;
                if(isset($data['images'])){
                    $post_data['images_count'] = $score->images_count +1;
                }else{
                    $post_data['images_count'] =  $score->images_count;
                }


                if($data['score']>3){
                    $post_data['good_rate'] = (($score->score_count*$score->good_rate) + 1)/$post_data['score_count'];
                }

                $post_data['score'] = ($score->score*$score->score_count + $data['score'])/$post_data['score_count'];
                $post_data['net_score'] = ($score->score*$score->score_count + $data['net_score'])/$post_data['score_count'];
                $post_data['facilities_score'] = ($score->score*$score->score_count + $data['facilities_score'])/$post_data['score_count'];
                $post_data['clean_score'] = ($score->score*$score->score_count + $data['clean_score'])/$post_data['score_count'];
                $post_data['service_score'] = ($score->score*$score->score_count + $data['service_score'])/$post_data['score_count'];


            }else{

                if(!isset($score->score_count)){
                    $score->score_count = 1;
                }

                if(!isset($score->good_rate)){
                    $score->good_rate = 100;
                }


                $post_data=array();
                $post_data['score_count'] = $score->score_count - 1;
                if(isset($data['images']) && $score->images_count>0){
                    $post_data['images_count'] = $score->images_count -1;
                }else{
                    $post_data['images_count'] =  $score->images_count;
                }


                if($data['score']>3){
                    $post_data['good_rate'] = (($score->score_count*$score->good_rate) - 1)/$post_data['score_count'];
                }

                $post_data['score'] = ($score->score*$score->score_count - $data['score'])/$post_data['score_count'];
                $post_data['net_score'] = ($score->score*$score->score_count - $data['net_score'])/$post_data['score_count'];
                $post_data['facilities_score'] = ($score->score*$score->score_count - $data['facilities_score'])/$post_data['score_count'];
                $post_data['clean_score'] = ($score->score*$score->score_count - $data['clean_score'])/$post_data['score_count'];
                $post_data['service_score'] = ($score->score*$score->score_count - $data['service_score'])/$post_data['score_count'];


            }


            $res = $this->set_hotel_score_from_redis($inter_id,array($hotel_id),$post_data,$hotel_id);

        }else{

            return false;

        }

        return true;

    }


    public function count_all_score($inter_id,$hotel_ids,$status=1){     //统计所有的评分

        $hotel_ids = implode(',',$hotel_ids);

        $sql = "SELECT
                    hotel_id,
                    SUM(score) AS score,
                    SUM(net_score) AS net_score,
                    SUM(facilities_score) AS facilities_score,
                    SUM(clean_score) AS clean_score,
                    SUM(service_score) AS service_score,
                    COUNT(comment_id) AS score_count
              FROM
                  `iwide_hotel_comments`
              WHERE
                   inter_id = '{$inter_id}'
              AND
                  hotel_id in ($hotel_ids)
              AND
                  type = 'user'
              AND
                  score !=''
              AND
                  status = $status
              group by hotel_id
             ";

        return $this->db->query($sql)->result_array();


    }


    public function count_all_comment($inter_id,$hotel_ids,$status=1){   //统计所有评论总数

        $hotel_ids = implode(',',$hotel_ids);

        $sql = "SELECT
                    count(comment_id) as count_total,hotel_id
                FROM
                    `iwide_hotel_comments`
                WHERE
                    inter_id = '{$inter_id}'
                AND
                    hotel_id in ($hotel_ids)
                AND
                    type = 'user'
                AND
                    status = $status
                 GROUP BY hotel_id
        ";

        return $this->db->query($sql)->result_array();

    }


    public function check_images($inter_id,$hotel_ids,$status=1){    //统计有图回复

        $hotel_ids = implode(',',$hotel_ids);

        $sql = "SELECT
                    count(images) as images_count,hotel_id
                FROM
                    `iwide_hotel_comments`
                WHERE
                    inter_id = '{$inter_id}'
                AND
                    hotel_id in ($hotel_ids)
                AND
                    images !=''
                AND
                    status = $status
                 GROUP BY hotel_id
        ";

        return $this->db->query($sql)->result_array();

    }


    public function get_hotel_feedback($inter_id){     //酒店回复

        $this->db->select('content');
        $this->db->select('hotel_id');
        $this->db->select('feedback_comment_id');
        $feedback = $this->db->get_where ( self::TAB_HCT, array (
            'inter_id' => $inter_id,
            'type'=>'hotel'
        ) )->result_array ();

        return $feedback;
    }


    public function get_keyword_by_id($inter_id,$keyword_id){   //获取关键词
        $this->db->select('keyword');
        $keyword = $this->db->get_where ( self::TAB_KEYWORD, array (
            'inter_id' => $inter_id,
            'keyword_id'=>$keyword_id
        ) )->row_array ();

        return $keyword;
    }


    public function get_keyword_log($inter_id,$nums = 5,$offset=1){    //获取操作日志

        $this->db->order_by('log_id','DESC');

        $this->db->like('ident','hotel_comment_keyword','after');

        $start = ($offset-1)*$nums;

        $this->db->limit($nums,$start);

        return $this->db->get_where ( self::TAB_LOG, array (
            'inter_id' => $inter_id
        ) )->result_array ();

    }


    public  function hotel_log_des(){

        return array(
            'add'=>'添加了',
            'del'=>'删除了'
        );

    }


    function check_no_order_comment($inter_id,$openid,$hotel_id){

        $sql = "SELECT
                    *
                FROM
                    `iwide_hotel_comments`
                WHERE
                    inter_id = '{$inter_id}'
                AND
                    openid = '{$openid}'
                AND
                    hotel_id = {$hotel_id}
                AND
                    orderid =''
        ";

        $comment = $this->db->query($sql)->row_array();

        return $comment;

    }


    function set_comment_config($inter_id,$data){

        $insert_data = array(
            'inter_id'=>$inter_id,
            'module'=>'HOTEL',
            'param_name'=>'NEW_COMMENT',
            'param_value'=>json_encode($data),
            'hotel_id'=>0
        );

        return $this->db->insert ( self::TAB_H_CONFIG, $insert_data);

    }



    function update_comment_config($inter_id,$data){

        $this->db->where ( 'inter_id', $inter_id );
        $this->db->where ( 'param_name', 'NEW_COMMENT' );
        $this->db->where ( 'module', 'HOTEL' );

        return $this->db->update ( self::TAB_H_CONFIG, array('param_value'=>json_encode($data)));

    }


    function allCommentConfig(){
        $db = $this->db;
        $this->db->where ( 'param_name', 'NEW_COMMENT' );
        $this->db->where ( 'module', 'HOTEL' );
        return $db->get ( self::TAB_H_CONFIG )->result_array ();
    }


    function deal_configs($data){
        $db = $this->db;
        return $db->insert_string( self::TAB_C_CONFIG,$data);
    }


    function comment_give_bonus($inter_id,$comment_info){    //评论成功发放积分

            $this->load->model('hotel/Order_model');
            $this->load->model('hotel/Member_model');
            $order = $this->Order_model->get_main_order ( $this->inter_id, array (
                'orderid' => $comment_info['orderid'],
                'only_openid' => $comment_info['openid'],
                'isdel' => 0,
                'idetail' => array (
                    'i'
                )
            ) );

            if($order){
                $order=$order[0];
            }else{
                $this->db->where ( array (
                    'comment_id' => $comment_info ['comment_id'],
                    'inter_id' => $inter_id
                ) );
                $this->db->update ( self::TAB_HCT, array (
                    'point_give' => 2
                ) );
                return;
            }

            $point_given=$this->Member_model->check_point_giverules( $inter_id, $order, 'comment_complete', array (
                'hotel' => $order ['hotel_id'],
                'rooms' => $order ['roomnums'],
                'product_num' => $order ['roomnums'],
                'price_code' => $order ['first_detail'] ['price_code'],
            ) );

        if ($point_given ['code'] == 1) {
            $point_reward = $this->Member_model->give_point ( $inter_id, $order ['orderid'], $order ['openid'], $point_given ['result']['give_amount'], '订单评论，赠送积分' );
            if($point_reward){
                $this->db->where ( array (
                    'comment_id' => $comment_info ['comment_id'],
                    'inter_id' => $inter_id
                ) );
                $give_info['comment_give'] = $point_given ['result'];
                $this->db->update ( self::TAB_HCT, array (
                    'comment_info' => json_encode ( $give_info ),
                    'point_give' => 1
                ) );
            }else{
                $this->db->where ( array (
                    'comment_id' => $comment_info ['comment_id'],
                    'inter_id' => $inter_id
                ) );
                $this->db->update ( self::TAB_HCT, array (
                    'point_give' => 2
                ) );
            }
        } else {
            $this->db->where ( array (
                'comment_id' => $comment_info ['comment_id'],
                'inter_id' => $inter_id
            ) );
            $this->db->update ( self::TAB_HCT, array (
                'point_give' => 2
            ) );
        }

    }


    function count_good_rate($inter_id,$hotel_ids,$status=1){     //统计好评率

        $select = "hotel_id,count( case when content!='' then 1 else NULL end) c_n, count( case when score!=0 and score!='' then 1 else NULL end) c_s, sum(score) t_s,count(case when score>3 then 1 else NULL end) g_s";
        $this->db->select ( $select );
        if (empty ( $hotel_ids )) {
            $this->db->group_by ( 'inter_id' );
        } else {
            $this->db->where_in ( 'hotel_id', $hotel_ids );
            $this->db->group_by ( 'hotel_id' );
        }
        $this->db->where ( array (
            'inter_id' => $inter_id
        ) );
        $this->db->where ( 'status', $status );

        return $this->db->get ( self::TAB_HCT )->result_array ();

    }


    function own_comments($inter_id,$openid,$status=2,$hotel_id=''){   //用户个人所有评论

        $select = "hotel_id,
                    SUM(score) AS score,
                    SUM(net_score) AS net_score,
                    SUM(facilities_score) AS facilities_score,
                    SUM(clean_score) AS clean_score,
                    SUM(service_score) AS service_score,
                    COUNT(comment_id) AS score_count";

        $this->db->select ( $select );
        $this->db->where('inter_id',$inter_id);
        $this->db->where('type','user');
        $this->db->where('openid',$openid);
        $this->db->where('status',$status);

        if(!empty($hotel_id)){
            $this->db->where('hotel_id',$hotel_id);
        }

        $this->db->group_by ( 'hotel_id' );

        return $this->db->get ( self::TAB_HCT )->result_array ();

    }




    function match_single_comment($keyword,$content){    //单个评论关键词匹配

        $type = mb_detect_encoding($keyword, array('UTF-8', 'GBK'));

        if($type=='GBK'){
            $keyword=iconv("GBK","UTF-8//IGNORE",$keyword) ;
        }

        $length = (strlen($keyword))/3;

        $match = strpos($content['content'],$keyword);

        if($match !==false){
            return true;
        }else{
            return false;
        }

    }


    function check_comment_feedback($inter_id,$comment_id){  //检查评论是否已回复

        $this->db->where('inter_id',$inter_id);
        $this->db->where('feedback_comment_id',$comment_id);

        return $this->db->get ( self::TAB_HCT )->row_array ();

    }


    function get_feedbacks($comment_ids,$inter_id,$status=1){

        $this->db->select('comment_id,status,feedback_comment_id,content,comment_time as feedback_time');

        $this->db->where('inter_id',$inter_id);
        $this->db->where('status',$status);
        $this->db->where_in('feedback_comment_id',$comment_ids);

        $this->db->order_by('comment_id','desc');

        return $this->db->get ( self::TAB_HCT )->result_array ();
    }


}