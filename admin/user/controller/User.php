<?php
namespace admin\user\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use admin\extra\controller\Base;

/**
 * 前端用户控制器
 * 主要包括：？？？？？
 * @author   heqingyu
 * @date     2018/5/9 14:25:28
 * @version  1.0
 */
class User extends Base
{   
    /**
    * 用户列表
    * @param   input|void;
    * @return  output|void;
    */
    public function lists(){
        $where = [];
        //筛选条件
        $get = input('get.');
        if(!empty($get['user_status'])){
            $where['user_status'] = $get['user_status'];
        }
        if(!empty($get['user_name'])){
            $where['user_nick|user_name'] = ['like','%'.trim($get['user_name']," ").'%'];
        }
        $data = Db::name('User')
                ->where($where)
                ->field('user_id,user_nick,user_name,user_mobile,user_sex,invite_code,user_status,create_time')
                ->order('create_time DESC')
                ->paginate(config('page_size'),false);
        $page = $data->render();
        $this->assign('page',$page);
        $this->assign('list',$data);
        return $this->fetch();
    }
    
    /**
    * 查看更多
    * @param   input|void;
    * @return  output|void;
    */
    public function viewmore(){
        $result = ['code'=>400,'msg'=>'操作失败！'];
        $id = input('id');
        if(!empty($id)){
            $findData = Db::name('User')->where('user_id',$id)->find();
            if($findData){
                if($findData['user_status'] == 1){
                    $findData['user_status'] = '启用';
                }else if($findData['user_status'] == '-1'){
                    $findData['user_status'] = '禁用';
                }
                $findData['create_time'] = date('Y-m-d H:i:s',$findData['create_time']);
                $result['code'] = 200;
                $result['data'] = $findData;
                $result['msg'] = '成功操作!';
            }
        }
        echo json_encode($result);
    }
    /**
    * 前端登录日志
    * @param   input|void;
    * @return  output|void;
    */
    public function viewlog(){
        $where = [];
        //筛选条件
        $get = input('get.');
        if(!empty($get['client_name'])){
            $where['client_name'] = ['like','%'.trim($get['client_name']," ").'%'];
        }
        $where['login_type'] = 2;
        $data = Db::name('LoginLogs')
                ->where($where)
                ->order('login_time DESC')
                ->paginate(config('page_size'),false);
        $page = $data->render();
        //dump($data);die;
        $this->assign('page',$page);
        $this->assign('list',$data);
        return $this->fetch();
    }
    
    /**
    * 答题记录
    * @param   input|void;
    * @return  output|void;
    */
    public function anround(){  
        $where = [];
        //筛选条件
        $get = input('get.');
        if(!empty($get['user_nick'])){
            $where['user_nick'] = ['like','%'.trim($get['user_nick']," ").'%'];
        }
        $data = Db::name('AnswerRound')
                ->where($where)
                ->order('create_time DESC')
                ->paginate(config('page_size'),false);
        $page = $data->render();
        $this->assign('page',$page);
        $this->assign('list',$data);
        return $this->fetch();
    }
    /**
    * 更多答题记录
    * @param   input|void;
    * @return  output|void;
    */
    public function anlog(){ 
        $result = ['code'=>400,'msg'=>'操作失败！'];
        
        echo json_encode($result);
    }
    
    
}
