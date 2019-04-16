<?php
namespace app\phpexcel\controller;
use think\Db;
//use think\db;
use think\Controller;
use think\Loader;
class Index extends Controller
{
    public function index()
    {
        echo 1;
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }



    public function exportExcel(){
        ini_set('memory_limit', '1024M');//设置php允许的文件大小最大值
        Loader::import('PHPExcel.Classes.PHPExcel');//必须手动导入，否则会报PHPExcel类找不到
        $objPHPExcel = new \PHPExcel();
        $worksheet = $objPHPExcel->getActiveSheet();
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '昵称')
            ->setCellValue('B1', '链接')
            ->setCellValue('C1', '房间号')
            ->setCellValue('D1', '分组');
// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.date('Ymd').'.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');




        exit;
    }




    public function insertExcelform(){
        return $this->fetch('insertExcel');

    }

    //可以卸载insertexcel中，判断是否为post
    public function insertExcel(){
        Loader::import('PHPExcel.Classes.PHPExcel');
//        Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory');
//        Loader::import('PHPExcel.Classes.PHPExcel.Reader.Excel5');
        //获取表单上传文件
        $file = request()->file('excel');
        $info = $file->validate(['ext' => 'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            if(empty($info)) {
                return error('导入失败!');
            }
            $exclePath = $info->getSaveName();  //获取文件名
            //上传文件的地址
            $filename = ROOT_PATH . 'public' . DS . 'uploads' . DS . $exclePath;
            //判断版本，这里有的网上的版本没有进行判断，导致会报大概这样的错误：
            //Warning: ZipArchive::getFromName() [ziparchive.getfromname]: Invalid or unitialized ，这里加上这个判断就可以了
            $extension = strtolower( pathinfo($filename, PATHINFO_EXTENSION) );

//            $filename

            if($extension == 'xlsx') {
                $objReader =\PHPExcel_IOFactory::createReader('Excel2007');
                //加载文件内容,编码utf-8
                $objPHPExcel = $objReader->load($filename, $encode = 'utf-8');
            }else if($extension == 'xls'){
                $objReader =\PHPExcel_IOFactory::createReader('Excel5');
                $objPHPExcel = $objReader->load($filename, $encode = 'utf-8');
            }else{
                return error('请上传excel格式的文件!');
            }
            $excel_array=$objPHPExcel->getsheet(0)->toArray();   //转换为数组格式
            array_shift($excel_array);  //删除第一个数组(标题);

            $data = [];
            foreach($excel_array as $k=>$v) {
                //data数组根据你表字段自行修改，这里Excel文件里的字段要跟表一致

                $data[$k]['id']=$v[0];
                $data[$k]['name']=$v[1];
                $data[$k]['score']=$v[2];
            }

            if(Db::name('lesson_excel')->insertAll($data)){//批量插入数据
                return $this->success('导入数据成功!');
            } else {
                return  $this->error('导入数据失败!');
            }

        } else {
            return $this-> error('导入失败!');
        }
    }

}
