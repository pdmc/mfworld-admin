<?php
namespace admin\guessing\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use think\File;
use admin\extra\controller\Base;


/**
 * 竞猜控制器
 * 主要包括：？？？？？
 * @author   heqingyu
 * @date     2018/5/2 16:25:28
 * @version  1.0
 */
class Guessing extends Base
{   
    /**
    * 添加竞猜 
    * @param   input|void;
    * @return  void;
    */
    public function addGuess(){
        if(Request::instance()->isPost()){
            $info = input('post.');
            if($info){
                $info['close_time'] = strtotime($info['close_time']);
                $info['user_id'] = session('admin_id');
                $info['status'] = 0;
                $info['update_time'] = time();
                $info['create_time'] = time();
                if( Db::name('Guessing')->insert($info)){
                    $this->redirect('Guessing/lists');
                }else{
                    $this->error('添加失败,请重新操作！');
                }
            }
        }
        //分类处理start
        $cateData = Db::name('category')
                ->field('id,name,pid')
                ->select();
        $cateList = $this->cateTree($cateData,47);
        $this->assign('cateList',$cateList);
        //分类处理end
        return $this->fetch();
    }
    //分类tree
    private function cateTree($data,$pid = 0,$level = 0){
        static $result = array();
        foreach($data as $v){
            if($v['pid'] == $pid){
                $v['level'] = $level;
                $result[] = $v;
                $this->cateTree($data,$v['id'], $level+1);//递归调用
            }
        }
        return $result;
    }
    /**
    * 竞猜列表
    * @param   input|void;
    * @return  output|void;
    */
    public function lists(){
         //筛选条件
        $get = input('get.');
        $where = array();
        if(!empty($get['cate_id'])){
            $where['cate_id'] = $get['cate_id'];
        }
        if(!empty($get['title'])){
            $where['title'] = ['like','%'.trim($get['title']," ").'%'];
        }
        $data = Db::name('Guessing')
                ->where($where)
                ->order('create_time DESC,sort DESC')
                ->paginate(config('page_size'),false,['query' => $get]);
        $page = $data->render();
        $this->assign('page',$page);
        $this->assign('list',$data);
        
        //分类处理start
        $cateData = Db::name('category')
                ->field('id,name,pid')
                ->select();
        $cateList = $this->cateTree($cateData,47);
        $keyval[0] = ''; 
        foreach($cateList as $val){
            $keyval[$val['id']] = $val['name'];
        }
        $this->assign('keyval',$keyval);
        $this->assign('cateList',$cateList);
        //分类处理end
        return $this->fetch();
    }
    /**
    * 编辑竞猜 
    * @param   input|void;
    * @return  void;
    */
    public function editGuess(){
        $id = input('id');
        if(!empty($id)){
            $guessModel = Db::name('Guessing'); 
            if(Request::instance()->isPost()){
                $info = input('post.'); 
                $info['close_time'] = strtotime($info['close_time']);
                $info['user_id'] = session('admin_id');
                $info['update_time'] = time();
                if($guessModel->where('id',$id)->update($info)){
                    $this->redirect('Guessing/lists');
                }else{
                    $this->error('编辑失败,请重新操作！');
                }
            }else{
                $findData = $guessModel->where('id',$id)->find();
                $this->assign('data',$findData);
                //分类处理start
                $cateData = Db::name('category')
                        ->field('id,name,pid')
                        ->select();
                $cateList = $this->cateTree($cateData,47);
                $this->assign('cateList',$cateList);
                //分类处理end
                return $this->fetch();
            }
        }else{
            $this->redirect('Guessing/lists');
        }
    }
    /**
    * 发布竞猜  
    * @param   
    * @return  
    */
    public function pubGuess(){
        $result = ['flag'=>0,'msg'=>'发布失败!'];
        $id = input('id');
        if(!empty($id)){
            $updata['id'] = $id;
            $updata['status'] = 1;
            $updata['pub_time'] = time();
            $updata['update_time'] = time();
            $updata['user_id'] = session('admin_id');
            if(Db::name('Guessing')->update($updata)){
                $result = ['flag'=>1,'msg'=>'成功发布!'];
            }
        }
        echo json_encode($result);
    }
    /**
    * 编辑开奖信息 
    * @param   
    * @return  
    */
    public function editWin(){
        $result = ['flag'=>0,'msg'=>'操作失败！'];
        $info = input('post.');
        $id = $info['id'];
        if(!empty($id)){
            $guessModel = Db::name('Guessing');
            if($info['action'] == 'post'){
                Db::startTrans();
                
                $updata['id'] = $id;
                $updata['correct'] = $info['correct'];
                $updata['status'] = 3;
                $updata['remark'] = $info['remark'];
                $updata['prize_time'] = time();
                $updata['update_time'] = time();
                $updata['user_id'] = session('admin_id');
                if($guessModel->update($updata)){
                    Db::commit();
                    $resultData = $this->puballdata($id);
                    if($resultData['code'] == '200'){
                        $result['flag'] = 1;
                        $result['msg'] = '操作成功！';
                    }else{
                        $result['flag'] = 1;
                        $result['msg'] = $resultData['msg'];
                    }
                }else{
                    Db::rollback();
                }
            }else{
                $data = $guessModel
                        ->where('id',$id)
                        ->field('id,remark,option_one,option_two')
                        ->find();
                if($data){
                    $result['data'] = $data;
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功！';
                }
            }
        }
        echo json_encode($result);
    }
    /**
    * 查看开奖信息 
    * @param   
    * @return  
    */
    public function viewWin(){
        $result = ['flag'=>0,'msg'=>'操作失败！'];
        $id = input('id');
        if(!empty($id)){
            $data = Db::name('Guessing')
                    ->where('id',$id)
                    ->field('id,remark,option_one,option_two,correct')
                    ->find();
            if($data){
                $result['data'] = $data;
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }
        }
        echo json_encode($result);
    }
    /**
    * 开奖处理数据信息 
    */
    
    public function test(){//用于测试
        $this->puballdata(9);
    }
    private function puballdata($guessid){
    try{    
        $result = ['code'=>400,'msg'=>'操作失败！'];
        if($guessid){
            $findGuData = Db::name('Guessing')->where('id',$guessid)->find();
            if($findGuData['status'] == 3){
                Db::startTrans();
                //赢的彩钻
                if($findGuData['correct'] == $findGuData['option_one']){
                    $colorWin = $findGuData['option_one_total'];
                    $colorFail = $findGuData['option_two_total'];
                }else{
                    $colorWin = $findGuData['option_two_total'];
                    $colorFail = $findGuData['option_one_total'];
                }
                
                
                
                if(empty($findGuData['option_all_total'])){ //无输无赢(无人参与竞猜)
                    Db::rollback();
                    $result = ['code'=>200,'msg'=>'无人参与竞猜！'];
                    return $result;
                }else if($colorWin && $colorFail){ //有输有赢
                        //计算平台赢取彩钻值start
                        $updateGuess['seller_value'] = $colorFail * $findGuData['seller_proportion'];
                        $isGuess = Db::name('Guessing')
                                ->where('id',$guessid)
                                ->update($updateGuess);
                        if(is_bool($isGuess)){
                            Db::rollback();
                            $result = ['code'=>400,'msg'=>'联系开发,更新平台赢取彩钻值失败！'];
                            return $result;
                        }
                        //计算平台赢取彩钻值end
                        
                        //计算平台赢取彩钻值start
                        $junfenval = ($colorFail - $updateGuess['seller_value'])/$colorWin;
                        $findLogData = Db::name('GuessingLog')
                                ->where('guessing_id',$guessid)
                                ->field('id,color_value,user_id,correct')
                                ->select();
                        $updateLog = array();
                        $updateUser = array();
                        $allUser = array();
                        $upDataAllUser = array();
                        foreach($findLogData as $value){
                            $allUser[] = $value['user_id'];
                        }
                        $FUwhere['user_id'] = ['in',$allUser];
                        $ethAddr = Db::name('User')
                                  ->where($FUwhere)
                                  ->column('user_id,eth_addr');
                        
                        $logDataCount = count($findLogData);
                        for($i=0;$i<$logDataCount;$i++){
                            $updateLog['id'] = $findLogData[$i]['id'];
                            if($findLogData[$i]['correct'] == $findGuData['correct']){
                                $updateLog['result'] = 1;
                                $updateLog['color_win'] =  $junfenval*$findLogData[$i]['color_value'] + $findLogData[$i]['color_value']; //?????
                                if(isset($updateUser[$findLogData[$i]['user_id']])){
                                    $updateUser[$findLogData[$i]['user_id']] += $updateLog['color_win'];
                                }else{
                                    $updateUser[$findLogData[$i]['user_id']] = $updateLog['color_win'];
                                }
                                $upDataAllUser[] = $findLogData[$i]['user_id'];
                                //dump($updateLog['color_win']);
                                //dump($updateUser);
                                //dump($upDataAllUser);die;
                                //彩钻交易
                                $post_data['action']    =   'tranDiamond';
                                $post_data['touser']    =   $ethAddr[$findLogData[$i]['user_id']];
                                $post_data['fromuser']  =   config('ETH_user');
                                $post_data['value']     =   $updateLog['color_win'];
                                $curlres = $this->curlPost($post_data);
                                $curlres = json_decode($curlres,true);
                                if($curlres['code'] == 400){
                                    Db::rollback();
                                    $result = ['code'=>400,'msg'=>$curlres['data']];
                                    return $result;
                                }
                            }else{
                                $updateLog['result'] = 2;
                                $updateLog['color_win'] = 0;
                            }
                            //dump($updateLog);
                            //dump($updateLog['id']);die;
                            $allUser[] = $findLogData[$i]['user_id'];
                            $isGuessLog = Db::name('GuessingLog')->where('id',$updateLog['id'])->update($updateLog);
                            if(is_bool($isGuessLog)){
                                Db::rollback();
                                $result = ['code'=>400,'msg'=>'联系开发人，更新GuessingLog失败！'];
                                return $result;
                            }
                        }
                      
                        $findwhere['user_id'] = ['in',$upDataAllUser];
                        $findUser = Db::name('User')
                                  ->where($findwhere)
                                  ->field('user_id,color')
                                  ->select();
                        $userCount = count($findUser);
                        
                        $colorLogData = array();
                        for($i=0;$i<$userCount;$i++){
                            //$updaUser['user_id'] = $findUser[$i]['user_id'];
                            $updaUser['color'] = $updateUser[$findUser[$i]['user_id']] + $findUser[$i]['color'];
                            $isUser = Db::name('User')->where('user_id',$findUser[$i]['user_id'])->update($updaUser);
                            if(!$isUser){
                                Db::rollback();
                                $result = ['code'=>400,'msg'=>'联系开发人，更新用户彩钻值！'];
                                return $result;
                            }
                            
                            //处理彩钻日志数据
                            $colorLogData[$i]['user_id'] = $findUser[$i]['user_id'];
                            $colorLogData[$i]['value'] = $updateUser[$findUser[$i]['user_id']];
                            $colorLogData[$i]['type'] = 1;
                            $colorLogData[$i]['before'] = $findUser[$i]['color'];
                            $colorLogData[$i]['after'] = $updaUser['color'];
                            $colorLogData[$i]['create_time'] = time();
                            $colorLogData[$i]['is_true'] = 1;
                        }
                        
                        Db::name('ColorLog')->insertAll($colorLogData);
                        if($isGuess && $isGuessLog && $isUser){
                            Db::commit();
                            $result = ['code'=>200,'msg'=>'操作成功！'];
                            return $result;
                        }
                }else if($colorWin && ($colorFail == 0)){ //无输有赢
                        $findLogData = Db::name('GuessingLog')
                                ->where('guessing_id',$guessid)
                                ->field('id,color_value,user_id')
                                ->select();
                        $updateLog = array();
                        $updateUser = array();
                        $allUser = array();
                        foreach($findLogData as $value){
                            $allUser[] = $value['user_id'];
                        }
                        $FUwhere['user_id'] = ['in',$allUser];
                        $ethAddr = Db::name('User')
                                  ->where($FUwhere)
                                  ->column('user_id,eth_addr');
                        $logDataCount = count($findLogData);
                        for($i=0;$i<$logDataCount;$i++){
                            $updateLog['id'] = $findLogData[$i]['id'];
                            $updateLog['result'] = 1;
                            $updateLog['color_win'] = $findLogData[$i]['color_value'];
                            if(isset($updateUser[$findLogData[$i]['user_id']])){
                                $updateUser[$findLogData[$i]['user_id']] += $updateLog['color_win'];
                            }else{
                                $updateUser[$findLogData[$i]['user_id']] = $updateLog['color_win'];
                            }
                            
                            $isGuessLog = Db::name('GuessingLog')->where('id',$updateLog['id'])->update($updateLog);
                            if(!$isGuessLog){
                                Db::rollback();
                                $result = ['code'=>400,'msg'=>'联系开发人员D！'];
                                return $result;
                            }else{
                                 //彩钻交易
                                $post_data['action']    =   'tranDiamond';
                                $post_data['touser']    =   $ethAddr[$findLogData[$i]['user_id']];
                                $post_data['fromuser']  =   config('ETH_user');
                                $post_data['value']     =   $updateLog['color_win'];
                                $curlres = $this->curlPost($post_data);
                                $curlres = json_decode($curlres,true);
                                if($curlres['code'] == 400){
                                    Db::rollback();
                                    $result = ['code'=>400,'msg'=>'联系开发人员E！'];
                                    return $result;
                                }
                            }
                        }
                        
                        $findUser = Db::name('User')
                                  ->where($FUwhere)
                                  ->field('user_id,color')
                                  ->select();
                        $userCount = count($findUser);
                        $colorLogData = array();
                        for($i=0;$i<$userCount;$i++){
                            $updaUser['color'] = $findUser[$i]['color'] + $updateUser[$findUser[$i]['user_id']];
                            $isUser = Db::name('User')->where('user_id',$findUser[$i]['user_id'])->update($updaUser);
                            if(!$isUser){
                                Db::rollback();
                                $result = ['code'=>400,'msg'=>'联系开发人员F！'];
                                return $result;
                            }
                            //处理彩钻日志数据
                            $colorLogData[$i]['user_id'] = $findUser[$i]['user_id'];
                            $colorLogData[$i]['value'] = $updateUser[$findUser[$i]['user_id']];
                            $colorLogData[$i]['type'] = 1;
                            $colorLogData[$i]['before'] = $findUser[$i]['color'];
                            $colorLogData[$i]['after'] = $updaUser['color'];
                            $colorLogData[$i]['create_time'] = time();
                            $colorLogData[$i]['is_true'] = 1;
                        }
                        if(Db::name('ColorLog')->insertAll($colorLogData)){
                            Db::commit();
                            $result = ['code'=>200,'msg'=>'操作成功！'];
                            return $result;
                        }else{
                            Db::rollback();
                            $result = ['code'=>400,'msg'=>'联系开发人员G！'];
                            return $result;
                        }
                        
                }else if(($colorWin == 0) && $colorFail){ //有输无赢(给平台)
                    Db::name('GuessingLog')->where('id',$guessid)->update(['result'=>2]);
                    $failWin = Db::name('Guessing')
                            ->where('id',$guessid)
                            ->update(['seller_value'=>$colorFail]);
                    if($failWin){
                        Db::commit();
                        $result = ['code'=>200,'msg'=>'操作成功！'];
                        return $result;
                    }
                    Db::rollback();
                    $result = ['code'=>400,'msg'=>'请联系开发人员H！'];
                    return $result;
                }else{
                    Db::rollback();
                    $result = ['code'=>400,'msg'=>'请联系开发人员i！'];
                    return $result;
                }
            }
        }
        return $result;
        
    }catch(Exception $e){
        echo $e->getMessage();die;
    }
        
    }
    
   
        
    private function curlPost($post_data){
        $url = config('ETH_url');
        $o = "";
        foreach ($post_data as $k => $v ) 
        { 
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $data = substr($o,0,-1);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
