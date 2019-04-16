<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/11
 * Time: 9:14
 */
$a=[
    array(1,"中文"),
    array(2,"中文123")
];

// 1,中文
$b='';
foreach ($a as $k=>$v){
    $b.=implode(',',$v)."\n";
}
//var_dump($b);exit;

//$b=iconv('utf-8','gb2312',$b);
//$b="\xef\xbb\xbf".$b;



$filename = date('Ymd').'.csv'; //设置文件名
header("Content-type:text/csv");
header("Content-Disposition:attachment;filename=".$filename);
header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
header('Expires:0');
header('Pragma:public');
echo $b;

