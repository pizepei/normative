<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/4/23 22:33
 * @baseAuth UserAuth:aut
 * @title 菜单相关控制器
 * @authGroup 权限组列表（在显示权限时继续分组）资源
 * @basePath /admin/menu/
 */

namespace app\bases;


use pizepei\staging\Controller;
use pizepei\staging\Request;

class Menu extends Controller
{
    /**
     * @Author pizepei
     * @Created 2019/4/23 22:35
     *
     * @param \pizepei\staging\Request $Request
     * @return array [json]
     * @title  获取菜单列表
     * @explain 获取菜单列表（权限不同内容不同）
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup admin.del:删除管理员账号操作,user.del:删除账号操作,user.add:添加账号操作
     * @authExtend UserExtend.list:删除账号操作
     * @router get menu-list
     */
    public function index(Request $Request)
    {
        return $this->succeed([
            [
                'title'=>'工作台',
                'icon'=>"layui-icon-home",
                'list'=>[[
                    'title'=>'导航',
                    'jump'=>'/',
                ]]
            ]
        ]);

    }

    /**
     * @Author pizepei
     * @Created 2019/4/23 23:02
     * @param \pizepei\staging\Request $Request
     * @return array [json]
     *
     * @title  用户信息
     * @explain 简单用户信息
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup admin.del:删除管理员账号操作,user.del:删除账号操作,user.add:添加账号操作
     * @authExtend UserExtend.list:删除账号操作
     *
     * @router get session
     */
    public function session(Request $Request)
    {
        $data = [
            "username"=> "pizepei", "sex"=>"男", "role"=> 1
        ];
        return $this->succeed($data);
    }
    /**
     * @Author pizepei
     * @Created 2019/4/23 23:02
     * @param \pizepei\staging\Request $Request
     * @return array [json]
     *
     * @title  用户信息
     * @explain 简单用户信息
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup admin.del:删除管理员账号操作,user.del:删除账号操作,user.add:添加账号操作
     * @authExtend UserExtend.list:删除账号操作
     *
     * @router get message/new
     */
    public function messageNew(Request $Request)
    {
        $data = [
            "newmsg"=>  3
        ];
        return $this->succeed($data);
    }

}