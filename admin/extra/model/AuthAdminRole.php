<?php
namespace admin\extra\model;
use think\Model;

class AuthAdminRole extends Model
{

 	/**
     * 查询Admin
     * @return object
     */
    public function Admin(){
        return $this->hasOne('Admin','id','admin_id')->field('id,user_name,nick_name,mobile,status');
    }

}