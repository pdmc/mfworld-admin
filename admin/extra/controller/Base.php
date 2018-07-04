<?php
namespace admin\extra\controller;
use think\Controller;
use think\Request;
use think\Session;
use think\Db;

class Base extends Controller 
{
    public function _initialize(){
        //判断是否登陆
        $adminId = Session::get('admin_id');
        if(empty($adminId)){
            session('admin_id',null);
            session('user_name',null);
            session('nick_name',null);
            session('is_super',null);
            $this->redirect('login/Login/login');
            return false;
        }
        //获取左侧的菜单
        $path  =  Request::instance()->module().'/'.Request::instance()->controller().'/'.Request::instance()->action();
        $allData = Db::name('auth_privilege')
                ->field('id,pid,level,name,title')
                ->where('status',config('normal_status'))
                ->order('sort desc,id asc')
                ->select();
        $currentpri = array();
        $data = array();
        foreach($allData as $val){
            //判断当前访问方法是否在权限表中
            if($val['name'] == $path){
                $currentpri = $val;
            }
            //找出level小于2的权限用于左侧菜单
            if($val['level'] < 2){
                $data[] = $val;
            }
        }
       
        if(!empty($currentpri)){
            //获取顶级节点ID,
            if($currentpri['level']==0){
                $currentpriId = $currentpri['id'];
            }else{
                $currentpriId = $this->gettopmenu($allData,$currentpri['pid']);
            }
            //获取次级节点,即level为1；
            if($currentpri['level']<=1){
                $memuId = $currentpri['id'];
            }else{
                $memuId = $this->gettopmenu($allData,$currentpri['pid'],1);
            }
        }else{
            $currentpriId = 0;
            $memuId = 0;
        }
        
        //递归将权限重组,将左侧菜单列举出来.
        if(Session::get('is_super')){
            $menuData = $this->getTree($data,0);
        }else{
            $menuData = $this->getMenuTree($data,0);
        }
        $this->assign('menuData',$menuData);
        $this->assign('path',$path);
        $this->assign('currentpriId',$currentpriId);
        $this->assign('memuId',$memuId);
        //权限的判断
        
        $noAuthPath = config('no_auth_path');
        if(in_array($path,$noAuthPath)){
            return true;
        }
        if(Session::get('is_super')){
            return true;
        }
        
        //当前访问的控制器和方法，是否在session中
        $sessionPrivil = json_decode(Session::get('privilegeData'));
        if(in_array($path,$sessionPrivil)){
            return true;
        }else{
            session('admin_id',null);
            session('user_name',null);
            session('nick_name',null);
            session('is_super',null);
            $this->error('您没有权限访问','login/Login/login');die;
        }
    }
     /**
     * 获取顶级菜单
     */
    private function gettopmenu($data,$id,$level=0){
        static $topmemnid = '';
        foreach($data as $val){
            if($val['id'] == $id){
                if($val['level'] == $level){
                    $topmemnid = $val['id'];
                }else{
                    $this->gettopmenu($data,$val['pid'],$level);
                }
            }
        }
        return $topmemnid;
    }
    //处理权限关系
    private function getTree($data,$pid=0){
        $result = array();
        foreach ($data as $v){
            if ($v['pid'] == $pid){
                $v['child'] = $this->getTree($data,$v['id']);
                $result[] = $v;
            }
        }
        return $result;
    } 
    private function getMenuTree($data,$pid=0){
        $result = array();
        $sessionPrivil = json_decode(Session::get('privilegeIdsData'),true);
        foreach ($data as $v){
            //找当前分类的子分类，默认从顶级开始找
            if ($v['pid'] == $pid && in_array($v['id'],$sessionPrivil)){ 
                //找到了，继续以找到的分类为当前分类，找它的后代节点,并将结果放到当前元素的下标为child的元素中
                $v['child'] = $this->getMenuTree($data,$v['id']);
                //然后将$v 保存到$list中
                $result[] = $v;
            }
            continue;
        }
        return $result;
    }
    
    
}