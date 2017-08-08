<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Memberlist extends MY_Admin_Cprice
{
	protected $label_action= '会员列表';
	
	protected function main_model_name()
	{
		return 'member/admin/grid/gridmember';
	}
	
	public function grid()
	{ 
		$this->load->model('member/member');
		$inter_id= $this->session->get_admin_inter_id();

		if($inter_id == FULL_ACCESS) {
			$filter= array();
		} else if($inter_id) {
			$filter= array(Member::TABLE_MEMBER.'.inter_id'=>$inter_id );
		} else {
			$filter= array(Member::TABLE_MEMBER.'.inter_id'=>'deny' );
		}
		/* 兼容grid变为ajax加载加这一段 */
		if(is_ajax_request())
		    //处理ajax请求，参数规格不一样
		    $get_filter= $this->input->post();
		else
		    $get_filter= $this->input->get('filter');
		
		if( !$get_filter) $get_filter= $this->input->get('filter');
		
		if(is_array($get_filter)) $filter= $get_filter+ $filter;

        if(!empty($_GET['searchAll'])){

            $con=$_GET['searchAll'];

                $get=addslashes($con);

                $condition=" AND (
                                t2.name like '%{$get}%'
                            OR  t1.mem_card_no like '%{$get}%'
                            OR  t2.membership_number  like '%{$get}%'
                          )
            ";




            $filter['sql']="SELECT
                                t1.mem_id,t1.inter_id,t2.name,t1.mem_card_no,t1.level,t2.membership_number,t1.bonus,t1.balance
                            FROM
                                `iwide_member` as t1,
                                `iwide_member_additional` as t2
                           WHERE
                                 t1.inter_id='{$inter_id}'
                           AND
                                 t1.mem_id = t2.mem_id".$condition;


            $this->m_grid ( $filter );

        }else{

            /* 兼容grid变为ajax加载加这一段 */
            $this->_grid($filter);
        }
	}
	
	public function edit()
	{
		$memid = $this->input->get('ids');
		
		if($memid) {
			$this->load->model('member/imember');
			$data['levels'] = $this->imember->getAllMemberLevels();
			$data['meminfo'] = $this->imember->getMemberDetailByMemId($memid);
			
			$html= $this->_render_content($this->_load_view_file('edit'), $data, false);
		
		    echo $html;
		} else {
			exit;
		}
	}
	
	public function owners(){
		$this->load->model('member/member');
		$inter_id= $this->session->get_admin_inter_id();
		
		$this->load->library('pagination');
		$config['per_page']          = 20;
		// PHP5.3 下报错
		//$page = empty($this->uri->segment(4)) ? 0 : ($this->uri->segment(4) - 1) * $config['per_page'];
		$segment4= $this->uri->segment(4);
		$page = empty($segment4) ? 0 : ($segment4 - 1) * $config['per_page'];
		
		$key = $this->input->get_post('key');
		$config['use_page_numbers']  = TRUE;
		$config['cur_page']          = $page;
		$config['uri_segment']       = 4;
		// 		$config['suffix']            = $sub_fix;
		if($key){
			$config['suffix']            = '?key='.$key;
		}
		$config['numbers_link_vars'] = array('class'=>'number');
		$config['cur_tag_open']      = '<a class="number current" href="#">';
		$config['cur_tag_close']     = '</a>';
		$config['base_url']          = site_url("member/memberlist/owners");
		$config['total_rows']        = $this->member->getUnAuthMembersCount($inter_id,$key);
		$config['cur_tag_open'] = '<li class="paginate_button active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="paginate_button">';
		$config['num_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="paginate_button first">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="paginate_button last">';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="paginate_button previous">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="paginate_button next">';
		$config['next_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		$view_params= array(
				'pagination' => $this->pagination->create_links(),
				'res'        => $this->member->getUnAuthMembers($inter_id,$config['per_page'],$config['cur_page'],$key),
		);
		echo $this->_render_content($this->_load_view_file('owners'), $view_params, false);
	}
	public function auth_member(){
		$this->load->model('member/member');
		$this->load->model('member/imember');
		$rec_ids = $this->input->post('ids');
		$err_count = 0;
		$suc_count = 0;
		if(is_array($rec_ids)){
			foreach ($rec_ids as $item){
				$local_member = $this->member->getMemberById($item,'mem_id');
				$local_member_info = $this->member->getMemberInfoById($item,'mem_id');
				$res = $this->imember->getPmsMemberCard($local_member_info->telephone,'',1,$local_member_info->inter_id,0);
				if($this->__auth($res,$local_member,$local_member_info)){
					$suc_count += 1;
				}else{
					$err_count += 1;
				}
			}
		}else{
			$local_member = $this->member->getMemberById($rec_ids,'mem_id');
			$local_member_info = $this->member->getMemberInfoById($rec_ids,'mem_id');
			$res = $this->imember->getPmsMemberCard($local_member_info->telephone,'',1,$local_member_info->inter_id,0);
			if($this->__auth($res,$local_member,$local_member_info)){
				$suc_count += 1;
			}else{
				$err_count += 1;
			}
		}
		echo "成功通过:".$suc_count."人，失败:".$err_count."人"; 
		exit;
		
	
	}
	private function __auth($res,$local_member,$local_member_info){
		if ($res) {
			$res = $this->imember->upgradeLevel ( $res->Ic_num, $local_member_info->inter_id, 0 );
			
			if ($res->UpdateIcTypResult === true) {
				$this->db->where ( array ( 'mem_id' => $local_member->mem_id, 'is_login' => 1 ) );
				$this->db->limit ( 1 );
				$this->db->update ( 'member', array ( 'level' => 2 ) );
				$this->db->where ( array ( 'ma_id' => $local_member_info->ma_id ) );
				$this->db->limit ( 1 );
				$this->db->update ( 'member_additional', array ( 'audit' => 2 ) );
				return true;
			} else {
				return false;
			}
		} else {
			$id = $this->input->get ( 'id' );
			$data = array (
					'name'      => $local_member_info->name,
					'telephone' => $local_member_info->telephone,
					'password'  => $local_member_info->password,
					'level'     => 'R',
					'crtf_typ'  => $local_member_info->member_type,
					'crtf_num'  => $local_member_info->owner_no 
			);
			$result = $this->imember->registerMember ( $local_member->openid, $data, $local_member_info->inter_id, 0 );
			if ($result && $result ['code'] == 1) {
				$res = $this->imember->getPmsMemberCard ( $local_member_info->telephone, '', 1, $local_member_info->inter_id, 0 );
				$this->db->where ( array ( 'mem_id' => $local_member->mem_id, 'is_login' => 1 ) );
				$this->db->limit ( 1 );
				$this->db->update ( 'member', array ( 'level' => 2 ) );
				$this->db->where ( array ( 'ma_id' => $local_member_info->ma_id ) );
				$this->db->limit ( 1 );
				$this->db->update ( 'member_additional', array ( 'audit' => 2, 'membership_number' => $res->Ic_num ) );
				return true;
			} else {
				return false;
			}
		}
	}
	public function unbinding(){
		$memid = $this->input->get('ids');
		$inter_id= $this->session->get_admin_inter_id();
		if($memid) {
            $memid_array=explode(",",$memid);

            foreach($memid_array as $memid){

                $this->load->model('member/imember');
                $data['levels'] = $this->imember->getAllMemberLevels($inter_id,0);
                $data['meminfo'] = $this->imember->getMemberDetailByMemId($memid,$inter_id,0);

                $this->load->model('member/member');

                if($data['meminfo']->membership_number){

                    $updateParams = array(
                        'membership_number' => ''
                    );

                    $this->member->updateMemberInfoById($data['meminfo']->ma_id,$updateParams);

                }

                $updateParams = array(
                    'openid'           => $data['meminfo']->openid,
                    'level'            => 0,
                    'is_login'         => 0,
                    'is_active'        => 0,
                    'last_login_time'  => time()
                );
                $this->member->updateMemberByOpenId($updateParams);

            }
            redirect('member/memberlist/grid');
			exit;
		} else {
			exit;
		}
	}



    public function applyOwners()
    {
        $this->load->model('member/member');
        $inter_id= $this->session->get_admin_inter_id();

        if($inter_id == FULL_ACCESS) {
            $filter= array();
        } else if($inter_id) {
            $filter= array(Member::TABLE_MEMBER_INFO.'.inter_id'=>$inter_id );
        } else {
            $filter= array(Member::TABLE_MEMBER_INFO.'.inter_id'=>'deny' );
        }
        /* 兼容grid变为ajax加载加这一段 */
        if(is_ajax_request())
            //处理ajax请求，参数规格不一样
        $get_filter= $this->input->post();
        else
            $get_filter= $this->input->get('filter');

        if( !$get_filter) $get_filter= $this->input->get('filter');

        if(is_array($get_filter)) $filter= $get_filter+ $filter;

        if(!empty($_GET['searchAll'])){

            $con=$_GET['searchAll'];

            $get=addslashes($con);

            $condition=" AND (
                                t2.name like '%{$get}%'
                            OR  t1.mem_card_no like '%{$get}%'
                            OR  t2.membership_number  like '%{$get}%'
                          )
            ";




            $filter['sql']="SELECT
                                membership_number,name,telephone,member_type,owner_name,identity_card
                            FROM
                                `iwide_member_additional`
                           WHERE
                                 inter_id='{$inter_id}'
                           AND
                                 member_type !=0";


            $this->m_grid ( $filter );

        }else{

            /* 兼容grid变为ajax加载加这一段 */
            $this->m_grid($filter);
        }
    }

}