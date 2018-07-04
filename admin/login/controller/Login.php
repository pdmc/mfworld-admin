<?php
namespace admin\login\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;

/**
* 登陆控制器
* 主要包括：登录方法,退出登录
* @author   heqingyu
* @date     2018/4/18 15:25:28
* @version  1.0
*/
class Login extends Controller{
    /**
     * 登陆方法
     * @date     2018/4/18 15:25:28
     */
    
    public function login(){
        $data = input('post.');
        if(!(empty($data['password'])&&empty($data['username']))){
            $pwd = $data['password'];
            $where['pwd'] = md5($pwd);
            $where['nick_name|mobile'] = trim($data['username']);
            $info = Db::name('admin')->where($where)->find();
            if($info){
                //首先判断用户是否正常
                if ($info['status'] == config('delete_status')) {
                    $result['flag'] = 2;
                    $result['msg'] = '该账号被禁用';
                }else{
                    // 判断用户是否是超级用户
                    if($info['type']== '1'){
                        //获取该用户具有的权限
                        $privilege = $this->getUsetPrivilege($info['id']);
                        $privilegeName = json_encode($privilege['name']);
                        $privilegeIds = json_encode($privilege['ids']);
                        session('privilegeData',$privilegeName);
                        session('privilegeIdsData',$privilegeIds);
                    }
                    session('admin_id',$info['id']);
                    session('user_name',$info['user_name']);
                    session('nick_name',$info['nick_name']);
                    if($info['type'] == '1'){
                        session('is_super',false);
                    }else{
                        session('is_super',true);
                    }
                    $lifeTime = config('life_time'); 
                    setcookie(session_name(), session_id(), time() + $lifeTime, "/");
                    
                    $result['flag'] = 3;
                    $result['msg'] = '登录成功';
                    
                    //写入登录log
                    $login_data['user_id']   = $info['id'];
                    $login_data['client_name']  = $info['nick_name'];
                    $login_data['login_time'] = date('Y-m-d H:i:s');
                    $login_data['login_ip']   = get_client_ip();
                    $login_data['login_type']  = 1;//后台
                    Db::name('LoginLogs')->insert($login_data);
                }
            }else{
                $result['flag'] = 4;
                $result['msg'] = '用户名或密码错误';
            } 
            echo json_encode($result);
        }else{
            $adminId = session('admin_id');
            if(!empty($adminId)){
                $this->redirect('/index/Index/index');
            }else{
                return $this->fetch('login');
            }
        }
    }


    /**
     * 退出登陆
     * @return void
     */
    public function logout()
    {   
        session('admin_id',null);
        session('user_name',null);
        session('nick_name',null);
        session('is_super',null);
        $this->redirect('Login/login');
    }

    /**
     * 获取用户的权限节点
     * @param int $userid
     * @return array
     */
    private function getUsetPrivilege($userid){
        //获取用户的职位�
        $data = array('name'=>array(),'ids'=>array());
        $priIdsData = array();
        $privileges = array();
        $roleAdmin = Db::name('auth_admin_role')->where('admin_id='.$userid)->select();
        if(!empty($roleAdmin)){
            foreach ($roleAdmin as $roleAdminV){
                $roleid[] = $roleAdminV['role_id'];
            }
            $map['status'] = config('normal_status');
            $map['id'] = array('in',$roleid);
            $roleData = Db::name('auth_role')->where($map)->select();
            if(!empty($roleData)){
                foreach ($roleData as $key => $value) {
                    if($value['privilege']!=''){
                         $priIds = explode(',', $value['privilege']);
                         $priIdsData = array_merge($priIdsData,$priIds);
                    }
                }
                $priIdsData = array_unique($priIdsData);
                if(!empty($priIdsData)){
                    $data['ids'] = $priIdsData;
                    $where['status'] = config('normal_status');
                    $where['id'] = array('in',$priIdsData);
                    $privileges = Db::name('auth_privilege')->where($where)->select();
                    if(!empty($privileges)){
                        foreach ($privileges as $prival){
                            $data['name'][] = $prival['name'];
                        }
                    }
                }
            }        
        }
        return $data;
    }
}