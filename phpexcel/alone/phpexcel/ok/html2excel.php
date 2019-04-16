<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/10
 * Time: 10:36
 */

$dataResult = array();      //todo:导出数据（自行设置）

$headTitle = "XX保险公司 优惠券赠送记录";

$title = "优惠券记录";

$headtitle= "<tr style='height:50px;border-style:none;><th border=\"0\" style='height:60px;width:270px;font-size:22px;' colspan='11' >{$headTitle}</th></tr>";

$titlename = "<tr> 

               <th style='width:70px;' >合作商户</th> 

               <th style='width:70px;' >会员卡号</th> 

               <th style='width:70px;'>车主姓名</th> 

               <th style='width:150px;'>手机号</th> 

               <th style='width:70px;'>车牌号</th> 

               <th style='width:100px;'>优惠券类型</th> 

               <th style='width:70px;'>优惠券名称</th> 

               <th style='width:70px;'>优惠券面值</th> 

               <th style='width:70px;'>优惠券数量</th> 

               <th style='width:70px;'>赠送时间</th> 

               <th style='width:90px;'>截至有效期</th> 

           </tr>";

$filename = $title.".xls";

excelData($dataResult,$titlename,$headtitle,$filename);


/*

*处理Excel导出

*@param $datas array 设置表格数据

*@param $titlename string 设置head

*@param $title string 设置表头

*/

 function excelData($datas,$titlename,$title,$filename){

    $str = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>";

    $str .="<table border=1><head>".$titlename."</head>";

    $str .= $title;

    foreach ($datas as $key=> $rt )

    {

        $str .= "<tr>";

        foreach ( $rt as $k => $v )

        {

            $str .= "<td>{$v}</td>";

        }

        $str .= "</tr>\n";

    }

    $str .= "</table></body></html>";

    header( "Content-Type: application/vnd.ms-excel; name='excel'" );

    header( "Content-type: application/octet-stream" );

    header( "Content-Disposition: attachment; filename=".$filename );

    header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );

    header( "Pragma: no-cache" );

    header( "Expires: 0" );

    exit( $str );

}