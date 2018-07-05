<?php
namespace admin\order\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use admin\extra\controller\Base;

/**
 * 订单控制器
 * 主要包括：？？？？？
 * @author   heqingyu
 * @date     2018/6/20 14:25:28
 * @version  1.0
 */
class Order extends Base
{   
    /**
    * 订单列表
    * @param   input|void;
    * @return  output|void;
    */
    public function lists(){
        $where = [];
        //筛选条件
        $get = input('get.');
        if(!empty($get['order_status'])){
            $where['order_status'] = $get['order_status'];
        }
        if(!empty($get['order_id'])){
            $where['order_id'] = ['like','%'.trim($get['order_id']," ").'%'];
        }
        $data = Db::name('Order')
                ->where($where)
                ->order('id DESC')
                ->paginate(config('page_size'),false);
        $allUserId = array();
        $orderData = array();
        foreach($data as $val){
            $allUserId[] = $val['user_id'];
            $orderData[] = $val;
        }
        $userWhere['user_id'] = array('in',$allUserId); 
        $allUserData = Db::name('User')
                ->where($userWhere)
                ->column('user_id,user_name');
        foreach($orderData as $k => $v){
            if(isset($allUserData[$v['user_id']])){
                $orderData[$k]['user_name'] = $allUserData[$v['user_id']];
            }
            
        }
        
        $page = $data->render();
        $this->assign('page',$page);
        $this->assign('list',$orderData);
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
            $findData = Db::name('Order')->where('id',$id)->field('prop')->find();
            if($findData){
                $goodData = json_decode($findData['prop'],true);
                foreach($goodData as $v){
                    $goodId[] = $v['id'];
                    $goodIds[$v['id']] = $v['num'];
                }
                $propWhere['id'] = ['in',$goodId];
                $propData = Db::name('Prop')
                          ->where($propWhere)
                          ->field('id,name')
                          ->select();
                foreach($propData as $k=>$val){
                    $propData[$k]['num'] = $goodIds[$val['id']];
                }
                //dump($propData);die;
                $result['code'] = 200;
                $result['data'] = $propData;
                $result['msg'] = '成功操作!';
            }
        }
        echo json_encode($result);
    }
    
    
    
}
