<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/4/21 16:34
 * @title 资源定义
 */

namespace authority;


class Resource
{
    /**
     * @Author pizepei
     * @Created 2019/4/21 16:38
     * @param $name
     * @return null
     * @title  获取属性
     */
    public function __get($name)
    {
        if(isset($this->$name)){return $this->$name;}
        return null;
    }

    /**
     * 注册主模块
     */
    const mainResource = [
            'admin'=>'管理员管理',
            'user'=>'用户管理',
        ];


    /**
     * 管理员管理
     * @var array
     */
    protected  static $admin=[
        'del'=>'删除管理员',
        'list'=>'获取管理员列表',
        'info'=>'获取管理员信息信息',
        'menu'=>'后台菜单'
    ];

    /**
     * 用户管理
     * @var array
     */
    protected static $user=[
        'del'=>'删除用户',
        'list'=>'获取用户列表',
        'info'=>'获取用户信息信息',
        'add'=>'添加用户',
    ];
}