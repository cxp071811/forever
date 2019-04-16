<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/10
 * Time: 14:31
 */
require_once dirname(__FILE__) . '/../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

$filename="./excel_write.xls";
$fileType=PHPExcel_IOFactory::identify($filename);//自动获取文件的类型提供给phpexcel用
//$objReader=PHPExcel_IOFactory::createReader($fileType);//获取文件读取操作对象


$objReader = PHPExcel_IOFactory::createReader($fileType);
$objPHPExcel = $objReader->load($filename);


echo '<hr />';

$data=$objPHPExcel->getSheet(0)->toArray();//读取每个sheet里的数据 全部放入到数组中

var_dump($data);
//exit;
$objPHPExcel->setActiveSheetIndex(0); //设置第一个工作表为活动工作表

$sheetData = $objPHPExcel->getActiveSheet()->toArray();
var_dump($sheetData);
