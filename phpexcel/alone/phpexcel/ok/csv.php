<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/10
 * Time: 10:54
 */

$data=array(
    array("username"=>"中文","password"=>"123"),
    array("username"=>"test2","password"=>"456"),
    array("username"=>"test3","password"=>"789"),
);
export_csv($data);
function export_csv($data)
{
    $string="";
    foreach ($data as $key => $value)
    {
        foreach ($value as $k => $val)
        {
            $value[$k]=iconv('utf-8','gb2312',$value[$k]);
        }

        $string .= implode(",",$value)."\n"; //用英文逗号分开
    }
    $filename = date('Ymd').'.csv'; //设置文件名
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=".$filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo $string;
}
?>