<?php
namespace admin\cate\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use admin\extra\controller\Base;

/**
 * 分类控制器
 * 主要包括：？？？？？
 * @author   heqingyu
 * @date     2018/4/23 10:25:28
 * @version  1.0
 */
class Cate extends Base
{   
    /**
    * 分类列表
    * @param   input|void;
    * @return  output|void;
    */
    public function lists(){
        $data = Db::name('category')
                ->field('id,name,pid,sort,status,web_status,create_time')
                ->order('sort DESC')
                ->select();
        $list = $this->cateTree($data);
        $keyval = array();
        $keyval['0'] = "顶级分类";
        foreach($list as $val){
            $keyval[$val['id']] = $val['name'];
        }
        $this->assign('keyval',$keyval);
        $this->assign('list',$list);
        //dump($list);die;
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
    * 添加分类 
    * @param   input|void;
    * @return  string;
    */
    public function addCate(){
        $result = array('flag'=>0,'msg'=>'添加失败,请重新操作！');
        $infodata = input('post.');
        $infodata['user_id'] = session('admin_id');
        $infodata['status']  = config('normal_status');
        $infodata['create_time'] = time();
        if(Db::name('category')->insert($infodata)){
            $result['flag'] = 1;
            $result['msg'] = "成功添加！";
        }
        echo json_encode($result);
    }
    /**
    * 编辑分类 
    * @param   
    * @return  
    */
    public function editCate(){
        $result = ['flag'=>0,'msg'=>'操作失败'];
        $info = input('post.');
        $id = $info['id'];
        if(!empty($id)){
            $cateModel = Db::name('Category');
            if($info['action'] == 'post'){
                $alldata = $cateModel->field('id,pid')->select();
                $childs = $this->getChildCat($alldata,$id);
                $childs[] = (int)$id;
                if(in_array($info['pid'],$childs)){
                    $result = ['flag' => 0,'msg' => '父类不能移动到子类下'];
                }else{
                    $updata['id'] = $id;
                    $updata['pid'] = $info['pid'];
                    $updata['name'] = $info['name'];
                    $updata['sort'] = $info['sort'];
                    $updata['update_time'] = time();
                    $updata['user_id'] = session('admin_id');
                    if($cateModel->update($updata)){
                        $result['flag'] = 1;
                        $result['msg'] = '操作成功';
                    }
                }
            }else{
                $data = $cateModel->where('id',$id)->find();
                $result['data'] = $data;
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }
        }
        echo json_encode($result);
    }
    
    //获取子类集合
    private function getChildCat($data,$id){
        static $result = [];
        foreach($data as $v){
            if($v['pid'] == $id){
                $result[] = $v['id'];
                $this->getChildCat($data,$v['id']);
            }
        }
        return $result;
    }
     /**
    * 后台开启关闭分类 
    * @param   
    * @return  
    */
    public function onOffCate(){
        $result = ['flag'=>0,'msg'=>'操作失败!'];
        $id = input('id');
        if(!empty($id)){
            $cateModel = Db::name('Category');
            $findData = $cateModel->where('id',$id)->field('status')->find();
            if($findData['status'] == config('normal_status')){
                $updata['status'] = config('delete_status');
            }else if($findData['status'] == config('delete_status')){
                $updata['status'] = config('normal_status');
            }
            $updata['id'] = $id;
            if($cateModel->update($updata)){
                $result = ['flag'=>1,'msg'=>'成功操作!'];
            }
        }
        echo json_encode($result);
    }
    
    
     /**
    * 前台开启关闭分类 
    * @param   
    * @return  
    */
    public function webOnOffCate(){
        $result = ['flag'=>0,'msg'=>'操作失败!'];
        $id = input('id');
        if(!empty($id)){
            $cateModel = Db::name('Category');
            $findData = $cateModel->where('id',$id)->field('web_status')->find();
            if($findData['web_status'] == config('normal_status')){
                $updata['web_status'] = config('delete_status');
            }else{
                $updata['web_status'] = config('normal_status');
            }
            $updata['id'] = $id;
            if($cateModel->update($updata)){
                $result = ['flag'=>1,'msg'=>'成功操作!'];
            }
        }
        echo json_encode($result);
    }
    
     /**
    * 删除分类 (此功能禁用)
    * @param   
    * @return  
    */
    public function delCate(){
        $result = ['flag'=>0,'msg'=>'操作失败!'];
        $id = input('id');
        if(!empty($id)){
            $cateModel = Db::name('Category');
            if($cateModel->where('pid',$id)->count()){
                $result = ['flag'=>0,'msg'=>'有子类存在,禁止删除!'];
            }else{
                if($cateModel->where('id',$id)->delete()){
                    $result = ['flag'=>1,'msg'=>'成功删除!'];
                }
            }
        }
        echo json_encode($result);
    }
}
