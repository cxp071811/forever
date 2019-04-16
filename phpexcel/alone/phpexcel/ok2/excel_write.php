<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/11
 * Time: 9:56
 */

require "../PHPExcel-1.8/Classes/PHPExcel.php";


$excel=new PHPExcel();
//$excel->createSheet();
$excel->setActiveSheetIndex(0);
//$excel->getActiveSheet()->setCellValue('E4','中文');

//$excel->getActiveSheet()->setTitle('Simple');



$excel->getActiveSheet()->fromArray(
    array(
        array('',	2010,	2011,	2012),
        array('Q1',   12,   15,		21),
        array('Q2',   56,   73,		86),
        array('Q3',   52,   61,		69),
        array('Q4',   30,   32,		0),
    )
);


$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$objWriter->save('adsf.xlsx');
//$callEndTime = microtime(true);


