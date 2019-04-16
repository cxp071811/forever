<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
class Content extends Controller
{
   /* public function index()
    {
        $data=Db::table('permission')->select();
        return view('show',['data'=>$data]);//展示页面
    }
    public function dels(){
        $id=Request::instance()->param('id');
        $a=Db::table('permission')->where('p_id','in',$id)->delete();
        if($a){
            return $this->index();
        }else{
            return $this->error('删除失败');
        }
    }*/
    public function out(){
        header("Content-type:application/vnd.ms_excel");
        header("Content-Disposition:attachment;filename=excel.xls");
        $arr=Db::table('permission')->select();
        //var_dump($arr);die;
        $str=iconv("utf-8","gb2312","ID\t英文名字\t中文名字\t类型\t型号\t地址\n");
        //var_dump($str);die;
        foreach($arr as $v){
            $str .=iconv("utf-8","gb2312",$v['p_id']."\t".$v['p_eng']."\t".$v['p_chi']."\t".$v['p_type']."\t".$v['pid']."\t".$v['p_url']."\n");
        }
        echo $str;
    }
    public function into(){
        //header("content-type:text/html;charset=utf-8");
        $dir =dirname(THINK_PATH)."/public";
    $str = iconv("gb2312","utf-8",trim(file_get_contents($dir."/excel.xls")));
    //var_dump($str);die;
    $data=explode("\n",$str);
    //var_dump($data);die;
    foreach($data as $v){
        $arr[]=explode("\t",$v);
        unset($arr[0]);
    }
    //var_dump($arr);die;
        foreach ($arr as $v) {
            Db::table('permission')->insert(['p_id'=>$v[0],'p_eng'=>$v[1],'p_chi'=>$v[2],'p_type'=>$v[3],'pid'=>$v[4],'p_url'=>$v[5]]);
    }

    }


}
