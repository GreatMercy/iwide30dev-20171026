<?php
//!isset($_SERVER['SERVER_PROTOCOL']) OR exit('No direct script access allowed');
class Auto_group extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
		echo 'arrival';
	}
	//统计，根据设定的自动分组信息，将分销员进行分组
		public function auto_group_run(){
			exit('ple in front!');
		set_time_limit(0);
		@ini_set('memory_limit','256M');
		$this->load->model('distribute/distribute_group_model');
		$start = date('Y-m-d H:i:s').' : '.microtime(TRUE).' 开始...';
		$this->distribute_group_model->write_log($start);
		//遍历inter_id
		$inter_ids = $this->distribute_group_model->get_all_inter_id();
		if(!empty($inter_ids)){
			foreach($inter_ids as $inter_id){
				//更新分组status 获取符合条件的分组（自动组）
				$group_ids = $this->distribute_group_model->get_all_zd_group_by_inter_id($inter_id['inter_id']);//var_dump($group_ids);
				if(!empty($group_ids)){
					foreach($group_ids as $group){
						//获取符合条件的人员信息 进行统计
						$saler_ids = $this->distribute_group_model->get_salers_info_list($inter_id['inter_id'],$group);//var_dump($saler_ids);
						if(!empty($saler_ids)){
							//根据分销号查询统计
							foreach($saler_ids as $saler){
								$res = $this->distribute_group_model->check_count_result($inter_id['inter_id'],$saler['qrcode_id'],$group);
								if($res && is_array($res)){//不为false 返回数组信息
									//插入$res = $this->db->insert('distribute_group',$data);
									/*
									 * */
									//根据分销号和返回的周期数判断该周期是否已经添加记录 有添加记录 做更新里，没有在插入
									$member_record = $this->distribute_group_model->get_member_record($res['week_num'],$group['group_id'],$saler['qrcode_id']);
									if(empty($member_record)){
										$res['saler_id'] = $saler['qrcode_id'];
										$res['openid'] = $saler['openid'];
										$res['saler_name'] = $saler['name'];
										$res['group_id'] = $group['group_id'];
										$res['create_time'] = time();
										$res['status'] = 1;
										$insert = $this->db->insert('distribute_group_member',$res);
										if($insert){
											$log  = 'member_insert_success|'. date('Y-m-d H:i:s').' : '.microtime(TRUE).' done...';
											$this->distribute_group_model->write_log($log);
										}else{
											$log  = 'member_insert_error|'. date('Y-m-d H:i:s').' : '.microtime(TRUE).' done...';
											$this->distribute_group_model->write_log($log);
										}
									}else{//有记录 更新
										if(($res['total_income'] != $member_record['total_income']) || ($res['complete_count'] != $member_record['complete_count'])){
											if($res['complete_count'] != $member_record['complete_count']){
												$data['complete_time'] = time();//次数变化需要更新完成时间
											}
											$data['complete_count'] = $res['complete_count'];
											$data['total_income'] = $res['total_income'];
											$update = $this->db->update('distribute_group_member',$data,array('id'=>$member_record['id']));
											if($insert){
												$log  = 'member_update_success|'. date('Y-m-d H:i:s').' : '.microtime(TRUE).' done...';
												$this->distribute_group_model->write_log($log);
											}else{
												$log  ='member_update_error'. date('Y-m-d H:i:s').' : '.microtime(TRUE).' done...'.json_encode($res);
												$this->distribute_group_model->write_log($log);
											}
										}
									}
								}
							}
						}
						//每个组更新完后，统计组内人员
						$count_res = $this->distribute_group_model->get_group_member_count_group_by_openid($group);
						$this->db->update('distribute_group',array('his_member_count'=>$count_res['his_count'],'member_count'=>$count_res['week_count']),array('group_id'=>$group['group_id']));
					}
				}
			}
		}
		$end = date('Y-m-d H:i:s').' : '.microtime(TRUE).' 结束...';
		$this->distribute_group_model->write_log($end);
		echo 'done!';die;
	}

}