<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/11
 * Time: 9:39
 */

$a = "
<table>
<thead>
<tr>
<th style='color: #ffb454'>adsf</th>
<th>中文</th>
</tr>
</thead>
<tbody>
<tr>
<td>123</td>
<td>123</td>
</tr>
</tbody>
</table>
";

$a = "\xEF\xBB\xBF" . $a;
$filename = date('Ymd').'.xls'; //设置文件名
header( "Content-Type: application/vnd.ms-excel; name='excel'" );

header( "Content-type: application/octet-stream" );

header( "Content-Disposition: attachment; filename=".$filename );

header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );

header( "Pragma: no-cache" );

header( "Expires: 0" );

exit( $a );
