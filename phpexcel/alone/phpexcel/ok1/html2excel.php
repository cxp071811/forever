<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2018/8/10
 * Time: 13:54
 */
//<meta http-equiv=Content-Type content="text/html; charset=utf-8">
$a="

<table>
<thead>
<tr>
<th>課程</th>
<th>班級</th>
<th>分數</th>
</tr>
</thead>
<tbody>
<tr>
<td>語文</td>
<td>五班</td>
<td>66</td>
</tr>
</tbody>
</table>
";

//$a = "\xEF\xBB\xBF" . $a;
$filename = date('Ymd').'.xls'; //设置文件名
header( "Content-Type: application/vnd.ms-excel; name='excel'" );

header( "Content-type: application/octet-stream" );

header( "Content-Disposition: attachment; filename=".$filename );

header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );

header( "Pragma: no-cache" );

header( "Expires: 0" );

exit( $a );