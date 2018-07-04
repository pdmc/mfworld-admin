<?php
namespace admin\problem\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use think\File;
use admin\extra\controller\Base;


/**
 * 题库控制器
 * 主要包括：？？？？？
 * @author   heqingyu
 * @date     2018/4/23 18:25:28
 * @version  1.0
 */
class Problem extends Base
{   
    /**
    * 分类列表
    * @param   input|void;
    * @return  output|void;
    */
    public function lists(){
         //筛选条件
        $get = input('get.');
        $where = array();
        if(!empty($get['cate_id'])){
            $where['cate_id'] = $get['cate_id'];
        }
        if(!empty($get['name'])){
            $where['name'] = ['like','%'.trim($get['name']).'%'];
        }
        $where['status'] = ['neq',-2];
        $data = Db::name('Problem')
                ->where($where)
                ->order('create_time DESC,sort DESC')
                ->paginate(config('page_size'),false,['query' => $get]);
        $datacount = count($data);
        $allerror = [];
        for($i=0;$i<$datacount;$i++){
            $allerror[$i] = explode('/|*|/',$data[$i]['error']);
        }
        $page = $data->render();
        $this->assign('page',$page);
        $this->assign('allerror',$allerror);
        $this->assign('list',$data);
        //分类处理start
        $cateData = Db::name('category')
                ->field('id,name,pid')
                ->select();
        $cateList = $this->cateTree($cateData,1);
        foreach($cateList as $val){
            $keyval[$val['id']] = $val['name'];
        }
        $keyval['0'] = '';
        $this->assign('keyval',$keyval);
        $this->assign('cateList',$cateList);
        //分类处理end
        return $this->fetch();
    }
    //分类tree
    private function cateTree($data,$pid = 0,$level = 0){
        static $result = array();
        foreach($data as $v){
            if($v['pid'] == $pid){
                $v['level'] = $level;
                $result[] = $v;
                $this->cateTree($data,$v['id'], $level+1);//递归调用
            }
        }
        return $result;
    }
    /**
    * 添加试题 
    * @param   input|void;
    * @return  string;
    */
    public function addPro(){
        $result = array('flag'=>0,'msg'=>'添加失败,请重新操作！');
        $infodata = input('post.');
        $errorString = '';
        foreach($infodata['error'] as $val){
            $errorString .= $val.'/|*|/';
        }
        $insertData['name'] = $infodata['name'];
        $insertData['correct'] = $infodata['correct'];
        $insertData['error'] = $errorString;
        $insertData['cate_id'] = $infodata['cate_id'];
        $insertData['sort'] = $infodata['sort'];
        $insertData['status']  = config('normal_status');
        $insertData['user_id'] = session('admin_id');
        $insertData['create_time'] = time();
        if(Db::name('Problem')->insert($insertData)){
            $result['flag'] = 1;
            $result['msg'] = "成功添加！";
        }
        echo json_encode($result);
    }
    /**
    * 编辑试题 
    * @param   
    * @return  
    */
    public function editPro(){
        $result = ['flag'=>0,'msg'=>'操作失败'];
        $info = input('post.');
        $id = $info['id'];
        if(!empty($id)){
            $proModel = Db::name('Problem');
            if($info['action'] == 'post'){
                $errorString = '';
                foreach($info['error'] as $val){
                    $errorString .= $val.'/|*|/';
                }
                $updata['id'] = $id;
                $updata['name'] = $info['name'];
                $updata['correct'] = $info['correct'];
                $updata['error'] = $errorString;
                $updata['cate_id'] = $info['cate_id'];
                $updata['sort'] = $info['sort'];
                $updata['update_time'] = time();
                $updata['user_id'] = session('admin_id');
                if($proModel->update($updata)){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }else{
                $data = $proModel->where('id',$id)->find();
                $data['error'] = explode('/|*|/',$data['error']);
                $result['data'] = $data;
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }
        }
        echo json_encode($result);
    }
    /**
    * 开启关闭试题 
    * @param   
    * @return  
    */
    public function onOffPro(){
        $result = ['flag'=>0,'msg'=>'操作失败!'];
        $id = input('id');
        if(!empty($id)){
            $proModel = Db::name('Problem');
            $findData = $proModel->where('id',$id)->field('status')->find();
            if($findData['status'] == config('normal_status')){
                $updata['status'] = config('delete_status');
            }else if($findData['status'] == config('delete_status')){
                $updata['status'] = config('normal_status');
            }
            $updata['id'] = $id;
            $updata['update_time'] = time();
            $updata['user_id'] = session('admin_id');
            if($proModel->update($updata)){
                $result = ['flag'=>1,'msg'=>'成功操作!'];
            }
        }
        echo json_encode($result);
    }
    
    /**
    * 删除试题  
    * @param   
    * @return  
    */
    public function delPro(){
        $result = ['flag'=>0,'msg'=>'操作失败!'];
        $id = input('id');
        if(!empty($id)){
            $updata['id'] = $id;
            $updata['status'] = -2;
            $updata['update_time'] = time();
            $updata['user_id'] = session('admin_id');
            if(Db::name('Problem')->update($updata)){
                $result = ['flag'=>1,'msg'=>'成功操作!'];
            }
        }
        echo json_encode($result);
    }
    
    /**
    * 导入数据 
    * @param   
    * @return  
    */
    public function import(){
        $result = ['flag'=>0,'msg'=>'操作失败！'];
        if(Request::instance()->isPost()){
            $file = Request()->file("import_file");
            //判断是否上传错误
            if($file->geterror()){
                $result = ['flag'=>0,'msg'=>'上传错误,重新上传！'];
                echo json_encode($result);die;
            }else{
                // 验证文件并移动到框架应用根目录/public/uploads/ 目录下  
                $path = ROOT_PATH."public/uploads/";
	        $info = $file
                        ->validate(['size'=>3145728,'ext'=>'xls,xlsx,csv'])
                        ->rule('uniqid')
                        ->move($path);
                $error = $info->getinfo();
                if($info){
                    if($error['error']){
                        $result = ['flag'=>0,'msg'=>'上传错误,重新上传...'];
                        echo json_encode($result);
                    }else{
                        $ext = $info->getExtension();// 获取后缀
                        $filename = $path.$info->getSaveName();// 文件保存名字
                        vendor('PHPExcel.PHPExcel.IOFactory');
                        vendor('PHPExcel.PHPExcel.Reader.Excel5');// Excel5:xls;Excel2007:xlsx;
                        vendor('PHPExcel.PHPExcel.Reader.Excel2007');// Excel5:xls;Excel2007:xlsx;
                        $reader = \PHPExcel_IOFactory::createReader('Excel5');//设置以Excel5格式
                        if($ext == 'xlsx'){
                            $reader = \PHPExcel_IOFactory::createReader('Excel2007');//设置以Excel2007格式
                        }
                        
                        //分类处理start
                        $cateData = Db::name('category')
                                ->field('id,name,pid')
                                ->select();
                        $cateList = $this->cateTree($cateData,1);
                        foreach($cateList as $val){
                            $cate[$val['id']] = $val['name'];
                        }
                        $cate['0'] = ''; 
                        $cateDatas = array_flip($cate);
                           
                        
                        $PHPExcel = $reader->load($filename); // 载入excel文件  
                        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表  
                        $highestRow = $sheet->getHighestRow(); // 取得总行数  
                        for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始，这里示例中excel有3列字段 
                            $cate_name   = $sheet->getCell('A'.$row)->getValue();
                            if($cate_name &&($sheet->getCell('B'.$row)->getValue())){
                                if(!in_array($cate_name,$cate)){
                                    $result = ['flag'=>0,'msg'=>$cate_name.'分类不存在，请先添加分类！'];
                                    echo json_encode($result);die;
                                }
                                $data[$row]['cate_id'] = $cateDatas[$cate_name];
                                $data[$row]['name']    = $sheet->getCell('B'.$row)->getValue(); 
                                $data[$row]['correct'] = $sheet->getCell('C'.$row)->getValue();  
                                $data[$row]['error']   = $sheet->getCell('D'.$row)->getValue().'/|*|/'.$sheet->getCell('E'.$row)->getValue().'/|*|/'.$sheet->getCell('F'.$row)->getValue();  
                                $data[$row]['status']  = 1;
                                $data[$row]['user_id'] = session('admin_id');
                                $data[$row]['create_time'] = time();
                            }
                        } 
                        if(Db::name('Problem')->insertAll($data)){
                            $result = ['flag'=>1,'msg'=>'成功导入!'];
                        }
                    }
                }else{
                    $result = ['flag'=>0,'msg'=>'请选择上传3MB内的excel表格文件...'];
                }
            }
        }
        echo json_encode($result);
    }
    
    /**
    * 试题去重
    * @param   
    * @return  
    */
    public function repeat(){
        $result = ['flag'=>0,'msg'=>'操作失败！'];
        $where['status'] = ['neq',-2];
        $allData = Db::name('Problem')->where($where)->column('id,name');
        $unique_arr = array_unique($allData);   
        $repeat_arr = array_diff_assoc($allData,$unique_arr);
        if(is_array($repeat_arr)){
            $result['flag']  =1;
            $result['msg'] = '成功操作!';
            $result['data']  = $repeat_arr;
        }
        echo json_encode($result);
    }
    
    /**
    * 答题配置 
    * @param   
    * @return  
    */
    public function config(){
        $where['key'] = 'problemConfig';
        $configModal = Db::name('Config');
        if(Request::instance()->isPost()){
            $result = ['flag'=>0,'msg'=>'更新失败!'];
            $info = input('post.');
            $updata['value'] = json_encode($info);
            $updata['user_id'] = session('admin_id');
            $updata['update_time'] = time();
            if($configModal->where($where)->update($updata)){
                $result = ['flag'=>1,'msg'=>'成功更新!'];
            }
            echo json_encode($result);
        }else{
            $findData = $configModal->where($where)->field('value')->find();
            $data = json_decode($findData['value'],true);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
    
    
}
