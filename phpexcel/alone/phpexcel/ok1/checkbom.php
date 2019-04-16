<?php
function checkBOM($filename)
{
    if (!file_exists($filename)) {
        return FALSE;
    }
    $contents   = file_get_contents($filename);
    $charset[1] = substr($contents, 0, 1);
    $charset[2] = substr($contents, 1, 1);
    $charset[3] = substr($contents, 2, 1);
    if (ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191) {
        return TRUE;
    }
    return FALSE;
}

$msg = "你好\n";
//如果默认编码不是utf8,先用函数utf8_encode将所需写入的数据变成UTF编码格式。
//$msg = utf8_encode($msg);
//$msg = iconv('gbk', 'utf-8', $msg);

$fileName = 'test';
$filePath = './test.txt';
$checkBom = checkBOM($filePath);
// 有bom的情况下"\xEF\xBB\xBF"第一次写入这段字符不可缺少
if ($checkBom == FALSE) {
    $msg = "\xEF\xBB\xBF" . $msg;
}
$fp = @fopen($filePath, 'a');
@fwrite($fp, $msg);
@fclose($fp);