<?php
namespace app\intention\controller;

use think\Loader;
use think\Controller;
use think\db;
class Dao extends Controller
{
    //数据导出
    public function index()
    {
        return $this->fetch();
    }
    public function excel()
    {
        $path = dirname(__FILE__); //找到当前脚本所在路径
        Loader::import('PHPExcel.PHPExcel'); //手动引入PHPExcel.php
        Loader::import('PHPExcel.PHPExcel.IOFactory.PHPExcel_IOFactory'); //引入IOFactory.php 文件里面的PHPExcel_IOFactory这个类
        $PHPExcel = new \PHPExcel(); //实例化
        $db1=db('intentions');
        $zhushi=db()->query('show full fields from intentions');
        $iclasslist=$db1->group('iclass')->select();//班级
        $zimu=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','I','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG'];
        for($i=0;$i<=count($iclasslist)-1;$i++){
            $PHPExcel->createSheet();
            $PHPExcel->setactivesheetindex($i);
            $PHPSheet = $PHPExcel->getActiveSheet();
            $PHPSheet->setTitle($iclasslist[$i]['iclass']); //给当前活动sheet设置名称    //班级
            for($j=0;$j<=count($zhushi)-1;$j++){
                $PHPSheet->setCellValue("$zimu[$j]1", $zhushi[$j]['Comment']);//表格数据
            }
            $user=$db1->where("iclass="."'".$iclasslist[$i]['iclass']."'")->select();
            $a=2;
            foreach($user as $k=>$v){
                $b=0;
                foreach ($v as $key => $vo){
                    $PHPSheet->setCellValue("$zimu[$b]$a", $vo);
                    $b++;
                 }
                $a++;
            }
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007"); //创建生成的格式
        header('Content-Disposition: attachment;filename="第一次调查结果(班级).xlsx"'); //下载下来的表格名
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }
    //表格导入数据库
    public function channelExcel()
    {
        $scriptFilename = explode('/', $_SERVER['SCRIPT_FILENAME']);
        unset($scriptFilename[count($scriptFilename) - 1]);
        $file = implode('/', $scriptFilename) . '/excel/abc.xlsx';
        Loader::import('PHPExcel.PHPExcel');
        Loader::import('PHPExcel.PHPExcel.IOFactory.PHPExcel_IOFactory');
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file, $encode = 'utf8');
        //班级总数 0 .-.  sheet是全部的人数
        $sheetCount = $objPHPExcel->getSheetCount();
        for($i=0; $i<$sheetCount ; $i++) {    //循环每一个sheet
            $sheet = $objPHPExcel->getSheet($i)->toArray();
            unset($sheet[0]);
            foreach ($sheet as $v) {
                $data['id'] = $v[0];
                $data['username'] = $v[1];
                $data['iclass'] = $v[2];
                $data['inten'] = $v[3];
                $data['reason'] = $v[4];
                $data['liuxiao'] = $v[5];
                $data['support'] = $v[6];
                try {
                    db('intentions')->insert($data);
                } catch (\Exception $e) {
                    return '插入失败';
                }
            }
        }
        echo "succ";
    }

}