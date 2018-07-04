<?php
namespace admin\privilege\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Paginator;
use admin\extra\controller\Base;

/**
 * 菜单管理控制器
 * 主要包括:添加菜单，编辑，删除，列表
 * @author   heqingyu
 * @date     2018/4/20 20:40:58
 * @version  1.0
 */
class Privilegecont extends Base 
{
    /**
     * 菜单列表
     * @param   input|void;
     * @return  output|void;
     */
    public function index(){
        $privilegeModel = Db::name('auth_privilege');
        $id = input('id');
        //获取level为零的菜单
        $map['pid'] = 0;
        $map['status'] = config('normal_status');
        $onedata = $privilegeModel
                ->field('title,id')
                ->where($map)
                ->order('sort desc')
                ->select();
        //获取当前菜单
        if(empty($id)){
            $id = $onedata[0]['id'];
        }
        foreach($onedata as $val){
            if($val['id'] == $id){
                $title = $val['title'];
            }
        }
        $this->assign('title',$title);
        
        $twodata = $privilegeModel
                ->field('id,title')
                ->where('status='.config('normal_status').' and pid='.$id)
                ->order('sort desc')
                ->select();
        if(!empty($twodata)){
            foreach($twodata as $v){
                $ids[] = $v['id'];
            }
            //该功能块下的菜单
            $where['pid'] = array('in', $ids);
            $threedata = $privilegeModel
                    ->field('id,title,pid')
                    ->where($where)
                    ->order('sort desc, id desc')
                    ->select();
            //获取该菜单下的操作方法
            if(!empty($threedata)){
                $twocount = count($twodata);
                $threecount = count($threedata);
                for($i=0;$i<$twocount;$i++){
                    for($j=0;$j<$threecount;$j++){
                        if($twodata[$i]['id'] == $threedata[$j]['pid']){
                            $twodata[$i]['child'][] = $threedata[$j];
                        } 
                    }
                }
            }
        }
        $this->assign('onedata',$onedata);
        $this->assign('twodata',$twodata);
        return $this->fetch('index');
    }
    /**
     * 获取菜单权限信息,只取三级的权限
     * 添加菜单
     * @param  input|void;
     * @param  output|string(json); 
     */
    public function getprivilege(){
        $data = input('post.');
        $privilegeModel = Db::name('auth_privilege');
        $result = array('flag'=>0,'msg'=>'操作失败!');
        if($data['action'] == 'get'){
            $privilegedatas = $privilegeModel->field('id,title,level,pid')
                ->where('level in (0,1) and status='.config('normal_status'))
                ->select();
            $privilegeTree = $this->getTrees($privilegedatas, 0);
            if(!empty($privilegeTree)){
                $result['flag'] =1;
                $result['msg'] = 'ok';
                $result['data'] =$privilegeTree;
            }
        }else if($data['action'] == 'post'){
            $info = $data['Privilege'];
            if($info){
                $info['level'] = 0;
                $info['create_time'] = time();
                $info['admin_id'] = session('admin_id');
                
                $pid = $info['pid'];
                if($pid!=0){
                    $preprivilege = $privilegeModel
                            ->field('level')
                            ->where('id='.$pid)
                            ->find();
                    if(!empty($preprivilege)){
                        $info['level'] = $preprivilege['level']+1;
                    }
                }
                $resultdata = $privilegeModel->insert($info);
                if($resultdata){
                    $result['flag'] = 1;
                    $result['msg'] = '添加成功';
                }
            }
        }
        echo json_encode($result);
    }
    
    private function getTrees($data, $pid = 0){
        static $result = array();
        foreach($data as $v){
            if($v['pid']==$pid){
                $result[] = $v;
                $this->getTrees($data,$v['id']);//递归调用
            }
        }
        return $result;
    } 
    /**
     * 删除菜单
     * @param  input|void;
     * @param  output|string(json); 
     */
    public function delprivilege(){
        $result = array('flag'=>0,'msg'=>'删除失败！');
        $id = input('id');
        if(!empty($id)){
            $privilegeModel = Db::name('auth_privilege');
            if($privilegeModel->where('pid='.$id)->field('id')->find()){
                $result['flag'] = 0;
                $result['msg'] = '有子菜单存在，不能删除！';
            }else if($privilegeModel->where('id='.$id)->delete()){
                $result['flag'] = 1;
                $result['msg'] = '删除成功！';
            }
        }
        echo json_encode($result);
    }
    /**
     * 编辑菜单
     * @param  input|void;
     * @param  output|string(json); 
     */
    public function editprivilege(){
        $data = input('post.');
        $result = array('flag'=>0,'msg'=>'操作失败!');
        $privilegeModel = Db::name('auth_privilege');
        if($data['action'] == 'get'){
            $id = $data['id'];
            $currentprivilege = $privilegeModel->where('id='.$id)->find();
            $privilegedatas = $privilegeModel->field('id,title,level,pid')
                ->where('level in (0,1) and status='.config('normal_status'))
                ->select();
            $privilegeTree = $this->getTrees($privilegedatas, 0);
            if(!empty($currentprivilege)){
                $result['flag'] = 1;
                $result['msg'] = 'ok';
                $result['privilegeTree'] = $privilegeTree;
                $result['currentprivilege'] = $currentprivilege;
            }
        }else if($data['action'] == 'post'){
            $editData = $data['editPrivilege'];
            $id = $editData['id'];
            //获取该权限原来的pid
            $oldprivilege = $privilegeModel
                    ->field('pid')
                    ->where('id='.$id)
                    ->find();
            if(!empty($oldprivilege)){
                $alldata = $privilegeModel->field('id,pid')->select();
                //获取该类别下的菜单下的所有子类
                $childPrivilegeIds = $this->getTrees($alldata,$id);
                if(in_array($editData['pid'], $childPrivilegeIds)){
                    $result['flag'] = 0;
                    $result['msg'] = '修改后其上级菜单不能为自己的子菜单';
                }else{
                    $preprivilege = $privilegeModel
                            ->field('level')
                            ->where('id='.$editData['pid'])
                            ->find();
                    if(!empty($preprivilege)){
                        $editData['level'] = $preprivilege['level']+1;
                    }else{
                        $editData['level'] = 0;
                    }
                    if($data['status']['status']){
                        $editData['status'] = $data['status']['status'];
                    }
                    $editData['update_time'] = time();
                    $pri_update = $privilegeModel
                            ->where('id',$id)
                            ->update($editData);
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
     * 获取某个菜单下所有的权限,只取出菜单的id数组集合
     * @staticvar array $result
     * @param type $pid
     * @return array
     */
    private function getChildPrivilege($data,$pid){
        static $result = array();
        foreach($data as $v){
            if($v['pid']==$pid){
                $result[] = $v;
                $this->getTrees($data,$v['id']);//递归调用
            }
        }
        return $result;
        
        
    }
    /**
     * 权限分配页面
     * @param  input|void;
     * @return  output|void;
     */
    public function privilegeset()
    {
        $id = input('id');
        if(!empty($id)){
            if(Request::instance()->isPost()){
                $post = Request::instance()->post();
                if(empty($post['rules'])){$post['rules'] = array();}
                $pri = $post['rules'];
                $priData = implode(',', $pri);
                if(empty($priData)){
                    $info['privilege'] = '';
                }else{
                    $info['privilege'] = $priData;
                }
                $info['id'] = $post['id'];
                $res = Db::name('authRole')->update($info);
                if(!(is_bool($res))){
                    $this->success('编辑成功!', 'position/index');
                }else{
                    $this->error('编辑失败!');
                }
            }else{
                //获取所有的权限
                $priWhere['status'] = config("normal_status");
                $privilegeData = Db::name('AuthPrivilege')
                                ->field('id,pid,name,title')
                                ->where($priWhere)
                                ->order('sort DESC,create_time ASC')
                                ->select();
                foreach($privilegeData as $val){
                    if($val['pid'] == '0'){
                        $firstPrivilege[] = $val;
                    }
                }
                $privilegeTree =$this->getTree($privilegeData,0);
                //获得该职位的权限
                $roleWhere['id'] = $id;
                $roleData = Db::name('auth_role')
                        ->where($roleWhere)
                        ->field('privilege,title')
                        ->find();
                $role = explode(',', $roleData['privilege']);
                $this->assign('first_privilege',$firstPrivilege);
                $this->assign('privilegeTree',$privilegeTree);
                $this->assign('role',$role);
                $this->assign('rolename',$roleData['title']);
                $this->assign('id',$id);
                return $this->fetch();
            }
        }else{
            $this->error('操作失败!');
        }
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
  


}