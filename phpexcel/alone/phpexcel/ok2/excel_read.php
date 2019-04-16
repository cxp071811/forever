<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/11
 * Time: 10:49
 */
//require "../PHPExcel-1.8/Classes/PHPExcel.php";


require "../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";//引入读取excel的类文件
//$excel=new PHPExcel();
//$excel->createSheet();

$filename = "01simple.xls";


$fileType = PHPExcel_IOFactory::identify($filename);//自动获取文件的类型提供给phpexcel用
$objReader = PHPExcel_IOFactory::createReader($fileType);//获取文件读取操作对象
$objPHPExcel = $objReader->load($filename);//加载文件
//

$sheetCount = $objPHPExcel->getSheetCount();//获取excel文件里有多少个sheet
for ($i = 0; $i < $sheetCount; $i++) {
    $data = $objPHPExcel->getSheet($i)->toArray();//读取每个sheet里的数据 全部放入到数组中
    print_r($data);
}