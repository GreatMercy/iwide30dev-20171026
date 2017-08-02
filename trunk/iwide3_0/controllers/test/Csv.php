<?php

class Csv extends CI_Controller{
	private $letters = array(
		'A',
		'B',
		'C',
		'D',
		'E',
		'F',
		'G',
		'H',
		'I',
		'J',
		'K',
		'L',
		'M',
		'N',
		'O',
		'P',
		'Q',
		'R',
		'S',
		'T',
		'U',
		'V',
		'W',
		'X',
		'Y',
		'Z'
	);

	public function downexcel(){
		$this->load->library('PHPExcel', NULL, 'excel');

//		$json = $this->json_data();
		$json = $this->get_rooms();
//		print_r($json);exit;
		$hotel_list = json_decode($json, TRUE);

		$this->excel->setActiveSheetIndex(0);

		$hotel_count = count($hotel_list);
		$first = $hotel_list[0];
		$column = count($first);
		$i = 0;
		foreach($first as $k => $v){
			$this->excel->getActiveSheet()->setCellValue($this->letters[$i] . '1', $k);
			$i++;
		}

		for($i = 0; $i < $hotel_count; $i++){
			//酒店数据
			$v = $hotel_list[$i];
			//行
			$j = $i + 2;
			$f = 0;
			foreach($v as $t){
				$this->excel->getActiveSheet()->setCellValue($this->letters[$f] . $j, $t);
				$f++;
			}
		}

		$excel_write = new PHPExcel_Writer_Excel2007($this->excel);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");;
		header('Content-Disposition:attachment;filename="resume.xlsx"');
		header("Content-Transfer-Encoding:binary");

		$excel_write->save('php://output');

//		$excel_write->save('demo.xlsx');

	}

	public function readxlsx(){
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/qinde_hotels.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
//		$highestColumm = $sheet->getHighestColumn(); // 取得总列数
//		$highestColumm = PHPExcel_Cell::columnIndexFromString($highestColumm); //字母列转换为数字列 如:AA变为27

		$json = file_get_contents(FD_PUBLIC . '/qinde/kezhan_additions.json');
		$_hotels = json_decode($json, TRUE);
		$hotels=array();
		foreach($_hotels as $v){
			$hotels[$v['hotel_id']]=$v['hotel_web_id'];
		}

		$sql = '';

		/** 循环读取每个单元格的数据 */
		$val_arr = array();
		for($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
			if(!isset($hotels[(int)$sheet->getCell('A' . $row)->getValue()])){
				$val_arr[] = "('" . $sheet->getCell('B' . $row)->getValue() . "','" . (int)$sheet->getCell('A' . $row)->getValue() . "','kezhan','" . json_encode(array(
					                                                                                                                                                                                         'url'  => 'http://a.qininn.com:10008/JfkSoap',
					                                                                                                                                                                                         'user' => 'jfksoap',
					                                                                                                                                                                                         'pwd'  => 'jfk.qdkz.2016'
				                                                                                                                                                                                         )) . "','" . $sheet->getCell('G' . $row)->getValue() . "',3,1)";
			}

//			$sql .= "update iwide_hotel_additions set hotel_web_id = '" . $sheet->getCell('G' . $row)->getValue() . "' where hotel_id = " . (int)$sheet->getCell('A' . $row)->getValue() . " and inter_id='" . $sheet->getCell('B' . $row)->getValue() . "'" . "\n";
			/*for ($column = 0; $column < $highestColumm; $column++) {//列数是以第0列开始
				$columnName = PHPExcel_Cell::stringFromColumnIndex($column);
				echo $columnName.$row.":".$sheet->getCellByColumnAndRow($column, $row )->getValue()."<br />";
			}*/
		}
		if($val_arr){
			$sql .= "insert into iwide_hotel_additions (inter_id,hotel_id,pms_type,pms_auth,hotel_web_id,pms_room_state_way,pms_member_way)";
			$sql .= " values " . implode(',', $val_arr) . ";\n";
		}

		/*$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/qinde_rooms.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		for($row = 2; $row <= $highestRow; $row++){
			if($sheet->getCellByColumnAndRow(5, $row)->getValue()){
				$sql .= "update iwide_hotel_rooms set webser_id = '" . $sheet->getCell('F' . $row)->getValue() . "' where room_id = '" . (int)$sheet->getCell('D' . $row)->getValue() . "' and inter_id = '" . $sheet->getCell('A' . $row)->getValue() . "';" . "\n";
			}
		}*/

		echo $sql;

	}

	private function json_data(){
		return file_get_contents(FD_PUBLIC . '/qinde_hotel.json');
	}

	private function get_rooms(){
		return file_get_contents(FD_PUBLIC . '/qinde_rooms.json');
	}
}