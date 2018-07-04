<?php
namespace admin\task\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use admin\extra\controller\Base;

/**
 * 任务控制器
 * 主要包括：？？？？？
 * @author   heqingyu
 * @date     2018/4/27 18:25:28
 * @version  1.0
 */
class Task extends Base
{   
    /**
    * 任务列表
    * @param   input|void;
    * @return  output|void;
    */
    public function lists(){
         //筛选条件
        $where['status'] = ['neq',-2];
        $data = Db::name('Task')
                ->where($where)
                ->order('create_time DESC,sort DESC')
                ->paginate(config('page_size'),false);
        $page = $data->render();
        $this->assign('page',$page);
        $this->assign('list',$data);
        return $this->fetch();
    }
    /**
    * 添加任务 
    * @param   input|void;
    * @return  string;
    */
    public function addTask(){
        $result = array('flag'=>0,'msg'=>'添加失败,请重新操作！');
        $infodata = input('post.');
        $infodata['status']  = config('normal_status');
        $infodata['user_id'] = session('admin_id');
        $infodata['create_time'] = time();
        if(Db::name('Task')->insert($infodata)){
            $result['flag'] = 1;
            $result['msg'] = "成功添加！";
        }
        echo json_encode($result);
    }
    /**
    * 编辑任务
    * @param   
    * @return  
    */
    public function editTask(){
        $result = ['flag'=>0,'msg'=>'操作失败'];
        $info = input('post.');
        $id = $info['id'];
        if(!empty($id)){
            $taskModel = Db::name('Task');
            if($info['action'] == 'post'){
                $updata['id'] = $id;
                $updata['name'] = $info['name'];
                $updata['type'] = $info['type'];
                $updata['num'] = $info['num'];
                $updata['reward'] = $info['reward'];
                $updata['sort'] = $info['sort'];
                $updata['update_time'] = time();
                $updata['user_id'] = session('admin_id');
                if($taskModel->update($updata)){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }else{
                $data = $taskModel->where('id',$id)->find();
                if(!empty($data)){
                    $result['data'] = $data;
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }
        }
        echo json_encode($result);
    }
    /**
    * 开启关闭任务 
    * @param   
    * @return  
    */
    public function onOffTask(){
        $result = ['flag'=>0,'msg'=>'操作失败!'];
        $id = input('id');
        if(!empty($id)){
            $taskModel = Db::name('Task');
            $findData = $taskModel->where('id',$id)->field('status')->find();
            if($findData['status'] == config('normal_status')){
                $updata['status'] = config('delete_status');
            }else if($findData['status'] == config('delete_status')){
                $updata['status'] = config('normal_status');
            }
            $updata['id'] = $id;
            $updata['update_time'] = time();
            $updata['user_id'] = session('admin_id');
            if($taskModel->update($updata)){
                $result = ['flag'=>1,'msg'=>'成功操作!'];
            }
        }
        echo json_encode($result);
    }
    
    /**
    * 删除任务
    * @param   
    * @return  
    */
    public function delTask(){
        $result = ['flag'=>0,'msg'=>'操作失败!'];
        $id = input('id');
        if(!empty($id)){
            $updata['id'] = $id;
            $updata['status'] = -2;
            $updata['update_time'] = time();
            $updata['user_id'] = session('admin_id');
            if(Db::name('Task')->update($updata)){
                $result = ['flag'=>1,'msg'=>'成功操作!'];
            }
        }
        echo json_encode($result);
    }
    
}
