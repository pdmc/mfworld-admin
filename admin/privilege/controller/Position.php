<?php
namespace admin\privilege\controller;
use think\Controller;
use think\Request;
use think\Db;
use admin\extra\controller\Base;
use think\Paginator;
use admin\extra\model\AuthAdminRole;

/**
 * 职位权限划分方法
 * 主要包括:添加职位，编辑，删除，添加人员，查看人员，权限分配
 * @author   heqingyu
 * @date     2018/4/18 14:40:52
 * @version  1.0
 */
class Position extends Base{
    /**
     * 职位列表
     * @param input|void;
     * @param output|void; 
     */
    public function index(){
        $list = Db::name('auth_role')
                ->field('id,title,pid,status,privilege,sort')
                ->order('sort DESC')
                ->select();
        $treeData = $this->getAllRoleData($list,0,0);
        $this->assign('list',$treeData);
        return  $this->fetch('index');
    }
    /**
     * 将职位auth_role表输出成树状结构
     * @param array $roleDatas
     * @param int $pid
     * @return array
     */
    static function getAllRoleData($roleDatas,$pid=0,$level=0) {
        static $datas;
        if ($roleDatas != NULL || !empty($roleDatas)) {
            foreach ($roleDatas as $key =>$roleData) {
                if($roleData['pid']==$pid){
                    $roleData['level'] =$level + 1;
                    $datas[] = $roleData;
                    self::getAllRoleData($roleDatas,$roleData['id'],$roleData['level']);
                }
            }
        }
        return $datas;
    }
    /**
     * 获取职位
     * @param  input|void;
     * @return string|json;
     */
    public function getprivilege(){
        $result = array('flag'=>0,'msg'=>'fail','data'=>null);
        $privilegedatas = Db::name('auth_role')
                    ->field('id,title,level,pid')
                    ->where('status',config('normal_status'))
                    ->select();
        $privilegeTree = $this->getPrivilegeTree($privilegedatas, 0);
        if(!empty($privilegeTree)){
            $result['flag'] =1;
            $result['msg']  ='ok';
            $result['data'] =$privilegeTree;
        }
        echo json_encode($result);
    }
    
    private function getPrivilegeTree($data, $pid = 0){
        static $result = array();
        foreach($data as $v){
            if($v['pid']==$pid){
                $result[] = $v;
                $this->getPrivilegeTree($data,$v['id']);//递归调用
            }
        }
        return $result;
    }

    /**
     * 添加部门职位
     * @param  input|void;
     * @return string|json;
     */
    public function addposition() {
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $post = input('post.');
        $info = $post['info'];
        if($info){
            $info['level'] = 0;
            $info['status'] =config('normal_status');
            $pid = $info['pid'];
            if($pid!=0){
                $RoleData = Db::name('auth_role')
                            ->field('level')
                            ->where('id='.$pid)
                            ->find();
                if(!empty($RoleData)){
                    $info['level'] = $RoleData['level']+1;
                }
            }
            if(Db::name('auth_role')->insert($info)){
                $result['flag'] = 1;
                $result['msg'] = '添加成功';
            }
        }
        echo json_encode($result);
    }

    /**
     * 开启删除职位
     * @param  input|void;
     * @return string|json;
     */
    public function delposition(){
    	$post = input('post.');
        $result = array('flag'=>0,'msg'=>'更新失败!');
        if($post){
            $id = $post['id'];
            $info['status'] = $post['status'];
            $roleModel = Db::name('auth_role');
            if($roleModel->where('pid='.$id.' and status = '.config('normal_status'))->field('id')->count()){
                $result['flag'] = 0;
                $result['msg'] = '有子职位存在,不能删除!';
            }else if($roleModel->where('id',$id)->update($info)){
                $result['flag']=1;
                $result['msg'] = '成功更新!';
            }
        }
        echo json_encode($result);
    }
    /**
     * 编辑职位
     * @param  input|void;
     * @return string|json;
     */
    public function editposition(){
        $data = input('post.');
        $result = array('flag'=>0,'msg'=>'操作失败!');
        $roleModel = Db::name('auth_role');
        if($data['action'] == 'get'){
            $id = $data['id'];
            $roledata = $roleModel->where('id='.$id)->find();
            $roledatas = $roleModel
                        ->field('id,title,level,pid')
                        ->where('status='.config('normal_status'))
                        ->select();
            $roleTree = $this->getPrivilegeTree($roledatas, 0);
            if(!empty($roledata)){
                $result['flag'] = 1;
                $result['roleTree'] = $roleTree;
                $result['roledata'] = $roledata;
            }
        }else if($data['action'] == 'post'){
            $editData = $data['editinfo'];
            $id = $editData['id'];
            //获取该权限原来的pid
            $oldprivilege = $roleModel->where('id='.$id)->count();
            if(!empty($oldprivilege)){
                //获取该职位下的所有子职位
                $roledatas = $roleModel->field('id,pid')
                            ->where('status='.config('normal_status'))
                            ->select();
                $childPrivilegeIds = $this->getChildPrivilege($roledatas,$id);
                $childPrivilegeIds[] = $id;
                if(in_array($editData['pid'], $childPrivilegeIds)){
                    $result['flag'] = 0;
                    $result['msg'] = '请确认不是在自己的子菜单下!';
                }else{
                    $preprivilege = $roleModel
                                ->field('level')
                                ->where('id='.$editData['pid'])
                                ->find();
                    if(!empty($preprivilege)){
                        $editData['level'] = $preprivilege['level']+1;
                    }else{
                        $editData['level'] = 0;
                    }
                    
                    //此处批量更新保存  
                    $pri_update = $roleModel->where('id',$id)->update($editData);
                    if($pri_update){
                        $result['flag'] = 1;
                        $result['msg'] = '修改成功';
                    }
                }
            }
        }
        echo json_encode($result);
    }
     /**
     *  递归调用
     * @param type $roledatas
     * @param type $pid
     * @return array
     */
    private function getChildPrivilege($roledatas,$pid = 0){
        static $result = array();
        foreach($roledatas as $v){
            if($pid == $v['pid']){
                $result[] = $v['id'];
                $this->getChildPrivilege($roledatas,$v['id']);   
            }
        }
        return $result;
    }
    /**
     * 添加职位上的人员
     * @param  input|void;
     * @return string|json;
     */
    public function adduser() {
        $roleadminModel = Db::name('auth_admin_role');
        $result = array('flag'=>0,'msg'=>'操作失败!');
        if(Request::instance()->isPost()){
            $postdata = input('post.');
            $roleId =$postdata['position_id'];
            $uid = array();
            if(!empty($postdata['uid'])){
                $uid = $postdata['uid'];
            }
            $role = Db::name('auth_role')
                ->where('id='.$roleId .' and status ='.config('normal_status'))
                ->count();
            if(!empty($role)){
                $del_res = $roleadminModel->where('role_id',$roleId)->delete();
                if(!is_bool($del_res)){
                    foreach($uid as $v){
                        $roleuserData['role_id'] = $roleId;
                        $roleuserData['admin_id'] = $v;
                        $roleadminModel->insert($roleuserData);
                    }
                    $result['flag'] = 1;
                    $result['msg'] = '新增成功';
                } 
            }         
        }else{
            $id = input('id');
            //获取所有管理员信息
            $admindata = Db::name('admin')
                    ->field('id,user_name,nick_name')
                    ->where("status=".config('normal_status'). " and type!=2")
                    ->select(); 
            //获取该职位下的人员
            $roleadmin = $roleadminModel
                    ->field('admin_id')
                    ->where('role_id='.$id)
                    ->select();
            $roleadmininfo = array();
            if(!empty($roleadmin)){
                foreach($roleadmin as $v){
                    $roleadmininfo[] = $v['admin_id'];
                }
            }
            if(!empty($admindata)){
                $result['flag'] = 1;
                $result['msg'] = 'ok';
                $result['admindata'] = $admindata;
                $result['roleadmin'] = $roleadmininfo;
            }
        }
        echo json_encode($result);
    }

    /**
     * 查看职位对应的人员
     * @param  input|void;
     * @return string|json;
     */
    public function positionuser(){
        $result = array('flag'=>0,'msg'=>'操作失败!');
        if(Request::instance()->isPost()){
            $roleId = input('id');
            $roleAdmin = AuthAdminRole::with('Admin')
                    ->where('role_id='.$roleId)
                    ->select();
            if(!empty($roleAdmin)){
                $result['flag'] = 1;
                $result['msg'] = 'ok';
                $result['data'] = $roleAdmin;
            }
        }
        echo json_encode($result);
    }

    
}