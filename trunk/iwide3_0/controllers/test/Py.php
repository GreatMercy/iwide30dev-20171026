<?php

/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2016/11/11
 * Time: 16:18
 */
class Py extends MY_Controller{
	public function index(){
		ini_set('display_errors','Off');
		set_time_limit(900);
		$json=file_get_contents(FD_PUBLIC.'/tmp_data/city.json');
		$list=json_decode($json,true);
		$this->load->helper('string');
		$this->load->helper('pinyin');
		$res=[];
		$fix=[];
		foreach($list as $v){
			$str=$v['city'];
			if($str){
				$str=mb_substr($str,0,1,'UTF-8');
				$fix[]=$str;
			}
		}
		$fix = array_unique($fix);
		foreach($fix as $str){
			$py=get_first_py($str);
			if(!$py){
				$f=mb_substr($str,0,1,'utf-8');
				echo '\''.$f.'\'=>\''.strtoupper(pinyin($str,'one')).'\','."\n";
			}
		}
	}
}
?>