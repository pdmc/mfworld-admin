<?php
namespace admin\prop\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\File;
use think\Db;
use admin\extra\controller\Base;

/**
 * 道具控制器
 * 主要包括：？？？？？
 * @author   heqingyu
 * @date     2018/4/27 18:25:28
 * @version  1.0
 */
class Prop extends Base
{   
    /**
    * 道具列表
    * @param   input|void;
    * @return  output|void;
    */
    public function lists(){
        //筛选条件
        $get = input('get.');
        $where = array();
        if(!empty($get['prop_type'])){
            $where['prop_type'] = $get['prop_type'];
        }
        if(!empty($get['name'])){
            $where['name'] = ['like','%'.trim($get['name']).'%'];
        }
        $where['status'] = ['neq',-2];
        $data = Db::name('Prop')
                ->where($where)
                ->order('creade_time DESC,sort DESC')  
                ->paginate(config('page_size'),false,['query' => $get]);
        $page = $data->render();
        $this->assign('page',$page);
        $this->assign('list',$data);
        return $this->fetch();
    }
    /**
    * 添加道具 
    * @param   input|void;
    * @return  string;
    */
    public function addProp(){
        if(Request::instance()->isPost()){
            $info = input('post.');
            if($_FILES['image']['error'] == 0 && !empty($_FILES['image']['tmp_name'])){
                $result = $this->upload('image',config('prop_image'),true);
                if($result['ok'] == 1){
                    $insertdata['img'] = config('img_domain_path').$result['images'];
                }
            }
            //判断是否是套餐
            if($info['prop_type'] == 2){
                if(count($info['sid']) != count($info['snum'])){
                    $this->error('添加失败,请重新添加！');die;
                }
                $result = array();
                foreach($info['sid'] as $k=>$v){
                    $result[$v] = $info['snum'][$k];
                }
                $insertdata['prop_mul'] = json_encode($result);
            }else{
                $insertdata['use_type'] = $info['use_type'];
            }
            $insertdata['name'] = $info['name'];
            $insertdata['describe'] = $info['describe'];
            $insertdata['price'] = $info['price'];
            $insertdata['prop_type'] = $info['prop_type'];
            $insertdata['keep_time'] = $info['keep_time'];
            $insertdata['cool_time'] = $info['cool_time'];
            $insertdata['propnum'] = $info['propnum'];
            $insertdata['user_id'] = session('admin_id');
            $insertdata['status'] = config('normal_status');
            $insertdata['sort'] = $info['sort'];
            $insertdata['creade_time'] = time();
            if(Db::name('Prop')->insert($insertdata)){
                $this->redirect('Prop/lists');
            }else{
                $this->error('添加失败,请重新添加！');
            }
        }
        return $this->fetch();
    }
    /**
    * 查找道具 
    * @param   input|void;
    * @return  string;
    */
    public function selProp(){
        $result = ['flag'=>0,'msg'=>'操作失败'];
        $where['status'] = config('normal_status');
        $where['prop_type'] = 1;
        $data = Db::name('Prop')
                ->where($where)
                ->column('id,name');
        if($data){
            $result['flag'] = 1;
            $result['msg'] = '成功操作！';
            $result['data']= $data; 
        }
        echo json_encode($result);
    }
    /**
     * 图片上传
     * @param string    $imgName    form表单中文件域的name值
     * @param string    $dirName    图片保存的文件夹
     * @return array
     */
    private function upload($imgName,$dirName){
        $img = request()->file($imgName);
        $maxSize = (int) Config('max_size');
        $ext = Config('ext');
        $umf = (int) ini_get('upload_max_filesize');
        $readSize = min($umf, $maxSize)* 1024 * 1024;
        $path = ROOT_PATH . Config('root_path') . $dirName;

        //上传文件
        $info = $img->validate(['size'=>$readSize,'ext'=>$ext])->move($path);
        $file_name = str_replace("\\", "/", $info->getSaveName());
        $save_path = substr($file_name,0,strpos($file_name,'/'));

        $fileError = $info->getError();
        $saveFile = config('img_host').'/'.$dirName .'/'. $file_name;
        if(!empty($fileError)){
            return $ret = array( 'ok' => 0, 'error' => $img->getError() );
        }else{
            $ret = array( 'ok' => 1, 'images' => $saveFile);
        }
        return  $ret;
    }
    /**
    * 编辑道具
    * @param   
    * @return  
    */
    public function editProp(){
        $result = ['flag'=>0,'msg'=>'操作失败'];
        $info = input('post.');
        $id = $info['id'];
        if(!empty($id)){
            $propModel = Db::name('Prop');
            if($info['action'] == 'post'){
                if($_FILES['image']['tmp_name']){
                    if($_FILES['image']['error'] == 0 && !empty($_FILES['image']['tmp_name'])){
                        $resul = $this->upload('image',config('prop_image'),true);
                        if($resul['ok'] == 1){
                            $updata['img'] = config('img_domain_path').$resul['images'];
                        }
                    }
                    $findData = $propModel->where('id',$id)->field('img')->find();
                    $tmpimg ='.'.str_replace(config('img_domain_path'),'',$findData['img']);
                    if($findData['img'] && is_file($tmpimg)){
                        unlink($tmpimg);
                    }
                }
                //判断是否是套餐
                if($info['prop_type'] == 2){
                    if(count($info['sid']) != count($info['snum'])){
                       echo json_encode($result);die;
                    }
                    $result = array();
                    foreach($info['sid'] as $k=>$v){
                        if($info['snum'][$k]){
                            $result[$v] = $info['snum'][$k];
                        }
                    }
                    $updata['prop_mul'] = json_encode($result);
                }else{
                    $updata['use_type'] = $info['use_type'];
                    $updata['keep_time'] = $info['keep_time'];
                    $updata['cool_time'] = $info['cool_time'];
                }
                $updata['name'] = $info['name'];
                $updata['describe'] = $info['describe'];
                $updata['price'] = $info['price'];
                
                $updata['propnum'] = $info['propnum'];
                $updata['user_id'] = session('admin_id');
                $updata['sort'] = $info['sort'];
                $updata['update_time'] = time();
                if(Db::name('Prop')->where('id',$id)->update($updata)){
                    $result = ['flag'=>1,'msg'=>'成功操作！'];
                }else{
                    $result = ['flag'=>0,'msg'=>'操作失败'];
                }
                        
            }else{
                $data = $propModel->where('id',$id)->find();
                if(!empty($data)){
                    if($data['prop_type'] == 2){
                        $where['status'] = config('normal_status');
                        $where['prop_type'] = 1;
                        $allProp = Db::name('Prop')
                                ->where($where)
                                ->field('id,name')->select();
                        $jsonData = json_decode($data['prop_mul'],true);
                        $allPropCount = count($allProp);
                        for($i=0;$i<$allPropCount;$i++){
                            //$id = (string)$allProp[$i]['id'];
                            if(isset($jsonData[$allProp[$i]['id']])){
                                $allProp[$i]['num'] = $jsonData[$allProp[$i]['id']];
                            }else{
                                $allProp[$i]['num'] = 0;
                            }
                        }
                        $data['prop_mul'] = $allProp;
                    }
                    $result['data'] = $data;
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }
        }
        echo json_encode($result);
    }
    /**
    * 开启关闭道具 
    * @param   
    * @return  
    */
    public function onOffProp(){
        $result = ['flag'=>0,'msg'=>'操作失败!'];
        $id = input('id');
        if(!empty($id)){
            $propModel = Db::name('Prop');
            $findData = $propModel->where('id',$id)->field('status')->find();
            if($findData['status'] == config('normal_status')){
                $updata['status'] = config('delete_status');
            }else if($findData['status'] == config('delete_status')){
                $updata['status'] = config('normal_status');
            }
            $updata['id'] = $id;
            $updata['update_time'] = time();
            $updata['user_id'] = session('admin_id');
            if($propModel->update($updata)){
                $result = ['flag'=>1,'msg'=>'成功操作!'];
            }
        }
        echo json_encode($result);
    }
    /**
    * 删除道具
    * @param   
    * @return  
    */
    public function delProp(){
        $result = ['flag'=>0,'msg'=>'操作失败!'];
        $id = input('id');
        if(!empty($id)){
            $updata['id'] = $id;
            $updata['status'] = -2;
            $updata['update_time'] = time();
            $updata['user_id'] = session('admin_id');
            if(Db::name('Prop')->update($updata)){
                $result = ['flag'=>1,'msg'=>'成功操作!'];
            }
        }
        echo json_encode($result);
    }
    
}
