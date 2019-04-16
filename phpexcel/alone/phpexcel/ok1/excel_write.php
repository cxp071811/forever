<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/10
 * Time: 14:31
 */
include "../PHPExcel-1.8/Classes/PHPExcel.php";

//require_once dirname(__FILE__) . '/../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

$excel=new PHPExcel();
$excel->createSheet();
$excel->setActiveSheetIndex(0);
$excel->getActiveSheet()->fromArray([
    array(1,"中文",123),
    array(1123,"中文123",121233),
]);


$objWriter=PHPExcel_IOFactory::createWriter($excel,'Excel5');//生成excel文件


$objWriter->save(str_replace('.php', '.xls', __FILE__));
