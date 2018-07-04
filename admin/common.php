<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
    /**
    * 判断显示菜单
    * @param   input|String   (模块/控制器/方法名)
    * @return  output|boolean
    */
    function showHandle($handleString) {
        $isspuer = input('session.is_super');
        if($isspuer) {
            return true;
        }
        if(empty($handleString)) {
            return false;
        }
        $privileges = json_decode(input('session.privilegeData'));    
        if (in_array($handleString, $privileges)) {
            return true;
        } else {
            return false;
        }
    }
    // 获取用户IP
    function get_client_ip() {
        $ip = NULL;
        if ($ip !== NULL)
                return $ip;
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos)
                        unset($arr[$pos]);
                $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
                $ip = $_SERVER['HTTP_X_REAL_IP'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
        return $ip;
    }
    
    
    
    
    
    
    
    /**
     * 上传图片
     * @param string    $imgName    form表单中文件域的name值
     * @param string    $dirName    图片保存的文件夹
     * @param array     $thumb      array(array('600', '600', 1),array('350', '350', 1),array('130', '130', 1),))宽、高、缩略图的处理方式
     * @return array
     */
    function upload($imgName,$dirName,$thumb=array(),$water=TRUE){
        $img = request()->file($imgName);
        $maxSize = (int)config('max_size');
        $ext = config('ext');
        $umf = (int)ini_get('upload_max_filesize');
        $readSize = min($umf,$maxSize)* 1024 * 1024;
        $path = ROOT_PATH.config('root_path').$dirName;
        foreach($img as $ki=>$file){
            //移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>$readSize,'ext'=>$ext])->move($path);
            $file_name = str_replace("\\", "/", $info->getSaveName());
            $save_path = substr($file_name,0,strpos($file_name,'/'));
            $fileError = $info->getError();
            if(!empty($fileError)){
                return $ret = array(
                    'ok' => 0,
                    'error' => $file->getError()
                );
            }else{
                $factFilename = config('root_path') .$dirName .'/'. $file_name;
                $saveFile = config('img_host').'/'.$dirName .'/'. $file_name;
                $ret['ok'] = 1;
                $ret['images'][] = $saveFile;
                //添加水印
                $imgobj = new \think\File('.'.$factFilename);
                if($water){
                    $image = \think\Image::open($imgobj);
                    $image->water(config('water_pic_path'),config('water_southeast'))->save($path.'/'.$file_name);
                }
                //是否生成缩略图
                if($thumb){
                    $image = \think\Image::open($imgobj);
                    foreach ($thumb as $k => $v) {
                        $_imgName = config('root_path') .$dirName .'/'.$save_path.'/'. 'thumb_' . $v[0] . 'X' . $v[1] . '_' . $info->getFilename(); 
                        // 把这个缩略图的名字放到要返回的图片中
                        $ret['thumb'][$ki][] = config('img_host').'/'.$dirName .'/'.$save_path.'/'. 'thumb_' . $v[0] . 'X' . $v[1] . '_' . $info->getFilename();
                        $image->thumb($v[0], $v[1], $v[2])->save(ROOT_PATH .$_imgName);
                    }
                }
            }    
        }
        return $ret;
    }
    
   