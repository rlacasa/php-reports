<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

class XlsxReportFormat extends XlsReportBase {
	public static function display(&$report, &$request) {
		// First let set up some headers
		$file_name = preg_replace(array('/[\s]+/','/[^0-9a-zA-Z\-_\.]/'),array('_',''),$report->options['Name']);

		//always use cache for Excel reports
		$report->use_cache = true;

		//run the report
		$report->run();

		if(!$report->options['DataSets']) return;

		$objPHPExcel = parent::getExcelRepresantation($report);

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
		header('Pragma: no-cache');
		header('Expires: 0');
		
		$objWriter->save('php://output');
	}
}
