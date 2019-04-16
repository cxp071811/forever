<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/10
 * Time: 10:55
 */

header("Content-Type:text/html;charset=utf-8");


$dir=dirname(__FILE__).'/../';//找到当前脚本所在路径
require $dir."/PHPExcel-1.8/Classes/PHPExcel.php";//引入读取excel的类文件


$excel=new PHPExcel();//新建excel
$excel->createSheet();
$excel->setActiveSheetIndex(0);
$current_sheet=$excel->getActiveSheet();//获取当前活动sheet
$current_sheet->setTitle('年级');//给当前活动sheet起个名称

$current_sheet->fromArray(array(
    array(1,123,123),
    array('中文','123'),
    array('dasf','123'),
));
//$current_sheet->setCellValue();

/** Include PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
$objWriter=PHPExcel_IOFactory::createWriter($excel,'Excel5');//生成excel文件


$objWriter->save(str_replace('.php', '.xls', __FILE__));