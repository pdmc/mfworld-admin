<?php
namespace admin\index\controller;
use think\Controller;
use think\Session;
use think\Db;
use admin\extra\controller\Base;

/**
 * 首页控制器
 * 主要包括：后台首页信息,个人信息,修改密码
 * @author   heqingyu
 * @date     2018/4/20 15:25:28
 * @version  1.0
 */
class Index extends Base
{   
    /**
    * 后台首页
    * @param   input|void;
    * @return  output|void;
    */
    public function index(){
        if(function_exists('gd_info')){
            $gd = gd_info();
            $gd = $gd['GD Version'];
        }else{
            $gd = "不支持";
        }
        $info = array(
            'OS'               => PHP_OS,
            'serverIP'         => $_SERVER['SERVER_NAME'] . ' (' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . ')',
            'ENV'              => $_SERVER["SERVER_SOFTWARE"],
            'PHPway'           => php_sapi_name(),
            'dir'              => ROOT_PATH,
            'MYSQL'            => function_exists("mysql_close") ? mysql_get_client_info() : '不支持',
            'GD'               => $gd,
            'filesize'         => ini_get('upload_max_filesize'),
            'runtime'          => ini_get('max_execution_time') . "s",
            'space'            => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            'servertime'       => date("Y年n月j日 H:i:s"),
            'bjtime'           => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600),
            'is_url_open'      => ini_get('allow_url_fopen') ? '支持' : '不支持',
            'register_globals' => get_cfg_var("register_globals") == "1" ? "ON" : "OFF",
        );
        $this->assign('info', $info);
        return $this->fetch();
    }
    /**
    * 个人资料
    * @param   input|void;
    * @return  output|void;
    */
    public function personaldata(){
        $id = session('admin_id');
        if(!empty($id)){
            $adminWhere['id'] = $id;
            $adminWhere['status'] = config('normal_status');
            $data = Db::name('Admin')
                    ->field('id,user_name,nick_name,mobile,type,create_time')
                    ->where($adminWhere)
                    ->find();
            if(!empty($data)){
                $this->assign('data',$data);
                return $this->fetch();
            }
        }
        $this->redirect('/login/login/login');
    }
    /**
    * 修改个人密码
    * @param  input|void;
    * @param  output|string(json); 
    */
    public function editpwd(){
        $result = array('flag'=>0,'msg'=>'修改失败！');
        $post = input('post.');
        $id = session('admin_id');
        if(!empty($post)&&!empty($id)){
            $where['id'] = $id;
            $where['status'] = config('normal_status');
            $where['pwd'] = md5($post['oldpw']);
            if(Db::name('Admin')->where($where)->count()){
                $updateWhere['id'] = $id;
                $data['update_time'] = date('Y-m-d H:i:s');
                $data['pwd'] = md5($post['newpw']);
                if(Db::name('Admin')->where($updateWhere)->update($data)){
                    $result= array('flag'=>'1','msg'=>'修改成功！');
                }
            }else{
                $result= array('flag'=>'0','msg'=>'原始密码错误！');
            }
        }
        echo json_encode($result);
    }
}
