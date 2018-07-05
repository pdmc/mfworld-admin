<?php
namespace admin\privilege\controller;
use think\Controller;
use admin\extra\controller\Base;
use think\Request;
use think\Db;
use think\Session;
use think\Paginator;

/**
 * 管理员控制器
 * 主要包含： 管理员模块，密码修改，禁用，编辑功能
 * @author   heqingyu
 * @date     2018/4/19 17:18:22
 * @version  1.0
 */
class Admin extends Base
{   
    /**
     * 管理员列表
     * @param input|void;
     * @param output|void; 
     */
    public function adminlist(){
        //筛选条件
        $get = input('get.');
        $where = array();
        $where['status'] = config('normal_status');
        if(!empty($get['member_status'])){
            if($get['member_status'] == 'all'){
                unset($where['status']);
            }else if($get['member_status'] == config('delete_status')){
                $where['status'] = config('delete_status');
            }
        }
        $pageSize = config('page_size');
        $list = Db::name('admin')
                ->where($where)
                ->order('create_time desc')
                ->field('id,nick_name,user_name,type,mobile,status,create_time')
                ->paginate($pageSize,false,['query' => $get]);
        $page = $list->render();
        $count = Db::name('admin')->where($where)->count();
        $this->assign('page',$page);
        $this->assign('list',$list);
        return $this->fetch();
    }
    /**
     * 添加管理人员
     * @param input|void;
     * @param output|string(json); 
     */
    public function addPerson(){
        $data = input('post.');
        $result = array('flag'=>'0','msg'=>'添加失败!');
        if($data){
            $action['nick_name'] = trim($data['user']);
            $action['user_name'] = trim($data['username']);
            $action['pwd'] = trim(md5($data['pwd']));
            $action['mobile'] = trim($data['phone']);
            $action['status'] = config('normal_status');
            $action['create_time'] = time();
            $action['type'] = 1; //默认普通管理员	
            $action['user_id'] = session("admin_id");

            $user['nick_name'] = trim($data['user']);
            $is_user  = Db::name('admin')->where($user)->count();
            $phone['mobile'] = trim($data['phone']);
            $is_phone = Db::name('admin')->where($phone)->count();
            if($is_user){
                $result['flag'] = 2;
                $result['msg'] = '该账号已存在';
            }else if($is_phone){
                $result['flag'] = 2;
                $result['msg'] = '该联系方式已存在';
            }else{
                $resultdata = Db::name('admin')->insert($action);
                if($resultdata){
                        $result['flag'] = 1;
                        $result['msg'] = '添加成功';
                }
            }
            echo json_encode($result);
        }
    }
    /**
     * 修改密码
     * @param input|void;
     * @param output|string(json); 
     */
    public function editPassword()
    {
        $result = array('flag'=>'操作失败!');
        $adminId = input('post.id');
        $postpwd = input('post.pwd');
        $pwd = trim($postpwd);
        if(!empty($adminId)){
            $data['pwd'] = md5($pwd);
            $data['update_time'] = time();
            $res = Db::name('admin')->where('id',$adminId)->update($data);
            if($res){
                $result['flag'] = 1;
                $result['msg'] = '修改成功！';
            }
        }
        echo json_encode($result);
    }

    /**
     * 修改用户状态
     * @param input|void;
     * @param output|string(json); 
     */
    public function changeStatus(){
        $status = input('post.status');
        $id = input('post.id');
        $result = array('flag'=>0,'msg'=>'更新失败');
        if($status==config('normal_status')){
            $action['status'] = config('delete_status');
        }else{
            $action['status'] = config('normal_status');
        }
        
        $action['update_time'] = time();
        $info = Db::name('admin')->where('id',$id)->update($action);
        if($info){
            $result['flag'] = 1;
            $result['msg'] = '更新成功';
        }
        echo json_encode($result);
    }
    /**
     * 编辑管理员信息
     * @param input|void;
     * @param output|string(json); 
     */
    public function editorAdmin(){
        $result = array('flag'=>0,'msg'=>'操作失败');
        $post = input('post.');
        $id = $post['id'];
        if($post['action'] == 'get'){
            $info = Db::name('admin')->where('id',$id)->find();
            $result['flag'] = 1;
            $result['msg'] = 'OK';
            $result['data'] = $info;
        }
        if($post['action'] == 'post'){
            $user['nick_name'] = trim($post['user']);
            $user['id'] = array('neq',$id);
            $is_user = Db::name('admin')->where($user)->count();
            $phone['mobile'] =  trim($post['phone']);
            $phone['id'] = array('neq',$id);
            $is_phone = Db::name('admin')->where($phone)->count();
            
            if($is_user){
                $result['flag'] = 2;
                $result['msg'] = '该账号已存在';
            }else if($is_phone){
                $result['flag'] = 2;
                $result['msg'] = '该联系方式已存在';
            }else{
                $action['nick_name'] =  trim($post['user']);
                $action['user_name'] = trim($post['username']);
                $action['mobile'] = trim($post['phone']);
                $action['update_time'] = time();
                $resultdata = Db::name('admin')->where('id',$id)->update($action);
                if(!is_bool($resultdata)){
                    $result['flag'] = 1;
                    $result['msg'] = '更新成功';
                }
            }
        }
        echo json_encode($result);
    }
    
    /**
    * 后端登录日志
    * @param   input|void;
    * @return  output|void;
    */
    public function viewlog(){
        $where = [];
        //筛选条件
        $get = input('get.');
        if(!empty($get['client_name'])){
            $where['client_name'] = ['like','%'.trim($get['client_name']).'%'];
        }
        $where['login_type'] = 1;
        $data = Db::name('LoginLogs')
                ->where($where)
                ->order('login_time DESC')
                ->paginate(config('page_size'),false);
        $page = $data->render();
        $this->assign('page',$page);
        $this->assign('list',$data);
        return $this->fetch();
    }
    

}	