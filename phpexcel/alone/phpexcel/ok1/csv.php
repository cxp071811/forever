<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/10
 * Time: 13:49
 */
$array=[array(1,2,4),
    array('中文','1')
];
//$string='';
$string = "\xEF\xBB\xBF";
foreach ($array as $k=>$v){
    $string.=implode(',',$v)."\n";
}
//$string=iconv('utf-8','gb2312',$string);

// if (mb_detect_encoding()($string) == 'UTF-8') {
//$string = iconv("UTF-8//IGNORE", "GBK", $string);
//}
$filename = date('Ymd').'.csv'; //设置文件名
header("Content-type:text/csv");
header("Content-Disposition:attachment;filename=".$filename);
header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
header('Expires:0');
header('Pragma:public');
echo $string;

